<?php
$form_class = 'form-add-property';

if ( isset( $_GET['id'] ) && ! empty( $_GET['id'] ) ) {
	$form_class = 'form-edit-property';
}

if ( 'steps' === get_option( 'inspiry_dashboard_submit_page_layout', 'steps' ) ) {
	$form_class .= ' submit-property-form-wizard';
}

$inspiry_submit_fields = inspiry_get_submit_fields();
?>
<form id="submit-property-form" class="submit-property-form <?php echo esc_attr( $form_class ); ?>" enctype="multipart/form-data" method="post">
    <div id="dashboard-tabs" class="dashboard-tabs">
        <ul id="dashboard-tabs-nav" class="dashboard-tabs-nav"></ul><!-- #dashboard-tabs-nav -->
        <div id="dashboard-tabs-contents" class="dashboard-tabs-contents">

            <div class="dashboard-tab-content form-fields" data-content-title="<?php esc_html_e( 'Basic', 'framework' ); ?>">
                <div class="row">
					<?php
					// Property Title
					if ( in_array( 'title', $inspiry_submit_fields, true ) ) { ?>
                        <div class="col-12">
							<?php get_template_part( 'common/dashboard/form-fields/title' ); ?>
                        </div>
						<?php
					}

					// Address and Google Map
					if ( in_array( 'address-and-map', $inspiry_submit_fields, true ) ) { ?>
                        <div class="col-12">
							<?php
							$inspiry_maps_type = inspiry_get_maps_type();
							if ( 'google-maps' == $inspiry_maps_type ) {
								get_template_part( 'common/dashboard/form-fields/google-map' );
							} else {
								get_template_part( 'common/dashboard/form-fields/open-street-map' );
							}
							?>
                        </div>
						<?php
					}

					// Property Description
					if ( in_array( 'description', $inspiry_submit_fields, true ) ) { ?>
                        <div class="col-12">
							<?php get_template_part( 'common/dashboard/form-fields/description' ); ?>
                        </div>
						<?php
					}

					// Property Price
					if ( in_array( 'price', $inspiry_submit_fields, true ) ) { ?>
                        <div class="col-md-6 col-lg-4">
							<?php get_template_part( 'common/dashboard/form-fields/price' ); ?>
                        </div>
						<?php
					}

					// Property Old Price
					if ( in_array( 'price', $inspiry_submit_fields, true ) ) { ?>
                        <div class="col-md-6 col-lg-4">
							<?php get_template_part( 'common/dashboard/form-fields/price-old' ); ?>
                        </div>
						<?php
					}

					// Property Price Prefix
					if ( in_array( 'price-postfix', $inspiry_submit_fields, true ) ) { ?>
                        <div class="col-md-6 col-lg-4">
							<?php get_template_part( 'common/dashboard/form-fields/price-prefix' ); ?>
                        </div>
						<?php
					}

					// Property Price Postfix
					if ( in_array( 'price-postfix', $inspiry_submit_fields, true ) ) { ?>
                        <div class="col-md-6 col-lg-4">
							<?php get_template_part( 'common/dashboard/form-fields/price-postfix' ); ?>
                        </div>
						<?php
					}

					// Property ID
					if ( in_array( 'property-id', $inspiry_submit_fields, true ) ) { ?>
                        <div class="col-md-6 col-lg-4">
							<?php get_template_part( 'common/dashboard/form-fields/property-id' ); ?>
                        </div>
						<?php
					}

					// Parent Property
					if ( in_array( 'parent', $inspiry_submit_fields, true ) ) {
						get_template_part( 'common/dashboard/form-fields/parent' );
					}

					// Property Type
					if ( in_array( 'property-type', $inspiry_submit_fields, true ) ) { ?>
                        <div class="col-md-6 col-lg-4">
							<?php get_template_part( 'common/dashboard/form-fields/property-type' ); ?>
                        </div>
						<?php
					}

					// Property Status
					if ( in_array( 'property-status', $inspiry_submit_fields, true ) ) { ?>
                        <div class="col-md-6 col-lg-4">
							<?php get_template_part( 'common/dashboard/form-fields/property-status' ); ?>
                        </div>
						<?php
					}

					// Locations
					if ( in_array( 'locations', $inspiry_submit_fields, true ) ) {
						get_template_part( 'common/dashboard/form-fields/locations' );
					}

					// Bedrooms
					if ( in_array( 'bedrooms', $inspiry_submit_fields, true ) ) { ?>
                        <div class="col-md-6 col-lg-4">
							<?php get_template_part( 'common/dashboard/form-fields/bedrooms' ); ?>
                        </div>
						<?php
					}

					// Bathrooms
					if ( in_array( 'bathrooms', $inspiry_submit_fields, true ) ) { ?>
                        <div class="col-md-6 col-lg-4">
							<?php get_template_part( 'common/dashboard/form-fields/bathrooms' ); ?>
                        </div>
						<?php
					}

					// Garages
					if ( in_array( 'garages', $inspiry_submit_fields, true ) ) { ?>
                        <div class="col-md-6 col-lg-4">
							<?php get_template_part( 'common/dashboard/form-fields/garages' ); ?>
                        </div>
						<?php
					}

					// Property Area
					if ( in_array( 'area', $inspiry_submit_fields, true ) ) { ?>
                        <div class="col-md-6 col-lg-4">
							<?php get_template_part( 'common/dashboard/form-fields/area' ); ?>
                        </div>
						<?php
					}

					// Property Area Postfix
					if ( in_array( 'area-postfix', $inspiry_submit_fields, true ) ) { ?>
                        <div class="col-md-6 col-lg-4">
							<?php get_template_part( 'common/dashboard/form-fields/area-postfix' ); ?>
                        </div>
						<?php
					}

					// Property Lot Size
					if ( in_array( 'lot-size', $inspiry_submit_fields, true ) ) { ?>
                        <div class="col-md-6 col-lg-4">
							<?php get_template_part( 'common/dashboard/form-fields/lot-size' ); ?>
                        </div>
						<?php
					}

					// Property Lot Size Postfix
					if ( in_array( 'lot-size-postfix', $inspiry_submit_fields, true ) ) { ?>
                        <div class="col-md-6 col-lg-4">
							<?php get_template_part( 'common/dashboard/form-fields/lot-size-postfix' ); ?>
                        </div>
						<?php
					}

					// Property Year Built
					if ( in_array( 'year-built', $inspiry_submit_fields, true ) ) { ?>
                        <div class="col-md-6 col-lg-4">
							<?php get_template_part( 'common/dashboard/form-fields/year-built' ); ?>
                        </div>
						<?php
					}

					// Mortgage Calculator Fields
					if ( in_array( 'mortgage-fields', $inspiry_submit_fields, true ) ) {
						get_template_part( 'common/dashboard/form-fields/mortgage-fields' );
					}

					// This hook can be used to add more property submit form fields
					do_action( 'inspiry_additional_submit_property_fields' );

                    // Featured Property
                    if ( in_array( 'featured', $inspiry_submit_fields, true ) ) { ?>
                        <div class="col-12">
		                    <?php get_template_part( 'common/dashboard/form-fields/featured' ); ?>
                        </div>
	                    <?php
                    }
					?>
                </div>
            </div>

			<?php
			// Get vacation rental meta fields.
			if ( inspiry_is_rvr_enabled() ) {
				get_template_part( 'common/dashboard/form-fields/vacation-rentals' );
			}

			if ( in_array( 'images', $inspiry_submit_fields, true ) ||
			     in_array( 'attachments', $inspiry_submit_fields, true ) ||
			     in_array( 'slider-image', $inspiry_submit_fields, true ) ||
			     in_array( 'floor-plans', $inspiry_submit_fields, true )
			) :
				?>
                <div class="dashboard-tab-content form-fields"
                     data-content-title="<?php esc_html_e( 'Gallery', 'framework' ); ?>">
                    <div class="row">
						<?php
						// Gallery Images
						if ( in_array( 'images', $inspiry_submit_fields, true ) ) { ?>
                            <div class="col-12">
								<?php get_template_part( 'common/dashboard/form-fields/images' ); ?>
                            </div>
							<?php
						}
						
						// Attachments
						if ( in_array( 'attachments', $inspiry_submit_fields ) ) { ?>
                            <div class="col-12">
								<?php get_template_part( 'common/dashboard/form-fields/attachment' ); ?>
                            </div>
							<?php
						}

						// Property Homepage Slider Image
						if ( in_array( 'slider-image', $inspiry_submit_fields ) ) { ?>
                            <div class="col-12">
								<?php get_template_part( 'common/dashboard/form-fields/slider-image' ); ?>
                            </div>
							<?php
						}

						// Floor Plans
						if ( in_array( 'floor-plans', $inspiry_submit_fields ) ) { ?>
                            <div class="col-12">
								<?php get_template_part( 'common/dashboard/form-fields/floor-plans' ); ?>
                            </div>
							<?php
						}
						?>
                    </div>
                </div>
			<?php
			endif;

			if ( in_array( 'video', $inspiry_submit_fields, true ) ||
			     in_array( 'virtual-tour', $inspiry_submit_fields, true )
			) :
				?>
                <div class="dashboard-tab-content form-fields" data-content-title="<?php esc_html_e( 'Video', 'framework' ); ?>">
                    <div class="row">
						<?php
						// Property 360 Virtual Tour
						if ( in_array( 'virtual-tour', $inspiry_submit_fields ) ) { ?>
                            <div class="col-12">
								<?php get_template_part( 'common/dashboard/form-fields/virtual-tour' ); ?>
                            </div>
							<?php
						}

						// Property Video
						if ( in_array( 'video', $inspiry_submit_fields, true ) ) { ?>
                            <div class="col-12">
								<?php get_template_part( 'common/dashboard/form-fields/video' ); ?>
                            </div>
							<?php
						}
						?>
                    </div>
                </div>
			<?php
			endif;

			if ( in_array( 'features', $inspiry_submit_fields, true ) ||
			     in_array( 'energy-performance', $inspiry_submit_fields, true ) ||
			     in_array( 'label-and-color', $inspiry_submit_fields, true ) ||
			     in_array( 'additional-details', $inspiry_submit_fields, true )
			) :
				?>
                <div class="dashboard-tab-content form-fields"
                     data-content-title="<?php esc_html_e( 'Features', 'framework' ); ?>">
                    <div class="row">
						<?php
						// Additional Details
						if ( in_array( 'additional-details', $inspiry_submit_fields, true ) ) { ?>
                            <div class="col-12">
								<?php get_template_part( 'common/dashboard/form-fields/additional-details' ); ?>
                                <div class="form-fields-separator"></div>
                            </div>
							<?php
						}

						// Property Features
						if ( in_array( 'features', $inspiry_submit_fields, true ) ) { ?>
                            <div class="col-12">
								<?php get_template_part( 'common/dashboard/form-fields/features' ); ?>
                                <div class="form-fields-separator"></div>
                            </div>
							<?php
						}

						// Property Label and Color
						if ( in_array( 'label-and-color', $inspiry_submit_fields, true ) ) {
							get_template_part( 'common/dashboard/form-fields/label-and-color' );
						}

						// Property Energy Performance Certificate
						if ( in_array( 'energy-performance', $inspiry_submit_fields, true ) ) { ?>
                            <div class="col-12">
								<?php get_template_part( 'common/dashboard/form-fields/energy-performance' ); ?>
                            </div>
							<?php
						}
						?>
                    </div>
                </div>
			<?php endif; ?>

			<?php
			$show_reCAPTCHA = ( ! is_user_logged_in() && inspiry_guest_submission_enabled() && function_exists( 'ere_is_reCAPTCHA_configured' ) && ere_is_reCAPTCHA_configured() );
			if ( in_array( 'agent', $inspiry_submit_fields, true ) ||
			     in_array( 'owner-information', $inspiry_submit_fields, true ) ||
			     in_array( 'reviewer-message', $inspiry_submit_fields, true ) ||
			     in_array( 'terms-conditions', $inspiry_submit_fields, true ) ||
			     $show_reCAPTCHA
			) :
				?>
                <div class="dashboard-tab-content form-fields" data-content-title="<?php esc_html_e( 'Agent & Reviewer', 'framework' ); ?>">
                    <div class="row">
						<?php
						// Property Agent
						if ( in_array( 'agent', $inspiry_submit_fields, true ) ) { ?>
                            <div class="col-12">
								<?php get_template_part( 'common/dashboard/form-fields/agent' ); ?>
                            </div>
							<?php
						}

						// Property Owner Information
						if ( in_array( 'owner-information', $inspiry_submit_fields, true ) ) {
							get_template_part( 'common/dashboard/form-fields/owner-information' );
						}

						// Reviewer Message
						if ( in_array( 'reviewer-message', $inspiry_submit_fields, true ) ) { ?>
                            <div class="col-12">
								<?php get_template_part( 'common/dashboard/form-fields/reviewer-message' ); ?>
                            </div>
							<?php
						}

						// Terms & Conditions
						if ( in_array( 'terms-conditions', $inspiry_submit_fields, true ) ) { ?>
                            <div class="col-12">
								<?php get_template_part( 'common/dashboard/form-fields/terms-conditions' ); ?>
                            </div>
							<?php
						}

						// Display reCAPTCHA if enabled and configured from customizer settings
						if ( $show_reCAPTCHA ) : ?>
                            <div class="col-12">
                                <div class="field-wrap inspiry-recaptcha-wrapper g-recaptcha-type-<?php echo esc_attr( get_option( 'inspiry_reCAPTCHA_type', 'v2' ) ); ?>">
                                    <div class="inspiry-google-recaptcha"></div>
                                </div>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
			<?php endif; ?>

        </div><!-- #dashboard-tabs-content -->
    </div><!-- #dashboard-tabs -->
	<?php get_template_part( 'common/dashboard/form-fields/submit-button' ); ?>
</form><!-- #submit-property-form -->