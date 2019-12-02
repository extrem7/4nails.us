<?php
$pdf = nails()->woo->invoice($order);
?>
<div class="title third-title">
    <a href="<?= wc_get_account_menu_item_classes('orders') ?>" class="mr-1" target="_blank">
        <? the_icon('arrow_back') ?></a>Details for Order #<?= $order->get_order_number() ?></div>
<div class="mt-1 mb-1">Date: <?= $order->get_date_created()->date('d.m.Y'); ?></div>
<? if ($pdf !== false): ?>
    <div>
        <a href="<?= $pdf ?>" class="link" target="_blank">Print this page for your records
            <span class="ml-3"><? the_icon('pdf') ?></span></a>
    </div>
<? endif; ?>
<table class="cabinet-orders order-detail">
    <thead>
    <tr>
        <th>#</th>
        <th>Item Details</th>
        <th>Qty</th>
        <th>Rate</th>
        <th>Amount</th>
    </tr>
    </thead>
    <tbody>
    <?
    $i = 0;
    foreach ($order->get_items() as $item):
        $i++;
        $itemData = $item->get_data();
        $link = get_permalink($itemData['product_id']);
        $price = $itemData['subtotal'] / $item->get_quantity();
        ?>
        <tr>
            <td><?= $i ?></td>
            <td class="small-size">
                <? if ($link): ?><a href="<?= $link ?>" class="link" target="_blank"><? endif; ?>
                    <?= $item->get_name() ?>
                    <? if ($link): ?></a><? endif; ?>
            </td>
            <td>
                <span class="mob-title base-title">Qty</span>
                <?= $item->get_quantity() ?>
            </td>
            <td>
                <span class="mob-title base-title">Rate</span>
                <?= wc_price($price) ?>
            </td>
            <td>
                <span class="mob-title base-title">Amount</span>
                <?= wc_price($itemData['subtotal']) ?>
            </td>
        </tr>
    <? endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="3" class="text-right"></td>
        <td>Sub total:</td>
        <td><span class="base-title"><?= $order->get_subtotal_to_display() ?></span></td>
    </tr>
    <tr>
        <td colspan="3" class="text-right"></td>
        <td>Shipping Charges:</td>
        <td><span class="base-title">$<?= $order->get_shipping_total() ?></span></td>
    </tr>
    <tr>
        <td colspan="3" class="text-right"></td>
        <td>Total ($):</td>
        <td><span class="base-title"><?= $order->get_formatted_order_total() ?></span></td>
    </tr>
    </tfoot>
</table>
