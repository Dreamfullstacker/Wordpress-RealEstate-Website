<?php
/**
 * Template Name: Contact
 *
 * @package realhomes/templates
 */

do_action( 'inspiry_before_contact_page_render', get_the_ID() );

get_template_part( 'assets/' . INSPIRY_DESIGN_VARIATION . '/partials/page/contact' );
