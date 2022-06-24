<?php
/**
 * Section:    `Layout`
 * Panel:    `Footer`
 *
 * @since 3.5.0
 */

//if ( ! function_exists( 'inspiry_footer_layout_customizer' ) ) :

	/**
	 * inspiry_footer_layout_customizer.
	 *
	 * @param  WP_Customize_Manager $wp_customize
	 *
	 * @since  3.5.0
	 */
	function inspiry_footer_layout_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Footer Layout Settings
		 */
		$wp_customize->add_section( 'inspiry_footer_layout', array(
			'title' => esc_html__( 'Widgets', 'framework' ),
			'panel' => 'inspiry_footer_panel',
		) );

		/* Footer Columns */
		$default_columns = 4;
		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$default_columns = 3;
		}

		$wp_customize->add_setting(
			'inspiry_footer_columns', array(
				'type'    => 'option',
				'default' => $default_columns,
				'sanitize_callback' => 'inspiry_sanitize_select',
			)
		);

		$footer_columns = array(
			'1' => esc_html__( 'One Column', 'framework' ),
			'2' => esc_html__( 'Two Columns', 'framework' ),
			'3' => esc_html__( 'Three Columns', 'framework' ),
			'4' => esc_html__( 'Four Columns', 'framework' ),
		);


		$wp_customize->add_control(
			'inspiry_footer_columns', array(
				'label'       => esc_html__( 'Layout', 'framework' ),
				'description' => esc_html__( 'Select the number of footer widgets columns you want to use.', 'framework' ),
				'type'        => 'select',
				'section'     => 'inspiry_footer_layout',
				'choices'     => $footer_columns,
			)
		);
	}

	add_action( 'customize_register', 'inspiry_footer_layout_customizer' );
//endif;