<?php
/**
 * Columns Shortcodes
 */

// columns wrapper
if ( ! function_exists( 'ere_show_columns' ) ) {
	function ere_show_columns( $atts, $content = null ) {
		return '<div class="row-fluid">' . do_shortcode( $content ) . '</div>';
	}
}
add_shortcode( 'columns', 'ere_show_columns' );

// single column
if ( ! function_exists( 'ere_show_single_column' ) ) {
	function ere_show_single_column( $atts, $content = null ) {
		return '<div class="span12">' . do_shortcode( $content ) . '</div>';
	}
}
add_shortcode( 'single_column', 'ere_show_single_column' );

// two columns
if ( ! function_exists( 'ere_show_two_column' ) ) {
	function ere_show_two_column( $atts, $content = null ) {
		return '<div class="span6">' . do_shortcode( $content ) . '</div>';
	}
}
add_shortcode( 'one_half', 'ere_show_two_column' );

// three columns
if ( ! function_exists( 'ere_show_one_third' ) ) {
	function ere_show_one_third( $atts, $content = null ) {
		return '<div class="span4">' . do_shortcode( $content ) . '</div>';
	}
}
add_shortcode( 'one_third', 'ere_show_one_third' );


// four columns
if ( ! function_exists( 'ere_show_one_fourth' ) ) {
	function ere_show_one_fourth( $atts, $content = null ) {
		return '<div class="span3">' . do_shortcode( $content ) . '</div>';
	}
}
add_shortcode( 'one_fourth', 'ere_show_one_fourth' );

// six columns
if ( ! function_exists( 'ere_show_one_sixth' ) ) {
	function ere_show_one_sixth( $atts, $content = null ) {
		return '<div class="span2">' . do_shortcode( $content ) . '</div>';
	}
}
add_shortcode( 'one_sixth', 'ere_show_one_sixth' );

// three columns
if ( ! function_exists( 'ere_show_three_fourth' ) ) {
	function ere_show_three_fourth( $atts, $content = null ) {
		return '<div class="span9">' . do_shortcode( $content ) . '</div>';
	}
}
add_shortcode( 'three_fourth', 'ere_show_three_fourth' );
