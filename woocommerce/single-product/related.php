<?php
global $product;
if ($cross = $product->get_cross_sell_ids()) {
    $related_products = array_map(function (WP_Post $post) {
        return wc_get_product($post);
    }, get_posts([
        'post_type' => 'product',
        'post__in' => $cross
    ]));
}
if ($related_products) : ?>
    <section class="section-viewed">
        <h2 class="title secondary-title line">Customers also viewed</h2>
        <div class="owl-carousel owl-theme carousel-top base-indent">
            <? foreach ($related_products as $related_product) {
                $post_object = get_post($related_product->get_id());
                setup_postdata($GLOBALS['post'] =& $post_object);
                wc_get_template_part('content', 'product');
            } ?>
        </div>
    </section>
<?php endif;
wp_reset_postdata();
wp_reset_query();
