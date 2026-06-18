<?php

/**
 * Quote Mode – Comprehensive gettext string replacements.
 *
 * Catches translatable strings from WooCommerce, Elementor Pro's Mini Cart
 * widget, and any other plugin that outputs these phrases.
 *
 * Performance note: the lookup table is built once per request via a static
 * variable so the array is not rebuilt on every translated string.
 */

if ( ! defined( 'ABSPATH' ) || ! defined( 'SVD_QUOTE_MODE' ) ) {
	exit;
}

/**
 * Returns the full map of original English strings => quote equivalents.
 *
 * Keys are the ORIGINAL (source) strings passed to __() / _e() / esc_html__()
 * etc. Values are the replacement strings shown to visitors.
 *
 * @return array<string, string>
 */
function svd_get_quote_string_map() {
	return [

		// ------------------------------------------------------------------
		// Product buttons
		// ------------------------------------------------------------------
		'Add to cart'                                          => 'Add to Quote',
		'Add to Cart'                                          => 'Add to Quote',
		'Read more'                                            => 'View Product',

		// ------------------------------------------------------------------
		// Cart page – buttons, headings, notices
		// ------------------------------------------------------------------
		'Cart'                                                 => 'Quote',
		'Shopping cart'                                        => 'Quote',
		'Shopping Cart'                                        => 'Quote',
		'Your cart'                                            => 'Your quote',
		'Your Cart'                                            => 'Your Quote',
		'View cart'                                            => 'View Quote',
		'View Cart'                                            => 'View Quote',
		'Proceed to checkout'                                  => 'Request a Quote',
		'Update cart'                                          => 'Update Quote',
		'Empty cart'                                           => 'Clear Quote',
		'Clear cart'                                           => 'Clear Quote',
		'Return to cart'                                       => 'Return to Quote',
		'Cart totals'                                          => 'Quote Summary',
		'Cart Totals'                                          => 'Quote Summary',
		'Your cart is currently empty.'                        => 'Your quote list is currently empty.',
		'Your cart is currently empty!'                        => 'Your quote list is currently empty.',

		// Added-to-cart notices
		'%s has been added to your cart.'                      => '%s has been added to your quote.',
		'&ldquo;%s&rdquo; has been added to your cart.'       => '&ldquo;%s&rdquo; has been added to your quote.',
		'Cart updated.'                                        => 'Quote updated.',

		// ------------------------------------------------------------------
		// Checkout page – headings, labels, notes
		// ------------------------------------------------------------------
		'Checkout'                                             => 'Request a Quote',
		'Place order'                                          => 'Get a Quote',
		'Place Order'                                          => 'Get a Quote',
		'Your order'                                           => 'Your quote',
		'Your Order'                                           => 'Your Quote',
		'Order notes'                                          => 'Quote notes',
		'Order Notes'                                          => 'Quote Notes',
		'Notes about your order, e.g. special notes for delivery.' => 'Any additional notes or requirements for your quote.',
		'Additional information'                               => 'Additional information',

		// ------------------------------------------------------------------
		// Thank-you / order-received page
		// ------------------------------------------------------------------
		'Order received'                                       => 'Quote Received',
		'Thank you. Your order has been received.'             => 'Thank you. Your quote request has been received.',
		'Your order has been received, and is now being processed. Your order details are shown below for your reference.' => 'Your quote request has been received. We\'ll be in touch shortly. Your quote details are shown below for your reference.',

		// Order detail labels
		'Order details'                                        => 'Quote details',
		'Order Details'                                        => 'Quote Details',
		'Order number'                                         => 'Quote number',
		'Order Number'                                         => 'Quote Number',
		'Order number:'                                        => 'Quote number:',
		'Order date'                                           => 'Quote date',
		'Order Date'                                           => 'Quote Date',
		'Order date:'                                          => 'Quote date:',
		'Order total'                                          => 'Quote total',
		'Order Total'                                          => 'Quote Total',
		'Order total:'                                         => 'Quote total:',
		'Order status'                                         => 'Quote status',
		'Order Status'                                         => 'Quote Status',
		'Order again'                                          => 'Quote again',

		// ------------------------------------------------------------------
		// My Account – orders list & order detail view
		// ------------------------------------------------------------------
		'Orders'                                               => 'Quotes',
		'My orders'                                            => 'My Quotes',
		'My Orders'                                            => 'My Quotes',
		'Recent orders'                                        => 'Recent Quotes',
		'Recent Orders'                                        => 'Recent Quotes',
		'No order has been made yet.'                          => 'No quote requests have been made yet.',
		'Go shop'                                              => 'Browse Products',

		// WooCommerce uses this format in My Account order rows:
		// translators: 1: order number 2: order date 3: order status
		'Order #%s was placed on %s and is currently %s.'     => 'Quote #%s was placed on %s and is currently %s.',

		// ------------------------------------------------------------------
		// Admin order list / order edit screen
		// ------------------------------------------------------------------
		'New order'                                            => 'New Quote Request',
		'New Order'                                            => 'New Quote Request',

		// ------------------------------------------------------------------
		// Email body strings (WooCommerce default templates)
		// ------------------------------------------------------------------
		'You have received an order from the following customer:' => 'You have received a quote request from the following customer:',
		'Thank you for your order.'                            => 'Thank you for your quote request.',
		'Thank you for ordering with us.'                      => 'Thank you for your quote request.',
		'Your order is on hold'                                => 'Your quote request is on hold',
		'Your order has been received'                         => 'Your quote request has been received',
		'We have received your order.'                         => 'We have received your quote request.',

		// ------------------------------------------------------------------
		// Elementor Pro – Mini Cart widget strings
		// ------------------------------------------------------------------
		'Start shopping'                                       => 'Browse our products',
		'Go to cart'                                           => 'View Quote',
		'Go to Cart'                                           => 'View Quote',
	];
}

