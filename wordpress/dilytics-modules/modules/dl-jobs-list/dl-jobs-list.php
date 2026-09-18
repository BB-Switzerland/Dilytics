<?php
/**
 * pages/offres-demploi.vue, "Postes ouverts.": one row per open position,
 * each with a button that opens the visitor's mail client. With no position,
 * the sentence that says so instead.
 */

class DL_Jobs_List_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Carrière : postes ouverts', 'Les postes ouverts, ou la phrase affichée quand il n’y en a aucun.', 'Pages', __DIR__ );
	}
}

FLBuilder::register_settings_form(
	'dl_jobs_list_offer',
	array(
		'title' => 'Poste',
		'tabs'  => dl_form(
			array(
				't' => dl_f_text( 'Intitulé' ),
				'd' => dl_f_area( 'Description', '', 3 ),
				'p' => dl_f_text( 'Taux d’activité' ),
				'l' => dl_f_text( 'Lieu' ),
			)
		),
	)
);

FLBuilder::register_module(
	'DL_Jobs_List_Module',
	dl_form(
		array(
			'title'   => dl_f_text( 'Titre' ),
			'offers'  => dl_f_items( 'Postes ouverts', 'dl_jobs_list_offer' ),
			'none'    => dl_f_area( 'Phrase sans poste ouvert', 'Affichée à la place de la liste quand aucun poste n’est ouvert.' ),
			'apply'   => dl_f_text( 'Bouton de candidature' ),
			'subject' => dl_f_text( 'Objet de l’e-mail de candidature', '{poste} est remplacé par l’intitulé du poste.' ),
		)
	)
);
