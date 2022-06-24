<?php
/**
 * Rental Properties search form.
 *
 * @package    realhomes
 * @subpackage classic
 */
?>
<div class="as-form-wrap">
    <form class="rvr-search rh_classic_advance_search_form advance-search-form clearfix"
          action="<?php echo esc_url( inspiry_get_search_page_url() ); ?>" method="get">
        <div class="wrapper-search-form-grid">
			<?php

			/*
			 * Location Field
			 */
			get_template_part( 'assets/classic/partials/properties/search/fields/location' );


			/*
			 * Check In & Check Out Field
			 */
			get_template_part( 'assets/classic/partials/properties/search/fields/rvr/check-in-out' );

			/*
			 * Number of Guests Field
			 */
			get_template_part( 'assets/classic/partials/properties/search/fields/rvr/guest' );

			/**
			 * Additional Search Fields
			 */
			do_action('inspiry_additional_search_fields');

			/*
			 * Search Button
			 */
			get_template_part( 'assets/classic/partials/properties/search/fields/button' );

			if ( isset( $_GET['sortby'] ) ) {
				?><input type="hidden" name="sortby" value="<?php echo esc_attr( $_GET['sortby'] ); ?>" /><?php

			}
			?>
        </div>
	    <?php

	    $feature_search_option = get_option( 'inspiry_search_fields_feature_search', 'true' );

	    if ( ! empty( $feature_search_option ) && $feature_search_option == 'true' ) {
		    get_template_part( 'assets/classic/partials/properties/search/fields/property-features' );
	    }

	    ?>
    </form>
</div>
