<?php
/**
 * CrossSell.vue: four other services, each a card with its picture, its name,
 * its one-line pitch and a link to its page.
 */

class DL_Cross_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Autres prestations', 'Titre et cartes vers d’autres prestations.', 'Sections partagées', __DIR__ );
	}
}

// A card: the service's name, pitch, page and picture.
FLBuilder::register_settings_form(
	'dl_cross_item',
	array(
		'title' => 'Prestation',
		'tabs'  => dl_form(
			array(
				't'   => dl_f_text( 'Nom' ),
				'd'   => dl_f_area( 'Accroche', '', 2 ),
				'to'  => dl_f_link( 'Page' ),
				'img' => dl_f_photo( 'Photo' ),
			)
		),
	)
);

FLBuilder::register_module(
	'DL_Cross_Module',
	dl_form(
		array(
			'title' => dl_f_text( 'Titre' ),
			'items' => dl_f_items( 'Prestations', 'dl_cross_item' ),
			'visit' => dl_f_text( 'Lien de chaque carte : libellé', 'Laisser vide pour « Visiter la page ».' ),
		)
	)
);
