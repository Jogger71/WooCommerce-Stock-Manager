<?php

/**
 * A Custom product class for easy use in the WooCommerce Stock System
 */

if ( ! defined ( 'ABSPATH' ) ) {
	exit();
}

if ( ! class_exists ( 'WSS_Product' ) ) {
	class WSS_Product {
		/**
		 * Product ID
		 * @var int $id
		 * @since 0.1.0
		 */
		private $id;

		/**
		 * Product name
		 * @var string $name
		 * @since 0.1.0
		 */
		private $name;

		/**
		 * Product image url
		 * @var string $image_url
		 * @since 0.1.0
		 */
		private $image_url;

		/**
		 * Product stock available
		 * @var int $stock_available
		 * @since 0.1.0
		 */
		private $stock_available;

		/**
		 * Product stock on hand
		 * @var int $stock_on_hand
		 * @since 0.1.0
		 */
		private $stock_on_hand;

		/**
		 * Product total sales
		 * @var int $total_sales
		 * @since 0.1.0
		 */
		private $total_sales;

		/**
		 * WooCommerce product object
		 * @var WC_Product|WC_Product_Variation|WC_Product_Bundle|WC_Product_Variable|WC_Product_Simple $wc_product
		 * @since 0.1.0
		 */
		public $wc_product;


		/**
		 * Class Constructor
		 * @param int|null $id
		 */
		public function __construct ( $id = null ) {
			if ( ! empty( $id ) ) {
				//  Initialise WooCommerce product
				$this->wc_product = wc_get_product ( $id );

				//  Set possible internal values for our variables
				$this->set_id ( $id );
				$this->set_name ( $this->wc_product->get_title () );
				$this->set_image_url ( $this->wc_product->get_image () );
				$this->set_stock_available ( $this->wc_product->get_stock_quantity () );
				$this->set_stock_on_hand ( get_post_meta ( $this->get_id (), 'stock_on_hand', true ) );
				$this->set_total_sales ( get_post_meta ( $this->id, 'total_sales', true ) );
			}
		}


		/**
		 * Set the product id
		 * @param int $value
		 * @return bool
		 * @since 0.1.0
		 */
		public function set_id ( $value ) {
			if ( is_int ( $value ) ) {
				$this->id = $value;
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Set the product name
		 * @param string $value
		 * @return bool
		 * @since 0.1.0
		 */
		public function set_name ( $value ) {
			if ( is_string ( $value ) ) {
				$this->name = $value;
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Set the product image url
		 * @param string $value
		 * @return bool
		 * @since 0.1.0
		 */
		public function set_image_url ( $value ) {
			if ( is_string ( $value ) ) {
				$this->image_url = $value;
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Set the product stock available
		 * @param int $value
		 * @return bool
		 * @since 0.1.0
		 */
		public function set_stock_available ( $value ) {
			if ( is_int ( $value ) ) {
				$this->stock_available = $value;
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Set the product stock on hand
		 * @param int $value
		 * @return bool
		 * @since 0.1.0
		 */
		public function set_stock_on_hand ( $value ) {
			$this->stock_on_hand = $value;
		}

		/**
		 * Set the product total sales
		 * @param int $value
		 * @return bool
		 * @since 0.1.0
		 */
		public function set_total_sales ( $value ) {
			if ( is_int ( $value ) || is_string ( $value ) ) {
				$this->total_sales = $value;
				return true;
			} else {
				return false;
			}
		}


		/**
		 * Get the product id
		 * @return int
		 * @since 0.1.0
		 */
		public function get_id () {
			return $this->id;
		}

		/**
		 * Get the product name
		 * @return string
		 * @since 0.1.0
		 */
		public function get_name () {
			if ( 'variation' == $this->wc_product->product_type ) {
				$attr = $this->wc_product->get_variation_attributes ();
				$keys = array_keys ( $attr );
				$this->name .= ' ' . $attr[ $keys[ 0 ] ];
			}

			return $this->name;
		}

		/**
		 * Get the product image url
		 * @return string
		 * @since 0.1.0
		 */
		public function get_image_url () {
			return $this->image_url;
		}

		/**
		 * Get the product stock available
		 * @return int
		 * @since 0.1.0
		 */
		public function get_stock_available () {
			return $this->stock_available;
		}

		/**
		 * Get the product stock on hand
		 * @return int
		 * @since 0.1.0
		 */
		public function get_stock_on_hand () {
			return $this->stock_on_hand;
		}

		/**
		 * Get the product total sales
		 * @return int
		 * @since 0.1.0
		 */
		public function  get_total_sales () {
			return $this->total_sales;
		}

		/**
		 * Update stock on hand level
		 * @param int    $value
		 * @param string $method
		 * @since 0.2.0
		 */
		public function update_stock_on_hand ( $value, $method = 'set' ) {
			switch ( $method ) {
				case 'add':
					$current_stock_on_hand = $this->get_stock_on_hand ();
					$this->set_stock_on_hand ( $current_stock_on_hand + $value );
					update_post_meta ( $this->get_id (), 'stock_on_hand', $this->get_stock_on_hand () );
					break;
				case 'subtract':
					$current_stock_on_hand = $this->get_stock_on_hand ();
					$this->set_stock_on_hand ( $current_stock_on_hand - $value );
					update_post_meta ( $this->get_id (), 'stock_on_hand', $this->get_stock_on_hand () );
					break;
				default:
					$this->set_stock_on_hand ( $value );
					update_post_meta ( $this->get_id (), 'stock_on_hand', $this->get_stock_on_hand () );
					break;
			}
		}

		/**
		 * Reduce stock on hand level
		 * @param int $value
		 * @return bool
		 * @since 0.2.0
		 */
		public function reduce_stock_on_hand ( $value ) {
			$this->update_stock_on_hand ( $value, 'subtract' );
		}

		/**
		 * Increase stock on hand level
		 * @param int $value
		 * @since 0.2.0
		 */
		public function increase_stock_on_hand ( $value ) {
			$this->update_stock_on_hand ( $value, 'add' );
		}
	}
}