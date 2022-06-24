<?php
/**
 * Check if WooCommerce is activated
 *
 * @since 3.13.0
 *
 * @return bool
 */
function realhomes_is_woocommerce_activated() {

	if ( class_exists( 'woocommerce' ) ) {
		return true;
	}

	return false;
}

/**
 * Hides the WooCommerce page title for shop page.
 *
 * @since 3.13.0
 *
 * @return bool
 */
function realhomes_hide_woocommerce_page_title() {
	return false;
}

add_filter( 'woocommerce_show_page_title', 'realhomes_hide_woocommerce_page_title' );