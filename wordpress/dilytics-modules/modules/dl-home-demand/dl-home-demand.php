<?php
/**
 * components/home/HomeDemand.vue: the prestations for businesses, as rows.
 */

class DL_Home_Demand_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Accueil : prestations', 'Titre, lien vers toutes les prestations et liste des prestations pour les entreprises.', 'Accueil', __DIR__ );
	}
}

FLBuilder::register_module(
	'DL_Home_Demand_Module',
	dl_form(
		array(
			'title' => dl_f_area( 'Titre', 'La balise br passe à la ligne.', 2 ),
			'all'   => dl_f_text( 'Lien : libellé' ),
			'to'    => dl_f_link( 'Lien : page' ),
			'rows'  => dl_f_items( 'Prestations', 'dl_row' ),
		)
	)
);