/**
 * Swap any matching translatable string to its quote equivalent.
 *
 * Runs on every __() / _e() / esc_html__() call regardless of text domain
 * so it catches strings from WooCommerce AND Elementor Pro's mini-cart.
 *
 * @param string $translated  The already-translated string (equals $original on English sites).
 * @param string $original    The original source string from the code.
 * @param string $domain      The text domain (unused – we intentionally match across all domains).
 * @return string
 */
function svd_quote_gettext( $translated, $original, $domain ) {
	static $map = null;
	if ( null === $map ) {
		$map = svd_get_quote_string_map();
	}

	// Match on the original source string first (canonical, locale-independent).
	if ( isset( $map[ $original ] ) ) {
		return $map[ $original ];
	}

	// Fallback: match on the translated value in case a cached/pre-translated
	// string arrives that differs from its original.
	if ( $translated !== $original && isset( $map[ $translated ] ) ) {
		return $map[ $translated ];
	}

	return $translated;
}

add_filter( 'gettext',              'svd_quote_gettext', 20, 3 );
add_filter( 'gettext_with_context', 'svd_quote_gettext', 20, 3 ); // same signature minus context

/**
 * Handle plural forms (e.g. "1 item" / "%d items").
 *
 * We only replace strings where both the singular AND plural form need
 * to change; counts themselves (%d) are left intact.
 *
 * @param string $translation  Chosen translation for the given $number.
 * @param string $single       Singular source string.
 * @param string $plural       Plural source string.
 * @param int    $number       The number that determined which form to use.
 * @param string $domain       Text domain.
 * @return string
 */
function svd_quote_ngettext( $translation, $single, $plural, $number, $domain ) {
	$plural_map = [
		// My Account: "1 order" / "%d orders"
		'%d order'                     => [ 1 => '%d quote',  'n' => '%d quotes' ],
		'%d orders'                    => [ 1 => '%d quote',  'n' => '%d quotes' ],
		// WooCommerce notices: "1 item" / "%d items"  — kept as-is (cart icon counts)
	];

	if ( isset( $plural_map[ $single ] ) ) {
		return $number === 1 ? $plural_map[ $single ][1] : $plural_map[ $single ]['n'];
	}
	if ( isset( $plural_map[ $plural ] ) ) {
		return $number === 1 ? $plural_map[ $plural ][1] : $plural_map[ $plural ]['n'];
	}

	return $translation;
}

add_filter( 'ngettext', 'svd_quote_ngettext', 20, 5 );
