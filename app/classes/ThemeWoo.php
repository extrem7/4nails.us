<?php

class ThemeWoo
{
    public function __construct()
    {
        $this->setup();

        add_action('wp_ajax_add_to_cart', [$this, 'addToCart']);
        add_action('wp_ajax_nopriv_add_to_cart', [$this, 'addToCart']);
        $this->cart();
        $this->checkout();
        $this->auth();
        $this->account();
        $this->individualDiscount();

        add_filter( 'request', function ( $vars ) {
            global $wpdb;
            if ( ! empty( $vars['pagename'] ) || ! empty( $vars['category_name'] ) || ! empty( $vars['name'] ) || ! empty( $vars['attachment'] ) ) {
                $slug   = ! empty( $vars['pagename'] ) ? $vars['pagename'] : ( ! empty( $vars['name'] ) ? $vars['name'] : ( ! empty( $vars['category_name'] ) ? $vars['category_name'] : $vars['attachment'] ) );
                $exists = $wpdb->get_var( $wpdb->prepare( "SELECT t.term_id FROM $wpdb->terms t LEFT JOIN $wpdb->term_taxonomy tt ON tt.term_id = t.term_id WHERE tt.taxonomy = 'product_cat' AND t.slug = %s", array( $slug ) ) );
                if ( $exists ) {
                    $old_vars = $vars;
                    $vars     = array( 'product_cat' => $slug );
                    if ( ! empty( $old_vars['paged'] ) || ! empty( $old_vars['page'] ) ) {
                        $vars['paged'] = ! empty( $old_vars['paged'] ) ? $old_vars['paged'] : $old_vars['page'];
                    }
                    if ( ! empty( $old_vars['orderby'] ) ) {
                        $vars['orderby'] = $old_vars['orderby'];
                    }
                    if ( ! empty( $old_vars['order'] ) ) {
                        $vars['order'] = $old_vars['order'];
                    }
                }
            }

            return $vars;
        } );
    }

    private function setup()
    {
        add_action('after_setup_theme', function () {
            add_theme_support('woocommerce');
        });
        add_action('init', function () {
            remove_action('wp_footer', array(WC()->structured_data, 'output_structured_data'), 10);
            remove_action('woocommerce_email_order_details', array(WC()->structured_data, 'output_email_structured_data'), 30);
        });
        add_filter('woocommerce_enqueue_styles', '__return_empty_array');

        remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
        remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

        add_image_size('product', 174, 142);
    }

    public function addToCart()
    {

        $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
        $qty = absint($_POST['qty']);
        $response = [];

        if (WC()->cart->add_to_cart($product_id, $qty)) {
            $response['status'] = 'ok';

            $response['notice'] = '<div class="woocommerce-message">';
            $response['notice'] .= wc_add_to_cart_message($product_id, false, true);
            $response['notice'] .= '</div>';

            ob_start();
            woocommerce_mini_cart();
            $response['cart'] = ob_get_contents();
            ob_end_clean();
            ob_start();
            get_template_part('views/modal');
            $response['modal'] = ob_get_contents();
            ob_end_clean();
        } else {
            $response['status'] = 'error';
        }
        echo json_encode($response);
        die();
    }

    public function parentCategories()
    {
        return get_terms('product_cat', [
            'parent' => 0
        ]);
    }

    public function queries()
    {
        return new class
        {
            public function latest($limit)
            {
                $query = new WP_Query([
                    'post_type' => 'product',
                    'posts_per_page' => $limit,
                    'post_status' => 'publish',
                    'orderby' => 'date',
                ]);
                return $query;
            }

            public function popular($limit)
            {
                $query = new WP_Query([
                    'post_type' => 'product',
                    'posts_per_page' => $limit,
                    'post_status' => 'publish',
                    'meta_key' => 'total_sales',
                    'orderby' => [
                        'meta_value_num' => 'DESC'
                    ],
                ]);
                return $query;
            }

            public function sale($limit)
            {
                $query = new WP_Query([
                    'post_type' => 'product',
                    'posts_per_page' => $limit,
                    'post_status' => 'publish',
                    'orderby' => 'meta_value_num',
                    'meta_key' => '_price',
                    'order' => 'asc',
                    'tax_query', [
                        [
                            'taxonomy' => 'product_cat',
                            'terms' => 20,
                            'field' => 'id',
                            'include_children' => true,
                            'operator' => 'IN'
                        ]
                    ]
                ]);
                return $query;
            }

            public function featured($limit)
            {
                $query = new WP_Query([
                    'post_type' => 'product',
                    'posts_status' => 'publish',
                    'posts_per_page' => $limit,
                    'tax_query' => [
                        'relation' => 'AND',
                        [
                            'taxonomy' => 'product_visibility',
                            'field' => 'name',
                            'terms' => 'featured',
                            'operator' => 'IN'
                        ]
                    ]
                ]);

                return $query;
            }

            public function viewed($limit)
            {
                $rvps = new Rvps();
                $viewed = $rvps->rvps_get_products();
                $query = new WP_Query([
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'posts_per_page' => $limit,
                    'post__in' => $viewed
                ]);

                return $query;
            }

            public function wishlist()
            {
                $wlp = TInvWL_Public_Wishlist_View::instance();
                $wishlist = $wlp->get_current_wishlist();
                $products = $wlp->get_current_products($wishlist);
                $ids = array_map(function ($product) {
                    return $product['product_id'];
                }, $products);
                if (!empty($products)) {
                    $query = new WP_Query([
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'post__in' => $ids,
                        'posts_per_page' => -1
                    ]);
                    return $query;
                }
            }
        };
    }

