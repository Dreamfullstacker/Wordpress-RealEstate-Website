<?php
/**
 * This file contains functions related to Real Estate Search
 */

if ( ! function_exists( 'inspiry_is_search_page_map_visible' ) ) :
	/**
	 * Check if search page map is set to show or hide
	 */
	function inspiry_is_search_page_map_visible() {
		if ( 'with_map' === get_option( 'inspiry_search_results_layout', 'with_map' ) ) {
			return true;
		}

		return false;
	}
endif;


if ( ! function_exists( 'inspiry_get_search_page_url' ) ) :
	/**
	 * Get search page URL
	 */
	function inspiry_get_search_page_url() {
		/* Check search page*/
		$inspiry_search_page = get_option( 'inspiry_search_page' );
		if ( ! empty( $inspiry_search_page ) ) {

			/* WPML filter to get translated page id if translation exists otherwise default id */
			$inspiry_search_page = apply_filters( 'wpml_object_id', $inspiry_search_page, 'page', true );

			return get_permalink( $inspiry_search_page );
		}

		/* Check search url which is deprecated and this code is to provide backward compatibility */
		$theme_search_url = get_option( 'theme_search_url' );
		if ( ! empty( $theme_search_url ) ) {
			return $theme_search_url;
		}

		/* Return false if all fails */

		return false;
	}
endif;


if ( ! function_exists( 'inspiry_is_search_fields_configured' ) ) :
	/**
	 * Checks if search fields are configured or not
	 *
	 * @return bool
	 */
	function inspiry_is_search_fields_configured() {
		$theme_search_fields = get_option( 'theme_search_fields' );
		if ( ! empty( $theme_search_fields ) && is_array( $theme_search_fields ) ) {
			return true;
		}

		return false;
	}
endif;


if ( ! function_exists( 'inspiry_is_search_page_configured' ) ) :
	/**
	 * Check if search page settings are configured
	 */
	function inspiry_is_search_page_configured() {

		/* Check search page */
		$inspiry_search_page = get_option( 'inspiry_search_page' );
		if ( ! empty( $inspiry_search_page ) ) {
			return true;
		}

		/* Check search url which is deprecated and this code is to provide backward compatibility */
		$theme_search_url = get_option( 'theme_search_url' );
		if ( ! empty( $theme_search_url ) ) {
			return true;
		}

		/* Return false if all fails */

		return false;
	}
endif;


if ( ! function_exists( 'inspiry_show_search_form_widget' ) ) :
	/**
	 * Checks if search form can be displayed in the sidebar.
	 *
	 * @return bool
	 */
	function inspiry_show_search_form_widget() {
		$inspiry_show_search_in_header = (int) get_option( 'inspiry_show_search_in_header', 1 );
		if ( $inspiry_show_search_in_header ) {
			return false;
		}

		return true;
	}
endif;


if ( ! function_exists( 'inspiry_show_header_search_form' ) ) :
	/**
	 * Checks if search form can be displayed in the sidebar.
	 *
	 * @return bool
	 */
	function inspiry_show_header_search_form() {
		$inspiry_show_search_in_header = (int) get_option( 'inspiry_show_search_in_header', 1 );
		if ( $inspiry_show_search_in_header ) {
			return true;
		}

		return false;
	}
endif;


if ( ! function_exists( 'inspiry_get_search_fields' ) ) :
	/**
	 * Get search fields array
	 */
	function inspiry_get_search_fields() {
		$theme_search_fields = get_option( 'theme_search_fields' );
		if ( ! empty( $theme_search_fields ) && is_array( $theme_search_fields ) ) {
			return $theme_search_fields;
		}

		return false;
	}
endif;

if ( ! function_exists( 'inspiry_smart_placeholder' ) ) {
	function inspiry_smart_placeholder( $label_key, $default ) {

		$label = get_option( $label_key );

		if ( ! empty( $label ) ) {
			return $label;
		} else {
			return $default;
		}
	}
}

if ( ! function_exists( 'inspiry_any_value' ) ) :
	/**
	 * Return
	 * @return string|void
	 */
	function inspiry_any_value() {
		return 'any';   // NOTE: do not translate this as it has back-end use only, and it never appears on front-end.
	}
endif;


if ( ! function_exists( 'inspiry_hide_empty_locations' ) ) :
	/**
	 * Returns true if setting is configured to hide empty locations and returns false otherwise
	 *
	 * @return bool
	 */
	function inspiry_hide_empty_locations(): bool {
		if ( ( 'true' == get_option( 'inspiry_hide_empty_locations', 'true' ) )
		     && ( ! is_page_template( array( 'templates/submit-property.php', 'templates/dashboard.php' ) ) ) ) {
			return true;
		}

		return false;
	}
endif;


if ( ! function_exists( 'realhomes_locations_placeholders' ) ) {
	/**
	 * Returns an array for locations placeholders.
	 *
	 * @return array
	 */
	function realhomes_locations_placeholders(): array {
		$locations_placeholders = array();
		$get_location_count     = get_option( 'theme_location_select_number', 1 );
		for ( $i = 1; $i <= $get_location_count; $i ++ ) {
			$current_placeholder = get_option( 'inspiry_location_placeholder_' . $i );
			if ( ! empty( $current_placeholder ) ) {
				$locations_placeholders[] = $current_placeholder;
			} else {
				$locations_placeholders[] = rh_any_text();
			}
		}

		return $locations_placeholders;
	}
}

if ( ! function_exists( 'realhomes_get_searched_locations' ) ) {
	/**
	 * Returns an associative array of [ select name => location slug ] pairs
	 *
	 * @param $location_select_names
	 *
	 * @return array
	 */
	function realhomes_get_searched_locations( $location_select_names ): array {
		$locations_in_params = array();
		if ( ! empty ( $location_select_names ) ) {
			foreach ( $location_select_names as $location_name ) {
				if ( isset( $_GET[ $location_name ] ) ) {
					$locations_in_params[ $location_name ] = $_GET[ $location_name ];
				}
			}
		}

		return $locations_in_params;
	}
}

