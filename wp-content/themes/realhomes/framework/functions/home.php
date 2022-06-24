<?php
/**
 * Functions related to homepage
 *
 * @package realhomes/functions
 */

if ( ! function_exists( 'selection_based_properties' ) ) {
	/**
	 * Homepage Properties Based on Selection
	 *
	 * @param $properties_args
	 * @return mixed
	 */
	function selection_based_properties( $properties_args ) {

		$types_for_homepage    = get_post_meta( get_the_ID(), 'theme_types_for_homepage' );
		$statuses_for_homepage = get_post_meta( get_the_ID(), 'theme_statuses_for_homepage' );
		$cities_for_homepage   = get_post_meta( get_the_ID(), 'theme_cities_for_homepage' );

		$tax_query = array();

		if ( is_array( $types_for_homepage ) ) {
			$types_for_homepage = array_filter( $types_for_homepage );
			if ( ! empty( $types_for_homepage ) ) {
				$tax_query[] = array(
					'taxonomy' => 'property-type',
					'field' => 'slug',
					'terms' => $types_for_homepage
				);
			}
		}

		if ( is_array( $statuses_for_homepage ) ) {
			$statuses_for_homepage = array_filter( $statuses_for_homepage );
			if ( ! empty( $statuses_for_homepage ) ) {
				$tax_query[] = array(
					'taxonomy' => 'property-status',
					'field' => 'slug',
					'terms' => $statuses_for_homepage
				);
			}
		}

		if ( is_array( $cities_for_homepage ) ) {
			$cities_for_homepage = array_filter( $cities_for_homepage );
			if ( ! empty( $cities_for_homepage ) ) {
				$tax_query[] = array(
					'taxonomy' => 'property-city',
					'field' => 'slug',
					'terms' => $cities_for_homepage
				);
			}
		}

		$tax_count = count( $tax_query );   // count number of taxonomies
		if ( $tax_count > 1 ) {
			$tax_query[ 'relation' ] = 'AND';  // add OR relation if more than one
		}

		if ( $tax_count > 0 ) {
			$properties_args[ 'tax_query' ] = $tax_query;   // add taxonomies query to home query arguments
		}

		return $properties_args;

	}
}


if ( ! function_exists( 'only_featured_properties' ) ) {
	/**
	 * Featured Properties on Homepage
	 *
	 * @param $properties_args
	 * @return mixed
	 */
	function only_featured_properties( $properties_args ) {

		$properties_args[ 'meta_query' ] = array(
			array(
				'key' => 'REAL_HOMES_featured',
				'value' => 1,
				'compare' => '=',
				'type' => 'NUMERIC'
			) );

		return $properties_args;

	}

	add_filter( 'real_homes_only_featured_properties', 'only_featured_properties' );
}


if ( ! function_exists( 'homepage_properties' ) ) {
	/**
	 * Homepage Properties
	 *
	 * @param $properties_args
	 * @return mixed|void
	 */
	function homepage_properties( $properties_args ) {

		/* Modify home query arguments based on theme options */
		$home_properties = get_post_meta( get_the_ID(), 'theme_home_properties', true );
		if ( ! empty( $home_properties ) && ( $home_properties == 'based-on-selection' ) ) {

			/* Properties Based on Selection from Theme Options */
			$properties_args = selection_based_properties( $properties_args );

		} elseif ( ! empty( $home_properties ) && ( $home_properties == 'featured' ) ) {

			/* Featured Properties on Homepage */
			$properties_args = apply_filters( 'real_homes_only_featured_properties', $properties_args );

		} else {

			/* Exclude Featured Properties If Enabled */
			$featured_properties = get_post_meta( get_the_ID(), 'theme_exclude_featured_properties', true );
			if ( ! empty( $featured_properties ) && $featured_properties == 'true' ) {
				$properties_args[ 'meta_query' ] = array(
					'relation' => 'OR',
					array(
						'key' => 'REAL_HOMES_featured',
						'compare' => 'NOT EXISTS',
					),
					array(
						'key' => 'REAL_HOMES_featured',
						'value' => 0,
						'compare' => '=',
						'type' => 'NUMERIC'
					));
			}

		}

		return $properties_args;

	}

	add_filter( 'real_homes_homepage_properties', 'homepage_properties' );
}


