<?php
/**
 * pages/[slug].vue, hero: crumb, headline, tagline, introduction, actions and picture.
 */

class DL_Svc_Hero_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Prestation : ouverture', 'Fil d’Ariane, titre, accroche, introduction, boutons et photo d’une page de prestation.', 'Prestations', __DIR__ );
	}
}

FLBuilder::register_module(
	'DL_Svc_Hero_Module',
	dl_form(
		array(
			'parent_t'  => dl_f_text( 'Fil d’Ariane : famille', 'Nom de la famille de prestations.' ),
			'parent_to' => dl_f_link( 'Fil d’Ariane : page de la famille' ),
			'title'     => dl_f_text( 'Titre', 'Repris dans le fil d’Ariane.' ),
			'tagline'   => dl_f_area( 'Accroche', 'En rouge sous le titre.', 2 ),
			'intro'     => dl_f_area( 'Introduction' ),
			'book'      => dl_f_text( 'Bouton : libellé', 'Ouvre la prise de rendez-vous. Laisser vide pour « Réserver un entretien ».' ),
			'write'     => dl_f_text( 'Lien vers le contact : libellé', 'Laisser vide pour « Nous écrire ».' ),
			'img'       => dl_f_photo( 'Photo' ),
			'alt'       => dl_f_text( 'Texte alternatif de la photo', 'Laisser vide pour reprendre le titre.' ),
		)
	)
);
