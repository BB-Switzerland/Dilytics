<?php
/**
 * pages/photos-a-fournir.vue, the whole page: the shot list for Dilytics and
 * its photographer, generated from the photo registry that puts the red
 * notes on the pages (content/photos.js, written by the build script).
 * The texts are editable; the list follows the registry.
 */

class DL_Photos_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Photos à fournir', 'Liste des photos réelles attendues, tirée du registre des notes rouges.', 'Pages', __DIR__ );
	}
}

FLBuilder::register_settings_form(
	'dl_photos_group',
	array(
		'title' => 'Groupe de photos',
		'tabs'  => dl_form(
			array(
				'prio' => dl_f_text( 'Priorité', 'Les photos du registre qui portent cette priorité (1 ou 2).' ),
				't'    => dl_f_text( 'Titre' ),
				'd'    => dl_f_area( 'Texte', '', 3 ),
			)
		),
	)
);

FLBuilder::register_module(
	'DL_Photos_Module',
	dl_form(
		array(
			'title'     => dl_f_text( 'Titre' ),
			'intro'     => dl_f_area( 'Introduction', '{total} est remplacé par le nombre d’emplacements.', 5 ),
			'new_t'     => dl_f_text( 'Nouveaux emplacements : titre' ),
			'new_d'     => dl_f_area( 'Nouveaux emplacements : texte', '', 2 ),
			'new_label' => dl_f_text( 'Nouveaux emplacements : libellé de la case' ),
			'groups'    => dl_f_items( 'Groupes de photos à remplacer', 'dl_photos_group' ),
			'file'      => dl_f_text( 'Ligne du fichier actuel', '{file} est remplacé par le nom du fichier.' ),
		)
	)
);
