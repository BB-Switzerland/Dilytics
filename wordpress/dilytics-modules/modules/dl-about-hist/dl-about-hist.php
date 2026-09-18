<?php
/**
 * pages/a-propos.vue, "Notre histoire": the two eras side by side, on navy.
 */

class DL_About_Hist_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'À propos : histoire', 'Titre, phrase d’introduction et les étapes de l’histoire du cabinet.', 'Pages', __DIR__ );
	}
}

FLBuilder::register_settings_form(
	'dl_about_hist_era',
	array(
		'title' => 'Étape',
		'tabs'  => dl_form(
			array(
				'y' => dl_f_text( 'Année' ),
				't' => dl_f_text( 'Titre' ),
				'p' => dl_f_area( 'Texte', 'Paragraphes séparés par une ligne vide.', 8 ),
			)
		),
	)
);

FLBuilder::register_module(
	'DL_About_Hist_Module',
	dl_form(
		array(
			'title' => dl_f_text( 'Titre' ),
			'text'  => dl_f_area( 'Phrase d’introduction', '', 2 ),
			'eras'  => dl_f_items( 'Étapes', 'dl_about_hist_era' ),
		)
	)
);
