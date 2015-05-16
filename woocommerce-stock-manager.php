<?php

/**
 * Plugin Name: WooCommerce Stock Manager
 * Author: Graphite Programming
 * Author URI: http://www.graphiteprogramming.com/
 *
 * Description: A system purely dedicated to stock management in woocommerce.
 *
 * Version: 0.0.0
 * Release: DEVELOPMENT
 */

if ( !defined ( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'WC_Stock_Manager' ) ) {
	class WC_Stock_Manager {
		/**
		 *
		 */

		public function __construct() {

		}
	}
}

$GLOBALS['wc_stock_manager'] = new WC_Stock_Manager();