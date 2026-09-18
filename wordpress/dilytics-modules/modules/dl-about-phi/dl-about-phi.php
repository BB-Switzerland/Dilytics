<?php
/**
 * pages/a-propos.vue, "Notre philosophie": the heading holds while the
 * principles go past.
 */

class DL_About_Phi_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'À propos : philosophie', 'Titre fixe, phrase d’introduction et les principes du cabinet.', 'Pages', __DIR__ );
	}
}

FLBuilder::register_module(
	'DL_About_Phi_Module',
	dl_form(
		array(
			'title'  => dl_f_text( 'Titre' ),
			'text'   => dl_f_area( 'Phrase d’introduction', '', 2 ),
			'values' => dl_f_items( 'Principes', 'dl_td' ),
		)
	)
);
