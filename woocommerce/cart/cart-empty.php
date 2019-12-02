<div class="text-center base-indent">
    <div class="base-title mb-5">
        <? do_action('woocommerce_cart_is_empty'); ?>
    </div>
    <? if (wc_get_page_id('shop') > 0) : ?>
        <p class="return-to-shop">
            <a class="button btn-cyan w-100 btn-lg" href="<? shop_url() ?>">
                <? esc_html_e('Return to shop', 'woocommerce'); ?>
            </a>
        </p>
    <?php endif; ?>
</div>