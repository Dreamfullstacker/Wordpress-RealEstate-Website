<?php
/**
 * Search Form Over Image for Homepage.
 *
 * @package    realhomes
 * @subpackage Modern
 */

$SFOI_classes = ' rh_mod_parallax_sfoi ';

$inspiry_home_search_bg_video = trim( get_post_meta( get_the_ID(), 'inspiry_home_search_bg_video', true ) );


if ( function_exists( 'putRevSlider' ) && ( ! empty( $inspiry_home_search_bg_video ) ) ) {
	$SFOI_classes .= ' over-video ';
}

$inspiry_sfoi_classes = get_option( 'inspiry_sfoi_classes' );
if ( ! empty( $inspiry_sfoi_classes ) ) {
	$SFOI_classes .= $inspiry_sfoi_classes;
}

$get_responsive_header = get_option( 'inspiry_responsive_header_option' );

if ( $get_responsive_header == 'solid' ) {
	$SFOI_classes .= ' inspiry_responsive_header_is_solid ';
} else {
	$SFOI_classes .= ' inspiry_responsive_header_is_transparent ';
}
$advance_search_expand = '';
if ( 'false' == get_option( 'inspiry_search_advance_search_expander', 'true' ) ) {
	$SFOI_classes = 'rh_sfoi_hide_advance_fields';
}

?>
<div class="rh_mod_sfoi_wrapper <?php echo esc_attr( $SFOI_classes ); ?>"
     style="background-image: url('<?php echo inspiry_get_search_bg_image(); ?>') ">

	<?php if ( function_exists( 'putRevSlider' ) && ( ! empty( $inspiry_home_search_bg_video ) ) ) : ?>
        <div class="SFOV">
			<?php putRevSlider( $inspiry_home_search_bg_video ); ?>
        </div>
	<?php endif; ?>

    <div class="rh_mod_sfoi_overlay"></div>

    <div class="rh_mod_sfoi-container">
        <div class="rh_mod_sfoi_content rh_sfoi_faded">

            <div class="rh_sfoi_titles">
				<?php
				$inspiry_SFOI_title = get_post_meta( get_the_ID(), 'inspiry_SFOI_title', true );
				if ( ! empty( $inspiry_SFOI_title ) ) {
					?><h2 class="SFOI__title"><?php echo esc_html( $inspiry_SFOI_title ); ?></h2><?php
				}

				/*
				 * Description
				 */
				$inspiry_SFOI_description = get_post_meta( get_the_ID(), 'inspiry_SFOI_description', true );
				if ( ! empty( $inspiry_SFOI_description ) ) {
					?><p class="SFOI__description"><?php echo esc_html( $inspiry_SFOI_description ); ?></p><?php
				}

				?>

            </div>


			<?php
			if ( inspiry_is_rvr_enabled() && inspiry_is_search_fields_configured() ) {
				$theme_search_fields = inspiry_get_search_fields();
				if ( ! empty( $theme_search_fields ) && is_array( $theme_search_fields ) ) {
					?>
                    <div class="rh_mod_sfoi_form rh_mod_sfoi_form_rvr">
                        <form class="SFOI__form rh_sfoi_advance_search_form advance-search-form clearfix"
                              action="<?php echo esc_url( inspiry_get_search_page_url() ); ?>" method="get">
                            <div class="SFOI__top-fields-wrapper">
                                <div class="SFOI__top-fields-container clearfix">
									<?php
									$feature_search_option        = get_option( 'inspiry_search_fields_feature_search', 'true' );
									?>
                                    <div class="rh_top_sfoi_fields">
										<?php
										foreach ( $theme_search_fields as $field ) {
											if ( 'location' === $field ) {
												$field = '../' . $field;
											}
											get_template_part( 'assets/modern/partials/properties/search/fields/rvr/' . $field );
										}

										do_action( 'inspiry_additional_search_fields' );

										get_template_part( 'assets/modern/partials/properties/search/fields/sfoi-buttons' );
										?>

                                    </div>
<!--                                    <div class="rh_mod_sfoi_advance_fields_wrapper">-->
<!--                                        <div class="rh_mod_sfoi_advance_fields">-->
<!--                                        </div>-->
<!--                                    </div>-->
                                </div>
                            </div>

                        </form>
                    </div>
					<?php
				}
			} else if ( inspiry_is_search_page_configured() ) {
				if ( inspiry_is_search_fields_configured() ) {
					$theme_search_fields = inspiry_get_search_fields();
					?>
                    <div class="rh_mod_sfoi_form">
                        <form class="SFOI__form rh_sfoi_advance_search_form advance-search-form clearfix"
                              action="<?php echo esc_url( inspiry_get_search_page_url() ); ?>" method="get">
							<?php
							if ( ! empty( $theme_search_fields ) && is_array( $theme_search_fields ) ) {
								?>

                                <div class="SFOI__top-fields-wrapper">
                                    <div class="SFOI__top-fields-container clearfix">
										<?php
										if ( array_filter( $theme_search_fields ) ) {

											$feature_search_option = get_option( 'inspiry_search_fields_feature_search', 'true' );

											$inspiry_sfoi_fields_main_row = get_option( 'inspiry_sfoi_fields_main_row', '2' );
											$top_field_int_value          = (int) $inspiry_sfoi_fields_main_row;


											?>
                                            <div class="rh_top_sfoi_fields <?php echo ' rh_sfoi_top_fields_count_' . esc_attr( $inspiry_sfoi_fields_main_row ); ?>"
                                                 data-sfoi-top="<?php echo esc_attr( $inspiry_sfoi_fields_main_row ); ?>">
												<?php
												foreach ( $theme_search_fields as $field ) {
													get_template_part( 'assets/modern/partials/properties/search/fields/' . $field );
												}
												do_action( 'inspiry_additional_search_fields' );

												get_template_part( 'assets/modern/partials/properties/search/fields/sfoi-buttons' );
												?>

                                            </div>
                                            <div class="rh_mod_sfoi_advance_fields_wrapper">
                                                <div class="rh_mod_sfoi_advance_fields">
													<?php


													if ( ! empty( $feature_search_option ) && $feature_search_option == 'true' ) {
														?>
                                                        <div class="rh_sfoi_features">
															<?php
															get_template_part( 'assets/modern/partials/properties/search/fields/property-features' );
															?>
                                                        </div>
														<?php

													}
													?>
                                                </div>
                                            </div>
											<?php


										}
										?>
                                    </div>
                                </div>

								<?php
							}
							?>
                        </form>
                    </div>

					<?php
				}
			}

			?>

        </div>
    </div>

</div>

