<?php
/**
 * pages/a-propos.vue, opening: crumb, headline across the full measure,
 * two paragraphs, and the photograph from edge to edge beneath.
 */

class DL_About_Open_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'À propos : ouverture', 'Titre, introduction et grande photo de la page À propos.', 'Pages', __DIR__ );
	}
}

FLBuilder::register_module(
	'DL_About_Open_Module',
	dl_form(
		array(
			'crumb' => dl_f_text( 'Fil d’Ariane', 'Nom de la page dans le fil d’Ariane.' ),
			'title' => dl_f_text( 'Titre' ),
			'intro' => dl_f_area( 'Introduction', 'Deux paragraphes côte à côte, séparés par une ligne vide.', 8 ),
			'img'   => dl_f_photo( 'Photo pleine largeur' ),
			'alt'   => dl_f_text( 'Texte alternatif de la photo' ),
		)
	)
);
