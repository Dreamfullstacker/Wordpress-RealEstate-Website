<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 */

namespace Quick_And_Easy_FAQs\Admin;

class Admin {

		/**
		 * The ID of this plugin.
		 */
		private $plugin_name;

		/**
		 * The version of this plugin.
		 */
		private $version;

		/**
		 * Initialize the class and set its properties.
		 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

		/**
		 * Check if Gutenberg is active.
		 */
	public static function is_gutenberg_active() {
		// Gutenberg plugin is installed and activated.
		$gutenberg = ! ( false === has_filter( 'replace_editor', 'gutenberg_init' ) );

		// Block editor since 5.0.
		$block_editor = version_compare( $GLOBALS['wp_version'], '5.0-beta', '>' );

		if ( ! $gutenberg && ! $block_editor ) {
			return false;
		}

		if ( self::is_classic_editor_plugin_active() ) {
			$editor_option       = get_option( 'classic-editor-replace' );
			$block_editor_active = array( 'no-replace', 'block' );

			return in_array( $editor_option, $block_editor_active, true );
		}

		return true;
	}

		/**
		 * Check if Classic Editor plugin is active.
		 */
	public static function is_classic_editor_plugin_active() {
		if ( ! function_exists( 'is_plugin_active' ) ) {
			include_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		if ( is_plugin_active( 'classic-editor/classic-editor.php' ) ) {
			return true;
		}

		return false;
	}

		/**
		 * To log any thing for debugging purposes
		 */
	public static function log( $message ) {
		if ( WP_DEBUG === true ) {
			if ( is_array( $message ) || is_object( $message ) ) {
				error_log( print_r( $message, true ) );
			} else {
				error_log( $message );
			}
		}
	}

		/**
		 * Register the stylesheets for the admin area.
		 */
	public function enqueue_admin_styles() {

		$screen = get_current_screen();
		if ( 'faq_page_quick_and_easy_faqs' === $screen->id ) {

			// Add the color picker css file
			wp_enqueue_style( 'wp-color-picker' );

			// plugin custom css file
			wp_enqueue_style(
				$this->plugin_name,
				dirname( plugin_dir_url( __FILE__ ) ) . '/admin/css/styles-admin.css',
				array( 'wp-color-picker' ),
				$this->version,
				'all'
			);
		}
	}

		/**
		 * Register the JavaScript for the admin area.
		 */
	public function enqueue_admin_scripts() {

		$screen = get_current_screen();

		if ( 'faq_page_quick_and_easy_faqs' === $screen->id ) {

			wp_enqueue_script(
				$this->plugin_name,
				dirname( plugin_dir_url( __FILE__ ) ) . '/admin/js/admin-scripts.js',
				array( 'jquery', 'wp-color-picker' ),
				$this->version,
				false
			);
		}
	}

}
