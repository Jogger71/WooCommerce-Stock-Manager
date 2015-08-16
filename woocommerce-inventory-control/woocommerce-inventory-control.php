<?php

/**
 * Plugin Name: WooCommerce Stock System
 * Author: Graphite Programming
 * Author URI: http://www.graphiteprogramming.com/
 *
 * Description: A system purely dedicated to stock management in woocommerce.
 *
 * Version: 0.1.0
 * Release: DEVELOPMENT
 */

if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists ( 'WC_Inventory_Control' ) ) {
	class WC_Inventory_Control {
		/**
		 * Admin Class variable
		 */
		private $admin;

		/**
		 * Class Constructor
		 */
		public function __construct () {
			//  Set some variables
			define ( 'WSS_PLUGIN_LOCATION', dirname ( __FILE__ ) );
			include ( WSS_PLUGIN_LOCATION . '/classes/class-wcsm-admin.php' );
			include ( WSS_PLUGIN_LOCATION . '/classes/class-wss-product-handling.php' );
			include ( WSS_PLUGIN_LOCATION . '/classes/class-wss-product.php' );
			$this->admin = new WCSM_Admin();

			//  Actions
			add_action ( 'init', array ( $this, 'set_products' ) );
			add_action ( 'admin_enqueue_scripts', array ( $this, 'styling' ) );
			//  add_action( 'woocommerce_reduce_order_stock', array( $this, 'wss_reduce_stock' ) );
			add_action ( 'woocommerce_order_status_completed', array ( $this, 'wss_reduce_stock_on_hand' ) );
		}

		/**
		 * Reduce stock on hand when order is marked completed
		 * @param int $order
		 * @since 0.2.0
		 */
		public function wss_reduce_stock_on_hand ( $order ) {
			if ( is_numeric ( $order ) ) {
				$order_obj = wc_get_order ( $order );

				$items = $order_obj->get_items ();
				foreach ( $items as $item ) {
					$product_id = $item[ 'product_id' ];
					$product_obj = new WSS_Product( $product_id );

					$qty = apply_filters ( 'woocommerce_order_item_quantity', $item[ 'qty' ], $order_obj, $item );
					$qty = (int)$qty;

					$product_obj->reduce_stock_on_hand ( $qty );
				}
			}
		}

		/**
		 * Load all style files
		 * @since 0.2.0
		 */
		public function styling () {
			if ( ! wp_style_is ( 'wcsm_interface', 'enqueued' ) ) {
				wp_enqueue_style ( 'wcsm_interface', plugins_url ( 'assets/css/wcsm_interface.css', __FILE__ ) );
			}
		}
	}
}

$GLOBALS[ 'wc_inventory_control' ] = new WC_Inventory_Control();