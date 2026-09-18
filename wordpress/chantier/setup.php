<?php
/**
 * Site-level setup, idempotent: run it as often as needed.
 *
 *   wp eval-file ~/chantier/dilytics/build.php setup --user=1
 *
 * Beaver Builder's global spacing, the contact details and photo registry the
 * modules read, the pictures, the pages, the main menu, and the Themer header
 * and footer.
 */

defined( 'ABSPATH' ) || exit;

$c = dlb_content();

/* ---------------------------------------------------- Beaver Builder globals
   No automatic spacing anywhere: every section carries the Nuxt spacing in
   its own CSS. Saved through the API: wp beaver global-update crashes on a
   site that has never saved its global settings. */
$globals = (array) FLBuilderModel::get_global_settings();
FLBuilderModel::save_global_settings(
	array_merge(
		$globals,
		array(
			'row_padding_top'       => 0,
			'row_padding_right'     => 0,
			'row_padding_bottom'    => 0,
			'row_padding_left'      => 0,
			'row_margins_top'       => 0,
			'row_margins_right'     => 0,
			'row_margins_bottom'    => 0,
			'row_margins_left'      => 0,
			'module_margins_top'    => 0,
			'module_margins_right'  => 0,
			'module_margins_bottom' => 0,
			'module_margins_left'   => 0,
			'auto_spacing'          => 0,
			'show_default_heading'  => 0,
		)
	)
);
dlb_log( 'Beaver Builder: global spacing at 0' );

// bb-theme's own layout in full width, not boxed (some of its presets box it)
set_theme_mod( 'fl-layout-width', 'full-width' );

/* ------------------------------------------------------------ plugin options */
update_option( 'dl_contact', $c['site']['CONTACT'] );
update_option( 'dl_photos', $c['photos'] );
dlb_log( 'Options: contact details and photo registry' );

/* ------------------------------------------------------------------ pictures
   Every picture of the Nuxt site, under the slug dl-<name>: the modules and
   the scripts find them by name, never by a hard-coded id. */
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/image.php';

$imported = 0;
foreach ( glob( __DIR__ . '/img/*.webp' ) as $file ) {
	$name = basename( $file, '.webp' );
	if ( dl_img_id( $name ) ) {
		continue;
	}
	$tmp = wp_tempnam( $name );
	copy( $file, $tmp );
	$id = media_handle_sideload(
		array(
			'name'     => 'dl-' . $name . '.webp',
			'tmp_name' => $tmp,
		),
		0,
		'dl-' . $name
	);
	if ( is_wp_error( $id ) ) {
		WP_CLI::error( "{$name}: " . $id->get_error_message() );
	}
	wp_update_post(
		array(
			'ID'        => $id,
			'post_name' => 'dl-' . $name,
		)
	);
	++$imported;
}
dlb_log( "Pictures: {$imported} imported, " . count( glob( __DIR__ . '/img/*.webp' ) ) . ' in the library' );

/* --------------------------------------------------------------------- pages */
$pages = array(
	'accueil'             => 'Accueil',
	'entreprises'         => 'Entreprises',
	'creation-dentreprise' => "Création d'entreprise",
	'particuliers'        => 'Particuliers',
	'a-propos'            => 'À propos',
	'contact'             => 'Contact',
	'articles'            => 'Articles',
	'offres-demploi'      => "Offres d'emploi",
	'photos-a-fournir'    => 'Photos à fournir',
);
foreach ( $c['services'] as $s ) {
	$pages[ trim( $s['slug'], '/' ) ] = $c['h1'][ $s['slug'] ] ?? $s['title'];
}
$ids = array();
foreach ( $pages as $slug => $title ) {
	$ids[ $slug ] = dlb_page( $slug, $title );
}
update_option( 'show_on_front', 'page' );
update_option( 'page_on_front', $ids['accueil'] );
dlb_log( 'Pages: ' . count( $ids ) . ', front page is /accueil/' );

// WordPress's sample content has no place on the site: to the bin, not deleted.
foreach ( array( 'hello-world' => 'post', 'sample-page' => 'page', 'privacy-policy' => 'page' ) as $slug => $type ) {
	$p = get_page_by_path( $slug, OBJECT, $type );
	if ( $p && 'trash' !== $p->post_status ) {
		wp_trash_post( $p->ID );
	}
}

