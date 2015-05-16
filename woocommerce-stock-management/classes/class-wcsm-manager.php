<?php

/**
 * Stock Management class
 */

if ( !defined ( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'WCSM_Manager' ) ) {
	class WCSM_Manager {
		public function __construct() {

		}

		public function update_stock( $product_id, $amount, $update_method = 'set' ) {
			global $woocommerce;
			//  Get product object
			$product = $woocommerce->product_factory->get_product( $product_id );
			//  Update the stock
			$product->set_stock( $amount, $update_method );
		}
	}
}

return new WCSM_Manager();