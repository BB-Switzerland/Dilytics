<?php
/**
 * pages/a-propos.vue, the bexio partnership on its own band, with the badge.
 */

class DL_About_Bex_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'À propos : partenaire bexio', 'Badge, titre et texte du partenariat bexio.', 'Pages', __DIR__ );
	}
}

FLBuilder::register_module(
	'DL_About_Bex_Module',
	dl_form(
		array(
			'img'   => dl_f_photo( 'Badge' ),
			'alt'   => dl_f_text( 'Texte alternatif du badge' ),
			'title' => dl_f_text( 'Titre' ),
			'text'  => dl_f_area( 'Texte' ),
		)
	)
);