if ( ! function_exists( 'realhomes_get_edited_property_locations' ) ) {
	/**
	 * Returns an associative array of [ select name => location slug ] pairs
	 *
	 * @param int $location_select_count
	 * @param $location_select_names
	 *
	 * @return array
	 */
	function realhomes_get_edited_property_locations( int $location_select_count, $location_select_names ): array {

		$locations_in_params = array();

		if ( ( is_page_template( 'templates/submit-property.php' ) && isset( $_GET['edit_property'] ) )
		     || ( is_page_template( 'templates/dashboard.php' ) && isset( $_GET['id'] ) ) ) {

			$property_id = 0;

			if ( isset( $_GET['edit_property'] ) && ! empty( $_GET['edit_property'] ) ) {
				$property_id = $_GET['edit_property'];
			} elseif ( isset( $_GET['id'] ) && ! empty( $_GET['id'] ) ) {
				$property_id = $_GET['id'];
			}

			$edit_property_id = intval( trim( $property_id ) );
			$target_property  = get_post( $edit_property_id );

			if ( ! empty( $target_property ) && ( $target_property->post_type == 'property' ) ) {
				$location_terms = get_the_terms( $edit_property_id, 'property-city' );
				if ( $location_terms && ! is_wp_error( $location_terms ) ) {
					$existing_location_term = $location_terms[0];
					if ( $existing_location_term->term_id ) {
						//todo:we can avoid db call by finding the ancestor using data from ERE_Data class
						$existing_location_ancestors = get_ancestors( $existing_location_term->term_id, 'property-city' );
						$existing_location_ancestors = array_reverse( $existing_location_ancestors );
						$location_term_depth         = count( $existing_location_ancestors );

						if ( $location_term_depth >= $location_select_count ) {
							for ( $i = 0; $i < ( $location_select_count - 1 ); $i ++ ) {
								//todo: request db can also be saved here using data from ERE_Data class
								$current_ancestor                                    = get_term_by( 'id', $existing_location_ancestors[ $i ], 'property-city' );
								$locations_in_params[ $location_select_names[ $i ] ] = $current_ancestor->slug;
							}
							// For last select box
							$locations_in_params[ $location_select_names[ $location_select_count - 1 ] ] = $existing_location_term->slug;
						} else {
							// It is understood that ( $location_term_depth < $location_select_count )
							for ( $i = 0; $i < $location_term_depth; $i ++ ) {
								//todo: request db can also be saved here using data from ERE_Data class
								$current_ancestor                                    = get_term_by( 'id', $existing_location_ancestors[ $i ], 'property-city' );
								$locations_in_params[ $location_select_names[ $i ] ] = $current_ancestor->slug;
							}
							// For last select box
							$locations_in_params[ $location_select_names[ $location_term_depth ] ] = $existing_location_term->slug;
						}
					}
				}
			}
		}

		return $locations_in_params;
	}
}

if ( ! function_exists( 'realhomes_locations_js_data' ) && 'yes' != get_option( 'inspiry_ajax_location_field' ) ) {
	/**
	 * Load Location Related Script
	 */
	function realhomes_locations_js_data() {

		if ( ! is_admin() && class_exists( 'ERE_Data' ) ) {
			$hide_empty = inspiry_hide_empty_locations();

			// Get locations data in a true hierarchical structure, where a parent has its child in children array ( like tree branches )
			$hierarchical_locations = ERE_Data::get_hierarchical_locations( $hide_empty );

			// Get select boxes names
			$location_select_names = inspiry_get_location_select_names();

			// Get number of select boxes configured in settings
			$location_select_count = inspiry_get_locations_number();

			// location parameters in request, if any
			$locations_in_params = realhomes_get_edited_property_locations( $location_select_count, $location_select_names );

			// following code usually works on search results page to gather searched locations
			if ( 0 == count( $locations_in_params ) ) {
				$locations_in_params = realhomes_get_searched_locations( $location_select_names );
			}

			$any_text = rh_any_text();
			if ( is_page_template( array( 'templates/submit-property.php', 'templates/dashboard.php' ) ) ) {
				$any_text = esc_html__( 'None', 'framework' );  // modify it to None for submit page
			}

			$multi_select_locations = 'no';
			if ( 'yes' == get_option( 'inspiry_search_form_multiselect_locations', 'yes' )
			     && ( 'yes' === get_option( 'inspiry_ajax_location_field', 'no' ) || $location_select_count <= 1 ) ) {
				$multi_select_locations = 'yes';
			}

			// combine all the data variables into an array to pass to JavaScript
			$rh_locations_data = array(
				'any_text'               => $any_text,
				'any_value'              => inspiry_any_value(),
				'select_names'           => $location_select_names,
				'select_count'           => $location_select_count,
				'locations_in_params'    => $locations_in_params,
				'multi_select_locations' => $multi_select_locations,
				'all_locations'          => $hierarchical_locations,
			);

			wp_localize_script( 'realhomes-locations', 'realhomesLocationsData', $rh_locations_data );
		}
	}

	add_action( 'after_location_fields', 'realhomes_locations_js_data' );
}


if ( ! function_exists( 'realhomes_hierarchical_options' ) ) {
	/**
	 * Advance hierarchical options
	 *
	 * @param $taxonomy_name
	 */
	function realhomes_hierarchical_options( $taxonomy_name ) {
		if ( ! class_exists( 'ERE_Data' ) ) {
			return;
		}

		$hierarchical_terms_array = array();
		$searched_terms = null;
		$excluded_terms = null;
		$get_select_placeholder = null;
		$skip_any_option_generation = false;

		if ( $taxonomy_name == 'property-city' ) {
			$hierarchical_terms_array = ERE_Data::get_hierarchical_locations();
			if ( ! empty( $_GET['location'] ) ) {
				$searched_terms = $_GET['location'];
			}
		}

		if ( $taxonomy_name == 'property-type' ) {
			$hierarchical_terms_array = ERE_Data::get_hierarchical_property_types();
			$skip_any_option_generation = ( 'yes' == get_option( 'inspiry_search_form_multiselect_types', 'yes' ) );
			if ( ! $skip_any_option_generation ) {
			    // placeholder for any will be needed
				$get_select_placeholder = get_option( 'inspiry_property_type_placeholder' );
			}
			if ( ! empty( $_GET['type'] ) ) {
				$searched_terms = $_GET['type'];
			}
		}

		if ( $taxonomy_name == 'property-status' ) {
			$hierarchical_terms_array = ERE_Data::get_hierarchical_property_statuses();
			$excluded_terms = get_option( 'inspiry_search_exclude_status' ); // statuses to be excluded from search form field and results
			$get_select_placeholder = get_option( 'inspiry_property_status_placeholder' );
			if ( ! empty( $_GET['status'] ) ) {
				$searched_terms = $_GET['status'];
			}
		}

		if ( ! $skip_any_option_generation ) {
			realhomes_generate_any_option( $get_select_placeholder, $searched_terms );
        }

		// Generate options
		realhomes_generate_options( $hierarchical_terms_array, $searched_terms, '', $excluded_terms );
	}

}

