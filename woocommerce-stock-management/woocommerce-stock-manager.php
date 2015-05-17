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

		public function __construct() {
            //  Set some variables
            $this->plugin_location = plugin_dir_path( __FILE__ );
            $this->product_ids = $this->get_all_products();
		}

        public function get_plugin_path() {
            return $this->plugin_location;
        }

        public function get_product_ids() {
            return $this->product_ids;
        }

        public function get_all_products() {
            $products = [];

            $arguments = array(
                'post_type' => 'product',
                'posts_per_page' => -1
            );

            $query = new WP_Query( $arguments );

            while( $query->have_posts() ) : $query->the_post();
                $products[] = get_the_ID();
            endwhile;

            wp_reset_query();

            //  Return the ids
            return $products;
        }
	}
}

$GLOBALS['wc_stock_manager'] = new WC_Stock_Manager();