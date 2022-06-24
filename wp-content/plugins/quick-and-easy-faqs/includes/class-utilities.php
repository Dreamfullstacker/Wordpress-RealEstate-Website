<?php
/**
 * It includes basic methods which will be used across both the
 * public-facing side of the site and the admin area.
 */

namespace Quick_And_Easy_FAQs\Includes;

class Utilities {


	/**
	 * The version of this plugin.
	 *
	 * @var bool $shortcode_being_used
	 */
	private $shortcode_being_used;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @var string $plugin_name
	 * @var string $version
	 */
	public function __construct() {
		$this->shortcode_being_used = false;
	}

	/**
	 * Get the value of a settings field
	 *
	 * @param string $option settings field name.
	 * @param string $section the section name this field belongs to.
	 * @param string $default default text if it's not found.
	 *
	 * @return mixed
	 */
	protected function get_option( $option, $section, $default = '' ) {

		$options = get_option( $section );

		if ( isset( $options[ $option ] ) ) {
			return $options[ $option ];
		}

		return $default;
	}

	/**
	 * Check if the faqs shortcode is used in WordPress contents
	 *
	 * @return bool
	 */
	protected function is_shortcode_being_used() {

		if ( $this->shortcode_being_used ) {
			return true;
		} else {
			global $post;
			if ( is_a( $post, 'WP_Post' ) && has_shortcode( $post->post_content, 'faqs' ) ) {
				$this->shortcode_being_used = true;
				return true;
			}
			return false;
		}
	}
}
