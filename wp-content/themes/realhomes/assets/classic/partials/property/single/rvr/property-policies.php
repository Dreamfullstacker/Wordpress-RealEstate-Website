<?php

/* Property Policies */
$property_policies = get_post_meta( get_the_ID(), 'rvr_policies', true );
if ( ! empty( $property_policies ) ) {
	?>
    <div class="features nolink-list">
        <h4 class="title"><?php
	        $rvr_settings = get_option( 'rvr_settings' );
	        echo ! empty( $rvr_settings['rvr_property_policies_label'] ) ? esc_html( $rvr_settings['rvr_property_policies_label'] ) : esc_html__( 'Property Policies', 'framework' );
            ?></h4>
        <ul class="arrow-bullet-list no-link-list property-policy">
		    <?php
		    foreach ( $property_policies as $property_policy ) {
			    ?>
                <li class="rh_property__feature">
				    <?php
				    echo esc_html( $property_policy['rvr_policy_detail'] );
				    ?>
                </li>
			    <?php
		    }
		    ?>
        </ul>
    </div>
	<?php
}