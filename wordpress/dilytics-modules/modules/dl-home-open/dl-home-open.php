<?php
/**
 * components/home/HomeOpen.vue: the opening of the home page. Photograph,
 * headline, introduction, booking and phone, the three figures at the foot.
 */

class DL_Home_Open_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Accueil : ouverture', 'Photo plein écran, titre, introduction, rendez-vous et trois chiffres.', 'Accueil', __DIR__ );
	}
}

// A figure of the strip: the value and its caption.
FLBuilder::register_settings_form(
	'dl_home_open_fig',
	array(
		'title' => 'Chiffre',
		'tabs'  => dl_form(
			array(
				'v' => dl_f_text( 'Chiffre', '{years} est remplacé par le nombre d’années depuis la fondation du cabinet.' ),
				'l' => dl_f_text( 'Légende' ),
			)
		),
	)
);

FLBuilder::register_module(
	'DL_Home_Open_Module',
	dl_form(
		array(
			'img'    => dl_f_photo( 'Photo de fond' ),
			'lines'  => dl_f_area( 'Titre', 'Une ligne du titre par ligne.', 2 ),
			'accent' => dl_f_text( 'Ligne en rouge', 'Numéro de la ligne en rouge, en partant de 0.' ),
			'intro'  => dl_f_area( 'Introduction', '{since} est remplacé par l’année de fondation.' ),
			'label'  => dl_f_text( 'Bouton rouge : libellé', 'Le bouton ouvre la prise de rendez-vous.' ),
			'strip'  => array_merge( dl_f_items( 'Chiffres', 'dl_home_open_fig' ), array( 'preview_text' => 'v' ) ),
		)
	)
);
