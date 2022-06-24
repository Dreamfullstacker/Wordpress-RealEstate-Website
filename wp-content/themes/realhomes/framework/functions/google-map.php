<?php
/**
 * Contains Enqueue and Render functions related to Google Map
 */

if ( ! function_exists( 'inspiry_enqueue_google_map_clusterer_spiderfier' ) ) :
	/**
	 * Enqueue Google Map Clusterer and Spiderfier scripts
	 * This function is created for re-usability.
	 */
	function inspiry_enqueue_google_map_clusterer_spiderfier() {


		// Google map marker clusters
		wp_enqueue_script(
			'google-map-marker-clusterer',
			get_theme_file_uri( 'common/js/vendors/markerclusterer.js' ),
			array( 'google-map-api' ),
			'2.1.1',
			true
		);

		// https://github.com/jawj/OverlappingMarkerSpiderfier
		wp_enqueue_script(
			'google-map-oms',
			get_theme_file_uri( 'common/js/vendors/oms.min.js' ),
			array( 'google-map-api' ),
			'0.3.3',
			true
		);

	}
endif;


if ( ! function_exists( 'inspiry_enqueue_google_map_info_box' ) ) :
	/**
	 * Enqueue Google Map Info Box script.
	 * This function is created for re-usability.
	 */
	function inspiry_enqueue_google_map_info_box() {

		// Google Map Info Box API.
		wp_enqueue_script(
			'google-map-info-box',
			get_theme_file_uri( 'common/js/vendors/infobox.js' ),
			array( 'google-map-api' ),
			'1.1.9',
			true
		);

	}
endif;


if ( ! function_exists( 'inspiry_enqueue_google_maps' ) ) {
	/**
	 * Enqueue Google Maps Scripts
	 */
	function inspiry_enqueue_google_maps() {
		if ( inspiry_is_map_needed() ) {

			// default map query arguments
			$google_map_arguments = array();

			// Google Map API.
			wp_enqueue_script(
				'google-map-api',
				esc_url_raw(
					add_query_arg(
						apply_filters(
							'inspiry_google_map_arguments',
							$google_map_arguments
						),
						'//maps.google.com/maps/api/js'
					)
				),
				array(),
				false,
				true
			);

			// Now we need to load JS files and Localized data based on the page visitor is on.
			if ( is_singular( 'property' ) && ( 'true' == get_option( 'theme_display_google_map' ) ) ) {

				inspiry_enqueue_google_map_info_box();
				inspiry_render_property_google_map();

			} elseif ( is_page_template( 'templates/contact.php' ) && ( '1' == get_post_meta( get_the_ID(), 'theme_show_contact_map', true ) ) ) {

				inspiry_render_contact_google_map();

			} elseif ( is_page_template( array( 'templates/submit-property.php', 'templates/dashboard.php' ) ) ) {

				$file = 'assets/' . INSPIRY_DESIGN_VARIATION . '/scripts/js/submit-google-map.js';
				if ( is_page_template( 'templates/dashboard.php' ) ) {
					$file = 'common/js/submit-google-map.js';
				}

				// Directly enqueued script as no additional data passing was required.
				wp_enqueue_script(
					'submit-google-map',
					get_theme_file_uri( $file ),
					array( 'jquery', 'google-map-api' ),
					INSPIRY_THEME_VERSION,
					true
				);

			} elseif ( is_page_template( 'templates/half-map-layout.php' ) ) {

				inspiry_enqueue_google_map_info_box();
				inspiry_enqueue_google_map_clusterer_spiderfier();
				inspiry_render_multi_properties_google_map();

			} elseif ( is_page_template( 'templates/home.php' ) ) {
				$theme_homepage_module = get_post_meta( get_the_ID(), 'theme_homepage_module', true );
				if ( isset( $_GET['module'] ) ) {
					$theme_homepage_module = $_GET['module'];
				}
				if ( 'properties-map' == $theme_homepage_module ) {
					inspiry_enqueue_google_map_info_box();
					inspiry_enqueue_google_map_clusterer_spiderfier();
					inspiry_render_multi_properties_google_map();
				}

			} elseif ( is_page_template( array('templates/properties-search.php', 'templates/properties-search-half-map.php', 'templates/half-map-layout.php', 'templates/properties-search-left-sidebar.php', 'templates/properties-search-right-sidebar.php') ) ) {
				$theme_search_module = get_option( 'theme_search_module', 'properties-map' );
				if ( 'modern' === INSPIRY_DESIGN_VARIATION && ( inspiry_is_search_page_map_visible() || is_page_template( 'templates/properties-search-half-map.php' ) ) ) {

					inspiry_enqueue_google_map_info_box();
					inspiry_enqueue_google_map_clusterer_spiderfier();
					inspiry_render_multi_properties_google_map();

				} elseif ( 'classic' === INSPIRY_DESIGN_VARIATION && ( 'properties-map' == $theme_search_module || is_page_template( 'templates/properties-search-half-map.php' ) ) ) {

					inspiry_enqueue_google_map_info_box();
					inspiry_enqueue_google_map_clusterer_spiderfier();
					inspiry_render_multi_properties_google_map();

				}

			} elseif ( is_page_template( array( 'templates/list-layout.php', 'templates/grid-layout.php', 'templates/list-layout-full-width.php', 'templates/grid-layout-full-width.php' ) ) ||
			           is_tax( 'property-city' ) || is_tax( 'property-status' ) || is_tax( 'property-type' ) || is_tax( 'property-feature' ) ||
			           is_post_type_archive( 'property' ) ) {

				$theme_listing_module = get_option( 'theme_listing_module' );
				if ( isset( $_GET['module'] ) ) {
					$theme_listing_module = $_GET['module'];
				}

				if ( $theme_listing_module == 'properties-map' ) {
					inspiry_enqueue_google_map_info_box();
					inspiry_enqueue_google_map_clusterer_spiderfier();
					inspiry_render_multi_properties_google_map();
				}
			}
		}
	}
}


