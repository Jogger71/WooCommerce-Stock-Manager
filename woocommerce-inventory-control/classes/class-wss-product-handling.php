<?php

/**
 * Product Handling Class
 * @since 0.1.0
 */

if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists ( 'WSS_Product_Handling' ) ) {
	class WSS_Product_Handling {

		/**
		 * Get multiple products
		 * @param string $type
		 * @return array
		 * @since 0.1.0
		 */
		public static function get_products ( $type = 'product' ) {
			$args = array (
				'posts_per_page' => -1,
				'post_type'      => $type,
				'orderby'        => 'title',
				'order'          => 'ASC'
			);

			return get_posts ( $args );
		}

		/**
		 * Get all the display products
		 * @return array
		 * @since 0.1.0
		 */
		public static function get_all_products () {
			$products = self::get_products ();

			$display_products = array ();

			foreach ( $products as $product ) {
				if ( empty( get_post_meta ( $product->ID, '_bundle_data' ) ) ) {
					$children_args = array (
						'post_parent' => $product->ID,
						'post_type'   => 'product_variation',
						'post_status' => 'publish'
					);

					if ( ! empty( get_posts ( $children_args ) ) ) {
						$children = get_posts ( $children_args );

						foreach ( $children as $child ) {
							$display_products[] = $child;
						}
					} else {
						$display_products[] = $product;
					}
				}
			}

			return $display_products;
		}

		/**
		 * Get Single Products
		 * @return array
		 * @since 0.1.0
		 */
		public static function get_single_products () {
			$products = self::get_products ();
			$single_products = array ();

			foreach ( $products as $product ) {
				if ( empty( get_post_meta ( $product->ID, '_bundle_data' ) ) ) {
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
		public static function get_variation_products () {
			$products = self::get_products ( 'product_variation' );
		}

		/**
		 * Get Post Parent
		 * @param int|WP_Post $post
		 * @return WP_Post|bool
		 * @since 0.1.0
		 */
		public static function get_parent ( $post ) {
			if ( $post instanceof WP_Post ) {
				$parent_id = wp_get_post_parent_id ( $post->ID );
			} else if ( is_numeric ( $post ) ) {
				$parent_id = wp_get_post_parent_id ( $post );
			} else {
				return false;
			}

			return get_post ( $parent_id );
		}

		/**
		 * Check if product is bundled
		 * @param int|WP_Post|WC_Product $product
		 * @return bool
		 * @since 0.1.0
		 */
		public function is_bundle_product ( $product ) {
			if ( is_numeric ( $product ) ) {
				return empty( get_post_meta ( $product, '_bundle_data' ) );
			} else if ( $product instanceof WP_Post ) {
				return empty( get_post_meta ( $product->ID, '_bundle_data' ) );
			} else {
				return empty( get_post_meta ( $product->id, '_bundle_data' ) );
			}
		}
	}
}