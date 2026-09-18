<?php
/**
 * pages/a-propos.vue, "Nos locaux": the address, and until the real
 * pictures exist, one red slot per picture saying what it should show.
 */

class DL_About_Loc_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'À propos : locaux', 'Titre, adresse du cabinet et emplacements des photos des locaux.', 'Pages', __DIR__ );
	}
}

FLBuilder::register_settings_form(
	'dl_about_loc_slot',
	array(
		'title' => 'Emplacement photo',
		'tabs'  => dl_form(
			array(
				't' => dl_f_area( 'Ce que la photo doit montrer', '', 2 ),
			)
		),
	)
);

FLBuilder::register_module(
	'DL_About_Loc_Module',
	dl_form(
		array(
			'title' => dl_f_text( 'Titre', 'L’adresse qui suit vient des coordonnées du cabinet.' ),
			'label' => dl_f_text( 'Libellé des emplacements photo' ),
			'slots' => dl_f_items( 'Emplacements photo', 'dl_about_loc_slot' ),
		)
	)
);
