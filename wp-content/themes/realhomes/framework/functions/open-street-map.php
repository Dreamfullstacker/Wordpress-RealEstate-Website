<?php
/**
 * Contains Enqueue and Render functions related to Open Street Map
 */


if ( ! function_exists( 'inspiry_enqueue_open_street_map' ) ) :
	/**
	 * Enqueue Open Street Map related JS and CSS files.
	 */
	function inspiry_enqueue_open_street_map() {

		if ( inspiry_is_map_needed() || inspiry_map_needed_for_address() ) {

			// Enqueue leaflet CSS
			wp_enqueue_style( 'leaflet', 'https://unpkg.com/leaflet@1.3.4/dist/leaflet.css', array(), '1.3.4' );

			// Enqueue leaflet JS
			wp_enqueue_script( 'leaflet', 'https://unpkg.com/leaflet@1.3.4/dist/leaflet.js', array(), '1.3.4', true );

			// Now we need to load JS files and Localized data based on the page visitor is on.
			if ( is_singular( 'property' ) && ( 'true' == get_option( 'theme_display_google_map' ) ) ) {
				inspiry_render_property_open_street_map();

			} elseif ( is_page_template( 'templates/contact.php' ) && ( '1' == get_post_meta( get_the_ID(), 'theme_show_contact_map', true ) ) ) {
				inspiry_render_contact_open_street_map();

			} elseif ( is_page_template( array( 'templates/submit-property.php', 'templates/dashboard.php' ) ) ) {
				inspiry_render_submit_open_street_map();

			} elseif ( is_page_template( 'templates/half-map-layout.php' ) ) {
				inspiry_render_multi_properties_open_street_map();

			} elseif ( is_page_template( 'templates/home.php' ) ) {
				$theme_homepage_module = get_post_meta( get_the_ID(), 'theme_homepage_module', true );
				if ( isset( $_GET['module'] ) ) {
					$theme_homepage_module = $_GET['module'];
				}
				if ( 'properties-map' == $theme_homepage_module ) {
					inspiry_render_multi_properties_open_street_map();
				}

			} elseif ( is_page_template( array('templates/properties-search.php', 'templates/properties-search-half-map.php', 'templates/half-map-layout.php', 'templates/properties-search-left-sidebar.php', 'templates/properties-search-right-sidebar.php') ) ) {
				$theme_search_module = get_option( 'theme_search_module', 'properties-map' );
				if ( 'modern' === INSPIRY_DESIGN_VARIATION && ( inspiry_is_search_page_map_visible() || is_page_template( 'templates/properties-search-half-map.php' ) ) ) {
					inspiry_render_multi_properties_open_street_map();
				} elseif ( 'classic' === INSPIRY_DESIGN_VARIATION && ( 'properties-map' == $theme_search_module || is_page_template( 'templates/properties-search-half-map.php' ) ) ) {
					inspiry_render_multi_properties_open_street_map();
				}

			} elseif ( is_page_template( array( 'templates/list-layout.php', 'templates/grid-layout.php', 'templates/list-layout-full-width.php', 'templates/grid-layout-full-width.php' ) ) ||
			           is_tax( 'property-city' ) || is_tax( 'property-status' ) || is_tax( 'property-type' ) || is_tax( 'property-feature' ) ||
			           is_post_type_archive( 'property' ) ) {

				$theme_listing_module = get_option( 'theme_listing_module' );
				if ( isset( $_GET['module'] ) ) {
					$theme_listing_module = $_GET['module'];
				}
				if ( $theme_listing_module == 'properties-map' ) {
					inspiry_render_multi_properties_open_street_map();
				}

			}

		}

	}

endif;


if ( ! function_exists( 'inspiry_render_submit_open_street_map' ) ) :
	/**
	 * Render open street map for submit property page
	 */
	function inspiry_render_submit_open_street_map() {

		$file = 'assets/' . INSPIRY_DESIGN_VARIATION . '/scripts/js/submit-open-street-map.js';
		if ( is_page_template( 'templates/dashboard.php' ) ) {
			$file = 'common/js/submit-open-street-map.js';
		}
		wp_enqueue_script( 'submit-open-street-map', get_theme_file_uri( $file ), array( 'jquery', 'leaflet' ), INSPIRY_THEME_VERSION, true );
	}

endif;


