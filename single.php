<? get_header(); ?>
    <main class="content">
        <div class="container">
            <article class="article">
                <h1 class="title main-title line"><? the_title() ?></h1>
                <div class="dynamic-content base-indent"><? the_post_content() ?></div>
                <div class="text-center">
                    <a href="<?= get_term_link(1) ?>" class="readMore">Return to the blog</a>
                </div>
                <div class="d-flex align-items-center justify-content-center post-nav">
                    <?
                    $prev = get_permalink(get_previous_post()->ID);
                    $next = get_permalink(get_next_post()->ID);
                    if ($prev && $prev != get_permalink()):
                        ?>
                        <a href="<?= $prev ?>" class="button btn-cyan-outline w-100">Previous</a>
                    <?endif;
                    if ($next && $next != get_permalink()):?>
                        <a href="<?= $next ?>" class="button btn-cyan w-100">Next post</a>
                    <? endif; ?>
                </div>
            </article>
        </div>
    </main>
<? get_footer(); ?>