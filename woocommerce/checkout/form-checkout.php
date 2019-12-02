<?php

do_action('woocommerce_before_checkout_form', $checkout);

// If checkout registration is disabled and not logged in, the user cannot checkout.
if (!$checkout->is_registration_enabled() && $checkout->is_registration_required() && !is_user_logged_in()) {
    echo esc_html(apply_filters('woocommerce_checkout_must_be_logged_in_message', __('You must be logged in to checkout.', 'woocommerce')));
    return;
}

?>

<form name="checkout" method="post" class="checkout woocommerce-checkout"
      action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data">
    <div class="row">
        <?php if ($checkout->get_checkout_fields()) : ?>

            <?php do_action('woocommerce_checkout_before_customer_details'); ?>
            <div class="row  col-xl-7 col-md-5" id="customer_details">
                <div class="col-xl-6 col-12">
                    <?php do_action('woocommerce_checkout_billing'); ?>
                </div>

                <div class="col-xl-6 col-12">
                    <?php do_action('woocommerce_checkout_shipping'); ?>
                </div>
            </div>

            <?php do_action('woocommerce_checkout_after_customer_details'); ?>
        <?php endif; ?>
        <div class=" col-xl-5 col-md-7">
            <h3 id="order_review_heading "
                class="title line mb-5"><?php esc_html_e('Your order', 'woocommerce'); ?></h3>

            <?php do_action('woocommerce_checkout_before_order_review'); ?>

            <div id="order_review" class="woocommerce-checkout-review-order">
                <?php do_action('woocommerce_checkout_order_review'); ?>
            </div>

            <?php do_action('woocommerce_checkout_after_order_review'); ?>
        </div>
    </div>
</form>

<?php do_action('woocommerce_after_checkout_form', $checkout); ?>
