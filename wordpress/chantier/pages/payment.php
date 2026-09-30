<?php
/**
 * /paiement-confirme/ — where Stripe sends a client back after an online
 * payment (?item=<service slug>&session_id=cs_…). track.js reads both and
 * pushes the purchase, once per payment. Not indexed (metas.php). WordPress
 * only: the Nuxt site has no payment.
 */

defined( 'ABSPATH' ) || exit;

$id = dlb_page( 'paiement-confirme', 'Paiement reçu' );
dlb_start( $id );

dlb_add(
	'dl-contact-open',
	array_merge(
		array(
			'crumb'  => 'Paiement reçu',
			'lines'  => dlb_lines( array( 'Merci,', 'votre paiement', 'est bien reçu.' ) ),
			'accent' => '2',
			'intro'  => "Le reçu de Stripe vous parvient par e-mail. Pour la suite, réservez un entretien avec l'un de nos conseillers.",
			'alt'    => 'Réunion dans les bureaux de Dilytics',
		),
		dlb_photo( 'img', 'meet' )
	)
);

dlb_cta();

dlb_finish( $id );
