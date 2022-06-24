<?php
global $settings;
$prop_excerpt_length = $settings['prop_excerpt_length'];
$show_excerpt        = $settings['show_excerpt'];
if ( 'yes' == $show_excerpt ) {
	?>
    <p class="rh_prop_stylish_card__excerpt"><?php rhea_framework_excerpt( esc_html( $prop_excerpt_length ) ); ?></p>
	<?php
}