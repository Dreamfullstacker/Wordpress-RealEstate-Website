<?php
/**
 * Section: Sections Manager
 * Panel: Property
 *
 * @since 3.8.4
 */
if ( ! function_exists( 'inspiry_property_sections_manager_customizer' ) ) :
	function inspiry_property_sections_manager_customizer( WP_Customize_Manager $wp_customize ) {

		$wp_customize->add_section( 'inspiry_property_sections_manager', array(
			'title'    => esc_html__( 'Sections Manager', 'framework' ),
			'panel'    => 'inspiry_property_panel',
			'priority' => 1
		) );

		$wp_customize->add_setting( 'inspiry_property_sections_order_default', array(
			'default'           => 'default',
			'sanitize_callback' => 'inspiry_sanitize_radio',
		) );
		$wp_customize->add_control( 'inspiry_property_sections_order_default', array(
			'label'    => esc_html__( 'Order Settings', 'framework' ),
			'type'     => 'radio',
			'section'  => 'inspiry_property_sections_manager',
			'settings' => 'inspiry_property_sections_order_default',
			'choices'  => array(
				'default' => esc_html__( 'Default', 'framework' ),
				'custom'  => esc_html__( 'Custom', 'framework' ),
			)
		) );

		/* Property Sections Order - Classic */
		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			$property_sections_default = 'slider,content,floor-plans,video,virtual-tour,map,walkscore,yelp-nearby-places,attachments,children,agent,energy-performance,mortgage-calculator';
			$property_sections         = array(
				'slider'              => esc_html__( 'Slider', 'framework' ),
				'content'             => esc_html__( 'Content', 'framework' ),
				'floor-plans'         => esc_html__( 'Floor Plans', 'framework' ),
				'video'               => esc_html__( 'Video', 'framework' ),
				'virtual-tour'        => esc_html__( 'Virtual Tour', 'framework' ),
				'map'                 => esc_html__( 'Map', 'framework' ),
				'walkscore'           => esc_html__( 'WalkScore', 'framework' ),
				'yelp-nearby-places'  => esc_html__( 'Nearby Places', 'framework' ),
				'attachments'         => esc_html__( 'Attachments', 'framework' ),
				'children'            => esc_html__( 'Child Properties', 'framework' ),
				'agent'               => esc_html__( 'Agents', 'framework' ),
				'energy-performance'  => esc_html__( 'Energy Performance', 'framework' ),
				'mortgage-calculator' => esc_html__( 'Mortgage Calculator', 'framework' ),
			);

			// Add Property Views section if Property Analytic is enabled.
			if ( inspiry_is_property_analytics_enabled() ) {

				$property_sections = array_merge(
					$property_sections,
					array(
						'property-views' => esc_html__( 'Property Views', 'framework' ),
					)
				);

				$property_sections_default .= ',property-views';
			}

			// Add RVR related section if RVR is enabled.
			if ( inspiry_is_rvr_enabled() ) {

				$property_sections = array_merge(
					$property_sections,
					array(
						'rvr/price-details'         => esc_html__( 'Price Details', 'framework' ),
						'rvr/guests-accommodation'  => esc_html__( 'Guests Accommodation', 'framework' ),
						'rvr/seasonal-prices'       => esc_html__( 'Seasonal Prices', 'framework' ),
						'rvr/availability-calendar' => esc_html__( 'Availability Calendar', 'framework' ),
					)
				);

				$property_sections_default .= ',rvr/price-details,rvr/seasonal-prices,rvr/availability-calendar';
			}

			$wp_customize->add_setting( 'inspiry_property_sections_order', array(
				'type'              => 'option',
				'default'           => $property_sections_default,
				'sanitize_callback' => 'sanitize_text_field'
			) );

			$wp_customize->add_control( new Inspiry_Dragdrop_Control( $wp_customize, 'inspiry_property_sections_order',
				array(
					'label'       => esc_html__( 'Sections Order', 'framework' ),
					'description' => esc_html__( 'Select custom order for classic design variation.', 'framework' ),
					'section'     => 'inspiry_property_sections_manager',
					'settings'    => 'inspiry_property_sections_order',
					'choices'     => $property_sections,
				)
			) );
		}

		/* Property Sections Order - Modern */
		if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
			$property_sections_default = 'content,additional-details,common-note,features,attachments,floor-plans,video,virtual-tour,map,walkscore,yelp-nearby-places,children,agent,energy-performance,mortgage-calculator';
			$property_sections         = array(
				'content'             => esc_html__( 'Content', 'framework' ),
				'additional-details'  => esc_html__( 'Additional Details', 'framework' ),
				'common-note'         => esc_html__( 'Common Note', 'framework' ),
				'features'            => esc_html__( 'Features', 'framework' ),
				'attachments'         => esc_html__( 'Attachments', 'framework' ),
				'floor-plans'         => esc_html__( 'Floor Plans', 'framework' ),
				'video'               => esc_html__( 'Video', 'framework' ),
				'virtual-tour'        => esc_html__( 'Virtual Tour', 'framework' ),
				'map'                 => esc_html__( 'Map', 'framework' ),
				'walkscore'           => esc_html__( 'WalkScore', 'framework' ),
				'yelp-nearby-places'  => esc_html__( 'Nearby Places', 'framework' ),
				'children'            => esc_html__( 'Child Properties', 'framework' ),
				'agent'               => esc_html__( 'Agents', 'framework' ),
				'energy-performance'  => esc_html__( 'Energy Performance', 'framework' ),
				'mortgage-calculator' => esc_html__( 'Mortgage Calculator', 'framework' ),
			);

			// Add Property Views section if Property Analytic is enabled.
			if ( inspiry_is_property_analytics_enabled() ) {

				$property_sections = array_merge(
					$property_sections,
					array(
						'property-views' => esc_html__( 'Property Views', 'framework' ),
					)
				);

				$property_sections_default .= ',property-views';
			}

			if ( inspiry_is_rvr_enabled() ) {

				$property_sections = array_merge(
					$property_sections,
					array(
						'rvr/price-details'         => esc_html__( 'Price Details', 'framework' ),
						'rvr/guests-accommodation'  => esc_html__( 'Guests Accommodation', 'framework' ),
						'rvr/seasonal-prices'       => esc_html__( 'Seasonal Prices', 'framework' ),
						'rvr/availability-calendar' => esc_html__( 'Availability Calendar', 'framework' ),
					)
				);

				$property_sections_default .= ',rvr/price-details,rvr/seasonal-prices,rvr/availability-calendar';
			}

			$property_sections = apply_filters( 'realhomes_property_sections', $property_sections );

			$wp_customize->add_setting( 'inspiry_property_sections_order_mod', array(
				'type'              => 'option',
				'default'           => $property_sections_default,
				'sanitize_callback' => 'sanitize_text_field'
			) );
			$wp_customize->add_control( new Inspiry_Dragdrop_Control( $wp_customize, 'inspiry_property_sections_order_mod',
				array(
					'label'       => esc_html__( 'Sections Order', 'framework' ),
					'description' => esc_html__( 'Select custom order for modern design variation.', 'framework' ),
					'section'     => 'inspiry_property_sections_manager',
					'settings'    => 'inspiry_property_sections_order_mod',
					'choices'     => $property_sections,
				)
			) );
		}
	}

	add_action( 'customize_register', 'inspiry_property_sections_manager_customizer' );
endif;

if ( ! function_exists( 'inspiry_property_sections_manager_defaults' ) ) :
	function inspiry_property_sections_manager_defaults( WP_Customize_Manager $wp_customize ) {
		$property_sections_manager_settings_ids = array(
			'inspiry_property_sections_order_default',
			'inspiry_property_sections_order',
			'inspiry_property_sections_order_mod'
		);
		inspiry_initialize_defaults( $wp_customize, $property_sections_manager_settings_ids );
	}

	add_action( 'customize_save_after', 'inspiry_property_sections_manager_defaults' );
endif;