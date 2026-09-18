<?php
/**
 * SiteNav.vue and ScrollBar.vue: the fixed bar, its mega panels, the mobile
 * drawer and the reading progress line. The families come from the main
 * menu (Apparence › Menus), see includes/menus.php.
 */

class DL_Header_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'En-tête du site', 'Barre de navigation, panneaux du menu et menu mobile.', 'Structure', __DIR__ );
	}
}

FLBuilder::register_module(
	'DL_Header_Module',
	dl_form(
		array(
			'cta'       => array_merge( dl_f_text( 'Bouton', 'Libellé du bouton rouge, qui ouvre la prise de rendez-vous.' ), array( 'default' => 'Rendez-vous' ) ),
			'aside'     => array_merge( dl_f_text( 'Phrase sous la photo des panneaux' ), array( 'default' => 'Une question avant de choisir ?' ) ),
			'drawer_cta' => array_merge( dl_f_text( 'Bouton du menu mobile' ), array( 'default' => 'Prendre rendez-vous' ) ),
		),
		'Réglages'
	)
);
