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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WC_Inventory_Control' ) ) {
	class WC_Inventory_Control {
		/**
		 * Instance of the class
		 *
		 * @var WC_Inventory_Control $instance
		 * @since 0.3.0
		 */
		private static $instance;

		/**
		 * Admin Class variable
		 */
		private $admin;

		/**
		 * Class Constructor
		 */
		private function __construct() {
			register_activation_hook( __FILE__, array ( $this, 'activation' ) );

			$this->activation();

			//  Set some variables
			define( 'WSS_PLUGIN', dirname( __FILE__ ) );
			include_once( WSS_PLUGIN . '/classes/class-wcic-setup.php' );

			wcic_setup()->define_constants( WSS_PLUGIN, plugins_url( '', __FILE__ ) );
			wcic_setup()->includes();

			//  Actions
//			add_action( 'init', array( $this, 'set_products' ) );
			add_action( 'init', array ( $this, 'check_report_request' ) );
			add_action( 'admin_enqueue_scripts', 'wcic_styling' );
			//  add_action( 'woocommerce_reduce_order_stock', array( $this, 'wss_reduce_stock' ) );
			add_action( 'woocommerce_order_status_completed', 'wss_reduce_stock_on_hand', 10, 3 );
		}

		/**
		 * Gets the only instance of the class
		 *
		 * @return WC_Inventory_Control
		 * @since 0.3.0
		 */
		public static function get_instance() {
			if ( ! isset( self::$instance ) && ! self::$instance instanceof WC_Inventory_Control ) {
				self::$instance = new WC_Inventory_Control();
			}

			return self::$instance;
		}

		/**
		 * Plugin activation hook
		 * @since 0.3.0
		 */
		private function activation() {
			include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
			if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
				add_action( 'admin_notices', array ( $this, 'need_woocommerce' ) );
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
		 * Check for report request
		 * @since 0.3.0
		 */
		public function check_report_request() {
			if ( isset( $_POST[ 'stock_report' ] ) ) {
				WSS_Stock_Report::get_stock_report( array ( 'simple', 'variation' ) );
			}
		}
	}
}

function WCIC() {
	return WC_Inventory_Control::get_instance();
}

WCIC();