<div class="content-wrapper single-property-section">
    <div class="container">
        <div class="rh_property__row rh_property__meta rh_property--borderBottom">
			<?php
			$property_id                     = get_post_meta( get_the_ID(), 'REAL_HOMES_property_id', true );
			$display_social_share            = get_option( 'theme_display_social_share', 'true' );
			$theme_property_detail_variation = get_option( 'theme_property_detail_variation' );
			?>
            <div class="rh_property__id">
                <p class="title"><?php esc_html_e( 'Property ID', 'framework' ); ?> :&nbsp;</p>
                <p class="id">
					<?php
					if ( ! empty( $property_id ) ) :
						echo esc_html( $property_id );
					else :
						esc_html_e( 'None', 'framework' );
					endif;
					?>
                </p>
            </div>
            <div class="rh_property__print">
	            <?php if ( 'true' === $display_social_share ) : ?>
                    <a href="#" class="share" id="social-share"><?php inspiry_safe_include_svg( '/images/icons/icon-share-2.svg' ); ?></a>
                    <div id="share-button-title" class="hide"><?php esc_html_e( 'Share', 'framework' ); ?></div>
                    <div class="share-this" data-check-mobile="<?php if ( wp_is_mobile() ) {echo esc_attr( 'mobile' );} ?>" data-property-name="<?php the_title(); ?>" data-property-permalink="<?php the_permalink(); ?>"></div>
	            <?php endif; ?>
                <?php
                // Display add to favorite button
                inspiry_favorite_button( get_the_ID(), true );
				?>
                <a href="javascript:window.print()" class="print">
					<?php inspiry_safe_include_svg( '/images/icons/icon-printer.svg' ); ?>
                    <span class="rh_tooltip">
                        <span class="label"><?php esc_html_e( 'Print', 'framework' ); ?></span>
                    </span>
                </a>
            </div>
        </div>
		<?php
		/**
		 * Property meta information.
		 */
		get_template_part( 'assets/modern/partials/property/single/meta' );
		?>
        <h4 class="rh_property__heading"><?php esc_html_e( 'Description', 'framework' ); ?></h4>
        <div class="rh_content">
			<?php the_content(); ?>
        </div>
    </div>
</div>