    private function cart()
    {
        add_action('woocommerce_before_checkout_form', function () {
            remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
        }, 9);
        add_action('template_redirect', function () {
            if (isset($_POST['save']) && $_POST['save']) {
                $this->saveForLater();
            }
        });
        add_filter('woocommerce_add_to_cart_fragments', function ($array) {
            ob_start();
            get_template_part('views/modal');
            $array['modal'] = ob_get_contents();
            ob_end_clean();
            return $array;
        }, 10, 1);
    }

    private function checkout()
    {
        add_filter('woocommerce_add_error', function ($error) {
            if (strpos($error, 'Поле ') !== false) {
                $error = str_replace("Поле ", "", $error);
            }
            if (strpos($error, 'Оплата ') !== false) {
                $error = str_replace("Оплата ", "", $error);
            }
            return $error;
        });
        add_filter('woocommerce_checkout_fields', function ($fields) {
            unset($fields['billing']['billing_country']);
            unset($fields['shipping']['shipping_country']);
            return $fields;
        });
        add_filter('default_checkout_billing_country', function () {
            return 'US';
        });

        add_action('woocommerce_before_checkout_form', function () {
            remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
        }, 9);
    }

    private function auth()
    {
        add_filter('woocommerce_process_registration_errors', function ($errors) {
            if (!empty($_POST['first_name']) && trim($_POST['first_name']) == '') {
                $errors->add('first_name_error', 'Please provide a valid first name.');
            }
            if (!empty($_POST['last_name']) && trim($_POST['first_name']) == '') {
                $errors->add('last_name_error', ' Please provide a valid last name.');
            }
            if (empty($_POST['conf_password']) || !empty($_POST['conf_password']) && trim($_POST['conf_password']) !== trim($_POST['password'])) {
                $errors->add('last_name_error', ' Please confirm password.');
            }
            return $errors;
        }, 10, 3);

        add_action('user_register', function ($user_id) {
            if (!empty($_POST['first_name']) && !empty($_POST['last_name'])) {
                $first = esc_attr(wp_unslash($_POST['first_name']));
                $last = esc_attr(wp_unslash($_POST['last_name']));
                wp_update_user([
                    'ID' => $user_id,
                    'display_name' => "$first $last"
                ]);
            }
        }, 10, 1);

        add_action('insert_user_meta', function ($meta, $user, $update) {
            if (!$update && !empty($_POST['first_name']) && !empty($_POST['last_name'])) {
                $meta['first_name'] = trim($_POST['first_name']);
                $meta['last_name'] = trim($_POST['last_name']);
                /* copy info to shipping */
                $meta['shipping_first_name'] = $meta['first_name'];
                $meta['shipping_last_name'] = $meta['last_name'];
                /* check subscribe */
                if (isset($_POST['subscribe']) && $_POST['subscribe'] == true) $this->subscription($user->ID);
            }
            return $meta;
        }, 10, 3);

        add_filter('woocommerce_min_password_strength', function ($strength) {
            return 1;
        });

        add_action('woocommerce_registration_redirect', function () {
            return get_permalink(102); //congratulations page
        }, 2);

        add_action('template_redirect', function () {
            if (is_page(102) && !is_user_logged_in()) {
                wp_redirect(get_permalink(wc_get_page_id('myaccount')));
                exit();
            }
        });
    }

