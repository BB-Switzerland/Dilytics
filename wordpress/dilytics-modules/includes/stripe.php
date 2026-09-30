<?php
/**
 * Online payment of the company creations (Stripe payment links, see
 * app/content/offers.js): when a payment succeeds, Stripe calls this site,
 * which sends two e-mails, the confirmation to the client and the notice to
 * Dilytics.
 *
 * Stripe → POST /wp-json/dilytics/v1/stripe (webhook, signed with the secret
 * in wp-config.php, DL_STRIPE_WEBHOOK_SECRET). Only the Checkout sessions of
 * the site's payment links are handled: they carry metadata.page.
 *
 * The mails leave through the SMTP of Dilytics' Microsoft 365 (DL_SMTP_*
 * constants in wp-config.php): dilytics.ch only lets Microsoft send for it
 * (SPF -all), so a mail sent by this server in its name would land in spam.
 * Until the SMTP is set, nothing is sent and the payment is logged.
 *
 * The same webhook sends the purchase to GA4 from the server (dl_ga4_purchase,
 * secret DL_GA4_API_SECRET in wp-config.php), for visitors who accepted
 * statistics.
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'rest_api_init',
	function () {
		register_rest_route(
			'dilytics/v1',
			'/stripe',
			array(
				'methods'             => 'POST',
				'callback'            => 'dl_stripe_webhook',
				'permission_callback' => '__return_true',
			)
		);
	}
);

/** The Stripe-Signature header checked against the endpoint's secret, five minutes of tolerance. */
function dl_stripe_verify( $payload, $header ) {
	if ( ! defined( 'DL_STRIPE_WEBHOOK_SECRET' ) || ! $header ) {
		return false;
	}
	$t  = 0;
	$v1 = array();
	foreach ( explode( ',', (string) $header ) as $part ) {
		$kv = explode( '=', trim( $part ), 2 );
		if ( 2 !== count( $kv ) ) {
			continue;
		}
		if ( 't' === $kv[0] ) {
			$t = (int) $kv[1];
		} elseif ( 'v1' === $kv[0] ) {
			$v1[] = $kv[1];
		}
	}
	if ( ! $t || abs( time() - $t ) > 300 ) {
		return false;
	}
	$expected = hash_hmac( 'sha256', $t . '.' . $payload, DL_STRIPE_WEBHOOK_SECRET );
	foreach ( $v1 as $sig ) {
		if ( hash_equals( $expected, $sig ) ) {
			return true;
		}
	}
	return false;
}

function dl_stripe_webhook( WP_REST_Request $request ) {
	$payload = $request->get_body();
	if ( ! dl_stripe_verify( $payload, $request->get_header( 'stripe_signature' ) ) ) {
		return new WP_REST_Response( array( 'error' => 'signature' ), 400 );
	}
	$event   = json_decode( $payload, true );
	$type    = $event['type'] ?? '';
	$session = $event['data']['object'] ?? array();

	// A card or TWINT payment is paid when the session completes; a delayed
	// method only when Stripe confirms it later.
	$paid = ( 'checkout.session.completed' === $type && 'paid' === ( $session['payment_status'] ?? '' ) )
		|| 'checkout.session.async_payment_succeeded' === $type;
	if ( ! $paid || empty( $session['metadata']['page'] ) || empty( $session['id'] ) ) {
		return new WP_REST_Response( array( 'ignored' => $type ), 200 );
	}

	// Stripe retries a webhook until it gets a 200: one set of mails per session
	$key = 'dl_paid_' . md5( $session['id'] );
	if ( get_transient( $key ) ) {
		return new WP_REST_Response( array( 'duplicate' => true ), 200 );
	}
	set_transient( $key, 1, 30 * DAY_IN_SECONDS );

	$ga   = dl_ga4_purchase( $session );
	$sent = dl_pay_send( dl_pay_data( $session ) );
	return new WP_REST_Response( array( 'sent' => $sent, 'ga4' => $ga ), 200 );
}

