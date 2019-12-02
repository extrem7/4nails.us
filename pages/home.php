<? /* Template Name: Home */ ?>
<? get_header(); ?>
    <div class="banner container">
        <div class="owl-carousel owl-theme banner-slider">
            <? foreach (get_field('banner') as $img): ?>
                <div class="item"><img class="owl-lazy" data-src="<?= $img['url'] ?>" alt="<?= $img['alt'] ?>"></div>
            <? endforeach; ?>
        </div>
    </div>
    <main class="content">
        <section class="section-category container">
            <h1 class="title main-title mb-3 text-center"><? the_field('title') ?></h1>
            <h2 class="title secondary-title line">Categories</h2>
            <div class="owl-carousel owl-theme  category-carousel base-indent">
                <?
                global $category;
                foreach (nails()->woo->parentCategories() as $category)
                    wc_get_template_part('content', 'product_cat'); ?>
            </div>
        </section>
        <section class="section-top-sellers container">
            <h2 class="title secondary-title line">Top Sellers</h2>
            <div class="owl-carousel owl-theme carousel-top base-indent">
                <?
                $latest = nails()->woo->queries()->popular(8);
                while ($latest->have_posts()) {
                    $latest->the_post();
                    wc_get_template_part('content', 'product');
                }
                wp_reset_query();
                ?>
            </div>
        </section>
        <section class="section-top-sellers container">
            <h2 class="title secondary-title line mt-3">Just Arrived</h2>
            <div class="owl-carousel owl-theme carousel-top base-indent">
                <?
                $latest = nails()->woo->queries()->latest(8);
                while ($latest->have_posts()) {
                    $latest->the_post();
                    wc_get_template_part('content', 'product');
                }
                wp_reset_query();
                ?>
            </div>
        </section>
        <section class="section-about container dynamic-content"><? the_post_content() ?></section>
    </main>
<? get_footer() ?>