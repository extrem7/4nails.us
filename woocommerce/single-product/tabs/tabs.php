<div class="col-md-12 product-tab">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="active" id="home-tab" data-toggle="tab" href="#tab-1">
                <span class="title four-title">Description</span>
            </a>
        </li>
        <? if (get_field('youtube')): ?>
            <li class="nav-item">
                <a class="" id="profile-tab" data-toggle="tab" href="#tab-2">
                    <span class="title four-title">Video</span>
                </a>
            </li>
        <? endif; ?>
        <li class="nav-item">
            <a class="" id="contact-tab" data-toggle="tab" href="#tab-3">
                <span class="title four-title">Review</span>
            </a>
        </li>
    </ul>
    <div class="tab-content dynamic-content base-indent">
        <? woocommerce_product_description_tab() ?>
        <div class="tab-pane video-tab fade" id="tab-2" role="tabpanel">
            <div class="video-iframe alignleft">
                <iframe data-src="https://www.youtube.com/embed/<? the_field('youtube') ?>" allowfullscreen></iframe>
            </div>
            <? the_field('video_content') ?>
        </div>
        <div class="tab-pane review-tab fade" id="tab-3" role="tabpanel">
            <? wc_get_template('single-product-reviews.php') ?>
        </div>
    </div>
</div>