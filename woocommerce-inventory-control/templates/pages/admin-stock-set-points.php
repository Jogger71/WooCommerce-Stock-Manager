<?php

$products = WSS_Product_Handling::get_products();
$stock_keeping_unit = get_option( 'wic_stock_keeping_unit', 'stock_on_hand' );

if ( 'set_points_update' == $_REQUEST[ 'submitted' ] ) {
	//  Update stock
	$product_out_of_stocks = $_POST[ 'out_of_stock_set_point' ];
	$product_low_stocks = $_POST[ 'low_stock_set_point' ];
	$product_reorder_set_point = $_POST[ 'reorder_stock_set_point' ];

	update_option( 'wic_stock_keeping_unit', $_POST[ 'stock_keeping_unit' ] );

	foreach ( $products as $product_post ) {
		$product = new WSS_Product( $product_post->ID );


		switch ( $product->wc_product->product_type ) {
			case 'simple':
				$product_object = $product;
				if ( $product_object->wc_product->managing_stock() ) {
					$product_object->update_reorder_set_point( $product_reorder_set_point[ (string)$product_object->get_id() ] );
					$product_object->update_low_stock_set_point( $product_low_stocks[ $product_object->get_id() ] );
					$product_object->update_out_of_stock_set_point( $product_out_of_stocks[ (string)$product_object->get_id() ] );
				}
				break;
			case 'variable':
				foreach ( $product->wc_product->get_children() as $child ) {
					$product_object = new WSS_Product( $child );
					if ( $product_object->wc_product->managing_stock() ) {
						$product_object->update_reorder_set_point( $product_reorder_set_point[ (string)$product_object->get_id() ] );
						$product_object->update_low_stock_set_point( $product_low_stocks[ (string)$product_object->get_id() ] );
						$product_object->update_out_of_stock_set_point( $product_out_of_stocks[ (string)$product_object->get_id() ] );
					}
				}
				break;
		}
	}
}

?>

<div class="wrap">
	<form method="post" action="?page=wcsm-stock-set-points">
		<input type="submit" class="button button-primary" value="Update Stock Set Points"/>
		<input type="hidden" name="submitted" value="set_points_update"/>
		<label for="stock-keeping-unit">Stock Keeping Unit:</label>
		<select id="stock-keeping-unit" name="stock_keeping_unit">
			<option value="stock_on_hand" <?php selected( 'stock_on_hand', $stock_keeping_unit, true ); ?>>Stock On Hand</option>
			<option value="stock_available" <?php selected( 'stock_available', $stock_keeping_unit, true ); ?>>Stock Available</option>
		</select>
		<table id="stock-adjust-table">
			<thead>
				<tr>
					<th>ID</th>
					<th>Product Name</th>
					<th>Out Of Stock Level</th>
					<th>Reorder Stock Level</th>
					<th>Low Stock Level</th>
				</tr>
			</thead>
			<?php
			foreach ( $products as $product_post ) {
				$product = new WSS_Product( $product_post->ID );
				switch ( $product->wc_product->product_type ) {
					case 'simple':
						$product_object = $product;
						if ( $product_object->wc_product->managing_stock() ):
							?>
							<tr class="product-row">
								<?php
								include( WSS_PLUGIN_LOCATION . '/templates/template-stock-set-points.php' );
								?>
							</tr>
							<?php
						endif;
						break;
					case 'variable':
						foreach ( $product->wc_product->get_children() as $child ) {
							$product_object = new WSS_Product( $child );
							if ( $product_object->wc_product->managing_stock() ):
								?>
								<tr class="product-row">
									<?php
									include( WSS_PLUGIN_LOCATION . '/templates/template-stock-set-points.php' );
									?>
								</tr>
								<?php
							endif;
						}
						break;
				}
			}
			?>
		</table>
		<input type="submit" class="button button-primary" value="Update Stock"/>
	</form>
</div>