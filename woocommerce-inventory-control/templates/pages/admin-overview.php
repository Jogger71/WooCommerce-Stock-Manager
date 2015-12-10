<?php

/**
 * WC Stock Manager Overview admin page.
 * @since 0.1.0
 */

$single_products = WSS_Product_Handling::get_products();

if ( isset( $_POST[ 'set_stock' ] ) ) {
	$products = WSS_Product_Handling::get_products();

	foreach ( $products as $product ) {
		$product_obj = new WSS_Product( $product->ID );

		switch ( $product_obj->wc_product->product_type ) {
			case 'simple':
				if ( $product_obj->wc_product->managing_stock() && empty( get_post_meta( $product_obj->get_id(), 'stock_on_hand', true ) ) ) {
					$product_obj->update_stock_on_hand( $product_obj->get_stock_available() );
				}
				break;
			case 'variable':
				$children = $product_obj->wc_product->get_children();
				foreach ( $children as $child ) {
					$child_obj = $product_obj->wc_product->get_child( $child );
					if ( empty( get_post_meta( $child, 'stock_on_hand', true ) ) ) {
						update_post_meta( $child, 'stock_on_hand', $child_obj->get_stock_quantity() );
					}
				}
				break;
		}

		if ( $product_obj->wc_product->managing_stock() ) {
			$product_obj->update_stock_on_hand( $product_obj->get_stock_available() );
		}
	}
}

if ( isset( $_POST[ 'initialise_stock_available' ] ) ) {
	$products = WSS_Product_Handling::get_products();

	foreach ( $products as $product ) {
		$product_obj = new WSS_Product( $product->ID );

		switch ( $product_obj->wc_product->product_type ) {
			case 'variable':
				$children = $product_obj->wc_product->get_children();
				foreach ( $children as $child ) {
					$child_obj = new WSS_Product( $child );
					$child_obj->update_stock_available( $child_obj->get_stock_on_hand() );
				}
				break;
			default:
				if ( $product_obj->wc_product->managing_stock() ) {
					$product_obj->update_stock_available( $product_obj->get_stock_on_hand() );
				}
				break;
		}
	}

	$order_args = array (
		'posts_per_page' => -1,
		'post_type'      => 'shop_order',
		'post_status'    => array (
			'wc-on-hold',
			'wc-processing'
		)
	);

	$order_posts = get_posts( $order_args );

	foreach ( $order_posts as $order_post ) {
		$order = wc_get_order( $order_post->ID );

		$items = $order->get_items();

		foreach ( $items as $item ) {
			$product_id = $item[ 'product_id' ];
			$product_obj = new WSS_Product( $product_id );

			if ( $product_obj->wc_product->managing_stock() ) {
				$qty = apply_filters( 'woocommerce_order_item_quantity', $item[ 'qty' ], $order, $item );
				$qty = (int)$qty;

				$product_obj->reduce_stock_available( $qty );
			}
		}
	}
}

?>

<div class="wrap">
	<h2>Stock Overview</h2>
	<table class="button-table">
		<tr>
			<td>
				<form method="post" action="<?php echo $_SERVER[ 'REQUEST_URI' ]; ?>">
					<input type="hidden" name="set_stock" value="true"/>
					<input class="wcic-button green" type="submit" name="init_stock" value="Initialise Stock On Hand"/>
				</form>
			</td>
			<td>
				<form method="post" action="<?php echo $_SERVER[ 'REQUEST_URI' ]; ?>">
					<input type="hidden" name="initialise_stock_available" value="true"/>
					<input class="wcic-button green" type="submit" name="init_stock" value="Initialise Stock Available"/>
				</form>
			</td>
			<td>
				<form method="post" action="<?php echo $_SERVER[ 'REQUEST_URI' ]; ?>">
					<input type="hidden" name="stock_report" value="true"/>
					<input class="wcic-button green" type="submit" name="get_stock_report" value="Get Report"/>
				</form>
			</td>
		</tr>
	</table>
	<table id="stock-overview-table" style="border: 1px solid #000; ">
		<thead>
			<tr>
				<th style="border: 1px solid #000; padding: 10px;">ID</th>
				<th style="border: 1px solid #000; padding: 10px;">Name</th>
				<th style="border: 1px solid #000; padding: 10px;">Total Sales</th>
				<th style="border: 1px solid #000; padding: 10px;">Stock Available</th>
				<th style="border: 1px solid #000; padding: 10px;">Stock On Hand</th>
			</tr>
		</thead>
		<?php

		foreach ( $single_products as $product ) {
			$wss_product = new WSS_Product( $product->ID );

			switch ( $wss_product->wc_product->product_type ) {
				case 'simple':
					if ( $wss_product->wc_product->managing_stock() ):
						?>
						<tr class="<?php echo $wss_product->get_stock_status(); ?>">
							<td style="border: 1px solid #000; padding: 10px;"><?php echo $wss_product->get_id(); ?></td>
							<td style="border: 1px solid #000; padding: 10px;"><?php echo $wss_product->get_name(); ?></td>
							<td style="border: 1px solid #000; padding: 10px;"><?php echo $wss_product->get_total_sales(); ?></td>
							<td style="border: 1px solid #000; padding: 10px;"><?php echo $wss_product->get_stock_available(); ?></td>
							<td style="border: 1px solid #000; padding: 10px;"><?php echo $wss_product->get_stock_on_hand(); ?></td>
						</tr>
						<?php
					endif;
					break;
				case 'variable':
					$children = $wss_product->wc_product->get_children();
					foreach ( $children as $child ) {
						$child_obj = new WSS_Product( $child );
						if ( $child_obj->wc_product->managing_stock() ):
							?>
							<tr class="<?php echo $child_obj->get_stock_status(); ?>">
								<td style="border: 1px solid #000; padding: 10px;"><?php echo $child_obj->get_id(); ?></td>
								<td style="border: 1px solid #000; padding: 10px;"><?php echo $child_obj->get_name(); ?></td>
								<td style="border: 1px solid #000; padding: 10px;"><?php echo $child_obj->get_total_sales(); ?></td>
								<td style="border: 1px solid #000; padding: 10px;"><?php echo $child_obj->get_stock_available(); ?></td>
								<td style="border: 1px solid #000; padding: 10px;"><?php echo $child_obj->get_stock_on_hand(); ?></td>
							</tr>
							<?php
						endif;
					}
			}
		}
		?>
	</table>
</div>