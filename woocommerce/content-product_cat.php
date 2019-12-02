<?php

global $category;

$title = $category->name;
$link = get_term_link($category);
$img = wp_get_attachment_image(categoryImage($category->term_id), 'medium', false, ['class' => 'img-fluid owl-lazy']);

if (is_shop() || is_tax()): ?>
    <div <? wc_product_cat_class('col-sm-6 col-md-4 col-lg-3', $category); ?>>
        <a href="<?= $link ?>" class="equipment-item">
            <?= $img ?>
            <div class="title four-title"><?= $title ?></div>
        </a>
    </div>
<? else : ?>
    <div <? wc_product_cat_class('item category-item', $category); ?>>
        <a href="<?= $link ?>">
            <?= $img ?>
            <div class="title four-title"><?= $title ?></div>
        </a>
    </div>
<? endif; ?>