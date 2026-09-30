<?php
/**
 * The client's confirmation, after an online payment (includes/stripe.php).
 * $d: service, amount, name, date. $c: the cabinet's contact details.
 * Tables and inline styles: what every mail client renders.
 */

defined( 'ABSPATH' ) || exit;

$ink   = '#001934';
$muted = 'rgba(0,25,52,.66)';
$font  = "'Archivo', Arial, Helvetica, sans-serif";
$hours = lcfirst( (string) ( $c['hours'] ?? '' ) );
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Paiement reçu</title>
</head>
<body style="margin:0;padding:0;background:#f6f5f2;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f6f5f2;">
	<tr>
		<td align="center" style="padding:40px 16px;">
			<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;">
				<tr>
					<td style="padding:0 0 24px 4px;">
						<img src="<?php echo esc_url( set_url_scheme( DL_URL . 'assets/img/mail-logo.png', 'https' ) ); ?>" width="112" height="41" alt="Dilytics" style="display:block;border:0;">
					</td>
				</tr>
				<tr>
					<td style="background:#ffffff;border-radius:14px;padding:40px 36px;font-family:<?php echo $font; ?>;color:<?php echo $ink; ?>;">
						<h1 style="margin:0 0 20px;font-size:26px;line-height:1.2;font-weight:700;letter-spacing:-.02em;">Paiement reçu</h1>
						<p style="margin:0 0 14px;font-size:16px;line-height:1.55;">Bonjour<?php echo $d['name'] ? ' ' . esc_html( $d['name'] ) : ''; ?>,</p>
						<p style="margin:0 0 28px;font-size:16px;line-height:1.55;">Nous avons bien reçu votre paiement. Le reçu de Stripe vous parvient dans un e-mail séparé.</p>

						<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f6f5f2;border-radius:10px;">
							<tr>
								<td style="padding:18px 20px 6px;font-size:13px;color:<?php echo $muted; ?>;">Prestation</td>
								<td align="right" style="padding:18px 20px 6px;font-size:15px;font-weight:600;"><?php echo esc_html( $d['service'] ); ?></td>
							</tr>
							<tr>
								<td style="padding:6px 20px;font-size:13px;color:<?php echo $muted; ?>;">Montant</td>
								<td align="right" style="padding:6px 20px;font-size:15px;font-weight:600;"><?php echo esc_html( $d['amount'] ); ?><br><span style="font-size:12px;font-weight:400;color:<?php echo $muted; ?>;">TVA 8,1 % comprise</span></td>
							</tr>
							<tr>
								<td style="padding:6px 20px 18px;font-size:13px;color:<?php echo $muted; ?>;">Date</td>
								<td align="right" style="padding:6px 20px 18px;font-size:15px;"><?php echo esc_html( $d['date'] ); ?></td>
							</tr>
						</table>

						<p style="margin:32px 0 18px;font-size:16px;line-height:1.55;">Pour la suite, réservez un entretien avec l'un de nos conseillers.</p>
						<table role="presentation" cellpadding="0" cellspacing="0">
							<tr>
								<td style="border-radius:999px;background:#d61d41;">
									<a href="<?php echo esc_url( $c['booking'] ?? '' ); ?>" style="display:inline-block;padding:14px 26px;font-family:<?php echo $font; ?>;font-size:15px;font-weight:600;color:#ffffff;text-decoration:none;border-radius:999px;">Réserver mon entretien</a>
								</td>
							</tr>
						</table>

						<p style="margin:32px 0 0;padding-top:24px;border-top:1px solid rgba(0,25,52,.12);font-size:14px;line-height:1.6;color:<?php echo $muted; ?>;">
							Une question ? Répondez à cet e-mail, ou appelez-nous au
							<a href="<?php echo esc_attr( $c['phoneHref'] ?? '' ); ?>" style="color:<?php echo $ink; ?>;font-weight:600;text-decoration:none;white-space:nowrap;"><?php echo esc_html( $c['phone'] ?? '' ); ?></a>,
							du <?php echo esc_html( $hours ); ?>.
						</p>
					</td>
				</tr>
				<tr>
					<td style="padding:22px 4px 0;font-family:<?php echo $font; ?>;font-size:12px;line-height:1.6;color:<?php echo $muted; ?>;">
						Dilytics Sàrl · <?php echo esc_html( $c['street'] ?? '' ); ?> · <?php echo esc_html( $c['city'] ?? '' ); ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
