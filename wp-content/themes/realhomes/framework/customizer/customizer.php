<?php
/**
 * Customizer
 *
 * @package realhomes/customizer
 */
if ( ! function_exists( 'inspiry_customize_register_init' ) ) {
	/**
	 * Modify default customizer settings
	 */
	function inspiry_customize_register_init( $wp_customize ) {
		$wp_customize->get_section( 'background_image' )->panel = 'inspiry_styles_panel';
	}

	add_action( 'customize_register', 'inspiry_customize_register_init' );
}

if ( ! function_exists( 'inspiry_initialize_defaults' ) ) :
	/**
	 * Helper function to initialize default values for settings as customizer api do not do so by default.
	 *
	 * @param WP_Customize_Manager $wp_customize - Instance of WP_Customize_Manager.
	 * @param $inspiry_settings_ids - Settings ID of the theme.
	 *
	 * @since 1.0.0
	 */
	function inspiry_initialize_defaults( WP_Customize_Manager $wp_customize, $inspiry_settings_ids ) {
		if ( is_array( $inspiry_settings_ids ) && ! empty( $inspiry_settings_ids ) ) {
			foreach ( $inspiry_settings_ids as $setting_id ) {
				$setting = $wp_customize->get_setting( $setting_id );
				if ( $setting ) {
					add_option( $setting->id, $setting->default );
				}
			}
		}
	}
endif;

if ( ! function_exists( 'inspiry_enqueue_customizer_css' ) ) :
	/**
	 * Enqueue Customizer css file.
	 */
	function inspiry_enqueue_customizer_css() {
		wp_enqueue_style( 'inspiry-customizer', get_theme_file_uri( 'framework/customizer/custom/css/style.css' ), array(), null, 'all' );
	}

	add_action( 'customize_controls_print_styles', 'inspiry_enqueue_customizer_css' );
endif;

if ( ! function_exists( 'inspiry_enqueue_customizer_js' ) ) :
	/**
	 * Enqueue Customizer JS file.
	 *
	 * @todo Figure out why postMessage method isn't working.
	 * @since 4.6.2
	 */
	function inspiry_enqueue_customizer_js() {

		// Common customizer preview js file.
		wp_enqueue_script(
			'inspiry_customizer_preview',
			get_theme_file_uri( 'framework/customizer/js/customizer-preview.js' ),
			array( 'jquery', 'customize-preview' ),
			null,
			true
		);

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			wp_enqueue_script(
				'customizer_js',
				get_theme_file_uri( 'framework/customizer/js/customizer.js' ),
				array( 'jquery', 'customize-preview' ),
				'',
				true
			);
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			wp_enqueue_script(
				'customizer_js',
				get_theme_file_uri( 'assets/modern/scripts/js/customizer.js' ),
				array( 'jquery', 'customize-preview' ),
				'',
				true
			);
		}
	}

	add_action( 'customize_preview_init', 'inspiry_enqueue_customizer_js', 100, 0 );
endif;

if ( ! function_exists( 'inspiry_customize_control_js' ) ) :
	/**
	 * Enqueue Customizer Control JS file.
	 *
	 * @since 3.15
	 */
	function inspiry_customize_control_js() {
		// Common customizer control js file.
		wp_enqueue_script( 'inspiry_customizer_control',
			get_theme_file_uri( 'framework/customizer/js/customizer-control.js' ),
			array( 'customize-controls', 'jquery' ),
			null,
			true
		);
	}

	add_action( 'customize_controls_enqueue_scripts', 'inspiry_customize_control_js' );
endif;

if ( ! function_exists( 'inspiry_load_customize_controls' ) ) :
	/**
	 * Load custom controls
	 */
	function inspiry_load_customize_controls() {
		require_once( INSPIRY_FRAMEWORK . 'customizer/custom/control-multiple-checkbox.php' );
		require_once( INSPIRY_FRAMEWORK . 'customizer/custom/control-multiple-checkbox-sortable.php' );
		require_once( INSPIRY_FRAMEWORK . 'customizer/custom/control-heading.php' );
		require_once( INSPIRY_FRAMEWORK . 'customizer/custom/control-intro-text.php' );
		require_once( INSPIRY_FRAMEWORK . 'customizer/custom/control-radio-image.php' );
		require_once( INSPIRY_FRAMEWORK . 'customizer/custom/control-separator.php' );
		require_once( INSPIRY_FRAMEWORK . 'customizer/custom/control-dragdrop.php' );
	}

	add_action( 'customize_register', 'inspiry_load_customize_controls', 0 );
endif;

if ( ! function_exists( 'inspiry_remove_default_panels' ) ) :
	/**
	 * Remove Default Customizer Panel
	 */
	function inspiry_remove_default_panels( WP_Customize_Manager $wp_customize ) {
		$wp_customize->remove_section( "colors" );
	}

	add_action( 'customize_register', 'inspiry_remove_default_panels' );
endif;

if ( ! function_exists( 'inspiry_sanitize_checkbox' ) ) {
	function inspiry_sanitize_checkbox( $input ) {
		//returns true if checkbox is checked
		return ( $input ) ? true : false;
	}
}

if ( ! function_exists( 'inspiry_sanitize_radio' ) ) {
	function inspiry_sanitize_radio( $input, $setting ) {

		//input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
		$input = sanitize_key( $input );

		//get the list of possible radio box options
		$choices = $setting->manager->get_control( $setting->id )->choices;

		//return input if valid or return default option
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
}

if ( ! function_exists( 'inspiry_sanitize_select' ) ) {
	function inspiry_sanitize_select( $input, $setting ) {

		//input must be a slug: lowercase alphanumeric characters, dashes and underscores are allowed only
		$input = sanitize_key( $input );

		//get the list of possible select options
		$choices = $setting->manager->get_control( $setting->id )->choices;

		//return input if valid or return default option
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
}

if ( ! function_exists( 'inspiry_sanitize_select_fonts' ) ) {
	function inspiry_sanitize_select_fonts( $input, $setting ) {

		//Sanitizes a string from user input or from the database.
		$input = sanitize_text_field( $input );

		//get the list of possible select options
		$choices = $setting->manager->get_control( $setting->id )->choices;

		//return input if valid or return default option
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}
}

/**
 * Site Logo
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/site-logo.php' );

/**
 * Header Settings
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/header.php' );

/**
 * Footer Settings
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/footer.php' );

/**
 * Properties Search Settings
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/search.php' );

/**
 * Property Detail Page Settings
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/property.php' );

/**
 * Properties Templates and Archive Settings
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/properties-templates-and-archive.php' );

/**
 * Agents Settings
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/agents.php' );

/**
 * Agencies Settings
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/agencies.php' );

/**
 * Blog Page Settings
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/blog.php' );

/**
 * Gallery Page Settings
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/gallery.php' );

/**
 * Pages Settings
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/pages.php' );

/**
 * Contact Page Settings
 */
if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
	require_once( INSPIRY_FRAMEWORK . 'customizer/contact.php' );
}

/**
 * Dashboard Settings
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/dashboard.php' );

/**
 * Floating Features
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/floating-features.php' );

/**
 * language switcher
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/language-switcher.php' );

/**
 * Compare Properties Settings
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/compare-properties.php' );

/**
 * Misc Settings
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/misc.php' );

/**
 * Deprecated Settings
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/deprecated.php' );

/**
 * Styles Settings
 */
require_once( INSPIRY_FRAMEWORK . 'customizer/styles.php' );
