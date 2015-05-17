<?php

/**
 * WC Stock Manager Overview admin page.
 */

global $wc_inventory_manager;

$product_ids = $wc_inventory_manager->get_product_ids();
$variations = $wc_inventory_manager->get_variation_ids();

?>

<div class="wrap">
    <table style="border: 1px solid #000; ">
        <thead>
        <tr>
            <th style="border: 1px solid #000;">ID</th>
            <th style="border: 1px solid #000;">Name</th>
            <th style="border: 1px solid #000;">Price</th>
            <th style="border: 1px solid #000;">Managing Stock</th>
            <th style="border: 1px solid #000;">Stock</th>
        </tr>
        </thead>
        <?php
        foreach ( $product_ids as $id ) {
            $product = wc_get_product( $id );

            ?>
            <tr>
                <td style="border: 1px solid #000;"><?php echo $product->id; ?></td>
                <td style="border: 1px solid #000;"><?php echo $product->get_title(); ?></td>
                <td style="border: 1px solid #000;"><?php echo $product->get_price(); ?></td>
                <td style="border: 1px solid #000;"><?php echo $product->managing_stock() ? 'Yes' : 'No'; ?></td>
                <td style="border: 1px solid #000;"><?php echo $product->managing_stock() ? $product->get_stock_quantity() : 'Not Managing Stock'; ?></td>
            </tr>
        <?php
        }

        foreach ( $variations as $id ) {
            $product = wc_get_product( $id );

            ?>
            <tr>
                <td>ID: <?php echo $product->id; ?></td>
                <td>Name: <?php echo $product->get_title(); ?></td>
                <td>Price: <?php echo $product->get_price(); ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
</div>