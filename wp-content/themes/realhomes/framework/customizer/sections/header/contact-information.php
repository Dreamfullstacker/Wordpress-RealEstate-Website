<?php
/**
 * Section:    `Contact Information`
 * Panel:    `Header`
 *
 * @since 2.6.3
 */

if ( !function_exists( 'inspiry_contact_information_customizer' ) ) :

	/**
	 * inspiry_contact_information_customizer.
	 *
	 * @param  WP_Customize_Manager $wp_customize
	 *
	 * @since  2.6.3
	 */

	function inspiry_contact_information_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Header Contact Information Section
		 */
		$wp_customize->add_section( 'inspiry_header_contact_info', array(
			'title' => esc_html__( 'Contact Information', 'framework' ),
			'panel' => 'inspiry_header_panel',
		) );

		/* Header Email */
		$wp_customize->add_setting( 'inspiry_header_email_label', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'default'           => esc_html__( 'Email us at', 'framework' ),
			'sanitize_callback' => 'esc_html',
		) );
		$wp_customize->add_control( 'inspiry_header_email_label', array(
			'label'           => esc_html__( 'Email Address Label', 'framework' ),
			'type'            => 'text',
			'section'         => 'inspiry_header_contact_info',
			'active_callback' => function() {
				return ( 'classic' === INSPIRY_DESIGN_VARIATION );
			},
		) );

		/* Header Email Label Selective Refresh */
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'inspiry_header_email_label', array(
				'selector'            => '#contact-email',
				'container_inclusive' => false,
				'render_callback'     => 'inspiry_header_email_render',
			) );
		}

		$wp_customize->add_setting( 'theme_header_email', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_email',
		) );
		$wp_customize->add_control( 'theme_header_email', array(
			'label'   => esc_html__( 'Email Address', 'framework' ),
			'type'    => 'email',
			'section' => 'inspiry_header_contact_info',
		) );

		/* Header Email Selective Refresh */
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'theme_header_email', array(
				'selector'            => '#contact-email, .rh_menu__user_email',
				'container_inclusive' => false,
				'render_callback'     => 'inspiry_header_email_render',
			) );
		}

		/* Header Phone Number */
		$wp_customize->add_setting( 'theme_header_phone', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'theme_header_phone', array(
			'label'   => esc_html__( 'Phone Number', 'framework' ),
			'type'    => 'tel',
			'section' => 'inspiry_header_contact_info',
		) );

		/* Header Email Selective Refresh */
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'theme_header_phone', array(
				'selector'            => '.contact-number',
				'container_inclusive' => false,
				'render_callback'     => 'inspiry_header_phone_render',
			) );
		}

		/* Header Phone Number Icon */
		$wp_customize->add_setting( 'theme_header_phone_icon', array(
			'type'    => 'option',
			'default' => 'phone',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'theme_header_phone_icon', array(
			'label'   => esc_html__( 'Phone Number Icon ', 'framework' ),
			'type'    => 'radio',
			'section' => 'inspiry_header_contact_info',
			'choices' => array(
				'phone'    => 'Phone',
				'whatsapp' => 'WhatsApp',
			),
		) );
	}

	add_action( 'customize_register', 'inspiry_contact_information_customizer' );
endif;


if ( !function_exists( 'inspiry_header_email_render' ) ) {
	function inspiry_header_email_render() {
		if ( get_option( 'theme_header_email' ) ) {
			$header_email = get_option( 'theme_header_email' );

			if ( 'classic' == INSPIRY_DESIGN_VARIATION ) {
				inspiry_safe_include_svg( '/images/icon-mail.svg' );
				$email_label = get_option( 'inspiry_header_email_label', esc_html__( 'Email us at', 'framework' ) );
				echo esc_html( $email_label ) . ' : ';
			} else {
				inspiry_safe_include_svg( '/images/icons/icon-mail.svg' );
			}

			echo '<a href="mailto:' . antispambot( $header_email ) . '">' . antispambot( $header_email ) . '</a>';
		}
	}
}


if ( ! function_exists( 'inspiry_header_phone_render' ) ) {
	function inspiry_header_phone_render() {
		if ( get_option( 'theme_header_phone' ) && ( 'classic' === INSPIRY_DESIGN_VARIATION ) ) {
			$header_phone      = get_option( 'theme_header_phone' );
			$header_phone_icon = get_option( 'theme_header_phone_icon', 'phone' );
			$desktop_version   = '<span class="desktop-version">' . $header_phone . '</span>';
			$mobile_version    = '<a class="mobile-version" href="tel://' . $header_phone . '" title="' . esc_attr( 'Make a Call', 'framework' ) . '">' . $header_phone . '</a>';
			if ( 'phone' === $header_phone_icon ) {
				echo ' <i class="fas fa-phone"></i> ';
			} else {
				echo ' <i class="fab fa-whatsapp"></i> ';
			}
			echo wp_kses_post( $desktop_version . $mobile_version . '<span class="outer-strip"></span>' );
		} elseif ( get_option( 'theme_header_phone' ) && ( 'modern' === INSPIRY_DESIGN_VARIATION ) ) {
			echo esc_html( get_option( 'theme_header_phone' ) );
		}
	}
}

