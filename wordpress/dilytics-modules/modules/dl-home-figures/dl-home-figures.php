<?php
/**
 * components/home/HomeFigures.vue: the navy panel, the founder's words beside
 * the cabinet's figures.
 */

class DL_Home_Figures_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Accueil : le cabinet en chiffres', 'Citation du fondateur, lien vers le cabinet et chiffres clés.', 'Accueil', __DIR__ );
	}
}

// A figure: a counted number (with what comes before and after it), or a
// written value, or, while it is missing, the red note asking for it.
FLBuilder::register_settings_form(
	'dl_home_figures_stat',
	array(
		'title' => 'Chiffre',
		'tabs'  => dl_form(
			array(
				'n'       => dl_f_text( 'Nombre', 'Compté depuis zéro à l’apparition.' ),
				'prefix'  => dl_f_text( 'Avant le nombre' ),
				'suffix'  => dl_f_text( 'Après le nombre' ),
				'text'    => dl_f_text( 'Valeur écrite', 'Remplace le nombre, sans comptage (par exemple « 4,6 / 5 »).' ),
				'label'   => dl_f_text( 'Légende' ),
				'pending' => dl_f_text( 'Chiffre attendu', 'Rempli tant que le chiffre manque : une note rouge le remplace.' ),
				'hint'    => dl_f_area( 'Chiffre attendu : précision', '', 2 ),
			)
		),
	)
);

FLBuilder::register_module(
	'DL_Home_Figures_Module',
	dl_form(
		array(
			'quote' => dl_f_area( 'Citation', 'Les mots dans une balise span de classe red sont en rouge.', 3 ),
			'img'   => dl_f_photo( 'Portrait' ),
			'name'  => dl_f_text( 'Nom' ),
			'role'  => dl_f_text( 'Fonction' ),
			'label' => dl_f_text( 'Bouton : libellé' ),
			'to'    => dl_f_link( 'Bouton : page' ),
			'stats' => array_merge( dl_f_items( 'Chiffres', 'dl_home_figures_stat' ), array( 'preview_text' => 'label' ) ),
		)
	)
);
