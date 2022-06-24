<?php
/**
 * Customizer:    `Site Logo`
 *
 * @since 2.6.3
 */


if ( ! function_exists( 'inspiry_site_logo_customizer' ) ) :
	function inspiry_site_logo_customizer( WP_Customize_Manager $wp_customize ) {

		/**
		 * Site Identity (logo)
		 */
		$wp_customize->add_setting( 'theme_sitelogo', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'theme_sitelogo', array(
			'label'    => esc_html__( 'Site Logo', 'framework' ),
			'section'  => 'title_tagline',
			// id of site identity section - Ref: https://developer.wordpress.org/themes/advanced-topics/customizer-api/.
			'settings' => 'theme_sitelogo',
			'priority' => 1,
		) ) );


		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$selective_selectors = '#logo, .rh_logo';
		}else{
			$selective_selectors = '.rh_logo_selective_refresh';
		}

		/* Site Logo Selective Refresh */
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'theme_sitelogo', array(
				'selector'            => $selective_selectors,
				'container_inclusive' => false,
				'render_callback'     => 'inspiry_site_logo_render',
			) );
		}

		/**
		 * Site Identity ( retina logo)
		 */
		$wp_customize->add_setting( 'theme_sitelogo_retina', array(
			'type'              => 'option',
			'transport'         => 'postMessage',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'theme_sitelogo_retina', array(
			'label'       => esc_html__( 'Site Retina Logo', 'framework' ),
			'description' => esc_html__( 'Upload double size of your default logo image. For example, if your default logo image size is 150px by 50px, your retina logo image size should be 300px by 100px.', 'framework' ),
			'section'     => 'title_tagline',
			'settings'    => 'theme_sitelogo_retina',
			'priority'    => 2,
		) ) );


		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {

			$wp_customize->add_setting( 'inspiry_site_logo_separator', array( 'sanitize_callback' => 'sanitize_text_field', ) );
			$wp_customize->add_control(
				new Inspiry_Separator_Control(
					$wp_customize,
					'inspiry_site_logo_separator',
					array(
						'section'  => 'title_tagline',
						'priority' => 3,
					)
				)
			);

			/**
			 * Site Logo Mobile
			 */
			$wp_customize->add_setting( 'theme_sitelogo_mobile', array(
				'type'              => 'option',
				'sanitize_callback' => 'esc_url_raw',
			) );
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'theme_sitelogo_mobile', array(
				'label'       => esc_html__( 'Site Logo For Mobile', 'framework' ),
				'description' => esc_html__( 'Logo for mobile devices. Default Site Logo will be appeared if no image is selected', 'framework' ),
				'section'     => 'title_tagline',
				'settings'    => 'theme_sitelogo_mobile',
				'priority'    => 4,
			) ) );

			/**
			 * Site Retina Logo Mobile
			 */
			$wp_customize->add_setting( 'theme_sitelogo_retina_mobile', array(
				'type'              => 'option',
				'transport'         => 'postMessage',
				'sanitize_callback' => 'esc_url_raw',
			) );
			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'theme_sitelogo_retina_mobile', array(
				'label'       => esc_html__( 'Site Retina Logo For Mobile', 'framework' ),
				'description' => esc_html__( 'Upload double size of your default logo image. For example, if your default logo image size is 150px by 50px, your retina logo image size should be 300px by 100px.', 'framework' ),
				'section'     => 'title_tagline',
				'settings'    => 'theme_sitelogo_retina_mobile',
				'priority'    => 5,
			) ) );

		}

		/* Site Retina Logo Selective Refresh */
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'theme_sitelogo_retina', array(
				'selector'            => '#logo, .rh_logo',
				'container_inclusive' => false,
				'render_callback'     => 'inspiry_site_logo_render',
			) );
		}

		// Site Name.
		$wp_customize->get_setting( 'blogname' )->transport = 'postMessage';
		/* Site Name Selective Refresh */
		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'blogname', array(
				'selector'            => '.rh_logo_selective_refresh',
				'container_inclusive' => false,
				'render_callback'     => 'inspiry_site_logo_render',
			) );
		}

		// Site Description.
		$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';
		/* Site Description Selective Refresh */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			if ( isset( $wp_customize->selective_refresh ) ) {
				$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
					'selector'            => '#logo .tag-line span',
					'container_inclusive' => false,
					'render_callback'     => 'inspiry_site_desc_render',
				) );
			}
		}

		$wp_customize->add_setting( 'inspiry_logo_filter_for_print', array(
			'type'              => 'option',
			'default'           => 'none',
			'sanitize_callback' => 'inspiry_sanitize_select',
		) );
		$wp_customize->add_control( 'inspiry_logo_filter_for_print', array(
			'label'       => esc_html__( 'Site Logo Filter for Print', 'framework' ),
			'description' => esc_html__( 'Select filter for site logo to improve its readability in print.', 'framework' ),
			'type'        => 'select',
			'section'     => 'title_tagline',
			'priority'    => 6,
			'choices'     => array(
				'none'      => esc_html__( 'None', 'framework' ),
				'contrast'  => esc_html__( 'Contrast', 'framework' ),
				'grayscale' => esc_html__( 'Grayscale', 'framework' ),
				'invert'    => esc_html__( 'Invert', 'framework' ),
			)
		) );
	}

	add_action( 'customize_register', 'inspiry_site_logo_customizer' );
