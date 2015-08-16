<?php

/**
 * Stock update page
 */

$products = WSS_Product_Handling::get_products();

if ( 'stock_update' == $_REQUEST[ 'submitted' ] ) {
	//  Update stock
	$product_amounts = $_REQUEST[ 'stock_update_amount' ];
	$product_update_method = $_REQUEST[ 'stock_update_method' ];

	foreach ( $product_amounts as $key => $amount ) {
		//  $update_product = wc_get_product( $key );
		$update_product = new WSS_Product( $key );
		$update_product->wc_product->set_stock( $amount, $product_update_method[ $key ] );
		$update_product->update_stock_on_hand( $amount, $product_update_method[ $key ] );
	}
}

?>

<div class="wrap">
	<form method="post" action="?page=wcsm-update-stocks">
		<input type="submit" class="button button-primary" value="Update Stock"/>
		<input type="hidden" name="submitted" value="stock_update"/>
		<table id="stock-adjust-table">
			<thead>
				<tr>
					<th>ID</th>
					<th>Current Stock</th>
					<th>Product</th>
					<th>Add</th>
					<th>Subtract</th>
					<th>Set</th>
					<th>Amount</th>
				</tr>
			</thead>
			<?php
			foreach ( $products as $product_post ) {
				$product = new WSS_Product( $product_post->ID );
				if ( $product->wc_product->managing_stock() ) :
					switch ( $product->wc_product->product_type ) {
						case 'simple':
							?>
							<tr class="product-row">
								<?php
								include( WSS_PLUGIN_LOCATION . '/templates/template-stock-adjust.php' );
								?>
							</tr>
							<?php
							break;
						case 'variable':

					}
				endif;
			}
			?>
		</table>
		<input type="submit" class="button button-primary" value="Update Stock"/>
	</form>
</div>