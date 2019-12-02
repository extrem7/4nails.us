<?php

class ThemeBase
{
    protected static $instance;

    public static function getInstance(): Theme
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }

    protected function __construct()
    {
        $this->themeSetup();
        $this->enqueueStyles();
        $this->enqueueScripts();
        $this->customHooks();
        $this->GPSI();
        $this->registerNavMenus();
        $this->ACF();
    }

    private function themeSetup()
    {
        add_theme_support('post-thumbnails');
        add_theme_support('menus');
        add_theme_support('widgets');
        show_admin_bar(false);
    }

    private function enqueueStyles()
    {
        add_action('wp_print_styles', function () {
            wp_register_style('main', path() . 'assets/css/main.css');
            wp_enqueue_style('main');
        });
    }

    private function enqueueScripts()
    {
        add_action('wp_enqueue_scripts', function () {
            wp_deregister_script('jquery');
            wp_register_script('jquery', path() . 'assets/node_modules/jquery/dist/jquery.min.js');
            wp_enqueue_script('jquery');
            if (is_product()) {
                wp_register_script('fancybox', path() . 'assets/node_modules/@fancyapps/fancybox/dist/jquery.fancybox.js');
                wp_enqueue_script('fancybox');
            }
            if (is_front_page() || is_product() || is_cart()) {
                wp_register_script('owl.carousel', path() . '/assets/node_modules/owl.carousel/dist/owl.carousel.min.js');
                wp_enqueue_script('owl.carousel');
            }
            if (is_account_page() || is_edit_account_page()) {
                wp_register_script('popper', path() . 'assets/node_modules/popper.js/dist/umd/popper.min.js');
                wp_enqueue_script('popper');
                wp_register_script('select2', path() . '/assets/node_modules/select2/dist/js/select2.min.js');
                wp_enqueue_script('select2');
            }
            wp_register_script('bootstrap', path() . 'assets/node_modules/bootstrap/dist/js/bootstrap.min.js');
            wp_enqueue_script('bootstrap');
            wp_register_script('mask', path() . 'assets/node_modules/jquery.inputmask/dist/jquery.inputmask.bundle.js');
            wp_enqueue_script('mask');
            wp_register_script('main', path() . 'assets/js/main.js');
            wp_enqueue_script('main');
            wp_localize_script('main', 'SharedData',
                [
                    'link' => get_permalink(),
                    'adminAjax' => admin_url('admin-ajax.php')
                ]
            );
        });
    }

    private function customHooks()
    {
        add_filter('wp_get_attachment_image_attributes', function ($attr) {
            if (!is_admin()) {
                $attr['data-src'] = $attr['src'];
                $attr['data-srcset'] = $attr['srcset'];
                $attr['srcset'] = '';
                $attr['src'] = '';
            }
            return $attr;
        });
        add_filter('nav_menu_css_class', function ($classes, $item) {
            if (in_array('current-menu-item', $classes)) {
                $classes[] = 'active ';
            }
            return $classes;
        }, 10, 2);
        add_action('navigation_markup_template', function ($content) {
            $content = str_replace('role="navigation"', '', $content);
            $content = preg_replace('#<h2.*?>(.*?)<\/h2>#si', '', $content);

            return $content;
        });

        add_filter('wpcf7_form_elements', function ($content) {
            $content = preg_replace('/<br \/>/', '', $content);
            return $content;
        });
        add_action('template_redirect', function () {
            if (!isset($_COOKIE["loaded"])) {
                setcookie('loaded', true, time() + (10 * 365 * 24 * 60 * 60), '/');
            }
        });
    }

    private function ACF()
    {
        if (function_exists('acf_add_options_page')) {
            $main = acf_add_options_page([
                'page_title' => 'Settings',
                'menu_title' => 'Settings',
                'menu_slug' => 'theme-general-settings',
                'capability' => 'edit_posts',
                'redirect' => false,
                'position' => 2,
                'icon_url' => 'dashicons-hammer',
            ]);
        }
        $path = get_template_directory() . '/assets/acf-json';
        add_filter('acf/settings/save_json', function () use ($path) {
            return $path;
        });
        add_filter('acf/settings/load_json', function () use ($path) {
            return [$path];
        });
    }

    private function GPSI()
    {
        add_action('after_setup_theme', function () {
            remove_action('wp_head', 'wp_print_scripts');
            remove_action('wp_head', 'wp_print_head_scripts', 9);
            remove_action('wp_head', 'wp_enqueue_scripts', 1);
            add_action('wp_footer', 'wp_print_scripts', 5);
            add_action('wp_footer', 'wp_enqueue_scripts', 5);
            add_action('wp_footer', 'wp_print_head_scripts', 5);
            remove_action('wp_head', 'wp_generator');
            remove_action('wp_head', 'wlwmanifest_link');
            remove_action('wp_head', 'rsd_link');
            remove_action('wp_head', 'wp_shortlink_wp_head');
            remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
            add_filter('the_generator', '__return_false');
            remove_action('wp_head', 'print_emoji_detection_script', 7);
            remove_action('wp_print_styles', 'print_emoji_styles');
        });

        remove_action('wp_head', 'wp_oembed_add_discovery_links');
        remove_action('wp_head', 'wp_oembed_add_host_js');
    }

    private function registerNavMenus()
    {
        function current_location()
        {
            if (isset($_SERVER['HTTPS']) &&
                ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
                isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
                $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
                $protocol = 'https://';
            } else {
                $protocol = 'http://';
            }

            return $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        }

        add_filter('nav_menu_link_attributes', function ($atts) {
            if ($atts['href'] == current_location()) {
                unset($atts['href']);
            }

            return $atts;
        }, 1, 3);
    }
}