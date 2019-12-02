<? /* Template Name: Account */ ?>
<? get_header(); ?>
    <main class="content">
        <div class="container">
            <? if (is_checkout() && !is_order_received_page()): ?>
                <h1 class="title main-title line mb-5"><? the_title() ?></h1>
            <? endif; ?>
            <? the_post_content() ?>
        </div>
    </main>
<? get_footer() ?>