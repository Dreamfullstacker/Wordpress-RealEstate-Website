<?php
/**
 * Properties search widget form.
 *
 * @package    realhomes
 * @subpackage modern
 */

if ( inspiry_is_search_fields_configured() && inspiry_show_search_form_widget() ) :
	$theme_search_fields = inspiry_get_search_fields();
	?>

	<form class="rh_widget_search__form advance-search-form" action="<?php echo esc_url( inspiry_get_search_page_url() ); ?>" method="get">

		<div class="rh_widget_search__fields">

<?php
if ( ! empty( $theme_search_fields ) && is_array( $theme_search_fields ) ) {


	foreach ( $theme_search_fields as $field ) {

		get_template_part( 'assets/modern/partials/properties/search/fields/' . $field );

	}

	/**
	 * This hook can be used to display more search fields.
	 */
	do_action( 'inspiry_additional_search_fields' );

	$feature_search_option = get_option( 'inspiry_search_fields_feature_search', 'true' );

	if ( ! empty( $feature_search_option ) && $feature_search_option == 'true' ) {
		get_template_part( 'assets/modern/partials/properties/search/fields/property-features' );
	}

}
?>


		</div>
		<!-- /.rh_widget_search__fields -->

		<div class="rh_widget_search__buttons">
			<?php
			/**
			 * Search Button
			 */
			get_template_part( 'assets/modern/partials/properties/search/fields/button' );
			?>
		</div>
		<!-- /.rh_widget_search__buttons -->

	</form>
	<!-- /.rh_widget_search__form -->

	<?php
else :
	?>
	<div class="rh_alert-wrapper rh_alert__widget">
		<h4 class="no-results"><?php esc_html_e( 'Advance Search is already enabled in the header.', 'framework' ); ?></h4>
	</div>
	<?php
endif;
