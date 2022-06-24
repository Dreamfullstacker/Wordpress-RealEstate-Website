<?php

/* Outdoor Features */
$rvr_outdoor_features = get_post_meta( get_the_ID(), 'rvr_outdoor_features', true );
if ( ! empty( $rvr_outdoor_features ) ) {
	?>
    <div class="features nolink-list">
        <h4 class="title"><?php
	        $rvr_settings = get_option( 'rvr_settings' );
	        echo ! empty( $rvr_settings['rvr_outdoor_features_label'] ) ? esc_html( $rvr_settings['rvr_outdoor_features_label'] ) : esc_html__( 'Outdoor Features', 'framework' );
            ?></h4>
        <ul class="arrow-bullet-list clearfix">
			<?php
			foreach ( $rvr_outdoor_features as $rvr_outdoor_feature ) {
				echo '<li>' . esc_html( $rvr_outdoor_feature ) . '</li>';
			}
			?>
        </ul>
    </div>
	<?php
}