<? /* Template Name: Wishlist */
$isLogged = is_user_logged_in();
?>
<? get_header(); ?>
    <main class="content">
        <div class="container">
            <h1 class="title main-title line"><?= $isLogged ? 'My Account' : 'Your wishlist' ?></h1>
            <? if ($isLogged): ?>
                <div class="cabinet">
                    <div class="row">
                        <? do_action('woocommerce_account_navigation'); ?>
                        <div class="col-md-9">
                            <? the_post_content() ?>
                        </div>
                    </div>
                </div>
            <? else: ?>
                <? the_post_content() ?>
            <? endif; ?>
        </div>
    </main>
<? get_footer() ?>