if( !function_exists( 'inspiry_render_multi_properties_google_map' ) ) :
	/**
	 * Render google map for multiple properties
	 */
	function inspiry_render_multi_properties_google_map() {

		wp_register_script( 'properties-google-map', get_theme_file_uri( 'assets/' . INSPIRY_DESIGN_VARIATION . '/scripts/js/properties-google-map.js' ), array(
			'jquery',
			'google-map-api'
		), INSPIRY_THEME_VERSION, true );

		$map_stuff                 = array();
		$properties_map_options    = array();
		$map_properties_query_args = array(
			'post_type'      => 'property',
			'posts_per_page' => apply_filters( 'real_homes_properties_on_map', 500 ),
			// used 500 instead of -1 to get only a reasonable number of properties
			'meta_query'     => array(
				array(
					'key'     => 'REAL_HOMES_property_address',
					'compare' => 'EXISTS',
				),
			),
		);

		if ( is_page_template( array(
			'templates/properties-search.php',
			'templates/properties-search-half-map.php',
			'templates/properties-search-left-sidebar.php',
			'templates/properties-search-right-sidebar.php'
		) ) ) {

			// Apply Search Filter
			$map_properties_query_args = apply_filters( 'real_homes_search_parameters', $map_properties_query_args );

			// Override number of properties for search results map
			$properties_on_search_map = get_option( 'inspiry_properties_on_search_map', 'all' );
			if ( 'all' == $properties_on_search_map ) {
				$map_properties_query_args['posts_per_page'] = - 1;
			}

			$properties_map_options['type'] = get_option( 'inspiry_search_map_type', 'roadmap' );


		} elseif ( is_page_template( 'templates/home.php' ) ) {

			$map_stuff['modernHome'] = true;

			// Apply Homepage Properties Filter
			$map_properties_query_args = apply_filters( 'real_homes_homepage_properties', $map_properties_query_args );

			$properties_map_options['type'] = get_post_meta( get_the_ID(), 'inspiry_home_map_type', true );

		} elseif ( is_page_template( array(
			'templates/list-layout.php',
			'templates/list-layout-full-width.php',
			'templates/grid-layout.php',
			'templates/grid-layout-full-width.php',
			'templates/half-map-layout.php'
		) ) ) {
			
			// Override number of properties for listing page map
			$properties_on_listing_map = get_option( 'inspiry_properties_list_tax_on_map', 'all' );
			if ( 'all' == $properties_on_listing_map ) {
				$map_properties_query_args['posts_per_page'] = - 1;
			}

			// Apply properties filter settings from properties list templates.
			$map_properties_query_args = apply_filters( 'inspiry_properties_filter', $map_properties_query_args );
			
			// Apply sorting.
			$map_properties_query_args = sort_properties( $map_properties_query_args );

			$properties_map_options['type'] = get_option( 'inspiry_list_tax_map_type', 'roadmap' );

		} elseif ( is_tax() ) {

			global $wp_query;
			$map_properties_query_args['tax_query'] = array(
				array(
					'taxonomy' => $wp_query->query_vars['taxonomy'],
					'field'    => 'slug',
					'terms'    => $wp_query->query_vars['term'],
				),
			);

			// Override number of properties for taxonomy page map
			$properties_on_tax_map = get_option( 'inspiry_properties_list_tax_on_map', 'all' );
			if ( 'all' == $properties_on_tax_map ) {
				$number_of_properties = - 1;
			} else {
				// number of properties per page
				$number_of_properties = intval( get_option( 'theme_number_of_properties', 6 ) );
				if ( 0 >= $number_of_properties ) {
					$number_of_properties = 6;
				}
			}

			$map_properties_query_args['posts_per_page'] = $number_of_properties;

			// for pagination
			global $paged;
			$map_properties_query_args['paged'] = $paged;

			$properties_map_options['type'] = get_option( 'inspiry_list_tax_map_type', 'roadmap' );

		} elseif ( is_post_type_archive( 'property' ) ) {

			// Override number of properties for property archive page map
			$properties_on_archive_map = get_option( 'inspiry_properties_list_tax_on_map', 'all' );
			if ( 'all' == $properties_on_archive_map ) {
				$number_of_properties = - 1;
			} else {
				// number of properties per page
				$number_of_properties = intval( get_option( 'theme_number_of_properties', 6 ) );
				if ( 0 >= $number_of_properties ) {
					$number_of_properties = 6;
				}
			}

			$map_properties_query_args['posts_per_page'] = $number_of_properties;

			// for pagination
			global $paged;
			$map_properties_query_args['paged'] = $paged;

			$properties_map_options['type'] = get_option( 'inspiry_list_tax_map_type', 'roadmap' );
		}

		$map_properties_query = new WP_Query( $map_properties_query_args );
		$properties_map_data  = array();


		// if ( is_page_template( array( 'templates/half-map-layout.php' ) ) ) {
		// 	$properties_on_listing_map = get_option( 'inspiry_properties_list_tax_on_map', 'all' );

		// 	if ( 'all' == $properties_on_listing_map ) {

		// 		$theme_number_of_properties = get_option( 'theme_number_of_properties', 6 );
		// 		$number_of_properties       = get_post_meta( get_the_ID(), 'inspiry_posts_per_page', true );

		// 		if ( $number_of_properties ) {
		// 			$gm_post_per_page = $number_of_properties;
		// 		} elseif ( ! empty( $theme_number_of_properties ) ) {
		// 			$gm_post_per_page = $theme_number_of_properties;
		// 		} else {
		// 			$gm_post_per_page = 6;
		// 		}
		// 		if ( $map_properties_query->query['paged'] > 1 ) {
		// 			$get_previous_posts['previous-posts'] = $gm_post_per_page * ( $map_properties_query->query['paged'] - 1 );
		// 			wp_localize_script( 'properties-google-map', 'previousProperties', $get_previous_posts );
		// 		}

		// 	}
		// }


		// if ( is_page_template( array( 'templates/properties-search-half-map.php', ) ) ) {
		// 	$properties_on_search_map = get_option( 'inspiry_properties_on_search_map', 'all' );
		// 	if ( 'all' == $properties_on_search_map ) {

		// 		$theme_number_of_properties = get_option( 'theme_properties_on_search', 6 );

		// 		if ( ! empty( $theme_number_of_properties ) ) {
		// 			$gm_post_per_page = $theme_number_of_properties;
		// 		} else {
		// 			$gm_post_per_page = 6;
		// 		}
		// 		if ( $map_properties_query->query['paged'] > 1 ) {
		// 			$get_previous_posts['previous-posts'] = $gm_post_per_page * ( $map_properties_query->query['paged'] - 1 );
		// 			wp_localize_script( 'properties-google-map', 'previousProperties', $get_previous_posts );
		// 		}

		// 	}
		// }

		if ( $map_properties_query->have_posts() ) {
			while ( $map_properties_query->have_posts() ) {
				$map_properties_query->the_post();

				$current_property_data = array();
				$current_property_data[ 'title' ] = get_the_title();
				$current_property_data[ 'id' ] = get_the_ID();

				if ( function_exists('ere_get_property_price') ) {
					$current_property_data[ 'price' ] = ere_get_property_price();
				} else {
					$current_property_data[ 'price' ] = null;
				}

				$current_property_data[ 'url' ] = get_permalink();

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
					$current_property_data[ 'icon' ]       = INSPIRY_DIR_URI . '/images/map/single-family-home-map-icon.png';           // default icon
					$current_property_data[ 'retinaIcon' ] = INSPIRY_DIR_URI . '/images/map/single-family-home-map-icon@2x.png';  // default retina icon
				}

				$properties_map_data[] = $current_property_data;

			}
			wp_reset_postdata();
		}

		// Map Styles
		$styles_json = get_option( 'inspiry_google_maps_styles' );
		if ( ! empty( $styles_json ) ) {
			$properties_map_options['styles'] = stripslashes( $styles_json );
		}

		// Fallback Location
		$fallback_location = get_option( 'inspiry_properties_map_default_location', '27.664827,-81.515755' );
		if ( ! empty( $fallback_location ) ) {
			$lat_lng                                            = explode( ',', $fallback_location );
			$properties_map_options['fallback_location']['lat'] = $lat_lng[0];
			$properties_map_options['fallback_location']['lng'] = $lat_lng[1];
		}

		// Setting the map marker type and related data.
		$properties_map_options['marker_type']  = get_option( 'inspiry_property_map_marker_type', 'pin' );
		$properties_map_options['marker_color'] = get_option( 'inspiry_property_map_marker_color', '#ea723d' );

		wp_localize_script( 'properties-google-map', 'propertiesMapData', $properties_map_data );
		wp_localize_script( 'properties-google-map', 'propertiesMapOptions', $properties_map_options );

		$map_stuff['closeIcon'] = INSPIRY_DIR_URI . '/images/map/close.png';
		$map_stuff['clusterIcon'] = INSPIRY_DIR_URI . '/images/map/cluster-icon.png';
		$map_stuff['infoBoxPlaceholder'] = get_inspiry_image_placeholder_url( 'property-thumb-image' );
		wp_localize_script( 'properties-google-map', 'mapStuff', $map_stuff );

		wp_enqueue_script( 'properties-google-map' );

	}
