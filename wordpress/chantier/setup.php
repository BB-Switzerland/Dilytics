<?php
/**
 * Site-level setup, idempotent: run it as often as needed.
 *
 *   wp eval-file ~/chantier/dilytics/build.php setup --user=1
 *
 * Beaver Builder's global spacing, the contact details and photo registry the
 * modules read, the pictures, the pages, the main menu, and the Themer header
 * and footer.
 */

defined( 'ABSPATH' ) || exit;

$c = dlb_content();

/* ---------------------------------------------------- Beaver Builder globals
   No automatic spacing anywhere: every section carries the Nuxt spacing in
   its own CSS. Saved through the API: wp beaver global-update crashes on a
   site that has never saved its global settings. */
$globals = (array) FLBuilderModel::get_global_settings();
FLBuilderModel::save_global_settings(
	array_merge(
		$globals,
		array(
			'row_padding_top'       => 0,
			'row_padding_right'     => 0,
			'row_padding_bottom'    => 0,
			'row_padding_left'      => 0,
			'row_margins_top'       => 0,
			'row_margins_right'     => 0,
			'row_margins_bottom'    => 0,
			'row_margins_left'      => 0,
			'module_margins_top'    => 0,
			'module_margins_right'  => 0,
			'module_margins_bottom' => 0,
			'module_margins_left'   => 0,
			'auto_spacing'          => 0,
			'show_default_heading'  => 0,
		)
	)
);
dlb_log( 'Beaver Builder: global spacing at 0' );

// bb-theme's own layout in full width, not boxed (some of its presets box it)
set_theme_mod( 'fl-layout-width', 'full-width' );

/* ------------------------------------------------------------ plugin options */
update_option( 'dl_contact', $c['site']['CONTACT'] );
update_option( 'dl_photos', $c['photos'] );
dlb_log( 'Options: contact details and photo registry' );

// The services paid online (PRICE[…].pay in app/content/offers.js), for the
// begin_checkout and purchase events of track.js: price before VAT.
$pay = array();
foreach ( $c['price'] as $slug => $p ) {
	if ( ! empty( $p['pay'] ) ) {
		$pay[] = array(
			'id'    => trim( $slug, '/' ),
			'name'  => $c['h1'][ $slug ] ?? trim( $slug, '/' ),
			'price' => (float) preg_replace( '/[^\d.]/', '', (string) $p['amount'] ),
			'url'   => $p['pay'],
		);
	}
}
update_option( 'dl_pay', $pay );
dlb_log( 'Online payment: ' . count( $pay ) . ' services' );

/* ------------------------------------------ consent (Complianz Premium)
   Complianz loads Google Tag Manager itself, with Google Consent Mode v2:
   everything denied by default, granted category by category when the
   visitor accepts. So GTM4WP never prints the container (placement off
   below) and only fills the dataLayer. The container ID goes here; empty,
   no container is loaded at all. */