if ( ! function_exists( 'realhomes_generate_options' ) ) {
	/**
	 * Generate Hierarchical Options
	 *
	 * @param array $hierarchical_terms_array
	 * @param $searched_terms
	 * @param string $prefix
	 */
	function realhomes_generate_options( array $hierarchical_terms_array, $searched_terms, string $prefix = '', $excluded_terms = null ) {
		if ( ! empty( $hierarchical_terms_array ) ) {
			foreach ( $hierarchical_terms_array as $term ) {

			    if ( ! empty( $excluded_terms ) && in_array( $term['term_id'], $excluded_terms ) ) {
					continue; //skip if matched with excluded
				}

				if ( ! empty( $searched_terms )
                     && ( ( is_string( $searched_terms ) && $searched_terms == $term['slug'] )
                          || ( is_array( $searched_terms ) && in_array( $term['slug'], $searched_terms ) ) ) ) {
					echo '<option value="' . esc_attr( $term['slug'] ) . '" selected="selected">' . esc_html( $prefix . $term['name'] ) . '</option>';
				} else {
					echo '<option value="' . esc_attr( $term['slug'] ) . '">' . esc_html( $prefix . $term['name'] ) . '</option>';
				}

				// check children and generate options if there are any
				if ( ! empty( $term['children'] ) ) {
					realhomes_generate_options( $term['children'], $searched_terms, '- ' . $prefix, $excluded_terms );
				}
			}
		}
	}
}


if ( ! function_exists( 'realhomes_generate_any_option' ) ) {
	function realhomes_generate_any_option( $get_select_placeholder, $searched_terms ){
		$default_select = rh_any_text();

		if ( ! empty( $get_select_placeholder ) ) {
			$default_select = $get_select_placeholder;
		}

		if ( $searched_terms == inspiry_any_value() || empty( $searched_terms ) ) {
			echo '<option value="' . inspiry_any_value() . '" selected="selected">' . esc_html( $default_select ) . '</option>';
		} else {
			echo '<option value="' . inspiry_any_value() . '">' . esc_html( $default_select ) . '</option>';
		}
	}
}


if ( ! function_exists( 'realhomes_id_based_hierarchical_options' ) ) {
	/**
     * Takes select options based on hierarchical terms data
	 * @param $hierarchical_terms
	 * @param $target_terms_ids
	 * @param string $prefix
	 */
	function realhomes_id_based_hierarchical_options( $hierarchical_terms, $target_terms_ids, $prefix = '' ) {
		if ( ! empty( $hierarchical_terms ) ) {
			foreach ( $hierarchical_terms as $term ) {

				if ( is_array( $target_terms_ids ) ) {
					$has_term = in_array( $term['term_id'], $target_terms_ids );
				} else {
					$has_term = ( $target_terms_ids == $term['term_id'] );
				}

				if ( $has_term ) {
					echo '<option value="' . $term['term_id'] . '" selected="selected">' . $prefix . $term['name'] . '</option>';
				} else {
					echo '<option value="' . $term['term_id'] . '">' . $prefix . $term['name'] . '</option>';
				}

				if ( ! empty( $term['children'] ) ) {
					realhomes_id_based_hierarchical_options( $term['children'], $target_terms_ids, '- ' . $prefix );
				}
			}
		}
	}
}


if ( ! function_exists( 'numbers_list' ) ) {
	/**
	 * Numbers loop
	 *
	 * @param $numbers_list_for
	 */
	function numbers_list( $numbers_list_for ) {
		$numbers_array  = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 );
		$searched_value = '';

		if ( $numbers_list_for == 'bedrooms' ) {
			if ( isset( $_GET['bedrooms'] ) ) {
				$searched_value = $_GET['bedrooms'];
			}
		}

		if ( $numbers_list_for == 'bathrooms' ) {
			if ( isset( $_GET['bathrooms'] ) ) {
				$searched_value = $_GET['bathrooms'];
			}
		}

		if ( $searched_value == inspiry_any_value() || empty( $searched_value ) ) {
			echo '<option value="' . inspiry_any_value() . '" selected="selected">' . rh_any_text() . '</option>';
		} else {
			echo '<option value="' . inspiry_any_value() . '">' . rh_any_text() . '</option>';
		}

		if ( ! empty( $numbers_array ) ) {
			foreach ( $numbers_array as $number ) {
				if ( $searched_value == $number ) {
					echo '<option value="' . $number . '" selected="selected">' . $number . '</option>';
				} else {
					echo '<option value="' . $number . '">' . $number . '</option>';
				}
			}
		}

	}
}

if ( ! function_exists( 'inspiry_agents_in_search' ) ) {
	function inspiry_agents_in_search() {
		$agents = ERE_Data::get_agents_id_name();

		/* check and store searched value if there is any */
		$searched_value = '';
		if ( isset( $_GET['agents'] ) ) {
			$searched_value = $_GET['agents'];
		}

		$inspiry_search_form_multiselect_types = get_option( 'inspiry_search_form_multiselect_agents', 'yes' );

		if ( 'no' == $inspiry_search_form_multiselect_types ) {
			$agent_placeholder = get_option( 'inspiry_property_agent_placeholder' );
			realhomes_generate_any_option( $agent_placeholder, $searched_value );
		}

		/* loop through agent values and generate select options */
		if ( ! empty( $agents ) ) {
			foreach ( $agents as $agent_id => $agent_name ) {
				if ( is_array( $searched_value ) && in_array( $agent_id, $searched_value ) ) {
					echo '<option value="' . $agent_id . '" selected="selected">' . $agent_name . '</option>';
				} else {
					echo '<option value="' . $agent_id . '">' . $agent_name . '</option>';
				}
			}
		}
	}
}

if ( ! function_exists( 'inspiry_min_beds' ) ) {
	/**
	 * Generate values for minimum beds select box
	 */
	function inspiry_min_beds() {
		$min_beds_values = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 );

		// Get values from database and convert them to an integer array
		$inspiry_min_beds = get_option( 'inspiry_min_beds' );
		if ( ! empty( $inspiry_min_beds ) ) {
			$inspiry_min_beds_array = explode( ',', $inspiry_min_beds );
			if ( is_array( $inspiry_min_beds_array ) && ! empty( $inspiry_min_beds_array ) ) {
				$new_inspiry_min_beds_array = array();
				foreach ( $inspiry_min_beds_array as $option_beds_value ) {
					$individual_beds_value = doubleval( $option_beds_value );
					if ( $individual_beds_value >= 0 ) {
						$new_inspiry_min_beds_array[] = $individual_beds_value;
					}
				}
				if ( ! empty( $new_inspiry_min_beds_array ) ) {
					$min_beds_values = $new_inspiry_min_beds_array;
				}
			}
		}

		// check and store searched value if there is any
		$searched_value = '';
		if ( isset( $_GET['bedrooms'] ) ) {
			$searched_value = $_GET['bedrooms'];
		}

		$get_select_placeholder = get_option( 'inspiry_min_beds_placeholder' );

		realhomes_generate_any_option( $get_select_placeholder, $searched_value );

		// loop through min beds values and generate select options
		if ( ! empty( $min_beds_values ) ) {
			foreach ( $min_beds_values as $option_beds_value ) {
				if ( ! empty( $searched_value ) && ( $searched_value == $option_beds_value ) ) {
					echo '<option value="' . $option_beds_value . '" selected="selected">' . $option_beds_value . '</option>';
				} else {
					echo '<option value="' . $option_beds_value . '">' . $option_beds_value . '</option>';
				}
			}
		}

	}
}


