<? get_header(); ?>
    <main class="content">
        <div class="container">
            <div class="text-center">
                <img src="<?= path() ?>assets/img/error.png" alt="">
                <div class="mb-4 base-title">The page you requested does not exist.</div>
                <a href="<? bloginfo('url') ?>" class="button btn-cyan-outline w-100">Go to homepage</a>
            </div>
        </div>
    </main>
<? get_footer(); ?>