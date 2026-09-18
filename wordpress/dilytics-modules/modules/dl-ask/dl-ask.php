<?php
/**
 * AskBlock.vue: "Des questions ?", a short form beside the phone and e-mail.
 * The form opens the visitor's mail client, addressed to the cabinet.
 */

class DL_Ask_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Des questions ?', 'Texte, téléphone, e-mail et formulaire court.', 'Sections partagées', __DIR__ );
	}
}

FLBuilder::register_module(
	'DL_Ask_Module',
	dl_form(
		array(
			'title'  => dl_f_text( 'Titre' ),
			'text'   => dl_f_area( 'Texte' ),
			'hours'  => dl_f_area( 'Disponibilités', '', 2 ),
			'button' => dl_f_text( 'Bouton d’envoi' ),
			'done_t' => dl_f_text( 'Mot après envoi' ),
			'done_d' => dl_f_area( 'Texte après envoi', '{mail} est remplacé par l’adresse du cabinet.' ),
			'again'  => dl_f_text( 'Lien pour écrire un autre message' ),
		)
	)
);