if ( ! function_exists( 'inspiry_min_baths' ) ) {
	/**
	 * Generate values for minimum baths select box
	 */
	function inspiry_min_baths() {
		$min_baths_values = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 );

		// Get values from database and convert them to an integer array
		$inspiry_min_baths = get_option( 'inspiry_min_baths' );
		if ( ! empty( $inspiry_min_baths ) ) {
			$inspiry_min_baths_array = explode( ',', $inspiry_min_baths );
			if ( is_array( $inspiry_min_baths_array ) && ! empty( $inspiry_min_baths_array ) ) {
				$new_min_baths_array = array();
				foreach ( $inspiry_min_baths_array as $baths_value ) {
					$integer_baths_value = doubleval( $baths_value );
					if ( $integer_baths_value >= 0 ) {
						$new_min_baths_array[] = $integer_baths_value;
					}
				}
				if ( ! empty( $new_min_baths_array ) ) {
					$min_baths_values = $new_min_baths_array;
				}
			}
		}

		// check and store searched value if there is any */
		$searched_value = '';
		if ( isset( $_GET['bathrooms'] ) ) {
			$searched_value = $_GET['bathrooms'];
		}

		$get_select_placeholder = get_option( 'inspiry_min_baths_placeholder' );

		realhomes_generate_any_option( $get_select_placeholder, $searched_value );

		// loop through min baths values and generate select options
		if ( ! empty( $min_baths_values ) ) {
			foreach ( $min_baths_values as $baths_value ) {
				if ( ! empty( $searched_value ) && ( $searched_value == $baths_value ) ) {
					echo '<option value="' . $baths_value . '" selected="selected">' . $baths_value . '</option>';
				} else {
					echo '<option value="' . $baths_value . '">' . $baths_value . '</option>';
				}
			}
		}

	}
}


if ( ! function_exists( 'inspiry_min_garages' ) ) {
	/**
	 * Generate values for minimum baths select box
	 */
	function inspiry_min_garages() {
		$min_garages_values = array( 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 );

		/* Get values from database and convert them to an integer array */
		$inspiry_min_garages = get_option( 'inspiry_min_garages' );
		if ( ! empty( $inspiry_min_garages ) ) {
			$inspiry_min_garages_array = explode( ',', $inspiry_min_garages );
			if ( is_array( $inspiry_min_garages_array ) && ! empty( $inspiry_min_garages_array ) ) {
				$new_min_garages_array = array();
				foreach ( $inspiry_min_garages_array as $garages_value ) {
					$integer_garages_value = doubleval( $garages_value );
					if ( $integer_garages_value >= 0 ) {
						$new_min_garages_array[] = $integer_garages_value;
					}
				}
				if ( ! empty( $new_min_garages_array ) ) {
					$min_garages_values = $new_min_garages_array;
				}
			}
		}

		/* check and store searched value if there is any */
		$searched_value = '';
		$get_global     = $_GET;
		if ( isset( $get_global['garages'] ) ) {
			$searched_value = $get_global['garages'];
		}

		$get_select_placeholder = get_option( 'inspiry_min_garages_placeholder' );

		realhomes_generate_any_option( $get_select_placeholder, $searched_value );

		/* loop through min baths values and generate select options */
		if ( ! empty( $min_garages_values ) ) {
			foreach ( $min_garages_values as $garages_value ) {
				if ( $searched_value == $garages_value ) {
					echo '<option value="' . esc_attr( $garages_value ) . '" selected="selected">' . esc_html( $garages_value ) . '</option>';
				} else {
					echo '<option value="' . esc_attr( $garages_value ) . '">' . esc_html( $garages_value ) . '</option>';
				}
			}
		}

	}
}


if ( ! function_exists( 'min_prices_list' ) ) {
	/**
	 * Minimum Prices
	 */
	function min_prices_list() {

		$min_price_array = array(
			1000,
			5000,
			10000,
			50000,
			100000,
			200000,
			300000,
			400000,
			500000,
			600000,
			700000,
			800000,
			900000,
			1000000,
			1500000,
			2000000,
			2500000,
			5000000,
		);

		/* Get values from theme options and convert them to an integer array */
		$minimum_price_values = get_option( 'theme_minimum_price_values' );
		if ( ! empty( $minimum_price_values ) ) {
			$min_prices_string_array = explode( ',', $minimum_price_values );
			if ( is_array( $min_prices_string_array ) && ! empty( $min_prices_string_array ) ) {
				$new_min_prices_array = array();
				foreach ( $min_prices_string_array as $string_price ) {
					$integer_price = doubleval( $string_price );
					if ( $integer_price > 1 ) {
						$new_min_prices_array[] = $integer_price;
					}
				}
				if ( ! empty( $new_min_prices_array ) ) {
					$min_price_array = $new_min_prices_array;
				}
			}
		}

		$minimum_price = '';
		if ( isset( $_GET['min-price'] ) ) {
			$minimum_price = doubleval( $_GET['min-price'] );
		}

		$get_select_placeholder = get_option( 'inspiry_min_price_placeholder' );

		realhomes_generate_any_option( $get_select_placeholder, $minimum_price );

		if ( ! empty( $min_price_array ) && function_exists( 'ere_format_amount' ) ) {
			foreach ( $min_price_array as $price ) {
				if ( $minimum_price == $price ) {
					echo '<option value="' . $price . '" selected="selected">' . ere_format_amount( $price ) . '</option>';
				} else {
					echo '<option value="' . $price . '">' . ere_format_amount( $price ) . '</option>';
				}
			}
		}

	}
}


if ( ! function_exists( 'min_prices_for_rent_list' ) ) {
	/**
	 * Minimum Prices For Rent Only
	 */
	function min_prices_for_rent_list() {

		$min_price_for_rent_array = array(
			500,
			1000,
			2000,
			3000,
			4000,
			5000,
			7500,
			10000,
			15000,
			20000,
			25000,
			30000,
			40000,
			50000,
			75000,
			100000,
		);

		/* Get values from theme options and convert them to an integer array */
		$minimum_price_values_for_rent = get_option( 'theme_minimum_price_values_for_rent' );
		if ( ! empty( $minimum_price_values_for_rent ) ) {
			$min_prices_string_array = explode( ',', $minimum_price_values_for_rent );
			if ( is_array( $min_prices_string_array ) && ! empty( $min_prices_string_array ) ) {
				$new_min_prices_array = array();
				foreach ( $min_prices_string_array as $string_price ) {
					$integer_price = doubleval( $string_price );
					if ( $integer_price > 1 ) {
						$new_min_prices_array[] = $integer_price;
					}
				}
				if ( ! empty( $new_min_prices_array ) ) {
					$min_price_for_rent_array = $new_min_prices_array;
				}
			}
		}

		$minimum_price = '';
		if ( isset( $_GET['min-price'] ) ) {
			$minimum_price = doubleval( $_GET['min-price'] );
		}

		$get_select_placeholder = get_option( 'inspiry_min_price_placeholder' );

		realhomes_generate_any_option( $get_select_placeholder, $minimum_price );

		if ( ! empty( $min_price_for_rent_array ) && function_exists( 'ere_format_amount' ) ) {
			foreach ( $min_price_for_rent_array as $price ) {
				if ( $minimum_price == $price ) {
					echo '<option value="' . $price . '" selected="selected">' . ere_format_amount( $price ) . '</option>';
				} else {
					echo '<option value="' . $price . '">' . ere_format_amount( $price ) . '</option>';
				}
			}
		}

	}
}


