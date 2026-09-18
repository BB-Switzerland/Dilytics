<?php
/**
 * SiteFoot.vue: the brand block, the menu columns, contact and the legal line.
 */

class DL_Footer_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Pied de page', 'Présentation, colonnes du menu, contact et mentions.', 'Structure', __DIR__ );
	}
}

FLBuilder::register_settings_form(
	'dl_legal',
	array(
		'title' => 'Lien',
		'tabs'  => dl_form(
			array(
				't'  => dl_f_text( 'Libellé' ),
				'to' => dl_f_link( 'Adresse' ),
			)
		),
	)
);

FLBuilder::register_module(
	'DL_Footer_Module',
	dl_form(
		array(
			'intro'     => dl_f_area( 'Présentation', 'Sous le logo. {since} est remplacé par l’année de fondation.', 3 ),
			'badge'     => dl_f_photo( 'Badge' ),
			'badge_alt' => dl_f_text( 'Texte alternatif du badge' ),
			'legal'     => dl_f_items( 'Liens légaux', 'dl_legal' ),
			'copy'      => dl_f_text( 'Ligne de copyright' ),
		)
	)
);
