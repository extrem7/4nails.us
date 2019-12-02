<? $post = get_post($_POST['product_id']) ?>
<div class="modal-body">
    <div class="text-center base-title">Item successfully added to cart</div>
    <div class="modal-cart">
        <div class="product-thumbnail" style="background-image: url('<? the_post_thumbnail_url() ?>')"></div>
        <? if (has_excerpt()): ?>
            <div class="small-size ml-3"><? the_excerpt() ?></div>
        <? endif; ?>
    </div>
    <div class="text-center mb-4">
        <a href="<? cart_url() ?>" class="button btn-cyan btn-lg w-100">View Cart</a>
        <a href="" rel="nofollow" data-dismiss="modal" class="button btn-cyan-outline btn-lg w-100 mt-3">Continue
            shopping</a>
    </div>
</div>