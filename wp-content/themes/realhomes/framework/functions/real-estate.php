<?php
/**
 * This file contain theme's real estate functions
 *
 * @package realhomes/functions
 */
if ( ! function_exists( 'inspiry_get_properties_sort_by_value' ) ) {
	/**
	 * Retrieves the properties sort by value.
	 *
	 * @return string Properties sort by value.
	 * 
	 * @since 3.10.1
	 */
	function inspiry_get_properties_sort_by_value() {

		$sort_by_value = '';

		if ( isset( $_GET['sortby'] ) ) {
			$sort_by_value = sanitize_text_field( $_GET['sortby'] );
		} else {
			$sort_by_value = get_option( 'theme_listing_default_sort' );

			if ( is_page_template( array(
				'templates/list-layout.php',
				'templates/list-layout-full-width.php',
				'templates/grid-layout.php',
				'templates/grid-layout-full-width.php',
				'templates/half-map-layout.php',
			) ) ) {
				$page_sort_by_value = get_post_meta( get_the_ID(), 'inspiry_properties_order', true );
				if ( 'default' !== $page_sort_by_value ) {
					$sort_by_value = $page_sort_by_value;
				}
			}
		}

		return apply_filters( 'inspiry_get_properties_sort_by_value', $sort_by_value );
	}
}

if ( ! function_exists( 'sort_properties' ) ) {
	/**
	 * This function add sorting parameters to given query arguments
	 *
	 * @param $property_query_args
	 *
	 * @return mixed
	 */
	function sort_properties( $property_query_args ) {

		$sort_by = inspiry_get_properties_sort_by_value();

		if ( $sort_by == 'price-asc' ) {

			$property_query_args['orderby']  = 'meta_value_num';
			$property_query_args['meta_key'] = 'REAL_HOMES_property_price';
			$property_query_args['order']    = 'ASC';

		} else if ( $sort_by == 'price-desc' ) {

			$property_query_args['orderby']  = 'meta_value_num';
			$property_query_args['meta_key'] = 'REAL_HOMES_property_price';
			$property_query_args['order']    = 'DESC';

		} else if ( $sort_by == 'date-asc' ) {

			// This condition is for search results only - For more info consult real_homes_search() function.
			if ( isset( $property_query_args['meta_key'] ) && ( $property_query_args['meta_key'] == 'REAL_HOMES_featured' ) ) {
				$property_query_args['orderby'] = array(
					'meta_value_num' => 'DESC',
					'date'           => 'ASC',
				);
			} else {
				$property_query_args['orderby'] = 'date';
				$property_query_args['order']   = 'ASC';
			}

		} else if ( $sort_by == 'date-desc' ) {

			// This condition is for search results only - For more info consult real_homes_search() function.
			if ( isset( $property_query_args['meta_key'] ) && ( $property_query_args['meta_key'] == 'REAL_HOMES_featured' ) ) {
				$property_query_args['orderby'] = array(
					'meta_value_num' => 'DESC',
					'date'           => 'DESC',
				);
			} else {
				$property_query_args['orderby'] = 'date';
				$property_query_args['order']   = 'DESC';
			}

		}

		return apply_filters( 'inspiry_sort_properties', $property_query_args );
	}
}

if ( ! function_exists( 'realhomes_property_archive_sort' ) ) {
	/**
     * Modifies property archive query with respect to sorting
	 * @param $query
	 */
	function realhomes_property_archive_sort( $query ) {
		if ( $query->is_main_query() && ! is_admin() ) {
			if ( $query->is_post_type_archive( 'property' ) ) {
				$sort_query_args = sort_properties( array() );
				// order by
				if ( isset( $sort_query_args['orderby'] ) ) {
					$query->set( 'orderby', $sort_query_args['orderby'] );
				}
				// order by
				if ( isset( $sort_query_args['meta_key'] ) ) {
					$query->set( 'meta_key', $sort_query_args['meta_key'] );
				}
				// order by
				if ( isset( $sort_query_args['order'] ) ) {
					$query->set( 'order', $sort_query_args['order'] );
				}
			}
		}
	}

	add_action( 'pre_get_posts', 'realhomes_property_archive_sort' );
}

