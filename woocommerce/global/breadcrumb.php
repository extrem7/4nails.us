<?php
if (is_front_page() || is_order_received_page()) return;
?>
<div class="container breadcrumbs">
    <?
    if (!empty($breadcrumb)) {

        echo $wrap_before;

        foreach ($breadcrumb as $key => $crumb) {

            echo $before;

            if (!empty($crumb[1]) && sizeof($breadcrumb) !== $key + 1) {
                echo '<a href="' . esc_url($crumb[1]) . '">' . esc_html($crumb[0]) . '</a>';
            } else {
                echo esc_html($crumb[0]);
            }

            echo $after;

            if (sizeof($breadcrumb) !== $key + 1) {
                echo $delimiter;
            }
        }

        echo $wrap_after;

    } ?>
</div>
