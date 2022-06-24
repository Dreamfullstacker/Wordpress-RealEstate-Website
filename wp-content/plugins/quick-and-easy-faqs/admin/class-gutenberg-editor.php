<?php
/**
 * Gutenberg Blocks for FAQs
 */

namespace Quick_And_Easy_FAQs\Admin;

class Gutenberg_Editor {

	/**
	 * Adding new block category for FAQs
	 */
	public function add_faqs_block_category( $categories ) {

		$categories[] = array(
			'slug'  => 'quick-and-easy-faqs',
			'title' => __( 'Quick and Easy FAQs', 'quick-and-easy-faqs' ),
		);

		return $categories;

	}

	/**
	 * Adding all the blocks for FAQs
	 */
	public function add_all_faqs_block() {

		wp_register_script(
			'quick-and-easy-faqs-block',
			dirname( plugin_dir_url( __FILE__ ) ) . '/admin/js/gutenberg-blocks-faqs.js',
			array( 'wp-blocks', 'wp-element' ),
			'',
			true
		);

		register_block_type(
			'quick-and-easy-faqs/faqs-only',
			array(
				'editor_script' => 'quick-and-easy-faqs-block',
			)
		);

		register_block_type(
			'quick-and-easy-faqs/faqs-grouped',
			array(
				'editor_script' => 'quick-and-easy-faqs-block',
			)
		);

		register_block_type(
			'quick-and-easy-faqs/faqs-toggle',
			array(
				'editor_script' => 'quick-and-easy-faqs-block',
			)
		);

		register_block_type(
			'quick-and-easy-faqs/faqs-accordion',
			array(
				'editor_script' => 'quick-and-easy-faqs-block',
			)
		);

		register_block_type(
			'quick-and-easy-faqs/faqs-toggle-grouped',
			array(
				'editor_script' => 'quick-and-easy-faqs-block',
			)
		);

		register_block_type(
			'quick-and-easy-faqs/faqs-accordion-grouped',
			array(
				'editor_script' => 'quick-and-easy-faqs-block',
			)
		);

		register_block_type(
			'quick-and-easy-faqs/faqs-filterable-toggle',
			array(
				'editor_script' => 'quick-and-easy-faqs-block',
			)
		);

		register_block_type(
			'quick-and-easy-faqs/faqs-filterable-accordion',
			array(
				'editor_script' => 'quick-and-easy-faqs-block',
			)
		);

		register_block_type(
			'quick-and-easy-faqs/faqs-orderby-title-asc',
			array(
				'editor_script' => 'quick-and-easy-faqs-block',
			)
		);

		register_block_type(
			'quick-and-easy-faqs/faqs-orderby-title-desc',
			array(
				'editor_script' => 'quick-and-easy-faqs-block',
			)
		);

		register_block_type(
			'quick-and-easy-faqs/faqs-toggle-orderby-title-asc',
			array(
				'editor_script' => 'quick-and-easy-faqs-block',
			)
		);

		register_block_type(
			'quick-and-easy-faqs/faqs-toggle-orderby-title-desc',
			array(
				'editor_script' => 'quick-and-easy-faqs-block',
			)
		);

		register_block_type(
			'quick-and-easy-faqs/faqs-accordion-orderby-title-asc',
			array(
				'editor_script' => 'quick-and-easy-faqs-block',
			)
		);

		register_block_type(
			'quick-and-easy-faqs/faqs-accordion-orderby-title-desc',
			array(
				'editor_script' => 'quick-and-easy-faqs-block',
			)
		);

	}

}