if ( ! function_exists( 'inspiry_get_sort_by_value' ) ) {
	/**
	 * Retrieves the sort value for the page.
     *
     * @since 3.10.2
	 *
	 * @param string $sort_by_value
	 *
	 * @return string sort by value.
	 */
	function inspiry_get_sort_by_value( $sort_by_value = 'default' ) {

		if ( isset( $_GET['sortby'] ) ) {
			$sort_by_value = sanitize_text_field( $_GET['sortby'] );
		}

		return $sort_by_value;
	}
}

if ( ! function_exists( 'inspiry_agents_sort_args' ) ) {
	/**
	 * Adds sorting parameters to agents query arguments.
     *
     * @since 3.10.2
	 *
	 * @param $agent_query_args
	 *
	 * @return mixed
	 */
	function inspiry_agents_sort_args( $agent_query_args ) {

		$sort_by = inspiry_get_sort_by_value();

		if ( 'title-asc' === $sort_by ) {
			$agent_query_args['orderby']  = 'title';
			$agent_query_args['order']    = 'ASC';

		} elseif ( 'title-desc' === $sort_by ) {
			$agent_query_args['orderby']  = 'title';
			$agent_query_args['order']    = 'DESC';

		} elseif ( 'total-asc' === $sort_by || 'total-desc' === $sort_by ) {

			$agents_to_sort = array();
			$agents = get_posts( array(
				'post_type'   => 'agent',
				'numberposts' => - 1,
			) );

			if ( ! empty( $agents ) && function_exists( 'ere_get_agent_properties_count' ) ) {
				foreach ( $agents as $agent ) {
					$agent_id = $agent->ID;
					$agents_to_sort[ $agent_id ] = ere_get_agent_properties_count( $agent_id );
				}
			}

			if ( ! empty( $agents_to_sort ) && is_array( $agents_to_sort ) ) {
				if ( 'total-asc' === $sort_by ) {
					asort( $agents_to_sort );
				} elseif ( 'total-desc' === $sort_by ) {
					arsort( $agents_to_sort );
				}

				$agent_query_args['post__in'] = array_keys( $agents_to_sort );
				$agent_query_args['orderby']  = 'post__in';
			}
		}

		return apply_filters( 'inspiry_agents_sort_args', $agent_query_args );
	}
}

if ( ! function_exists( 'inspiry_agent_sort_options' ) ) {
	/**
	 * Displays agent sort options for select.
	 *
     * @since 3.10.2
	 */
	function inspiry_agent_sort_options() {

		$sort_options = apply_filters( 'inspiry_agent_sort_options', array(
			'default'    => esc_html__( 'Default Order', 'framework' ),
			'title-asc'  => esc_html__( 'Agent Name ( A to Z )', 'framework' ),
			'title-desc' => esc_html__( 'Agent Name ( Z to A )', 'framework' ),
			'total-asc'  => esc_html__( 'Listed Properties ( Low to High )', 'framework' ),
			'total-desc' => esc_html__( 'Listed Properties ( High to Low )', 'framework' )
		) );

		if ( ! empty( $sort_options ) && is_array( $sort_options ) ) {

			$html     = '';
			$selected = apply_filters( 'inspiry_agents_sort_by_value', inspiry_get_sort_by_value() );

			foreach ( $sort_options as $key => $value ) {
				$html .= sprintf( '<option value="%s"%s>%s</option>', esc_attr( $key ), selected( $selected, $key, false ), esc_html( $value ) );
			}

			echo wp_kses(
				$html,
				array(
					'option' => array(
						'value'    => array(),
						'selected' => array(),
					),
				)
			);
		}
	}
}

