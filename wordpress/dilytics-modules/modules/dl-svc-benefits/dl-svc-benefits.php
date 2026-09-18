<?php
/**
 * pages/[slug].vue, the three named benefits under the hero.
 */

class DL_Svc_Benefits_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Prestation : atouts', 'Les atouts de la prestation, chacun avec son pictogramme.', 'Prestations', __DIR__ );
	}
}

// A benefit: its pictogram (Ico.vue), a title, a text.
FLBuilder::register_settings_form(
	'dl_svc_benefits_item',
	array(
		'title' => 'Atout',
		'tabs'  => dl_form(
			array(
				'ico' => array(
					'type'    => 'select',
					'label'   => 'Pictogramme',
					'default' => 'check',
					'options' => array(
						'check'  => 'Coche',
						'tag'    => 'Étiquette',
						'screen' => 'Écran',
						'talk'   => 'Bulle',
						'coin'   => 'Pièces',
						'clock'  => 'Horloge',
						'shield' => 'Bouclier',
						'pin'    => 'Repère',
						'doc'    => 'Document',
						'users'  => 'Personnes',
						'chart'  => 'Graphique',
					),
				),
				't'   => dl_f_text( 'Titre' ),
				'd'   => dl_f_area( 'Texte', '', 3 ),
			)
		),
	)
);

FLBuilder::register_module(
	'DL_Svc_Benefits_Module',
	dl_form(
		array(
			'items' => dl_f_items( 'Atouts', 'dl_svc_benefits_item' ),
		)
	)
);
