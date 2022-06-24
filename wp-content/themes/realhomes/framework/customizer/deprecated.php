<?php
/**
 * Deprecated Settings
 *
 * @package realhomes/customizer
 */
if ( ! function_exists( 'inspiry_deprecated_customizer_settings' ) ) {
	function inspiry_deprecated_customizer_settings( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_panel( 'inspiry_deprecated_settings_panel', array(
			'title'       => esc_html__( 'Deprecated', 'framework' ),
			'description' => sprintf( '<p>%s</p>', esc_html__( 'Settings in this panel are deprecated and we don’t recommend you to use these settings.', 'framework' ) ),
			'priority'    => 141,
		) );

		/* Users or Members Section */
		$wp_customize->add_section( 'inspiry_members_basic', array(
			'title'       => esc_html__( 'Users or Members', 'framework' ),
			'description' => sprintf( '<p>%s</p>', esc_html__( 'Settings in this section are deprecated in 3.12 version and we don’t recommend you to use these settings.', 'framework' ) ),
			'panel'       => 'inspiry_deprecated_settings_panel',
		) );

		/* Edit Profile Page */
		$wp_customize->add_setting( 'inspiry_edit_profile_page', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'inspiry_edit_profile_page', array(
			'label'       => esc_html__( 'Select Edit Profile Page', 'framework' ),
			'description' => esc_html__( 'Selected page should have Edit Profile Template assigned to it.', 'framework' ),
			'type'        => 'select',
			'section'     => 'inspiry_members_basic',
			'choices'     => RH_Data::get_pages_array(),
		) );

		/* Submit Property Page */
		$wp_customize->add_setting( 'inspiry_submit_property_page', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'inspiry_submit_property_page', array(
			'label'       => esc_html__( 'Select Submit Property Page', 'framework' ),
			'description' => esc_html__( 'Selected page should have Submit Property Template assigned to it.', 'framework' ),
			'type'        => 'select',
			'section'     => 'inspiry_members_basic',
			'choices'     => RH_Data::get_pages_array(),
		) );

		/* My Properties Page */
		$wp_customize->add_setting( 'inspiry_my_properties_page', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'inspiry_my_properties_page', array(
			'label'       => esc_html__( 'Select My Properties Page', 'framework' ),
			'description' => esc_html__( 'Selected page should have My Properties Template assigned to it.', 'framework' ),
			'type'        => 'select',
			'section'     => 'inspiry_members_basic',
			'choices'     => RH_Data::get_pages_array(),
		) );

		/* My Favorites Page */
		$wp_customize->add_setting( 'inspiry_favorites_page', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'inspiry_favorites_page', array(
			'label'       => esc_html__( 'Select Favorite Properties Page', 'framework' ),
			'description' => esc_html__( 'Selected page should have Favorite Properties Template assigned to it.', 'framework' ),
			'type'        => 'select',
			'section'     => 'inspiry_members_basic',
			'choices'     => RH_Data::get_pages_array(),
		) );

		/* Membership Page */
		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting( 'inspiry_membership_page', array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'inspiry_sanitize_select',
			) );
			$wp_customize->add_control( 'inspiry_membership_page', array(
				'label'       => esc_html__( 'Select Memberships Page', 'framework' ),
				'description' => esc_html__( 'Selected page should have Memberships Template assigned to it.', 'framework' ),
				'type'        => 'select',
				'section'     => 'inspiry_members_basic',
				'choices'     => RH_Data::get_pages_array(),
			) );

			/* Header Variation */
			$wp_customize->add_setting( 'inspiry_member_pages_header_variation', array(
				'type'              => 'option',
				'default'           => 'banner',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			) );

			$wp_customize->add_control( 'inspiry_member_pages_header_variation', array(
				'label'       => esc_html__( 'Header Variation', 'framework' ),
				'description' => esc_html__( 'Header variation to display on member pages.', 'framework' ),
				'type'        => 'radio',
				'section'     => 'inspiry_members_basic',
				'choices'     => array(
					'banner' => esc_html__( 'Banner', 'framework' ),
					'none'   => esc_html__( 'None', 'framework' ),
				),
			) );
		}
	}

	add_action( 'customize_register', 'inspiry_deprecated_customizer_settings' );
}