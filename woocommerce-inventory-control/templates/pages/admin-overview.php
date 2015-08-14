<?php

/**
 * WC Stock Manager Overview admin page.
 * @since 0.1.0
 */

global $wc_inventory_control;

$product_ids = $wc_inventory_control->get_product_ids();
$single_products = WSS_Product_Handling::get_all_products();
$variations = $wc_inventory_control->get_variation_ids();

?>

<div class="wrap">
	<table style="border: 1px solid #000; ">
		<thead>
			<tr>
				<th style="border: 1px solid #000; padding: 10px;">ID</th>
				<th style="border: 1px solid #000; padding: 10px;">Image</th>
				<th style="border: 1px solid #000; padding: 10px;">Name</th>
				<th style="border: 1px solid #000; padding: 10px;">Total Sales</th>
				<th style="border: 1px solid #000; padding: 10px;">Stock</th>
			</tr>
		</thead>
		<?php
		foreach ( $single_products as $product ) {
			$wss_product = new WSS_Product( $product->ID );
			if ( $wss_product->wc_product->managing_stock() ):
				?>
				<tr>
					<td style="border: 1px solid #000; padding: 10px;"><?php echo $wss_product->get_id(); ?></td>
					<td style="border: 1px solid #000; padding: 10px;"><?php echo $wss_product->get_image_url(); ?></td>
					<td style="border: 1px solid #000; padding: 10px;"><?php echo $wss_product->get_name(); ?></td>
					<td style="border: 1px solid #000; padding: 10px;"><?php echo $wss_product->get_total_sales(); ?></td>
					<td style="border: 1px solid #000; padding: 10px;"><?php echo $wss_product->get_stock_available()?></td>
				</tr>
				<?php
			endif;
		}
		?>
	</table>
</div>