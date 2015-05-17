<?php

/**
 * WC Stock Manager Overview admin page.
 */

global $wc_stock_manager;

$product_ids = $wc_stock_manager->get_product_ids();

?>

<div class="wrap">
    <table>
        <?php
        foreach ( $product_ids as $id ) {
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