<? $order = get_field('modal_order', 'option') ?>
<div class="row">
    <div class="col-md-6">
        <div class="title main-title cyan-color line text-center pb-3"><?= $order['title'] ?></div>
        <div class="base-title text-center pt-4"><?= $order['text'] ?></div>
    </div>
</div>
<img src="<?= path() ?>assets/img/thankYou.png" class="thank-you-bg" alt="thankYou">
