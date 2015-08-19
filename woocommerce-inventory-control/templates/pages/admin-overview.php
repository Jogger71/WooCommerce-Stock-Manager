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

?>

<div class="wrap">
	<h2>Stock Overview</h2>
	<form method="post" action="<?php echo $_SERVER[ 'REQUEST_URI' ]; ?>">
		<input type="hidden" name="set_stock" value="true"/>
		<input type="submit" name="init_stock" value="Initialise Stock On Hand"/>
	</form>
	<table style="border: 1px solid #000; ">
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
						<tr>
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
							<tr>
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