if ( ! function_exists( 'inspiry_agency_sort_options' ) ) {
	/**
	 * Displays agency sort options for select.
	 *
	 * @since 3.11.0
	 */
	function inspiry_agency_sort_options() {

		$sort_options = apply_filters( 'inspiry_agency_sort_options', array(
			'default'    => esc_html__( 'Default Order', 'framework' ),
			'title-asc'  => esc_html__( 'Agency Name ( A to Z )', 'framework' ),
			'title-desc' => esc_html__( 'Agency Name ( Z to A )', 'framework' ),
			'total-asc'  => esc_html__( 'Listed Properties ( Low to High )', 'framework' ),
			'total-desc' => esc_html__( 'Listed Properties ( High to Low )', 'framework' ),
		) );

		if ( ! empty( $sort_options ) && is_array( $sort_options ) ) {

			$html = '';
			$selected = apply_filters( 'inspiry_agencies_sort_by_value', inspiry_get_sort_by_value() );

			foreach ( $sort_options as $key => $value ) {
				$html .= sprintf( '<option value="%s"%s>%s</option>', esc_attr( $key ), selected( $selected, $key, false ), esc_html( $value ) );
			}

			echo wp_kses(
				$html,
				array(
					'option' => array(
						'value'    => array(),
						'selected' => array(),
					),
				)
			);
		}
	}
}

if ( ! function_exists( 'inspiry_agencies_sort_args' ) ) {
	/**
	 * Adds sorting parameters to agencies query arguments.
	 *
	 * @since 3.11.0
	 *
	 * @param $agency_query_args
	 *
	 * @return mixed
	 */
	function inspiry_agencies_sort_args( $agency_query_args ) {

		$sort_by = inspiry_get_sort_by_value();

		if ( 'title-asc' === $sort_by ) {
			$agency_query_args['orderby']  = 'title';
			$agency_query_args['order']    = 'ASC';

		} elseif ( 'title-desc' === $sort_by ) {
			$agency_query_args['orderby']  = 'title';
			$agency_query_args['order']    = 'DESC';

		} elseif ( 'total-asc' === $sort_by || 'total-desc' === $sort_by ) {

			$agencies_to_sort = array();
			$agencies         = get_posts( array(
				'post_type'   => 'agency',
				'numberposts' => - 1,
			) );

			if ( ! empty( $agencies ) && function_exists( 'ere_get_agency_properties_count' ) ) {
				foreach ( $agencies as $agency ) {
					$agency_id = $agency->ID;
					$agencies_to_sort[ $agency_id ] = ere_get_agency_properties_count( $agency_id );
				}
			}

			if ( ! empty( $agencies_to_sort ) && is_array( $agencies_to_sort ) ) {
				if ( 'total-asc' === $sort_by ) {
					asort( $agencies_to_sort );
				} elseif ( 'total-desc' === $sort_by ) {
					arsort( $agencies_to_sort );
				}

				$agency_query_args['post__in'] = array_keys( $agencies_to_sort );
				$agency_query_args['orderby']  = 'post__in';
			}
		}

		return apply_filters( 'inspiry_agencies_sort_args', $agency_query_args );
	}
}

if ( ! function_exists( 'realhomes_admin_styles' ) ) {
	/**
	 * Register and load admin styles
	 *
	 * @param $hook
	 */
	function realhomes_admin_styles( $hook ) {
		wp_register_style( 'realhomes-admin-styles', get_theme_file_uri( 'common/css/admin-styles.min.css' ) );
		wp_enqueue_style( 'realhomes-admin-styles' );
	}

	add_action( 'admin_enqueue_scripts', 'realhomes_admin_styles', 100 );
}

if ( ! function_exists( 'inspiry_get_figure_caption' ) ) {
	/**
	 * Figure caption based on property statuses
	 *
	 * @param $post_id
	 *
	 * @return string
	 */
	function inspiry_get_figure_caption( $post_id ) {
		$status_terms = get_the_terms( $post_id, "property-status" );
		if ( ! empty( $status_terms ) && ! is_wp_error( $status_terms ) ) {
			$status_classes = '';
			$status_names   = '';
			$status_count   = 0;
			foreach ( $status_terms as $term ) {
				if ( $status_count > 0 ) {
					$status_names   .= ', ';  /* add comma before the term namee of 2nd and any later term */
					$status_classes .= ' ';
				}
				$status_names   .= $term->name;
				$status_classes .= $term->slug;
				$status_count ++;
			}

			if ( ! empty( $status_names ) ) {
				return '<figcaption class="' . $status_classes . '">' . $status_names . '</figcaption>';
			}

			return '';
		}
	}
}

