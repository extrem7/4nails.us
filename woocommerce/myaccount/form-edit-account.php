<div class="row personal-info">
    <div class="col-md-12 col-lg-6">
        <div class="title third-title line">Personal Information</div>
        <form method="post">
            <div class="form-group">
                <label for="account_first_name">First name&nbsp;<span class="required">*</span></label>
                <input type="text" class="control-form" name="account_first_name" id="account_first_name"
                       autocomplete="given-name" value="<?= esc_attr($user->first_name); ?>"/>
            </div>
            <div class="form-group">
                <label for="account_last_name">Last name&nbsp;<span class="required">*</span></label>
                <input type="text" class="control-form" name="account_last_name" id="account_last_name"
                       autocomplete="family-name" value="<?= esc_attr($user->last_name); ?>"/>
            </div>
            <div class="form-group box-tooltip">
                <label for="account_email">Email address&nbsp;<span class="required">*</span></label>
                <input type="email" class="control-form" name="account_email" id="account_email" autocomplete="email"
                       value="<?= esc_attr($user->user_email); ?>"/>
                <? nails()->views()->tooltip() ?>
            </div>
            <fieldset>
                <div class="form-group control-icon box-tooltip">
                    <label for="password_current">Current password (leave blank to leave unchanged)</label>
                    <div class="control-icon">
                        <input type="password" class="control-form" name="password_current" id="password_current"
                               autocomplete="off"/>
                        <button class="icon show-pass"></button>
                    </div>
                    <? nails()->views()->tooltip() ?>
                </div>
                <div class="form-group control-icon box-tooltip">
                    <label for="password_1">New password (leave blank to leave unchanged)</label>
                    <div class="control-icon">
                        <input type="password" class="control-form" name="password_1" id="password_1"
                               autocomplete="off"/>
                        <button class="icon show-pass"></button>
                    </div>
                    <? nails()->views()->tooltip() ?>
                </div>
                <div class="form-group control-icon box-tooltip">
                    <label for="password_2">Confirm new password</label>
                    <div class="control-icon">
                        <input type="password" class="control-form" name="password_2" id="password_2"
                               autocomplete="off"/>
                        <button class="icon show-pass"></button>
                    </div>
                    <? nails()->views()->tooltip() ?>
                </div>
            </fieldset>
            <div class="title third-title line">Subscription settings</div>
            <?
            $subscriptions = [
                'new' => [
                    'label' => 'New items',
                    'field' => 'new_items'
                ],
                'promotion' => [
                    'label' => 'Promotions and discounts',
                    'field' => 'promotions_and_discounts'
                ],
                'information' => [
                    'label' => 'Useful information',
                    'field' => 'useful_information'
                ]
            ];
            foreach ($subscriptions as $key => $item):
                ?>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" name="subscribe[<?= $key ?>]"
                               id="subscribe-<?= $key ?>" <? the_checkbox($item['field'], 'checked', 'user_' . get_current_user_id()) ?>>
                        <label class="custom-control-label" for="subscribe-<?= $key ?>"><?= $item['label'] ?></label>
                    </div>
                </div>
            <? endforeach; ?>
            <div class="form-group d-flex justify-content-between flex-column flex-sm-row align-items-center">
                <? wp_nonce_field('save_account_details', 'save-account-details-nonce'); ?>
                <button type="submit" class="button btn-cyan w-100" name="save_account_details"
                        value="Save changes">Save changes
                </button>
                <a href="<? account_url() ?>" class="button btn-cyan-outline w-100 mt-2 mt-sm-0">Cancel</a>
                <input type="hidden" name="action" value="save_account_details"/>
            </div>
        </form>
    </div>
</div>
