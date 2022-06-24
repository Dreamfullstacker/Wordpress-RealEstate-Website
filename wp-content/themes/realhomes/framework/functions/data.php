<?php
/**
 * This file contains some reusable classes for theme's code
 *
 * @package realhomes/functions
 */

class RH_Data {

	// Array of pages with page id as index and title as value
	private static $pages_array;

	/**
	 * Returns an array of pages with page id as index and title as value
	 *
	 * @return Array of pages with page id as index and title as value
	 */
	public static function get_pages_array(): array {
		if ( empty( self::$pages_array ) ) {
			$pages_objects     = get_pages();
			self::$pages_array = array( 0 => esc_html__( 'None', 'framework' ) );
			if ( 0 < count( $pages_objects ) ) {
				foreach ( $pages_objects as $single_page ) {
					self::$pages_array[ $single_page->ID ] = $single_page->post_title;
				}
			}
		}
		return self::$pages_array;
	}

}