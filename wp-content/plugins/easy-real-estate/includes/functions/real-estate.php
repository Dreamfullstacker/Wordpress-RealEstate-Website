<?php
/**
 * Helping functions related to real estate
 */

if ( ! function_exists( 'ere_get_property_statuses' ) ) {
	/**
	 * Display property status.
	 *
	 * @param int $post_id - Property ID.
	 */
	function ere_get_property_statuses( $post_id ) {

		$status_terms = get_the_terms( $post_id, 'property-status' );

		if ( ! empty( $status_terms ) ) {

			$status_names = '';
			$status_count = 0;

			foreach ( $status_terms as $term ) {
				if ( $status_count > 0 ) {
					$status_names .= ', ';  /* add comma before the term namee of 2nd and any later term */
				}
				$status_names .= $term->name;
				$status_count++;
			}

			if ( ! empty( $status_names ) ) {
				return $status_names;
			}
		}

		return '';
	}
}


if ( ! function_exists( 'ere_get_property_types' ) ) {
	/**
	 * Get property types
	 *
	 * @param $property_post_id
	 * @return string
	 */
	function ere_get_property_types( $property_post_id ) {
		$type_terms = get_the_terms( $property_post_id, "property-type" );
		if ( ! empty( $type_terms ) ) {
			$type_count = count( $type_terms );
			$property_types_str = '<small>';
			$loop_count = 1;
			foreach ( $type_terms as $typ_trm ) {
				$property_types_str .= $typ_trm->name;
				if ( $loop_count < $type_count && $type_count > 1 ) {
					$property_types_str .= ', ';
				}
				$loop_count++;
			}
			$property_types_str .= '</small>';
		} else {
			$property_types_str = '&nbsp;';
		}
		return $property_types_str;
	}
}


if( !function_exists( 'ere_any_text' ) ) :
	/**
	 * Return text string for word 'Any'
	 *
	 * @return string
	 */
	function ere_any_text() {
		$ere_any_text = get_option( 'inspiry_any_text' );
		if ( $ere_any_text ) {
			return $ere_any_text;
		}
		return esc_html__( 'Any', 'easy-real-estate' );
	}
endif;


if( !function_exists( 'ere_is_search_page_configured' ) ) :
	/**
	 * Check if search page settings are configured
	 */
	function ere_is_search_page_configured() {

		/* Check search page */
		$inspiry_search_page = get_option('inspiry_search_page');
		if ( ! empty( $inspiry_search_page ) ) {
			return true;
		}

		/* Check search url which is deprecated and this code is to provide backward compatibility */
		$theme_search_url = get_option('theme_search_url');
		if ( ! empty( $theme_search_url ) ) {
			return true;
		}

		/* Return false if all fails */
		return false;
	}
endif;

if ( ! function_exists( 'ere_skip_sticky_properties' ) ) :
	/**
	 * Skip sticky properties
	 */
	function ere_skip_sticky_properties(){
		$skip_sticky = get_option( 'inspiry_listing_skip_sticky', false );
		if ( $skip_sticky ) {
			remove_filter( 'the_posts', 'inspiry_make_properties_stick_at_top', 10 );
		}
    }
endif;

if ( ! function_exists( 'ere_skip_home_sticky_properties' ) ) :
	/**
	 * Skip sticky properties
	 */
	function ere_skip_home_sticky_properties(){
		$skip_sticky = get_post_meta( get_the_ID(), 'inspiry_home_skip_sticky', true );
		if ( $skip_sticky ) {
			remove_filter( 'the_posts', 'inspiry_make_properties_stick_at_top', 10 );
		}
    }
endif;


if ( ! function_exists( 'ere_get_figure_caption' ) ) {
	/**
	 * Figure caption based on property statuses
	 *
	 * @param $post_id
	 * @return string
	 */
	function ere_get_figure_caption( $post_id ) {
		$status_terms = get_the_terms( $post_id, "property-status" );
		if ( ! empty( $status_terms ) ) {
			$status_classes = '';
			$status_names = '';
			$status_count = 0;
			foreach ( $status_terms as $term ) {
				if ( $status_count > 0 ) {
					$status_names .= ', ';  /* add comma before the term namee of 2nd and any later term */
					$status_classes .= ' ';
				}
				$status_names .= $term->name;
				$status_classes .= $term->slug;
				$status_count++;
			}

			if ( ! empty( $status_names ) ) {
				return '<figcaption class="' . $status_classes . '">' . $status_names . '</figcaption>';
			}

			return '';
		}
	}
}


if ( ! function_exists( 'ere_display_figcaption' ) ) {
	/**
	 * Display figure caption for given property's post id
	 *
	 * @param $post_id
	 */
	function ere_display_figcaption( $post_id ) {
		echo ere_get_figure_caption( $post_id );
	}
}


if ( ! function_exists( 'ere_is_added_to_compare' ) ) {
	/**
	 * Check if a property is already added to compare list.
	 *
	 * @param $property_id
	 * @return bool
	 */
	function ere_is_added_to_compare( $property_id ) {

		if ( $property_id > 0 ) {
			/* check cookies for property id */
			if ( isset( $_COOKIE[ 'inspiry_compare' ] ) ) {
				$inspiry_compare 	= unserialize( $_COOKIE[ 'inspiry_compare' ] );
				if ( in_array( $property_id, $inspiry_compare ) ) {
					return true;
				}
			}
		}
		return false;

	}
}

if ( ! function_exists( 'ere_additional_details_migration' ) ) {
	/**
	 * Migrate property additioanl details from old metabox key to new metabox key.
	 *
	 * @param int $post_id Property ID of which additional details has to migrate.
	 */
	function ere_additional_details_migration( $post_id ) {

		if ( ! $post_id ) {
			return;
		}

		$additional_details = get_post_meta( $post_id, 'REAL_HOMES_additional_details', true );
		if ( ! empty( $additional_details ) ) {
			$formatted_details = array();
			foreach ( $additional_details as $field => $value ) {
				$formatted_details[] = array( $field, $value );
			}

			if ( update_post_meta( $post_id, 'REAL_HOMES_additional_details_list', $formatted_details ) ) {
				delete_post_meta( $post_id, 'REAL_HOMES_additional_details' );
			}
		} else {
			// For legacy code
			$detail_titles = get_post_meta( $post_id, 'REAL_HOMES_detail_titles', true );
			if ( ! empty( $detail_titles ) ) {
				$detail_values = get_post_meta( $post_id, 'REAL_HOMES_detail_values', true );
				if ( ! empty( $detail_values ) ) {
					$additional_details = array_combine( $detail_titles, $detail_values );
					$formatted_details = array();
					foreach ( $additional_details as $field => $value ) {
						$formatted_details[] = array( $field, $value );
					}

					if ( update_post_meta( $post_id, 'REAL_HOMES_additional_details_list', $formatted_details ) ) {
						delete_post_meta( $post_id, 'REAL_HOMES_detail_titles' );
						delete_post_meta( $post_id, 'REAL_HOMES_detail_values' );
					}
				}
			}
		}
	}
}
