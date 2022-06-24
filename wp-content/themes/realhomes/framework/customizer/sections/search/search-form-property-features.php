<?php
/**
 * Section: `Search Form Property Features`
 * Panel:   `Properties Search`
 *
 * @package realhomes/customizer
 * @since 3.13
 */
if ( ! function_exists( 'inspiry_search_form_property_features_customizer' ) ) {
	/**
	 * Search Form Property Features Customizer Settings.
	 *
	 * @param WP_Customize_Manager $wp_customize - Instance of WP_Customize_Manager.
	 *
	 * @since 3.13
	 */
	function inspiry_search_form_property_features_customizer( WP_Customize_Manager $wp_customize ) {

		// Search Form Property Features Section
		$wp_customize->add_section(
			'inspiry_properties_search_form_property_features', array(
			'title' => esc_html__( 'Search Form Property Features', 'framework' ),
			'panel' => 'inspiry_properties_search_panel',
		) );

		$wp_customize->add_setting( 'inspiry_search_fields_feature_search', array(
			'type'    => 'option',
			'default' => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_search_fields_feature_search', array(
			'label'       => esc_html__( 'Property Features Search Fields ', 'framework' ),
			'type'        => 'radio',
			'section'     => 'inspiry_properties_search_form_property_features',
			'choices'     => array(
				'true'  => esc_html__( 'Show', 'framework' ),
				'false'  => esc_html__( 'Hide', 'framework' ),
			),
		) );

		// Search Features Title
		$wp_customize->add_setting(
			'inspiry_search_features_title', array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'default'           => esc_html__( 'Looking for certain features', 'framework' ),
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			'inspiry_search_features_title', array(
				'label'     => esc_html__( 'Title for Features Toggle', 'framework' ),
				'type'      => 'text',
				'section'   => 'inspiry_properties_search_form_property_features',
			)
		);

		// Search Features Title Selective Refresh
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial(
				'inspiry_search_features_title', array(
					'selector'              => '.advance-search .more-option-trigger a',
					'container_inclusive'   => false,
					'render_callback'       => 'inspiry_search_features_title_render',
				)
			);
		}
	}

	add_action( 'customize_register', 'inspiry_search_form_property_features_customizer' );
}

if ( ! function_exists( 'inspiry_search_features_title_render' ) ) {
	function inspiry_search_features_title_render() {
		if ( get_option( 'inspiry_search_features_title' ) ) {
			echo '<i class="far fa-plus-square"></i>' . get_option( 'inspiry_search_features_title' );
		}
	}
}