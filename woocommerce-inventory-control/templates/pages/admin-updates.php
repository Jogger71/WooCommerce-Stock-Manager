<?php

/**
 * Stock update page
 */

global $wc_inventory_control;

$product_ids = $wc_inventory_control->get_product_ids();

if ( 'stock_update' == $_REQUEST['submitted'] ) {
	//  Update stock
	$product_amounts = $_REQUEST['stock_update_amount'];
	$product_update_method = $_REQUEST['stock_update_method'];

	foreach ( $product_amounts as $key => $amount ) {
		$update_product = wc_get_product( $key );
		$update_product->set_stock( $amount, $product_update_method[$key] );
	}
}

?>

<div class="wrap">
	<form method="post" action="?page=wcsm-update-stocks">
		<input type="submit" class="button button-primary" value="Update Stock" />
		<input type="hidden" name="submitted" value="stock_update" />
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
			foreach ( $product_ids as $id ) {
				$product = wc_get_product( $id );
				?>
				<tr class="product-row">
					<?php
					include( $wc_inventory_control->get_plugin_path() . 'templates/template-stock-adjust.php' );
					?>
				</tr>
			<?php
			}
			?>
		</table>
		<input type="submit" class="button button-primary" value="Update Stock" />
	</form>
</div>