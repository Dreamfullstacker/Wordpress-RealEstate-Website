<?php
if ( function_exists( 'ere_social_networks' ) ) {

	$args = array(
		'container'       => 'div',
		'container_class' => 'rh_var2_social_icons',
		'replace_icons'   => array(
			'facebook' => 'fab fa-facebook-square',
			'linkedin' => 'fab fa-linkedin',
			'youtube'  => 'fab fa-youtube',
		),
	);

	ere_social_networks( $args );
}