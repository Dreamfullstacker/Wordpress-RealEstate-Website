<?php
/**
 * Section: `Gallery`
 * Panel:   `Property Detail Page`
 *
 * @since 3.10
 */

if ( ! function_exists( 'inspiry_property_gallery_customizer' ) ) :
	/**
	 * @param  WP_Customize_Manager $wp_customize
	 * @since  3.10
	 */
	function inspiry_property_gallery_customizer( WP_Customize_Manager $wp_customize ) {
		/**
		 * Gallery Section
		 */
		$wp_customize->add_section(
			'inspiry_property_gallery',
			array(
				'title' => esc_html__( 'Gallery', 'framework' ),
				'panel' => 'inspiry_property_panel',
				'priority' => 5
			)
		);

		$gallery_slider_type_choices = array(
			'thumb-on-right'  => esc_html__( 'Gallery with Thumbnails on Right', 'framework' ),
			'thumb-on-bottom' => esc_html__( 'Gallery with Thumbnails on Bottom', 'framework' ),
		);

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$gallery_slider_type_choices['thumb-on-right']    = esc_html__( 'Default Gallery', 'framework' );
			$gallery_slider_type_choices['thumb-on-bottom']   = esc_html__( 'Gallery with Thumbnails', 'framework' );
			$gallery_slider_type_choices['img-pagination']    = esc_html__( 'Gallery with Thumbnails Two', 'framework' );
			$gallery_slider_type_choices['masonry-style']     = esc_html__( 'Masonry', 'framework' );
			$gallery_slider_type_choices['carousel-style']    = esc_html__( 'Carousel', 'framework' );
			$gallery_slider_type_choices['fw-carousel-style'] = esc_html__( 'Full Width Carousel', 'framework' );

		}

		/* Gallery Type */
		$wp_customize->add_setting(
			'inspiry_gallery_slider_type',
			array(
				'type'              => 'option',
				'default'           => 'thumb-on-right',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);
		$wp_customize->add_control(
			'inspiry_gallery_slider_type',
			array(
				'label'   => esc_html__( 'Gallery Type', 'framework' ),
				'type'    => 'select',
				'section' => 'inspiry_property_gallery',
				'choices' => $gallery_slider_type_choices,
			)
		);

		/* Display Image Title in Lightbox */
		$wp_customize->add_setting(
			'inspiry_display_title_in_lightbox',
			array(
				'type'              => 'option',
				'default'           => 'false',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);
		$wp_customize->add_control(
			'inspiry_display_title_in_lightbox',
			array(
				'label'   => esc_html__( 'Image title in gallery lightbox.', 'framework' ),
				'type'    => 'radio',
				'section' => 'inspiry_property_gallery',
				'choices' => array(
					'true'  => esc_html__( 'Show', 'framework' ),
					'false' => esc_html__( 'Hide', 'framework' ),
				),
			)
		);

		$wp_customize->add_setting(
			'inspiry_image_size_full_width',
			array(
				'type'              => 'option',
				'default'           => 'false',
				'sanitize_callback' => 'inspiry_sanitize_radio',
			)
		);
		$wp_customize->add_control(
			'inspiry_image_size_full_width',
			array(
				'label'   => esc_html__( 'Full Width Property Template Slider Image Size', 'framework' ),
				'type'    => 'radio',
				'section' => 'inspiry_property_gallery',
				'choices' => array(
					'cover'   => esc_html__( 'Cover', 'framework' ),
					'contain' => esc_html__( 'Contain', 'framework' ),
				),
			)
		);

		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$wp_customize->add_setting(
				'inspiry_masonry_gallery_count_text',
				array(
					'type'              => 'option',
					'default'           => 'See All Photos',
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			$wp_customize->add_control(
				'inspiry_masonry_gallery_count_text',
				array(
					'label'   => esc_html__( 'Masonry Gallery Count Text', 'framework' ),
					'type'    => 'text',
					'section' => 'inspiry_property_gallery',
				)
			);
		}
	}

	add_action( 'customize_register', 'inspiry_property_gallery_customizer' );
endif;

if ( ! function_exists( 'inspiry_property_gallery_defaults' ) ) :
	/**
	 * @since 3.10
	 */
	function inspiry_property_gallery_defaults( WP_Customize_Manager $wp_customize ) {
		$property_gallery_slider_settings_ids = array(
			'inspiry_gallery_slider_type',
			'inspiry_display_title_in_lightbox',
		);

		inspiry_initialize_defaults( $wp_customize, $property_gallery_slider_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_property_gallery_defaults' );
endif;