$gtm = ''; // GTM-XXXXXXX, from Hanae
if ( function_exists( 'cmplz_update_option' ) ) {
	$cmplz = array(
		// one opt-in banner for every visitor, the GDPR one (Swiss law and
		// Google's rules for Swiss traffic ask for consent before tracking)
		'use_country'                  => false,
		'regions'                      => 'eu', // one region: a single value, not a list
		'organisation_name'            => 'Dilytics Sàrl',
		'address_company'              => $c['site']['CONTACT']['street'] . "\n" . $c['site']['CONTACT']['city'],
		'country_company'              => 'CH',
		'email_company'                => $c['site']['CONTACT']['mail'],
		'telephone_company'            => $c['site']['CONTACT']['phone'],
		'cookie-statement'             => 'generated',
		'privacy-statement'            => 'url',
		'impressum'                    => 'none',
		'disclaimer'                   => 'none',
		// Google Tag Manager for statistics, Google Ads for marketing
		'compile_statistics'           => 'google-tag-manager',
		'configuration_by_complianz'   => $gtm ? 'yes' : 'no',
		'gtm_code'                     => $gtm,
		'consent-mode'                 => 'yes',
		'gtag-basic-consent-mode'      => 'no',
		'cmplz-tm-template'            => 'no',
		'cmplz-gtag-urlpassthrough'    => 'no',
		'cmplz-gtag-ads_data_redaction' => 'yes',
		'uses_ad_cookies'              => 'yes',
		// no IAB TCF: Dilytics advertises, it shows no ads; Consent Mode is enough
		'uses_ad_cookies_personalized' => 'no',
		'uses_ad_cookies_consent_mode' => 'yes',
		// links to maps and social networks, but nothing of theirs embedded
		'uses_thirdparty_services'     => 'no',
		'thirdparty_services_on_site'  => array(),
		'uses_social_media'            => 'no',
		'socialmedia_on_site'          => array(),
		'uses_firstparty_marketing_cookies' => 'no',
		'uses_wordpress_comments'      => 'no',
		'enable_cookie_banner'         => 'yes',
		'enable_cookie_blocker'        => 'yes',
	);
	foreach ( $cmplz as $k => $v ) {
		cmplz_update_option( $k, $v );
	}
	update_option( 'cmplz_privacy-statement_custom_page_url', home_url( $c['site']['LEGAL'][1]['href'] ) );

	// the cookie policy Complianz writes, on a page of its own (templates/document.php)
	$policy = get_page_by_path( 'politique-de-cookies', OBJECT, 'page' );
	if ( ! $policy ) {
		wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => 'Politique de cookies',
				'post_name'    => 'politique-de-cookies',
				'post_content' => '[cmplz-document type="cookie-statement" region="eu"]',
				'post_author'  => 1,
			)
		);
	}

	// the banner in the site's colours: paper and ink, red to accept, pill buttons
	$banner = new cmplz_cookiebanner( cmplz_get_default_banner_id() );
	$banner->position                     = 'bottom-left';
	$banner->banner_width                 = 460;
	$banner->font_size                    = 14;
	$banner->use_logo                     = 'hide';
	$banner->animation                    = 'none';
	$banner->use_box_shadow               = 1;
	$banner->colorpalette_background      = array( 'color' => '#ffffff', 'border' => '#e2e0d9' );
	$banner->colorpalette_text            = array( 'color' => '#001934', 'hyperlink' => '#d61d41' );
	$banner->colorpalette_toggles         = array( 'background' => '#d61d41', 'bullet' => '#ffffff', 'inactive' => '#c4c2bb' );
	$banner->colorpalette_border_radius   = array( 'top' => 18, 'right' => 18, 'bottom' => 18, 'left' => 18, 'type' => 'px' );
	$banner->border_width                 = array( 'top' => 1, 'right' => 1, 'bottom' => 1, 'left' => 1 );
	$banner->colorpalette_button_accept   = array( 'background' => '#d61d41', 'border' => '#d61d41', 'text' => '#ffffff' );
	$banner->colorpalette_button_deny     = array( 'background' => '#ffffff', 'border' => '#d8d6cf', 'text' => '#001934' );
	$banner->colorpalette_button_settings = array( 'background' => '#ffffff', 'border' => '#d8d6cf', 'text' => '#001934' );
	$banner->buttons_border_radius        = array( 'top' => 999, 'right' => 999, 'bottom' => 999, 'left' => 999, 'type' => 'px' );
	$banner->save();
	dlb_log( 'Consent: Complianz set' . ( $gtm ? ", GTM {$gtm} with Consent Mode v2" : ', GTM container ID still to add' ) );
}

/* ------------------------------------------- Google Tag Manager (GTM4WP)
   GTM4WP loads the container and fills the dataLayer with the page's data;
   the conversion events come from the plugin's track.js alone. So its own
   Contact Form 7 events stay off (they would never see the site's forms,
   which post to CF7 without its script, and would put names and e-mails
   in the dataLayer), as do its scroll, media and user events: GA4 already
   measures scrolling, and a second source would count twice. */
update_option(
	'gtm4wp-options',
	array_merge(
		(array) get_option( 'gtm4wp-options', array() ),
		array(
			// Complianz prints the container, behind consent: GTM4WP never does
			'gtm-code-placement'        => 3,
			// the site's own staff browse without being measured
			'gtm-no-gtm-for-logged-in'  => 'administrator,editor,author',
			'gtm-no-console-log'        => true,
			// page data: its type and language, nothing personal
			'include-posttype'          => true,
			'include-page-language'     => true,
			'include-categories'        => false,
			'include-tags'              => false,
			'include-author'            => false,
			'include-authorid'          => false,
			'include-loggedin'          => false,
			'include-userrole'          => false,
			'include-userid'            => false,
			'include-useremail'         => false,
			'include-username'          => false,
			'include-visitor-ip'        => false,
			'include-browserdata'       => false,
			'include-osdata'            => false,
			'include-devicedata'        => false,
			'integrate-wpcf7'           => false,
			'integrate-wpcf7-inputs'    => 'none',
			'integrate-wpcf7-ga4events' => false,
			'scroller-enabled'          => false,
			'event-form-move'           => false,
			'event-youtube'             => false,
			'event-vimeo'               => false,
			'event-html5-media'         => false,
		)
	)
);
dlb_log( 'Google Tag Manager: GTM4WP set (container ID still to add)' );

/* ------------------------------------------------------- forms (Contact Form 7)
   The back end of the site's two forms (includes/contact.php): the fields
   the markup posts, the mail to the cabinet and the messages. The markup
   stays the modules' own. */