// The picture of each menu family is the featured image of the page it links to.
foreach ( array(
	'entreprises'          => 'entr',
	'creation-dentreprise' => 'crea',
	'particuliers'         => 'part',
	'offres-demploi'       => 'duo',
	'a-propos'             => 'apropos',
) as $slug => $img ) {
	set_post_thumbnail( $ids[ $slug ], dlb_media( $img )['id'] );
}

/* ---------------------------------------------------------------- main menu
   MENU of app/content/nav.js. Page links point at the page itself, so a slug
   change never breaks the menu. */
$menu = wp_get_nav_menu_object( 'Menu principal Dilytics' );
$menu_id = $menu ? (int) $menu->term_id : (int) wp_create_nav_menu( 'Menu principal Dilytics' );
foreach ( (array) wp_get_nav_menu_items( $menu_id ) as $old ) {
	wp_delete_post( $old->ID, true );
}
$item = function ( $to, $title, $parent = 0, $desc = '' ) use ( $menu_id, $ids ) {
	$slug = trim( $to, '/' );
	$args = array(
		'menu-item-title'       => $title,
		'menu-item-status'      => 'publish',
		'menu-item-parent-id'   => $parent,
		'menu-item-description' => $desc,
	);
	if ( isset( $ids[ $slug ] ) ) {
		$args['menu-item-type']      = 'post_type';
		$args['menu-item-object']    = 'page';
		$args['menu-item-object-id'] = $ids[ $slug ];
	} else {
		$args['menu-item-type'] = 'custom';
		$args['menu-item-url']  = home_url( $to );
	}
	return (int) wp_update_nav_menu_item( $menu_id, 0, $args );
};
foreach ( $c['menu'] as $fam ) {
	$top = $item( $fam['to'], $fam['label'], 0, $fam['blurb'] );
	foreach ( $fam['items'] as $it ) {
		$item( $it['to'], $it['label'], $top );
	}
}
$locations            = (array) get_theme_mod( 'nav_menu_locations', array() );
$locations['dl-main'] = $menu_id;
set_theme_mod( 'nav_menu_locations', $locations );
dlb_log( 'Menu: ' . count( $c['menu'] ) . ' families' );

/* -------------------------------------------------- Themer header and footer
   The pages never carry a header or a footer module: both are Themer layouts
   shown on the whole site. */
$layout = function ( $slug, $title, $type, array $settings ) {
	$p  = get_page_by_path( $slug, OBJECT, 'fl-theme-layout' );
	$id = $p ? (int) $p->ID : (int) wp_insert_post(
		array(
			'post_type'   => 'fl-theme-layout',
			'post_status' => 'publish',
			'post_title'  => $title,
			'post_name'   => $slug,
			'post_author' => 1,
		)
	);
	update_post_meta( $id, '_fl_theme_layout_type', $type );
	update_post_meta( $id, '_fl_theme_builder_locations', array( 'general:site' ) );
	update_post_meta( $id, '_fl_theme_builder_exclusions', array() );
	update_post_meta( $id, '_fl_theme_layout_settings', $settings );
	return $id;
};

$header = $layout(
	'dl-header',
	'En-tête Dilytics',
	'header',
	array(
		'sticky'     => '0',
		'shrink'     => '0',
		'overlay'    => '0',
		'overlay_bg' => 'default',
	)
);
dlb_start( $header );
dlb_add( 'dl-header', array() );
dlb_finish( $header );

$footer = $layout( 'dl-footer', 'Pied de page Dilytics', 'footer', array() );
dlb_start( $footer );
$legal = array();
foreach ( $c['site']['LEGAL'] as $l ) {
	$legal[] = array(
		't'  => $l['label'],
		'to' => $l['href'],
	);
}
dlb_add(
	'dl-footer',
	array_merge(
		array(
			'intro'     => "Fiduciaire genevoise depuis {since}. Comptabilité, fiscalité, salaires et création d'entreprise, pour les PME et les particuliers.",
			'badge_alt' => 'Badge bexio Partenaire Platine',
			'legal'     => $legal,
			'copy'      => '© 2026 Dilytics · Genève',
		),
		dlb_photo( 'badge', 'bexio_platine' )
	)
);
dlb_finish( $footer );
