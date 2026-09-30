<?php
/**
 * Plugin Name: Dilytics, modules
 * Description: Modules Beaver Builder du site Dilytics, portés du site Nuxt : mêmes sections, même HTML, même CSS, mêmes animations.
 * Version:     1.0.0
 * Author:      BB
 * Text Domain: dilytics
 * Requires PHP: 8.2
 */

defined( 'ABSPATH' ) || exit;

// Bump on every CSS or JS change: it is the cache parameter of the assets.
define( 'DL_VERSION', '1.0.0' );
define( 'DL_DIR', plugin_dir_path( __FILE__ ) );
define( 'DL_URL', plugin_dir_url( __FILE__ ) );

require DL_DIR . 'includes/helpers.php';
require DL_DIR . 'includes/partials.php';
require DL_DIR . 'includes/assets.php';
require DL_DIR . 'includes/menus.php';
require DL_DIR . 'includes/schema.php';
require DL_DIR . 'includes/stripe.php';
require DL_DIR . 'includes/contact.php';

// Modules load once Beaver Builder has loaded its own, on init at priority 2
// (FLBuilderModel::load_modules): 2.11 no longer fires fl_builder_loaded.
// One manual loader, no fl_builder_load_modules_paths.
add_action(
	'init',
	function () {
		if ( ! class_exists( 'FLBuilder' ) ) {
			return;
		}
		require DL_DIR . 'includes/forms.php';
		foreach ( glob( DL_DIR . 'modules/*/*.php' ) as $file ) {
			if ( basename( $file, '.php' ) === basename( dirname( $file ) ) ) {
				require_once $file;
			}
		}
	},
	5
);