if ( ! function_exists( 'inspiry_modern_home_heading' ) ) {

	/**
	 * Displays the headings on Modern homepage
	 * sections.
	 *
	 * @param string $subtitle - Text Over Title.
	 * @param string $title - Title.
	 * @param string $description - Description text.
	 * @author Ashar Irfan
	 * @since  3.2.0
	 */
	function inspiry_modern_home_heading( $subtitle, $title, $description ) {
		if ( ! empty( $subtitle ) || ! empty( $title ) || ! empty( $description ) ) :
			?>
			<div class="rh_section__head">

				<?php if ( ! empty( $subtitle ) ) : ?>
					<span class="rh_section__subtitle">
						<?php echo esc_html( $subtitle ); ?>
					</span>
					<!-- /.rh_section__subtitle -->
				<?php endif; ?>

				<?php if ( ! empty( $title ) ) : ?>
					<h2 class="rh_section__title">
						<?php echo esc_html( $title ); ?>
					</h2>
					<!-- /.rh_section__title -->
				<?php endif; ?>

				<?php if ( ! empty( $description ) ) : ?>
					<p class="rh_section__desc">
						<?php echo esc_html( $description ); ?>
					</p>
					<!-- /.rh_section__desc -->
				<?php endif; ?>

			</div>
			<!-- /.rh_section__head -->
		<?php endif;
	}
}


