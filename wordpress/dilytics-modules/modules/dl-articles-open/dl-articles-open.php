<?php
/**
 * pages/articles.vue, opening: crumb, headline, introduction and the lead
 * article, large.
 */

class DL_Articles_Open_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Articles : ouverture', 'Titre, introduction et article à la une de la page Articles.', 'Pages', __DIR__ );
	}
}

FLBuilder::register_module(
	'DL_Articles_Open_Module',
	dl_form(
		array(
			'crumb'   => dl_f_text( 'Fil d’Ariane', 'Nom de la page dans le fil d’Ariane.' ),
			'lines'   => dl_f_area( 'Titre', 'Une ligne du titre par ligne.', 3 ),
			'accent'  => dl_f_text( 'Ligne en rouge', 'Numéro de la ligne en rouge, en partant de 0.' ),
			'text'    => dl_f_area( 'Introduction' ),
			'img'     => dl_f_photo( 'Article à la une : image' ),
			'title'   => dl_f_text( 'Article à la une : titre' ),
			'excerpt' => dl_f_area( 'Article à la une : résumé', '', 2 ),
			'date'    => dl_f_text( 'Article à la une : date' ),
			'to'      => dl_f_link( 'Article à la une : lien' ),
		)
	)
);
