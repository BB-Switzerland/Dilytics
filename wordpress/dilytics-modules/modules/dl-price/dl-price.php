<?php
/**
 * PriceBlock.vue: one band, two cards. The price on white; beside it the free
 * offer when there is one, otherwise the key figures, otherwise nothing.
 */

class DL_Price_Module extends DL_Module {
	public function __construct() {
		parent::__construct( 'Tarif', 'Carte du prix, avec l’offre gratuite ou les chiffres clés à côté.', 'Sections partagées', __DIR__ );
	}
}

// A key figure: its label and its value.
FLBuilder::register_settings_form(
	'dl_price_fact',
	array(
		'title' => 'Chiffre clé',
		'tabs'  => dl_form(
			array(
				'k' => dl_f_text( 'Libellé' ),
				'v' => dl_f_text( 'Valeur' ),
			)
		),
	)
);

FLBuilder::register_module(
	'DL_Price_Module',
	array(
		'price' => array(
			'title'    => 'Prix',
			'sections' => array(
				'main' => array(
					'title'  => '',
					'fields' => array(
						'lead'   => dl_f_text( 'Phrase au-dessus du prix' ),
						'amount' => dl_f_text( 'Montant', 'Tel qu’affiché, par exemple 2\'600 : le chiffre compte jusqu’à lui.' ),
						'unit'   => dl_f_text( 'Devise' ),
						'per'    => dl_f_text( 'Période', 'Facultatif, par exemple « par mois ».' ),
						'terms'  => dl_f_text( 'Conditions', 'Facultatif.' ),
						'detail' => dl_f_area( 'Texte' ),
						'cta'    => dl_f_text( 'Bouton', 'Mène à la page Contact.' ),
					),
				),
			),
		),
		'aside' => array(
			'title'    => 'À côté du prix',
			'sections' => array(
				'offer' => array(
					'title'  => 'Offre gratuite',
					'fields' => array(
						'offer_t'   => dl_f_text( 'Titre', 'Quand l’offre a un titre, elle prend la place des chiffres clés.' ),
						'offer_d'   => dl_f_area( 'Texte' ),
						'offer_cta' => dl_f_text( 'Bouton', 'Mène à la page Contact.' ),
					),
				),
				'keys'  => array(
					'title'  => 'Chiffres clés',
					'fields' => array(
						'facts_t'   => dl_f_text( 'Titre' ),
						'facts'     => array_merge( dl_f_items( 'Chiffres clés', 'dl_price_fact' ), array( 'preview_text' => 'k' ) ),
						'facts_cta' => dl_f_text( 'Bouton', 'Ouvre la prise de rendez-vous. Laisser vide pour « Prendre rendez-vous ».' ),
					),
				),
			),
		),
	)
);
