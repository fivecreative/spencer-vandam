<?php

/**
 * Quote Mode – WooCommerce-specific button and page text hooks.
 *
 * These named WC filters are more reliable than the gettext approach for
 * buttons and structured sections, so we handle them here explicitly.
 */

if ( ! defined( 'ABSPATH' ) || ! defined( 'SVD_QUOTE_MODE' ) ) {
	exit;
}

// --- Product buttons -----------------------------------------------------------

// Single product page "Add to cart" button
add_filter( 'woocommerce_product_single_add_to_cart_text', function () {
	return 'Add to Quote';
} );

// Shop / archive "Add to cart" button
add_filter( 'woocommerce_product_add_to_cart_text', function () {
	return 'Add to Quote';
} );

// --- Checkout ------------------------------------------------------------------

// "Place order" submit button on the checkout page
add_filter( 'woocommerce_order_button_text', function () {
	return 'Get a Quote';
} );

// --- Thank-you / order-received page ------------------------------------------

// Main confirmation message below the page title
add_filter( 'woocommerce_thankyou_order_received_text', function () {
	return 'Thank you! Your quote request has been received. We\'ll review your items and be in touch shortly with your custom quote.';
} );

// --- Email subjects & headings ------------------------------------------------

// Admin "new order" notification
add_filter( 'woocommerce_email_subject_new_order', function ( $subject, $order ) {
	return sprintf( '[%s] New Quote Request (#%s)', get_bloginfo( 'name' ), $order->get_order_number() );
}, 10, 2 );

add_filter( 'woocommerce_email_heading_new_order', function () {
	return 'New Quote Request';
} );

// Customer "processing order" (sent after checkout)
add_filter( 'woocommerce_email_subject_customer_processing_order', function ( $subject, $order ) {
	return sprintf( 'Your %s quote request has been received (#%s)', get_bloginfo( 'name' ), $order->get_order_number() );
}, 10, 2 );

add_filter( 'woocommerce_email_heading_customer_processing_order', function () {
	return 'Thank you for your quote request!';
} );

// Customer "on-hold order" (sent for bank transfer / manual payment)
add_filter( 'woocommerce_email_subject_customer_on_hold_order', function ( $subject, $order ) {
	return sprintf( 'Your %s quote request is being reviewed (#%s)', get_bloginfo( 'name' ), $order->get_order_number() );
}, 10, 2 );

add_filter( 'woocommerce_email_heading_customer_on_hold_order', function () {
	return 'Your quote request is being reviewed';
} );

// Customer "completed order"
add_filter( 'woocommerce_email_subject_customer_completed_order', function ( $subject, $order ) {
	return sprintf( 'Your %s quote is ready (#%s)', get_bloginfo( 'name' ), $order->get_order_number() );
}, 10, 2 );

add_filter( 'woocommerce_email_heading_customer_completed_order', function () {
	return 'Your quote is ready!';
} );
