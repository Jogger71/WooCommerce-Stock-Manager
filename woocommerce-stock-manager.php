<?php

/**
 * Plugin Name: WooCommerce Stock Manager
 * Author: Plugin Gateway
 * Author URI: http://www.plugingateway.com/
 *
 * Description: Easily manage and control the stock of your woocommerce store. Create and automatically send purchase orders to your suppliers.
 *
 * Version: 0.0.0.000
 * Release: DEVELOPMENT
 */

if ( !defined ( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'WC_STOCK_MAN' ) ) {
	class WC_STOCK_MAN {

		public function __construct() {

		}
	}
}

$GLOBALS['wc_stock_man'] = new WC_STOCK_MAN();