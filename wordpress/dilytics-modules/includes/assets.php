<?php
/**
 * Styles, scripts and <head>. The front end carries the Nuxt site's CSS and
 * nothing else: the theme's and WordPress's own front-end styles are removed,
 * so no rule reaches a page that the Nuxt site does not have.
 */

defined( 'ABSPATH' ) || exit;

/** Beaver Builder's editor is open on this request. */
function dl_editing() {
	return class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_active();
}

add_action(
	'wp_enqueue_scripts',
	function () {
		// the plugin version plus the file's own date: a changed sheet or script
		// always gets a new cache parameter, even between two version bumps
		$ver = function ( $file ) {
			return DL_VERSION . '.' . filemtime( DL_DIR . $file );
		};
		wp_enqueue_style( 'dl-base', DL_URL . 'assets/css/base.css', array(), $ver( 'assets/css/base.css' ) );
		wp_enqueue_style( 'dl-components', DL_URL . 'assets/css/components.css', array( 'dl-base' ), $ver( 'assets/css/components.css' ) );
		wp_enqueue_style( 'dl-wp', DL_URL . 'assets/css/wp.css', array( 'dl-components' ), $ver( 'assets/css/wp.css' ) );

		$footer = array(
			'in_footer' => true,
			'strategy'  => 'defer',
		);
		wp_enqueue_script( 'dl-gsap', DL_URL . 'assets/js/vendor/gsap.min.js', array(), '3.15.0', $footer );
		wp_enqueue_script( 'dl-scrolltrigger', DL_URL . 'assets/js/vendor/ScrollTrigger.min.js', array( 'dl-gsap' ), '3.15.0', $footer );
		wp_enqueue_script( 'dl-lenis', DL_URL . 'assets/js/vendor/lenis.min.js', array(), '1.3.26', $footer );
		wp_enqueue_script( 'dl-site', DL_URL . 'assets/js/site.js', array( 'dl-gsap', 'dl-scrolltrigger', 'dl-lenis' ), $ver( 'assets/js/site.js' ), $footer );

		// In the editor the page must stay still and whole: no smooth scroll,
		// no entrances, every section visible as it is rendered.
		if ( dl_editing() ) {
			wp_add_inline_script( 'dl-site', 'window.DLEditing=true;', 'before' );
		}
	},
	20
);

// Theme, block library and global styles off the front end. Kept: the site's
// own sheets, Beaver Builder's layout sheets and the admin bar. In the editor
// Beaver Builder needs more (icons, UI), so there only the theme's and the
// block library's styles go. Done right before printing: the theme enqueues
// its skin late.
add_action(
	'wp_print_styles',
	function () {
		if ( is_admin() ) {
			return;
		}
		$theme = array( 'fl-automator-skin', 'base', 'base-4', 'bootstrap', 'bootstrap-4', 'child-style', 'wp-block-library', 'wp-block-library-theme', 'classic-theme-styles', 'global-styles', 'core-block-supports', 'wp-img-auto-sizes-contain', 'jquery-magnificpopup' );
		foreach ( wp_styles()->queue as $handle ) {
			$ours = 0 === strpos( $handle, 'dl-' ) || 0 === strpos( $handle, 'fl-builder' ) || 0 === strpos( $handle, 'fl-theme-builder' ) || in_array( $handle, array( 'admin-bar', 'dashicons' ), true );
			if ( $ours ) {
				continue;
			}
			if ( dl_editing() && ! in_array( $handle, $theme, true ) ) {
				continue;
			}
			wp_dequeue_style( $handle );
		}
	},
	1
);

// The theme's script handles its own header and anchor scrolling; Lenis and
// the plugin own both here.
add_action(
	'wp_print_scripts',
	function () {
		if ( ! is_admin() && ! dl_editing() ) {
			wp_dequeue_script( 'fl-automator' );
		}
	},
	1
);

// The pre-paint guard, word for word the Nuxt head script: the first screen
// never flashes its content before the entrances take hold, and a timer drops
// the guard whatever happens.
add_action(
	'wp_head',
	function () {
		if ( dl_editing() ) {
			return;
		}
		echo "<script>var d=document.documentElement;d.classList.add('mo');setTimeout(function(){d.classList.remove('mo')},2200)</script>\n";
	},
	1
);

add_action(
	'wp_head',
	function () {
		echo '<meta name="theme-color" content="#f6f5f2">' . "\n";
		echo '<link rel="icon" href="' . esc_url( DL_URL . 'assets/img/favicon.ico' ) . '" sizes="48x48">' . "\n";
		echo '<link rel="icon" href="' . esc_url( DL_URL . 'assets/img/favicon.png' ) . '" type="image/png" sizes="512x512">' . "\n";
		echo '<link rel="apple-touch-icon" href="' . esc_url( DL_URL . 'assets/img/apple-touch-icon.png' ) . '">' . "\n";

		$id = get_queried_object_id();
		if ( $id ) {
			$desc = get_post_meta( $id, '_dl_description', true );
			if ( $desc ) {
				echo '<meta name="description" content="' . esc_attr( $desc ) . '">' . "\n";
			}
			if ( get_post_meta( $id, '_dl_noindex', true ) ) {
				echo '<meta name="robots" content="noindex, nofollow">' . "\n";
			}
		}
	},
	2
);

// The page titles of the Nuxt site, stored per page by the build script.
add_filter(
	'pre_get_document_title',
	function ( $title ) {
		$id = get_queried_object_id();
		$t  = $id ? get_post_meta( $id, '_dl_title', true ) : '';
		return $t ? $t : $title;
	},
	99
);

// Full page: a Beaver Builder page is served by the plugin's own template, so
// no theme container or post title ever wraps the sections. A template chosen
// by hand in the page settings still wins.
add_filter(
	'template_include',
	function ( $template ) {
		if ( is_page() && ! is_page_template() && class_exists( 'FLBuilderModel' ) && FLBuilderModel::is_builder_enabled() ) {
			return DL_DIR . 'templates/page.php';
		}
		return $template;
	},
	99
);

// The Nuxt <body> carries no class. WordPress adds its own, and some are
// names the Nuxt CSS styles: `page`, on every page, would get `.page`
// (max-width 1240px) and narrow the whole site. Those are removed.
add_filter(
	'body_class',
	function ( $classes ) {
		static $styled = null;
		if ( null === $styled ) {
			$styled = array_flip( (array) json_decode( (string) file_get_contents( DL_DIR . 'assets/css/classes.json' ), true ) );
		}
		return array_values(
			array_filter(
				$classes,
				function ( $c ) use ( $styled ) {
					return ! isset( $styled[ $c ] );
				}
			)
		);
	},
	99
);

// <html lang="fr">, as on the Nuxt site.
add_filter(
	'language_attributes',
	function () {
		return 'lang="fr"';
	}
);

// No emoji script, no site icon from WordPress: the plugin prints its own icons.
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'wp_site_icon', 99 );
