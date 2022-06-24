<?php
/**
 * Property features of single property.
 *
 * @package    realhomes
 * @subpackage modern
 */

// Get current property's features
$features_terms = get_the_terms( get_the_ID(), 'property-feature' );
if ( ! empty( $features_terms ) ) {
	?>
    <div class="rh_property__features_wrap">
		<?php
		$property_features_title = get_option( 'theme_property_features_title' );
		if ( ! empty( $property_features_title ) ) {
			?><h4 class="rh_property__heading"><?php echo esc_html( $property_features_title ); ?></h4><?php
		}
		$rh_property_features_display = get_option( 'inspiry_property_features_display', 'link' );
		?>
        <ul class="rh_property__features arrow-bullet-list">
			<?php
			foreach ( $features_terms as $feature_term ) {
				echo '<li class="rh_property__feature" id="rh_property__feature_' . esc_attr( $feature_term->term_id ) . '">';
				echo '<span class="rh_done_icon">';
				inspiry_safe_include_svg( '/images/icons/done.svg' );
				echo '</span>';
				if ( 'link' === $rh_property_features_display ) {
					echo '<a href="' . esc_url( get_term_link( $feature_term ) ) . '">' . esc_html( $feature_term->name ) . '</a>';
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
	/*
	 * RVR - Property Outdoor Features.
	 */

	?>

    <div class="rh_wrapper_rvr_features">

		<?php
		$location_surroundings = get_post_meta( get_the_ID(), 'rvr_surroundings', true );
		$rvr_outdoor_features  = get_post_meta( get_the_ID(), 'rvr_outdoor_features', true );
		if ( ! empty( $location_surroundings ) || ! empty( $rvr_outdoor_features ) ) {
			?>
            <div class="rh_rvr_alternate_wrapper rh_outdoor_and_surroundings">
				<?php
				get_template_part( 'assets/modern/partials/property/single/rvr/location-surroundings' );
				get_template_part( 'assets/modern/partials/property/single/rvr/outdoor-features' );

				?>
            </div>
			<?php
		}
		/*
		 * RVR - Property Optional Services.
		 */
		get_template_part( 'assets/modern/partials/property/single/rvr/optional-services' );

		/*
		 * RVR - Property Property Policies.
		 */
		get_template_part( 'assets/modern/partials/property/single/rvr/property-policies' );

		/*
		 * RVR - Property Location Surroundings.
		 */

		?>
    </div>
	<?php
}