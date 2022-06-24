<?php

	$REAL_HOMES_property_address = get_post_meta( get_the_ID(), 'REAL_HOMES_property_address', true );

	if ( isset( $REAL_HOMES_property_address ) && ! empty( $REAL_HOMES_property_address ) ) {

		?>
        <div class="rh_address_sty">
            <a
		        <?php rh_lightbox_data_attributes( '', get_the_ID() ) ?>
                    href="<?php the_permalink(); ?>"
            >
                <span class="rh_address_pin test">
                    <?php ere_safe_include_svg( '/images/icons/pin.svg' ); ?>
                </span>
				<?php echo esc_html( $REAL_HOMES_property_address ); ?>

            </a>
        </div>
		<?php
	}

