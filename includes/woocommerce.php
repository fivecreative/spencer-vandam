<?php
	
	/**
	 * WC functionality for the theme
	 */
	
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}
	
	add_filter('woocommerce_breadcrumb_defaults', 'sv_breadcrumb_args', 20); // Woocommerce breadcrumb arguments
	add_filter('woocommerce_single_product_image_thumbnail_html', 'sv_show_gallery_as_first_image', 20, 2); // Shows the first image gallery as the main image slider
	add_filter('woocommerce_product_get_gallery_image_ids', 'sv_wc_insert_featured_image_id_in_product_gallery', 20, 2); // Insert featured image at the end of our gallery
	add_filter('woocommerce_product_thumbnails_columns', 'sv_wc_product_slider_thumbnail_columns'); // Changes the number of columns in our slider
	add_filter('woocommerce_product_data_tabs', 'sv_wc_add_downloads_data_tab', 20, 1); // Adds download data tab to product data
	add_filter('woocommerce_get_breadcrumb', 'sv_wc_add_shop_to_breadcrumb_list', 10, 2); // Adds the shop page to the breadcrumbs structure
	add_filter('register_pa_solutions_taxonomy_args', 'sv_wc_enable_solution_attributes_archives_in_elementor', 20, 3); // Ensures we can select pa_solutions in the elementor template conditions
	add_filter('register_pa_use-case_taxonomy_args', 'sv_wc_enable_solution_attributes_archives_in_elementor', 20, 3); // Ensures we can select pa_solutions in the elementor template conditions
	add_filter('woocommerce_product_single_add_to_cart_text', 'sv_wc_add_to_cart_text');
	add_filter('woocommerce_product_add_to_cart_text', 'sv_wc_add_to_cart_text');
	
	add_action('after_setup_theme', 'sv_wc_disable_gallery_zoom', 20); // Disables the default gallery zoom for woocommerce galleries
	add_action('woocommerce_product_data_panels', 'sv_wc_downloads_data_tab');
	
	/**
	 * sv_breadcrumb_args function
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @param $args
	 *
	 * @return mixed
	 */
	function sv_breadcrumb_args($args) {
		
		$args['home'] = '&nbsp;';
		$args['delimiter'] = '<span class="sv-wc-breadcrumb-delimiter">/</span>';
		
		return $args;
		
	}
	
	/**
	 * sv_show_gallery_as_first_image function
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @param $html
	 * @param $thumbnail_id
	 *
	 * @return mixed|string
	 */
	function sv_show_gallery_as_first_image($html, $thumbnail_id) {
		
		global $product;
		
		if(!is_product() || empty($product->get_image_id())) {
			return $html;
		}
		
		// If we are doing our product thumbnails - ignore the thumbnail ID that is the first one in our gallery
		if(doing_action('woocommerce_product_thumbnails')) {
			$image_ids = $product->get_gallery_image_ids();
			if($thumbnail_id == $image_ids[0]) {
				return '';
			}
			return $html;
		}
		
		// Do we have a gallery?
		if($product->get_gallery_image_ids()) {
			$image_id = $product->get_gallery_image_ids()[0];
			$html = wc_get_gallery_image_html($image_id, true );
		}
		
		return $html;
		
	}
	
	/**
	 * Appends the featured image ID to the product gallery image IDs.
	 * This function modifies the array of gallery image IDs for a WooCommerce
	 * product by appending the featured image ID at the end, if one exists.
	 *
	 * @param array $image_ids The current gallery image IDs for a product.
	 * @param int $product The product object.
	 *
	 * @return array The modified array of gallery image IDs.
	 */
	function sv_wc_insert_featured_image_id_in_product_gallery($image_ids, WC_Product $product) {
		
		remove_filter('woocommerce_product_get_gallery_image_ids', 'sv_wc_insert_featured_image_id_in_product_gallery', 20, 2);
		
		// If we have a gallery and its single product - insert the main featured image at the top and remove the first image id
		if(!is_product() || empty($product->get_gallery_image_ids()) || empty($product->get_image_id())) {
			return $image_ids;
		}
		
		$image_ids[] = $product->get_image_id();
		$image_ids = array_values(array_unique($image_ids));
		
		add_filter('woocommerce_product_get_gallery_image_ids', 'sv_wc_insert_featured_image_id_in_product_gallery', 20, 2);
		
		return $image_ids;
		
	}
	
	/**
	 * sv_wc_product_slider_thumbnail_columns function
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return int
	 */
	function sv_wc_product_slider_thumbnail_columns() {
		return 7;
	}
	
	
	/**
	 * Disables the zoom feature on the WooCommerce product gallery images.
	 * This function ensures that the zoom-in functionality is not available when
	 * users hover over the product images, providing a consistent user experience
	 * without zoom interaction.
	 */
	function sv_wc_disable_gallery_zoom() {
		remove_theme_support('wc-product-gallery-zoom');
		remove_theme_support( 'wc-product-gallery-lightbox' );
	}
	
	/**
	 * Adds a custom downloads data tab to the WooCommerce product page. This function integrates an additional tab in the product data section,
	 * specifically designed to handle downloadable products, enhancing the information accessibility for such products on the WooCommerce platform.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @param $tabs
	 *
	 * @return mixed
	 */
	function sv_wc_add_downloads_data_tab($tabs) {
		$tabs['acf_downloads'] = ['label' => __('Downloads', 'your-textdomain'), 'target' => 'acf_downloads_product_data', 'class' => [], 'priority' => 70];
		return $tabs;
	}
	
	/**
	 * Handles the layout and content for the custom downloads data tab.
	 * This action provides the necessary HTML content and setup for the
	 * 'acf_downloads_product_data' container, ensuring proper display of
	 * downloadable product information within the WooCommerce product page.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 */
	function sv_wc_downloads_data_tab() {
		global $post;
		
		echo '<div id="acf_downloads_product_data" class="panel woocommerce_options_panel">';
		
		if(function_exists('acf_get_field_groups')) {
			
			// Custom screen context — matches our location rule
			$screen = ['post_id' => $post->ID, 'post_type' => 'product', 'wc_product_tab' => 'downloads'];
			
			$field_groups = acf_get_field_groups($screen);
			
			// Only keep field groups that explicitly have a wc_product_tab rule.
			// Without this, any field group with "post_type == product" would also
			// match because post_type is present in the screen context above.
			$field_groups = array_filter($field_groups, function($field_group) {
				foreach((array) $field_group['location'] as $rule_group) {
					foreach((array) $rule_group as $rule) {
						if(isset($rule['param']) && $rule['param'] === 'wc_product_tab') {
							return true;
						}
					}
				}
				return false;
			});
			
			if(!empty($field_groups)) {
				
				// Output the ACF nonce required for saving.
				// This is normally added automatically when ACF renders a meta box,
				// but since we're rendering manually we add it here.
				static $nonce_output = false;
				if(!$nonce_output) {
					wp_nonce_field('acf_form_data', 'acf_nonce', false, true);
					$nonce_output = true;
				}
				
				foreach($field_groups as $field_group) {
					$fields = acf_get_fields($field_group);
					if($fields) {
						// 'label' = instructions appear below the field label (default)
						// 'field' = instructions appear below the input
						acf_render_fields($fields, $post->ID, 'div', 'label');
					}
				}
			} else {
				echo '<p class="form-field" style="padding:10px 12px;color:#757575;">';
				esc_html_e('No ACF field groups found. Set Location to: Product Data Tab == Downloads.', 'your-textdomain');
				echo '</p>';
			}
		}
		
		echo '</div>';
	}
	
	/**
	 * Change the icon for the downloads tab
	 *
	 * @version 1.0.0
	 * @since    1.0.0
	 * @return void
	 */
	add_action('admin_head', function() {
		$screen = get_current_screen();
		if(!$screen || 'product' !== $screen->id) {
			return;
		}
		echo '<style> #woocommerce-product-data ul.wc-tabs li.acf_downloads_tab a::before { content: \'\f316\'; font-family: dashicons; } div#acf_downloads_product_data { padding: 0 15px; } #woocommerce-product-data ul.wc-tabs li.woo_variation_swatches_options {
	display: none !important;
}</style>';
	});
	
	/**
	 * Remove variation attributes from product attributes
	 */
	add_filter('woocommerce_display_product_attributes', function($attributes, $product) {
		$product_attributes = $product->get_attributes();
		foreach($attributes as $key => $attribute) {
			$name = str_replace('attribute_', '', $key);
			if(isset($product_attributes[$name]) && $product_attributes[$name]->get_variation()) {
				unset($attributes[$key]);
			}
		}
		return $attributes;
	}, 10, 2);
	
	/**
	 * Adds the shop page to the WooCommerce breadcrumb list.
	 * This function ensures that the shop page is included in the breadcrumb
	 * navigation, improving user experience and site navigation by providing
	 * a clear path back to the main shop area.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @param array $breadcrumb The current breadcrumb list.
	 * @return array Modified breadcrumb list including the shop page.
	 */
	function sv_wc_add_shop_to_breadcrumb_list($crumbs, $breadcrumb) {
		
		// If blog
		if((is_singular() && 'post' == get_post_type()) || (is_category() || is_tag())) {
			array_splice($crumbs, 1, 0, [[get_the_title(get_field('resources_page', 'options')), get_permalink(get_field('resources_page', 'options'))]]);
			return $crumbs;
		}
		
		// Only apply on single products and all product taxonomy archives (categories, tags, attributes)
		if(!is_product() && !is_tax(get_object_taxonomies('product'))) {
			return $crumbs;
		}
		
		$shop_page_id = wc_get_page_id('shop');
		if(!$shop_page_id || $shop_page_id === -1) {
			return $crumbs;
		}
		
		$shop_url = get_permalink($shop_page_id);
		
		// Bail if shop crumb is already present
		foreach($crumbs as $crumb) {
			if($crumb[1] === $shop_url) {
				return $crumbs;
			}
		}
		
		// Insert shop crumb at position 1, after Home
		array_splice($crumbs, 1, 0, [[get_the_title($shop_page_id), $shop_url]]);
		
		return $crumbs;
		
	}
	
	/**
	 * Enables solution attributes archives in Elementor.
	 * This function configures Elementor to display archives for solution attributes,
	 * allowing better content management and site organization within the Elementor
	 * environment.
	 */
	function sv_wc_enable_solution_attributes_archives_in_elementor($args, $taxonomy, $args_type) {
		
		$args['show_in_nav_menus'] = true;
		
		return $args;
		
	}
	
	function sv_wc_add_to_cart_text() {
		return 'Add to Quote';
	}