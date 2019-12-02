<?php wp_enqueue_script('tinvwl'); ?>
<div class="tinv-wishlist woocommerce tinv-wishlist-clear">
    <? if (!empty(wc_get_notices())): ?>
        <div class="notices-area w-100"><? wc_print_notices() ?></div>
    <? endif; ?>
    <form action="<?= esc_url(tinv_url_wishlist()); ?>" method="post" autocomplete="off">
        <div class="row catalog wishlist-list <?= !is_user_logged_in() ? 'base-indent' : '' ?>">
            <?
            global $wl_product;
            foreach ($products as $wl_product) {
                global $product, $post;
                $product = apply_filters('tinvwl_wishlist_item', $wl_product['data']);
                $post = $product->get_id();
                if ($wl_product['quantity'] > 0 && apply_filters('tinvwl_wishlist_item_visible', true, $wl_product, $product))
                    wc_get_template_part('content', 'product');
            }
            ?>
        </div>
        <?= wp_nonce_field('tinvwl_wishlist_owner', 'wishlist_nonce'); ?>
    </form>
</div>
