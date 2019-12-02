<h1 class="title main-title line">Password recovery</h1>
<div class="recovery-form">
    <div class="base-title text-center">Forgot You Password?</div>
    Enter you email address below, and we’ll email you a link to set a new password
    <form method="post" class="woocommerce-ResetPassword lost_reset_password">
        <div class="form-group">
            <input class="control-form" type="text" name="user_login" id="user_login" placeholder="Email" required>
        </div>
        <div class="form-group text-center">
            <input type="hidden" name="wc_reset_password" value="true"/>
            <button type="submit" class="button btn-cyan btn-lg w-100" value="Email me">Email me</button>
        </div>
        <div class="text-center">
            <a href="<? account_url() ?>" class="link">Cancel</a>
        </div>
        <? wp_nonce_field('lost_password', 'woocommerce-lost-password-nonce'); ?>
    </form>
</div>
