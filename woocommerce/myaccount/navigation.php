<?php
function isWishlist($endpoint)
{
    echo $endpoint == 'tinv_wishlist' && is_wishlist() ? ' active is-active' : '';
}

?>
<nav class="col-md-3">
    <ul class="cabinet-menu">
        <? foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
            <li class="<?= wc_get_account_menu_item_classes($endpoint);
            isWishlist($endpoint) ?>">
                <a href="<?= esc_url(wc_get_account_endpoint_url($endpoint)); ?>"><?php echo esc_html($label); ?></a>
            </li>
        <?php endforeach; ?>
    </ul>
</nav>