/**
 * The purchase sent to GA4 from the server too (Measurement Protocol), so it
 * counts even when the buyer never sees /paiement-confirme/. Same
 * transaction_id as the browser's purchase (track.js): GA4 keeps one. Only
 * for a visitor who accepted statistics: track.js then passes GA's client and
 * session ids as the session's client_reference_id (ga_<cid>_<sid>).
 * Secret: DL_GA4_API_SECRET in wp-config.php (GA4 property « Dilytics.ch »,
 * G-436C2QWD5K > stream « Mon site web » > Measurement Protocol API secrets). Returns what happened, for the webhook's answer.
 */
function dl_ga4_purchase( array $s ) {
	if ( ! defined( 'DL_GA4_API_SECRET' ) || ! preg_match( '/^ga_(\d+)-(\d+)(?:_(\d+))?$/', (string) ( $s['client_reference_id'] ?? '' ), $m ) ) {
		return 'skipped';
	}
	$slug = trim( (string) $s['metadata']['page'], '/' );
	$it   = null;
	foreach ( (array) get_option( 'dl_items', array() ) as $i ) {
		if ( $i['id'] === $slug ) {
			$it = $i;
		}
	}
	// the price before VAT, as the browser sends it; else the amount paid without its 8.1 %
	$value = $it && ! empty( $it['price'] ) ? (float) $it['price'] : round( ( $s['amount_total'] ?? 0 ) / 100 / 1.081, 2 );
	$line  = array(
		'item_id'       => $slug,
		'item_name'     => $it ? $it['name'] : $slug,
		'item_category' => $it ? $it['category'] : '',
		'price'         => $value,
		'quantity'      => 1,
	);
	$params = array(
		'transaction_id'       => $s['id'],
		'currency'             => strtoupper( $s['currency'] ?? 'chf' ),
		'value'                => $value,
		'tax'                  => round( $value * 0.081, 2 ),
		'items'                => array( $line ),
		'page_type'            => 'payment',
		'service_id'           => $slug,
		'service_name'         => $line['item_name'],
		'service_category'     => $line['item_category'],
		'engagement_time_msec' => 1,
	);
	if ( ! empty( $m[3] ) ) {
		$params['session_id'] = $m[3];
	}
	$res = wp_remote_post(
		'https://www.google-analytics.com/mp/collect?measurement_id=G-436C2QWD5K&api_secret=' . rawurlencode( DL_GA4_API_SECRET ),
		array(
			'timeout' => 5,
			'headers' => array( 'Content-Type' => 'application/json' ),
			'body'    => wp_json_encode(
				array(
					'client_id' => $m[1] . '.' . $m[2],
					// the server knows nothing of the visitor's advertising consent: none given
					'consent'   => array(
						'ad_user_data'       => 'DENIED',
						'ad_personalization' => 'DENIED',
					),
					'events'    => array(
						array(
							'name'   => 'purchase',
							'params' => $params,
						),
					),
				)
			),
		)
	);
	return is_wp_error( $res ) ? 'error' : 'sent ' . wp_remote_retrieve_response_code( $res );
}

/** What the mails need, from a Checkout session. */
function dl_pay_data( array $s ) {
	$page = get_page_by_path( trim( (string) $s['metadata']['page'], '/' ), OBJECT, 'page' );
	$cd   = $s['customer_details'] ?? array();
	$addr = array_filter(
		array(
			trim( ( $cd['address']['line1'] ?? '' ) . ' ' . ( $cd['address']['line2'] ?? '' ) ),
			trim( ( $cd['address']['postal_code'] ?? '' ) . ' ' . ( $cd['address']['city'] ?? '' ) ),
			$cd['address']['country'] ?? '',
		)
	);
	// the optional field of the payment page: the name planned for the company
	$planned = '';
	foreach ( $s['custom_fields'] ?? array() as $f ) {
		if ( 'nomsociete' === ( $f['key'] ?? '' ) ) {
			$planned = (string) ( $f['text']['value'] ?? '' );
		}
	}
	return array(
		'planned' => $planned,
		'service' => $page ? get_post_field( 'post_title', $page->ID, 'raw' ) : (string) $s['metadata']['page'],
		'amount'  => dl_pay_amount( (int) ( $s['amount_total'] ?? 0 ), (string) ( $s['currency'] ?? 'chf' ) ),
		'name'    => (string) ( $cd['name'] ?? '' ),
		'email'   => (string) ( $cd['email'] ?? '' ),
		'phone'   => (string) ( $cd['phone'] ?? '' ),
		'address' => implode( ', ', $addr ),
		'date'    => dl_pay_date( (int) ( $s['created'] ?? time() ) ),
		'payment' => (string) ( $s['payment_intent'] ?? '' ),
	);
}

