<?php

/**
 * Product Handling Class
 * @since 0.1.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit;
}

if ( !class_exists( 'WSS_Product_Handling' ) ) {
	class WSS_Product_Handling {

		/**
		 * Get multiple products
		 * @param string $type
		 * @return array
		 * @since 0.1.0
		 */
		public static function get_products( $type = 'product' ) {
			$args = array(
				'posts_per_page' => -1,
				'post_type'      => $type
			);

			return get_posts( $args );
		}

		/**
		 * Get all the display products
		 * @return array
		 * @since 0.1.0
		 */
		public static function get_all_products() {
			$products = self::get_products();

			$display_products = array();

			foreach ( $products as $product ) {
				if ( empty( get_post_meta( $product->ID, '_bundle_data' ) ) ) {
					$children_args = array(
						'post_parent' => $product->ID,
						'post_type'   => 'product_variation',
						'post_status' => 'publish'
					);

					if ( !empty( get_children( $children_args ) ) ) {
						$children = get_children( $children_args );
					}
				}
			}
		}

		/**
		 * Get Single Products
		 * @return array
		 * @since 0.1.0
		 */
		public static function get_single_products() {
			$products = self::get_products();
			$single_products = array();

			foreach ( $products as $product ) {
				if ( empty( get_post_meta( $product->ID, '_bundle_data' ) ) ) {
					$single_products[] = $product;
				}
			}

			return $single_products;
		}

		/**
		 * Get Variable Products
		 * @return array
		 * @since 0.1.0
		 */
		public static function get_variation_products() {
			$products = self::get_products( 'product_variation' );
		}

		/**
		 * Get Post Parent
		 * @param int|WP_Post $post
		 * @return WP_Post|bool
		 * @since 0.1.0
		 */
		public static function get_parent( $post ) {
			if ( $post instanceof WP_Post ) {
				$parent_id = wp_get_post_parent_id( $post->ID );
			} else if ( is_numeric( $post ) ) {
				$parent_id = wp_get_post_parent_id( $post );
			} else {
				return false;
			}

			return get_post( $parent_id );
		}
	}
}