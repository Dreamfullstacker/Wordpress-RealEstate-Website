<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


class RHEA_Properties_Cities_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'rhea-properties-cities-widget';
	}

	public function get_title() {
		return esc_html__( 'Locations / Cities', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-image-hotspot';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'rhea_properties_cities_section',
			[
				'label' => esc_html__( 'Cities', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$rhea_city_terms = get_terms( array( 'taxonomy' => 'property-city' ) );
		$get_city_terms  = array();
		foreach ( $rhea_city_terms as $rhea_term ) {
			$get_city_terms[ $rhea_term->slug ] = $rhea_term->name;
		}


		$status_repeater = new \Elementor\Repeater();


		$status_repeater->add_control(
			'rhea_property_location_select_section',
			[
				'label'   => esc_html__( 'Select Locations', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => $get_city_terms,
			]
		);

		$status_repeater->add_control(
			'rhea_city_label',
			[
				'label'       => esc_html__( 'City Label', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'description' => esc_html__( 'Default city name will appear if field is empty.', 'realhomes-elementor-addon' ),
			]
		);

		$status_repeater->add_control(
			'image',
			[
				'label'   => __( 'Choose Image', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_control(
			'rhea_add_city_select',
			[
				'label'       => esc_html__( 'Add City', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $status_repeater->get_controls(),
				'title_field' => ' {{{ rhea_property_location_select_section }}}',
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'rhea_properties_cities_labels',
			[
				'label' => esc_html__( 'Labels', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'ere_property_singular_label',
			[
				'label'   => esc_html__( 'Singular Property', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Property', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'ere_property_plural_label',
			[
				'label'   => esc_html__( 'More Than One Properties', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Properties', 'realhomes-elementor-addon' ),
			]
		);

		$this->end_controls_section();
		$this->start_controls_section(
			'rhea_property_city_typo_section',
			[
				'label' => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_city_typography',
				'label'    => esc_html__( 'Heading', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_property_city .rhea_property_city_inner h3',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_count_typography',
				'label'    => esc_html__( 'Property Count', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_property_city .rhea_property_city_inner .rhea_pc_count',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_label_typography',
				'label'    => esc_html__( 'Property Count Label', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_property_city .rhea_property_city_inner .rhea_pc_label',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_properties_cities_variations',
			array(
				'label' => esc_html__( 'Design Variations', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'rhea_city_variations',
			array(
				'label'   => esc_html__( 'Designs', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => array(
					'default' => array(
						'title' => esc_html__( 'Default', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-posts-justified',
					),
					'classic' => array(
						'title' => esc_html__( 'Classic', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-posts-grid',
					),
					'masonry' => array(
						'title' => esc_html__( 'Masonry', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-posts-masonry',
					),
				),
				'default' => 'default',
				'toggle'  => false,
			)
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_properties_cities_spaces',
			[
				'label' => esc_html__( 'Spaces & Alignments', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'rhea_properties_cities_inner_Padding',
			[
				'label'      => esc_html__( 'Image Inner Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea_property_city .rhea_property_city_inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_pc_gutter',
			[
				'label'           => esc_html__( 'Locations Columns/Row Margin', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 30,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 7,
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea_properties_cities_wrapper'               => 'margin-left: -{{SIZE}}{{UNIT}}; margin-right: -{{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .rhea_property_city .rhea_property_city_inner' => 'margin: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'rhea_city_position',
			[
				'label'   => esc_html__( 'Labels Positions', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'column' => [
						'title' => esc_html__( 'Default', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-v-align-top',
					],

					'column-reverse' => [
						'title' => esc_html__( 'Reverse', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-v-align-bottom',
					],
				],
				'default' => 'column',
				'toggle'  => false,
			]
		);

		$this->add_control(
			'rhea_city_align',
			[
				'label'   => esc_html__( 'City Label Align', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					''         => [
						'title' => esc_html__( 'Left', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'   => [
						'title' => esc_html__( 'Center', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end' => [
						'title' => esc_html__( 'Right', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default' => '',
				'toggle'  => true,
			]
		);

		$this->add_control(
			'rhea_counter_align',
			[
				'label'   => esc_html__( 'Properties Count Align', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => esc_html__( 'Left', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center'     => [
						'title' => esc_html__( 'Center', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-h-align-center',
					],
					'flex-end'   => [
						'title' => esc_html__( 'Right', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default' => 'flex-end',
				'toggle'  => true,
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'rhea_properties_cities_colors',
			[
				'label' => esc_html__( 'Colors & Styles', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'rhea_property_city_color',
			[
				'label'     => esc_html__( 'City Name', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_property_city .rhea_property_city_inner h3' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_property_city_color_hover',
			[
				'label'     => esc_html__( 'City Name On Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_property_city .rhea_property_city_inner:hover h3' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_properties_counter_color',
			[
				'label'     => esc_html__( 'Properties Counter', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_property_city .rhea_property_city_inner .rhea_pc_count' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_properties_counter_color_hover',
			[
				'label'     => esc_html__( 'Properties Counter On Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_property_city .rhea_property_city_inner:hover .rhea_pc_count' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_properties_label_counter_color',
			[
				'label'     => esc_html__( 'Properties Label', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_property_city .rhea_property_city_inner .rhea_pc_label' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'rhea_properties_label_counter_color_hover',
			[
				'label'     => esc_html__( 'Properties Label On Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_property_city .rhea_property_city_inner:hover .rhea_pc_label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_over_lay_color',
			[
				'label'     => esc_html__( 'Overlay Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_property_city .rhea_property_city_inner .rhea_pc_layer' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_over_lay_hover_color',
			[
				'label'     => esc_html__( 'Overlay Hover Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_property_city .rhea_property_city_inner:hover .rhea_pc_layer' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_transform',
			[
				'label' => esc_html__( 'Image Scale', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min'  => 1.01,
						'max'  => 2,
						'step' => .05,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_property_city .rhea_property_city_inner .rhea_pc_layer_still' => 'transform: scale({{SIZE}});',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_transform_on_hover',
			[
				'label' => esc_html__( 'Image Scale On Hover', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::SLIDER,

				'range'           => [
					'px' => [
						'min'  => 1,
						'max'  => 2,
						'step' => .05,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => '1.1',
					'unit' => 'px',
				],
				'tablet_default'  => [
					'size' => '1.1',
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => '1.1',
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea_property_city .rhea_property_city_inner:hover .rhea_pc_layer_still' => 'transform: scale({{SIZE}});',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ere_properties_cities_box_shadow',
			[
				'label' => esc_html__( 'Box Shadow', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'realhomes-elementor-addon' ),
				'selector' => '{{WRAPPER}} .rhea_property_city .rhea_property_city_inner',
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$repeater_city = $settings['rhea_add_city_select'];

		if ( $repeater_city ) {

			?>
            <div class="rhea_properties_cities_wrapper <?php echo esc_attr( $settings['rhea_city_variations'] ); ?>">
				<?php

				foreach ( $repeater_city as $city ) {

					$image_attributes = wp_get_attachment_image_src( $city['image']['id'], 'large' );

					$term = get_term_by( 'slug', $city['rhea_property_location_select_section'], 'property-city' );
					if ( $term ) {
						$name    = $term->name;
						$term_id = apply_filters( 'wpml_object_id', $term->term_id, 'property-city', true );
						?>
                        <div class="rhea_property_city">
                            <a class="rhea_property_city_inner"
                               style="flex-direction: <?php echo esc_attr( $settings['rhea_city_position'] ) ?>"
                               href="<?php echo get_term_link( $term_id, 'property-city' ) ?>">

                            <span class="rhea_pc_layer_still"
                                  style='background-image: url("<?php echo esc_url( $image_attributes[0] ) ?>")'></span>
                                <span class="rhea_pc_layer"></span>

                                <h3 class="rhea_city_title"
									<?php
									if ( ! empty( $settings['rhea_city_align'] ) ) {
										?>
                                        style="align-self: <?php echo esc_attr( $settings['rhea_city_align'] ); ?> "
										<?php
									}
									?>
                                >
									<?php
									if ( ! empty( $city['rhea_city_label'] ) ) {
										echo esc_html( $city['rhea_city_label'] );
									} else {
										echo esc_html( $name );
									}
									?>
                                </h3>


                                <span class="rhea_pc_counter"
                                      style="align-self: <?php echo esc_attr( $settings['rhea_counter_align'] ); ?>">

                    <span class="rhea_pc_count">
                            <?php
                            echo esc_html( $term->count );
                            ?>
                    </span>

                          <span class="rhea_pc_label">
                           <?php

                           if ( $term->count <= 1 ) {
	                           echo esc_html( $settings['ere_property_singular_label'] );
                           } else {
	                           echo esc_html( $settings['ere_property_plural_label'] );
                           }

                           ?>
                    </span>
                        </span>

                            </a>
                        </div>
						<?php
					}
					?>

					<?php

				}

				?>

            </div>
			<?php
		}

		?>


		<?php


	}

}