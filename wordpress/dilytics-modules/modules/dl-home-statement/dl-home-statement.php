<?php
/**
 * components/home/HomeStatement.vue: one sentence, lit word by word as it
 * scrolls through.
 */

class DL_Home_Statement_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Accueil : déclaration', 'Une phrase en grand, qui s’éclaire mot à mot au défilement.', 'Accueil', __DIR__ );
	}
}

FLBuilder::register_module(
	'DL_Home_Statement_Module',
	dl_form(
		array(
			'text' => dl_f_area( 'Phrase', 'Les mots dans une balise span de classe red sont en rouge.', 4 ),
		)
	)
);