if ( ! function_exists( 'display_figcaption' ) ) {
	/**
	 * Display figure caption for given property's post id
	 *
	 * @param $post_id
	 */
	function display_figcaption( $post_id ) {
		echo inspiry_get_figure_caption( $post_id );
	}
}

if ( ! function_exists( 'display_property_status_html' ) ) {
	/**
	 * Display property status.
	 *
	 * @param $post_id
	 *
	 */
	function display_property_status_html( $post_id ) {
		$status_terms = get_the_terms( $post_id, 'property-status' );

		if ( ! empty( $status_terms ) && ! is_wp_error( $status_terms ) ) {


			foreach ( $status_terms as $term ) {

			    $inspiry_property_status_bg = get_term_meta($term->term_id,'inspiry_property_status_bg',true);
				$status_bg = '';
			    if(!empty($inspiry_property_status_bg)){
			        $status_bg = " background:" . "$inspiry_property_status_bg; ";
                }
                $inspiry_property_status_text = get_term_meta($term->term_id,'inspiry_property_status_text',true);

			    $status_text = '';
			    if(!empty($inspiry_property_status_text)){
				    $status_text = " color:" . "$inspiry_property_status_text; ";
                }

			    ?>
                <span class="rh_prop_status_sty" style="<?php echo esc_attr($status_bg . $status_text)?>">
                <?php
				echo esc_html($term->name);
				?>
				</span>
                <?php
			}
		}

	}
}

if ( ! function_exists( 'display_property_status' ) ) {
	/**
	 * Display property status.
	 *
	 * @param $post_id
	 *
	 * @return string
	 */
	function display_property_status( $post_id ) {
		$status_terms = get_the_terms( $post_id, 'property-status' );

		if ( ! empty( $status_terms ) && ! is_wp_error( $status_terms ) ) {

			$status_names = '';
			$status_count = 0;

			foreach ( $status_terms as $term ) {
				if ( $status_count > 0 ) {
					$status_names .= ', ';  /* add comma before the term name of 2nd and any later term */
				}
				$status_names .= $term->name;
				$status_count ++;
			}

			if ( ! empty( $status_names ) ) {
				return $status_names;
			}
		}

		return '';
	}
}

if ( ! function_exists( 'inspiry_display_property_label' ) ) {
	/**
	 * Display property label
	 *
	 * @param $post_id
	 */
	function inspiry_display_property_label( $post_id ) {

		$label_text = get_post_meta( $post_id, 'inspiry_property_label', true );
		$color      = get_post_meta( $post_id, 'inspiry_property_label_color', true );
		if ( ! empty ( $label_text ) ) {
			?>
            <span <?php if ( ! empty( $color ) ){ ?>style="background: <?php echo esc_attr( $color ); ?>"<?php } ?>
                  class='property-label'><?php echo esc_html( $label_text ); ?></span>
			<?php

		}
	}
}

if ( ! function_exists( 'inspiry_get_property_types' ) ) {
	/**
	 * Get property types
	 *
	 * @param $property_post_id
	 *
	 * @return string
	 */
	function inspiry_get_property_types( $property_post_id ) {
		$type_terms = get_the_terms( $property_post_id, "property-type" );
		if ( ! empty( $type_terms ) && ! is_wp_error( $type_terms ) ) {
			$type_count         = count( $type_terms );
			$property_types_str = '<small> - ';
			$loop_count         = 1;
			foreach ( $type_terms as $typ_trm ) {
				$property_types_str .= $typ_trm->name;
				if ( $loop_count < $type_count && $type_count > 1 ) {
					$property_types_str .= ', ';
				}
				$loop_count ++;
			}
			$property_types_str .= '</small>';
		} else {
			$property_types_str = '&nbsp;';
		}

		return $property_types_str;
	}
}

