<?php
	
	/**
	 * Theme functionality
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}
	
	add_action('after_setup_theme', 'fs_setup_theme'); //Sets up theme things
	
	// Scripts and styles
	add_action('wp_enqueue_scripts', function() {
	
	    // Style css
	    wp_enqueue_style('spencer-styles', get_stylesheet_directory_uri().'/style.css', null, filemtime(get_stylesheet_directory().'/style.css'));
	    
	    // JS
		wp_register_script('foundation', get_stylesheet_directory_uri().'/js/foundation.min.js', ['jquery']);
	    wp_register_script('fs-script', get_stylesheet_directory_uri().'/js/scripts.js', ['jquery', 'foundation'], filemtime(get_stylesheet_directory().'/js/scripts.js'));
	    
		// Enqueuse JS file
	    wp_enqueue_script('fs-script');
	
	}, 200);
	
	// Theme shortcodes
	include_once(locate_template('includes/shortcodes.php'));
	
	// Elementor functionality
	include_once(locate_template('includes/elementor.php'));
	
	// ACF functionality
	include_once(locate_template('includes/acf.php'));
	
	// ACF functionality
	include_once(locate_template('includes/woocommerce.php'));

	// Quote mode – swaps WooCommerce "order/cart/checkout" language to quotes.
	// To disable, comment out the line below.
	include_once( locate_template( 'includes/quotes/loader.php' ) );

	// ACF functionality
	include_once(locate_template('includes/training.php'));
	
	add_action('admin_init', function() {
		if(!isset($_GET['asdjifbnkasdf'])) {
			return;
		}
		$products = wc_get_products( [
			'type'   => 'variable',
			'limit'  => -1,
			'status' => 'publish',
		] );
		
		$updated = 0;
		
		foreach ( $products as $product ) {
			$defaults = $product->get_default_attributes();
			
			// Skip if defaults are already set
			if ( ! empty( $defaults ) ) {
				continue;
			}
			
			$variations = $product->get_available_variations();
			
			if ( empty( $variations ) ) {
				continue;
			}
			
			// Use the first available variation's attributes as the default
			$first_variation = $variations[0];
			$new_defaults    = [];
			
			foreach ( $first_variation['attributes'] as $key => $value ) {
				// Strip 'attribute_' prefix WooCommerce adds to keys
				$attribute_name               = str_replace( 'attribute_', '', $key );
				$new_defaults[ $attribute_name ] = $value;
			}
			
			$product->set_default_attributes( $new_defaults );
			$product->save();
			$updated++;
			
			echo "Updated product ID {$product->get_id()}: {$product->get_name()}\n";
		}
		
		echo "Done. Updated {$updated} products.\n";
		die();
	});
	
	/**
	 * fs_setup_theme function
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function fs_setup_theme() {
		
		// Adds small_thumb image size cropped proportionally
		add_image_size('small_thumb', 300);
		
	}