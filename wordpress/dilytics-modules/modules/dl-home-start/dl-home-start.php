<?php
/**
 * components/home/HomeStart.vue: what happens once you call, stage by stage.
 * The red line draws through the stages as the page scrolls (assets/js/site.js).
 */

class DL_Home_Start_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Accueil : premier entretien', 'Titre, texte, étapes et prise de rendez-vous.', 'Accueil', __DIR__ );
	}
}

// A stage: its title and its text.
FLBuilder::register_settings_form(
	'dl_home_start_step',
	array(
		'title' => 'Étape',
		'tabs'  => dl_form(
			array(
				't' => dl_f_text( 'Titre' ),
				'd' => dl_f_area( 'Texte' ),
			)
		),
	)
);

FLBuilder::register_module(
	'DL_Home_Start_Module',
	dl_form(
		array(
			'title' => dl_f_area( 'Titre', 'La balise br passe à la ligne.', 2 ),
			'text'  => dl_f_area( 'Texte' ),
			'steps' => dl_f_items( 'Étapes', 'dl_home_start_step' ),
			'label' => dl_f_text( 'Bouton : libellé', 'Le bouton ouvre la prise de rendez-vous.' ),
		)
	)
);
