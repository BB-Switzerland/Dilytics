<?php
/**
 * pages/[slug].vue, the guide: the explanation read as an article, with a rail
 * that keeps your place, and a picture after the first part on long guides.
 */

class DL_Svc_Guide_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Prestation : guide', 'Parties de l’explication, sommaire qui suit la lecture et photo après la première partie.', 'Prestations', __DIR__ );
	}
}

// A part of the guide: its title and its paragraphs.
FLBuilder::register_settings_form(
	'dl_svc_guide_sec',
	array(
		'title' => 'Partie',
		'tabs'  => dl_form(
			array(
				't' => dl_f_text( 'Titre', 'Repris dans le sommaire.' ),
				'p' => dl_f_area( 'Paragraphes', 'Séparés par une ligne vide.', 10 ),
			)
		),
	)
);

FLBuilder::register_module(
	'DL_Svc_Guide_Module',
	dl_form(
		array(
			'rail_t' => dl_f_text( 'Titre du sommaire', 'Laisser vide pour « Sommaire ».' ),
			'ask'    => dl_f_text( 'Question sous le sommaire', 'Suivie du numéro de téléphone du cabinet.' ),
			'secs'   => dl_f_items( 'Parties', 'dl_svc_guide_sec' ),
			'img'    => dl_f_photo( 'Photo après la première partie' ),
			'alt'    => dl_f_text( 'Texte alternatif de la photo' ),
		)
	)
);
