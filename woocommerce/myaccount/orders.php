<?
if ($has_orders) :
    $orders = wc_get_orders(['customer' => get_user_meta(get_current_user_id(), 'email', true), 'limit' => -1]);
    ?>
    <form method="post">
        <table class="cabinet-orders">
            <thead>
            <tr>
                <th>Date</th>
                <th>Order #</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
            </thead>
            <tbody>
            <? foreach ($orders as $order) :
                $order = wc_get_order($order);
                $date = $order->get_date_created()->date('d.m.Y');
                $url = $order->get_view_order_url();
                $number = $order->get_order_number();
                $status = $order->get_status();
                $cancel = nails()->woo->cancelOrder($order);
                ?>
                <tr>
                    <td><?= $date ?></td>
                    <td><a href="<?= $url ?>">#<?= $number ?></a></td>
                    <td class="<?= $status ?> text-left">
                        <div class="status-box">
                            <div><span class="status"></span><?= ucwords($status) ?></div>
                            <? if ($cancel !== false): ?>
                                <a href="<?= $cancel ?>" class="button btn-cyan-outline cancel-order">Cancel</a>
                            <? endif; ?>
                        </div>
                    </td>
                    <td><?= $order->get_formatted_order_total() ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </form>
<?php else : ?>
    <div class="woocommerce-message woocommerce-message--info woocommerce-Message woocommerce-Message--info woocommerce-info">
        <a class="woocommerce-Button button btn-cyan"
           href="<?= esc_url(apply_filters('woocommerce_return_to_shop_redirect', wc_get_page_permalink('shop'))); ?>">
            <? _e('Go shop', 'woocommerce') ?>
        </a>
        <? _e('No order has been made yet.', 'woocommerce'); ?>
    </div>
<?php endif; ?>
