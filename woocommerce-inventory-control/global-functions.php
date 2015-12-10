<?php


/**
 * Reduce stock on hand when order is marked completed
 *
 * @param int $order
 * @since 0.2.0
 */
function wss_reduce_stock_on_hand( $order ) {
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
 *
 * @since 0.2.0
 */
function wcic_styling() {
	if ( ! wp_style_is( 'wcsm_interface', 'enqueued' ) ) {
		wp_enqueue_style( 'wcsm_interface', plugins_url( 'assets/css/wcsm_interface_2.css', __FILE__ ) );
	}

	if ( ! wp_style_is( 'wss_print', 'enqueued' ) ) {
		wp_enqueue_style( 'wss_print', plugins_url( 'assets/css/wss_print.css', __FILE__ ) );
	}

	if ( ! wp_style_is( 'select2', 'registered' ) ) {
		wp_register_style( 'select2', plugins_url( 'assets/select2/css/select2.min.css', __FILE__ ) );
	}

	if ( wp_style_is( 'select2', 'registered' ) && ! wp_style_is( 'select2', 'enqueued' ) ) {
		wp_enqueue_style( 'select2' );
	}

	if ( ! wp_script_is( 'jquery', 'enqueued' ) ) {
		wp_enqueue_script( 'jquery' );
	}

	if ( ! wp_script_is( 'select2', 'registered' ) ) {
		wp_register_script( 'select2', plugins_url( 'assets/select2/js/select2.full.min.js', __FILE__ ), array ( 'jquery' ) );
	}

	if ( wp_script_is( 'select2', 'registered' ) && ! wp_script_is( 'select2', 'enqueued' ) ) {
		wp_enqueue_script( 'select2' );
	}

	wp_enqueue_script( 'wss_scripts', plugins_url( 'assets/js/wss_scripts.js', __FILE__ ), array ( 'jquery' ) );
}