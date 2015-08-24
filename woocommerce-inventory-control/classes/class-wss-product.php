<?php

/**
 * A Custom product class for easy use in the WooCommerce Stock System
 */

if ( !defined( 'ABSPATH' ) ) {
	exit();
}

if ( !class_exists( 'WSS_Product' ) ) {
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
		 * Product Low Stock Set Point
		 * @var int $low_stock_set_point
		 * @since 0.3.0
		 */
		private $low_stock_set_point;

		/**
		 * Product Stock Reorder Point
		 * @var int $reorder_set_point
		 * @since 0.3.0
		 */
		private $reorder_set_point;

		/**
		 * Product out of stock set point
		 * @var int $out_of_stock_set_point
		 * @since 0.3.0
		 */
		private $out_of_stock_set_point;

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
		public function __construct( $id = null ) {
			if ( !empty( $id ) ) {
				//  Initialise WooCommerce product
				$this->wc_product = wc_get_product( $id );

				//  Set possible internal values for our variables
				$this->set_id( $id );
				$this->set_name( $this->wc_product->get_title() );
				$this->set_image_url( $this->wc_product->get_image() );
				$this->set_stock_available( $this->wc_product->get_stock_quantity() );
				$this->set_stock_on_hand( get_post_meta( $this->get_id(), 'stock_on_hand', true ) );
				$this->set_total_sales( get_post_meta( $this->id, 'total_sales', true ) );
				$this->set_low_stock_set_point( get_post_meta( $this->get_id(), 'wic_low_stock_set_point', true ) );
				$this->set_reorder_set_point( get_post_meta( $this->get_id(), 'wic_reorder_set_point', true ) );
				$this->set_out_of_stock_set_point( get_post_meta( $this->get_id(), 'wic_out_of_stock_set_point', true ) );
			}
		}


		/**
		 * Set the product id
		 * @param int $value
		 * @return bool
		 * @since 0.1.0
		 */
		public function set_id( $value ) {
			if ( is_numeric( $value ) ) {
				$this->id = (int)$value;
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
		public function set_name( $value ) {
			if ( is_string( $value ) ) {
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
		public function set_image_url( $value ) {
			if ( is_string( $value ) ) {
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
		public function set_stock_available( $value ) {
			if ( is_numeric( $value ) ) {
				$this->stock_available = (int)$value;
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
		public function set_stock_on_hand( $value ) {
			if ( is_numeric( $value ) ) {
				$this->stock_on_hand = (int)$value;
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Set the product total sales
		 * @param int $value
		 * @return bool
		 * @since 0.1.0
		 */
		public function set_total_sales( $value ) {
			if ( is_numeric( $value ) ) {
				$this->total_sales = (int)$value;
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Set the low stock set point value
		 * @param int|string $value
		 * @return bool
		 * @since 0.3.0
		 */
		public function set_low_stock_set_point( $value ) {
			if ( !empty( $value ) ) {
				if ( is_numeric( $value ) ) {
					$this->low_stock_set_point = (int)$value;
					return true;
				} else {
					return false;
				}
			} else {
				$this->update_low_stock_set_point( 50 );
				$this->low_stock_set_point = 50;
				return true;
			}
		}

		/**
		 * Update the low stock set point value
		 * @param int $value
		 * @return bool
		 * @since 0.3.0
		 */
		public function update_low_stock_set_point( $value ) {
			if ( is_numeric( $value ) && !empty( $value ) ) {
				update_post_meta( $this->get_id(), 'wic_low_stock_set_point', $value );
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Set the out of stock set point value
		 * @param int|string $value
		 * @return bool
		 * @since 0.3.0
		 */
		public function set_out_of_stock_set_point( $value ) {
			if ( is_numeric( $value ) ) {
				$this->out_of_stock_set_point = (int) $value;
				return true;
			} else {
				$this->update_out_of_stock_set_point( 0 );
				$this->out_of_stock_set_point = 0;
				return true;
			}
		}

		/**
		 * Update the out of stock set point value
		 * @param int $value
		 * @return bool
		 * @since 0.3.0
		 */
		public function update_out_of_stock_set_point( $value ) {
			if ( is_numeric( $value ) ) {
				update_post_meta( $this->get_id(), 'wic_out_of_stock_set_point', $value );
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Set the reorder set point value
		 * @param int|string $value
		 * @return bool
		 * @since 0.3.0
		 */
		public function set_reorder_set_point( $value ) {
			if ( is_numeric( $value ) && !empty( $value ) ) {
				$this->reorder_set_point = (int) $value;
				return true;
			} else {
				$this->update_reorder_set_point( 25 );
				$this->reorder_set_point = 25;
				return true;
			}
		}

		/**
		 * Update the reorder set point value
		 * @param int $value
		 * @return bool
		 * @since 0.3.0
		 */
		public function update_reorder_set_point( $value ) {
			if ( is_numeric( $value ) ) {
				update_post_meta( $this->get_id(), 'wic_reorder_set_point', $value );
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
		public function get_id() {
			return $this->id;
		}

		/**
		 * Get the product name
		 * @return string
		 * @since 0.1.0
		 */
		public function get_name() {
			if ( 'variation' == $this->wc_product->product_type ) {
				$attr = $this->wc_product->get_variation_attributes();
				$keys = array_keys( $attr );
				$this->name .= ' ' . $attr[ $keys[ 0 ] ];
			}

			return $this->name;
		}

		/**
		 * Get the product image url
		 * @return string
		 * @since 0.1.0
		 */
		public function get_image_url() {
			return $this->image_url;
		}

		/**
		 * Get the product stock available
		 * @return int
		 * @since 0.1.0
		 */
		public function get_stock_available() {
			return $this->stock_available;
		}

		/**
		 * Get the product stock on hand
		 * @return int
		 * @since 0.1.0
		 */
		public function get_stock_on_hand() {
			return $this->stock_on_hand;
		}

		/**
		 * Get the product total sales
		 * @return int
		 * @since 0.1.0
		 */
		public function  get_total_sales() {
			return $this->total_sales;
		}

		/**
		 * Get the low stock set point value
		 * @return int
		 * @since 0.3.0
		 */
		public function get_low_stock_set_point() {
			return $this->low_stock_set_point;
		}

		/**
		 * Get the reorder set point value
		 * @return integer
		 * @since 0.3.0
		 */
		public function get_reorder_set_point() {
			return $this->reorder_set_point;
		}

		/**
		 * Get the out of stock set point value
		 * @return integer
		 * @since 0.3.0
		 */
		public function get_out_of_stock_set_point() {
			return $this->out_of_stock_set_point;
		}

		/**
		 * Get the product stock status
		 *
		 * @return string
		 * @since 0.3.0
		 */
		public function get_stock_status() {
			$method = get_option( 'wic_stock_keeping_unit', 'stock_on_hand' );

			switch ( $method ) {
				case 'stock_on_hand':
					$curr_stock = $this->get_stock_on_hand();
					if ( $this->get_out_of_stock_set_point() < $this->get_reorder_set_point() && $this->get_reorder_set_point() < $this->get_low_stock_set_point() ) {
						if ( $curr_stock <= $this->get_out_of_stock_set_point() ) {
							$stock_status = 'out_of_stock';
						} else if ( $curr_stock > $this->get_out_of_stock_set_point() && $curr_stock <= $this->get_reorder_set_point() ) {
							$stock_status = 'reorder_stock';
						} else if ( $curr_stock > $this->get_reorder_set_point() && $curr_stock <= $this->low_stock_set_point ) {
							$stock_status = 'low_stock';
						} else {
							$stock_status = 'in_stock';
						}
					}
					break;
				case 'stock_available':
					$curr_stock = $this->get_stock_available();
					if ( $this->get_out_of_stock_set_point() < $this->get_reorder_set_point() && $this->get_reorder_set_point() < $this->get_low_stock_set_point() ) {
						if ( $curr_stock <= $this->get_out_of_stock_set_point() ) {
							$stock_status = 'out_of_stock';
						} else if ( $curr_stock > $this->get_out_of_stock_set_point() && $curr_stock <= $this->get_reorder_set_point() ) {
							$stock_status = 'reorder_stock';
						} else if ( $curr_stock > $this->get_reorder_set_point() && $curr_stock <= $this->low_stock_set_point ) {
							$stock_status = 'low_stock';
						} else {
							$stock_status = 'in_stock';
						}
					}
					break;
			}

			return $stock_status;
		}

		/**
		 * Update stock on hand level
		 * @param int $value
		 * @param string $method
		 * @since 0.2.0
		 */
		public function update_stock_on_hand( $value, $method = 'set' ) {
			switch ( $method ) {
				case 'add':
					$current_stock_on_hand = $this->get_stock_on_hand();
					$this->set_stock_on_hand( ( $current_stock_on_hand + $value ) );
					update_post_meta( $this->get_id(), 'stock_on_hand', $this->get_stock_on_hand() );
					break;
				case 'subtract':
					$current_stock_on_hand = $this->get_stock_on_hand();
					$this->set_stock_on_hand( ( $current_stock_on_hand - $value ) );
					update_post_meta( $this->get_id(), 'stock_on_hand', $this->get_stock_on_hand() );
					break;
				default:
					$this->set_stock_on_hand( $value );
					update_post_meta( $this->get_id(), 'stock_on_hand', $this->get_stock_on_hand() );
					break;
			}
		}

		/**
		 * Reduce stock on hand level
		 * @param int $value
		 * @since 0.2.0
		 */
		public function reduce_stock_on_hand( $value ) {
			$this->update_stock_on_hand( $value, 'subtract' );
		}

		/**
		 * Increase stock on hand level
		 * @param int $value
		 * @since 0.2.0
		 */
		public function increase_stock_on_hand( $value ) {
			$this->update_stock_on_hand( $value, 'add' );
		}

		/**
		 * Update stock available level
		 * @param int $value
		 * @param string $method
		 * @since 0.3.0
		 */
		public function update_stock_available( $value, $method = 'set' ) {
			switch ( $method ) {
				case 'add':
					$this->wc_product->set_stock( $value, $method );
					break;
				case 'subtract':
					$this->wc_product->set_stock( $value, $method );
					break;
				default:
					$this->wc_product->set_stock( $value );
					break;
			}
		}

		/**
		 * Increase stock available level
		 * @param int $value
		 * @since 0.3.0
		 */
		public function increase_stock_available( $value ) {
			$this->update_stock_available( $value, 'add' );
		}

		/**
		 * Reduce stock available level
		 * @param int $value
		 * @since 0.3.0
		 */
		public function reduce_stock_available( $value ) {
			$this->update_stock_available( $value, 'subtract' );
		}
	}
}