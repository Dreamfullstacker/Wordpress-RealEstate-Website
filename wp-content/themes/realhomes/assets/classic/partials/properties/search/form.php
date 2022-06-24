<?php
/**
 * Properties search form.
 *
 * @package    realhomes
 * @subpackage classic
 */

if ( inspiry_is_search_fields_configured() ) :
	$theme_search_fields = inspiry_get_search_fields();
	$collapse_more_fields = get_option( 'inspiry_sidebar_asf_collapse', 'no' );

	?>

    <div class="as-form-wrap">
        <form class="advance-search-form rh_classic_advance_search_form clearfix"
              action="<?php echo esc_url( inspiry_get_search_page_url() ); ?>" method="get">


			<?php
			?>
            <div class="wrapper-search-form-grid">
				<?php
				if ( ! empty( $theme_search_fields ) && is_array( $theme_search_fields ) ) {


					foreach ( $theme_search_fields as $field ) {
						get_template_part( 'assets/classic/partials/properties/search/fields/' . $field );
					}

				}
				do_action( 'inspiry_additional_search_fields' );

				?>
                <div class="button-wrapper-flex">
					<?php get_template_part( 'assets/classic/partials/properties/search/fields/button' ); ?>
                </div>
            </div>
			<?php

			if ( 'yes' == $collapse_more_fields ) {
				?>
                <div class="more-fields-wrapper collapsed"></div>
                <div class="more-fields-trigger">
                    <a href="#"><i class="far fa-plus-square"></i>
                        <span><?php esc_html_e( 'More fields', 'framework' ); ?>
                                        </span></a>
                </div>
				<?php
			}
			?>
            <div class="button-wrapper-widget-search">
				<?php
				get_template_part( 'assets/classic/partials/properties/search/fields/button' );
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
<?php
endif;
