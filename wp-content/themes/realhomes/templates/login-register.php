<?php
/**
 * Template Name: Login & Register
 *
 * @since   1.0.0
 * @package realhomes/templates
 */

do_action( 'inspiry_before_login_register_page_render', get_the_ID() );

get_template_part( 'assets/' . INSPIRY_DESIGN_VARIATION . '/partials/page/login-register' );
