<?php

//cool functions for development

function pre($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function path()
{
    return get_template_directory_uri() . '/';
}

function moveKeyBefore($arr, $find, $move)
{
    if (!isset($arr[$find], $arr[$move])) {
        return $arr;
    }

    $elem = [$move => $arr[$move]];  // cache the element to be moved
    $start = array_splice($arr, 0, array_search($find, array_keys($arr)));
    unset($start[$move]);  // only important if $move is in $start
    return $start + $elem + $arr;
}

function tel($phone)
{
    return 'tel:' . preg_replace('/[^0-9]/', '', $phone);
}

function the_post_content()
{
    global $id;
    echo apply_filters('the_content', wpautop(get_post_field('post_content', $id), true));
}

function the_image($name, $class = '', $post = null, $size = 'full')
{
    if ($post == null) {
        global $post;
    }

    $image = get_field($name, $post);

    if ($post == 'option') {
        $src = $image['url'];
        $alt = $image['alt'];
        echo "<img src='$src' alt='$alt' class='$class' />";
    } else {

        echo wp_get_attachment_image($image, $size, false, ['class' => $class]);
    }
}

function the_icon($name, $echo = true)
{
    $icon = file_get_contents(path() . "assets/img/icons/$name.svg");
    if ($echo) {
        echo $icon;
        return true;
    }
    return file_get_contents(path() . "assets/img/icons/$name.svg");
}

function the_checkbox($field, $print, $post = null)
{
    if ($post == null) {
        global $post;
    }
    echo get_field($field, $post) ? $print : null;
}

function the_table($field, $post = null)
{
    if ($post == null) {
        global $post;
    }
    $table = get_field($field, $post);
    if ($table) {
        echo '<table>';
        if ($table['header']) {
            echo '<thead>';
            echo '<tr>';
            foreach ($table['header'] as $th) {
                echo '<th>';
                echo $th['c'];
                echo '</th>';
            }
            echo '</tr>';
            echo '</thead>';
        }
        echo '<tbody>';
        foreach ($table['body'] as $tr) {
            echo '<tr>';
            foreach ($tr as $td) {
                echo '<td>';
                echo $td['c'];
                echo '</td>';
            }
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    }
}

function the_link($field, $post = null, $classes = "")
{
    if ($post == null) {
        global $post;
    }
    $link = get_field($field, $post);
    if ($link) {
        echo "<a ";
        echo "href='{$link['url']}'";
        echo "class='$classes'";
        echo "target='{$link['target']}'>";
        echo $link['title'];
        echo "</a>";
    }
}

function repeater_image($name)
{
    echo 'src="' . get_sub_field($name)['url'] . '" ';
    echo 'alt="' . get_sub_field($name)['alt'] . '" ';
}

// woocommerce functions

function categoryImage($termId)
{
    return get_term_meta($termId, 'thumbnail_id', true);
}

function the_price($product = null)
{
    if ($product == null) {
        global $product;
    }
    echo wc_price($product->get_price());
}

function the_sku($product = null)
{
    if ($product == null) {
        global $product;
    }
    echo $product->get_sku();
}

function the_cart_url($product = null)
{
    if ($product == null) {
        global $product;
    }
    echo $product->add_to_cart_url();
}

function shop_url()
{
    echo get_permalink(wc_get_page_id('shop'));
}

function cart_url()
{
    echo wc_get_cart_url();
}

function checkout_url()
{
    echo wc_get_checkout_url();
}

function wishlist_url()
{
    echo tinv_url_wishlist_default();
}

function account_url()
{
    echo get_permalink(wc_get_page_id('myaccount'));
}

function cart_content()
{
    echo WC()->cart->get_cart_contents_count() ?: '';
}

function cart_active()
{
    echo WC()->cart->get_cart_contents_count() && !is_cart() ? 'active' : '';
}

function cart_total()
{
    echo WC()->cart->get_total();
}

function cart_items()
{
    echo WC()->cart->get_cart_contents_count() == 1 ? ' item' : ' items';
}