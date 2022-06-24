<?php
/**
 * RVR - Properties Search Form
 *
 * @package    realhomes
 * @subpackage modern
 */

$theme_search_fields = inspiry_get_search_fields();
if ( ! empty( $theme_search_fields ) && is_array( $theme_search_fields ) ) {
	?>
	<form class="rh_prop_search__form rh_prop_search_form_header advance-search-form rvr-search-form" action="<?php echo esc_url( inspiry_get_search_page_url() ); ?>" method="get">
		<div class="rh_prop_search__fields">

			<div class="rh_prop_search__wrap rh_prop_search_data" id="rh_fields_search__wrapper" data-top-bar="4">
				<div class="rh_form_fat_top_fields rh_search_top_field_common">
					<?php
					foreach ( $theme_search_fields as $field ) {
						if ( 'location' === $field ) {
							$field = '../' . $field;
						}
						get_template_part( 'assets/modern/partials/properties/search/fields/rvr/' . $field );
					}

					/**
					 * Additional Search Fields
					 */
					do_action( 'inspiry_additional_search_fields' );
					?>
				</div>
			</div>
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
}
?>