if ( ! function_exists( 'inspiry_get_property_types_string' ) ) {
	/**
	 * Get property types
	 *
	 * @param $property_post_id
	 *
	 * @return string
	 */
	function inspiry_get_property_types_string( $property_post_id ) {
		$type_terms = get_the_terms( $property_post_id, "property-type" );
		if ( ! empty( $type_terms ) && ! is_wp_error( $type_terms ) ) {
			$type_count = count( $type_terms );
			$property_types_str = '';
			$loop_count         = 1;
			foreach ( $type_terms as $typ_trm ) {
				$property_types_str .= $typ_trm->name;
				if ( $loop_count < $type_count && $type_count > 1 ) {
					$property_types_str .= ', ';
				}
				$loop_count ++;
			}
		} else {
			$property_types_str = '&nbsp;';
		}

		return $property_types_str;
	}
}

if ( ! function_exists( 'inspiry_get_property_status' ) ) {
	/**
	 * Returns property status
	 *
	 * @param $post_id
	 *
	 * @return string
	 */
	function inspiry_get_property_status( $post_id ) {
		$status_terms = get_the_terms( $post_id, "property-status" );
		if ( ! empty( $status_terms ) && ! is_wp_error( $status_terms ) ) {
			$status_links = '';
			$status_count = 0;
			foreach ( $status_terms as $term ) {
				if ( $status_count > 0 ) {
					$status_links .= ' ';
				}
				$status_href  = get_term_link( $term );
				$status_href  = ( ! is_wp_error( $status_href ) ) ? $status_href : '';
				$status_links .= '<a href=" ' . $status_href . ' ">' . $term->name . '</a>';
				$status_count ++;
			}

			if ( ! empty( $status_links ) ) {
				return $status_links;
			}

			return '';
		}
	}
}

if ( ! function_exists( 'inspiry_get_number_of_photos' ) ) {
	/**
	 * Returns the number of photos in a gallery of property
	 *
	 * @param  $post_id
	 *
	 * @return int
	 * @since  2.6.3
	 */
	function inspiry_get_number_of_photos( $post_id ) {
		if ( function_exists( 'rwmb_meta' ) ) {
			$properties_images = rwmb_meta( 'REAL_HOMES_property_images', 'type=plupload_image', $post_id );

			return count( $properties_images );
		}

		return 0;
	}
}

if ( ! function_exists( 'inspiry_add_term_children' ) ) {
	/**
	 * A recursive function to add children terms to given array
	 *
	 * @param $parent_id
	 * @param $tax_terms
	 * @param $terms_array
	 * @param string $prefix
	 */
	function inspiry_add_term_children( $parent_id, $tax_terms, &$terms_array, $prefix = '' ) {
		if ( ! empty( $tax_terms ) && ! is_wp_error( $tax_terms ) ) {
			foreach ( $tax_terms as $term ) {
				if ( $term->parent == $parent_id ) {
					$terms_array[ $term->slug ] = $prefix . $term->name;
					inspiry_add_term_children( $term->term_id, $tax_terms, $terms_array, $prefix . '- ' );
				}
			}
		}
	}
}

