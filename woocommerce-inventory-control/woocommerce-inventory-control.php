<?php

/**
 * Plugin Name: WooCommerce Inventory Control
 * Author: Graphite Programming
 * Author URI: http://www.graphiteprogramming.com/
 *
 * Description: A system purely dedicated to stock management in woocommerce.
 *
 * Version: 0.0.0
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
		 * Plugin Location Variable
		 */
		private $plugin_location;

		/**
		 * All product ids
		 */
		private $product_ids;
		private $variation_ids;

		/**
		 * Class Constructor
		 */
		public function __construct() {
			//  Set some variables
			define( 'WSS_PLUGIN_LOCATION', dirname( __FILE__ ) );
			include( WSS_PLUGIN_LOCATION . '/classes/class-wcsm-admin.php' );
			include( WSS_PLUGIN_LOCATION . '/classes/class-wss-product-handling.php' );
			include( WSS_PLUGIN_LOCATION . '/classes/class-wss-product.php' );
			$this->admin = new WCSM_Admin();

			//  Actions
			add_action( 'init', array( $this, 'set_products' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'styling' ) );
		}

		public function get_product_ids() {
			return $this->product_ids;
		}

		public function get_variation_ids() {
			return $this->variation_ids;
		}

		public function set_products() {
			$this->product_ids = $this->get_all_products();
			$this->variation_ids = $this->get_all_variations();
		}

		public function get_all_products() {
			$products = [ ];

			$arguments = array(
				'post_type'      => 'product',
				'posts_per_page' => -1
			);

			$query = new WP_Query( $arguments );

			while ( $query->have_posts() ) : $query->the_post();
				$products[] = get_the_ID();
			endwhile;

			wp_reset_query();

			//  Return the ids
			return $products;
		}

		public function get_all_variations() {
			$products = [ ];

			$arguments = array(
				'post_type'      => 'product_variation',
				'posts_per_page' => -1
			);

			$query = new WP_Query( $arguments );

			while ( $query->have_posts() ) : $query->the_post();
				$products[] = get_the_ID();
			endwhile;

			wp_reset_query();

			//  Return the ids
			return $products;
		}

		public function styling() {
			if ( !wp_style_is( 'wcsm_interface', 'enqueued' ) ) {
				wp_enqueue_style( 'wcsm_interface', plugins_url( 'assets/css/wcsm_interface.css', __FILE__ ) );
			}
		}
	}
}

$GLOBALS[ 'wc_inventory_control' ] = new WC_Inventory_Control();