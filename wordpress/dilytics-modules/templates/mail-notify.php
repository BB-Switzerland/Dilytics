<?php
/**
 * The notice to Dilytics, after an online payment (includes/stripe.php).
 * $d: service, amount, name, email, phone, address, date, payment.
 */

defined( 'ABSPATH' ) || exit;

$ink   = '#001934';
$muted = 'rgba(0,25,52,.66)';
$font  = "'Archivo', Arial, Helvetica, sans-serif";
$rows  = array(
	'Prestation'            => esc_html( $d['service'] ),
	'Nom envisagé'          => esc_html( $d['planned'] ?? '' ),
	'Montant'               => esc_html( $d['amount'] ) . ', TVA 8,1 % comprise',
	'Client'                => esc_html( $d['name'] ),
	'E-mail'                => $d['email'] ? '<a href="mailto:' . esc_attr( $d['email'] ) . '" style="color:' . $ink . ';">' . esc_html( $d['email'] ) . '</a>' : '',
	'Téléphone'             => $d['phone'] ? '<a href="tel:' . esc_attr( preg_replace( '/[^\d+]/', '', $d['phone'] ) ) . '" style="color:' . $ink . ';">' . esc_html( $d['phone'] ) . '</a>' : '',
	'Adresse de facturation' => esc_html( $d['address'] ),
	'Date'                  => esc_html( $d['date'] ),
);
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Paiement en ligne</title>
</head>
<body style="margin:0;padding:0;background:#f6f5f2;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f6f5f2;">
	<tr>
		<td align="center" style="padding:40px 16px;">
			<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px;">
				<tr>
					<td style="background:#ffffff;border-radius:14px;padding:36px;font-family:<?php echo $font; ?>;color:<?php echo $ink; ?>;">
						<h1 style="margin:0 0 8px;font-size:22px;line-height:1.25;font-weight:700;">Paiement en ligne reçu</h1>
						<p style="margin:0 0 24px;font-size:15px;line-height:1.55;color:<?php echo $muted; ?>;">Un client a payé sur le site. Il a reçu la confirmation et le reçu de Stripe ; répondre à cet e-mail lui écrit directement.</p>
						<table role="presentation" width="100%" cellpadding="0" cellspacing="0">
							<?php foreach ( $rows as $k => $v ) : ?>
								<?php if ( '' !== $v ) : ?>
									<tr>
										<td valign="top" style="padding:10px 12px 10px 0;border-top:1px solid rgba(0,25,52,.1);font-size:13px;color:<?php echo $muted; ?>;white-space:nowrap;"><?php echo esc_html( $k ); ?></td>
										<td valign="top" style="padding:10px 0;border-top:1px solid rgba(0,25,52,.1);font-size:15px;"><?php echo $v; ?></td>
									</tr>
								<?php endif; ?>
							<?php endforeach; ?>
						</table>
						<?php if ( $d['payment'] ) : ?>
							<table role="presentation" cellpadding="0" cellspacing="0" style="margin-top:28px;">
								<tr>
									<td style="border-radius:999px;background:<?php echo $ink; ?>;">
										<a href="<?php echo esc_url( 'https://dashboard.stripe.com/payments/' . rawurlencode( $d['payment'] ) ); ?>" style="display:inline-block;padding:13px 24px;font-family:<?php echo $font; ?>;font-size:14px;font-weight:600;color:#ffffff;text-decoration:none;border-radius:999px;">Voir le paiement dans Stripe</a>
									</td>
								</tr>
							</table>
						<?php endif; ?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
