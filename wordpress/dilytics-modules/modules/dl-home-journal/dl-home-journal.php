<?php
/**
 * components/home/HomeJournal.vue: the latest articles, the first one large.
 */

class DL_Home_Journal_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Accueil : articles', 'Titre, lien vers les articles, article à la une et articles suivants.', 'Accueil', __DIR__ );
	}
}

// An article as the home page lists it.
FLBuilder::register_settings_form(
	'dl_home_journal_article',
	array(
		'title' => 'Article',
		'tabs'  => dl_form(
			array(
				'img'     => dl_f_photo( 'Photo' ),
				'title'   => dl_f_text( 'Titre' ),
				'excerpt' => dl_f_area( 'Résumé', 'Affiché pour le premier article seulement.', 3 ),
				'date'    => dl_f_text( 'Date' ),
			)
		),
	)
);

FLBuilder::register_module(
	'DL_Home_Journal_Module',
	dl_form(
		array(
			'title'    => dl_f_text( 'Titre' ),
			'all'      => dl_f_text( 'Lien : libellé' ),
			'to'       => dl_f_link( 'Page des articles', 'Le lien du titre et de chaque article.' ),
			'articles' => array_merge( dl_f_items( 'Articles', 'dl_home_journal_article' ), array( 'preview_text' => 'title' ) ),
		)
	)
);
