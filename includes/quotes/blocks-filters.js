( function () {
	var blocksCheckout = window.wc && window.wc.blocksCheckout;
	if ( ! blocksCheckout || typeof blocksCheckout.registerCheckoutFilters !== 'function' ) {
		return;
	}

	blocksCheckout.registerCheckoutFilters( 'svd-quote-mode', {
		placeOrderButtonLabel: function () {
			return 'Get a Quote';
		},
		proceedToCheckoutButtonLabel: function () {
			return 'Request a Quote';
		},
	} );
} )();
