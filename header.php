<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no"> <? if (isset($_COOKIE["loaded"])): ?>
        <style>            @font-face {
                font-family: 'Cinzel';
                font-style: normal;
                font-weight: 400;
                src: local("Cinzel Regular"), local("Cinzel-Regular"), url(https://fonts.gstatic.com/s/cinzel/v8/8vIJ7ww63mVu7gt7-GT7LEc.woff2) format("woff2");
                unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
            }

            @font-face {
                font-family: 'Cinzel';
                font-style: normal;
                font-weight: 400;
                src: local("Cinzel Regular"), local("Cinzel-Regular"), url(https://fonts.gstatic.com/s/cinzel/v8/8vIJ7ww63mVu7gt79mT7.woff2) format("woff2");
                unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            }

            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 400;
                src: local("Source Sans Pro Regular"), local("SourceSansPro-Regular"), url(https://fonts.gstatic.com/s/sourcesanspro/v12/6xK3dSBYKcSV-LCoeQqfX1RYOo3qNa7lqDY.woff2) format("woff2");
                unicode-range: U+0460-052F, U+1C80-1C88, U+20B4, U+2DE0-2DFF, U+A640-A69F, U+FE2E-FE2F;
            }

            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 400;
                src: local("Source Sans Pro Regular"), local("SourceSansPro-Regular"), url(https://fonts.gstatic.com/s/sourcesanspro/v12/6xK3dSBYKcSV-LCoeQqfX1RYOo3qPK7lqDY.woff2) format("woff2");
                unicode-range: U+0400-045F, U+0490-0491, U+04B0-04B1, U+2116;
            }

            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 400;
                src: local("Source Sans Pro Regular"), local("SourceSansPro-Regular"), url(https://fonts.gstatic.com/s/sourcesanspro/v12/6xK3dSBYKcSV-LCoeQqfX1RYOo3qNK7lqDY.woff2) format("woff2");
                unicode-range: U+1F00-1FFF;
            }

            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 400;
                src: local("Source Sans Pro Regular"), local("SourceSansPro-Regular"), url(https://fonts.gstatic.com/s/sourcesanspro/v12/6xK3dSBYKcSV-LCoeQqfX1RYOo3qO67lqDY.woff2) format("woff2");
                unicode-range: U+0370-03FF;
            }

            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 400;
                src: local("Source Sans Pro Regular"), local("SourceSansPro-Regular"), url(https://fonts.gstatic.com/s/sourcesanspro/v12/6xK3dSBYKcSV-LCoeQqfX1RYOo3qN67lqDY.woff2) format("woff2");
                unicode-range: U+0102-0103, U+0110-0111, U+1EA0-1EF9, U+20AB;
            }

            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 400;
                src: local("Source Sans Pro Regular"), local("SourceSansPro-Regular"), url(https://fonts.gstatic.com/s/sourcesanspro/v12/6xK3dSBYKcSV-LCoeQqfX1RYOo3qNq7lqDY.woff2) format("woff2");
                unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
            }

            @font-face {
                font-family: 'Source Sans Pro';
                font-style: normal;
                font-weight: 400;
                src: local("Source Sans Pro Regular"), local("SourceSansPro-Regular"), url(https://fonts.gstatic.com/s/sourcesanspro/v12/6xK3dSBYKcSV-LCoeQqfX1RYOo3qOK7l.woff2) format("woff2");
                unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
            }        </style>    <? endif; ?>    <? wp_head() ?> <title><?= wp_get_document_title() ?></title></head>
<body <? body_class() ?>><a class="skip-link" href="#content">Skip to main content</a>
<header class="header">
    <div class="header-top">
        <div class="container"><img src="<?= path() ?>assets/img/icons/delivery.svg" alt="delivery"
                                    class="mr-2"> <? the_field('shipping_text', 'option') ?> <img
                    src="<?= path() ?>assets/img/icons/usa.svg" alt="usa"
                    class="ml-4 mr-2"> <? the_field('ship_us_text', 'option') ?>        </div>
    </div>
    <div class="header-middle">
        <div class="container">
            <? if (is_front_page()): ?>
                <div aria-label="logo"><? the_image('logo', 'logo', 'option') ?></div>
            <? else: ?>
                <a href="<? bloginfo('url') ?>" class="d-block"
                   aria-label="logo"><? the_image('logo', 'logo', 'option') ?></a>
            <? endif; ?>
            <? get_search_form() ?>
            <!--<div class="phone-box"><a href="<?//= //tel(get_field('phone', 'option')) ?>"> <img
                            src="<?//= //path() ?>assets/img/icons/call.svg" alt="call"
                            class="mr-2"> <? //the_field('phone', 'option') ?>                </a></div>-->
            <div class="shop-info">
                <div class="item">
                    <button class="icon" id="search-btn"><img src="<?= path() ?>assets/img/icons/search.svg"
                                                              alt="search"></button>
                </div>
                <a href="<? account_url() ?>" class="item"
                   aria-label="account-link">                    <? the_icon('user') ?>                    <? if (is_user_logged_in()): ?>
                        <div class="login-name">
                            Hi, <?= wp_get_current_user()->user_firstname ?></div>                    <? endif; ?>
                </a> <a href="<? the_permalink(81) ?>" class="item"><? the_icon('email') ?></a> <a
                        href="<? wishlist_url() ?>" class="item"
                        aria-label="wishlist-link"><? the_icon('heart_b') ?></a> <? nails()->views()->miniCart() ?>
            </div>
            <button class="mobile-btn" aria-label="mobile-menu" id="mobile-menu"><span></span><span></span><span></span>
            </button>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <div class="menu-container">
                <? if (is_front_page()): ?>
                    <div aria-label="logo-mini"
                         class="logo-stick">                        <? the_image('logo_mini', null, 'option') ?>                    </div>
                <? else: ?>
                    <a href="<? bloginfo('url') ?>" aria-label="logo-mini"
                       class="logo-stick"><? the_image('logo_mini', null, 'option') ?></a>
                <? endif; ?>
                <? wp_nav_menu(['menu' => 'header', 'container' => null, 'menu_class' => 'menu']); ?>
                <div class="shop-info"><a href="<? wishlist_url() ?>"
                                          class="item"><? the_icon('heart_b') ?></a> <? nails()->views()->miniCart() ?>
                </div>
                <!--<div class="phone-box"><a href="<?//= tel(get_field('phone', 'option')) ?>"> <img
                                data-src="<?//= path() ?>assets/img/icons/call.svg" alt="call"
                                class="mr-2"> <? //the_field('phone', 'option') ?></a></div>-->
            </div>
        </div>
    </div>
</header>
<? woocommerce_breadcrumb(); ?>