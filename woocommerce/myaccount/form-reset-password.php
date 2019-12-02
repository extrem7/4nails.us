<h1 class="title main-title line">Reset You Password</h1>
<div class="login-form text-center">
    <img src="<?= path() ?>assets/img/icons/passwordr.svg" alt="">
    <div class="mt-4 mb-3">Enter a new password for you account.</div>
    <form method="post">
        <div class="form-group control-icon">
            <input type="password" class="control-form" name="password_1" id="password_1" autocomplete="new-password"/>
            <button class="icon show-pass"></button>
        </div>
        <div class="form-group control-icon">
            <input type="password" class="control-form" name="password_2" id="password_2" autocomplete="new-password"/>
            <button class="icon show-pass"></button>
        </div>
        <input type="hidden" name="reset_key" value="<?= esc_attr($args['key']); ?>"/>
        <input type="hidden" name="reset_login" value="<?= esc_attr($args['login']); ?>"/>
        <div class="form-group text-center">
            <input type="hidden" name="wc_reset_password" value="true"/>
            <button type="submit" class="button btn-cyan btn-lg w-100" value="Reset Password">Reset Password</button>
        </div>
        <div class="text-center">
            <a href="<? account_url() ?>" class="link">Cancel</a>
        </div>
        <? wp_nonce_field('reset_password', 'woocommerce-reset-password-nonce'); ?>
    </form>
</div>