if ( ! function_exists( 'inspiry_render_contact_open_street_map' ) ) :
	/**
	 * Render open street map for contact page
	 */
	function inspiry_render_contact_open_street_map() {

		wp_register_script( 'contact-open-street-map', get_theme_file_uri( 'assets/' . INSPIRY_DESIGN_VARIATION . '/scripts/js/contact-open-street-map.js' ), array( 'jquery', 'leaflet' ), INSPIRY_THEME_VERSION, true );

		$contact_map_lat  = get_post_meta( get_the_ID(), 'theme_map_lati', true );
		$contact_map_lang = get_post_meta( get_the_ID(), 'theme_map_longi', true );

		if ( $contact_map_lat && $contact_map_lang ) {

			$contact_map_data = array();

			$contact_map_data['lat']  = $contact_map_lat;
			$contact_map_data['lng']  = $contact_map_lang;
			$contact_map_data['zoom'] = intval( get_post_meta( get_the_ID(), 'theme_map_zoom', true ) );

			wp_localize_script( 'contact-open-street-map', 'contactMapData', $contact_map_data );
			wp_enqueue_script( 'contact-open-street-map' );
		}
	}

endif;


if( !function_exists( 'inspiry_render_multi_properties_open_street_map' ) ) :
	/**
	 * Render open street map for multiple properties
	 */
	function inspiry_render_multi_properties_open_street_map() {

		wp_enqueue_script(
			'leaflet-marker-cluster',
			get_theme_file_uri( 'common/js/' . 'leaflet.markercluster-src.js' ),
			array( 'jquery', 'leaflet' ),
			INSPIRY_THEME_VERSION,
			true
		);

		wp_register_script( 'properties-open-street-map', get_theme_file_uri( 'assets/' . INSPIRY_DESIGN_VARIATION . '/scripts/js/properties-open-street-map.js' ), array( 'jquery', 'leaflet' ), INSPIRY_THEME_VERSION, true );

		$map_properties_query_args = array(
			'post_type'      => 'property',
			'posts_per_page' => apply_filters( 'real_homes_properties_on_map', 500 ),            /* used 500 instead of -1 to get only a reasonable number of properties */
			'meta_query'     => array(
				array(
					'key'     => 'REAL_HOMES_property_address',
					'compare' => 'EXISTS',
				),
			),
		);

		if ( is_page_template( array( 'templates/properties-search.php', 'templates/properties-search-half-map.php', 'templates/properties-search-left-sidebar.php', 'templates/properties-search-right-sidebar.php' ) ) ) {

			// Apply Search Filter
			$map_properties_query_args = apply_filters( 'real_homes_search_parameters', $map_properties_query_args );

			// Set number of properties for the search results map
			$properties_on_search_map = get_option( 'inspiry_properties_on_search_map', 'all' );
			if ( 'all' == $properties_on_search_map ) {
				$map_properties_query_args['posts_per_page'] = -1;
			}

		} elseif ( is_page_template( 'templates/home.php' ) ) {

			// Apply Homepage Properties Filter
			$map_properties_query_args = apply_filters( 'real_homes_homepage_properties', $map_properties_query_args );

		} elseif ( is_page_template( array( 'templates/list-layout.php', 'templates/list-layout-full-width.php', 'templates/grid-layout.php', 'templates/grid-layout-full-width.php', 'templates/half-map-layout.php' ) ) ) {

			// Apply properties filter settings from properties list templates.
			$map_properties_query_args = apply_filters( 'inspiry_properties_filter', $map_properties_query_args );

			// Apply sorting.
			$map_properties_query_args = sort_properties( $map_properties_query_args );

			// Set number of properties for the property listing pages map
			$properties_on_search_map = get_option( 'inspiry_properties_list_tax_on_map', 'all' );
			if ( 'all' == $properties_on_search_map ) {
				$map_properties_query_args['posts_per_page'] = -1;
			}

		} elseif ( is_tax() ) {

			global $wp_query;

			// taxonomy query
			$map_properties_query_args['tax_query'] = array(
				array(
					'taxonomy' => $wp_query->query_vars['taxonomy'],
					'field'    => 'slug',
					'terms'    => $wp_query->query_vars['term'],
				),
			);

			// for pagination
			global $paged;
			$map_properties_query_args['paged'] = $paged;

			// Set number of properties for the property taxonomy pages map
			$properties_on_search_map = get_option( 'inspiry_properties_list_tax_on_map', 'all' );
			if ( 'all' == $properties_on_search_map ) {
				$map_properties_query_args['posts_per_page'] = -1;
			} else {
				$number_of_properties = intval( get_option( 'theme_number_of_properties', 6 ) );
				if ( 0 >= $number_of_properties ) {
					$number_of_properties = 6;
				}
				$map_properties_query_args['posts_per_page'] = $number_of_properties;
			}

		} elseif ( is_post_type_archive( 'property' ) ) {

			global $paged;
			$map_properties_query_args['paged'] = $paged;

			// Set number of properties for the property archive page map
			$properties_on_search_map = get_option( 'inspiry_properties_list_tax_on_map', 'all' );
			if ( 'all' == $properties_on_search_map ) {
				$map_properties_query_args['posts_per_page'] = -1;
			} else {
				$number_of_properties = intval( get_option( 'theme_number_of_properties', 6 ) );
				if ( 0 >= $number_of_properties ) {
					$number_of_properties = 6;
				}
				$map_properties_query_args['posts_per_page'] = $number_of_properties;
			}
		}

		$map_properties_query = new WP_Query( $map_properties_query_args );
		$properties_map_data  = array();
		$propertiesMapOptions = array();

		if ( $map_properties_query->have_posts() ) {
			while ( $map_properties_query->have_posts() ) {
				$map_properties_query->the_post();

				$current_property_data = array();
				$current_property_data[ 'title' ] = get_the_title();

				if ( function_exists('ere_get_property_price') ) {
					$current_property_data[ 'price' ] = ere_get_property_price();
				} else {
					$current_property_data[ 'price' ] = null;
				}

				$current_property_data[ 'url' ] = get_permalink();
				$current_property_data[ 'id' ] = get_the_ID();

				// property location
				$property_location = get_post_meta( get_the_ID(), 'REAL_HOMES_property_location', true );
				if ( ! empty( $property_location ) ) {
					$lat_lng = explode( ',', $property_location );
					$current_property_data[ 'lat' ] = $lat_lng[ 0 ];
					$current_property_data[ 'lng' ] = $lat_lng[ 1 ];
				}

				// property thumbnail
				if ( has_post_thumbnail() ) {
					$image_id         = get_post_thumbnail_id();
					$image_attributes = wp_get_attachment_image_src( $image_id, 'property-thumb-image' );
					if ( ! empty( $image_attributes[ 0 ] ) ) {
						$current_property_data[ 'thumb' ] = $image_attributes[ 0 ];
					}
				}else{
					$current_property_data[ 'thumb' ] = get_inspiry_image_placeholder_url( 'property-thumb-image' );
				}

				// Property map icon based on Property Type
				$type_terms = get_the_terms( get_the_ID(), 'property-type' );
				if ( $type_terms && ! is_wp_error( $type_terms ) ) {
					foreach ( $type_terms as $type_term ) {
						$icon_id = get_term_meta( $type_term->term_id, 'inspiry_property_type_icon', true );
						if ( ! empty ( $icon_id ) ) {
							$icon_url = wp_get_attachment_url( $icon_id );
							if ( $icon_url ) {
								$current_property_data[ 'icon' ] = esc_url( $icon_url );

								// Retina icon
								$retina_icon_id = get_term_meta( $type_term->term_id, 'inspiry_property_type_icon_retina', true );
								if ( ! empty ( $retina_icon_id ) ) {
									$retina_icon_url = wp_get_attachment_url( $retina_icon_id );
									if ( $retina_icon_url ) {
										$current_property_data[ 'retinaIcon' ] = esc_url( $retina_icon_url );
									}
								}
								break;
							}
						}
					}
				}

				// Set default icons if above code fails to sets any
				if ( ! isset( $current_property_data[ 'icon' ] ) ) {
					$current_property_data[ 'icon' ]       = INSPIRY_DIR_URI . '/images/map/single-family-home-map-icon.png';     // default icon
					$current_property_data[ 'retinaIcon' ] = INSPIRY_DIR_URI . '/images/map/single-family-home-map-icon@2x.png';  // default retina icon
				}

				$properties_map_data[] = $current_property_data;

			}
			wp_reset_postdata();
		}

		// Fallback Location
		$fallback_location = get_option( 'inspiry_properties_map_default_location', '27.664827,-81.515755' );
		if ( ! empty( $fallback_location ) ) {
			$lat_lng                                         = explode( ',', $fallback_location );
			$propertiesMapOptions['fallback_location']['lat'] = $lat_lng[0];
			$propertiesMapOptions['fallback_location']['lng'] = $lat_lng[1];
		}

		// Setting the map marker type and related data.
		$propertiesMapOptions['marker_type']  = get_option( 'inspiry_property_map_marker_type', 'pin' );
		$propertiesMapOptions['marker_color'] = get_option( 'inspiry_property_map_marker_color', '#ea723d' );

		wp_localize_script( 'properties-open-street-map', 'propertiesMapData', $properties_map_data );
		wp_localize_script( 'properties-open-street-map', 'propertiesMapOptions', $propertiesMapOptions );
		wp_enqueue_script( 'properties-open-street-map' );

	}