if ( ! function_exists( 'inspiry_properties_filter' ) ) {
	/**
	 * Add properties filter parameters to given query arguments
	 *
	 * @param $properties_query_args  Array   query arguments
	 *
	 * @return mixed    Array   modified query arguments
	 */
	function inspiry_properties_filter( $properties_query_args ) {

		// Apply pagination
		$paged = 1;
		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) { // if is static front page
			$paged = get_query_var( 'page' );
		}

		$properties_query_args['paged'] = $paged;

		$page_id    = get_the_ID();
		$tax_query  = array();
		$meta_query = array();

		if ( '1' === get_post_meta( $page_id, 'inspiry_featured_properties_only', true ) ) {
			$meta_query[] = array(
				'key'     => 'REAL_HOMES_featured',
				'value'   => 1,
				'compare' => '=',
				'type'    => 'NUMERIC',
			);
		}
		
		// Number of properties on each page
		$theme_number_of_properties = get_option( 'theme_number_of_properties', 6 );
		$number_of_properties       = get_post_meta( $page_id, 'inspiry_posts_per_page', true );

		if ( $number_of_properties ) {
			$properties_query_args['posts_per_page'] = $number_of_properties;
		} elseif ( ! empty( $theme_number_of_properties ) ) {
			$properties_query_args['posts_per_page'] = $theme_number_of_properties;
		} else {
			$properties_query_args['posts_per_page'] = 6;
		}

		// Locations
		$locations = get_post_meta( $page_id, 'inspiry_properties_locations', false );
		if ( ! empty( $locations ) && is_array( $locations ) ) {
			$tax_query[] = array(
				'taxonomy' => 'property-city',
				'field'    => 'slug',
				'terms'    => $locations
			);
		}

		// Statuses
		$statuses = get_post_meta( $page_id, 'inspiry_properties_statuses', false );
		if ( ! empty( $statuses ) && is_array( $statuses ) ) {
			$tax_query[] = array(
				'taxonomy' => 'property-status',
				'field'    => 'slug',
				'terms'    => $statuses
			);
		}

		// Types
		$types = get_post_meta( $page_id, 'inspiry_properties_types', false );
		if ( ! empty( $types ) && is_array( $types ) ) {
			$tax_query[] = array(
				'taxonomy' => 'property-type',
				'field'    => 'slug',
				'terms'    => $types
			);
		}

		// Features
		$features = get_post_meta( $page_id, 'inspiry_properties_features', false );
		if ( ! empty( $features ) && is_array( $features ) ) {
			$tax_query[] = array(
				'taxonomy' => 'property-feature',
				'field'    => 'slug',
				'terms'    => $features
			);
		}

		// If more than one taxonomies exist then specify the relation
		$tax_count = count( $tax_query );
		if ( $tax_count > 1 ) {
			$tax_query['relation'] = 'AND';
		}
		if ( $tax_count > 0 ) {
			$properties_query_args['tax_query'] = $tax_query;
		}

		// Minimum Bedrooms
		$min_beds = get_post_meta( $page_id, 'inspiry_properties_min_beds', true );
		if ( ! empty( $min_beds ) ) {
			$min_beds = intval( $min_beds );
			if ( $min_beds > 0 ) {
				$meta_query[] = array(
					'key'     => 'REAL_HOMES_property_bedrooms',
					'value'   => $min_beds,
					'compare' => '>=',
					'type'    => 'DECIMAL'
				);
			}
		}

		// Minimum Bathrooms
		$min_baths = get_post_meta( $page_id, 'inspiry_properties_min_baths', true );
		if ( ! empty( $min_baths ) ) {
			$min_baths = intval( $min_baths );
			if ( $min_baths > 0 ) {
				$meta_query[] = array(
					'key'     => 'REAL_HOMES_property_bathrooms',
					'value'   => $min_baths,
					'compare' => '>=',
					'type'    => 'DECIMAL'
				);
			}
		}

		// Min & Max Price
		$min_price = get_post_meta( $page_id, 'inspiry_properties_min_price', true );
		$max_price = get_post_meta( $page_id, 'inspiry_properties_max_price', true );
		if ( ! empty( $min_price ) && ! empty( $max_price ) ) {
			$min_price = doubleval( $min_price );
			$max_price = doubleval( $max_price );
			if ( $min_price >= 0 && $max_price > $min_price ) {
				$meta_query[] = array(
					'key'     => 'REAL_HOMES_property_price',
					'value'   => array( $min_price, $max_price ),
					'type'    => 'NUMERIC',
					'compare' => 'BETWEEN'
				);
			}
		} elseif ( ! empty( $min_price ) ) {
			$min_price = doubleval( $min_price );
			if ( $min_price > 0 ) {
				$meta_query[] = array(
					'key'     => 'REAL_HOMES_property_price',
					'value'   => $min_price,
					'type'    => 'NUMERIC',
					'compare' => '>='
				);
			}
		} elseif ( ! empty( $max_price ) ) {
			$max_price = doubleval( $max_price );
			if ( $max_price > 0 ) {
				$meta_query[] = array(
					'key'     => 'REAL_HOMES_property_price',
					'value'   => $max_price,
					'type'    => 'NUMERIC',
					'compare' => '<='
				);
			}
		}


		// Agents, use array_filter to remove empty values.
		$agents = array_filter( get_post_meta( $page_id, 'inspiry_properties_by_agents', false ) );
		if ( count( $agents ) >= 1 ) {
			$meta_query[] = array(
				'key'     => 'REAL_HOMES_agents',
				'value'   => $agents,
				'compare' => 'IN',
			);
		}

		// If more than one meta query elements exist then specify the relation.
		$meta_count = count( $meta_query );
		if ( $meta_count > 1 ) {
			$meta_query['relation'] = 'AND';
		}
		if ( $meta_count > 0 ) {
			$properties_query_args['meta_query'] = $meta_query;
		}

		return $properties_query_args;
	}

	add_filter( 'inspiry_properties_filter', 'inspiry_properties_filter' );
}

