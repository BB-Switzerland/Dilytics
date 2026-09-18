<?php
/**
 * The main menu. The header's mega panels, the mobile drawer and the footer
 * columns all read it, as the Nuxt site reads MENU in app/content/nav.js.
 *
 * A family is a top-level item: its label, its link, its description (the
 * blurb under the panel title) and the featured image of the page it links to
 * (the picture in the panel). Its children are the entries of the panel.
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'after_setup_theme',
	function () {
		register_nav_menus( array( 'dl-main' => 'Menu principal Dilytics' ) );
	}
);

/**
 * The label as typed: WordPress's display title goes through wptexturize,
 * which turns "d'entreprise" into a curly apostrophe the Nuxt site does not have.
 */
function dl_menu_label( $item ) {
	if ( '' !== $item->post_title ) {
		return $item->post_title;
	}
	// WordPress leaves the item's own title empty when it equals the page's
	if ( 'post_type' === $item->type && $item->object_id ) {
		return get_post_field( 'post_title', (int) $item->object_id, 'raw' );
	}
	return wp_specialchars_decode( $item->title, ENT_QUOTES );
}

function dl_menu_families() {
	static $out = null;
	if ( null !== $out ) {
		return $out;
	}
	$out       = array();
	$locations = get_nav_menu_locations();
	if ( empty( $locations['dl-main'] ) ) {
		return $out;
	}
	$items = wp_get_nav_menu_items( $locations['dl-main'] );
	if ( ! $items ) {
		return $out;
	}
	$byParent = array();
	foreach ( $items as $it ) {
		$byParent[ (int) $it->menu_item_parent ][] = $it;
	}
	foreach ( $byParent[0] ?? array() as $top ) {
		$img = 0;
		if ( 'post_type' === $top->type && $top->object_id ) {
			$img = (int) get_post_thumbnail_id( (int) $top->object_id );
		}
		$children = array();
		foreach ( $byParent[ (int) $top->ID ] ?? array() as $c ) {
			$children[] = array(
				'label' => dl_menu_label( $c ),
				'to'    => $c->url,
			);
		}
		$out[] = array(
			'label' => dl_menu_label( $top ),
			'to'    => $top->url,
			'blurb' => $top->post_content,
			'img'   => $img,
			'items' => $children,
		);
	}
	return $out;
}
