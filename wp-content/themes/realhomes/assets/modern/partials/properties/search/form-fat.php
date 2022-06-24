<?php
/**
 * Properties Search Form
 *
 * @package    realhomes
 * @subpackage modern
 */

if ( inspiry_is_search_fields_configured() ) :
	$theme_search_fields = inspiry_get_search_fields();
	$theme_top_row_fields = get_option( 'inspiry_search_fields_main_row', '4' );

//	$location_select_counter = inspiry_get_locations_number();

	?>

	<form class="rh_prop_search__form rh_prop_search_form_header advance-search-form"
	      action="<?php echo esc_url( inspiry_get_search_page_url() ); ?>" method="get">

		<div class="rh_prop_search__fields">

			<?php

			if ( ! empty( $theme_search_fields ) && is_array( $theme_search_fields ) ) {

				echo '<div class="rh_prop_search__wrap" id="rh_fields_search__wrapper" data-top-bar="'.$theme_top_row_fields.'">';

				foreach ( $theme_search_fields as $field ) {

					get_template_part( 'assets/modern/partials/properties/search/fields/' . $field );

				}
				echo '</div>';

			}
			$feature_search_option = get_option( 'inspiry_search_fields_feature_search', 'true' );

			if ( ! empty( $feature_search_option ) && $feature_search_option == 'true' ) {
				get_template_part( 'assets/modern/partials/properties/search/fields/property-features' );
			}

			?>


		</div>
		<!-- /.rh_prop_search__fields -->

		<div class="rh_prop_search__buttons">
			<?php
			/**
			 * Search Button
			 */
			get_template_part( 'assets/modern/partials/properties/search/fields/button' );
			?>
		</div>
		<!-- /.rh_prop_search__buttons -->

	</form>
	<!-- /.rh_prop_search__form -->

<?php
endif;
