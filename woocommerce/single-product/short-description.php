<?php

global $post;

$short_description = apply_filters('woocommerce_short_description', $post->post_excerpt);

if (!$short_description) return;

?>
<div class="product-name"><?= $short_description ?></div>