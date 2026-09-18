<?php
/**
 * pages/[slug].vue, the questions: a sticky heading with the phone number
 * beside an accordion, one answer open at a time, the first to begin with.
 */

class DL_Svc_Faq_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Prestation : questions fréquentes', 'Titre, texte, téléphone et questions en accordéon.', 'Prestations', __DIR__ );
	}
}

FLBuilder::register_module(
	'DL_Svc_Faq_Module',
	dl_form(
		array(
			'title' => dl_f_text( 'Titre' ),
			'text'  => dl_f_area( 'Texte', 'Suivi du numéro de téléphone du cabinet.', 3 ),
			'items' => dl_f_items( 'Questions', 'dl_faq' ),
		)
	)
);
