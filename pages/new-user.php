<? /* Template Name: Congratulations */ ?>
<? get_header(); ?>
    <main class="content">
        <div class="container">
            <h1 class="title main-title line text-center">Congratulations!</h1>
            <div class="account-create text-center">
                <div class="base-title"><? the_post_content() ?></div>
                <a href="<? shop_url() ?>" class="button btn-cyan w-100 btn-lg">Continue shopping</a>
                <a href="<? account_url() ?>" class="link d-block">My Account</a>
            </div>
        </div>
    </main>
<? get_footer() ?>