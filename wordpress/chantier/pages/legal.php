<?php
/**
 * The two legal pages, carried over word for word from the current
 * dilytics.ch (same addresses): plain WordPress content, shown in the site's
 * frame by templates/document.php. Texts in data/legal/<slug>.html.
 */

defined( 'ABSPATH' ) || exit;

foreach ( array(
	'declaration-sur-la-protection-des-donnees' => 'Déclaration sur la protection des données',
	'conditions-generales-de-vente'             => 'Conditions générales de vente',
) as $slug => $title ) {
	$id = dlb_page( $slug, $title );
	delete_post_meta( $id, '_fl_builder_enabled' );
	delete_post_meta( $id, '_wp_page_template' );
	wp_update_post(
		array(
			'ID'           => $id,
			'post_content' => (string) file_get_contents( __DIR__ . '/../data/legal/' . $slug . '.html' ),
		)
	);
	dlb_log( '  ' . get_permalink( $id ) );
}
