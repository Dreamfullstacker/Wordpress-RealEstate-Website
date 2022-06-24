<div class="rh_prop_card__priceLabel_sty">
    <span class="rh_prop_card__status_sty">
                  <?php
                  if ( function_exists( 'ere_get_property_statuses' ) ) {
	                  echo esc_html( ere_get_property_statuses( get_the_ID() ) );
                  }
                  ?>
    </span>
    <p class="rh_prop_card__price_sty">
		<?php
		if ( function_exists( 'ere_property_price' ) ) {
			ere_property_price();
		}
		?>
    </p>
</div>