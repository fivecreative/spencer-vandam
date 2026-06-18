<?php

/**
 * Quote Mode – Loader
 *
 * Replaces WooCommerce "order / cart / checkout" language with
 * quote-based equivalents across the storefront, mini-cart,
 * checkout, thank-you page, My Account, and emails.
 *
 * To ENABLE:  add the following line to functions.php —
 *     include_once( locate_template( 'includes/quotes/loader.php' ) );
 *
 * To DISABLE: comment-out or remove that line.
 *
 * No database changes are made; everything is done via PHP filters.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'SVD_QUOTE_MODE' ) ) {
	define( 'SVD_QUOTE_MODE', true );
}

require_once __DIR__ . '/button-text.php';
require_once __DIR__ . '/string-replacements.php';

add_action( 'wp_enqueue_scripts', function () {
	if ( ! ( is_cart() || is_checkout() ) ) {
		return;
	}
	wp_enqueue_script(
		'svd-quote-blocks-filters',
		get_stylesheet_directory_uri() . '/includes/quotes/blocks-filters.js',
		[ 'wc-blocks-checkout' ],
		filemtime( get_stylesheet_directory() . '/includes/quotes/blocks-filters.js' ),
		true
	);
} );
