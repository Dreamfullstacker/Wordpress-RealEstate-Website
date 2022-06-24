<?php
/**
 * Section: `Logo`
 *
 * Logo section in the Footer panel.
 *
 * @since 3.3.0
 * @package realhomes/customizer
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'inspiry_footer_logo_customizer' ) ) {

	/**
	 * Logo section in the Footer panel.
	 *
	 * @param object $wp_customize - Instance of WP_Customize_Manager.
	 * @since 3.3.0
	 */
	function inspiry_footer_logo_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Footer Logo Section
		 */
		$wp_customize->add_section( 'inspiry_footer_logo_section', array(
			'title' => esc_html__( 'Logo and Tagline', 'framework' ),
			'panel' => 'inspiry_footer_panel',
		) );

		/**
		 * Enable Footer Logo
		 */
		$wp_customize->add_setting( 'inspiry_enable_footer_logo', array(
			'type' => 'option',
			'transport' => 'postMessage',
			'default' => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_enable_footer_logo', array(
			'label' => esc_html__( 'Enable Logo', 'framework' ),
			'type' => 'radio',
			'section' => 'inspiry_footer_logo_section',
			'choices' => array(
				'true' => esc_html__( 'Yes', 'framework' ),
				'false' => esc_html__( 'No', 'framework' ),
			),
		) );

		// Selective refresh for Footer Logo.
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'inspiry_enable_footer_logo', array(
				'selector' => '.rh_footer__logo a',
				'container_inclusive' => false,
				'render_callback' => 'inspiry_enable_footer_logo_render',
			) );
		}

		/**
		 * Footer Logo
		 */
		$wp_customize->add_setting( 'inspiry_footer_logo', array(
			'type' => 'option',
			'transport' => 'postMessage',
			'default' => INSPIRY_DIR_URI . '/images/logo.png',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				'inspiry_footer_logo',
				array(
					'label' => esc_html__( 'Logo', 'framework' ),
					'description' => esc_html__( 'Select a logo for your footer.', 'framework' ),
					'section' => 'inspiry_footer_logo_section',
				)
			)
		);

		// Selective refresh for Footer Logo.
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'inspiry_footer_logo', array(
				'selector' => '.rh_footer__logo a',
				'container_inclusive' => false,
				'render_callback' => 'inspiry_footer_logo_render',
			) );
		}

		/**
		 * Enable Footer Tagline
		 */
		$wp_customize->add_setting( 'inspiry_enable_footer_tagline', array(
			'type' => 'option',
			'transport' => 'postMessage',
			'default' => 'true',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_enable_footer_tagline', array(
			'label' => esc_html__( 'Enable Tagline', 'framework' ),
			'type' => 'radio',
			'section' => 'inspiry_footer_logo_section',
			'choices' => array(
				'true' => esc_html__( 'Yes', 'framework' ),
				'false' => esc_html__( 'No', 'framework' ),
			),
		) );

		// Selective refresh for Footer Tagline.
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'inspiry_enable_footer_tagline', array(
				'selector' => '.rh_footer__logo .tag-line .text',
				'container_inclusive' => false,
				'render_callback' => 'inspiry_enable_footer_tagline_render',
			) );
		}

		/**
		 * Footer Tagline
		 */
		$wp_customize->add_setting( 'inspiry_footer_tagline', array(
			'type' => 'option',
			'transport' => 'postMessage',
			'default' => esc_html__( 'Simply #1 Real Estate Theme', 'framework' ),
			'sanitize_callback' => 'wp_kses_data',
		) );
		$wp_customize->add_control( 'inspiry_footer_tagline', array(
			'label' => esc_html__( 'Tagline', 'framework' ),
			'type' => 'textarea',
			'section' => 'inspiry_footer_logo_section',
		) );

		// Selective refresh for Footer Tagline.
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'inspiry_footer_tagline', array(
				'selector' => '.rh_footer__logo .tag-line .text',
				'container_inclusive' => false,
				'render_callback' => 'inspiry_footer_tagline_render',
			) );
		}

	}

	add_action( 'customize_register', 'inspiry_footer_logo_customizer' );
}

if ( ! function_exists( 'inspiry_footer_logo_defaults' ) ) :

	/**
	 * Default values initializer method.
	 *
	 * @param object $wp_customize - Instance of WP_Customize_Manager.
	 * @since  3.3.0
	 */
	function inspiry_footer_logo_defaults( WP_Customize_Manager $wp_customize ) {
		$footer_logo_settings_ids = array(
			'inspiry_enable_footer_logo',
			'inspiry_footer_logo',
			'inspiry_enable_footer_tagline',
			'inspiry_footer_tagline',
		);
		inspiry_initialize_defaults( $wp_customize, $footer_logo_settings_ids );
	}
	add_action( 'customize_save_after', 'inspiry_footer_logo_defaults' );
endif;


if ( ! function_exists( 'inspiry_enable_footer_logo_render' ) ) {

	/**
	 * Selective refresh callback for footer logo.
	 *
	 * @author Ashar Irfan
	 * @since  3.3.0
	 */
	function inspiry_enable_footer_logo_render() {
		$footer_logo_enable = get_option( 'inspiry_enable_footer_logo' );
		if ( ! empty( $footer_logo_enable ) && 'true' === $footer_logo_enable ) :
			?>
			<img src="<?php echo esc_url( get_option( 'inspiry_footer_logo' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>">
			<?php
		endif;
	}
}


if ( ! function_exists( 'inspiry_footer_logo_render' ) ) {

	/**
	 * Selective refresh callback for footer logo.
	 *
	 * @author Ashar Irfan
	 * @since  3.3.0
	 */
	function inspiry_footer_logo_render() {
		if ( get_option( 'inspiry_footer_logo' ) ) :
			?>
			<img src="<?php echo esc_url( get_option( 'inspiry_footer_logo' ) ); ?>" alt="<?php bloginfo( 'name' ); ?>">
			<?php
		endif;
	}
}

if ( ! function_exists( 'inspiry_enable_footer_tagline_render' ) ) {

	/**
	 * Selective refresh callback for footer logo.
	 *
	 * @author Ashar Irfan
	 * @since  3.3.0
	 */
	function inspiry_enable_footer_tagline_render() {
		$footer_tagline_enable = get_option( 'inspiry_enable_footer_tagline' );
		if ( ! empty( $footer_tagline_enable ) && 'true' === $footer_tagline_enable ) :
			echo esc_html( get_option( 'inspiry_footer_tagline' ) );
		endif;
	}
}

if ( ! function_exists( 'inspiry_footer_tagline_render' ) ) {

	/**
	 * Selective refresh callback for footer tagline.
	 *
	 * @author Ashar Irfan
	 * @since  3.3.0
	 */
	function inspiry_footer_tagline_render() {
		if ( get_option( 'inspiry_footer_tagline' ) ) {
			echo esc_html( get_option( 'inspiry_footer_tagline' ) );
		}
	}
}