if ( ! function_exists( 'max_prices_list' ) ) {
	/**
	 * Maximum Prices
	 */
	function max_prices_list() {

		$max_price_array = array(
			5000,
			10000,
			50000,
			100000,
			200000,
			300000,
			400000,
			500000,
			600000,
			700000,
			800000,
			900000,
			1000000,
			1500000,
			2000000,
			2500000,
			5000000,
			10000000,
		);

		/* Get values from theme options and convert them to an integer array */
		$maximum_price_values = get_option( 'theme_maximum_price_values' );
		if ( ! empty( $maximum_price_values ) ) {
			$max_prices_string_array = explode( ',', $maximum_price_values );
			if ( is_array( $max_prices_string_array ) && ! empty( $max_prices_string_array ) ) {
				$new_max_prices_array = array();
				foreach ( $max_prices_string_array as $string_price ) {
					$integer_price = doubleval( $string_price );
					if ( $integer_price > 1 ) {
						$new_max_prices_array[] = $integer_price;
					}
				}
				if ( ! empty( $new_max_prices_array ) ) {
					$max_price_array = $new_max_prices_array;
				}
			}
		}

		$maximum_price = '';
		if ( isset( $_GET['max-price'] ) ) {
			$maximum_price = doubleval( $_GET['max-price'] );
		}

		$get_select_placeholder = get_option( 'inspiry_max_price_placeholder' );

		realhomes_generate_any_option( $get_select_placeholder, $maximum_price );

		if ( ! empty( $max_price_array ) && function_exists( 'ere_format_amount' ) ) {
			foreach ( $max_price_array as $price ) {
				if ( $maximum_price == $price ) {
					echo '<option value="' . $price . '" selected="selected">' . ere_format_amount( $price ) . '</option>';
				} else {
					echo '<option value="' . $price . '">' . ere_format_amount( $price ) . '</option>';
				}
			}
		}
	}
}


if ( ! function_exists( 'max_prices_for_rent_list' ) ) {
	/**
	 * Maximum Price For Rent Only
	 */
	function max_prices_for_rent_list() {

		$max_price_for_rent_array = array(
			1000,
			2000,
			3000,
			4000,
			5000,
			7500,
			10000,
			15000,
			20000,
			25000,
			30000,
			40000,
			50000,
			75000,
			100000,
			150000,
		);

		/* Get values from theme options and convert them to an integer array */
		$maximum_price_for_rent_values = get_option( 'theme_maximum_price_values_for_rent' );
		if ( ! empty( $maximum_price_for_rent_values ) ) {
			$max_prices_string_array = explode( ',', $maximum_price_for_rent_values );
			if ( is_array( $max_prices_string_array ) && ! empty( $max_prices_string_array ) ) {
				$new_max_prices_array = array();
				foreach ( $max_prices_string_array as $string_price ) {
					$integer_price = doubleval( $string_price );
					if ( $integer_price > 1 ) {
						$new_max_prices_array[] = $integer_price;
					}
				}
				if ( ! empty( $new_max_prices_array ) ) {
					$max_price_for_rent_array = $new_max_prices_array;
				}
			}
		}

		$maximum_price = '';
		if ( isset( $_GET['max-price'] ) ) {
			$maximum_price = doubleval( $_GET['max-price'] );
		}

		$get_select_placeholder = get_option( 'inspiry_max_price_placeholder' );

		realhomes_generate_any_option( $get_select_placeholder, $maximum_price );

		if ( ! empty( $max_price_for_rent_array ) && function_exists( 'ere_format_amount' ) ) {
			foreach ( $max_price_for_rent_array as $price ) {
				if ( $maximum_price == $price ) {
					echo '<option value="' . $price . '" selected="selected">' . ere_format_amount( $price ) . '</option>';
				} else {
					echo '<option value="' . $price . '">' . ere_format_amount( $price ) . '</option>';
				}
			}
		}

	}
}


if ( ! function_exists( 'inspiry_get_location_titles' ) ) :
	/**
	 * Get location titles
	 *
	 * @return array Location titles
	 */
	function inspiry_get_location_titles() {

		$main_location = esc_html__( 'Main Location', 'framework' );

		if ( inspiry_is_rvr_enabled() ) {
			$main_location = esc_html__( 'City', 'framework' );
		}

		$location_select_titles = array(
			$main_location,
			esc_html__( 'Child Location', 'framework' ),
			esc_html__( 'Grand Child Location', 'framework' ),
			esc_html__( 'Great Grand Child Location', 'framework' ),
		);

		// Override select boxes titles based on theme options data.
		for ( $i = 1; $i <= 4; $i ++ ) {
			$temp_location_title = get_option( 'theme_location_title_' . $i );
			if ( $temp_location_title ) {
				$location_select_titles[ $i - 1 ] = $temp_location_title;
			}
		}

		return $location_select_titles;
	}
endif;


if ( ! function_exists( 'inspiry_get_locations_number' ) ) :
	/**
	 * Return number of location boxes required in search form
	 *
	 * @return int number of locations
	 */
	function inspiry_get_locations_number() {

		$is_location_ajax = get_option( 'inspiry_ajax_location_field', 'no' ); // Option to check if location field Ajax is enabled

		if ( 'yes' !== $is_location_ajax ) {
			$location_select_count = intval( get_option( 'theme_location_select_number' ) );
			if ( ! ( $location_select_count > 0 && $location_select_count < 5 ) ) {
				$location_select_count = 1;
			}

			return $location_select_count;
		}

		return 1;
	}
endif;


if ( ! function_exists( 'inspiry_get_location_select_names' ) ) :
	/**
	 * Return location select names
	 *
	 * @return mixed|void
	 */
	function inspiry_get_location_select_names() {
		$location_select_names = array(
			'location',
			'child-location',
			'grandchild-location',
			'great-grandchild-location',
		);

		return apply_filters( 'inspiry_location_select_names', $location_select_names );
	}
endif;


