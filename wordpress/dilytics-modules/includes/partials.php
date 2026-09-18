<?php
/**
 * The Nuxt site's small shared components, rendered to the same markup.
 * A component with scoped styles carries its scope class (v-…) on its root:
 * see wordpress/tools/compile-css.mjs.
 */

defined( 'ABSPATH' ) || exit;

/** Ar.vue: the arrow that follows a link or a button label. */
function dl_ar() {
	return '<svg class="ar" width="15" height="15" viewBox="0 0 16 16" fill="none" aria-hidden="true"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"></path></svg>';
}

/** Ax.vue: a hairline that draws itself across as it comes into view. */
function dl_ax() {
	return '<div data-rv="rule" class="rule"></div>';
}

/** Logo.vue: the wordmark, inline so it takes the colour of its link. */
function dl_logo() {
	static $svg = null;
	if ( null === $svg ) {
		$svg = trim( (string) file_get_contents( DL_DIR . 'assets/img/logo.svg' ) );
	}
	return '<span class="lg v-logo">' . $svg . '</span>';
}

/** Ico.vue: the plain stroke set beside named benefits. */
function dl_ico( $name ) {
	$paths = array(
		'tag'    => '<path d="M3 12.5V4a1 1 0 0 1 1-1h8.5L21 11.5 12.5 20 3 12.5Z"></path><circle cx="7.5" cy="7.5" r="1.4"></circle>',
		'screen' => '<rect x="2.5" y="4" width="19" height="13" rx="1.8"></rect><path d="M8.5 21h7M12 17v4M6.5 12.5l3-3 2.5 2.5 4-4.5"></path>',
		'talk'   => '<path d="M20.5 12.5a7.5 7.5 0 0 1-10.9 6.7L4 20.5l1.4-5A7.5 7.5 0 1 1 20.5 12.5Z"></path><path d="M9 11h6M9 14.5h3.5"></path>',
		'coin'   => '<ellipse cx="12" cy="6.5" rx="7.5" ry="3"></ellipse><path d="M4.5 6.5v11c0 1.7 3.4 3 7.5 3s7.5-1.3 7.5-3v-11M4.5 12c0 1.7 3.4 3 7.5 3s7.5-1.3 7.5-3"></path>',
		'clock'  => '<circle cx="12" cy="12" r="8.5"></circle><path d="M12 7v5.2l3.2 2"></path>',
		'shield' => '<path d="M12 3 4.5 6v6c0 4.4 3.1 7.9 7.5 9 4.4-1.1 7.5-4.6 7.5-9V6L12 3Z"></path><path d="M9 12l2.2 2.2L15.5 10"></path>',
		'pin'    => '<path d="M12 21s7-5.4 7-11a7 7 0 1 0-14 0c0 5.6 7 11 7 11Z"></path><circle cx="12" cy="10" r="2.6"></circle>',
		'doc'    => '<path d="M14 3H7a1.5 1.5 0 0 0-1.5 1.5v15A1.5 1.5 0 0 0 7 21h10a1.5 1.5 0 0 0 1.5-1.5V7.5L14 3Z"></path><path d="M13.5 3.2V8h4.8M9 12.5h6M9 16h4"></path>',
		'users'  => '<circle cx="9.5" cy="8.5" r="3.2"></circle><path d="M3.5 20a6 6 0 0 1 12 0M16.5 5.6a3.2 3.2 0 0 1 0 5.9M18 20a6 6 0 0 0-2.2-4.6"></path>',
		'chart'  => '<path d="M4 20V9.5M10 20V4.5M16 20v-7M22 20H2"></path>',
	);
	$inner = $paths[ $name ] ?? '<circle cx="12" cy="12" r="8.5"></circle><path d="M8.5 12.2l2.4 2.4 4.6-5"></path>';
	return '<svg class="ico v-ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' . $inner . '</svg>';
}

/**
 * Head3.vue: a display headline, each line clipped and rising into place.
 * mode 'load' for a headline already on screen, 'scroll' further down.
 */
function dl_head3( array $lines, array $o = array() ) {
	$o     = array_merge(
		array(
			'cls'    => 'd1',
			'accent' => -1,
			'as'     => 'h1',
			'mode'   => 'load',
			'delay'  => 0.1,
		),
		$o
	);
	$tag   = tag_escape( $o['as'] );
	$html  = '<' . $tag . ' class="' . esc_attr( $o['cls'] ) . ' hd v-head3" data-hd';
	$html .= dl_attrs(
		array(
			'data-mode'  => $o['mode'],
			'data-delay' => (string) $o['delay'],
		)
	) . '>';
	foreach ( array_values( $lines ) as $i => $l ) {
		$cls   = (int) $o['accent'] === $i ? ' class="ac"' : '';
		$html .= '<span class="ln"><i' . $cls . '>' . esc_html( $l ) . '</i></span>';
	}
	return $html . '</' . $tag . '>';
}

