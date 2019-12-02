<div class="tinv-wishlist woocommerce">
    <? wc_print_notices(); ?>
    <div class="text-center base-indent">
        <div class="base-title mb-5">
            <? if (get_current_user_id() === $wishlist['author']) {
                esc_html_e('Your Wishlist is currently empty.', 'ti-woocommerce-wishlist');
            } else {
                esc_html_e('Wishlist is currently empty.', 'ti-woocommerce-wishlist');
            } ?>
        </div>

        <p class="return-to-shop">
            <a class="button btn-cyan w-100 btn-lg" href="<? shop_url() ?>">Return To Shop</a>
        </p>
    </div>
</div>