if ( ! function_exists( 'real_homes_search' ) ) {
	/**
	 * Properties Search Filter
	 *
	 * @param $search_args
	 *
	 * @return mixed
	 */
	function real_homes_search( $search_args ) {

		// number of properties
		$number_of_properties = intval( get_option( 'theme_properties_on_search' ) );
		if ( ! $number_of_properties ) {
			$number_of_properties = 4;
		}
		$search_args['posts_per_page'] = $number_of_properties;


		$paged = 1;
		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) { // if is static front page
			$paged = get_query_var( 'page' );
		}

		$search_args['paged'] = $paged;


		/* Initialize Taxonomy Query Array */
		$tax_query = array();

		/* Initialize Meta Query Array */
		$meta_query = array();

		/* If search arguments already have a meta query then get it and work on that */
		if ( isset( $search_args['meta_query'] ) ) {
			$meta_query = $search_args['meta_query'];
		}

		/* Keyword Search */
		$search_args = inspiry_keyword_search( $search_args );

		/* Meta Search Filter */
		$meta_query = apply_filters( 'inspiry_real_estate_meta_search', $meta_query );

		/* Taxonomy Search Filter */
		$tax_query = apply_filters( 'inspiry_real_estate_taxonomy_search', $tax_query );

		/* If more than one taxonomies exist then specify the relation */
		$tax_count = count( $tax_query );
		if ( $tax_count > 1 ) {
			$tax_query['relation'] = 'AND';
		}

		/* If more than one meta query elements exist then specify the relation */
		$meta_count = count( $meta_query );
		if ( $meta_count > 1 ) {
			$meta_query['relation'] = 'AND';
		}

		/* If taxonomy query has some values then add it to search query */
		if ( $tax_count > 0 ) {
			$search_args['tax_query'] = $tax_query;
		}

		/* If meta query has some values then add it to search query */
		if ( $meta_count > 0 ) {
			$search_args['meta_query'] = $meta_query;
		}

		// check if featured properties on top option is selected
		$inspiry_featured_properties_on_top = get_option( 'inspiry_featured_properties_on_top' );
		if ( $inspiry_featured_properties_on_top == 'true' ) {
			$search_args['meta_key'] = 'REAL_HOMES_featured';
			$search_args['orderby']  = array(
				'meta_value_num' => 'DESC',
				'date'           => 'DESC',
			);
		}

		/* Sort by price */
		if ( ( isset( $_GET['min-price'] ) && ( $_GET['min-price'] != inspiry_any_value() ) ) || ( isset( $_GET['max-price'] ) && ( $_GET['max-price'] != inspiry_any_value() ) ) ) {
			$search_args['orderby']  = 'meta_value_num';
			$search_args['meta_key'] = 'REAL_HOMES_property_price';
			$search_args['order']    = 'ASC';
		}

		return $search_args;
	}

	add_filter( 'real_homes_search_parameters', 'real_homes_search' );
}


if ( ! function_exists( 'inspiry_area_search' ) ) :
	/**
	 * Add area related search arguments to meta query
	 *
	 * @param $meta_query
	 *
	 * @return array
	 */
	function inspiry_area_search( $meta_query ) {

		if ( isset( $_GET['min-area'] ) && ! empty( $_GET['min-area'] ) && isset( $_GET['max-area'] ) && ! empty( $_GET['max-area'] ) ) {
			$min_area = intval( $_GET['min-area'] );
			$max_area = intval( $_GET['max-area'] );
			if ( $min_area >= 0 && $max_area > $min_area ) {
				$meta_query[] = array(
					'key'     => 'REAL_HOMES_property_size',
					'value'   => array( $min_area, $max_area ),
					'type'    => 'NUMERIC',
					'compare' => 'BETWEEN',
				);
			}
		} elseif ( isset( $_GET['min-area'] ) && ! empty( $_GET['min-area'] ) ) {
			$min_area = intval( $_GET['min-area'] );
			if ( $min_area > 0 ) {
				$meta_query[] = array(
					'key'     => 'REAL_HOMES_property_size',
					'value'   => $min_area,
					'type'    => 'NUMERIC',
					'compare' => '>=',
				);
			}
		} elseif ( isset( $_GET['max-area'] ) && ! empty( $_GET['max-area'] ) ) {
			$max_area = intval( $_GET['max-area'] );
			if ( $max_area > 0 ) {
				$meta_query[] = array(
					'key'     => 'REAL_HOMES_property_size',
					'value'   => $max_area,
					'type'    => 'NUMERIC',
					'compare' => '<=',
				);
			}
		}

		return $meta_query;
	}

	add_filter( 'inspiry_real_estate_meta_search', 'inspiry_area_search' );
endif;


if ( ! function_exists( 'inspiry_price_search' ) ) :
	/**
	 * Add price related search arguments to meta query
	 *
	 * @param $meta_query
	 *
	 * @return array
	 */
	function inspiry_price_search( $meta_query ) {
		if ( isset( $_GET['min-price'] ) && ( $_GET['min-price'] != inspiry_any_value() ) && isset( $_GET['max-price'] ) && ( $_GET['max-price'] != inspiry_any_value() ) ) {
			$min_price = doubleval( $_GET['min-price'] );
			$max_price = doubleval( $_GET['max-price'] );
			if ( $min_price >= 0 && $max_price > $min_price ) {
				$meta_query[] = array(
					'key'     => 'REAL_HOMES_property_price',
					'value'   => array( $min_price, $max_price ),
					'type'    => 'NUMERIC',
					'compare' => 'BETWEEN',
				);
			}
		} elseif ( isset( $_GET['min-price'] ) && ( $_GET['min-price'] != inspiry_any_value() ) ) {
			$min_price = doubleval( $_GET['min-price'] );
			if ( $min_price > 0 ) {
				$meta_query[] = array(
					'key'     => 'REAL_HOMES_property_price',
					'value'   => $min_price,
					'type'    => 'NUMERIC',
					'compare' => '>=',
				);
			}
		} elseif ( isset( $_GET['max-price'] ) && ( $_GET['max-price'] != inspiry_any_value() ) ) {
			$max_price = doubleval( $_GET['max-price'] );
			if ( $max_price > 0 ) {
				$meta_query[] = array(
					'key'     => 'REAL_HOMES_property_price',
					'value'   => $max_price,
					'type'    => 'NUMERIC',
					'compare' => '<=',
				);
			}
		}

		return $meta_query;
	}

	add_filter( 'inspiry_real_estate_meta_search', 'inspiry_price_search' );
endif;


if ( ! function_exists( 'inspiry_property_id_search' ) ) :
	/**
	 * Add property id related search arguments to meta query
	 *
	 * @param $meta_query
	 *
	 * @return array
	 */
	function inspiry_property_id_search( $meta_query ) {
		if ( isset( $_GET['property-id'] ) && ! empty( $_GET['property-id'] ) ) {
			$property_id  = trim( $_GET['property-id'] );
			$meta_query[] = array(
				'key'     => 'REAL_HOMES_property_id',
				'value'   => $property_id,
				'compare' => 'LIKE',
				'type'    => 'CHAR',
			);
		}

		return $meta_query;
	}

	add_filter( 'inspiry_real_estate_meta_search', 'inspiry_property_id_search' );
