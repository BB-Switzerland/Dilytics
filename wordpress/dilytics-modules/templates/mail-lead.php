<?php
/**
 * The notice to Dilytics for a message sent by one of the site's forms, as
 * Contact Form 7's mail body (chantier/setup.php). The [tags] are CF7's,
 * escaped by CF7; a row whose tag is empty goes (exclude_blank), so each row
 * stays on one line. $subject: the form has a subject field (Contact).
 */

defined( 'ABSPATH' ) || exit;

$ink   = '#001934';
$muted = 'rgba(0,25,52,.66)';
$line  = 'border-top:1px solid rgba(0,25,52,.1)';
$font  = "'Archivo', Arial, Helvetica, sans-serif";
$th    = 'valign="top" style="padding:10px 12px 10px 0;' . $line . ';font-size:13px;color:' . $muted . ';white-space:nowrap;"';
$td    = 'valign="top" style="padding:10px 0;' . $line . ';font-size:15px;"';
?>
<!doctype html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $subject ? 'Message du site' : 'Question du site'; ?></title>
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
					<td style="background:#ffffff;border-radius:14px;padding:36px;font-family:<?php echo $font; ?>;color:<?php echo $ink; ?>;">
						<h1 style="margin:0 0 8px;font-size:22px;line-height:1.25;font-weight:700;"><?php echo $subject ? 'Nouveau message' : 'Nouvelle question'; ?> de [your-name]</h1>
						<p style="margin:0 0 24px;font-size:15px;line-height:1.55;color:<?php echo $muted; ?>;">Envoyé depuis le site. Répondre à cet e-mail écrit directement à [your-name].</p>
						<div style="margin:0 0 24px;padding:18px 20px;background:#f6f5f2;border-radius:10px;font-size:15px;line-height:1.6;white-space:pre-line;">[your-message]</div>
						<table role="presentation" width="100%" cellpadding="0" cellspacing="0">
<?php if ( $subject ) : ?>
<tr><td <?php echo $th; ?>>Sujet</td><td <?php echo $td; ?>>[your-subject]</td></tr>
<?php endif; ?>
<tr><td <?php echo $th; ?>>Nom</td><td <?php echo $td; ?>>[your-name]</td></tr>
<tr><td <?php echo $th; ?>>E-mail</td><td <?php echo $td; ?>><a href="mailto:[your-email]" style="color:<?php echo $ink; ?>;">[your-email]</a></td></tr>
<tr><td <?php echo $th; ?>>Téléphone</td><td <?php echo $td; ?>><a href="tel:[your-phone]" style="color:<?php echo $ink; ?>;">[your-phone]</a></td></tr>
<tr><td <?php echo $th; ?>>Page</td><td <?php echo $td; ?>><a href="[_post_url]" style="color:<?php echo $ink; ?>;">[_post_title]</a></td></tr>
<tr><td <?php echo $th; ?>>Date</td><td <?php echo $td; ?>>[_date] à [_time]</td></tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
