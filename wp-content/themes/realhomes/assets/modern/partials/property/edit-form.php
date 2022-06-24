<?php
/**
 * View: Edit Property
 *
 * Viewing template of Submit Property Edit page.
 *
 * @since   3.0.0
 * @package realhomes/modern
 */

if ( is_page_template( 'templates/submit-property.php' ) ) {
	global $target_property;
	global $edit_property_id;

	$edit_property_id = intval( trim( $_GET['edit_property'] ) );
	$target_property  = get_post( $edit_property_id );

	/* check if passed id is a proper property post */
	if ( ! empty( $target_property ) && ( 'property' == $target_property->post_type ) ) {

		// Check Author.
		$current_user = wp_get_current_user();

		/* check if current logged in user is the author of property */
		if ( $target_property->post_author == $current_user->ID ) {
			global $post_meta_data;
			$post_meta_data = get_post_custom( $target_property->ID );

			$inspiry_submit_fields = inspiry_get_submit_fields(); ?>
            <div class="rh_form">
                <form id="submit-property-form" class="rh_form__form" enctype="multipart/form-data" method="post">

                    <div class="rh_form__row">

						<?php
						/**
						 * Property Title
						 */
						if ( in_array( 'title', $inspiry_submit_fields, true ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/title' );
						}
						?>

                    </div>
                    <!-- /.rh_form__row -->

                    <div class="rh_form__row">

						<?php
						/**
						 * Property Description
						 */
						if ( in_array( 'description', $inspiry_submit_fields, true ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/description' );
						}
						?>

                    </div>
                    <!-- /.rh_form__row -->

                    <div class="rh_form__row">

						<?php
						/**
						 * Property Type
						 */
						if ( in_array( 'property-type', $inspiry_submit_fields, true ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/property-type' );
						}

						/**
						 * Property Status
						 */
						if ( in_array( 'property-status', $inspiry_submit_fields, true ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/property-status' );
						}

						/**
						 * Locations
						 */
						if ( in_array( 'locations', $inspiry_submit_fields, true ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/locations' );
						}

						/**
						 * Bedrooms
						 */
						if ( in_array( 'bedrooms', $inspiry_submit_fields, true ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/bedrooms' );
						}

						/**
						 * Bathrooms
						 */
						if ( in_array( 'bathrooms', $inspiry_submit_fields, true ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/bathrooms' );
						}

						/**
						 * Garages
						 */
						if ( in_array( 'garages', $inspiry_submit_fields, true ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/garages' );
						}

						/**
						 * Property ID
						 */
						if ( in_array( 'property-id', $inspiry_submit_fields, true ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/property-id' );
						}

						/**
						 * Property Price
						 */
						if ( in_array( 'price', $inspiry_submit_fields, true ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/price' );
						}

						/**
						 * Property Price Postfix
						 */
						if ( in_array( 'price-postfix', $inspiry_submit_fields, true ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/price-postfix' );
						}

						/**
						 * Property Area
						 */
						if ( in_array( 'area', $inspiry_submit_fields, true ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/area' );
						}

						/**
						 * Property Area Postfix
						 */
						if ( in_array( 'area-postfix', $inspiry_submit_fields, true ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/area-postfix' );
						}

						/**
						 * Property Lot Size
						 */
						if ( in_array( 'lot-size', $inspiry_submit_fields, true ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/lot-size' );
						}

						/**
						 * Property Lot Size Postfix
						 */
						if ( in_array( 'lot-size-postfix', $inspiry_submit_fields, true ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/lot-size-postfix' );
						}

						/**
						 * Property Video
						 */
						if ( in_array( 'video', $inspiry_submit_fields, true ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/video' );
						}

						/**
						 * Property Year Built
						 */
						if ( in_array( 'year-built', $inspiry_submit_fields, true ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/year-built' );
						}

						/**
						 * Property Energy Performance Certificate
						 */
						if ( in_array( 'energy-performance', $inspiry_submit_fields, true ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/energy-performance' );
						}

						/**
						 * This hook can be used to add more property edit form fields
						 */
						do_action( 'inspiry_additional_edit_property_fields', $edit_property_id );
						?>

                    </div>
                    <!-- /.rh_form__row -->

                    <div class="rh_form__row">

						<?php
						/**
						 * Gallery Images
						 */
						global $column_class;
						$column_class = 'rh_form--2-column';
						if ( in_array( 'images', $inspiry_submit_fields, true ) ) {
							if ( ! in_array( 'address-and-map', $inspiry_submit_fields, true ) ) {
								$column_class = 'rh_form--1-column';
							}
							get_template_part( 'assets/modern/partials/property/form-fields/images' );
						}

						/**
						 * Address and Google Map
						 */
						if ( in_array( 'address-and-map', $inspiry_submit_fields, true ) ) {
							if ( ! in_array( 'images', $inspiry_submit_fields, true ) ) {
								$column_class = 'rh_form--1-column';
							}

							$inspiry_maps_type = inspiry_get_maps_type();
							if ( 'google-maps' == $inspiry_maps_type ) {
								get_template_part( 'assets/modern/partials/property/form-fields/google-map' );
							} else {
								get_template_part( 'assets/modern/partials/property/form-fields/open-street-map' );
							}
						}
						?>

                    </div>
                    <!-- /.rh_form__row -->

                    <div class="rh_form__row">
		                <?php
		                /**
		                 * Attachments
		                 */
		                if ( in_array( 'attachments', $inspiry_submit_fields ) ) {
			                get_template_part( 'assets/modern/partials/property/form-fields/attachment' );
		                }
		                ?>
                    </div>
                    <!-- /.rh_form__row -->

                    <div class="rh_form__row">

						<?php
						/**
						 * Additional Details
						 */
						if ( in_array( 'additional-details', $inspiry_submit_fields, true ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/additional-details' );
						}
						?>

                    </div>
                    <!-- /.rh_form__row -->

                    <div class="rh_form__row">

						<?php
						/**
						 * Property Features
						 */
						if ( in_array( 'features', $inspiry_submit_fields, true ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/features' );
						}
						?>

                    </div>
                    <!-- /.rh_form__row -->

                    <div class="rh_form__row">
                        <div class="rh_form__item rh_form--2-column rh_form--columnAlign agent-fields-wrapper">
		                    <?php
		                    /**
		                     * Property Agent
		                     */
		                    if ( in_array( 'agent', $inspiry_submit_fields, true ) ) {
			                    get_template_part( 'assets/modern/partials/property/form-fields/agent' );
		                    }

		                    /**
		                     * Parent Property
		                     */
		                    if ( in_array( 'parent', $inspiry_submit_fields, true ) ) {
			                    get_template_part( 'assets/modern/partials/property/form-fields/parent' );
		                    }
		                    ?>
                        </div><!-- /.rh_form__item -->
                    </div>
                    <!-- /.rh_form__row -->

                    <div class="rh_form__row">
						<?php
						/**
						 * Floor Plans
						 */
						if ( in_array( 'floor-plans', $inspiry_submit_fields ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/floor-plans' );
						}
						?>
                    </div>
                    <!-- /.rh_form__row -->

                    <div class="rh_form__row">

						<?php
						/**
						 * Reviewer Message
						 */
						if ( in_array( 'reviewer-message', $inspiry_submit_fields, true ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/reviewer-message' );
						}
						?>

                    </div>
                    <!-- /.rh_form__row -->

                    <div class="rh_form__row">

						<?php
						/**
						 * Featured Property
						 */
						if ( in_array( 'featured', $inspiry_submit_fields, true ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/featured' );
						}
						?>

                    </div>
                    <!-- /.rh_form__row -->

                    <div class="rh_form__row">

						<?php
						/**
						 * Terms & Conditions
						 */
						if ( in_array( 'terms-conditions', $inspiry_submit_fields, true ) ) {
							get_template_part( 'assets/modern/partials/property/form-fields/terms-conditions' );
						}
						?>

                    </div>
                    <!-- /.rh_form__row -->

                    <div class="rh_form__row">

						<?php
						/**
						 * Submit Button
						 */
						get_template_part( 'assets/modern/partials/property/form-fields/submit-button' );
						?>

                    </div>
                    <!-- /.rh_form__row -->

                </form>
            </div>
            <!-- /.rh_form -->
			<?php
		}
	}
}