endif;


if ( ! function_exists( 'inspiry_get_beds_baths_compare_operator' ) ) :
	/**
	 * Return compare operator for beds and baths search
	 * @return string
	 */
	function inspiry_get_beds_baths_compare_operator() {
		$inspiry_beds_baths_search_behaviour = get_option( 'inspiry_beds_baths_search_behaviour' );
		switch ( $inspiry_beds_baths_search_behaviour ) {
			case 'min':
				$inspiry_compare_operator = '>=';
				break;
			case 'max':
				$inspiry_compare_operator = '<=';
				break;
			case 'equal':
				$inspiry_compare_operator = '=';
				break;
			default:
				$inspiry_compare_operator = '>=';
		}

		return $inspiry_compare_operator;
	}
endif;


if ( ! function_exists( 'inspiry_get_garages_compare_operator' ) ) :

	/**
	 * Return compare operator for garages search
	 *
	 * @return string
	 */
	function inspiry_get_garages_compare_operator() {
		$inspiry_garages_search_behaviour = get_option( 'inspiry_garages_search_behaviour' );
		switch ( $inspiry_garages_search_behaviour ) {
			case 'min':
				$inspiry_compare_operator = '>=';
				break;
			case 'max':
				$inspiry_compare_operator = '<=';
				break;
			case 'equal':
				$inspiry_compare_operator = '=';
				break;
			default:
				$inspiry_compare_operator = '>=';
		}

		return $inspiry_compare_operator;
	}
endif;


if ( ! function_exists( 'inspiry_bathrooms_search' ) ) :
	/**
	 * Add bathrooms related arguments to meta query
	 *
	 * @param $meta_query
	 *
	 * @return array
	 */
	function inspiry_bathrooms_search( $meta_query ) {
		if ( ( ! empty( $_GET['bathrooms'] ) ) && ( $_GET['bathrooms'] != inspiry_any_value() ) ) {
			$meta_query[] = array(
				'key'     => 'REAL_HOMES_property_bathrooms',
				'value'   => $_GET['bathrooms'],
				'compare' => inspiry_get_beds_baths_compare_operator(),
				'type'    => 'DECIMAL',
			);
		}

		return $meta_query;
	}

	add_filter( 'inspiry_real_estate_meta_search', 'inspiry_bathrooms_search' );
endif;


if ( ! function_exists( 'inspiry_beds_search' ) ) :
	/**
	 * Add bedrooms related arguments to meta query
	 *
	 * @param $meta_query
	 *
	 * @return array
	 */
	function inspiry_beds_search( $meta_query ) {
		if ( ( ! empty( $_GET['bedrooms'] ) ) && ( $_GET['bedrooms'] != inspiry_any_value() ) ) {
			$meta_query[] = array(
				'key'     => 'REAL_HOMES_property_bedrooms',
				'value'   => $_GET['bedrooms'],
				'compare' => inspiry_get_beds_baths_compare_operator(),
				'type'    => 'DECIMAL',
			);
		}

		return $meta_query;
	}

	add_filter( 'inspiry_real_estate_meta_search', 'inspiry_beds_search' );
endif;


if ( ! function_exists( 'inspiry_garages_search' ) ) :

	/**
	 * Add garages related arguments to meta query
	 *
	 * @param array $meta_query - Meta search query array.
	 *
	 * @return array
	 */
	function inspiry_garages_search( $meta_query ) {
		$get_global = $_GET;
		if ( ( ! empty( $get_global['garages'] ) ) && ( $get_global['garages'] != inspiry_any_value() ) ) {
			$meta_query[] = array(
				'key'     => 'REAL_HOMES_property_garage',
				'value'   => $get_global['garages'],
				'compare' => inspiry_get_garages_compare_operator(),
				'type'    => 'DECIMAL',
			);
		}

		return $meta_query;
	}

	add_filter( 'inspiry_real_estate_meta_search', 'inspiry_garages_search' );
endif;

if ( ! function_exists( 'inspiry_agent_search' ) ) :
	/**
	 * Add property agent related search arguments to meta query
	 *
	 * @param $meta_query
	 *
	 * @return array
	 */
	function inspiry_agent_search( $meta_query ) {
		if ( isset( $_GET['agents'] ) && ! empty( $_GET['agents'] ) ) {
			$meta_query[] = array(
				'key'     => 'REAL_HOMES_agents',
				'value'   => $_GET['agents'],
				'compare' => 'IN',
			);
		}

		return $meta_query;
	}

	add_filter( 'inspiry_real_estate_meta_search', 'inspiry_agent_search' );
endif;

if ( ! function_exists( 'inspiry_keyword_search' ) ) {
	/**
	 * Add keyword search related arguments to search query
	 *
	 * @param $search_args
	 *
	 * @return mixed
	 */
	function inspiry_keyword_search( $search_args ) {
		if ( isset ( $_GET['keyword'] ) ) {
			$keyword = trim( $_GET['keyword'] );
			if ( ! empty( $keyword ) ) {
				$search_args['s'] = $keyword;

				return $search_args;
			}
		}

		return $search_args;
	}
}


if ( ! function_exists( 'inspiry_property_type_search' ) ) :
	/**
	 * Add property type related search arguments to taxonomy query
	 *
	 * @param $tax_query
	 *
	 * @return array
	 */
	function inspiry_property_type_search( $tax_query ) {
		if ( ( ! empty( $_GET['type'] ) ) && ( $_GET['type'] != inspiry_any_value() ) ) {
			$tax_query[] = array(
				'taxonomy' => 'property-type',
				'field'    => 'slug',
				'terms'    => $_GET['type'],
			);
		}

		return $tax_query;
	}

	add_filter( 'inspiry_real_estate_taxonomy_search', 'inspiry_property_type_search' );
endif;


if ( ! function_exists( 'inspiry_location_search' ) ) :
	/**
	 * Add location related search arguments to taxonomy query
	 *
	 * @param $tax_query
	 *
	 * @return array
	 */
	function inspiry_location_search( $tax_query ) {
		$location_select_names = inspiry_get_location_select_names();
		$locations_count       = count( $location_select_names );
		for ( $l = $locations_count - 1; $l >= 0; $l -- ) {
			if ( isset( $_GET[ $location_select_names[ $l ] ] ) ) {
				$current_location = $_GET[ $location_select_names[ $l ] ];
				if ( ( ! empty ( $current_location ) ) && ( $current_location != inspiry_any_value() ) ) {
					$tax_query[] = array(
						'taxonomy' => 'property-city',
						'field'    => 'slug',
						'terms'    => $current_location,
					);
					break;
				}
			}
		}

		return $tax_query;
	}

	add_filter( 'inspiry_real_estate_taxonomy_search', 'inspiry_location_search' );
