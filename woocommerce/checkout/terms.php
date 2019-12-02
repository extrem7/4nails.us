<?php

if ( apply_filters( 'woocommerce_checkout_show_terms', true ) && function_exists( 'wc_terms_and_conditions_checkbox_enabled' ) ) {
	do_action( 'woocommerce_checkout_before_terms_and_conditions' );

	?>
    <h3 class="title line mb-4 mt-5"><?php esc_html_e('Privacy policy', 'woocommerce'); ?></h3>
	<div class="woocommerce-terms-and-conditions-wrapper mt-3">
		<?php
		/**
		 * Terms and conditions hook used to inject content.
		 *
		 * @since 3.4.0.
		 * @hooked wc_checkout_privacy_policy_text() Shows custom privacy policy text. Priority 20.
		 * @hooked wc_terms_and_conditions_page_content() Shows t&c page content. Priority 30.
		 */
		do_action( 'woocommerce_checkout_terms_and_conditions' );
		?>

		<?php if ( wc_terms_and_conditions_checkbox_enabled() ) : ?>
			<div class="form-row mt-2 validate-required">
				<div class="custom-control custom-checkbox woocommerce-form__label woocommerce-form__label-for-checkbox checkbox">
				<input type="checkbox" class="custom-control-input woocommerce-form__input woocommerce-form__input-checkbox input-checkbox" name="terms" required <?php checked( apply_filters( 'woocommerce_terms_is_checked_default', isset( $_POST['terms'] ) ), true ); // WPCS: input var ok, csrf ok. ?> id="terms" />
                <label class="custom-control-label" for="terms"><?php wc_terms_and_conditions_checkbox_text(); ?>&nbsp;<span class="required">*</span></label>
				</div>
				<input type="hidden" name="terms-field" value="1" />
			</div>
		<?php endif; ?>
	</div>
	<?php

	do_action( 'woocommerce_checkout_after_terms_and_conditions' );
}
