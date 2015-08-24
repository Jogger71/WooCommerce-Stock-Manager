<?php

/**
 * File for setting the stock set points
 *
 * @var WSS_Product $product_object
 * @since 0.3.0
 */


printf( '<td class="column-id">%s</td>', $product_object->get_id() );
printf( '<td class="column-product-name">%s</td>', $product_object->get_name() );
printf( '<td class="column-out-of-stock"><input class="out_of_stock" type="number" data-id="%1$s" name="out_of_stock_set_point[ %1$s ]" value="%2$s" min="0" max="%3$s" /></td>', $product_object->get_id(), $product_object->get_out_of_stock_set_point(), $product_object->get_reorder_set_point() );
printf( '<td class="column-reorder-stock"><input class="reorder" type="number" data-id="%1$s" name="reorder_stock_set_point[ %1$s ]" value="%2$s" min="%3$s" max="%4$s" /></td>', $product_object->get_id(), $product_object->get_reorder_set_point(), $product_object->get_out_of_stock_set_point(), $product_object->get_low_stock_set_point() );
printf( '<td class="column-low-stock"><input type="number" data-id="%1$s" name="low_stock_set_point[ %1$s ]" value="%2$s" min="%3$s" /></td>', $product_object->get_id(), $product_object->get_low_stock_set_point(), $product_object->get_reorder_set_point() );