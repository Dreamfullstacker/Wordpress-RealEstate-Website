<?php

/* Optional Services */
$rvr_included     = get_post_meta( get_the_ID(), 'rvr_included', true );
$rvr_not_included = get_post_meta( get_the_ID(), 'rvr_not_included', true );
if ( ! empty( $rvr_included ) || ! empty( $rvr_not_included ) ) {
	?>
    <div class="features nolink-list rvr-inc-exc">
        <h4 class="title">
			<?php
			$rvr_settings = get_option( 'rvr_settings' );
			echo ! empty( $rvr_settings['rvr_optional_services_label'] ) ? esc_html( $rvr_settings['rvr_optional_services_label'] ) : esc_html__( 'Optional Services', 'framework' );
			?>
        </h4>
		<?php

		if ( ! empty( $rvr_included ) ) {
			?>
            <h5>
				<?php echo ! empty( $rvr_settings['rvr_optional_services_inc_label'] ) ? esc_html( $rvr_settings['rvr_optional_services_inc_label'] ) : esc_html__( 'Included', 'framework' ); ?>
            </h5>
            <ul class="arrow-bullet-list clearfix">
				<?php
				foreach ( $rvr_included as $rvr_include ) {
					echo '<li>' . esc_html( $rvr_include ) . '</li>';
				}
				?>
            </ul>
			<?php
		}

		if ( ! empty( $rvr_not_included ) ) {
			?>
            <h5>
	            <?php echo ! empty( $rvr_settings['rvr_optional_services_not_inc_label'] ) ? esc_html( $rvr_settings['rvr_optional_services_not_inc_label'] ) : esc_html__( 'Not Included', 'framework' ); ?>
            </h5>
            <ul class="arrow-bullet-list clearfix">
				<?php
				foreach ( $rvr_not_included as $rvr_not_include ) {
					echo '<li>' . esc_html( $rvr_not_include ) . '</li>';
				}
				?>
            </ul>
			<?php
		}
		?>
    </div>
	<?php
}