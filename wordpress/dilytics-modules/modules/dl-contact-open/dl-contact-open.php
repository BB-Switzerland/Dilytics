<?php
/**
 * pages/contact.vue, opening: crumb, headline, introduction and picture.
 */

class DL_Contact_Open_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Contact : ouverture', 'Titre, introduction et photo de la page Contact.', 'Pages', __DIR__ );
	}
}

FLBuilder::register_module(
	'DL_Contact_Open_Module',
	dl_form(
		array(
			'crumb'  => dl_f_text( 'Fil d’Ariane', 'Nom de la page dans le fil d’Ariane.' ),
			'lines'  => dl_f_area( 'Titre', 'Une ligne du titre par ligne.', 3 ),
			'accent' => dl_f_text( 'Ligne en rouge', 'Numéro de la ligne en rouge, en partant de 0.' ),
			'intro'  => dl_f_area( 'Introduction' ),
			'img'    => dl_f_photo( 'Photo' ),
			'alt'    => dl_f_text( 'Texte alternatif de la photo' ),
		)
	)
);
