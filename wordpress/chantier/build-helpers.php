<?php
/**
 * Shared by every build script. Run through wp eval-file, never loaded by the site.
 *
 * Every page is rebuilt from scratch on each run: delete both layouts, add one
 * full-width row per section, one module per row, then copy the published
 * layout into the draft so the editor never reopens a stale version.
 */

defined( 'ABSPATH' ) || exit;

/** The Nuxt content, exported by wordpress/tools/export-content.mjs. */
function dlb_content() {
	static $c = null;
	if ( null === $c ) {
		$c = json_decode( file_get_contents( __DIR__ . '/data/content.json' ), true );
	}
	return $c;
}

function dlb_log( $msg ) {
	if ( class_exists( 'WP_CLI' ) ) {
		WP_CLI::log( $msg );
	} else {
		echo $msg . "\n";
	}
}

/** A page by its slug, created when missing. */
function dlb_page( $slug, $title = null ) {
	$p = get_page_by_path( $slug, OBJECT, 'page' );
	if ( $p ) {
		if ( $title && $p->post_title !== $title ) {
			wp_update_post(
				array(
					'ID'         => $p->ID,
					'post_title' => $title,
				)
			);
		}
		if ( 'publish' !== $p->post_status ) {
			wp_update_post(
				array(
					'ID'          => $p->ID,
					'post_status' => 'publish',
				)
			);
		}
		return (int) $p->ID;
	}
	return (int) wp_insert_post(
		array(
			'post_type'    => 'page',
			'post_status'  => 'publish',
			'post_title'   => $title ? $title : $slug,
			'post_name'    => $slug,
			'post_content' => '',
			'post_author'  => 1,
		)
	);
}

/** An imported picture by its Nuxt name: [ id, url ]. */
function dlb_media( $name ) {
	$id = dl_img_id( $name );
	if ( ! $id ) {
		WP_CLI::error( "Picture missing from the media library: {$name}" );
	}
	return array(
		'id'  => $id,
		'url' => dl_img_url( $id ),
	);
}

/** Photo field settings: the attachment and its URL, as Beaver Builder stores them. */
function dlb_photo( $key, $name ) {
	$m = dlb_media( $name );
	return array(
		$key          => $m['id'],
		$key . '_src' => $m['url'],
	);
}

/**
 * Title, description, share image (a Nuxt picture name) and indexing of a
 * page, read by the plugin's <head>. Set by metas.php only.
 */
function dlb_meta( $post_id, $title, $desc = '', $noindex = false, $img = '' ) {
	update_post_meta( $post_id, '_dl_title', $title );
	$desc ? update_post_meta( $post_id, '_dl_description', $desc ) : delete_post_meta( $post_id, '_dl_description' );
	$noindex ? update_post_meta( $post_id, '_dl_noindex', 1 ) : delete_post_meta( $post_id, '_dl_noindex' );
	$img ? update_post_meta( $post_id, '_dl_image', dlb_media( $img )['id'] ) : delete_post_meta( $post_id, '_dl_image' );
}

/**
 * A page title of 60 characters at most, what Google shows before cutting:
 * the long form of the site's titles, or a shorter suffix for a long heading.
 */
function dlb_title( $heading ) {
	$full = $heading . ' · Dilytics, fiduciaire à Genève';
	return mb_strlen( $full ) <= 60 ? $full : $heading . ' · Dilytics Genève';
}

/**
 * A meta description: whole sentences of the page's own text, 160
 * characters at most, never cut in the middle of a sentence. A first
 * sentence longer than that is kept whole and reported.
 */
function dlb_desc( $text, $max = 160 ) {
	$text = trim( preg_replace( '/\s+/u', ' ', wp_strip_all_tags( $text ) ) );
	$out  = '';
	foreach ( preg_split( '/(?<=[.!?])\s+/u', $text ) as $sentence ) {
		$next = '' === $out ? $sentence : $out . ' ' . $sentence;
		if ( '' !== $out && mb_strlen( $next ) > $max ) {
			break;
		}
		$out = $next;
	}
	if ( mb_strlen( $out ) > $max ) {
		dlb_log( '  ! description of ' . mb_strlen( $out ) . ' characters: ' . $out );
	}
	return $out;
}

/**
 * The scope class of the Vue page being built. Vue gives the root of a child
 * component the parent's scope, so the page's own rules reach it: on the
 * service pages, [slug].vue's `.ask` (meant for the rail) also styles
 * AskBlock's root. The modules that are child components of a page therefore
 * get the page's scope class on their root too. Reset by dlb_start().
 */
function dlb_scope( $scope = null ) {
	static $s = '';
	if ( null !== $scope ) {
		$s = $scope;
	}
	return $s;
}

/** The modules that are components used by a page, not sections of it. */
const DLB_CHILDREN = array( 'dl-ask', 'dl-cta', 'dl-cross', 'dl-price' );

