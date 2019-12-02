<?php
$username = (!empty($_POST['username'])) ? esc_attr(wp_unslash($_POST['username'])) : '';
$first_name = (!empty($_POST['first_name'])) ? esc_attr(wp_unslash(trim($_POST['first_name']))) : '';
$last_name = (!empty($_POST['last_name'])) ? esc_attr(wp_unslash(trim($_POST['last_name']))) : '';
$email = (!empty($_POST['email'])) ? esc_attr(wp_unslash($_POST['email'])) : '';
?>

<h1 class="title main-title line">Log in or create an Account</h1>
<? wc_print_notices(); ?>
<? do_action('woocommerce_before_customer_login_form');//errors ?>
<div class="row">
    <div class="col-md-6">
        <div class="login-form">
            <form class="woocommerce-form woocommerce-form-login login" method="post">
                <div class="form-group">
                    <input type="text" class="control-form" name="username"
                           id="username" autocomplete="username" placeholder="Email" value="<?= $username ?>" required>
                </div>
                <div class="form-group">
                    <div class="control-icon">
                        <input type="password" class="control-form" placeholder="Password" name="password" id="password"
                               autocomplete="current-password" required>
                        <button class="icon show-pass"></button>
                    </div>
                </div>
                <div class="form-group">
            <span class="small-size">Forgot Your Password?
                <a href="<?= esc_url(wp_lostpassword_url()); ?>" class="link">Click here</a></span>
                </div>
                <div class="form-group text-center">
                    <? wp_nonce_field('woocommerce-login', 'woocommerce-login-nonce'); ?>
                    <button type="submit" name="login" class="button btn-cyan btn-lg w-100" value="Sign In">Sign In
                    </button>
                    <div class="custom-control custom-checkbox mt-3">
                        <input class="custom-control-input" name="rememberme" type="checkbox" id="rememberme"
                               value="forever"/>
                        <label class="custom-control-label" for="rememberme">Remember me</label>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-md-6">
        <div class="registration-form">
            <form method="post" class="woocommerce-form woocommerce-form-register register">
                <div class="form-group">
                    <label>First Name <span class="required">*</span></label>
                    <input type="text" name="first_name" id="first_name" class="control-form" value="<?= $first_name ?>"
                           size="25" required>
                </div>
                <div class="form-group">
                    <label>Last Name <span class="required">*</span></label>
                    <input type="text" name="last_name" id="last_name" class="control-form" value="<?= $last_name ?>"
                           size="25" required>
                </div>
                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" class="control-form" name="email" id="email" value="<?= $email ?>" required>
                </div>
                <div class="form-group box-tooltip">
                    <label for="reg_password">Password <span class="required">*</span></label>
                    <div class="control-icon">
                        <input type="password" class="control-form" name="password" id="reg_password" required>
                        <button class="icon show-pass"></button>
                    </div>
                    <? nails()->views()->tooltip() ?>
                </div>
                <div class="form-group box-tooltip">
                    <label for="conf_password">Confirm Password <span class="required">*</span></label>
                    <div class="control-icon">
                        <input type="password" class="control-form" id="conf_password" name="conf_password" required>
                        <button class="icon show-pass"></button>
                    </div>
                    <? nails()->views()->tooltip() ?>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="subscribe" name="subscribe">
                        <label class="custom-control-label" for="subscribe">Would you like to receive e-mails regarding
                            exciting «Mash’s nails shop» promotions, product information and upcoming events?</label>
                    </div>
                </div>
                <div class="form-group text-center">
                    <? wp_nonce_field('woocommerce-register', 'woocommerce-register-nonce'); ?>
                    <button type="submit" class="button btn-cyan btn-lg w-100" name="register" value="Create Account">
                        Create
                        Account
                    </button>
                </div>
                <div class="text-center small-size mt-3">
                    By clicking this button, you agree to our <a href="<?= get_privacy_policy_url() ?>" class="link">Privacy
                        Policy.</a>
                </div>
            </form>
        </div>
    </div>
</div>