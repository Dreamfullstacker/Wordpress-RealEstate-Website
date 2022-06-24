<?php
global $settings;
?>
<div class="rhea_added_sty">
	<?php
    if ( $settings['ere_property_added_label'] ) {
        ?>
        <span><?php echo esc_html( $settings['ere_property_added_label'] ); ?></span>
		<?php
	}
	if ( $settings['ere_choose_post_time_formats'] == 'dashboard' ) {
	    the_date();
	}elseif ( $settings['ere_choose_post_time_formats'] == 'human' ) {
		echo human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) );
	} else {
		echo get_the_date($settings['ere_choose_post_time_format_option']);
	}
    echo  ' ' . esc_html($settings['ere_property_added_ago_label']);
	?>
</div>