/**
 * PhotoNote.vue: the red marker on a stock picture a real photograph must
 * replace. Nothing for a picture that is not listed, nothing once NOTES is off.
 */
function dl_photo_note( $name, array $o = array() ) {
	$e = dl_photo_entry( $name );
	if ( ! $e ) {
		return '';
	}
	$o    = array_merge(
		array(
			'compact' => false,
			'at'      => 'bl',
			'frame'   => true,
		),
		$o
	);
	$html = $o['frame'] ? '<span class="pnf v-photo-note" aria-hidden="true"></span>' : '';
	$cls  = 'pn ' . $o['at'] . ( $o['compact'] ? ' c' : '' ) . ' v-photo-note';
	$html .= '<span class="' . esc_attr( $cls ) . '"><strong>' . ( $o['compact'] ? 'À remplacer' : 'Photo réelle à fournir' ) . '</strong>';
	if ( ! $o['compact'] ) {
		$html .= '<span>' . esc_html( $e['brief'] ?? '' ) . '</span>';
	}
	return $html . '</span>';
}

/**
 * Pending.vue: content the site is still waiting for, marked in the same red
 * as the photo notes. $attrs lands on the root, as a parent's v-rv does.
 */
function dl_pending( $label, $hint = '', array $o = array(), array $attrs = array() ) {
	$photo = ! empty( $o['photo'] );
	$dark  = ! empty( $o['dark'] );
	$cls   = 'pd' . ( $photo ? ' ph' : '' ) . ( $dark ? ' dk' : '' ) . ' v-pending';
	$html  = '<div class="' . $cls . '"' . dl_attrs( $attrs ) . '>';
	if ( $photo ) {
		$html .= '<svg class="cam" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M3 8.5A1.5 1.5 0 0 1 4.5 7h2.3l1.6-2.2h7.2L17.2 7h2.3A1.5 1.5 0 0 1 21 8.5v9a1.5 1.5 0 0 1-1.5 1.5h-15A1.5 1.5 0 0 1 3 17.5v-9Z"></path><circle cx="12" cy="13" r="3.6"></circle></svg>';
	}
	$html .= '<strong>' . esc_html( $label ) . '</strong>';
	if ( '' !== (string) $hint ) {
		$html .= '<span>' . esc_html( $hint ) . '</span>';
	}
	return $html . '</div>';
}

/** Counter.vue: the real figure, counted up from zero once in view. */
function dl_counter( $to ) {
	return '<span data-counter="' . esc_attr( (string) (int) $to ) . '">' . (int) $to . '</span>';
}

/**
 * ServiceList.vue: rows with a navy fill on hover and the neighbours dimmed.
 * $items: [ [ 't' => …, 'd' => …, 'to' => path ] ].
 */
function dl_service_list( array $items ) {
	$html = '<div class="stage v-service-list"><ul class="rows" data-stagger>';
	foreach ( $items as $r ) {
		$r     = (object) $r;
		$html .= '<li><a href="' . esc_url( dl_url( $r->to ?? '' ) ) . '">';
		$html .= '<span class="fill" aria-hidden="true"></span>';
		$html .= '<span class="nm">' . esc_html( $r->t ?? '' ) . '</span>';
		$html .= '<span class="dc">' . esc_html( $r->d ?? '' ) . '</span>';
		$html .= '<span class="arw" aria-hidden="true"><svg viewBox="0 0 46 12" fill="none"><path class="shaft" d="M0 6h38" stroke="currentColor" stroke-width="1.6"></path><path class="head" d="M34 1.5 39.5 6 34 10.5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path></svg></span>';
		$html .= '</a></li>';
	}
	return $html . '</ul></div>';
}

/**
 * A crumb trail as the pages render it: Accueil · … · current.
 * 'label' adds the nav's aria-label, 'hidden' hides the dots from readers:
 * the Nuxt pages differ on both, and each keeps its own markup.
 */
function dl_crumb( $current, $parent = null, array $o = array() ) {
	$cls   = $o['class'] ?? 'crumb';
	$here  = $o['here'] ?? 'cur';
	$sep   = ! empty( $o['hidden'] ) ? '<span aria-hidden="true">·</span>' : '<span>·</span>';
	$html  = '<nav class="' . esc_attr( $cls ) . '"' . ( ! empty( $o['label'] ) ? ' aria-label="Fil d\'ariane"' : '' ) . '>';
	$html .= '<a href="' . esc_url( home_url( '/' ) ) . '">Accueil</a>' . $sep;
	if ( $parent ) {
		$html .= '<a href="' . esc_url( dl_url( $parent['to'] ) ) . '">' . esc_html( $parent['label'] ) . '</a>' . $sep;
	}
	return $html . '<span class="' . esc_attr( $here ) . '">' . esc_html( $current ) . '</span></nav>';
}
