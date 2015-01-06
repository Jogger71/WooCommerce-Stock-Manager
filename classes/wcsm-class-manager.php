<?php

/**
 * Stock Management class
 */

if ( !defined ( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'WCSM_MANAGER' ) ) {
	class WCSM_MANAGER {
		public function __construct() {

		}

		public function replenish_stock( $product_id, $amount ) {
			global $woocommerce;

			$product = $woocommerce->product_factory->get_product( $product_id );

			$current_stock = $product->get_stock_quantity();

			$new_stock = $current_stock + $amount;

			$product->set_stock( $new_stock );
		}
	}
}