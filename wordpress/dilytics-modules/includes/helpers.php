<?php
/**
 * Reading settings, contact details, images and links.
 */

defined( 'ABSPATH' ) || exit;

/**
 * One setting of a module, or the default when it is missing or empty.
 * Empty means "not set": an optional field never poses an empty value.
 */
function dl_s( $settings, $key, $default = '' ) {
	$v = is_object( $settings ) ? ( $settings->$key ?? null ) : ( $settings[ $key ] ?? null );
	return ( null === $v || '' === $v ) ? $default : $v;
}

/**
 * Repeater items as objects. An unfilled repeater arrives with one empty
 * entry: empty items are dropped so no ghost row or column is rendered.
 */
function dl_items( $v ) {
	if ( is_string( $v ) ) {
		$d = json_decode( $v );
		$v = is_array( $d ) ? $d : array();
	}
	if ( ! is_array( $v ) ) {
		return array();
	}
	$out = array();
	foreach ( $v as $it ) {
		if ( is_string( $it ) ) {
			$d  = json_decode( $it );
			$it = is_object( $d ) ? $d : (object) array( 'v' => $it );
		}
		$it   = (object) $it;
		$full = array_filter(
			(array) $it,
			function ( $x ) {
				return '' !== $x && null !== $x && array() !== $x;
			}
		);
		if ( $full ) {
			$out[] = $it;
		}
	}
	return $out;
}

/** Non-empty lines of a textarea. */
function dl_lines( $v ) {
	$lines = preg_split( '/\r\n|\n|\r/', (string) $v );
	return array_values( array_filter( array_map( 'trim', $lines ), 'strlen' ) );
}

/** Paragraphs of a textarea, separated by a blank line. */
function dl_paras( $v ) {
	$parts = preg_split( '/\n\s*\n/', str_replace( "\r", '', (string) $v ) );
	return array_values( array_filter( array_map( 'trim', $parts ), 'strlen' ) );
}

/** Escaped text; markup a field is allowed to carry (a <br />, a red span). */
function dl_t( $v ) {
	return esc_html( (string) $v );
}
function dl_h( $v ) {
	return wp_kses_post( (string) $v );
}

/**
 * The cabinet's contact details, written by the build script from the Nuxt
 * content (CONTACT in app/content/site.js).
 */
function dl_contact( $key = null ) {
	static $c = null;
	if ( null === $c ) {
		$c = (array) get_option( 'dl_contact', array() );
	}
	return null === $key ? $c : ( $c[ $key ] ?? '' );
}

/** Years of experience, counted from the founding like the Nuxt site does. */
function dl_years() {
	return (int) wp_date( 'Y' ) - (int) dl_contact( 'since' );
}

/**
 * Internal paths resolve against the site address, so a change of domain
 * never breaks a link; anything else is kept as it is.
 */
function dl_url( $v ) {
	$v = (string) $v;
	if ( '' === $v ) {
		return '';
	}
	if ( ctype_digit( $v ) ) {
		return (string) get_permalink( (int) $v );
	}
	if ( '/' === $v[0] ) {
		return home_url( $v );
	}
	return $v;
}

/** True when the link points at the page being shown. */
function dl_is_current( $v ) {
	$path = wp_parse_url( dl_url( $v ), PHP_URL_PATH );
	$here = wp_parse_url( home_url( add_query_arg( array() ) ), PHP_URL_PATH );
	return $path && trailingslashit( $path ) === trailingslashit( (string) $here );
}

/* -------------------------------------------------------------- images */

/** Attachment of a Nuxt image name: the media carry the slug dl-<name>. */
function dl_img_id( $name ) {
	static $cache = array();
	if ( empty( $cache[ $name ] ) ) {
		// only a found picture is remembered: one imported later is still found
		$q              = get_posts(
			array(
				'post_type'      => 'attachment',
				'name'           => 'dl-' . $name,
				'post_status'    => 'inherit',
				'posts_per_page' => 1,
				'fields'         => 'ids',
			)
		);
		$cache[ $name ] = $q ? (int) $q[0] : 0;
	}
	return $cache[ $name ];
}

/**
 * The original file, as the Nuxt site serves it: a picture wider than 2560px
 * is kept by WordPress as a "-scaled" copy, which is not what Nuxt shows.
 */
function dl_img_url( $id ) {
	if ( ! $id ) {
		return '';
	}
	$url = wp_get_original_image_url( (int) $id );
	return (string) ( $url ? $url : wp_get_attachment_url( (int) $id ) );
}

/** A photo field: the attachment first, the stored URL as a fallback. */
function dl_photo( $settings, $key ) {
	$url = dl_img_url( dl_s( $settings, $key ) );
	return $url ? $url : (string) dl_s( $settings, $key . '_src' );
}

/** The Nuxt name of an attachment ('dl-meet' → 'meet'): the key of the photo notes. */
function dl_img_name( $id ) {
	$p = $id ? get_post( (int) $id ) : null;
	return $p ? preg_replace( '/^dl-/', '', $p->post_name ) : '';
}

/* -------------------------------------------------------------- photo notes */

/**
 * The registry of the pictures Dilytics asked to replace (app/content/photos.js),
 * written by the build script. NOTES off removes every note at once.
 */
function dl_photos() {
	static $p = null;
	if ( null === $p ) {
		$p = (array) get_option( 'dl_photos', array() );
	}
	return $p;
}
function dl_photo_entry( $name ) {
	$p = dl_photos();
	if ( empty( $p['NOTES'] ) || ! $name ) {
		return null;
	}
	return $p['PHOTOS'][ $name ] ?? null;
}

/* -------------------------------------------------------------- module root */

/**
 * The attributes of a module's root element: Beaver Builder's own (node id,
 * classes) merged with the section's classes, so the section itself is the
 * module and no wrapper sits between it and the page.
 */
function dl_root( $module, array $classes, array $attrs = array() ) {
	$attrs['class'] = $classes;
	// Beaver Builder puts a clearfix (::before, ::after, display: table) on
	// every module except those carrying data-accepts, which its editor adds
	// anyway. Without it, the clearfix would overwrite a section's own
	// ::before (the .band hairline) and add two items to a flex or grid root.
	// An empty value is skipped when printed, hence a word; the editor sets its own.
	$attrs['data-accepts'] = 'no';
	$module->render_attributes( $attrs );
}

// Beaver Builder names a <section> or <footer> module after the module
// (aria-label="Contact : ouverture"); the Nuxt sections carry no such label.
add_filter(
	'fl_builder_module_attributes',
	function ( $attrs, $module ) {
		if ( 0 === strpos( (string) $module->slug, 'dl-' ) ) {
			unset( $attrs['aria-label'] );
		}
		return $attrs;
	},
	10,
	2
);

/** Attributes as a string, values escaped; true renders a bare attribute. */
function dl_attrs( array $attrs ) {
	$out = '';
	foreach ( $attrs as $k => $v ) {
		if ( null === $v || false === $v ) {
			continue;
		}
		$out .= true === $v ? ' ' . $k : ' ' . $k . '="' . esc_attr( (string) $v ) . '"';
	}
	return $out;
}

/** A reveal as the Nuxt v-rv directive renders it: data-rv, data-rvd. */
function dl_rv( $mode = 'up', $delay = null ) {
	return dl_attrs(
		array(
			'data-rv'  => $mode,
			'data-rvd' => null === $delay ? null : (string) $delay,
		)
	);
}
