<?php

global $product;
$product = wc_get_product($post);

get_header(); ?>
    <main class="content">
        <div class="container">
            <div class="notices-area w-100"><? wc_print_notices() ?></div>
            <? woocommerce_template_single_title() ?>
            <div class="row product base-indent" data-id="<? the_ID() ?>">
                <div class="col-md-12 col-lg-6 product-gallery">
                    <div class="gallery">
                        <? woocommerce_show_product_images() ?>
                        <? woocommerce_show_product_thumbnails() ?>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6 product-info">
                    <div class="box-info">
                        <p class="number">Item: # <? the_sku() ?> </p>
                        <? wc_get_template_part('single-product/stock') ?>
                        <? wc_get_template_part('single-product/short-description') ?>
                        <? woocommerce_template_single_rating() ?>
                        <?
                        if ($product->is_type('variable')) {
                            woocommerce_variable_add_to_cart();
                        } else {
                            woocommerce_simple_add_to_cart();
                        } ?>
                    </div>
                    <?
                    if ($product->is_type('variable')) wc_get_template_part('single-product/variations') ?>
                    <? woocommerce_template_single_sharing() ?>
                </div>
                <? woocommerce_output_product_data_tabs() ?>
            </div>
            <? woocommerce_output_related_products() ?>
        </div>
    </main>
<? get_footer();