if ( ! function_exists( 'inspiry_property_id_meta_update' ) ) {
	/**
	 * This function adds Property ID to properties
	 * in the backend if Auto Property ID generation
	 * is enabled.
	 *
	 * @since 3.2.0
	 */
	function inspiry_property_id_meta_update( $meta_id, $property_id, $meta_key, $meta_value ) {

		// Check if paramters are empty.
		if ( empty( $meta_id ) || empty( $property_id ) || empty( $meta_key ) ) {
			return;
		}

		// Check if meta key is not REAL_HOMES_property_id.
		if ( 'REAL_HOMES_property_id' !== $meta_key ) {
			return;
		}

		// Check if auto property id auto generation is enabled.
		$auto_property_id = get_option( 'inspiry_auto_property_id_check' );
		if ( ! empty( $auto_property_id ) && 'true' === $auto_property_id ) {

			$property_id_old     = get_post_meta( $property_id, 'REAL_HOMES_property_id', true );
			$property_id_pattern = get_option( 'inspiry_auto_property_id_pattern' );
			$property_id_value   = preg_replace( '/{ID}/', $property_id, $property_id_pattern );

			if ( $property_id_old !== $property_id_value ) {
				update_post_meta( $property_id, 'REAL_HOMES_property_id', $property_id_value );
			}
		}

	}

	add_action( 'added_post_meta', 'inspiry_property_id_meta_update', 10, 4 );
	add_action( 'updated_post_meta', 'inspiry_property_id_meta_update', 10, 4 );
}

