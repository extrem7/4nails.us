<?php

global $product;

$isVariable = $product->is_type('variable');
?>
<? if ($product->is_on_sale()) :
    $sale = $isVariable ? $product->get_variation_sale_price('min', true) : $product->get_sale_price();
    $regular = $isVariable ? $product->get_variation_regular_price('min', true) : $product->get_regular_price();
    $discount = 100 - intval(($sale / $regular) * 100);
    ?>
    <span class="label-product sale">Sale <?= $discount ?>%</span>
<? endif;