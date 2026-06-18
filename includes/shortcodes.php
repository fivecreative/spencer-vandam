<?php
	
	/**
	 * Theme shortcodes
	 */
	
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}
	
	add_shortcode('fs_page_title', 'fs_page_title'); // Gets the page title from ACF or page itself
	add_shortcode('fs_flexible_layout_wrapper_css_classes', 'fs_flexible_layout_wrapper_css_classes'); // Adds classes to our flexible wrapper classes
	add_shortcode('fs_flexible_layout_wrapper_id', 'fs_flexible_layout_wrapper_id'); // Wrapper ID for flexible section
	add_shortcode('fs_acf_image_object_fit', 'fs_acf_image_object_fit'); // Sets the object-fit attribute for ACF image fields
	add_shortcode('fs_get_archive_name', 'fs_get_archive_name'); // Gets the current looped taxonomy archive name
	add_shortcode('fs_get_acf_field_for_tax_query', 'fs_get_acf_field_for_tax_query'); // Gets an ACF field for a taxonomy when we are looping a taxonomy
	add_shortcode('fs_tel_link', 'fs_tel_link'); // Processes a telephone link from options page
	add_shortcode('fs_get_featured_image', 'fs_get_featured_image'); // Gets the featured image of the current object
	add_shortcode('fs_is_tax_page', 'fs_is_tax_page_shortcode'); // Whether its a term page
	add_shortcode('fs_get_term_featured_image', 'fs_get_term_featured_image'); // Gets term featured image - either from woocommerce or ACF field
	add_shortcode('sv_product_category_children_list', 'sv_product_category_children_list'); // Lists the children categories of a product category
	add_shortcode('sv_product_category_has_subcategories', 'sv_product_category_has_subcategories'); // Whether the product category has subcategories displaying
	add_shortcode('sv_is_single_product', 'sv_is_single_product'); // If is single product
	add_shortcode('sv_wc_product_features_list', 'sv_wc_product_features_list'); // Features list shortcode
	add_shortcode('sv_wc_product_has_features_list', 'sv_wc_product_has_features_list'); // Has features list shortcode
	add_shortcode('sv_wc_product_download_file_url', 'sv_wc_product_download_file_url'); // Gets the download URL from the file attachemnt in the product downloads repeater field
	add_shortcode('sv_wc_product_download_thumbnail_image', 'sv_wc_product_download_thumbnail_image'); // Displays the file URL thumbnail image for product downloads repeater field
	add_shortcode('sv_wc_is_product_accessory', 'sv_wc_is_product_accessory'); // Returns yes if product is in accessories cateogry
	add_shortcode('sv_showroom_address_escaped', 'sv_showroom_address_escaped'); // escapes the line break on our address for showroom so we can display the map properly
	add_shortcode('fs_fl_image_cards_sublinks', 'fs_fl_image_cards_sublinks'); // Sublinks for card with image and sublinks flexible layout
	add_shortcode('fs_fl_get_acf_field', 'fs_fl_get_acf_field_from_current_object');
	add_shortcode('footer_cta_buttons_source', 'fs_fl_footer_cta_buttons_source'); // Source for the buttons repeater field
	add_shortcode('sv_full_width_image_section', 'sv_full_width_image_section'); // Sortcode for our full width image
	add_shortcode('sv_shop_url', 'sv_shop_url'); // Returns woocommerce shop URL
	add_shortcode('sv_wc_product_description', 'sv_wc_product_description'); // Current products long description
	add_shortcode('sv_mobile_menu', 'sv_mobile_menu'); // Drilldown mobile menu
	add_shortcode('sv_wc_product_has_additional_info', 'sv_wc_product_has_additional_info'); // Whether the product has additional information to show
	add_shortcode('sv_resource_has_related_resources', 'sv_resource_has_related_resources'); // Whether the single resource has related articles to show
	add_filter( 'big_image_size_threshold', '__return_false' );

	
	/**
	 * sv_is_single_product function
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return false|string
	 */
	function sv_is_single_product() {
		return is_product() ? 'yes' : false;
	}
	
	/**
	 * sv_product_category_has_subcategories function
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @param $atts
	 *
	 * @return false|string
	 */
	function sv_product_category_has_subcategories($atts) {
		
		if(!is_product_category()) {
			return false;
		}
		
		$category = get_queried_object();
		
		$terms = new WP_Term_Query([
			'taxonomy' => 'product_cat',
			'child_of' => get_queried_object_id(),
			'hide_empty' => false,
		]);
		
		if(count($terms->get_terms()) > 0) {
			return 'yes';
		}
		
		return false;
		
	}
	
	/**
	 * Retrieves the page title. Returns a custom field value 'page_title' if set; otherwise, falls back to the default post title.
	 *
	 * @return string The page title string.
	 */
	function fs_page_title() {
		
		// Single and terms whhen we hhave a custom page title
		if(is_single() || is_tax() || is_shop() || is_front_page() || is_page()) {
			
			$object = get_queried_object();
			
			if(is_shop()) {
				$object = get_post(wc_get_page_id('shop'));
			}
			
			if(!empty(get_field('page_title', $object))) {
				return get_field('page_title', $object);
			}
			
		}
		
		// Returns ELementors util page title
		return ElementorPro\Core\Utils::get_page_title(false);
		
	}
	
	/**
	 * Generates a list of CSS classes for a flexible layout wrapper based on ACF subfields and structure.
	 *
	 * The generated classes include base classes, vertical padding classes, mobile-specific padding
	 * classes, and grid type classes, depending on the values of associated ACF subfields.
	 *
	 * @return string A space-separated string of CSS classes for the flexible layout wrapper.
	 */
	function fs_flexible_layout_wrapper_css_classes() {
		
		// base classes
		$classes = [
			'fs-fl-bg-'.get_sub_field('section_bg'),
			'fs-fl-type-'.get_row_layout(),
			'fs-fl-item'
		];
		
		// Vertical padding
		if(!empty(get_sub_field('vertical_padding')) && get_sub_field('vertical_padding') != 'default') {
			$classes[] = 'fs-fl-p-'.get_sub_field('vertical_padding');
		}
		
		// Mobile vertical padding
		if(!empty(get_sub_field('vertical_padding_mobile')) && get_sub_field('vertical_padding_mobile') != 'default') {
			$classes[] = 'fs-fl-p-mobile-'.get_sub_field('vertical_padding_mobile');
		}
		
		// Grid type
		if(!empty(get_sub_field('grid_type'))) {
			$classes[] = 'fs-fl-loop-grid-dynamic';
			$classes[] = 'fs-fl-loop-grid-'.get_sub_field('grid_type');
		}
		
		// IF we have a layout columns layout
		if(get_sub_field('layout_columns')) {
			$classes[] = 'fs-fl-loop-grid-columns-'.get_sub_field('layout_columns');
		}
		
		return implode(' ', $classes);
		
	}
	
	/**
	 * Retrieves the section container ID from a flexible layout field if it is set.
	 *
	 * @return string|null The section container ID value if available, or null otherwise.
	 */
	function fs_flexible_layout_wrapper_id() {
		if(get_sub_field('section_container_id')) {
			return get_sub_field('section_container_id');
		}
		
		return '';
	}
	
	/**
	 * Determines the CSS class for image object fit based on the value of the 'image_fit' subfield.
	 *
	 * @return string Returns 'fs-image-object-fit-contain' if the 'image_fit' subfield exists and equals 'contain'.
	 *                Returns an empty string if the 'image_fit' subfield does not meet the condition.
	 */
	function fs_acf_image_object_fit() {
		if(get_sub_field('image_fit') && get_sub_field('image_fit') == 'contain') {
			return 'fs-image-object-fit-contain';
		}
		return '';
	}
	
	/**
	 * Retrieves the name of the archive being displayed.
	 *
	 * Checks if the global `$wp_query` object has a `loop_term` property with a `name` value.
	 * If available, it returns the name of `loop_term`. If not, it retrieves and returns
	 * the name of the currently queried object.
	 *
	 * @return string Returns the name of the archive term or the queried object name.
	 * @global WP_Query $wp_query The global WordPress query object.
	 *
	 */
	function fs_get_archive_name() {
		
		global $wp_query;
		
		if(!empty($wp_query->loop_term)) {
			return $wp_query->loop_term->name;
		}
		
		return get_queried_object()->name;
		
	}
	
	/**
	 * Retrieves an ACF field value for a taxonomy query based on the provided arguments.
	 *
	 * @param array $args An associative array of arguments. Requires the 'field' key specifying the name of the ACF field.
	 *                    If the 'field' key is not provided or is empty, the method returns false.
	 *
	 * @return mixed Returns the value of the specified ACF field for the current taxonomy object.
	 *               Returns false if the 'field' argument is not set or empty.
	 */
	function fs_get_acf_field_for_tax_query($args) {
		
		if(empty($args['field'])) {
			return false;
		}
		
		global $wp_query;
		
		$object = !empty($wp_query->loop_term) ? $wp_query->loop_term : get_queried_object();
		
		$value = get_field($args['field'], $object);
		
		if(is_array($value)) {
			return print_r($value, true);
		} else {
			return $value;
		}
		
	}
	
	/**
	 * Generates a telephone link based on the specified field.
	 *
	 * @param array $args An associative array with the following key:
	 *                    - 'field' (string): The name of the field to retrieve the telephone value from. This key is mandatory.
	 *
	 * @return string|false Returns a formatted telephone link (e.g., "tel:123456789") if the field value exists and is valid,
	 *                      or false if the field name is not provided or the value is empty.
	 */
	function fs_tel_link($args) {
		
		// Field name mandatory
		if(empty($args['field'])) {
			return false;
		}
		
		if(str_contains($args['field'], ':options')) {
			$value = get_field(str_replace(':options', '', $args['field']), 'options');
		} else {
			// Value
			$value = get_sub_field($args['field']);
		}
		
		// No empty values
		if(empty($value)) {
			return false;
		}
		
		if(!empty($args['type'])) {
			$type = $args['type'];
		} else {
			$type = 'tel:';
		}
		
		// Cleans it up
		return $type.':'.str_replace(' ', '', $value);
		
	}
	
	/**
	 * Retrieves the featured image associated with a post, taxonomy term, or custom field.
	 *
	 * Depending on the context, it will determine the appropriate source for retrieving the featured image:
	 * - For single posts, it retrieves the post's thumbnail ID.
	 * - For taxonomy terms, it checks for an ACF field or term meta for the featured image.
	 *
	 * @return array|false Returns an associative array containing:
	 *                     - 'id' (int): The attachment ID of the featured image.
	 *                     - 'url' (string): The URL of the featured image in full size.
	 *                     Returns false if no featured image is found.
	 */
	function fs_get_featured_image() {
		
		// If is a single
		if(is_single()) {
			$image_id = get_post_thumbnail_id();
		} elseif(is_tax()) {
			// Try ACF
			return false;
			/*if(get_field('featured_image', get_queried_object_id())) {
				$image_id = get_field('featured_image', get_queried_object_id());
			} elseif(get_term_meta(get_queried_object_id(), 'thumbnail_id', true) != '') {
				$image_id = get_term_meta(get_queried_object_id(), 'thumbnail_id', true);
			}*/
		}
		
		if(empty($image_id)) {
			return false;
		}
		
		$image_url = wp_get_attachment_image_url($image_id, 'full');
		
		return [
			'id' => $image_id,
			'url' => $image_url,
		];
		
	}
	
	/**
	 * Retrieves the featured image for a taxonomy term.
	 *
	 * @return array|false Returns an associative array containing the featured image details:
	 *                     - 'id' (int): The attachment ID for the featured image.
	 *                     - 'url' (string): The full URL of the featured image.
	 *                     Returns false if the current page is not a taxonomy archive
	 *                     or if no featured image is found for the term.
	 */
	function fs_get_term_featured_image() {
		
		if(!is_tax()) {
			return false;
		}
		
		if(get_field('featured_image', get_queried_object_id())) {
			$image_id = get_field('featured_image', get_queried_object_id());
		} elseif(get_term_meta(get_queried_object_id(), 'thumbnail_id', true) != '') {
			$image_id = get_term_meta(get_queried_object_id(), 'thumbnail_id', true);
		}
		
		if(empty($image_id)) {
			return false;
		}
		
		$image_url = wp_get_attachment_image_url($image_id, 'full');
		
		return [
			'id' => $image_id,
			'url' => $image_url,
		];
		
	}
	
	
	/**
	 * Checks if the current page is a taxonomy page within a shortcode context.
	 *
	 * This utility function determines whether WordPress is rendering a taxonomy
	 * archive page when a specific shortcode is in use. It is useful for conditional
	 * logic inside shortcodes.
	 *
	 * @return bool Returns true if the current page is a taxonomy archive and the
	 *              shortcode context is detected, otherwise returns false.
	 */
	function fs_is_tax_page_shortcode() {
		return is_tax() ? 'yes' : false;
	}
	
	/**
	 * Gets the URL of the featured image for a taxonomy term.
	 * If the term has a featured image, it returns the full URL of the image.
	 * Otherwise, it returns false.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return false|string
	 */
	function sv_product_category_children_list() {
		
		if(is_tax('product_cat')) {
			$object = get_queried_object();
		} else {
			
			global $wp_query;
			
			if(!empty($wp_query->loop_term)) {
				$object = $wp_query->loop_term;
			}
			
		}
		
		if(empty($object)) {
			return false;
		}
		
		$term_query = new WP_Term_Query([
			'taxonomy' => 'product_cat',
			'hide_empty' => false,
			'child_of' => $object->term_id,
		]);
		
		$terms = $term_query->get_terms();
		
		if(empty($terms)) {
			return false;
		}
		
		ob_start();
		
		echo '<div class="sv-product-cat-tag-list">';
		
		foreach($terms as $term) {
			echo '<a class="sv-product-cat-tag e-paragraph-base" href="'.get_term_link($term).'"><span>'.$term->name.'</span></a>';
		}
		
		echo '</div>';
		
		return ob_get_clean();
		
	}
	
	/**
	 * Outputs a list of features for a WooCommerce product.
	 * The function retrieves product features and formats them into HTML for display.
	 * Returns a string containing the HTML of the feature list.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 * @return string The HTML string of the product features list.
	 */
	function sv_wc_product_features_list() {
		
		global $product;
		
		if(!$product instanceof WC_Product) {
			return '';
		}
		
		$attribute_key = 'pa_features';
		
		$terms = wc_get_product_terms($product->get_id(), $attribute_key, ['fields' => 'all']);
		
		if(empty($terms) || is_wp_error($terms)) {
			return '';
		}
		
		$with_icon    = [];
		$without_icon = [];
		
		foreach($terms as $term) {
			$icon_html = '';
			
			if(function_exists('get_field')) {
				$icon = get_field('feature_icon', $attribute_key.'_'.$term->term_id);
				
				if(!empty($icon)) {
					$src = is_array($icon) ? ($icon['url'] ?? '') : $icon;
					
					if($src) {
						$alt       = is_array($icon) ? esc_attr($icon['alt'] ?? $term->name) : esc_attr($term->name);
						$icon_html = '<img src="'.esc_url($src).'" alt="'.$alt.'" class="feature-icon">';
					}
				}
			}
			
			if($icon_html) {
				$with_icon[] = '<li class="has-icon"><span class="sv-wc-product-features-list-icon">'.$icon_html.'</span><span>'.esc_html($term->name).'</span></li>';
			} else {
				$without_icon[] = '<li><span>'.esc_html($term->name).'</span></li>';
			}
		}
		
		$items = implode('', array_merge($with_icon, $without_icon));
		
		return '<ul class="sv-wc-product-features-list">'.$items.'</ul>';
		
	}
	/**
	 * Checks if the current product has a list of features.
	 * It retrieves product terms associated with features and returns a formatted
	 * list. If no terms are found or an error occurs, it returns an empty string.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return string The HTML list of product features or an empty string if none.
	 */
	function sv_wc_product_has_features_list() {
		
		global $product;
		
		if(!$product instanceof WC_Product) {
			return 'false';
		}
		
		$terms = wc_get_product_terms($product->get_id(), 'pa_features', ['fields' => 'ids']);
		
		return (!empty($terms) && !is_wp_error($terms)) ? 'yes' : 'false';
		
	}
	
	/**
	 * Retrieves the URL of the file attachment associated with a WooCommerce product download.
	 * If the file is not found or has no URL, it returns a default value of '#'.
	 *
	 * @version 1.0.0
	 * @since    1.0.0
	 */
	function sv_wc_product_download_file_url() {
		
		$file = get_sub_field('file');
		
		if(empty($file) || empty($file['url'])) {
			return '#';
		}
		
		return $file['url'];
		
	}
	
	/**
	 * Retrieves the thumbnail image associated with a WooCommerce product download.
	 * It accesses the subfield to get the image array and returns the URL of the
	 * thumbnail. If no image is found, it defaults to returning an empty string.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return string The URL of the thumbnail image or an empty string if not set.
	 */
	function sv_wc_product_download_thumbnail_image() {
		
		$default_image = get_stylesheet_directory_uri().'/images/product-download-icon.svg';
		
		$file = get_sub_field('file');
		$title = get_sub_field('title');
		
		if(!empty($file)) {
			$attachment_id = $file['ID'];
			$image = wp_get_attachment_image($attachment_id, 'small_thumb');
		}
		
		if(empty($image)) {
			$image = '<img src="'.$default_image.'" alt="'.$title.'" class="product-download-icon">';
		}
		
		return '<a href="'.$file['url'].'" target="_blank">'.$image.'</a>';
		
	}
	
	/**
	 * Determines if a given product is classified as an accessory.
	 * This function evaluates specific product terms to identify accessory products,
	 * returning a boolean result based on the classification logic.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @param WC_Product $product The WooCommerce product to evaluate.
	 *
	 * @return bool True if the product is an accessory, false otherwise.
	 */
	function sv_wc_is_product_accessory() {
		
		global $product;
		
		if(has_term(get_field('accessories_cat', 'options'), 'product_cat', $product->get_id())) {
			return 'yes';
		}
		
		return false;
		
	}
	
	/**
	 * Provides an escaped version of the showroom's address.
	 * The address is processed to ensure it is safe for HTML contexts by escaping 
	 * potential harmful characters.
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @return string The HTML-safe showroom address.
	 */
	function sv_showroom_address_escaped() {
		
		$address = get_sub_field('address');
		
		return strip_tags($address);
		
	}
	
	/**
	 * Represents the sublinks for image cards in the FS FL theme.
	 * These sublinks are utilized to enhance navigation and user interaction
	 * within image card elements of the theme.
	 *
	 * @var array The list of sublink URLs or labels associated with image cards.
	 */
	function fs_fl_image_cards_sublinks() {
		
		if(!have_rows('sublinks')) {
			return;
		}
		
		ob_start();
		
		echo '<div class="sv-product-cat-tag-list">';
		
		while(have_rows('sublinks')) {
			the_row();
			echo '<a class="sv-product-cat-tag e-paragraph-base" href="'.get_sub_field('link_url').'"><span>'.get_sub_field('text').'</span></a>';
		}
		
		echo '</div>';
		
		return ob_get_clean();
		
	}
	
	/**
	 * Retrieves an ACF field value from the current object context.
	 * This function accesses the active Advanced Custom Fields (ACF) associated
	 * with the current object, providing a convenient way to fetch and use
	 * specific field data.
	 *
	 * @return mixed The value of the ACF field if available; null if not set.
	 */
	function fs_fl_get_acf_field_from_current_object($atts) {
		
		$field_name = !empty($atts['field']) ? $atts['field'] : false;
		
		if(empty($field_name)) {
			return;
		}
		
		$field_name = !str_ends_with($field_name, ':options') ? $field_name : str_replace(':options', '', $field_name);
		
		if(function_exists('is_shop') && is_shop()) {
			$object = !str_ends_with($field_name, ':options') ? get_post(wc_get_page_id('shop')) : 'options';
		} else {
			if(ElementorPro\Modules\LoopBuilder\Providers\Taxonomy_Loop_Provider::is_loop_taxonomy_strict()) {
				global $wp_query;
				$object = $wp_query->loop_term;
			} else {
				$object = !str_ends_with($field_name, ':options') ? get_queried_object() : 'options';
			}
		}
		
		return get_field($atts['field']);
		
	}
	
	/**
	 * Indicates the source type for footer CTA buttons in the FS FL theme.
	 * This value determines how the Call To Action (CTA) buttons are populated
	 * in the footer section of the theme's pages.
	 *
	 * @var string A specific identifier representing the source type for CTA buttons.
	 */
	function fs_fl_footer_cta_buttons_source() {
		
		$object = false;
		
		$return = '';
		
		if(empty(get_field('footer_cta_status')) || get_field('footer_cta_status') == 'default') {
			$return = 'options';
		} else {
			if(function_exists('is_shop') && is_shop()) {
				$return =  wc_get_page_id('shop');
			} elseif(is_singular()) {
				$return =  get_queried_object_id();
			} elseif(is_tax()) {
				$object = get_queried_object();
				$return =  $object->taxonomy.'_'.$object->term_id;
			} else {
				$return = false;
			}
		}
		
		return $return;
		
	}
	
	/**
	 * Renders a full-width image section for displaying large visuals.
	 * This function generates the necessary HTML structure to showcase a
	 * prominent image section that spans the full width of the container.
	 * It enhances the visual appeal and impact on the page.
	 *
	 * @return string The HTML markup for the full-width image section.
	 */
	function sv_full_width_image_section() {
		
		$image = get_sub_field('image');
		$image_id = substr(preg_replace('/[^a-z]+/', '', md5(time())), 0, 12);
		
		$markup = '<img src="'.$image['url'].'" alt="'.$image['alt'].'" id="'.$image_id.'">';
		
		$markup .= '<style>';
		
		if(!empty(get_sub_field('height_desktop')) || !empty(get_sub_field('height_tablet')) || !empty(get_sub_field('height_mobile'))) {
			
			if(!empty(get_sub_field('height_desktop'))) {
				$markup .= "
					@media (min-width: 992px) {
						#".$image_id." {
							height: ".get_sub_field('height_desktop')."px;
							max-width: initial;
						}
					}
				";
			} else {
				$markup .= "
					@media (min-width: 992px) {
						#".$image_id." {
							height: auto;
							width: 100%;
						}
					}
				";
			}
			
			if(!empty(get_sub_field('height_tablet'))) {
				$markup .= "
					@media (min-width: 768px) and (max-width: 991px) {
						#".$image_id." {
							height: ".get_sub_field('height_tablet')."px;
							max-width: initial;
						}
					}
				";
			} else {
				$markup .= "
					@media (min-width: 768px) and (max-width: 991px) {
						#".$image_id." {
							height: auto;
							width: 100%;
						}
					}
				";
			}
			
			if(!empty(get_sub_field('height_mobile'))) {
				$markup .= "
					@media (max-width: 767.98px) {
						#".$image_id." {
							height: ".get_sub_field('height_tablet')."px;
							max-width: initial;
						}
					}
				";
			} else {
				$markup .= "
					@media (max-width: 767.98) {
						#".$image_id." {
							height: auto;
							width: 100%;
						}
					}
				";
			}
						
		}
		
		$markup .= '</style>';
			
		return $markup;
		
	}
	
	/**
	 * Represents the URL of the shop section within the application.
	 * This variable is used to store and access the dynamic URL of the shop page,
	 * allowing for easy navigation and linking throughout the application.
	 *
	 * @var string
	 */
	function sv_shop_url() {
		
		return get_permalink(wc_get_page_id('shop'));
		
	}
	
	// Displays markup for our menu
	/**
	 * Outputs responsive markup for the mobile menu.
	 * This function generates HTML structure optimized for display on mobile
	 * devices, ensuring a seamless user experience when navigating the menu.
	 *
	 * @return string The HTML markup for the mobile menu.
	 */
	function sv_mobile_menu($atts) {
		
		if(empty($atts['menu'])) {
			return;
		}
		
		ob_start();
		wp_nav_menu([
			'menu' => $atts['menu']
		]);
		return ob_get_clean();
		
	}
	
	/**
	 * Retrieves the product description from WooCommerce and formats it.
	 * This function fetches the description of the given WooCommerce product,
	 * applies necessary formatting, and returns it as a string.
	 *
	 * @return string Formatted product description.
	 */
	function sv_wc_product_description() {
		
		global $product;
		
		if(!$product instanceof WC_Product) {
			return '';
		}
		
		return $product->get_description();
	}
	
	/**
	 * Checks if a WooCommerce product has additional information.
	 * This function determines whether the specified product includes extra
	 * details beyond the basic description, aiding in enriching product displays.
	 *
	 * @return bool True if the product has additional information, false otherwise.
	 */
	function sv_wc_product_has_additional_info() {
		
		global $product;
		
		if(!$product instanceof WC_Product) {
			return '';
		}
		
		ob_start();
		
		wc_display_product_attributes($product);
		
		$content = ob_get_clean();
		
		return !empty($content);
		
	}
	
	/**
	 * Retrieves a set of related post IDs based on specified criteria.
	 * This function analyzes the given post to find posts with similar tags
	 * or categories, enhancing content discovery on the site.
	 *
	 * @param int $post_id The ID of the post for which related IDs are sought.
	 * @param int $limit The maximum number of related post IDs to return.
	 *
	 * @return array An array of related post IDs, or an empty array if none are found.
	 */
	function sv_get_related_post_ids($limit = 4) {
		
		$post_id = get_the_ID();
		$categories = wp_get_post_categories($post_id, ['fields' => 'ids']);
		$tags = wp_get_post_tags($post_id, ['fields' => 'ids']);
		
		if(empty($categories) && empty($tags)) {
			return [];
		}
		
		$query = new WP_Query([
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => $limit,
			'post__not_in'        => [$post_id],
			'orderby'             => 'relevance',
			'tax_query'           => [
				'relation' => 'OR',
				[
					'taxonomy' => 'category',
					'field'    => 'term_id',
					'terms'    => $categories,
				],
				[
					'taxonomy' => 'post_tag',
					'field'    => 'term_id',
					'terms'    => $tags,
				],
			],
			'no_found_rows'       => true,
			'ignore_sticky_posts' => true,
		]);
		
		return $query->posts ? wp_list_pluck($query->posts, 'ID') : [];
	}
	
	/**
	 * Determines if a resource has related articles.
	 * This function analyzes the specified resource to check for any related articles
	 * based on predefined criteria, supporting content connectivity within the site.
	 *
	 * @param int $resource_id The ID of the resource to assess for related articles.
	 *
	 * @return bool True if related articles exist, false otherwise.
	 */
	function sv_resource_has_related_resources() {
		
		return !empty(sv_get_related_post_ids()) ? 'yes' : false;
		
	}