<?php

/**
 * Product Variation Class
 * @since 0.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WSS_Product' ) ) {
	include_once( WSS_PLUGIN_LOCATION . '/classes/class-wss-product.php' );
}

if ( ! class_exists( 'WSS_Product_Variation' ) ) {
	class WSS_Product_Variation extends WSS_Product {

		/**
		 * Variation Parent
		 * @var WC_Product $parent
		 * @since 0.2.0
		 */
		public $parent;

		/**
		 * Class Constructor
		 * @param int        $id
		 * @param WC_Product $parent
		 * @since 0.2.0
		 */
		public function __construct( $id, $parent ) {
			$this->set_id( $id );
			$this->parent = $parent;
		}
	}
}