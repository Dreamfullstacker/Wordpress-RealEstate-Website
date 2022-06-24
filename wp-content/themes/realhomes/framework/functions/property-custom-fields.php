<?php
/**
 * Custom property fields hooks and configuration
 *
 * @since    3.0.1
 * @package realhomes/functions
 */

if ( ! function_exists( 'inspiry_property_custom_fields' ) ) {
	function inspiry_property_custom_fields( $meta_boxes ) {
		$updated_meta_boxes = array_map( 'inspiry_append_custom_fields', $meta_boxes );

		return $updated_meta_boxes;
	}

	add_filter( 'framework_theme_meta', 'inspiry_property_custom_fields' );
}

if ( ! function_exists( 'inspiry_append_custom_fields' ) ) {
	function inspiry_append_custom_fields( $field ) {

		if ( isset( $field['id'] ) && $field['id'] == 'property-meta-box' ) {

			$prefix     = 'REAL_HOMES_';
			$tab_key    = 'details';
			$new_fields = array();

			$custom_fields = apply_filters( 'inspiry_property_custom_fields', array(
				array(
					'tab'    => array(),
					'fields' => array()
				)
			) );

			if ( isset( $custom_fields['tab'] ) && ! empty( $custom_fields['tab'] ) ) {

				$tab_key = inspiry_backend_safe_string( $custom_fields['tab']['label'] );

				$custom_tab = array(
					$tab_key => array(
						'label' => $custom_fields['tab']['label'],
						'icon'  => $custom_fields['tab']['icon'],
					)
				);

				$field['tabs'] = array_merge( $field['tabs'], $custom_tab );
			}

			if ( isset( $custom_fields['fields'] ) && ! empty( $custom_fields['fields'] ) && is_array( $custom_fields['fields'] ) ) {

				foreach ( $custom_fields['fields'] as $new_field ) {
					$new_fields[] = array(
						'id'      => $prefix . inspiry_backend_safe_string( $new_field['id'] ),
						'name'    => $new_field['name'],
						'desc'    => $new_field['desc'],
						'type'    => 'text',
						'std'     => '',
						'columns' => $new_field['columns'],
						'tab'     => $tab_key,
					);
				}

				$field['fields'] = array_merge( $field['fields'], $new_fields );
			}
		}

		return $field;
	}
}


if ( ! function_exists( 'inspiry_property_additional_details' ) ) {
	/**
	 * Set default additional details for the property
	 * @return array
	 */
	function inspiry_property_additional_details() {

		$string = get_option( 'inspiry_property_additional_details' );

		if ( ! empty( $string ) ) {
			$fields = explode( ',', $string );

			$default_details = array();
			foreach ( $fields as $field ) {
				$values = explode( ":", $field );

				if ( isset( $values[0] ) && isset( $values[1] ) ) {
					$default_details[ $values[0] ] = $values[1];
				}
			}

			return $default_details;
		}
	}

	add_filter( 'inspiry_default_property_additional_details', 'inspiry_property_additional_details' );
}


if ( ! function_exists( 'inspiry_make_sticky_properties' ) ) {

	/**
	 * Make sticky properties option array.
	 *
	 * @param int 	 $meta_id - ID of the meta.
	 * @param int 	 $property_id - ID of the property.
	 * @param string $meta_key - Meta key string.
	 * @param mix 	 $meta_value - Meta value.
	 * @since 3.0.2
	 */
	function inspiry_make_sticky_properties( $meta_id, $property_id, $meta_key, $meta_value ) {

		if ( empty( $meta_id ) || empty( $property_id ) || empty( $meta_key ) ) {
			return;
		}

		if ( 'REAL_HOMES_sticky' !== $meta_key ) {
			return;
		}

		if ( ! empty( $meta_value ) ) {
			// Get sticky properties option array.
			$sticky_properties 		= get_option( 'inspiry_sticky_properties', array() );
			$sticky_properties[]	= $property_id;

			// Update sticky properties option array.
			update_option( 'inspiry_sticky_properties', $sticky_properties );
		} else {
			// Get sticky properties option array.
			$sticky_properties 		= get_option( 'inspiry_sticky_properties', array() );
			if ( in_array( $property_id, $sticky_properties ) ) {
				$property_key = array_search( $property_id, $sticky_properties, true );
				unset( $sticky_properties[ $property_key ] );
			}
			// Update sticky properties option array.
			update_option( 'inspiry_sticky_properties', $sticky_properties );
		}

	}

	add_action( 'added_post_meta', 'inspiry_make_sticky_properties', 10, 4 );
	add_action( 'updated_post_meta', 'inspiry_make_sticky_properties', 10, 4 );
}


if ( ! function_exists( 'inspiry_make_properties_stick_at_top' ) ) {

	/**
	 * Make properties stick at top on Home page,
	 * Properties listing and grid listing page.
	 *
	 * @param  array    $posts - The array of retrieved properties/posts.
	 * @param  WP_Query $query - The WP_Query instance (passed by reference).
	 * @return array
	 * @since  3.0.2
	 */
	function inspiry_make_properties_stick_at_top( $posts, $query ) {

		// Apply it on homepage, property listing and grid listing only.
		if ( is_main_query() && ( is_page_template( array( 
														'templates/list-layout.php',
														'templates/home.php', 
														'templates/list-layout-full-width.php',
														'templates/grid-layout-full-width.php',
														'templates/grid-layout.php',
														) ) ) ) {

			global $wp_query;
			if ( 'property' !== $query->query_vars['post_type'] ) {
				return $posts;
			}

			if ( isset( $_GET['sortby'] ) && ( 'default' !== $_GET['sortby'] ) &&
				 ( is_page_template( array( 'templates/list-layout.php' , 'templates/grid-layout.php' ) ) ) ) {
				return $posts;
			}

		    $sticky_posts = get_option( 'inspiry_sticky_properties', array() );
		    $num_posts = count( $posts );
		    $sticky_offset = 0;

		    // Find the sticky posts.
		    for ( $i = 0; $i < $num_posts; $i++ ) {

		        // Put sticky posts at the top of the posts array.
		        if ( in_array( $posts[ $i ]->ID, $sticky_posts ) ) {
		            $sticky_post = $posts[ $i ];

		            // Remove sticky from current position.
		            array_splice( $posts, $i, 1 );

		            // Move to front, after other stickies.
		            array_splice( $posts, $sticky_offset, 0, array( $sticky_post ) );
		            $sticky_offset++;

		            // Remove post from sticky posts array.
		            $offset = array_search( $sticky_post->ID, $sticky_posts );
		            unset( $sticky_posts[ $offset ] );
		        }
		    }

		    // Look for more sticky posts if needed.
		    if ( ! empty( $sticky_posts ) ) {

		        $stickies = get_posts( array(
		            'post__in' 		=> $sticky_posts,
		            'post_type' 	=> $wp_query->query_vars['post_type'],
		            'post_status'	=> 'publish',
		            'nopaging' 		=> true,
		        ) );

		        foreach ( $stickies as $sticky_post ) {
		            array_splice( $posts, $sticky_offset, 0, array( $sticky_post ) );
		            $sticky_offset++;
		        }
		    }
		}

		return $posts;
	}

	add_filter( 'the_posts', 'inspiry_make_properties_stick_at_top', 10, 2 );
}
