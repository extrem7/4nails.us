<li class="wc_payment_method mb-2 payment_method_<?php echo esc_attr($gateway->id); ?>">
    <div class="custom-control custom-radio">
        <input id="payment_method_<?php echo esc_attr($gateway->id); ?>" type="radio" class="input-radio custom-control-input"
               name="payment_method"
               value="<?php echo esc_attr($gateway->id); ?>" <?php checked($gateway->chosen, true); ?>
               data-order_button_text="<?php echo esc_attr($gateway->order_button_text); ?>"/>

        <label class="custom-control-label" for="payment_method_<?php echo esc_attr($gateway->id); ?>">
            <?php echo $gateway->get_title(); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?><?php echo $gateway->get_icon(); /* phpcs:ignore WordPress.XSS.EscapeOutput.OutputNotEscaped */ ?>
        </label>
    </div>
    <?php if ($gateway->has_fields() || $gateway->get_description()) : ?>
        <div class="payment_box payment_method_<?php echo esc_attr($gateway->id); ?>"
             <?php if (!$gateway->chosen) : /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>style="display:none;"<?php endif; /* phpcs:ignore Squiz.ControlStructures.ControlSignature.NewlineAfterOpenBrace */ ?>>
            <?php $gateway->payment_fields(); ?>
        </div>
    <?php endif; ?>
</li>
