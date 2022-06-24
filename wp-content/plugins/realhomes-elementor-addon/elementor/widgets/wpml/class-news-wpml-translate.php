<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_News_WPML_Translate {

	public function __construct() {
		add_filter( 'wpml_elementor_widgets_to_translate', [
			$this,
			'inspiry_news_to_translate'
		] );
	}

	public function inspiry_news_to_translate( $widgets ) {

		$widgets['ere-news-widget-home'] = [
			'conditions' => [ 'widgetType' => 'ere-news-widget-home' ],
			'fields'     => [
				[
					'field'       => 'ere_news_in_label',
					'type'        => esc_html__( 'News: In', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],
				[
					'field'       => 'ere_news_by_label',
					'type'        => esc_html__( 'News: By', 'realhomes-elementor-addon' ),
					'editor_type' => 'LINE'
				],

			],
		];

		return $widgets;

	}
}

new RHEA_News_WPML_Translate();