<?php
global $post;

$features_terms = get_the_terms( get_the_ID(), 'property-feature' );

if ( ! empty( $features_terms ) || inspiry_is_rvr_enabled() ) : ?>
    <div class="features-content-wrapper single-property-section">
        <div class="container">
			<?php
			if ( ! empty( $features_terms ) ) {
				?>
                <div class="rh_property__features_wrap">
					<?php
					$property_features_title = get_option( 'theme_property_features_title' );
					if ( ! empty( $property_features_title ) ) {
						?><h4 class="rh_property__heading"><?php echo esc_html( $property_features_title ); ?></h4><?php
					}
					$property_features_display = get_option( 'inspiry_property_features_display', 'link' );
					?>
                    <ul class="rh_property__features arrow-bullet-list">
						<?php
						foreach ( $features_terms as $feature_term ) {
							echo '<li class="rh_property__feature" id="rh_property__feature_' . esc_attr( $feature_term->term_id ) . '">';
							echo '<span class="rh_done_icon">';
							inspiry_safe_include_svg( '/images/icons/done.svg' );
							echo '</span>';
							if ( 'link' === $property_features_display ) {
								echo '<a href="' . esc_url( get_term_link( $feature_term, 'property-feature' ) ) . '">' . esc_html( $feature_term->name ) . '</a>';
							} else {
								echo esc_html( $feature_term->name );
							}
							echo '</li>';
						}
						?>
                    </ul>
                </div>
				<?php
			}

			/**
			 * Display RVR related contents if it's enabled.
			 */
			if ( inspiry_is_rvr_enabled() ) {


				?>

                <div class="rh_wrapper_rvr_features">

                    <div class="rh_single_full_rvr_features">
						<?php
						/*
		        		 * RVR - Property Location Surroundings.
		        		 */
						get_template_part( 'assets/modern/partials/property/single/rvr/location-surroundings' );

						/*
			             * RVR - Property Outdoor Features.
		            	 */
						get_template_part( 'assets/modern/partials/property/single/rvr/outdoor-features' );
						/*
						 * RVR - Property Optional Services.
						 */
						get_template_part( 'assets/modern/partials/property/single/rvr/optional-services' );

						?>
                    </div>
					<?php
					/*
					 * RVR - Property Property Policies.
					 */
					get_template_part( 'assets/modern/partials/property/single/rvr/property-policies' );


					?>
                </div>
				<?php
			}
			?>
        </div>
    </div>
<?php endif; ?>