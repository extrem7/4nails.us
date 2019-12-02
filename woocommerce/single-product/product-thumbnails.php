<?php

global $product;

$attachment_ids = $product->get_gallery_image_ids();
$main_id        = get_post_thumbnail_id();

if ( in_array( $main_id, $attachment_ids ) ) {
    unset( $attachment_ids[ array_search( $main_id, $attachment_ids ) ] );
}
array_unshift( $attachment_ids, $main_id );

if ($attachment_ids && $product->get_image_id()):?>
    <div class="thumbnails owl-carousel owl-theme">
        <? foreach ($attachment_ids as $attachment_id):
            $image = wp_get_attachment_image_url($attachment_id, 'woocommerce_gallery_thumbnail');
            $imageBig = wp_get_attachment_image_url($attachment_id, 'woocommerce_single');
            ?>
            <div class="item">
                <div class="thumbnail" style="background-image: url('<?= $image ?>')" data-gallery="<?= $imageBig ?>"></div>
            </div>
        <? endforeach; ?>
    </div>
<? endif; ?>
