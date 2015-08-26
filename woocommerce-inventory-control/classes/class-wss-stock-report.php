<?php

/**
 * Stock report generating class
 * @since 0.3.0
 */

if ( !defined( 'ABSPATH' ) ) {
	exit( 'Cheaters Detected!' );
}

if ( !class_exists( 'WSS_Stock_Report' ) ) {
	class WSS_Stock_Report {

		/**
		 * Class Constructor
		 * @param array|string $product_types All the different product types to be included in the report.
		 */
		public function __construct( $product_types = 'simple' ) {
		}

		/**
		 * Get the stock report
		 * @param array|string $product_types All the different product types to be included in the report.
		 * @return file
		 * @since 0.3.0
		 */
		public static function get_stock_report( $product_types = 'simple' ) {
			if ( is_string( $product_types ) ) {
				$product_types = array( $product_types );
			}

			if ( is_array( $product_types ) ) {
				$today = date( 'd-m-Y-H:i:s' );
				header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
				header( 'Content-Description: File Transfer' );
				header( 'Content-Type: text/csv; charset=utf-8' );
				header( 'Content-Disposition: attachment; filename=' . $today . '-stock-report.csv' );

				$products = WSS_Product_Handling::get_products();

				$report = fopen( 'php://output', 'w' );

				$header_array = array(
					'id',
					'Name',
					'Stock Available',
					'Stock On Hand'
				);

				fputcsv( $report, $header_array );

				foreach ( $products as $product ) {
					$wss_product = new WSS_Product( $product->ID );

					switch ( $wss_product->wc_product->product_type ) {
						case 'variable':
							if ( in_array( $wss_product->wc_product->product_type, $product_types ) && $wss_product->wc_product->managing_stock() ) {
								$product_array = WSS_Product_Handling::wss_product_to_array( $wss_product );
								fputcsv( $report, $product_array );
							}

							$children = $wss_product->wc_product->get_children();

							foreach ( $children as $child ) {
								$child_obj = new WSS_Product( $child );
								if ( in_array( $child_obj->wc_product->product_type, $product_types ) && $child_obj->wc_product->managing_stock() ) {
									$product_array = WSS_Product_Handling::wss_product_to_array( $child_obj );
									fputcsv( $report, $product_array );
								}
							}
							break;
						default:
							if ( in_array( $wss_product->wc_product->product_type, $product_types ) && $wss_product->wc_product->managing_stock() ) {
								$product_array = WSS_Product_Handling::wss_product_to_array( $wss_product );
								fputcsv( $report, $product_array );
							}
							break;
					}
				}

				fclose( $report );
				exit;
			}
		}
	}
}