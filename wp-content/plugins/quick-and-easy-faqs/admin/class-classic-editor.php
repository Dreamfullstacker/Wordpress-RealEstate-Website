<?php
/**
 * TinyMCE - Classic Editor Button for FAQs
 */

namespace Quick_And_Easy_FAQs\Admin;

class Classic_Editor {


		/**
		 * Enqueue TinyMCE Plugin Script with its ID.
		 */
	public function enqueue_plugin_scripts( $plugin_array ) {
		$plugin_array['faqs_button'] = dirname( plugin_dir_url( __FILE__ ) ) . '/admin/js/classic-editor-button.js';

		return $plugin_array;
	}

		/**
		 * Register Button with its ID.
		 */
	public function register_buttons_editor( $buttons ) {
		array_push( $buttons, 'faqs' );

		return $buttons;
	}

}

