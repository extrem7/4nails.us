<footer class="footer">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-sm-4 col-lg-4 col-xl-2">
                    <h4 class="title four-title line mb-2">Account</h4>
                    <? wp_nav_menu([
                        'menu' => 'account',
                        'container' => null,
                        'menu_class' => null
                    ]); ?>
                </div>
                <div class="col-sm-4 col-lg-4 col-xl-2">
                    <h4 class="title four-title line mb-2">Information</h4>
                    <? wp_nav_menu([
                        'menu' => 'information',
                        'container' => null,
                        'menu_class' => null
                    ]); ?>
                </div>
                <div class="col-sm-4 col-lg-4 col-xl-2">
                    <h4 class="title four-title line mb-2">Business Hours</h4>
                    <? the_field('hours', 'option') ?>
                </div>
                <div class="col-lg-12 col-xl-6 decorative">
                    <div class="subscribe-block">
                        <h4 class="title four-title line"><? the_field('subscribe_title', 'option') ?></h4>
                        <div class="cyan-color"><? the_field('subscribe_text', 'option') ?></div>
                        <?= do_shortcode('[contact-form-7 id="84" title="Subscribe" html_class="subscribe"]') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <div class="flex-column flex-lg-row d-flex justify-content-between align-items-center">
                        <a href="<? bloginfo('url') ?>" class="logo-footer"
                           aria-label="footer-logo"><? the_image('logo_footer', null, 'option') ?></a>
                        <div class="payment-info">
                            <h4 class="white-color title-shadow mb-2">Payment methods</h4>
                            <? $methods = get_field('payment_methods', 'option');
                            foreach ($methods as $method):?>
                                <img data-src="<?= $method['url'] ?>" alt="<?= $method['alt'] ?>">
                            <? endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="d-flex align-items-center follow-box">
                        <h4 class="white-color title-shadow mr-3">Follow us:</h4>
                        <? while (have_rows('follow_us', 'option')): the_row() ?>
                            <a href="<? the_sub_field('link') ?>" aria-label="social-link" rel="nofollow noreferrer"
                               target="_blank">
                                <? the_icon(get_sub_field('name')) ?>
                            </a>
                        <? endwhile; ?>
                    </div>
                    <div class="d-flex align-items-center footer-contact">
                        <!--<div>
                            <img src="<?//= path() ?>assets/img/icons/call.svg" alt="call" class="mr-2">
                            <a href="<?//= tel(get_field('phone', 'option')) ?>"
                               class="title-shadow white-color">
                                <? //the_field('phone', 'option') ?>
                            </a>
                        </div>-->
                        <? $email = get_field('email', 'option') ?>
                        <div class="ml-4">
                            <img src="<?= path() ?>assets/img/icons/email.svg" alt="email" class="mr-2">
                            <a href="mailto:<?= $email ?>" class="title-shadow white-color"><?= $email ?></a>
                        </div>
                    </div>
                </div>
                <div class="col-12 copyright"><? the_field('copyright', 'option') ?></div>
            </div>
        </div>
    </div>
</footer>
<div class="modal fade" id="addedToCart" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close"><? the_icon('close') ?></button>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="contact" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close"><? the_icon('close') ?></button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <? $contact = get_field('modal_contact', 'option') ?>
                    <div class="text-center title secondary-title line cyan-color"><?= $contact['title'] ?></div>
                    <div class="text-center mt-2 mb-2"><?= $contact['text'] ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="subscribe" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="Close"><? the_icon('close') ?></button>
            </div>
            <div class="modal-body">
                <div class="modal-body">
                    <? $subscribe = get_field('modal_subscribe', 'option') ?>
                    <div class="text-center title secondary-title line cyan-color"><?= $subscribe['title'] ?></div>
                    <div class="text-center mt-2 mb-2"><?= $subscribe['text'] ?></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="overlay"></div>
<? wp_footer() ?>
<script src="<?= path() ?>assets/node_modules/jquery-lazy/jquery.lazy.min.js"></script>
<script src="<?= path() ?>assets/node_modules/jquery-lazy/jquery.lazy.plugins.min.js"></script>
</body>
</html>