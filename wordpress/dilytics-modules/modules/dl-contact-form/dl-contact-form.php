<?php
/**
 * pages/contact.vue, form and contact blocks. The form opens the visitor's
 * mail client with the message addressed to the cabinet (no mail server).
 */

class DL_Contact_Form_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Contact : formulaire', 'Formulaire de contact et coordonnées du cabinet.', 'Pages', __DIR__ );
	}
}

FLBuilder::register_module(
	'DL_Contact_Form_Module',
	dl_form(
		array(
			'subjects'  => dl_f_area( 'Sujets proposés', 'Un sujet par ligne.', 6 ),
			'button'    => dl_f_text( 'Bouton d’envoi' ),
			'note'      => dl_f_text( 'Phrase à côté du bouton' ),
			'done_t'    => dl_f_text( 'Titre après envoi' ),
			'done_d'    => dl_f_area( 'Texte après envoi', '{mail} est remplacé par l’adresse du cabinet.' ),
			'again'     => dl_f_text( 'Lien pour écrire un autre message' ),
			'call_t'    => dl_f_text( 'Bloc téléphone : titre' ),
			'write_t'   => dl_f_text( 'Bloc e-mail : titre' ),
			'visit_t'   => dl_f_text( 'Bloc adresse : titre' ),
			'visit_d'   => dl_f_area( 'Bloc adresse : accès', '', 2 ),
		)
	)
);