endif;


if ( ! function_exists( 'inspiry_render_contact_google_map' ) ) :
	/**
	 * Render google map for contact page
	 */
	function inspiry_render_contact_google_map() {

		wp_register_script( 'contact-google-map', get_theme_file_uri( 'assets/' . INSPIRY_DESIGN_VARIATION . '/scripts/js/contact-google-map.js' ), array(
			'jquery',
			'google-map-api'
		), INSPIRY_THEME_VERSION, true );

		$contact_page_meta = get_post_custom( get_the_ID() );
		$contact_map_lat   = isset( $contact_page_meta['theme_map_lati'] ) ? $contact_page_meta['theme_map_lati'][0] : '';
		$contact_map_lang  = isset( $contact_page_meta['theme_map_longi'] ) ? $contact_page_meta['theme_map_longi'][0] : '';

		if ( $contact_map_lat && $contact_map_lang ) {

			$contact_map_data = array();

			$contact_map_data['lat'] = $contact_map_lat;
			$contact_map_data['lng'] = $contact_map_lang;

			$map_zoom = intval( isset( $contact_page_meta['theme_map_zoom'] ) ? $contact_page_meta['theme_map_zoom'][0] : '' );
			if ( 0 < $map_zoom ) {
				$contact_map_data['zoom'] = $map_zoom;
			} else {
				$contact_map_data['zoom'] = 14;
			}

			$contact_map_data['type']    = isset( $contact_page_meta['inspiry_contact_map_type'] ) ? $contact_page_meta['inspiry_contact_map_type'][0] : 'roadmap';
			$contact_map_data['iconURL'] = INSPIRY_DIR_URI . '/images/map-marker.png';

			// Custom Google Maps Marker
			$custom_icon_id = isset( $contact_page_meta['inspiry_contact_map_icon'] ) ? $contact_page_meta['inspiry_contact_map_icon'][0] : '';
			if ( ! empty( $custom_icon_id ) ) {
				$custom_icon                 = wp_get_attachment_url( $custom_icon_id );
				$contact_map_data['iconURL'] = esc_url( $custom_icon );
			}

			// Map Styles
			$styles_json = get_option( 'inspiry_google_maps_styles' );
			if ( ! empty( $styles_json ) ) {
				$contact_map_data['styles'] = stripslashes( $styles_json );
			}

			$contact_map_data['mapWaterColor']  = get_option( 'theme_core_mod_color_green', '#1ea69a' );

			wp_localize_script( 'contact-google-map', 'contactMapData', $contact_map_data );
			wp_enqueue_script( 'contact-google-map' );
		}
	}

