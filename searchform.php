<div class="mob-search">
    <form class="search-box control-icon" action="<?= home_url('/'); ?>" method="post">
        <input type="text" aria-label="search" class="control-form material" name="s" minlength="3"
               placeholder="<? the_field('search', 'option') ?>" required>
        <input type="hidden" name="post_type" value="product">
        <div class="icon">
            <button type="submit" aria-label="search-button"><? the_icon('search') ?></button>
        </div>
    </form>
    <button class="icon close-icon"><img src="<?= path() ?>assets/img/icons/delete_m.svg" alt="delete"></button>
</div>