<?php
/**
 * pages/a-propos.vue, the identity figures, one row each.
 */

class DL_About_Marks_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'À propos : chiffres', 'Les chiffres du cabinet, un par ligne, avec leur explication.', 'Pages', __DIR__ );
	}
}

FLBuilder::register_settings_form(
	'dl_about_marks_item',
	array(
		'title' => 'Chiffre',
		'tabs'  => dl_form(
			array(
				'v' => dl_f_text( 'Chiffre' ),
				't' => dl_f_text( 'Titre' ),
				'd' => dl_f_area( 'Texte', '', 2 ),
			)
		),
	)
);

FLBuilder::register_module(
	'DL_About_Marks_Module',
	dl_form(
		array(
			'items' => dl_f_items( 'Chiffres', 'dl_about_marks_item' ),
		)
	)
);
