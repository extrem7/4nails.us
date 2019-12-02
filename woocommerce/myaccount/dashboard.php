<p><?
	printf(
		__( 'Hello %1$s (not %1$s? <a href="%2$s" class="link">Log out</a>)', 'woocommerce' ),
		'<strong>' . esc_html( $current_user->display_name ) . '</strong>',
		esc_url( wc_logout_url( wc_get_page_permalink( 'myaccount' ) ) )
	);
?></p>

<p><?
	printf(
		__( 'From your account dashboard you can view your <a href="%1$s" class="link">recent orders</a>, manage your <a href="%2$s" class="link">shipping and billing addresses</a>, and <a href="%3$s" class="link">edit your password and account details</a>.', 'woocommerce' ),
		esc_url( wc_get_endpoint_url( 'orders' ) ),
		esc_url( wc_get_endpoint_url( 'edit-address' ) ),
		esc_url( wc_get_endpoint_url( 'edit-account' ) )
	);
?></p>