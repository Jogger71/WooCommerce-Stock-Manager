<?php

/**
 * WooCommerce Stock Management Admin Class
 * @since 1.0.0
 */

if ( ! class_exists( 'WCSM_Admin' ) ) {
	class WCSM_Admin {
		/**
		 * Instance of the class
		 *
		 * @var WCSM_Admin $instance
		 * @since 0.3.0
		 */
		private static $instance;

		public function __construct() {
			//  Add all the needed actions to create the admin pages
			add_action( 'admin_menu', array ( $this, 'add_admin_menus' ) );
		}

		/**
		 * Returns the instance of the class
		 *
		 * @return WCSM_Admin
		 * @since 0.3.0
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) && ! self::$instance instanceof WCSM_Admin ) {
				self::$instance = new WCSM_Admin();
			}

			return self::$instance;
		}

		public function add_admin_menus() {
			add_menu_page(
				'Stock Overview',
				'WC Stock Manager',
				'manage_options',
				'wcsm-stocks',
				array ( $this, 'wcsm_admin_overview' )
			);

			add_submenu_page(
				'wcsm-stocks',
				'Stock Overview',
				'Overview',
				'manage_options',
				'wcsm-stocks',
				array ( $this, 'wcsm_admin_overview' )
			);

			add_submenu_page(
				'wcsm-stocks',
				'Update Stock',
				'Update Stock',
				'manage_options',
				'wcsm-update-stocks',
				array ( $this, 'wcsm_admin_updates' )
			);

			add_submenu_page(
				'wcsm-stocks',
				'Stock Set Points',
				'Set Points',
				'manage_options',
				'wcsm-stock-set-points',
				array ( $this, 'wcsm_admin_set_points' )
			);
		}

		public function wcsm_admin_overview() {
			include( WSS_PLUGIN_LOCATION . '/templates/pages/admin-overview.php' );
		}

		public function wcsm_admin_updates() {
			include( WSS_PLUGIN_LOCATION . '/templates/pages/admin-updates.php' );
		}

		public function wcsm_admin_set_points() {
			include( WSS_PLUGIN_LOCATION . '/templates/pages/admin-stock-set-points.php' );
		}
	}
}

function wcsm_admin() {
	return WCSM_Admin::get_instance();
}

wcsm_admin();