/** Start a layout from nothing. */
function dlb_start( $post_id ) {
	dlb_scope( '' );
	FLBuilderModel::set_post_id( $post_id );
	FLBuilderModel::delete_layout_data( 'draft', $post_id );
	FLBuilderModel::delete_layout_data( 'published', $post_id );
	update_post_meta( $post_id, '_fl_builder_enabled', true );
	// the theme's page templates would only add wrappers: the default one it is
	delete_post_meta( $post_id, '_wp_page_template' );
}

/**
 * A full-width row with one column and no padding or margin: the section's
 * own CSS, ported from Nuxt, owns every spacing. Returns the column's id.
 */
function dlb_row() {
	$row  = FLBuilderModel::add_row( '1-col' );
	$data = FLBuilderModel::get_layout_data();
	$s    = $data[ $row->node ]->settings;
	$s->width         = 'full';
	$s->content_width = 'full';
	foreach ( array( 'top', 'right', 'bottom', 'left' ) as $side ) {
		$s->{'padding_' . $side} = '0';
		$s->{'margin_' . $side}  = '0';
	}
	$data[ $row->node ]->settings = $s;
	FLBuilderModel::update_layout_data( $data );

	$cols = FLBuilderModel::get_nodes( 'column', $row->node );
	if ( ! $cols ) {
		foreach ( FLBuilderModel::get_nodes( 'column-group', $row->node ) as $g ) {
			$cols = FLBuilderModel::get_nodes( 'column', $g->node );
		}
	}
	$col = array_shift( $cols );
	return $col->node;
}

/** One section: a row and its module, settings merged over the module's defaults. */
function dlb_add( $type, array $settings ) {
	if ( dlb_scope() && in_array( $type, DLB_CHILDREN, true ) ) {
		$settings['class'] = trim( ( $settings['class'] ?? '' ) . ' ' . dlb_scope() );
	}
	$col      = dlb_row();
	$defaults = (array) FLBuilderModel::get_module_defaults( $type );
	$merged   = (object) array_merge( $defaults, dlb_objects( $settings ) );
	$module   = FLBuilderModel::add_module( $type, $merged, $col );
	if ( ! $module ) {
		WP_CLI::error( "Unknown module: {$type}" );
	}
	return $module;
}

/** Repeater items are objects in Beaver Builder's data. */
function dlb_objects( array $settings ) {
	foreach ( $settings as $k => $v ) {
		if ( is_array( $v ) && array_is_list( $v ) && $v && is_array( $v[0] ) ) {
			$settings[ $k ] = array_map(
				function ( $it ) {
					return (object) $it;
				},
				$v
			);
		}
	}
	return $settings;
}

/**
 * Publish: the published layout is copied into the draft (otherwise the
 * editor reopens an old draft and republishes it on the first save), the
 * page's compiled assets are purged.
 */
function dlb_finish( $post_id ) {
	$data = FLBuilderModel::get_layout_data( 'published', $post_id );
	FLBuilderModel::update_layout_data( $data, 'draft', $post_id );
	FLBuilderModel::delete_all_asset_cache( $post_id );
	wp_update_post(
		array(
			'ID'          => $post_id,
			'post_status' => 'publish',
		)
	);
	dlb_log( sprintf( '  %s  %d sections', get_permalink( $post_id ), count( FLBuilderModel::get_nodes( 'module', null, 'published' ) ) ) );
}

/**
 * SiteCta.vue with its Nuxt defaults; $o overrides them, as the pages pass
 * :title, :text or :action to the component.
 */
function dlb_cta( array $o = array() ) {
	return dlb_add(
		'dl-cta',
		array_merge(
			array(
				'lines' => dlb_lines( array( 'Parlons de', 'votre situation.' ) ),
				'text'  => 'Réservez un entretien de quinze minutes, gratuit, par téléphone ou en visioconférence. Vous saurez si notre fiduciaire peut vous aider.',
				'label' => '',
				'to'    => '',
			),
			dlb_photo( 'img', 'cta' ),
			$o
		)
	);
}

/** AskBlock.vue, word for word. */
function dlb_ask() {
	return dlb_add(
		'dl-ask',
		array(
			'title'  => 'Des questions ?',
			'text'   => 'Écrivez-nous pour nous communiquer vos besoins ou vos questions. Notre équipe répond à tous les messages.',
			'hours'  => 'Nous sommes aussi joignables au téléphone du lundi au vendredi, de 9h à 12h et de 13h à 18h.',
			'button' => 'Envoyer',
			'done_t' => 'Merci',
			'done_d' => 'Nous avons bien reçu votre message : notre équipe répond à tous les messages.',
			'again'  => 'Écrire un autre message',
		)
	);
}

/** Lines of text as a textarea value. */
function dlb_lines( array $lines ) {
	return implode( "\n", $lines );
}

/** Paragraphs as a textarea value, separated by a blank line. */
function dlb_paras( array $paras ) {
	return implode( "\n\n", $paras );
}