endif;


if ( ! function_exists( 'inspiry_render_property_open_street_map' ) ) :
	/**
	 * Render open street map for single property
	 */
	function inspiry_render_property_open_street_map() {

		wp_register_script( 'property-open-street-map', get_theme_file_uri( 'assets/' . INSPIRY_DESIGN_VARIATION . '/scripts/js/property-open-street-map.js' ), array( 'jquery', 'leaflet' ), INSPIRY_THEME_VERSION, true );

		$property_location = get_post_meta( get_the_ID(), 'REAL_HOMES_property_location', true );
		$property_address  = get_post_meta( get_the_ID(), 'REAL_HOMES_property_address', true );
		$property_map      = get_post_meta( get_the_ID(), 'REAL_HOMES_property_map', true );

		if ( $property_address && ! empty( $property_location ) && ( 1 != $property_map ) ) {

			$property_map_data            = array();
			$property_map_data[ 'title' ] = get_the_title();

			if ( function_exists('ere_get_property_price') ) {
				$property_map_data[ 'price' ] = ere_get_property_price();
			} else {
				$property_map_data[ 'price' ] = null;
			}

			// Property Latitude and Longitude
			$lat_lng                     = explode( ',', $property_location );
			$property_map_data[ 'lat' ]  = $lat_lng[ 0 ];
			$property_map_data[ 'lng' ] = $lat_lng[ 1 ];

			// Property thumbnail
			if ( has_post_thumbnail() ) {
				$image_id         = get_post_thumbnail_id();
				$image_attributes = wp_get_attachment_image_src( $image_id, 'property-thumb-image' );
				if ( ! empty( $image_attributes[ 0 ] ) ) {
					$property_map_data[ 'thumb' ] = $image_attributes[ 0 ];
				}
			}else{
				$property_map_data[ 'thumb' ] = get_inspiry_image_placeholder_url( 'property-thumb-image' );
			}

			// Property map icon based on Property Type
			$type_terms = get_the_terms( get_the_ID(), 'property-type' );
			if ( $type_terms && ! is_wp_error( $type_terms ) ) {
				foreach ( $type_terms as $type_term ) {
					$icon_id = get_term_meta( $type_term->term_id, 'inspiry_property_type_icon', true );
					if ( ! empty ( $icon_id ) ) {
						$icon_url = wp_get_attachment_url( $icon_id );
						if ( $icon_url ) {
							$property_map_data[ 'icon' ] = esc_url( $icon_url );

							// Retina icon
							$retina_icon_id = get_term_meta( $type_term->term_id, 'inspiry_property_type_icon_retina', true );
							if ( ! empty ( $retina_icon_id ) ) {
								$retina_icon_url = wp_get_attachment_url( $retina_icon_id );
								if ( $retina_icon_url ) {
									$property_map_data[ 'retinaIcon' ] = esc_url( $retina_icon_url );
								}
							}
							break;
						}
					}
				}
			}

			// Set default icons if above code fails to sets any
			if ( ! isset( $property_map_data[ 'icon' ] ) ) {
				$property_map_data[ 'icon' ]       = INSPIRY_DIR_URI . '/images/map/single-family-home-map-icon.png';           // default icon
				$property_map_data[ 'retinaIcon' ] = INSPIRY_DIR_URI . '/images/map/single-family-home-map-icon@2x.png';  // default retina icon
			}

			// Set Google Map Type & Zoom Level
			$property_map_data['zoom'] = get_option( 'inspiry_property_map_zoom', '15' );
			$property_map_data['marker_type']  = get_option( 'inspiry_property_map_marker_type', 'pin' );
			$property_map_data['marker_color'] = get_option( 'inspiry_property_map_marker_color', '#ea723d' );

			wp_localize_script( 'property-open-street-map', 'propertyMapData', $property_map_data );
			wp_enqueue_script( 'property-open-street-map' );

		}

	}

endif;