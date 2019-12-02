<div class="col-md-6 col-lg-4">
    <div class="article-item">
        <a href="<? the_permalink() ?>" class="article-img d-block">
            <? the_post_thumbnail(null, ['class' => 'img-fluid']) ?>
        </a>
        <div class="article-date"><?= get_the_date('d.m.Y') ?></div>
        <div class="title third-title"><? the_title() ?></div>
        <? if (has_excerpt()): ?>
            <div class="article-anons"><? the_excerpt() ?></div>
        <? endif; ?>
        <div class="text-right"><a href="<? the_permalink() ?>" class="readMore">Read more <? the_icon('arrow_r') ?></a>
        </div>
    </div>
</div>