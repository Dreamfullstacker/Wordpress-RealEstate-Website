<?php
/**
 * Featured Property Card
 *
 * Featured property card to be displayed on homepage.
 *
 */
global $settings;
$property_size      = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size', true );
$size_postfix       = get_post_meta( get_the_ID(), 'REAL_HOMES_property_size_postfix', true );
$property_bedrooms  = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bedrooms', true );
$property_bathrooms = get_post_meta( get_the_ID(), 'REAL_HOMES_property_bathrooms', true );
$property_address   = get_post_meta( get_the_ID(), 'REAL_HOMES_property_address', true );

?>

<li <?php post_class( 'rh_prop_card' ); ?>>

    <figure class="rh_prop_card__thumbnail_elementor">
        <div class="rhea_top_tags_box">
			<?php
			if ( $settings['ere_show_property_media_count'] == 'yes' ) {
				rhea_get_template_part( 'assets/partials/stylish/media-count' );
			}
			?>
        </div>
        <a href="<?php the_permalink(); ?>">
			<?php
			if ( has_post_thumbnail( get_the_ID() ) ) {
				the_post_thumbnail( 'property-detail-video-image' );
			} else {
				inspiry_image_placeholder( 'property-detail-video-image' );
			}
			?>
        </a>

    </figure>

    <div class="rh_prop_card__details_elementor rh_prop_card__featured">

        <div class="rh_label_elementor rhea_label__property">
            <div class="rh_label__wrap_elementor">

				<?php
				if ( ! empty( $settings['ere_property_featured_label'] ) ) {
					echo esc_html( $settings['ere_property_featured_label'] );
				} else {
					esc_html_e( 'Featured', 'realhomes-elementor-addon' );
				}
				?>
                <span></span>
            </div>
        </div>

        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

	    <?php
	    if ( 'yes' == $settings['show_excerpt'] ) {
		    ?>
            <p class="rh_prop_card__excerpt"><?php rhea_framework_excerpt( esc_html( $settings['featured_excerpt_length'] ) ); ?></p>
		    <?php
	    }

        if ( inspiry_is_rvr_enabled() && 'yes' == $settings['rhea_rating_enable']   ) {
	        ?>
            <div class="rhea_rvr_ratings_wrapper_stylish rvr_rating_left">

		        <?php rhea_rvr_rating_average(); ?>

		        <?php
		        if ( 'yes' == $settings['show_date'] ) {
			        rhea_get_template_part( 'assets/partials/stylish/added' );
		        }
		        ?>
            </div>
	        <?php
        } else {
	        if ( 'yes' == $settings['show_date'] ) {
		        rhea_get_template_part( 'assets/partials/stylish/added' );
	        }
        }
        ?>

        <div class="rh_prop_card__meta_wrap_elementor">

			<?php rhea_get_template_part( 'assets/partials/stylish/grid-card-meta' ); ?>

        </div>


            <div class="rhea_price_fav_box">
                <div class="rh_prop_card__priceLabel">
                    <span class="rh_prop_card__status">
                          <?php
                          if ( function_exists( 'ere_get_property_statuses' ) ) {
	                          echo esc_html( ere_get_property_statuses( get_the_ID() ) );
                          }
                          ?>
                    </span>
                    <p class="rh_prop_card__price">
						<?php
						if ( function_exists( 'ere_property_price' ) ) {
							ere_property_price();
						}
						?>
                    </p>
                </div>

                <div class="rhea_fav_icon_box rhea_parent_fav_button">
					<?php
					if ( 'yes' === $settings['ere_enable_fav_properties'] ) {
						if ( function_exists( 'inspiry_favorite_button' ) ) {
							inspiry_favorite_button( get_the_ID(), null, $settings['ere_property_fav_label'], $settings['ere_property_fav_added_label'] );
						}
					}
					rhea_get_template_part( 'assets/partials/stylish/compare' );
					?>

                </div>
            </div>


    </div>

</li>
