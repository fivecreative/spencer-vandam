<?php
	
	/**
	 * Elementor functionality for the theme
	 */
	
	add_filter('elementor/loop_taxonomy/args', 'fs_icon_loop_taxonomy_args', 10, 3);
	add_filter('elementor/loop_taxonomy/args', 'fs_multi_grid_featured_card_loop_taxonomy_args', 10, 3);
	add_filter('elementor/loop_taxonomy/args', 'fs_sv_shop_page_taxonomy_query', 10, 3);
	add_filter('elementor/loop_taxonomy/args', 'sv_wc_category_subcategories_loop', 10, 3);
	add_action('elementor/query/fs_fl_project_feed_query', 'fs_fl_project_feed_query'); // Project feed query
	add_action('elementor/query/fs_fl_product_feed_query', 'fs_fl_product_feed_query'); // Project feed query
	add_action('elementor/query/fs_fl_faq_loop_accordion_query', 'fs_fl_faq_loop_accordion_query'); // Feed filter for faqs
	add_action('elementor/query/sv_wc_get_recommended_accessories', 'sv_wc_get_recommended_accessories'); // Gets the recommended accessories
	add_action('elementor/query/sv_fl_featured_project_query', 'sv_fl_featured_project_query'); // Featured Project query
	add_action('elementor/query/sv_wc_mentioned_product', 'sv_wc_mentioned_product'); // Mentioned products loop on single resources
	add_action('elementor/query/sv_post_archive_feed', 'sv_post_archive_feed');
	add_action('elementor/query/sv_related_resources', 'sv_related_resources'); // Gets related articles for a resource single
	add_action('pre_get_posts', 'sv_search_search_for_products'); // Ensures we always search products
	
	add_filter('erdc/flexible_layout/wrapper_classes', 'fs_fl_flexible_layout_widget_wrapper_classes', 10, 2); // Adds classes to our flexible layout wrapper
	add_filter('erdc/flexible_layout/wrapper_id', 'fs_fl_flexible_layout_widget_wrapper_id', 10, 2); // Adds classes to our flexible layout wrapper
	
	
	/**
	 * Generates a list of CSS classes for a flexible layout wrapper based on ACF subfields and structure.
	 *
	 * The generated classes include base classes, vertical padding classes, mobile-specific padding
	 * classes, and grid type classes, depending on the values of associated ACF subfields.
	 *
	 * @return string A space-separated string of CSS classes for the flexible layout wrapper.
	 */
	function fs_fl_flexible_layout_widget_wrapper_classes($classes, $widget) {
		
		if(!is_array($classes)) {
			$classes = [$classes];
		}
		
		// base classes
		$classes = array_merge($classes, [
			'fs-fl-bg-'.get_sub_field('section_bg'),
			'fs-fl-type-'.get_row_layout(),
			'fs-fl-item'
		]);
		
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
		
		// IF we have a layout columns alignment
		if(get_sub_field('columns_alignment')) {
			$classes[] = 'fs-fl-loop-grid-columns-align-'.get_sub_field('columns_alignment');
		}
		
		return implode(' ', $classes);
		
	}
	
	/**
	 * sv_wc_category_subcategories_loop function
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @param $args
	 * @param $settings
	 * @param $display_settings
	 *
	 * @return mixed
	 */
	function sv_wc_category_subcategories_loop($args, $settings, $display_settings) {
		
		if(empty($args['term_taxonomy_id']) || $args['term_taxonomy_id'] != 'sv_wc_category_subcategories_loop') {
			return $args;
		}
		
		// Gets child terms
		$term_query = new WP_Term_Query([
			'taxonomy' => 'product_cat',
			'hide_empty' => $args['hide_empty'],
			'child_of' => get_queried_object_id(),
		]);
		
		$terms = $term_query->get_terms();
		
		if(empty($terms)) {
			$terms = [0];
		} else {
			$terms = array_map(function($term) {
				return $term->term_id;
			}, $terms);
		}
		
		$args['include'] = $terms;
		$args['taxonomy'] = 'product_cat';
		
		// Same order as selected in field
		$args['orderby'] = 'include';
		$args['order'] = 'ASC';
		
		unset($args['term_taxonomy_id']);
		
		return $args;
		
	}
	
	/**
	 * fs_sv_shop_page_taxonomy_query function
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @param $args
	 * @param $settings
	 * @param $display_settings
	 *
	 * @return mixed
	 */
	function fs_sv_shop_page_taxonomy_query($args, $settings, $display_settings) {
		
		if(empty($args['term_taxonomy_id']) || $args['term_taxonomy_id'] != 'sv_shop_page_taxonomy_query') {
			return $args;
		}
		
		// Gets parent terms
		$term_query = new WP_Term_Query([
			'taxonomy' => 'product_cat',
			'hide_empty' => $args['hide_empty'],
			'parent' => 0,
		]);
		
		$terms = $term_query->get_terms();
		
		if(empty($terms)) {
			$terms = [0];
		} else {
			$terms = array_map(function($term) {
				return $term->term_id;
			}, $terms);
		}
		
		$args['include'] = $terms;
		$args['taxonomy'] = 'product_cat';
		
		// Same order as selected in field
		$args['orderby'] = 'include';
		$args['order'] = 'ASC';
		
		unset($args['term_taxonomy_id']);
		
		return $args;
		
	}
	
	/**
	 * Retrieves the section container ID from a flexible layout field if it is set.
	 *
	 * @return string|null The section container ID value if available, or null otherwise.
	 */
	function fs_fl_flexible_layout_widget_wrapper_id($id = '', $widget) {
		if(get_sub_field('section_container_id')) {
			return get_sub_field('section_container_id');
		}
		
		return $id;
	}
	
	function fs_icon_loop_taxonomy_args($args, $settings, $display_settings) {
		
		// Ensures we are in the right queries
		if(empty($args['term_taxonomy_id']) ||
			(
				$args['term_taxonomy_id'] != 'fs_icon_loop_tax_query'
				&& $args['term_taxonomy_id'] != 'fs_card_loop_tax_query'
				&& $args['term_taxonomy_id'] != 'fs_multi_card_loop_tax_query'
			)
		) {
			return $args;
		}
		
		// Gets the taxonomy and terms from our ACF fields
		$taxonomy = $args['term_taxonomy_id'] == 'fs_icon_loop_tax_query'  ? get_sub_field('icon_taxonomy') : get_sub_field('taxonomy');
		$terms = $args['term_taxonomy_id'] == 'fs_icon_loop_tax_query'  ? get_sub_field('icon_terms') : get_sub_field('terms');
		
		if(empty($taxonomy) || empty($terms)) {
			$args['include'] = [];
			return $args;
		}
		
		// Ensures our terms exist
		$_terms = [];
		
		foreach($terms as $term_id) {
			$term = get_term_by('id', $term_id, $taxonomy);
			if($term) {
				$_terms[] = $term->term_id;
			}
		}
		
		// Sets the terms to include
		$args['include'] = $_terms;
		$args['taxonomy'] = $taxonomy;
		
		// Same order as selected in field
		$args['orderby'] = 'include';
		$args['order'] = 'ASC';
		
		unset($args['term_taxonomy_id']);
		
		return $args;
		
	}
	
	function fs_multi_grid_featured_card_loop_taxonomy_args($args, $settings, $display_settings) {
		
		//fs_multi_card_feateured_loop_tax_query
		// Ensures we are in the right queries
		if(empty($args['term_taxonomy_id']) || $args['term_taxonomy_id'] != 'fs_multi_card_featured_loop_tax_query') {
			return $args;
		}
		
		$taxonomy = get_sub_field('taxonomy');
		$terms = get_sub_field('featured_term');
		
		if(!is_array($terms)) {
			$terms = [$terms];
		}
		
		// Sets the terms to include
		$args['include'] = $terms;
		$args['taxonomy'] = $taxonomy;
		
		// Same order as selected in field
		$args['orderby'] = 'include';
		$args['order'] = 'ASC';
		
		unset($args['term_taxonomy_id']);
		
		return $args;
		
	}
	
	
	
	/**
	 * Returns the query arguments for the project feed.
	 * This function constructs and returns an array of query arguments
	 * based on specific conditions, including the selected project
	 * taxonomy and specified order for sorting.
	 *
	 * @return array The array of query arguments for retrieving the project feed.
	 */
	function fs_fl_project_feed_query($q) {
		
		// Project
		$q->set('post_type', 'project');
		
		// Manual selection
		if(get_sub_field('source') == 'manual') {
			$project_ids = get_sub_field('projects');
			$q->set('post__in', $project_ids);
			$q->set('orderby', 'post__in');
			$q->set('order', 'ASC');
		} else if(get_sub_field('source') == 'latest') {
			$q->set('orderby', 'date');
			$q->set('order', 'DESC');
			$q->set('posts_per_page', 4);
			$q->set('post__in', null);
		} else {
			$q->set('orderby', 'rand');
			$q->set('order', 'DESC');
			$q->set('post__in', null);
			$q->set('posts_per_page', 4);
		}
		
	}
	
	/**
	 * Constructs and returns the query arguments for the product feed.
	 * The function sets the post type to 'product' and configures query
	 * parameters based on defined conditions for ordering and inclusion.
	 *
	 * @return array The array of query arguments for retrieving the product feed.
	 */
	function fs_fl_product_feed_query($q) {
		
		// Manual selection
		if(get_sub_field('source') == 'manual') {
			
			$product_ids = get_sub_field('product_ids');
			$q->set('post__in', $product_ids);
			$q->set('orderby', 'post__in');
			$q->set('order', 'ASC');
			
		} else if(get_sub_field('source') == 'latest') {
			
			$q->set('orderby', 'date');
			$q->set('order', 'DESC');
			$q->set('posts_per_page', 4);
			$q->set('post__in', null);
			
		} else if(get_sub_field('source') == 'acf') {
			
			$product_ids = get_field(get_sub_field('acf_field_name'));
			
			if(empty($product_ids)) {
				$q->set('post__in', [0]);
				return;
			}
			
			$q->set('post__in', $product_ids);
			$q->set('orderby', 'post__in');
			$q->set('order', 'ASC');
			
		} else {
			
			global $wp_query;
			$q = $wp_query;
			
		}
		
		$q->set('post_type', 'product');
		
	}
	
	/**
	 * fs_fl_faq_loop_accordion_query function
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @param $q
	 */
	function fs_fl_faq_loop_accordion_query($q) {
		
		// Sets post type
		$q->set('post_type', 'faq');
		
		// Tag query
		$tax_query = [];
		
		// Removes action to avoid infinite loops
		remove_action('elementor/query/fs_fl_faq_loop_accordion_query', 'fs_fl_faq_loop_accordion_query');
		
		// Query
		$query = new WP_Query([
			'post_type' => 'faq',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'fields' => 'ids',
			'tax_query' => [
				[
					'taxonomy' => 'faq-tag',
					'terms' => get_sub_field('tags'),
					'compare' => 'IN',
				]
			],
		]);
		
		add_action('elementor/query/fs_fl_faq_loop_accordion_query', 'fs_fl_faq_loop_accordion_query');
		
		// Nothing to show
		if(empty($query->posts)) {
			$q->set('post__in', [0]);
			return;
		}
		
		$q->set('post__in', $query->posts);
		$q->set('orderby', 'post__in');
		$q->set('order', 'ASC');
		
	}
	
	/**
	 * sv_wc_get_recommended_accessories_ids function
	 *
	 * @version 1.0.0
	 * @since   1.0.0
	 *
	 * @param $product
	 * @param $max
	 *
	 * @return array|int[]|mixed|WP_Post[]|null
	 */
	function sv_wc_get_recommended_accessories_ids($product, $max = 4) {
		
		// Gets cross sells
		$cross_sells = $product->get_cross_sell_ids();
		
		// If less than 4, populate the remaining from the accessories category
		if(count($cross_sells) < $max) {
			
			$count = $max - count($cross_sells);
			
			$q = new WP_Query([
				'post_type' => 'product',
				'posts_per_page' => $count,
				'fields' => 'ids',
				'post_status' => 'publish',
				'orderby' => 'rand',
				'tax_query' => [
					[
						'taxonomy' => 'product_cat',
						'field' => 'term_id',
						'terms' => [get_field('accessories_cat', 'options')],
					]
				],
			]);
			
			$cross_sells = array_merge($cross_sells, $q->posts);
			
		}
		
		return $cross_sells;
		
	}
	
	/**
	 * Retrieves recommended accessory products for a given product.
	 * This function fetches the cross-sell items for the specified product and fills
	 * in any remaining slots up to $max by querying products from the 'accessories'
	 * category.
	 *
	 * @param WP_Product $product The product to retrieve accessories for.
	 * @param int $max The maximum number of accessory products to retrieve.
	 *
	 * @return array|WP_Post[] A list of product IDs for recommended accessories.
	 */
	function sv_wc_get_recommended_accessories($q) {
		
		// Removes action to avoid infinite loops
		remove_action('elementor/query/sv_wc_get_recommended_accessories', 'sv_wc_get_recommended_accessories');
		
		global $product;
		
		if(!$product) {
			$post_id = get_the_ID();
			if('product' == get_post_type(get_the_ID())) {
				$product = wc_get_product(get_the_ID());
			} else {
				return;
			}
		}
		
		// Gets cross sells
		$cross_sells = sv_wc_get_recommended_accessories_ids($product);
		
		// Adds action again
		add_action('elementor/query/sv_wc_get_recommended_accessories', 'sv_wc_get_recommended_accessories');
		
		// Update query
		$q->set('post_type', 'product');
		$q->set('post__in', $cross_sells);
		$q->set('orderby', 'post__in');
		$q->set('order', 'ASC');
		$q->set('posts_per_page', 4);
		
	}
	
	/**
	 * The `sv_fl_featured_project_query` function customizes a query for featured projects.
	 * This function is likely used to modify query parameters to display or retrieve
	 * specific featured project posts, ensuring only relevant posts are processed
	 * and returned in the desired order.
	 */
	function sv_fl_featured_project_query($q) {
		
		//  Featured project id
		if(empty(get_sub_field('featured_project'))) {
			$q->set('post__in', [0]);
		}
		
		$q->set('post__in', [get_sub_field('featured_project')]);
		
	}
	
	/**
	 * Returns the ID of the mentioned product within the current context.
	 * It retrieves the product ID from the current WordPress context, checking
	 * if the current post type is a product. This is useful in scenarios
	 * where dynamic product identification within posts is needed.
	 *
	 * @return int|null The ID of the mentioned product, or null if none is identified.
	 */
	function sv_wc_mentioned_product($q) {
		
		if(!is_singular() || 'post' != get_post_type() || is_admin()) {
			return;
		}
		
		//  Featured project id
		if(empty(get_field('related_products'))) {
			return;
		}
		
		$q->set('post__in', get_field('related_products'));
	}
	
	/**
	 * sv_post_archive_feed function
	 *
	 * This function customizes the query used for displaying post archive feeds
	 * by setting necessary post types and ordering rules. It ensures that posts
	 * are displayed in a specific format suited for the archive page or feed.
	 *
	 * @param WP_Query $q The WP_Query instance being modified for the post archive feed.
	 */
	function sv_post_archive_feed($q) {
		
		if(is_category()) {
			$q->set('cat', get_queried_object_id());
		} elseif(is_tag()) {
			$q->set('tag_id', get_queried_object_id());
		}
		
	}
	
	/**
	 * Handles search queries for products within a custom context.
	 *
	 * This function adjusts the query to target product-related searches,
	 * enabling retrieval of products based on specific criteria.
	 *
	 * @param WP_Query $q The query object being modified.
	 */
	function sv_search_search_for_products($q) {
		
		if(!is_admin() && !empty($_GET['s']) && $q->is_main_query() && $q->is_search()) {
			
			$q->set('post_type', 'product');
			
		}
		
	}
	
	
	
	/**
	 * Represents related resources associated with the current context.
	 * This element likely holds IDs or references to additional resources that
	 * are relevant or linked to the primary subject, providing supplementary
	 * information or context.
	 */
	function sv_related_resources($q) {
		
		// Remove action to avoid infinite loops
		remove_action('elementor/query/sv_related_resources', 'sv_related_resources');
		
		// Gets related posts
		$post_ids = sv_get_related_post_ids();
		
		add_action('elementor/query/sv_related_resources', 'sv_related_resources');
		
		if(empty($post_ids)) {
			$q->set('post__in', [0]);
			return;
		}
		
		$q->set('post__in', $post_ids);
		$q->set('orderby', 'post__in');
		$q->set('order', 'ASC');
		
	}