    private function account()
    {
        add_filter('woocommerce_account_menu_items', function ($items) {
            unset($items['dashboard']);
            unset($items['payment-methods']);
            $items['edit-account'] = 'Account Info';
            $items['edit-address'] = 'Address Book';
            $items['customer-logout'] = 'Exit';
            $items = moveKeyBefore($items, 'edit-address', 'edit-account');
            return $items;
        }, 10, 1);

        add_filter('woocommerce_save_account_details_required_fields', function ($fields) {
            unset($fields['account_display_name']);
            return $fields;
        });

        add_action('woocommerce_save_account_details', function ($user_id) {
            if (!empty($_POST['account_first_name']) || !empty($_POST['account_last_name'])) {
                $first = esc_attr(wp_unslash($_POST['account_first_name']));
                $last = esc_attr(wp_unslash($_POST['account_last_name']));
                wp_update_user([
                    'ID' => $user_id,
                    'display_name' => "$first $last"
                ]);
            }
        }, 12, 1);

        add_action('insert_user_meta', function ($meta, WP_User $user, $update) {
            if ($update && isset($_POST['subscribe']) && is_array($_POST['subscribe']) && !empty($_POST['subscribe'])) {
                $subscribe = $_POST['subscribe'];
                $this->subscription($user->ID, $subscribe['new'], $subscribe['promotion'], $subscribe['information']);

                $link = get_edit_user_link($user->ID);
                $message = "User $user->nickname changed his/her subscription settings. See: $link";
                wp_mail(get_bloginfo('admin_email'), 'Subscription changes', $message);
            }
            return $meta;
        }, 10, 3);
    }

    private function subscription($id, $new = true, $promotion = true, $info = true)
    {
        $user = "user_$id";
        update_field('new_items', $new, $user);
        update_field('promotions_and_discounts', $promotion, $user);
        update_field('useful_information', $info, $user);
    }

    private function saveForLater()
    {
        $cart = WC()->cart;
        $key = $_POST['save'];
        $item = $cart->get_cart_item($key);

        $cart->remove_cart_item($key);

        $instance = TInvWL_Public_Wishlist_View::instance();
        $wishlist = $instance->get_current_wishlist();

        $wlp = new TInvWL_Product($wishlist);
        $wlp->add_product(apply_filters('tinvwl_addtowishlist_add', [
            'product_id' => $item['product_id'],
            'quantity' => 1,
        ]));
    }

    public function freeShipping()
    {
        $amounts = [];
        $amount = null;

        $zone = new WC_Shipping_Zone(0);
        $methods = $zone->get_shipping_methods();

        foreach ($methods as $key => $value) {
            if ($value->id === "free_shipping") {
                if ($value->min_amount > 0) $amounts[] = $value->min_amount;
            }
        }

        $zones = WC_Shipping_Zones::get_zones();

        foreach ($zones as $key => $zone) {
            foreach ($zone['shipping_methods'] as $key => $value) {
                if ($value->id === "free_shipping") {
                    if ($value->min_amount > 0) $amounts[] = $value->min_amount;
                }
            }
        }

        if (is_array($amounts)) $amount = min($amounts);

        $amount -= WC()->cart->get_cart_contents_total();

        return $amount > 0 ? "You're $$amount away from FREE shipping!" : "You have free shipping!";
    }

    private function individualDiscount(){
        add_filter('woocommerce_calculated_total', function ($total, WC_Cart $cart) {
            if (is_user_logged_in()) {
                $userField = 'user_' . get_current_user_id();
                if ($discount = get_field('individual_discount', $userField)) {
                    $total -= (float)$cart->get_cart_contents_total() * ((float)$discount / 100);
                }
            }
            return $total;
        }, 10, 2);
    }

    public function cartPayPal()
    {
        $payPal = new WC_Gateway_PPEC_Cart_Handler();
        $payPal->display_mini_paypal_button();
        $payPal->before_cart_totals();
    }

    public function cancelOrder(WC_Order $order)
    {
        $order_id = $order->get_id();
        if ($order->has_status(['on-hold', 'pending', 'processing'])) {
            $url = wp_nonce_url(admin_url('admin-ajax.php?action=mark_order_as_cancell_request&order_id=' . $order_id), 'woocommerce-mark-order-cancell-request-myaccount');
            return $url;
        }
        return false;
    }

    public function invoice(WC_Order $order)
    {
        $instance = BE_WooCommerce_PDF_Invoices::instance();
        $invoice = $instance->add_my_account_pdf([], $order);
        if (!empty($invoice)) {
            return $invoice['invoice']['url'];
        }
        return false;
    }

    public function comments($comments)
    {
        echo '<ul class="reviews">';
        foreach ($comments as $comment) {
            $author = $comment->comment_author;
            $content = $comment->comment_content;
            $date = get_comment_date('d F Y', $comment);
            $rate = intval(get_comment_meta($comment->comment_ID, 'rating', true));
            echo '<li class="comment">';
            echo "<div class='name'>$author</div>";
            echo '<div class="comment-content">';
            echo '<div class="star-rate">';
            for ($i = 1; $i <= $rate; $i++) echo '<i class="fas fa-star"></i>';
            for ($i = 1; $i <= 5 - $rate; $i++) echo '<i class="far fa-star"></i>';
            echo '</div>';
            echo "<p class='text'>$content</p>";
            echo "<p class='date'>$date</p>";
            $children = $comment->get_children();
            if ($children) $this->comments($children);
            echo '</div></li>';
        }
        echo '</ul>';
    }
}