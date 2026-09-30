<?php
/**
 * The site's two forms (Contact, and the question block of the service pages)
 * keep their own markup, the Nuxt one; Contact Form 7 is their back end.
 * site.js posts them to CF7's REST endpoint, CF7 validates and mails them,
 * Flamingo keeps every message in the admin (Flamingo > Messages reçus), and
 * the forms themselves are set by wordpress/chantier/setup.php (option
 * dl_forms: form name → CF7 id).
 *
 * CF7's own script and styles are not loaded: no CF7 shortcode is ever shown.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'wpcf7_load_js', '__return_false' );
add_filter( 'wpcf7_load_css', '__return_false' );

/** The CF7 id of one of the site's forms ('contact' or 'question'). */
function dl_form_id( $name ) {
	$forms = (array) get_option( 'dl_forms', array() );
	return (int) ( $forms[ $name ] ?? 0 );
}

/**
 * What the form tag needs to post to CF7: its id, its REST endpoint and the
 * page it sits on (CF7's [_post_title] and [_post_url] in the mail).
 */
function dl_form_attrs( $name ) {
	$id = dl_form_id( $name );
	return dl_attrs(
		array(
			'data-form'     => $name,
			'data-cf7'      => (string) $id,
			'data-endpoint' => rest_url( 'contact-form-7/v1/contact-forms/' . $id . '/feedback' ),
			'data-post'     => (string) get_queried_object_id(),
		)
	);
}

/**
 * Spam: a field no one sees (a person leaves it empty) and the seconds since
 * the page loaded, counted by site.js (a person takes more than three). A
 * robot posting straight to the endpoint sends neither the right way.
 */
add_filter(
	'wpcf7_spam',
	function ( $spam, $submission ) {
		if ( $spam || ! in_array( $submission->get_contact_form()->id(), array_map( 'intval', (array) get_option( 'dl_forms', array() ) ), true ) ) {
			return $spam;
		}
		$trap    = (string) $submission->get_posted_data( 'hp-website' );
		$elapsed = (int) $submission->get_posted_data( 'hp-t' );
		if ( '' !== trim( $trap ) || $elapsed < 3 ) {
			$submission->add_spam_log(
				array(
					'agent'  => 'dilytics',
					'reason' => '' !== trim( $trap ) ? 'Champ piège rempli' : 'Envoyé en moins de trois secondes',
				)
			);
			return true;
		}
		return false;
	},
	10,
	2
);
