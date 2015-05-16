<?php

/**
 * Template for outputting the products for updating
 *
 * System used from simple selection
 */
?>

<td>
	<div class="wcsm_adjust_top_wrapper">
		<span class="product-id">ID: <?php echo $product->id; ?></span>
		<span class="product-name"><?php echo $product->get_title(); ?></span>
	</div>
</td>
<td>
	<div class="wscm-adjust-top-wrapper">
		<div class="label">Add</div>
		<div class="label">Subtract</div>
		<div class="label">Set</div>
	</div>
	<div class="wscm-adjust-bottom-wrapper">
		<div class="wcsm-controls-container">
			<label class="switch switch-green">
				<input type="radio" class="switch-input" name="stock_update_method[<?php echo $product->id; ?>]" value="add" checked />
				<span class="switch-label" data-on="On" data-off="Off"></span>
				<span class="switch-handle"></span>
			</label>

			<label class="switch switch-green">
				<input type="radio" class="switch-input" name="stock_update_method[<?php echo $product->id; ?>]" value="subtract" />
				<span class="switch-label" data-on="On" data-off="Off"></span>
				<span class="switch-handle"></span>
			</label>

			<label class="switch switch-green">
				<input type="radio" class="switch-input" name="stock_update_method[<?php echo $product->id; ?>]" value="set" />
				<span class="switch-label" data-on="On" data-off="Off"></span>
				<span class="switch-handle"></span>
			</label>
		</div>
	</div>
</td>
<td>
	<div class="wscm-adjust-top-wrapper">
		Adjustment Amount
	</div>
	<div class="wscm-adjust-bottom-wrapper">
		<input type="text" name="stock_update_amount[<?php echo $product->id; ?>]" />
	</div>
</td>
