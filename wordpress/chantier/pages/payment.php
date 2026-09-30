<?php
/**
 * /paiement-confirme/ — where Stripe sends a client back after an online
 * payment (?item=<service slug>&session_id=cs_…). track.js reads both and
 * pushes the purchase, once per payment. A plain page in the document frame
 * (templates/document.php): a title, a sentence, the booking button. Not
 * indexed (metas.php). WordPress only: the Nuxt site has no payment.
 */

defined( 'ABSPATH' ) || exit;

$c  = dlb_content()['site']['CONTACT'];
$id = dlb_page( 'paiement-confirme', 'Paiement reçu' );

// a plain page: no Beaver Builder layout left over from an earlier build
FLBuilderModel::delete_layout_data( 'draft', $id );
FLBuilderModel::delete_layout_data( 'published', $id );
delete_post_meta( $id, '_fl_builder_enabled' );
delete_post_meta( $id, '_wp_page_template' );
update_post_meta( $id, '_dl_heading', 'Merci, votre paiement est bien reçu.' );
update_post_meta( $id, '_dl_layout', 'done' ); // centred, a check above the title

wp_update_post(
	array(
		'ID'           => $id,
		'post_content' => '<p class="body">Le reçu de Stripe vous parvient par e-mail. Pour la suite, réservez un entretien avec l\'un de nos conseillers.</p>'
			. '<p class="acts"><a class="cta cta-red" href="' . esc_url( $c['booking'] ) . '" target="_blank" rel="noopener"><span>Réserver un entretien</span>' . dl_ar() . '</a>'
			. '<a class="ph" href="' . esc_attr( $c['phoneHref'] ) . '">' . esc_html( $c['phone'] ) . '</a></p>',
	)
);
dlb_log( '  ' . get_permalink( $id ) );