endif;


if ( ! function_exists( 'inspiry_property_features_search' ) ) :
	/**
	 * Add features related search arguments to taxonomy query
	 *
	 * @param $tax_query
	 *
	 * @return array
	 */
	function inspiry_property_features_search( $tax_query ) {
		if ( ! class_exists( 'ERE_Data' ) ) {
			return $tax_query;
		}
		if ( isset( $_GET['features'] ) ) {
			$required_features_slugs = $_GET['features'];
			if ( is_array( $required_features_slugs ) ) {
				$slugs_count = count( $required_features_slugs );
				if ( $slugs_count > 0 ) {

					/* build an array of existing features slugs to validate required feature slugs */
					$existing_features_slugs = ERE_Data::get_features_slug_name();

					foreach ( $required_features_slugs as $feature_slug ) {
						$feature_slug = rawurldecode( $feature_slug );
						/* validate feature slug */
						if ( isset( $existing_features_slugs[ $feature_slug ] ) ) {
							$tax_query[] = array(
								'taxonomy' => 'property-feature',
								'field'    => 'slug',
								'terms'    => $feature_slug,
							);
						}
					}
				}
			}
		}

		return $tax_query;
	}

	add_filter( 'inspiry_real_estate_taxonomy_search', 'inspiry_property_features_search' );
endif;


if ( ! function_exists( 'inspiry_property_status_search' ) ) :
	/**
	 * Add property status related search arguments to taxonomy query
	 *
	 * @param $tax_query
	 *
	 * @return array
	 */
	function inspiry_property_status_search( $tax_query ) {
		if ( ( ! empty( $_GET['status'] ) ) && ( $_GET['status'] != inspiry_any_value() ) ) {
			$tax_query[] = array(
				'taxonomy' => 'property-status',
				'field'    => 'slug',
				'terms'    => $_GET['status'],
			);
		}

		// Excluding statuses
		$excluded_statuses = get_option( 'inspiry_search_exclude_status' );
		if ( ! empty( $excluded_statuses ) ) {
			$tax_query[] = array(
				array(
					'taxonomy' => 'property-status',
					'field'    => 'id',
					'terms'    => $excluded_statuses,
					'operator' => 'NOT IN',
				),
			);
		}

		return $tax_query;
	}

	add_filter( 'inspiry_real_estate_taxonomy_search', 'inspiry_property_status_search' );
endif;


if ( ! function_exists( 'inspiry_fix_featured_meta' ) ) :
	/**
	 * To fix featured property meta data inconsistency in legacy code.
	 */
	function inspiry_fix_featured_meta() {

		// Works on search template only
		if ( is_page_template( array(
			'templates/properties-search.php',
			'templates/properties-search-half-map.php',
			'templates/properties-search-left-sidebar.php',
			'templates/properties-search-right-sidebar.php',
		) ) ) {

			// Only if featured properties on top is enabled
			$featured_properties_on_top = get_option( 'inspiry_featured_properties_on_top' );
			if ( 'true' == $featured_properties_on_top ) {

				// Take up to 100 properties and fix those.
				$fixable_properties = get_posts( array(
					'post_type'      => 'property',
					'posts_per_page' => 100,
					'meta_query'     => array(
						'relation' => 'OR',
						array(
							'key'     => 'REAL_HOMES_featured',
							'compare' => 'NOT EXISTS',
						),
						array(
							'relation' => 'AND',
							array(
								'key'     => 'REAL_HOMES_featured',
								'value'   => '1',
								'compare' => '!=',
							),
							array(
								'key'     => 'REAL_HOMES_featured',
								'value'   => '0',
								'compare' => '!=',
							),
						),
					),
				) );

				if ( $fixable_properties ) {
					foreach ( $fixable_properties as $fixable_property ) {
						update_post_meta( $fixable_property->ID, 'REAL_HOMES_featured', '0' );
					}
				}
			}
		}

	}

	add_action( 'template_redirect', 'inspiry_fix_featured_meta' );
endif;

if ( ! function_exists( 'inspiry_get_location_options' ) ) {
	/**
	 * Return Property Locations as Options List in Json format
	 */
	function inspiry_get_location_options() {

		$options = array(); // A list of location options will be passed to this array
		$number  = 15; // Number of locations that will be returned per Ajax request

		$offset = '';
		if ( isset( $_GET['page'] ) ) {
			$offset = $number * ( $_GET['page'] - 1 ); // Offset of locations list for the current Ajax request
		}
		$locations_order = array(
			'orderby' => 'count',
			'order'   => 'desc',
		);

		$order = get_option( 'theme_locations_order' );
		if ( $order == 'true' ) {
			$locations_order['orderby'] = 'name';
			$locations_order['order']   = 'asc';
		}

		// Prepare a query to fetch property locations from database
		$terms_query = array(
			'taxonomy'   => 'property-city',
			'number'     => $number,
			'offset'     => $offset,
			'hide_empty' => inspiry_hide_empty_locations(),
			'orderby'    => $locations_order['orderby'],
			'order'      => $locations_order['order'],
		);

		// If there is a search parameter
		if ( isset( $_GET['query'] ) ) {
			$terms_query['name__like'] = $_GET['query'];
		}

		$locations = get_terms( $terms_query );

		// Build an array of locations info form their objects
		if ( ! empty( $locations ) && ! is_wp_error( $locations ) ) {
			foreach ( $locations as $location ) {
				$options[] = array( $location->slug, $location->name );
			}
		}

		echo json_encode( $options ); // Return locations list in Json format
		die;
	}

	add_action( 'wp_ajax_inspiry_get_location_options', 'inspiry_get_location_options' );
	add_action( 'wp_ajax_nopriv_inspiry_get_location_options', 'inspiry_get_location_options' );
}

if ( ! function_exists( 'inspiry_searched_ajax_locations' ) ) {
	/**
	 * Display Property Ajax Searched Locations Select Options
	 */

	function inspiry_searched_ajax_locations() {

		$searched_locations = '';
		if ( isset( $_GET['location'] ) ) {
			$searched_locations = $_GET['location'];
		}

		if ( is_array( $searched_locations ) && ! empty( $_GET['location'] ) ) {
			foreach ( $searched_locations as $location ) {
				$searched_terms = get_term_by( 'slug', $location, 'property-city' );
				?>
                <option value="<?php echo esc_attr( $searched_terms->slug ) ?>"
                        selected="selected"><?php echo esc_html( $searched_terms->name ) ?></option>
				<?php
			}
		} elseif ( ! empty( $searched_terms ) ) {
			$searched_terms = get_term_by( 'slug', $searched_locations, 'property-city' );
			?>
            <option value="<?php echo esc_attr( $searched_terms->slug ) ?>"
                    selected="selected"><?php echo esc_html( $searched_terms->name ) ?></option>
			<?php
		}

	}
}