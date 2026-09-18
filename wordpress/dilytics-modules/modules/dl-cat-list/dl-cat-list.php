<?php
/**
 * CategoryPage.vue, the prestations of the family: heading, text and the
 * shared list of rows (ServiceList.vue).
 */

class DL_Cat_List_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Famille : prestations', 'Titre, texte et liste des prestations d’une famille.', 'Pages', __DIR__ );
	}
}

FLBuilder::register_module(
	'DL_Cat_List_Module',
	dl_form(
		array(
			'title' => dl_f_text( 'Titre', '{n} est remplacé par le nombre de prestations de la liste ; la balise br passe à la ligne.' ),
			'text'  => dl_f_area( 'Texte' ),
			'rows'  => dl_f_items( 'Prestations', 'dl_row' ),
		)
	)
);
