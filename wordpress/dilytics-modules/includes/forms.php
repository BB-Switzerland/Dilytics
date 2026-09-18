<?php
/**
 * The base class every module extends, and the settings forms the repeaters
 * share. Loaded on fl_builder_loaded, once FLBuilderModule exists.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Every module renders its own root element (include_wrapper false): the
 * section of the Nuxt site is the module, with no wrapper between the two.
 */
abstract class DL_Module extends FLBuilderModule {
	public function __construct( $name, $description, $category, $dir ) {
		parent::__construct(
			array(
				'name'            => $name,
				'description'     => $description,
				'group'           => 'Dilytics',
				'category'        => $category,
				'dir'             => trailingslashit( $dir ),
				'url'             => DL_URL . 'modules/' . basename( $dir ) . '/',
				'partial_refresh' => true,
				'include_wrapper' => false,
			)
		);
	}
}

/** Field shorthands, labels in French for the people who edit the site. */
function dl_f_text( $label, $help = '' ) {
	return array_filter(
		array(
			'type'    => 'text',
			'label'   => $label,
			'default' => '',
			'help'    => $help,
		)
	);
}
function dl_f_area( $label, $help = '', $rows = 4 ) {
	return array_filter(
		array(
			'type'    => 'textarea',
			'label'   => $label,
			'default' => '',
			'rows'    => $rows,
			'help'    => $help,
		)
	);
}
function dl_f_photo( $label ) {
	return array(
		'type'        => 'photo',
		'label'       => $label,
		'show_remove' => true,
	);
}
function dl_f_link( $label, $help = '' ) {
	return array_filter(
		array(
			'type'  => 'link',
			'label' => $label,
			'help'  => $help,
		)
	);
}
function dl_f_items( $label, $form ) {
	return array(
		'type'         => 'form',
		'label'        => $label,
		'form'         => $form,
		'preview_text' => 't',
		'multiple'     => true,
	);
}
/** A settings form of one section named "Contenu". */
function dl_form( array $fields, $title = 'Contenu' ) {
	return array(
		'general' => array(
			'title'    => $title,
			'sections' => array(
				'main' => array(
					'title'  => '',
					'fields' => $fields,
				),
			),
		),
	);
}

// A title and a text: benefits, points, stages, perks.
FLBuilder::register_settings_form(
	'dl_td',
	array(
		'title' => 'Élément',
		'tabs'  => dl_form(
			array(
				't' => dl_f_text( 'Titre' ),
				'd' => dl_f_area( 'Texte' ),
			)
		),
	)
);

// A question and its answer.
FLBuilder::register_settings_form(
	'dl_faq',
	array(
		'title' => 'Question',
		'tabs'  => dl_form(
			array(
				't' => dl_f_text( 'Question' ),
				'd' => dl_f_area( 'Réponse', '', 5 ),
			)
		),
	)
);

// A service row: name, one-line description, page.
FLBuilder::register_settings_form(
	'dl_row',
	array(
		'title' => 'Prestation',
		'tabs'  => dl_form(
			array(
				't'  => dl_f_text( 'Nom' ),
				'd'  => dl_f_area( 'Description', '', 2 ),
				'to' => dl_f_link( 'Page' ),
			)
		),
	)
);
