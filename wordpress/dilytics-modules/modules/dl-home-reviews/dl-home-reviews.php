<?php
/**
 * components/home/HomeReviews.vue: what clients say, the slots still waiting
 * for a review, and the cabinet's labels.
 */

class DL_Home_Reviews_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Accueil : avis clients', 'Avis clients, avis encore attendus et distinctions.', 'Accueil', __DIR__ );
	}
}

// A client's review.
FLBuilder::register_settings_form(
	'dl_home_reviews_review',
	array(
		'title' => 'Avis',
		'tabs'  => dl_form(
			array(
				'quote'   => dl_f_area( 'Citation', '', 5 ),
				'name'    => dl_f_text( 'Nom' ),
				'role'    => dl_f_text( 'Fonction' ),
				'company' => dl_f_text( 'Entreprise' ),
			)
		),
	)
);

// A distinction: its logo, or its value written out when there is no logo.
FLBuilder::register_settings_form(
	'dl_home_reviews_mark',
	array(
		'title' => 'Distinction',
		'tabs'  => dl_form(
			array(
				'img' => dl_f_photo( 'Logo' ),
				'alt' => dl_f_text( 'Texte alternatif du logo' ),
				'v'   => dl_f_text( 'Valeur', 'Écrite à la place du logo quand il n’y en a pas.' ),
				't'   => dl_f_text( 'Légende' ),
			)
		),
	)
);

FLBuilder::register_module(
	'DL_Home_Reviews_Module',
	dl_form(
		array(
			'title'      => dl_f_text( 'Titre' ),
			'reviews'    => array_merge( dl_f_items( 'Avis', 'dl_home_reviews_review' ), array( 'preview_text' => 'name' ) ),
			'slots'      => dl_f_text( 'Avis attendus', 'Nombre de notes rouges « avis à fournir » après les avis.' ),
			'slot_label' => dl_f_text( 'Avis attendu : titre' ),
			'slot_hint'  => dl_f_area( 'Avis attendu : précision', '', 2 ),
			'marks'      => dl_f_items( 'Distinctions', 'dl_home_reviews_mark' ),
		)
	)
);
