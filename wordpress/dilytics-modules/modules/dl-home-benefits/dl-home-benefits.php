<?php
/**
 * components/home/HomeBenefits.vue: the four gains, each under its icon.
 */

class DL_Home_Benefits_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Accueil : bénéfices', 'Titre, texte et bénéfices avec leur icône.', 'Accueil', __DIR__ );
	}
}

// A benefit: its icon, its name, its text.
FLBuilder::register_settings_form(
	'dl_home_benefits_item',
	array(
		'title' => 'Bénéfice',
		'tabs'  => dl_form(
			array(
				'ico' => array(
					'type'    => 'select',
					'label'   => 'Icône',
					'default' => 'clock',
					'options' => array(
						'clock'  => 'Horloge',
						'shield' => 'Bouclier',
						'chart'  => 'Graphique',
						'talk'   => 'Bulle de dialogue',
						'coin'   => 'Pièces',
						'doc'    => 'Document',
						'users'  => 'Personnes',
						'screen' => 'Écran',
						'tag'    => 'Étiquette',
						'pin'    => 'Repère',
					),
				),
				't'   => dl_f_text( 'Titre' ),
				'd'   => dl_f_area( 'Texte' ),
			)
		),
	)
);

FLBuilder::register_module(
	'DL_Home_Benefits_Module',
	dl_form(
		array(
			'title' => dl_f_area( 'Titre', 'La balise br passe à la ligne.', 2 ),
			'text'  => dl_f_area( 'Texte' ),
			'items' => dl_f_items( 'Bénéfices', 'dl_home_benefits_item' ),
		)
	)
);