/** "24 septembre 2026, 14h05", in French whatever the site's locale, Geneva time. */
function dl_pay_date( $ts ) {
	$months = array( 'janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre' );
	$tz     = new DateTimeZone( 'Europe/Zurich' );
	$d      = ( new DateTimeImmutable( '@' . $ts ) )->setTimezone( $tz );
	return $d->format( 'j' ) . ' ' . $months[ (int) $d->format( 'n' ) - 1 ] . ' ' . $d->format( 'Y, G\hi' );
}

/** 281060 → 2'810.60 CHF, 324300 → 3'243.– CHF, the Swiss way. */
function dl_pay_amount( $cents, $currency ) {
	$v = $cents % 100 ? number_format( $cents / 100, 2, '.', "'" ) : number_format( $cents / 100, 0, '.', "'" ) . '.–';
	return $v . ' ' . strtoupper( $currency );
}

/** The HTML of one of the two mails (templates/mail-*.php). */
function dl_pay_mail_html( $kind, array $d ) {
	$c = dl_contact();
	ob_start();
	include DL_DIR . 'templates/mail-' . $kind . '.php';
	return (string) ob_get_clean();
}

function dl_mail_ready() {
	return defined( 'DL_SMTP_HOST' ) && defined( 'DL_SMTP_USER' ) && defined( 'DL_SMTP_PASS' );
}

/** Both mails; nothing leaves before the SMTP is set. */
function dl_pay_send( array $d ) {
	if ( ! dl_mail_ready() ) {
		error_log( 'Dilytics: paiement en ligne reçu, e-mails non envoyés (SMTP non configuré) : ' . wp_json_encode( $d ) );
		return false;
	}
	$c      = dl_contact();
	$html   = array( 'Content-Type: text/html; charset=UTF-8' );
	$notify = defined( 'DL_PAY_NOTIFY' ) ? DL_PAY_NOTIFY : ( $c['mail'] ?? '' );
	$ok     = true;
	if ( $d['email'] ) {
		$ok = wp_mail(
			$d['email'],
			'Paiement reçu : ' . $d['service'],
			dl_pay_mail_html( 'paid', $d ),
			array_merge( $html, array( 'Reply-To: Dilytics <' . ( $c['mail'] ?? '' ) . '>' ) )
		) && $ok;
	}
	if ( $notify ) {
		$ok = wp_mail(
			$notify,
			'Paiement en ligne : ' . $d['service'] . ', ' . $d['amount'],
			dl_pay_mail_html( 'notify', $d ),
			array_merge( $html, $d['email'] ? array( 'Reply-To: ' . $d['name'] . ' <' . $d['email'] . '>' ) : array() )
		) && $ok;
	}
	return $ok;
}

// Every mail of the site leaves through the Microsoft 365 SMTP once it is set.
// Until then the server's own mailer sends it, with the envelope sender set to
// the From address so the domain's SPF check applies to it (form notices go
// from noreply@businessbooster.agency, whose SPF lists Infomaniak).
add_action(
	'phpmailer_init',
	function ( $mailer ) {
		if ( ! dl_mail_ready() ) {
			if ( ! $mailer->Sender ) {
				$mailer->Sender = $mailer->From;
			}
			return;
		}
		$mailer->isSMTP();
		$mailer->Host       = DL_SMTP_HOST;
		$mailer->Port       = defined( 'DL_SMTP_PORT' ) ? (int) DL_SMTP_PORT : 587;
		$mailer->SMTPSecure = 'tls';
		$mailer->SMTPAuth   = true;
		$mailer->Username   = DL_SMTP_USER;
		$mailer->Password   = DL_SMTP_PASS;
		$mailer->setFrom( defined( 'DL_SMTP_FROM' ) ? DL_SMTP_FROM : DL_SMTP_USER, 'Dilytics', false );
	}
);