if ( class_exists( 'WPCF7_ContactForm' ) ) {
	// ponytail: staging sender, allowed by businessbooster.agency's SPF; at launch
	// a dilytics.ch address sent through Microsoft 365 (FluentSMTP)
	$sender   = 'Site Dilytics <noreply@businessbooster.agency>';
	$messages = array(
		'mail_sent_ok'      => 'Merci, votre message a bien été envoyé.',
		'mail_sent_ng'      => "L'envoi n'a pas abouti. Réessayez dans un instant, ou écrivez-nous directement.",
		'validation_error'  => 'Un champ est incomplet. Vérifiez le formulaire.',
		'spam'              => "L'envoi n'a pas abouti. Réessayez dans un instant, ou écrivez-nous directement.",
		'invalid_required'  => 'Ce champ est obligatoire.',
		'invalid_too_short' => 'Ce texte est trop court.',
		'invalid_email'     => "L'adresse e-mail n'est pas valide.",
		'invalid_tel'       => "Le numéro de téléphone n'est pas valide.",
	);
	$fields   = function ( $subject ) {
		return "[text* your-name]\n[email* your-email]\n[tel your-phone]\n" . ( $subject ? "[text your-subject]\n" : '' )
			. "[textarea* your-message minlength:9]\n[text hp-website]\n[hidden hp-t]";
	};
	$body     = function ( $subject ) {
		return "[your-message]\n\n--\n[your-name]\n[your-email]\n[your-phone]\n\n"
			. ( $subject ? "Sujet : [your-subject]\n" : '' )
			. "Page : [_post_title], [_post_url]\nEnvoyé le [_date] à [_time]";
	};
	$defs     = array(
		'contact'  => array( 'Dilytics · Contact', '[your-subject] · [your-name]', true ),
		'question' => array( 'Dilytics · Question', 'Question · [your-name]', false ),
	);
	$form_ids = array();
	foreach ( $defs as $key => $d ) {
		$found = get_posts(
			array(
				'post_type'      => 'wpcf7_contact_form',
				'title'          => $d[0],
				'post_status'    => 'any',
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);
		$cf    = $found ? wpcf7_contact_form( $found[0] ) : WPCF7_ContactForm::get_template( array( 'title' => $d[0] ) );
		$cf->set_title( $d[0] );
		$cf->set_locale( 'fr_FR' );
		$cf->set_properties(
			array(
				'form'                => $fields( $d[2] ),
				'mail'                => array(
					'active'             => true,
					'subject'            => $d[1],
					'sender'             => $sender,
					'recipient'          => $c['site']['CONTACT']['mail'],
					'body'               => $body( $d[2] ),
					'additional_headers' => 'Reply-To: [your-name] <[your-email]>',
					'attachments'        => '',
					'use_html'           => false,
					'exclude_blank'      => true,
				),
				'mail_2'              => array( 'active' => false ),
				'messages'            => $messages,
				'additional_settings' => '',
			)
		);
		$form_ids[ $key ] = (int) $cf->save();
	}
	update_option( 'dl_forms', $form_ids );
	dlb_log( 'Forms: ' . wp_json_encode( $form_ids ) );
}

/* ------------------------------------------------------------------ pictures
   Every picture of the Nuxt site, under the slug dl-<name>: the modules and
   the scripts find them by name, never by a hard-coded id. */
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$imported = 0;
foreach ( glob( __DIR__ . '/img/*.webp' ) as $file ) {
	$name = basename( $file, '.webp' );
	if ( dl_img_id( $name ) ) {
		continue;
	}
	$tmp = wp_tempnam( $name );
	copy( $file, $tmp );
	$id = media_handle_sideload(
		array(
			'name'     => 'dl-' . $name . '.webp',
			'tmp_name' => $tmp,
		),
		0,
		'dl-' . $name
	);
	if ( is_wp_error( $id ) ) {
		WP_CLI::error( "{$name}: " . $id->get_error_message() );
	}
	wp_update_post(
		array(
			'ID'        => $id,
			'post_name' => 'dl-' . $name,
		)
	);
	++$imported;
}
dlb_log( "Pictures: {$imported} imported, " . count( glob( __DIR__ . '/img/*.webp' ) ) . ' in the library' );

/* --------------------------------------------------------------------- pages */
$pages = array(
	'accueil'             => 'Accueil',
	'entreprises'         => 'Entreprises',
	'creation-dentreprise' => "Création d'entreprise",
	'particuliers'        => 'Particuliers',
	'a-propos'            => 'À propos',
	'contact'             => 'Contact',
	'articles'            => 'Articles',
	'offres-demploi'      => "Offres d'emploi",
	'photos-a-fournir'    => 'Photos à fournir',
);
foreach ( $c['services'] as $s ) {
	$pages[ trim( $s['slug'], '/' ) ] = $c['h1'][ $s['slug'] ] ?? $s['title'];
}
$ids = array();
foreach ( $pages as $slug => $title ) {
	$ids[ $slug ] = dlb_page( $slug, $title );
}
update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $ids['accueil'] );
dlb_log( 'Pages: ' . count( $ids ) . ', front page is /accueil/' );

