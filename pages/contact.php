<? /* Template Name: Contact */ ?>
<? get_header(); ?>
    <main class="content">
        <div class="container">
            <h1 class="title main-title line"><? the_title() ?></h1>
            <div class="row base-indent">
                <div class="col-md-6"><?= do_shortcode('[contact-form-7 id="83" title="Contact Us"]') ?></div>
                <div class="col-md-6 contact-info">
                    <a href="<?= tel(get_field('phone', 'option')) ?>">
                        <img src="<?= path() ?>assets/img/icons/call.svg" alt="call"
                             class="mr-2"> <? the_field('phone', 'option') ?></a>
                    <? $email = get_field('email', 'option') ?>
                    <a href="mailto:<?= $email ?>">
                        <img src="<?= path() ?>assets/img/icons/email.svg" alt="email" class="mr-2"><?= $email ?></a>
                    <div class="text-right">
                        <img src="<?= path() ?>assets/img/contact.png" class="img-fluid" alt="contact">
                    </div>
                </div>
            </div>
        </div>
    </main>
<? get_footer() ?>