endif;

if ( ! function_exists( 'inspiry_site_logo_render' ) ) {
	function inspiry_site_logo_render() {
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			if ( get_option( 'theme_sitelogo' ) ) {
				echo '<a href="' . esc_url( home_url( '/' ) ) . '"><img src="' . esc_url( get_option( 'theme_sitelogo' ) ) . '" alt="' . esc_html( get_bloginfo( 'name' ) ) . '"></a>';
			} elseif ( get_option( 'theme_sitelogo_retina' ) ) {
				echo '<a href="' . esc_url( home_url( '/' ) ) . '"><img src="' . esc_url( get_option( 'theme_sitelogo_retina' ) ) . '" alt="' . esc_html( get_bloginfo( 'name' ) ) . '"></a>';
			} elseif ( get_bloginfo( 'name' ) ) {
				echo '<h2 class="logo-heading"><a href="' . esc_url( home_url( '/' ) ) . '">';
				bloginfo( 'name' );
				echo '</a></h2>';
			}
			$description = get_bloginfo( 'description' );
			if ( $description ) {
				echo '<div class="tag-line"><span>';
				echo esc_html( $description );
				echo '</span></div>';
			}
		} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			if ( get_option( 'theme_sitelogo' ) ) {
				echo '<a href="' . esc_url( home_url('/') ) . '"><img src="' . esc_url( get_option( 'theme_sitelogo' ) ) . '" alt="' . esc_html( get_bloginfo( 'name' ) ) . '"></a>';
			} elseif ( get_option( 'theme_sitelogo_retina' ) ) {
				echo '<a href="' . esc_url( home_url( '/' ) ) . '"><img src="' . esc_url( get_option( 'theme_sitelogo_retina' ) ) . '" alt="' . esc_html( get_bloginfo( 'name' ) ) . '"></a>';
			} elseif ( get_bloginfo( 'name' ) ) {
				echo '<h2 class="rh_logo__heading"><a href="' . esc_url( home_url() ) . '">';
				bloginfo( 'name' );
				echo '</a></h2>';
			}
		}
	}
}

if ( ! function_exists( 'inspiry_site_desc_render' ) ) {
	function inspiry_site_desc_render() {
		$description = get_bloginfo( 'description' );
		if ( $description && ( 'classic' === INSPIRY_DESIGN_VARIATION ) ) {
			echo esc_html( $description );
		} elseif ( $description && ( 'modern' === INSPIRY_DESIGN_VARIATION ) ) {
			echo '<span class="separator">/</span>' . esc_html( $description );
		}
	}
}