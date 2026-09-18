<?php
/**
 * CategoryPage.vue, opening: crumb, title, pitch, introduction, the two
 * buttons, the picture and the three facts of the family.
 */

class DL_Cat_Open_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Famille : ouverture', 'Titre, accroche, introduction, boutons, photo et chiffres clés d’une famille de prestations.', 'Pages', __DIR__ );
	}
}

// A fact: the figure or word in large type, its caption below.
FLBuilder::register_settings_form(
	'dl_cat_open_fact',
	array(
		'title' => 'Chiffre clé',
		'tabs'  => dl_form(
			array(
				'v' => dl_f_text( 'Chiffre ou mot' ),
				'k' => dl_f_area( 'Légende', '', 2 ),
			)
		),
	)
);

FLBuilder::register_module(
	'DL_Cat_Open_Module',
	dl_form(
		array(
			'crumb' => dl_f_text( 'Fil d’Ariane', 'Nom de la page dans le fil d’Ariane.' ),
			'title' => dl_f_text( 'Titre' ),
			'pitch' => dl_f_area( 'Accroche', 'En rouge, sous le titre.', 2 ),
			'lede'  => dl_f_area( 'Introduction' ),
			'book'  => dl_f_text( 'Bouton : libellé', 'Le bouton ouvre la prise de rendez-vous ; le téléphone du cabinet suit.' ),
			'img'   => dl_f_photo( 'Photo' ),
			'alt'   => dl_f_text( 'Texte alternatif de la photo' ),
			'facts' => array_merge( dl_f_items( 'Chiffres clés', 'dl_cat_open_fact' ), array( 'preview_text' => 'v' ) ),
		)
	)
);
