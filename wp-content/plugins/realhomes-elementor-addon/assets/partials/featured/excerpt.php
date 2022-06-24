<?php
global $settings;

if(!empty($settings['featured_excerpt_length'])){
    $excerpt_length = $settings['featured_excerpt_length'];;
}else{
	$excerpt_length = 10;
}

if ( ! empty( rhea_get_framework_excerpt() ) ) {
	?>
    <p class="rhea_fp_excerpt"><?php rhea_framework_excerpt( esc_html( $excerpt_length ) ); ?></p>

	<?php
}