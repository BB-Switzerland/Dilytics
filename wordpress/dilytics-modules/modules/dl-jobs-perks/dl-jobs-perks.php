<?php
/**
 * pages/offres-demploi.vue, "Travailler ici": what the cabinet offers.
 */

class DL_Jobs_Perks_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Carrière : avantages', 'Ce que le cabinet offre à ses collaborateurs, quatre par ligne.', 'Pages', __DIR__ );
	}
}

FLBuilder::register_module(
	'DL_Jobs_Perks_Module',
	dl_form(
		array(
			'title' => dl_f_text( 'Titre' ),
			'items' => dl_f_items( 'Avantages', 'dl_td' ),
		)
	)
);
