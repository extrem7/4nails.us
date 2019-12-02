<?php

$page_title = ('billing' === $load_address) ? __('Billing address', 'woocommerce') : __('Shipping address', 'woocommerce');

if (!$load_address):
    wc_get_template('myaccount/my-address.php');
else:
    ?>
    <div class="row personal-info">
        <div class="col-md-12 col-lg-6">
            <div class="title third-title line"><?= $page_title ?></div>
            <form method="post">
                <?
                foreach ($address as $key => $field) {
                    if (isset($field['country_field'], $address[$field['country_field']])) {
                        $field['country'] = wc_get_post_data_by_key($field['country_field'], $address[$field['country_field']]['value']);
                    }

                    $field['class'][] = 'form-group';
                    if (in_array($key, ['billing_email'])) {
                        $field['class'][] = 'box-tooltip';
                    }
                    $field['input_class'][] = 'control-form';

                    woocommerce_form_field($key, $field, wc_get_post_data_by_key($key, $field['value']));
                }
                ?>
                <div class="form-group d-flex justify-content-between flex-column flex-sm-row align-items-center">
                    <button type="submit" class="button btn-cyan w-100" name="save_address" value="Save address">Save
                        address
                    </button>
                    <a href="<? account_url() ?>edit-address/"
                       class="button btn-cyan-outline w-100 mt-2 mt-sm-0">Cancel</a>
                    <? wp_nonce_field('woocommerce-edit_address', 'woocommerce-edit-address-nonce'); ?>
                    <input type="hidden" name="action" value="edit_address"/>
                </div>
            </form>
            <div class="d-none tooltip-button-wrap">
                <? nails()->views()->tooltip() ?>
            </div>
        </div>
    </div>
<? endif; ?>
