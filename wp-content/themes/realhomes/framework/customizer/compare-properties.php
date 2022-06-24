<?php
/**
 * Section: Compare Properties
 *
 * Compare Properties customizer settings.
 *
 * @since 3.3.0
 * @package realhomes/customizer
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! function_exists( 'inspiry_compare_properties_section' ) ) {

	/**
	 * Compare Properties section of customizer.
	 *
	 * @param object $wp_customize — Instance of WP_Customize_Manager.
	 *
	 * @since 3.3.0
	 */
	function inspiry_compare_properties_section( WP_Customize_Manager $wp_customize ) {

		/**
		 * Favorites
		 */
		$wp_customize->add_section(
			'inpsiry_compare_properties', array(
				'title' => esc_html__( 'Compare Properties', 'framework' ),
				'panel' => 'inspiry_floating_features_section',
			)
		);

		/* Compare Properties Module  */
		$wp_customize->add_setting(
			'theme_compare_properties_module', array(
				'type'              => 'option',
				'default'           => 'disable',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);
		$wp_customize->add_control(
			'theme_compare_properties_module', array(
				'label'       => esc_html__( 'Compare Properties', 'framework' ),
				'description' => esc_html__( 'Select to Enable or Disable Properties Compare functionality for Properties List Templates.', 'framework' ),
				'type'        => 'radio',
				'section'     => 'inpsiry_compare_properties',
				'choices'     => array(
					'enable'  => esc_html__( 'Enable', 'framework' ),
					'disable' => esc_html__( 'Disable', 'framework' ),
				),
			)
		);

		/* Inspiry Compare Page */
		$wp_customize->add_setting(
			'inspiry_compare_page', array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'inspiry_sanitize_select',
			)
		);
		$wp_customize->add_control(
			'inspiry_compare_page', array(
				'label'           => esc_html__( 'Select Compare Page', 'framework' ),
				'description'     => esc_html__( 'Selected page should have Property Compare Template assigned to it. Also, make sure to Configure Pretty Permalinks.', 'framework' ),
				'type'            => 'select',
				'section'         => 'inpsiry_compare_properties',
				'active_callback' => 'inspiry_compare_properties_enabled',
				'choices'         => RH_Data::get_pages_array(),
			)
		);

		/* Compare Properties Title */
		$wp_customize->add_setting( 'inspiry_compare_view_title', array(
			'type'              => 'option',
			'default'           => esc_html__( 'Compare Properties', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		) );
		$wp_customize->add_control( 'inspiry_compare_view_title', array(
			'label'           => esc_html__( 'Compare Properties Title', 'framework' ),
			'type'            => 'text',
			'section'         => 'inpsiry_compare_properties',
			'active_callback' => 'inspiry_compare_properties_enabled',
		) );

		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'inspiry_compare_view_title', array(
				'selector'            => '.rh_compare .title',
				'container_inclusive' => false,
				'render_callback'     => 'inspiry_compare_view_title_render',
			) );
		}

		/* Compare Properties Limit Notification */
		$wp_customize->add_setting( 'inspiry_compare_action_notification', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'default'           => esc_html__( 'You can only compare 4 properties, any new property added will replace the first one from the comparison.', 'framework' ),
			'sanitize_callback' => 'esc_textarea',
		) );
		$wp_customize->add_control( 'inspiry_compare_action_notification', array(
			'label'           => esc_html__( 'Properties Comparison Limit Notification', 'framework' ),
			'type'            => 'textarea',
			'section'         => 'inpsiry_compare_properties',
			'active_callback' => 'inspiry_compare_properties_enabled',
		) );


		/* Compare Properties Title */
		$wp_customize->add_setting( 'inspiry_compare_button_text', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'default'           => esc_html__( 'Compare', 'framework' ),
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'inspiry_compare_button_text', array(
			'label'           => esc_html__( 'Compare Button Text', 'framework' ),
			'type'            => 'text',
			'section'         => 'inpsiry_compare_properties',
			'active_callback' => 'inspiry_compare_properties_enabled',
		) );

		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'inspiry_compare_button_text', array(
				'selector'            => '.rh_fixed_side_bar_compare .rh_compare__submit',
				'container_inclusive' => false,
				'render_callback'     => 'inspiry_compare_button_text_render',
			) );
		}

	}

	add_action( 'customize_register', 'inspiry_compare_properties_section' );
}


if ( ! function_exists( 'inspiry_compare_properties_defaults' ) ) :
	/**
	 * Set default values for url slugs settings
	 *
	 * @param object $wp_customize — Instance of WP_Customize_Manager.
	 */
	function inspiry_compare_properties_defaults( WP_Customize_Manager $wp_customize ) {
		$news_settings_ids = array(
			'theme_compare_properties_module',
			'inspiry_compare_action_notification',
		);
		inspiry_initialize_defaults( $wp_customize, $news_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_compare_properties_defaults' );
endif;


if ( ! function_exists( 'inspiry_compare_properties_enabled' ) ) {
	/**
	 * Checks if compare properties is enabled or not
	 *
	 * @return true|false
	 */
	function inspiry_compare_properties_enabled() {
		$theme_compare_properties_module = get_option( 'theme_compare_properties_module' );
		if ( 'enable' === $theme_compare_properties_module ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_compare_view_title_render' ) ) {
	function inspiry_compare_view_title_render() {
		if ( get_option( 'inspiry_compare_view_title' ) ) {
			echo esc_html( get_option( 'inspiry_compare_view_title' ) );
		}
	}
}


if ( ! function_exists( 'inspiry_compare_button_text_render' ) ) {
	function inspiry_compare_button_text_render() {
		if ( get_option( 'inspiry_compare_button_text' ) ) {
			echo esc_html( get_option( 'inspiry_compare_button_text' ) );
		}
	}
}

