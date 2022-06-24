<?php
/**
 * Template Name: Deprecated - Membership Plans
 *
 * @since   3.0.0
 * @package realhomes/templates
 */

do_action( 'inspiry_before_membership_plans_page_render', get_the_ID() );

if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
	wp_safe_redirect( home_url() );
	exit();
} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
	get_template_part( 'assets/' . INSPIRY_DESIGN_VARIATION . '/partials/page/membership' );
}
