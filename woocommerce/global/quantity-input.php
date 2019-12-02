<?php

if ($max_value && $min_value === $max_value) {
    ?>
    <div class="quantity hidden">
        <input type="hidden" id="<?= esc_attr($input_id); ?>" class="qty"
               name="<?= esc_attr($input_name); ?>" value="<?= esc_attr($min_value); ?>"/>
    </div>
    <?php
} else {
    /* translators: %s: Quantity. */
    $labelledby = !empty($args['product_name']) ? sprintf(__('%s quantity', 'woocommerce'), strip_tags($args['product_name'])) : '';
    ?>
    <div class="quantity">
        <button class="qty-btn qty-minus minus" type="button">
            <img src="<?= path() ?>assets/img/icons/minus.svg" alt="">
        </button>
        <input
                type="number"
                id="<?= esc_attr($input_id); ?>"
                class="input-text qty text"
                step="<?= esc_attr($step); ?>"
                min="<?= esc_attr($min_value); ?>"
                name="<?= esc_attr($input_name); ?>"
                value="<?= esc_attr($input_value); ?>"
                title="<?= esc_attr_x('Qty', 'Product quantity input tooltip', 'woocommerce'); ?>"
                size="4"/>
        <button class="qty-btn qty-plus plus" type="button">
            <img src="<?= path() ?>assets/img/icons/plus.svg" alt="">
        </button>
    </div>
    <?php
}