endif;


if ( ! function_exists( 'inspiry_render_property_google_map' ) ) :
	/**
	 * Render Google map for single property
	 */
	function inspiry_render_property_google_map() {

		wp_register_script( 'property-google-map', get_theme_file_uri( 'assets/' . INSPIRY_DESIGN_VARIATION . '/scripts/js/property-google-map.js' ), array( 'jquery', 'google-map-api' ), INSPIRY_THEME_VERSION, true );

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

			// Map Styles
			$styles_json = get_option( 'inspiry_google_maps_styles' );
			if ( ! empty( $styles_json ) ) {
				$property_map_data['styles'] = stripslashes( $styles_json );
			}

			// Set Google Map Type & Zoom Level.
			$property_map_data['zoom']         = get_option( 'inspiry_property_map_zoom', '15' );
			$property_map_data['type']         = get_option( 'inspiry_property_map_type', 'roadmap' );
			$property_map_data['marker_type']  = get_option( 'inspiry_property_map_marker_type', 'pin' );
			$property_map_data['marker_color'] = get_option( 'inspiry_property_map_marker_color', '#ea723d' );

			wp_localize_script( 'property-google-map', 'propertyMapData', $property_map_data );

			$map_stuff = array();
			$map_stuff['closeIcon'] = INSPIRY_DIR_URI . '/images/map/close.png';
			wp_localize_script( 'property-google-map', 'mapStuff', $map_stuff );

			wp_enqueue_script( 'property-google-map' );

		}

	}

endif;
