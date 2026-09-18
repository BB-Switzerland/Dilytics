<?php
/**
 * components/home/HomeSplit.vue: a picture and the bexio badge beside what
 * sets the cabinet apart.
 */

class DL_Home_Split_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Accueil : ce qui nous distingue', 'Photo, badge bexio, titre, texte et points forts.', 'Accueil', __DIR__ );
	}
}

FLBuilder::register_module(
	'DL_Home_Split_Module',
	dl_form(
		array(
			'img'       => dl_f_photo( 'Photo' ),
			'badge'     => dl_f_photo( 'Badge' ),
			'badge_alt' => dl_f_text( 'Texte alternatif du badge' ),
			'badge_t'   => dl_f_area( 'Texte à côté du badge', 'La balise br passe à la ligne.', 2 ),
			'title'     => dl_f_area( 'Titre', 'La balise br passe à la ligne.', 2 ),
			'text'      => dl_f_area( 'Texte' ),
			'points'    => dl_f_items( 'Points forts', 'dl_td' ),
		)
	)
);
