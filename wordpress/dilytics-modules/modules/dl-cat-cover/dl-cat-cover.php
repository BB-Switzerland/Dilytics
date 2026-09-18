<?php
/**
 * CategoryPage.vue, what an engagement covers: the promise, a link to ask for
 * a quote and the list of what is included.
 */

class DL_Cat_Cover_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Famille : ce qui est compris', 'Promesse, lien vers un devis et liste de ce que comprend l’accompagnement.', 'Pages', __DIR__ );
	}
}

FLBuilder::register_module(
	'DL_Cat_Cover_Module',
	dl_form(
		array(
			'title'   => dl_f_text( 'Titre' ),
			'label'   => dl_f_text( 'Lien : libellé' ),
			'to'      => dl_f_link( 'Lien : adresse' ),
			'bullets' => dl_f_area( 'Ce qui est compris', 'Un point par ligne.', 6 ),
		)
	)
);
