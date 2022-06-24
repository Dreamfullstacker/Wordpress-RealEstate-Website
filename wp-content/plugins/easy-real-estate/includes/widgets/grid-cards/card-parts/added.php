<div class="rh_added_sty">
	<?php
	?>
    <span><?php esc_html_e( 'Added: ', 'easy-real-estate' ); ?></span>
	<?php
	$inspiry_property_date_format = get_option( 'inspiry_property_date_format', 'dashboard' );
	if ( 'dashboard' == $inspiry_property_date_format ) {
		the_date();
	} else {
		echo human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) );
		echo ' ' . esc_html__( 'Ago ', 'easy-real-estate' );;
	}
	?>
</div>