if ( ! function_exists( 'inspiry_gallery_properties_filter' ) ) {
	/**
	 * Add gallery properties filter parameters to given query arguments
	 *
	 * @param array $properties_query_args - Query arguments.
	 *
	 * @return mixed|array - Modified query arguments.
	 */
	function inspiry_gallery_properties_filter( $properties_query_args ) {

		// Get the page ID.
		$page_id = get_the_ID();

		// Taxonomy query.
		$tax_query = array();

		// Meta query.
		$meta_query = array();

		// Number of properties on each page
		$number_of_properties = get_post_meta( $page_id, 'inspiry_gallery_posts_per_page', true );
		if ( $number_of_properties ) {
			$number_of_properties = intval( $number_of_properties );
			if ( $number_of_properties < 1 ) {
				$properties_query_args['posts_per_page'] = 6;
			} else {
				$properties_query_args['posts_per_page'] = $number_of_properties;
			}
		} else {
			$properties_query_args['posts_per_page'] = 6;
		}

		// Locations
		$locations = get_post_meta( $page_id, 'inspiry_gallery_properties_locations', false );
		if ( ! empty( $locations ) && is_array( $locations ) ) {
			$tax_query[] = array(
				'taxonomy' => 'property-city',
				'field'    => 'slug',
				'terms'    => $locations,
			);
		}

		// Statuses
		$statuses = get_post_meta( $page_id, 'inspiry_gallery_properties_statuses', false );
		if ( ! empty( $statuses ) && is_array( $statuses ) ) {
			$tax_query[] = array(
				'taxonomy' => 'property-status',
				'field'    => 'slug',
				'terms'    => $statuses,
			);
		}

		// Types
		$types = get_post_meta( $page_id, 'inspiry_gallery_properties_types', false );
		if ( ! empty( $types ) && is_array( $types ) ) {
			$tax_query[] = array(
				'taxonomy' => 'property-type',
				'field'    => 'slug',
				'terms'    => $types,
			);
		}

		// Features
		$features = get_post_meta( $page_id, 'inspiry_gallery_properties_features', false );
		if ( ! empty( $features ) && is_array( $features ) ) {
			$tax_query[] = array(
				'taxonomy' => 'property-feature',
				'field'    => 'slug',
				'terms'    => $features,
			);
		}

		// If more than one taxonomies exist then specify the relation.
		$tax_count = count( $tax_query );
		if ( $tax_count > 1 ) {
			$tax_query['relation'] = 'AND';
		}
		if ( $tax_count > 0 ) {
			$properties_query_args['tax_query'] = $tax_query;
		}

		// Meta query for gallery.
		$meta_query[] = array(
			'key' => '_thumbnail_id',
		);
		$properties_query_args['meta_query'] = $meta_query;

		return $properties_query_args;
	}

	add_filter( 'inspiry_gallery_properties_filter', 'inspiry_gallery_properties_filter' );
}

if ( ! function_exists( 'inspiry_get_property_agents' ) ) {
	/**
	 * Returns array containing agent/agents IDs related to given or current property ID.
	 *
	 * @param int $property_id
	 *
	 * @return array|bool|mixed
	 */
	function inspiry_get_property_agents( $property_id = 0 ) {

		if ( ! $property_id ) {
			$property_id = get_the_ID();
		}

		if ( $property_id ) {

			$property_agents = get_post_meta( $property_id, 'REAL_HOMES_agents' );

			// Remove invalid ids.
			if ( ! empty( $property_agents ) ) {
				$property_agents = array_filter( $property_agents, function ( $v ) {
					return ( $v > 0 );
				} );
			}

			if ( ! empty( $property_agents ) ) {
				// Remove duplicated ids.
				$property_agents = array_unique( $property_agents );

				// Return valid agents array.
				return $property_agents;
			}

		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_new_function' ) ) {
	/**
	 * Returns comma separated list of property agents names.
	 *
	 * @param int $property_id
	 *
	 * @return bool|string
	 */
	function inspiry_get_property_agents_names( $property_id = 0 ) {
		if ( ! $property_id ) {
			$property_id = get_the_ID();
		}

		$property_agents = inspiry_get_property_agents( $property_id );
		if ( ! empty( $property_agents ) ) {
			$agents_names = array();
			foreach ( $property_agents as $single_agent_id ) {
				if ( 0 < $single_agent_id ) {
					$agents_names[] = get_the_title( $single_agent_id );
				}
			}

			if ( ! empty( $agents_names ) ) {
				return implode( ', ', $agents_names );
			}
		}

		return false;
	}
}

if ( ! function_exists( 'rh_any_text' ) ) {
	/**
	 * Return text string for word 'Any'
	 *
	 * @return string
	 */
	function rh_any_text() {
		if ( function_exists( 'ere_any_text' ) ) {
			return ere_any_text();
		}

		return esc_html__( 'Any', 'framework' );
	}
}

if ( ! function_exists( 'inspiry_prop_detail_login' ) ) {
	/**
	 * Check if login required to vew property detail
	 *
	 * @return bool
	 */
	function inspiry_prop_detail_login() {
		$require_login = get_option( 'inspiry_prop_detail_login', 'no' );

		return ( 'yes' == $require_login && ! is_user_logged_in() );
	}
}