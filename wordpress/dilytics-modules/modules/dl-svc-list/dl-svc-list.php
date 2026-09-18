<?php
/**
 * pages/[slug].vue, what the engagement covers: plain lines, or named parts
 * with their description set three abreast under the heading.
 */

class DL_Svc_List_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Prestation : ce qui est compris', 'Titre et liste cochée : lignes simples, ou éléments nommés avec leur description.', 'Prestations', __DIR__ );
	}
}

// An item: a plain line (text alone), or a named part (name and text).
FLBuilder::register_settings_form(
	'dl_svc_list_item',
	array(
		'title' => 'Élément',
		'tabs'  => dl_form(
			array(
				't' => dl_f_text( 'Nom', 'Laisser vide pour une ligne simple. Quand le premier élément a un nom, la liste passe sur trois colonnes.' ),
				'd' => dl_f_area( 'Texte', '', 3 ),
			)
		),
	)
);

FLBuilder::register_module(
	'DL_Svc_List_Module',
	dl_form(
		array(
			'title' => dl_f_text( 'Titre' ),
			'items' => array_merge( dl_f_items( 'Éléments', 'dl_svc_list_item' ), array( 'preview_text' => 'd' ) ),
		)
	)
);
