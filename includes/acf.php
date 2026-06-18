<?php
	
	/**
	 * ACF functionality for the theme
	 */
	
	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly.
	}
	
	add_filter('acf/load_field/key=field_6a0cf10728a51', 'fs_acf_populate_taxonomy_choices'); // Populates taxonomy choices in flexible layouts
	add_filter('acf/load_field/key=field_6a0d0d929cd49', 'fs_acf_populate_taxonomy_choices'); // Populates taxonomy choices in flexible layouts
	add_filter('acf/load_field/key=field_6a0d41704d1f6', 'fs_acf_populate_taxonomy_choices'); // Populates taxonomy choices in flexible layouts
	add_filter('acf/prepare_field/key=field_6a0cf02bfb42a', 'fs_acf_populate_term_choices'); // P{opulates term choices in flexible layouts
	add_filter('acf/prepare_field/key=field_6a0d0dcd9cd4a', 'fs_acf_populate_term_choices'); // P{opulates term choices in flexible layouts
	add_filter('acf/prepare_field/key=field_6a0d41da4d1f9', 'fs_acf_populate_term_choices'); // P{opulates term choices in flexible layouts
	add_filter('acf/prepare_field/key=field_6a0d41704d1f7', 'fs_acf_populate_term_choices'); // P{opulates term choices in flexible layouts
	add_action('wp_ajax_acf_icon_terms_choices', 'fs_acf_ajax_get_term_choices'); // Does the AJAX query to populate select fields automatically
	add_action('acf/init', 'sv_downloads_data_tab_location'); // adds location for the downloads data tab in ACF
	add_action('admin_head', 'sv_extend_edit_category_width'); // Adds CSS so the category edit page is a bit wider
	
	
	
	// Adds default fields to our flexible content fields
	add_filter('acf/load_field/key=field_6a0a99f262aaf', function($field) {
		
		if(!function_exists('get_current_screen')) {
		
		} else {
			$screen = get_current_screen();
			
			if(!is_admin() || ($screen && !empty($screen->id) && $screen->id == 'acf-field-group')) {
				return $field;
			}
		}
		
		$counter = 1000000;
		
		// Adds the default fields to each layout
		foreach($field['layouts'] as $parent_index => &$layout) {
			
			$layout['sub_fields'] = array_merge([
				[
					'ID' => $counter++,
					'key' => 'field_692e45b73e77a',
					'label' => 'Section Content',
					'name' => '',
					'aria-label' => '',
					'prefix' => 'acf',
					'type' => 'tab',
					'value' => false,
					'menu_order' => 0,
					'instructions' => '',
					'required' => 0,
					'id' => '',
					'class' => '',
					'conditional_logic' => 0,
					'parent' => $field['ID'],
					'wrapper' =>
						array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
					'parent_layout' => $parent_index,
					'placement' => 'top',
					'endpoint' => 0,
					'selected' => 0,
					'_name' => 'section_content',
					'_valid' => 1,
				]
			], $layout['sub_fields'], [
				[
					'ID' => $counter++,
					'key' => 'field_692e45ab3e779',
					'label' => 'Other Settings',
					'name' => '',
					'aria-label' => '',
					'prefix' => 'acf',
					'type' => 'tab',
					'value' => false,
					'menu_order' => 7,
					'instructions' => '',
					'required' => 0,
					'id' => '',
					'class' => '',
					'conditional_logic' => 0,
					'parent' => $field['ID'],
					'wrapper' =>
						array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
					'parent_layout' => $parent_index,
					'placement' => 'top',
					'endpoint' => 0,
					'selected' => 0,
					'_name' => 'section_settings',
					'_valid' => 1,
				],
				[
					'ID' => $counter++,
					'key' => 'field_692e45cb3e77b',
					'label' => 'Section BG Colour',
					'name' => 'section_bg',
					'aria-label' => '',
					'prefix' => 'acf',
					'type' => 'button_group',
					'value' => NULL,
					'menu_order' => 8,
					'instructions' => '',
					'required' => 0,
					'id' => '',
					'class' => '',
					'conditional_logic' => 0,
					'parent' => $field['ID'],
					'wrapper' =>
						array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
					'choices' => array (
						'default' => 'Default (transparent)',
						'white' => 'White',
						'light' => 'Light',
						'primary' => 'Primary',
						'dark' => 'Dark',
					),
					'parent_layout' => $parent_index,
					'default_value' => 'default',
					'enable_opacity' => 0,
					'return_format' => 'string',
					'allow_in_bindings' => 0,
					'show_custom_palette' => 0,
					'show_color_wheel' => 1,
					'multiple' => 0,
					'ui' => 0,
					'allow_null' => 0,
					'ajax' => 0,
					'custom_palette_source' => '',
					'palette_colors' => '',
					'_name' => 'section_bg',
					'_valid' => 1,
				],
				[
					'ID' => $counter++,
					'key' => 'field_692e45cb3e78b',
					'label' => 'Section ID',
					'name' => 'section_container_id',
					'aria-label' => '',
					'prefix' => 'acf',
					'type' => 'text',
					'value' => NULL,
					'menu_order' => 8,
					'instructions' => '',
					'required' => 0,
					'id' => '',
					'append' => '',
					'prepend' => '',
					'class' => '',
					'conditional_logic' => 0,
					'parent' => $field['ID'],
					'wrapper' =>
						array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
					'parent_layout' => $parent_index,
					'default_value' => '',
					'allow_in_bindings' => 0,
					'ui' => 0,
					'ajax' => 0,
					'multiple' => 0,
					'_name' => 'section_container_id',
					'_valid' => 1,
				],
				[
					'ID' => $counter++,
					'key' => 'field_692e45f13e77c',
					'label' => 'Vertical Padding',
					'name' => 'vertical_padding',
					'aria-label' => '',
					'prefix' => 'acf',
					'type' => 'select',
					'value' => NULL,
					'menu_order' => 9,
					'instructions' => '',
					'required' => 0,
					'id' => '',
					'class' => '',
					'conditional_logic' => 0,
					'parent' => $field['ID'],
					'wrapper' =>
						array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
					'parent_layout' => $parent_index,
					'choices' =>
						array (
							'default' => 'Default',
							'sm' => 'Small',
							'lg' => 'Large',
							'bottom' => 'Bottom Padding Only',
							'top' => 'Top Padding Only',
							'top-sm' => 'Small Top Padding, Default Bottom Padding',
							'bottom-sm' => 'Small Bottom Padding, Default Top Padding',
							'none'  => 'No Padding'
						),
					'default_value' => 'default',
					'return_format' => 'value',
					'multiple' => 0,
					'allow_null' => 0,
					'allow_in_bindings' => 0,
					'ui' => 0,
					'ajax' => 0,
					'placeholder' => '',
					'create_options' => 0,
					'save_options' => 0,
					'_name' => 'vertical_padding',
					'_valid' => 1,
				],
				[
					'ID' => $counter++,
					'key' => 'field_692e45f13e77d',
					'label' => 'Vertical Padding (Mobile)',
					'name' => 'vertical_padding_mobile',
					'aria-label' => '',
					'prefix' => 'acf',
					'type' => 'select',
					'value' => NULL,
					'menu_order' => 9,
					'instructions' => '',
					'required' => 0,
					'id' => '',
					'class' => '',
					'conditional_logic' => 0,
					'parent' => $field['ID'],
					'wrapper' =>
						array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
					'parent_layout' => $parent_index,
					'choices' =>
						array (
							'default' => 'Default',
							'sm' => 'Small',
							'lg' => 'Large',
							'bottom' => 'Bottom Padding Only',
							'top' => 'Top Padding Only',
							'top-sm' => 'Small Top Padding, Default Bottom Padding',
							'bottom-sm' => 'Small Bottom Padding, Default Top Padding',
							'none'  => 'No Padding'
						),
					'default_value' => 'default',
					'return_format' => 'value',
					'multiple' => 0,
					'allow_null' => 0,
					'allow_in_bindings' => 0,
					'ui' => 0,
					'ajax' => 0,
					'placeholder' => '',
					'create_options' => 0,
					'save_options' => 0,
					'_name' => 'vertical_padding_mobile',
					'_valid' => 1,
				]
			]);
			
		}
		
		return $field;

	}, 20, 1);
		
	/**
	* Populates the choices for an ACF field with available taxonomies.
	*
	* This function retrieves all public taxonomies, formats them as choices
	* with their names as keys and labels as values, and assigns them to the
	* 'choices' attribute of the provided ACF field.
	*
	* @param array $field The ACF field array being filtered.
	*                     It contains the field's settings and attributes.
	*
	* @return array The modified ACF field array with populated choices.
	*/
	function fs_acf_populate_taxonomy_choices($field) {
		
		// Nto on field group edit
		if (function_exists('get_current_screen')) {
			$screen = get_current_screen();
			if ($screen && $screen->id === 'acf-field-group') return $field;
		}
		
		// Gets taxonomies
		$taxonomies = get_taxonomies(['public' => true], 'objects');
		$choices = [];
		foreach ($taxonomies as $tax) {
			$choices[$tax->name] = $tax->label;
		}
		
		// Sets choices
		$field['choices'] = $choices;
		
		// Return field
		return $field;
	}
	
	function fs_acf_populate_term_choices($field) {
		
		// Not on Edit field group
		if(function_exists('get_current_screen')) {
			$screen = get_current_screen();
			if ($screen && $screen->id === 'acf-field-group') return $field;
		}
		
		if($field['field_type'] == 'multi_select' || $field['field_type'] == 'checkbox') {
			$field['multiple'] = 1;
		}
		
		// ENsures select field - not taxonomy
		$field['type']           = 'select';
		$field['ui']             = 1;
		$field['ajax']           = 0;
		$field['allow_null']     = 0;
		$field['placeholder']    = '';
		$field['create_options'] = 0;
		$field['save_options']   = 0;
		$field['choices']        = [];
		
		foreach ((array) ($field['value'] ?? []) as $term_id) {
			$term = get_term(intval($term_id));
			if ($term && !is_wp_error($term)) {
				$field['choices'][$term->term_id] = $term->name;
			}
		}
		
		// Returns field
		return $field;
		
	}
	
	function fs_acf_ajax_get_term_choices() {
		
		check_ajax_referer('acf_icon_terms', 'nonce');
		
		$taxonomy = sanitize_text_field($_POST['taxonomy'] ?? '');
		
		if (!taxonomy_exists($taxonomy)) {
			wp_send_json_error('Invalid taxonomy');
			return;
		}
		
		$terms = fs_get_taxonomy_hierarchy($taxonomy);
		
		$_choices = [];
		$level = 0;
		foreach($terms as $term) {
			$_choices = array_merge($_choices, fs_get_taxonomy_hierarchy_choices($term, $level));
		}
		
		$choices = [];
		
		if(!empty($_choices)) {
			foreach($_choices as $choice) {
				foreach($choice as $term_id => $name) {
					$choices[] = [
						'label' => $name,
						'value' => $term_id,
					];
				}
			}
		}
		
		wp_send_json_success($choices);
		
	}
	
	function fs_get_taxonomy_hierarchy_choices($term, $level = 0) {
		
		$prefix = '';
		
		for($i = 0; $i < $level; $i++) {
			$prefix .= '– ';
		}
		
		$term->name = $prefix.$term->name;
		
		$return = [[(string)$term->term_id => $term->name]];
		
		if(!empty($term->children)) {
			foreach($term->children as $child) {
				$return = array_merge($return, fs_get_taxonomy_hierarchy_choices($child, $level + 1));
			}
		}
		
		return $return;
		
	}
	
	/**
	* Retrieves a hierarchy of terms for a given taxonomy.
	* The function organizes terms in a hierarchical structure based on their
	* parent-child relationships. It is typically used when a visual representation
	* of term relationships within a taxonomy is needed.
	*
	* @param string $taxonomy The taxonomy slug to retrieve terms from.
	*
	* @return array Returns a nested array of term objects, each with possible
	*               child terms, reflecting the hierarchical structure.
	*
	* @throws Exception Throws an exception if the taxonomy is invalid or terms
	*                   cannot be retrieved.
	*/
	function fs_get_taxonomy_hierarchy($taxonomy, $parent = 0 ) {
		
		// only 1 taxonomy
		$taxonomy = is_array( $taxonomy ) ? array_shift( $taxonomy ) : $taxonomy;
		
		// get all direct decendants of the $parent
		$terms = get_terms( $taxonomy, array( 'parent' => $parent, 'hide_empty' => false, 'orderby' => 'name', 'order' => 'ASC', ) );
		
		// prepare a new array.  these are the children of $parent
		// we'll ultimately copy all the $terms into this new array, but only after they
		// find their own children
		$children = array();
		
		// go through all the direct decendants of $parent, and gather their children
		foreach ( $terms as $term ){
			// recurse to get the direct decendants of "this" term
			$term->children = fs_get_taxonomy_hierarchy( $taxonomy, $term->term_id );
			
			// add the term to our new array
			$children[ $term->term_id ] = $term;
		}
		
		// send the results back to the caller
		return $children;
	}
	
	
	add_action('acf/input/admin_enqueue_scripts', function() {
		$dir  = get_stylesheet_directory();
		$uri  = get_stylesheet_directory_uri();
		$file = '/js/acf-icon-taxonomy.js';
	
		wp_enqueue_script(
			'acf-icon-taxonomy',
			$uri . $file,
			['jquery', 'acf-input'],
			file_exists($dir . $file) ? filemtime($dir . $file) : '1.0.0',
			true
		);
	
		wp_localize_script('acf-icon-taxonomy', 'acfIconTaxonomy', [
			'ajaxurl'  => admin_url('admin-ajax.php'),
			'nonce'    => wp_create_nonce('acf_icon_terms'),
			'taxKeys'   => ['field_6a0cf10728a51', 'field_6a0d0d929cd49', 'field_6a0d41704d1f6'],
			'termsKeys' => ['field_6a0cf02bfb42a', 'field_6a0d0dcd9cd4a', ['field_6a0d41704d1f7', 'field_6a0d41da4d1f9']],
		]);
	});
	
	/**
	* Represents the configuration or location identifier for download data tabs.
	* This value is used to specify or retrieve the location of data tabs related
	* to downloads, typically for display or management purposes within a system.
	*
	* @var string
	*/
	function sv_downloads_data_tab_location() {
		
		// Guard: ACF_Location base class requires ACF 5.9+
		if(!class_exists('ACF_Location')) {
			return;
		}
		
		class ACF_Location_WC_Product_Tab extends ACF_Location {
			
			public function initialize() {
				$this->name        = 'wc_product_tab';
				$this->label       = __('Product Data Tab', 'your-textdomain');
				$this->category    = 'post';
				$this->object_type = 'post';
			}
			
			/**
			* Values shown in the ACF location rule dropdown.
			* Add additional WC product tabs here if needed.
			*/
			public function get_values($rule) {
				return ['downloads' => __('Downloads', 'your-textdomain')];
			}
			
			/**
			* Determines whether this field group should be loaded.
			* Called when we pass a custom $screen context to acf_get_field_groups().
			*/
			public function match($rule, $screen, $field_group) {
				if(!isset($screen['wc_product_tab'])) {
					return false;
				}
				$match = ($screen['wc_product_tab'] === $rule['value']);
				return ($rule['operator'] === '==') ? $match : !$match;
			}
		}
		
		acf_register_location_type('ACF_Location_WC_Product_Tab');
		
	}
	
	function sv_extend_edit_category_width() {
		echo '<style>#edittag { widt: 100%; max-width: 1440px !important; }</style>';
	}