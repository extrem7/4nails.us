<?php

$customer_id = get_current_user_id();

$addresses = [
    'billing' => 'Home (Primary Billing)',
    'shipping' => 'Home (Primary Shipping)'
];

?>
<div class="row address-info">
    <? foreach ($addresses as $name => $title) :
        $url = esc_url(wc_get_endpoint_url('edit-address', $name));
        $address = wc_get_account_formatted_address($name);
        $address = $address ? wp_kses_post($address) : 'You have not set up this type of address yet.';
        ?>
        <div class="col-md-12 col-lg-6">
            <div class="title third-title line"><?= $title; ?></div>
            <address class="base-title"><?= $address ?></address>
            <a href="<?= $url ?>" class="link">Edit</a>
        </div>
    <?php endforeach; ?>
</div>
