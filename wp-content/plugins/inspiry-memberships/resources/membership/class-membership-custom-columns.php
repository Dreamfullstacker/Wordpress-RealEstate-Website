<?php
/**
 * Custom Columns for `Membership` Post Type
 *
 * Creates and manages custom columns for `Membership` post type.
 *
 * @since   1.0.0
 * @package IMS
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'IMS_Membership_Custom_Columns' ) ) :
	/**
	 * Control custom columns for the membership post type.
	 *
	 * This class creates and manages custom columns for `Membership` post type.
	 *
	 * @since 1.0.0
	 */
	class IMS_Membership_Custom_Columns {

		/**
		 * Register custom columns for the membership post type.
		 *
		 * @since 1.0.0
		 * @param array $columns Existing columns names.
		 */
		public function register_columns( $columns ) {

			$columns = apply_filters(
				'ims_membership_custom_column_name',
				array(
					'cb'         => '<input type="checkbox" />',
					'title'      => esc_html__( 'Membership Title', 'inspiry-memberships' ),
					'properties' => esc_html__( 'Allowed Properties', 'inspiry-memberships' ),
					'featured'   => esc_html__( 'Featured Properties', 'inspiry-memberships' ),
					'price'      => esc_html__( 'Price', 'inspiry-memberships' ),
					'duration'   => esc_html__( 'Billing Period', 'inspiry-memberships' ),
				)
			);

			/**
			 * Reverse the array for RTL
			 */
			if ( is_rtl() ) {
				$columns = array_reverse( $columns );
			}

			return $columns;

		}

		/**
		 * Display column values for the custom columns of membership post type.
		 *
		 * @since 1.0.0
		 * @param string $column Current column name.
		 */
		public function display_column_values( $column ) {

			global $post;

			// Meta data prefix.
			$prefix = apply_filters( 'ims_membership_meta_prefix', 'ims_membership_' );

			switch ( $column ) {

				case 'properties':
					$properties = get_post_meta( $post->ID, "{$prefix}allowed_properties", true );
					if ( ! empty( $properties ) ) {
						echo esc_html( $properties );
					} else {
						esc_html_e( 'Not Available', 'inspiry-memberships' );
					}
					break;

				case 'featured':
					$featured = get_post_meta( $post->ID, "{$prefix}featured_properties", true );
					if ( ! empty( $featured ) ) {
						echo esc_html( $featured );
					} else {
						esc_html_e( 'Not Available', 'inspiry-memberships' );
					}
					break;

				case 'price':
					$currency_settings = get_option( 'ims_basic_settings' );
					$price             = get_post_meta( $post->ID, "{$prefix}price", true );
					$currency_position = $currency_settings['ims_currency_position'];
					$formatted_price   = '';
					if ( 'after' === $currency_position ) {
						$formatted_price = $price . $currency_settings['ims_currency_symbol'];
					} else {
						$formatted_price = $currency_settings['ims_currency_symbol'] . $price;
					}
					if ( ! empty( $price ) ) {
						echo esc_html( $formatted_price );
					} else {
						esc_html_e( 'Free', 'inspiry-memberships' );
					}
					break;

				case 'duration':
					$duration      = get_post_meta( $post->ID, "{$prefix}duration", true );
					$duration_unit = get_post_meta( $post->ID, "{$prefix}duration_unit", true );
					if ( ! empty( $duration ) && ( $duration > 1 ) ) {
						echo esc_html( $duration . ' ' . $duration_unit );
					} elseif ( ! empty( $duration ) && ( $duration == 1 ) ) {
						echo esc_html( $duration . ' ' . rtrim( $duration_unit, 's' ) );
					} else {
						esc_html_e( 'Not Available', 'inspiry-memberships' );
					}
					break;

				default:
					break;

			}

		}

	}

endif;
