<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Classic_News_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_classic_news_to_translate'
		] );

	}

	public function inspiry_classic_news_to_translate( $widgets ) {

		$widgets['ere-classic-news-section-widget'] = [
			'conditions' => [ 'widgetType' => 'ere-classic-news-section-widget' ],
			'fields'     => [
				[
					'field'       => 'ere_news_on',
					'type'        => esc_html__( 'Classic News: On', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_news_by',
					'type'        => esc_html__( 'Classic News: By', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_news_read_more',
					'type'        => esc_html__( 'Classic News: Read More', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],

			],
		];

		return $widgets;

	}
}

new RHEA_Classic_News_WPML_Translate();