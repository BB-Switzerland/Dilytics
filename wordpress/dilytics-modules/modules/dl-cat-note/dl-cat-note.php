<?php
/**
 * CategoryPage.vue, the question the family raises: a picture beside a
 * title, a text, the appointment button and the phone.
 */

class DL_Cat_Note_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Famille : note', 'Photo, titre, texte, prise de rendez-vous et téléphone.', 'Pages', __DIR__ );
	}
}

FLBuilder::register_module(
	'DL_Cat_Note_Module',
	dl_form(
		array(
			'img'   => dl_f_photo( 'Photo' ),
			'title' => dl_f_text( 'Titre' ),
			'text'  => dl_f_area( 'Texte' ),
			'book'  => dl_f_text( 'Bouton : libellé', 'Le bouton ouvre la prise de rendez-vous ; le téléphone du cabinet suit.' ),
		)
	)
);
