<?php
/**
 * Entry point of every build step.
 *
 *   wp eval-file ~/chantier/dilytics/build.php setup contact … --user=1
 *   wp eval-file ~/chantier/dilytics/build.php all --user=1
 *
 * "setup" prepares the site, "metas" sets every page's title, description
 * and share image (metas.php), each other name rebuilds one page script from
 * pages/, "all" runs setup, every page, then metas.
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'FLBuilderModel' ) || ! function_exists( 'dl_img_id' ) ) {
	WP_CLI::error( 'Beaver Builder and the dilytics-modules plugin must be active.' );
}

require_once __DIR__ . '/build-helpers.php';

$steps = isset( $args ) && $args ? $args : array( 'all' );
if ( in_array( 'all', $steps, true ) ) {
	$steps = array_merge( array( 'setup' ), array_map( fn( $f ) => basename( $f, '.php' ), glob( __DIR__ . '/pages/*.php' ) ), array( 'metas' ) );
}

foreach ( $steps as $step ) {
	$file = in_array( $step, array( 'setup', 'metas' ), true ) ? __DIR__ . '/' . $step . '.php' : __DIR__ . '/pages/' . $step . '.php';
	if ( ! file_exists( $file ) ) {
		WP_CLI::error( "No build step named {$step}" );
	}
	dlb_log( "— {$step}" );
	require $file;
}

// Every compiled layout asset and the page cache go, so no page serves old CSS.
FLBuilderModel::delete_asset_cache_for_all_posts();
if ( function_exists( 'rocket_clean_minify' ) ) {
	rocket_clean_minify();
}
if ( function_exists( 'rocket_clean_domain' ) ) {
	rocket_clean_domain();
}
WP_CLI::success( 'Built: ' . implode( ', ', $steps ) );
