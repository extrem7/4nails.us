<form class="woocommerce-cart-form" action="<?= esc_url(wc_get_cart_url()); ?>" method="post">
    <div class="notices-area w-100"><? wc_print_notices() ?></div>
    <div class="row">
        <div class="col-md-12 col-lg-9">
            <div class="gift-label">
                <img src="<?= path() ?>assets/img/icons/gift.svg" alt=""> <?= nails()->woo->freeShipping(); ?>
            </div>
            <? if (is_user_logged_in() && $discount = get_field('individual_discount', 'user_' . get_current_user_id())): ?>
                <div class="gift-label mt-3">
                    <img src="<?= path() ?>assets/img/icons/heart_b.svg" alt=""> <?= $discount ?>% твоя индивидуальная скидка
                </div>
            <? endif; ?>
            <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents">
                <thead>
                <tr>
                    <th class="product-thumbnail">&nbsp;</th>
                    <th class="product-price"><? esc_html_e('Price', 'woocommerce'); ?></th>
                    <th class="product-quantity"><? esc_html_e('Quantity', 'woocommerce'); ?></th>
                    <th class="product-subtotal"><? esc_html_e('Total', 'woocommerce'); ?></th>
                    <th class="product-close">&nbsp;</th>
                </tr>
                </thead>
                <tbody>
                <?
                foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
                    $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                    $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                    if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) :
                        $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                        ?>
                        <tr class="woocommerce-cart-form__cart-item <?= esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                            <td class="product-thumbnail">
                                <a href="<?= $product_permalink ?>" class="d-flex">
                                    <div class="photo"
                                         style="background-image: url('<?= wp_get_attachment_image_url($_product->get_image_id(), 'full') ?>')"></div>
                                    <p class="product-name"><?= $_product->get_name() ?></p>
                                </a>
                            </td>
                            <td class="product-price" data-title="<? esc_attr_e('Price', 'woocommerce'); ?>">
                                <?= apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); ?>
                            </td>
                            <td class="product-quantity" data-title="<? esc_attr_e('Quantity', 'woocommerce'); ?>">
                                <?
                                $product_quantity = woocommerce_quantity_input([
                                    'input_name' => "cart[{$cart_item_key}][qty]",
                                    'input_value' => $cart_item['quantity'],
                                    'max_value' => $_product->get_max_purchase_quantity(),
                                    'min_value' => '0',
                                    'product_name' => $_product->get_name(),
                                ], $_product, false);
                                echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item);
                                ?>
                            </td>
                            <td class="product-subtotal" data-title="<? esc_attr_e('Total', 'woocommerce'); ?>">
                                <?= apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); ?>
                            </td>
                            <td class="product-remove">
                                <?= apply_filters('woocommerce_cart_item_remove_link', sprintf(
                                    '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><img src="%s" alt="">
                                              <span>Delete</span></a>',
                                    esc_url(wc_get_cart_remove_url($cart_item_key)),
                                    __('Remove this item', 'woocommerce'),
                                    esc_attr($product_id),
                                    esc_attr($_product->get_sku()),
                                    path() . 'assets/img/icons/delete_b.svg'
                                ), $cart_item_key); ?>
                                <button class="save icon" name="save" value="<?= $cart_item_key ?>">Save for later
                                </button>
                            </td>
                        </tr>
                    <?
                    endif;
                endforeach;
                ?>
                </tbody>
            </table>
            <div class="actions">
                <div class="buttons">
                    <a href="<? shop_url() ?>" class="button btn-cyan btn-lg w-100">Continue shopping</a>
                    <button type="submit" name="update_cart" hidden></button>
                    <? wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                </div>
                <p class="totals">Subtotal (<? cart_content();
                    cart_items() ?>): <span class="price"><? cart_total() ?></span>
                </p>
            </div>
        </div>
        <div class="col-md-12 col-lg-3">
            <div class="box-info">
                <div class="subtotal">
                    <div>Subtotal (<? cart_content();
                        cart_items() ?>):
                    </div>
                    <div class="price"><? cart_total() ?></div>
                </div>
                <? woocommerce_button_proceed_to_checkout() ?>
                <div class="paypal mt-3 pb-3">
                    <? // nails()->woo->cartPayPal() ?>
                </div>
            </div>
        </div>
    </div>
</form>