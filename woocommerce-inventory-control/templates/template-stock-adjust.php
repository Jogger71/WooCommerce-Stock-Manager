<?php

/**
 * Template for outputting the products for updating
 *
 * System used from simple selection
 */
?>

<td class="column-id">
	<?php echo $product->get_id (); ?>
</td>
<td class="column-stock <?php echo $product->wc_product->managing_stock () ? ( ( $product->wc_product->get_stock_quantity () == 0 ) ? 'out-of-stock' : 'in-stock' ) : 'not-managing'; ?>">
	<?php echo $product->wc_product->managing_stock () ? $product->wc_product->get_stock_quantity () : 'Not Managing Stock'; ?>
</td>
<td class="column-name">
	<?php echo $product->wc_product->get_title (); ?>
</td>
<td class="column-add">
	<label class="switch switch-green">
		<input type="radio" class="switch-input" name="stock_update_method[<?php echo $product->get_id (); ?>]" value="add" checked/>
		<span class="switch-label" data-on="On" data-off="Off"></span>
		<span class="switch-handle"></span>
	</label>
</td>
<td class="column-subtract">
	<label class="switch switch-green">
		<input type="radio" class="switch-input" name="stock_update_method[<?php echo $product->get_id (); ?>]" value="subtract"/>
		<span class="switch-label" data-on="On" data-off="Off"></span>
		<span class="switch-handle"></span>
	</label>
</td>
<td class="column-set">
	<label class="switch switch-green">
		<input type="radio" class="switch-input" name="stock_update_method[<?php echo $product->get_id (); ?>]" value="set"/>
		<span class="switch-label" data-on="On" data-off="Off"></span>
		<span class="switch-handle"></span>
	</label>
</td>
<td class="column-amount">
	<input type="text" name="stock_update_amount[<?php echo $product->get_id (); ?>]" placeholder="Amount"/>
</td>