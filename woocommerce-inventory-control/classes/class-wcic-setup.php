<?php

/**
 * Setup class that loads everything in the plugin
 *
 * @since 0.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Cheaters Detected!' );
}

if ( ! class_exists( 'WCIC_Setup' ) ) {
	class WCIC_Setup {
		/**
		 * Instance of the class
		 *
		 * @var WCIC_Setup $instance
		 * @since 0.3.0
		 */
		private static $instance;

		/**
		 * Class constructor
		 */
		private function __construct() {

		}

		/**
		 * Gets the instance of the class
		 *
		 * @return WCIC_Setup
		 * @since 0.3.0
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) && ! self::$instance instanceof WCIC_Setup ) {
				self::$instance = new WCIC_Setup();
			}

			return self::$instance;
		}

		/**
		 * Sets up the constants required in the plugin
		 *
		 * @param string $plugin_location
		 * @since 0.3.0
		 */
		public function define_constants( $plugin_location, $plugin_uri ) {
			define( 'WSS_PLUGIN_LOCATION', $plugin_location );
			define( 'WSS_PLUGIN_CLASSES_DIR', WSS_PLUGIN_LOCATION . '/classes' );

			define( 'WSS_PLUGIN_URI', $plugin_uri );
			define( 'WSS_PLUGIN_ASSETS_URI', WSS_PLUGIN_URI . '/assets' );
		}

		/**
		 * Includes all the required class files
		 *
		 * @since 0.3.0
		 */
		public function includes() {
			include_once( WSS_PLUGIN_LOCATION . '/global-functions.php' );
			include_once( WSS_PLUGIN_CLASSES_DIR . '/class-wcsm-admin.php' );
			include_once( WSS_PLUGIN_CLASSES_DIR . '/class-wss-product-handling.php' );
			include_once( WSS_PLUGIN_CLASSES_DIR . '/class-wss-product.php' );
			include_once( WSS_PLUGIN_CLASSES_DIR . '/class-wss-stock-report.php' );
		}
	}
}

function wcic_setup() {
	return WCIC_Setup::get_instance();
}

wcic_setup();