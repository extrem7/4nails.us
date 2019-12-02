(function ($) {
    let navText = ["<svg version=\"1.1\" xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\"width=\"25px\" height=\"48px\" viewBox=\"-164.5 181.5 25 48\" enable-background=\"new -164.5 181.5 25 48\" xml:space=\"preserve\">\n" +
    "<polygon fill=\"#BBCAC8\" points=\"-164.325,205.5 -140.382,181.558 -139.675,182.265 -162.911,205.5 -139.675,228.735 -140.382,229.442 \"/></svg>\n", "<svg version=\"1.1\"  xmlns=\"http://www.w3.org/2000/svg\" xmlns:xlink=\"http://www.w3.org/1999/xlink\" x=\"0px\" y=\"0px\"width=\"25px\" height=\"48px\" viewBox=\"-164.5 181.5 25 48\" enable-background=\"new -164.5 181.5 25 48\" xml:space=\"preserve\">\n" +
    "<polygon fill=\"#BBCAC8\" points=\"-139.675,205.5 -163.618,181.558 -164.325,182.265 -141.089,205.5 -164.325,228.735 -163.618,229.442 \"/></svg>\n"];

    class Woo {
        constructor() {
            this.url = SharedData.adminAjax;
            this.body = document.body;

            if (bodyClass('single-product')) {
                this.gallery();
                $('button.add-to-cart:not(.add-to-cart-variable)').click((e) => {
                    e.preventDefault();
                    let $btn = $(e.currentTarget),
                        id = $btn.val(),
                        count = $btn.closest('form').find('.qty').val();
                    this.addToCart(id, count, $btn);
                });
            }

            if (bodyClass('woocommerce-account')) {
                this.showPass();
                $('.box-tooltip .woocommerce-input-wrapper .control-form').after($('.tooltip-button-wrap').html());
            }

            if (bodyClass('woocommerce-checkout')) {
                $(this.body).on('click', '#place_order', function (e) {
                    if (!$('#terms')[0].reportValidity()) {
                        e.preventDefault();
                    }
                });
            }

            $(this.body).on('added_to_cart', (e, data) => this.updateModal(data.modal));

            if (!bodyClass('woocommerce-cart')) {
                $(this.body).on('removed_from_cart added_to_cart', () => {
                    setTimeout(() => this.updateCart(), 1000);
                }).on('click', '.remove_from_cart_button', () => {
                    $('.mini-cart').find('.mini-content').addClass('blockOverlay');
                }).on('wc_fragments_refreshed ', () => this.updateCart());
            } else {
                $(document).ajaxComplete(() => $('html, body').stop());
            }

            if ($('.variation-items .item').length) {
                const query = window.location.search.substring(1);

                if (query.length) {
                    if (window.history !== undefined && window.history.pushState !== undefined) {
                        window.history.pushState({}, document.title, window.location.pathname);
                    }
                }
                this.variable();
                $('.variation-items input').on('change', (e) => {
                    e.stopPropagation();
                    this.variable();
                });
                $('.quantity input').on('change', () => {
                    this.variable();
                });
            }
        }

        addToCart(id, qty = 1, $btn) {
            let data = {
                action: 'add_to_cart',
                product_id: id,
                qty
            };
            $btn.addClass('loading');
            $.post(this.url, data, (res) => {
                res = JSON.parse(res);
                if (res.status === 'ok') {
                    $(this.body).trigger('wc_fragment_refresh');
                    Qty.trigger();
                    this.updateModal(res.modal);
                }
            }).done(() => {
                $btn.removeClass('loading');
                $btn.addClass('added');
            });
        }

        updateModal(modal) {
            if (!bodyClass('woocommerce-cart')) {
                $('#addedToCart .modal-body').replaceWith(modal);
                $('#addedToCart').modal('show');
            }
        }

        updateCart() {
            let $cart = $('.mini-cart'),
                qty = $cart.find('.cart-fragments .qty').first().text();
            $('.product-quantity').html(qty);
            qty > 0 ? $cart.addClass('active') : $cart.removeClass('active');
        }

        variable() {
            const $input = $('.variation-items input:checked');
            if ($input.length) {
                const variation = $input.val();
                const id = $('.product').data('id');
                const quantity = $('.quantity input').val();

                let link = location.protocol + '//' + location.host + location.pathname;
                link += '?add-to-cart=' + id + '&variation_id=' + variation + '&quantity=' + quantity;
                $('.product .add-to-cart').attr('href', link);

                const name = $input.data('name'),
                    price = $input.data('price'),
                    oldPrice = $input.data('old-price');
                $('.variation-name').text(name);
                $('.product-price .woocommerce-Price-amount').replaceWith(price);
                $('.product-old-price .woocommerce-Price-amount').replaceWith(oldPrice);
            }
        }

        gallery() {
            $('.gallery .thumbnail, .variation-items input').click(function () {
                let src = $(this).attr('data-gallery'),
                    $main = $('.gallery .main-photo');
                if ($main.attr('href') !== src) {
                    $('.thumbnail.active').removeClass('active');
                    $(this).addClass('active');
                    $main.fadeOut(function () {
                        $(this).attr('href', src);
                        $(this).css('background-image', `url('${src}')`);
                        $(this).fadeIn();
                    });
                }
            });
        }

        showPass() {
            $('.show-pass').click(function (e) {
                e.preventDefault();
                $(this).toggleClass('active');
                $(this).siblings('input').attr('type', $(this).hasClass('active') ? 'text' : 'password');
            });
        }
    }

    class Qty {
        enable() {
            $(':input[name=update_cart]').removeAttr('disabled');
        }

        static trigger() {
            $(':input[name=update_cart]').trigger("click");
        }

        constructor() {
            setTimeout(() => this.enable());
            $(document.body).on('updated_cart_totals', () => this.enable());
            $('body').on('change', '.qty', () => {
                this.enable();
                Qty.trigger();
            });
            this.watch();
        }

        watch() {
            $('body').on('click', '.qty-btn', (e) => {
                e.preventDefault();

                let $this = $(e.currentTarget);
                let $input = $this.parent().find('input');

                let current = Math.abs(parseInt($input.val()));

                if ($this.hasClass('qty-plus')) {
                    $input.val(++current).trigger("change");
                } else if (current > 0) {
                    $input.val(--current).trigger("change");
                }
            });
        }
    }

    $.fn.extend({
        hasClasses: function (selectors) {
            var self = this;
            for (var i in selectors) {
                if ($(self).hasClass(selectors[i]))
                    return true;
            }
            return false;
        }
    });

    function bodyClass($class) {
        if (typeof $class == 'string') $class = [$class];
        return $('body').hasClasses($class);
    }

    function mail() {
        $('.wpcf7-form input[type=submit]').click(function (e) {
            if (!$(this).closest('form')[0].reportValidity()) e.preventDefault();
        });
        $(".wpcf7").on('wpcf7:mailsent', function (event) {
            let formSelector = '#contact';
            if ($(event.currentTarget).find('form').hasClass('subscribe')) {
                formSelector = '#subscribe';
            }
            $(formSelector).modal('show');
            setTimeout(() => {
                $(formSelector).modal('hide');
            }, 6000);
        });
    }

    function menu() {
        $("#mobile-menu").click(() => {
            $('.mobile-btn').toggleClass('open');
            $('.menu-container, body').toggleClass('open-menu');
        });
        $("#search-btn, .mob-search .close-icon, #overlay").click(() => {
            $('.mob-search, #overlay').toggleClass('open-search');
            $('.body').toggleClass('open-menu');
        });
    }

    function header() {
        if ($(this).scrollTop() > 145 && window.innerWidth > 768) {
            $(".header").addClass('sticky-header');
        } else if ($(".header").hasClass('sticky-header')) {
            $(".header").removeClass('sticky-header');
        }

        if ($(this).scrollTop() > 100 && window.innerWidth <= 768) {
            $(".header").addClass('sticky-mob-header');
        } else {
            $(".header").removeClass('sticky-mob-header');
        }
    }

    function lazy() {
        $('*[data-src]').each(function () {
            if (!$(this).closest('.owl-carousel').length) $(this).Lazy({
                placeholder: ''
            });
        });
        if ($().owlCarousel) {
            $('.category-carousel').owlCarousel({
                loop: true,
                margin: 22,
                nav: true,
                items: 4,
                dots: false,
                navText: navText,
                lazyLoad: true,
                responsive: {
                    0: {
                        items: 1,
                        nav: false,
                        dots: true,
                        autoplay: true
                    },
                    576: {
                        items: 2,
                        nav: false,
                        dots: true,
                        autoplay: true
                    },
                    768: {
                        items: 3,
                        nav: false,
                        dots: true,
                        autoplay: true

                    },
                    992: {
                        items: 4,
                        nav: true,
                        dots: false,
                        autoplay: false
                    },
                    1050: {
                        nav: true,
                        dots: false,
                        autoplay: false
                    }
                }
            });
            $('.carousel-top').owlCarousel({
                loop: true,
                margin: 22,
                nav: true,
                navText: navText,
                items: 4,
                dots: false,
                lazyLoad: true,
                responsive: {
                    0: {
                        items: 1,
                        nav: false,
                        dots: true,
                        autoplay: true
                    },
                    576: {
                        items: 2,
                        nav: false,
                        dots: true,
                        autoplay: true
                    },
                    768: {
                        items: 3,
                        nav: false,
                        dots: true,
                        autoplay: true
                    },
                    992: {
                        items: 4,
                        nav: false,
                        dots: true,
                        autoplay: true
                    },
                    1050: {
                        nav: true,
                        dots: false,
                        autoplay: false
                    }
                }
            });
            $('.banner-slider').owlCarousel({
                margin: 0,
                dots: true,
                nav: false,
                lazyLoad: true,
                items: 1
            });
        }
    }

    function fallbackCopyTextToClipboard(text) {
        var textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.position = "fixed";  //avoid scrolling to bottom
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();

        try {
            var successful = document.execCommand('copy');
            var msg = successful ? 'successful' : 'unsuccessful';
            console.log('Fallback: Copying text command was ' + msg);
        } catch (err) {
            console.error('Fallback: Oops, unable to copy', err);
        }

        document.body.removeChild(textArea);
    }

    function copyTextToClipboard(text) {
        if (!navigator.clipboard) {
            fallbackCopyTextToClipboard(text);
            return;
        }
        navigator.clipboard.writeText(text).then(function () {
            console.log('Async: Copying to clipboard was successful!');
        }, function (err) {
            console.error('Async: Could not copy text: ', err);
        });
    }

    function toClipboard() {
        $('.copy-link').on('click', () => {
            copyTextToClipboard(SharedData.link);
            $('#clipboard').toast('show');
        });
    }

    $(($) => {
        if (window.innerWidth > 768) {
            lazy();
        }

        new Woo();
        if (bodyClass(['single-product', 'woocommerce-cart'])) {
            new Qty();
            toClipboard();
        }
        menu();
        mail();

        if ($().select2) $('select').select2();
        if ($().tooltip) $('.tooltip-button').tooltip();
        $('input[type=tel]').inputmask("mask", {"mask": "(999) 999 9999", "clearIncomplete": true});
        $('.tinvwl-icon-heart').removeClass('tinvwl-icon-heart');
    });

    $(window).on('load resize scroll', () => header());

    $(window).on('load', () => {
        let offset = 0;

        if (!('hasCodeRunBefore' in localStorage)) {
            offset = 1500;
            localStorage.setItem("hasCodeRunBefore", true);
        }
        if (window.innerWidth < 768) {
            setTimeout(() => {
                lazy();
            }, offset);
        }
        if ($().owlCarousel) {
            $('.owl-testimonials').owlCarousel({
                loop: true,
                margin: 0,
                nav: true,
                navText: navText,
                items: 1,
                dots: false,
            });
            $('.gallery .thumbnails').owlCarousel({
                margin: 11,
                navText: navText,
                nav: true,
                items: 6,
                dots: false,
                responsive: {
                    // breakpoint from 0 up
                    0: {
                        items: 2,
                        dots: true,
                        nav: false
                    },
                    375: {
                        items: 3,
                        dots: true,
                        nav: false
                    },
                    430: {
                        items: 4,
                        dots: true,
                        nav: false
                    },
                    // breakpoint from 480 up
                    768: {
                        items: 6,

                    },
                    // breakpoint from 768 up
                    992: {
                        items: 4,
                    },
                    1199: {
                        items: 6,
                    }
                }
            });
        }
    });

    WebFontConfig = {
        google: {families: ['Cinzel', 'Source+Sans+Pro']}
    };

    (function () {
        setTimeout(() => {
            var wf = document.createElement('script');
            wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                '://ajax.googleapis.com/ajax/libs/webfont/1.6.26/webfont.js';
            wf.type = 'text/javascript';
            wf.async = 'true';
            var s = document.getElementsByTagName('script')[0];
            s.parentNode.insertBefore(wf, s);
        }, 2500);
    })();

})(jQuery);