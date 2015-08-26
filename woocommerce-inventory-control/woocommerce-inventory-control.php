<?php

/**
 * Plugin Name: WooCommerce Inventory Control
 * Author: Graphite Programming
 * Author URI: http://www.graphiteprogramming.com/
 *
 * Description: A system purely dedicated to stock management in woocommerce.
 *
 * Version: 0.2.2
 * Release: DEVELOPMENT
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'WC_Inventory_Control' ) ) {
	class WC_Inventory_Control {
		/**
		 * Admin Class variable
		 */
		private $admin;

		/**
		 * Class Constructor
		 */
		public function __construct() {
			register_activation_hook( __FILE__, array( $this, 'activation' ) );

			if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
				add_action( 'admin_notices', array( $this, 'need_woocommerce' ) );
				deactivate_plugins( plugin_basename( __FILE__ ) );
			}

			//  Set some variables
			define( 'WSS_PLUGIN_LOCATION', dirname( __FILE__ ) );
			include( WSS_PLUGIN_LOCATION . '/classes/class-wcsm-admin.php' );
			include( WSS_PLUGIN_LOCATION . '/classes/class-wss-product-handling.php' );
			include( WSS_PLUGIN_LOCATION . '/classes/class-wss-product.php' );
			include( WSS_PLUGIN_LOCATION . '/classes/class-wss-stock-report.php' );
			$this->admin = new WCSM_Admin();

			//  Actions
//			add_action( 'init', array( $this, 'set_products' ) );
			add_action( 'init', array( $this, 'check_report_request' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'styling' ) );
			//  add_action( 'woocommerce_reduce_order_stock', array( $this, 'wss_reduce_stock' ) );
			add_action( 'woocommerce_order_status_completed', array( $this, 'wss_reduce_stock_on_hand' ), 10, 3 );
		}

		/**
		 * Plugin activation hook
		 * @since 0.3.0
		 */
		private function activation() {
			if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
				add_action( 'admin_notices', array( $this, 'need_woocommerce' ) );
				deactivate_plugins( plugin_basename( __FILE__ ) );
			}
		}

		/**
		 * Notice stating plugin requires WooCommerce
		 *
		 * @since 0.3.0
		 */
		public function need_woocommerce() {
			echo '<div class="error">';
			echo '<p>WooCommerce Inventory Control Requires WooCommerce to be active to work.</p>';
			echo '</div>';
		}

		/**
		 * Reduce stock on hand when order is marked completed
		 *
		 * @param int $order
		 * @since 0.2.0
		 */
		public function wss_reduce_stock_on_hand( $order ) {
			if ( is_numeric( $order ) ) {
				$order_obj = wc_get_order( (int)$order );
				$items = $order_obj->get_items();
				foreach ( $items as $item ) {
					$product_id = $item[ 'product_id' ];
					$product_obj = new WSS_Product( $product_id );

					if ( $product_obj->wc_product->managing_stock() ) {
						$qty = apply_filters( 'woocommerce_order_item_quantity', $item[ 'qty' ], $order_obj, $item );
						$qty = (int)$qty;

						$product_obj->reduce_stock_on_hand( $qty );
					}
				}
			}
		}

		/**
		 * Load all style files
		 * @since 0.2.0
		 */
		public function styling() {
			if ( !wp_style_is( 'wcsm_interface', 'enqueued' ) ) {
				wp_enqueue_style( 'wcsm_interface', plugins_url( 'assets/css/wcsm_interface.css', __FILE__ ) );
			}

			if ( !wp_style_is( 'wss_print', 'enqueued' ) ) {
				wp_enqueue_style( 'wss_print', plugins_url( 'assets/css/wss_print.css', __FILE__ ) );
			}

			if ( ! wp_script_is( 'jquery', 'enqueued' ) ) {
				wp_enqueue_script( 'jquery' );
			}

			wp_enqueue_script( 'wss_scripts', plugins_url( 'assets/js/wss_scripts.js', __FILE__ ), array( 'jquery' ) );
		}

		/**
		 * Check for report request
		 * @since 0.3.0
		 */
		public function check_report_request() {
			if ( isset( $_POST[ 'stock_report' ] ) ) {
				WSS_Stock_Report::get_stock_report( array( 'simple', 'variation' ) );
			}
		}
	}
}

$GLOBALS[ 'wc_inventory_control' ] = new WC_Inventory_Control();