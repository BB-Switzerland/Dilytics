<?php
/**
 * SiteCta.vue: the navy contact band at the foot of most pages.
 */

class DL_Cta_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Bandeau de contact', 'Bandeau bleu marine : titre, téléphone, prise de rendez-vous, adresse et horaires.', 'Sections partagées', __DIR__ );
	}
}

FLBuilder::register_module(
	'DL_Cta_Module',
	dl_form(
		array(
			'lines'  => dl_f_area( 'Titre', 'Une ligne du titre par ligne ; la deuxième est en rouge.', 2 ),
			'text'   => dl_f_area( 'Texte' ),
			'label'  => dl_f_text( 'Bouton rouge : libellé', 'Laisser vide pour « Réserver un entretien », qui ouvre la prise de rendez-vous.' ),
			'to'     => dl_f_link( 'Bouton rouge : lien', 'Laisser vide pour la prise de rendez-vous.' ),
			'img'    => dl_f_photo( 'Photo' ),
		)
	)
);
