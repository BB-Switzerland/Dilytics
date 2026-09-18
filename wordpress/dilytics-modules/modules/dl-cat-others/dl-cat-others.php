<?php
/**
 * CategoryPage.vue, "Vous cherchiez autre chose ?": the other families as
 * cards, each with its picture, name and pitch.
 */

class DL_Cat_Others_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Famille : autres familles', 'Cartes vers les autres familles de prestations.', 'Pages', __DIR__ );
	}
}

// A card: the family's picture, name, pitch and page.
FLBuilder::register_settings_form(
	'dl_cat_others_card',
	array(
		'title' => 'Famille',
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
	'DL_Cat_Others_Module',
	dl_form(
		array(
			'title' => dl_f_text( 'Titre' ),
			'more'  => dl_f_text( 'Libellé du lien de chaque carte' ),
			'cards' => dl_f_items( 'Familles', 'dl_cat_others_card' ),
		)
	)
);