// WordPress's sample content has no place on the site: to the bin, not deleted.
foreach ( array( 'hello-world' => 'post', 'sample-page' => 'page', 'privacy-policy' => 'page' ) as $slug => $type ) {
	$p = get_page_by_path( $slug, OBJECT, $type );
	if ( $p && 'trash' !== $p->post_status ) {
		wp_trash_post( $p->ID );
	}
}

// The picture of each menu family is the featured image of the page it links to.
foreach ( array(
	'entreprises'          => 'entr',
	'creation-dentreprise' => 'crea',
	'particuliers'         => 'part',
	'offres-demploi'       => 'duo',
	'a-propos'             => 'apropos',
) as $slug => $img ) {
	set_post_thumbnail( $ids[ $slug ], dlb_media( $img )['id'] );
}

/* ---------------------------------------------------------------- main menu
   MENU of app/content/nav.js. Page links point at the page itself, so a slug
   change never breaks the menu. */
$menu = wp_get_nav_menu_object( 'Menu principal Dilytics' );
$menu_id = $menu ? (int) $menu->term_id : (int) wp_create_nav_menu( 'Menu principal Dilytics' );
foreach ( (array) wp_get_nav_menu_items( $menu_id ) as $old ) {
	wp_delete_post( $old->ID, true );
}
$item = function ( $to, $title, $parent = 0, $desc = '' ) use ( $menu_id, $ids ) {
	$slug = trim( $to, '/' );
	$args = array(
		'menu-item-title'       => $title,
		'menu-item-status'      => 'publish',
		'menu-item-parent-id'   => $parent,
		'menu-item-description' => $desc,
	);
	if ( isset( $ids[ $slug ] ) ) {
		$args['menu-item-type']      = 'post_type';
		$args['menu-item-object']    = 'page';
		$args['menu-item-object-id'] = $ids[ $slug ];
	} else {
		$args['menu-item-type'] = 'custom';
		$args['menu-item-url']  = home_url( $to );
	}
	return (int) wp_update_nav_menu_item( $menu_id, 0, $args );
};
foreach ( $c['menu'] as $fam ) {
	$top = $item( $fam['to'], $fam['label'], 0, $fam['blurb'] );
	foreach ( $fam['items'] as $it ) {
		$item( $it['to'], $it['label'], $top );
	}
}
$locations            = (array) get_theme_mod( 'nav_menu_locations', array() );
$locations['dl-main'] = $menu_id;
set_theme_mod( 'nav_menu_locations', $locations );
dlb_log( 'Menu: ' . count( $c['menu'] ) . ' families' );

/* -------------------------------------------------- Themer header and footer
   The pages never carry a header or a footer module: both are Themer layouts
   shown on the whole site. */
$layout = function ( $slug, $title, $type, array $settings ) {
	$p  = get_page_by_path( $slug, OBJECT, 'fl-theme-layout' );
	$id = $p ? (int) $p->ID : (int) wp_insert_post(
		array(
			'post_type'   => 'fl-theme-layout',
			'post_status' => 'publish',
			'post_title'  => $title,
			'post_name'   => $slug,
			'post_author' => 1,
		)
	);
	update_post_meta( $id, '_fl_theme_layout_type', $type );
	update_post_meta( $id, '_fl_theme_builder_locations', array( 'general:site' ) );
	update_post_meta( $id, '_fl_theme_builder_exclusions', array() );
	update_post_meta( $id, '_fl_theme_layout_settings', $settings );
	return $id;
};

$header = $layout(
	'dl-header',
	'En-tête Dilytics',
	'header',
	array(
		'sticky'     => '0',
		'shrink'     => '0',
		'overlay'    => '0',
		'overlay_bg' => 'default',
	)
);
dlb_start( $header );
dlb_add( 'dl-header', array() );
dlb_finish( $header );

$footer = $layout( 'dl-footer', 'Pied de page Dilytics', 'footer', array() );
dlb_start( $footer );
$legal = array();
foreach ( $c['site']['LEGAL'] as $l ) {
	$legal[] = array(
		't'  => $l['label'],
		'to' => $l['href'],
	);
}
dlb_add(
	'dl-footer',
	array_merge(
		array(
			'intro'     => "Fiduciaire genevoise depuis {since}. Comptabilité, fiscalité, salaires et création d'entreprise, pour les PME et les particuliers.",
			'badge_alt' => 'Badge bexio Partenaire Platine',
			'legal'     => $legal,
			'copy'      => '© 2026 Dilytics · Genève',
		),
		dlb_photo( 'badge', 'bexio_platine' )
	)
);
dlb_finish( $footer );
