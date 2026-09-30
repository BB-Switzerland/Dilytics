<?php
/**
 * /contact/ — pages/contact.vue.
 */

defined( 'ABSPATH' ) || exit;

$c  = dlb_content();
$id = dlb_page( 'contact' );
dlb_start( $id );

dlb_add(
	'dl-contact-open',
	array_merge(
		array(
			'crumb'  => 'Contact',
			'lines'  => dlb_lines( array( 'Prenez contact.', 'Nous répondons', 'à tous les messages.' ) ),
			'accent' => '2',
			'intro'  => 'Remplissez le formulaire pour nous poser vos questions ou demander un devis. Vous pouvez également nous joindre par téléphone, du lundi au vendredi.',
			'alt'    => "Vue aérienne de Genève et du Jet d'eau",
		),
		dlb_photo( 'img', 'geneve' )
	)
);

dlb_add(
	'dl-contact-form',
	array(
		'subjects' => dlb_lines( $c['components']['contact']['subjects'] ),
		'button'   => 'Envoyer le message',
		'note'     => 'Vous pouvez aussi nous joindre par téléphone, du lundi au vendredi.',
		'done_t'   => 'Votre message est envoyé.',
		'done_d'   => 'Merci. Nous avons bien reçu votre message : notre équipe répond à tous les messages.',
		'again'    => 'Écrire un autre message',
		'call_t'   => 'Nous appeler',
		'write_t'  => 'Nous écrire',
		'visit_t'  => 'Nous rendre visite',
		'visit_d'  => 'À moins de dix minutes du centre-ville, accessible par le Léman Express et de nombreux bus.',
	)
);

dlb_finish( $id );
