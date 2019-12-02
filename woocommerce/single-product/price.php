<?php

global $product;

$classPrefix = 'product-';

$isVariable = $product->is_type('variable');
$sale = $isVariable ? $product->get_variation_sale_price('min', true) : $product->get_sale_price();
$regular = $isVariable ? $product->get_variation_regular_price('min', true) : $product->get_regular_price();

if ((in_the_loop() || is_main_query()) && !is_single()) $classPrefix .= 'card-';

if ($product->is_on_sale()):?>
    <div class="<?= $classPrefix ?>old-price"><?= wc_price($regular) ?></div>
<? endif; ?>
<div class="<?= $classPrefix ?>price"><?= wc_price($product->get_price()); ?>
    <? if (!is_wishlist()) echo str_replace('tinvwl-icon-heart', '', do_shortcode('[ti_wishlists_addtowishlist]')); ?>
</div>
