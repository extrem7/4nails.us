<div class="cart-mini">
    <div class="d-none cart-fragments">
        <span class="qty"><? cart_content() ?></span>
    </div>
    <?php if (!WC()->cart->is_empty()) : ?>
        <div class="mini-content">
            <?php
            do_action('woocommerce_before_mini_cart_contents');

            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
                    $product_name = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
                    $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
                    $product_price = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
                    $product_subtotal = apply_filters('woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf('%s &times; %s', $cart_item['quantity'], $product_price) . '</span>', $cart_item, $cart_item_key);
                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                    ?>
                    <div class="cart-item">
                        <a href="<?= $product_permalink ?>" class="product-link">
                            <div class="photo" style="background-image: url('<?= wp_get_attachment_image_url($_product->get_image_id()) ?>')"></div>
                            <div class="product-name"><?= $product_name ?></div>
                        </a>
                        <div class="product-price"><?= $product_subtotal ?></div>
                        <?= apply_filters('woocommerce_cart_item_remove_link', sprintf(
                            '<a href="%s" class="remove remove_from_cart_button" aria-label="%s" data-product_id="%s" data-cart_item_key="%s" data-product_sku="%s"><img src="%s" alt=""></a>',
                            esc_url(wc_get_cart_remove_url($cart_item_key)),
                            __('Remove this item', 'woocommerce'),
                            esc_attr($product_id),
                            esc_attr($cart_item_key),
                            esc_attr($_product->get_sku()),
                            path() . 'assets/img/icons/delete_b.svg'
                        ), $cart_item_key); ?>
                    </div>
                    <?php
                }
            }
            ?>
            <div class="cart-separator"></div>
            <div class="subtotal">
                Subtotal (<? cart_content(); cart_items() ?>): <span
                        class="price"><?= wc_price(WC()->cart->get_cart_contents_total()) ?></span>
            </div>
            <div class="d-flex justify-content-center">
                <a href="<? cart_url() ?>" class="button btn-cyan mr-3">View Cart</a>
                <a href="<? checkout_url() ?>" class="button btn-cyan">Checkout</a>
            </div>
        </div>
    <?php else : ?>
        <div class="title four-title">cart is empty</div>
    <?php endif; ?>
</div>