if ( ! function_exists( 'inspiry_migrate_home_settings' ) ) {
	/**
	 * Migrate homepage settings from customizer to meta-boxes.
	 *
	 * @param $page_id
	 */
	function inspiry_migrate_home_settings( $page_id ) {

		$home_migrated  = get_option( 'inspiry_home_settings_migration', 'false' );
		$sections_order = get_post_meta( $page_id, 'inspiry_home_sections_order_default', true );

		// Check if home settings are not migrated yet then proceed with the migration process.
		if ( 'true' != $home_migrated && '' == $sections_order ) {

			$customizer_data = array();
			$settings_fields = array(

				/**
				 * Sections Manager
				 */
				'inspiry_home_sections_order_default',
				'inspiry_home_sections_order',
				'inspiry_home_sections_order_mod',

				/**
				 * Slider Area
				 */
				'theme_homepage_module',
				'theme_number_of_slides',
				'inspiry_home_search_bg_img',
				'inspiry_home_search_bg_video',
				'inspiry_SFOI_overlay_color',
				'inspiry_SFOI_overlay_opacity',
				'inspiry_SFOI_title',
				'inspiry_SFOI_title_color',
				'inspiry_SFOI_description',
				'inspiry_SFOI_description_color',
				'inspiry_home_map_type',
				'theme_rev_alias',
				'theme_number_custom_slides',

				/**
				 * Search Form
				 */
				'theme_show_home_search',

				/**
				 * Slogan
				 */
				'inspiry_enable_search_label_image',
				'inspiry_search_label_text',

				/**
				 * Search Form
				 */
				'theme_show_home_contents',

				/**
				 * Home Properties
				 */
				'theme_slogan_title',
				'theme_slogan_text',
				'theme_show_home_properties',
				'inspiry_home_properties_sub_title',
				'inspiry_home_properties_title',
				'inspiry_home_properties_desc',
				'theme_home_properties',
				'theme_cities_for_homepage',
				'theme_statuses_for_homepage',
				'theme_types_for_homepage',
				'theme_sorty_by',
				'theme_properties_on_home',
				'inspiry_home_skip_sticky',
				'theme_ajax_pagination_home',

				/**
				 * Features Section
				 */
				'inspiry_show_features_section',
				'inspiry_features_background_image',
				'inspiry_features_section_title',
				'inspiry_features_section_desc',

				'inspiry_show_home_features',
				'inspiry_home_features_sub_title',
				'inspiry_home_features_title',
				'inspiry_home_features_desc',

				/**
				 * Featured Properties
				 */
				'theme_show_featured_properties',
				'inspiry_featured_prop_sub_title',
				'theme_featured_prop_title',
				'theme_featured_prop_text',
				'theme_exclude_featured_properties',
				'inspiry_featured_properties_exclude_status',
				'inspiry_featured_properties_variation',

				/**
				 * Testimonial
				 */
				'inspiry_show_testimonial',
				'inspiry_testimonial_text',
				'inspiry_testimonial_name',
				'inspiry_testimonial_url',

				/**
				 * Call to Action
				 */
				'inspiry_show_cta',
				'inspiry_cta_background_image',
				'inspiry_cta_title',
				'inspiry_cta_desc',
				'inspiry_cta_btn_one_title',
				'inspiry_cta_btn_one_url',
				'inspiry_cta_btn_two_title',
				'inspiry_cta_btn_two_url',

				/**
				 * Agents
				 */
				'inspiry_show_agents',
				'inspiry_home_agents_sub_title',
				'inspiry_home_agents_title',
				'inspiry_home_agents_desc',
				'inspiry_agents_on_home',

				/**
				 * Partners
				 */
				'inspiry_show_home_partners',
				'inspiry_home_partners_sub_title',
				'inspiry_home_partners_title',
				'inspiry_home_partners_desc',
				'inpsiry_modern_partners_variation',
				'inspiry_home_partners_to_show',

				/**
				 * News or Blog Posts
				 */
				'theme_show_news_posts',
				'theme_news_posts_title',
				'theme_news_posts_text',
				'inspiry_show_home_news_modern',
				'inspiry_home_news_sub_title',
				'inspiry_home_news_title',
				'inspiry_home_news_desc',

				/**
				 * Call to Action - Contact
				 */
				'inspiry_show_home_cta_contact',
				'inspiry_home_cta_contact_bg_image',
				'inspiry_home_cta_contact_title',
				'inspiry_home_cta_contact_desc',
				'inspiry_cta_contact_btn_one_title',
				'inspiry_cta_contact_btn_one_url',
				'inspiry_cta_contact_btn_two_title',
				'inspiry_cta_contact_btn_two_url',

				/**
				 * General
				 */
				'inspiry_home_sections_border'
			);

			$theme_mod_fields = array(
				'inspiry_home_sections_order_default'
			);

			$checkbox_fields = array(
				'theme_cities_for_homepage',
				'theme_statuses_for_homepage',
				'theme_types_for_homepage',
				'inspiry_home_skip_sticky',
				'inspiry_featured_properties_exclude_status'
			);

			$attachment_fields = array(
				'inspiry_home_search_bg_img',
				'inspiry_features_background_image',
				'inspiry_cta_background_image',
				'inspiry_home_cta_contact_bg_image'
			);

			$default_values = array(
				'inspiry_home_sections_order_default' => 'default',
				'inspiry_search_label_text'           => esc_html__( 'Advance Search', 'framework' ),
			);

			/**
			 * Settings Migration
			 */
			foreach ( $settings_fields as $field ) {

				$default_value = ( isset( $default_values[ $field ] ) ) ? $default_values[ $field ] : '';

				// Get the customizer option value for the current key
				if ( in_array( $field, $theme_mod_fields ) ) {
					$customizer_data[ $field ] = get_theme_mod( $field, $default_value );
				} else {
					$customizer_data[ $field ] = get_option( $field, $default_value );
				}

				if ( isset( $customizer_data[ $field ] ) ) {

					// Retrieve the ID if current field is about an attachment otherwise simple value
					// Note: customizer field save attachment as URL while metabox as attachment ID
					if ( in_array( $field, $attachment_fields ) ) {
						$value = attachment_url_to_postid( $customizer_data[ $field ] );
					} else {
						$value = $customizer_data[ $field ];
					}

					if ( in_array( $field, $checkbox_fields ) ) {

						if ( 'inspiry_featured_properties_exclude_status' == $field ) {

							// Convert IDs based array to array of slugs for the Property Status taxonomy
							if ( is_array( $value ) ) {
								$status_slugs = array();

								foreach ( $value as $status_id ) {
									$status_term = get_term_by( 'term_id', $status_id, 'property-status' );
									if ( is_object( $status_term ) ) {
										$status_slugs[] = $status_term->slug;
									}
								}
								$value = $status_slugs;
							}
						}

						// If current field is a checkbox then remove existing current metabox value first if there is any
						delete_post_meta( $page_id, $field );

						if ( is_array( $value ) ) {
							foreach ( $value as $val ) {
								add_post_meta( $page_id, $field, $val );
							}
						} else {
							add_post_meta( $page_id, $field, $value );
						}

					} else {
						update_post_meta( $page_id, $field, $value );
					}

				}
			}

			/***
			 * Features Settings Migration
			 */
			if ( 'classic' == INSPIRY_DESIGN_VARIATION ) {

				$features_keys = array(
					'first',
					'second',
					'third',
				);

				$features_list  = array();
				$features_count = 0;

				// Gathering features information from customizer fields to $features_list array
				foreach ( $features_keys as $feature_key ) {
					$feature_icon = get_option( 'inspiry_' . $feature_key . '_feature_image' );
					$feature_name = get_option( 'inspiry_' . $feature_key . '_feature_title' );
					$feature_desc = get_option( 'inspiry_' . $feature_key . '_feature_desc' );
					$feature_url  = get_option( 'inspiry_' . $feature_key . '_feature_url' );

					// Retrieve the ID of attached icon image
					$feature_icon = attachment_url_to_postid( $feature_icon );

					$features_list[ $features_count ]['inspiry_feature_icon'] = $feature_icon;
					$features_list[ $features_count ]['inspiry_feature_name'] = $feature_name;
					$features_list[ $features_count ]['inspiry_feature_desc'] = $feature_desc;
					$features_list[ $features_count ]['inspiry_feature_link'] = $feature_url;

					$features_count ++;
				}

				// Adding $features_list array of complete features information to the related metabox field
				update_post_meta( $page_id, 'inspiry_features', $features_list );
			}

			// Flag the homepage settings migration as done!
			update_option( 'inspiry_home_settings_migration', 'true' );
		}

	}

	add_action( 'inspiry_before_home_page_render', 'inspiry_migrate_home_settings' );
}