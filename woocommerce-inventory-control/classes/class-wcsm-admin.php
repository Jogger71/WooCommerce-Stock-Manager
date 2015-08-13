<?php

/**
 * WooCommerce Stock Management Admin Class
 * @since 1.0.0
 */

if ( !class_exists( 'WCSM_Admin' ) ) {
	class WCSM_Admin {

		public function __construct() {
			//  Add all the needed actions to create the admin pages
			add_action( 'admin_menu', array( $this, 'add_admin_menus' ) );
		}

		public function add_admin_menus() {
			add_menu_page(
				'Stock Overview',
				'WC Stock Manager',
				'manage_options',
				'wcsm-stocks',
				array( $this, 'wcsm_admin_overview' )
			);

			add_submenu_page(
				'wcsm-stocks',
				'Stock Overview',
				'Overview',
				'manage_options',
				'wcsm-stocks',
				array( $this, 'wcsm_admin_overview' )
			);

			add_submenu_page(
				'wcsm-stocks',
				'Update Stock',
				'Update Stock',
				'manage_options',
				'wcsm-update-stocks',
				array( $this, 'wcsm_admin_updates' )
			);

			add_submenu_page(
				'wcsm-stocks',
				'Stock Taking',
				'Stock Take',
				'manage_options',
				'wcsm-stock-take',
				array( $this, 'wcsm_admin_stock_take' )
			);
		}

		public function wcsm_admin_overview() {
			global $wc_inventory_control;
			include( $wc_inventory_control->get_plugin_path() . 'templates/pages/admin-overview.php' );
		}

		public function wcsm_admin_updates() {
			global $wc_inventory_control;
			include( $wc_inventory_control->get_plugin_path() . 'templates/pages/admin-updates.php' );
		}

		public function wcsm_admin_stock_take() {
			global $wc_inventory_control;
			include( $wc_inventory_control->get_plugin_path() . 'templates/pages/admin-stock-take.php' );
		}
	}
}