<?php
/**
 * pages/articles.vue, the other articles, three to a row.
 */

class DL_Articles_Grid_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Articles : liste', 'Les articles, trois par ligne.', 'Pages', __DIR__ );
	}
}

FLBuilder::register_settings_form(
	'dl_articles_grid_item',
	array(
		'title' => 'Article',
		'tabs'  => dl_form(
			array(
				'img'     => dl_f_photo( 'Image' ),
				't'       => dl_f_text( 'Titre' ),
				'excerpt' => dl_f_area( 'Résumé', '', 2 ),
				'date'    => dl_f_text( 'Date' ),
				'to'      => dl_f_link( 'Lien' ),
			)
		),
	)
);

FLBuilder::register_module(
	'DL_Articles_Grid_Module',
	dl_form(
		array(
			'items' => dl_f_items( 'Articles', 'dl_articles_grid_item' ),
		)
	)
);
