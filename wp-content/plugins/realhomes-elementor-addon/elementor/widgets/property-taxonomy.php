<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Property_Taxonomy_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'rhea-property-taxonomy-widget';
	}

	public function get_title() {
		return esc_html__( 'Property Taxonomy', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-image-hotspot';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'property_taxonomy_content_section',
			[
				'label' => esc_html__( 'Settings', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$property_taxonomies = array(
			'property-type'   => esc_html__( 'Type', 'realhomes-elementor-addon' ),
			'property-city'   => esc_html__( 'City', 'realhomes-elementor-addon' ),
			'property-status' => esc_html__( 'Status', 'realhomes-elementor-addon' ),
		);

		$this->add_control(
			'select_property_taxonomy',
			[
				'label'   => esc_html__( 'Select Taxonomy', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'property-type',
				'options' => $property_taxonomies,
			]
		);

		if ( ! empty( $property_taxonomies ) ) {
			foreach ( $property_taxonomies as $property_taxonomy => $label ) {
				$terms_options = array();
				$control_id    = str_replace( '-', '_', $property_taxonomy );

				$property_taxonomy_terms = get_terms( array(
					'taxonomy'   => $property_taxonomy,
					'hide_empty' => false,
				) );

				if ( ! empty( $property_taxonomy_terms ) && ! is_wp_error( $property_taxonomy_terms ) ) {
					foreach ( $property_taxonomy_terms as $property_taxonomy_term ) {
						$terms_options[ $property_taxonomy_term->term_id ] = $property_taxonomy_term->name;
					}
				}
				$first_key = array_key_first($terms_options);

				$this->add_control(
					$control_id,
					[
						'label'     => esc_html__( 'Select Term', 'realhomes-elementor-addon' ),
						'type'      => \Elementor\Controls_Manager::SELECT,
						'options'   => $terms_options,
						'default'   => $first_key,
						'condition' => [
							'select_property_taxonomy' => $property_taxonomy,
						],
					]
				);
			}
		}

		$this->add_control(
			'term_custom_name',
			[
				'label' => esc_html__( 'Custom Name', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
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
			'show_property_count',
			[
				'label'        => __( 'Show Property Count', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => __( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'property_singular_label',
			[
				'label'     => esc_html__( 'Property', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Property', 'realhomes-elementor-addon' ),
				'condition' => [
					'show_property_count' => 'yes',
				],
			]
		);

		$this->add_control(
			'property_plural_label',
			[
				'label'     => esc_html__( 'Properties', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => esc_html__( 'Properties', 'realhomes-elementor-addon' ),
				'condition' => [
					'show_property_count' => 'yes',
				],
			]
		);

		$this->add_control(
			'show_description',
			[
				'label'        => __( 'Show Description', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => __( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
                'separator'    => 'before'
			]
		);

		$this->add_control(
			'description',
			[
				'label' => esc_html__( 'Custom Description', 'realhomes-elementor-addon' ),
				'type'  => \Elementor\Controls_Manager::TEXTAREA,
				'rows'  => 3,
				'condition' => [
					'show_description' => 'yes',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'property_taxonomy_style_section',
			array(
				'label' => esc_html__( 'Widget Style', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'widget_style',
			[
				'label'   => esc_html__( 'Preset Height Style', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'style-1',
				'options' => [
					'style-1' => esc_html__( 'Style 1', 'realhomes-elementor-addon' ),
					'style-2' => esc_html__( 'Style 2 ', 'realhomes-elementor-addon' ),
					'style-3' => esc_html__( 'Style 3', 'realhomes-elementor-addon' ),
				],
			]
		);

		$this->add_responsive_control(
			'widget_height',
			[
				'label'     => esc_html__( 'Custom Height(%)', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 50,
						'max' => 300,
					],
				],
				'devices'   => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .rhea-property-taxonomy-widget-wrapper' => 'padding-top: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'widget_margin_bottom',
			[
				'label'     => esc_html__( 'Margin Bottom(px)', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'   => [ 'desktop', 'tablet', 'mobile' ],
				'selectors' => [
					'{{WRAPPER}} .rhea-property-taxonomy-widget-wrapper' => 'margin-bottom: {{SIZE}}px;',
				],
			]
		);

		$this->add_responsive_control(
			'widget_content_padding',
			[
				'label'      => esc_html__( 'Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-property-taxonomy-widget-inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'rhea_widget_border-radius',
			[
				'label'      => esc_html__( 'Border Radius', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-property-taxonomy-widget-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator'  => 'after',
			]
		);

		$this->add_control(
			'vertical_align',
			[
				'label'     => esc_html__( 'Vertical Align', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'flex-start',
				'options'   => [
					'flex-start'    => esc_html__( 'Top', 'realhomes-elementor-addon' ),
					'center'        => esc_html__( 'Middle', 'realhomes-elementor-addon' ),
					'flex-end'      => esc_html__( 'Bottom', 'realhomes-elementor-addon' ),
					'space-between' => esc_html__( 'Space Between', 'realhomes-elementor-addon' ),
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-property-taxonomy-widget-inner' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'name_align',
			[
				'label'     => esc_html__( 'Name Alignment', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'flex-start',
				'options'   => [
					'flex-start' => esc_html__( 'Left', 'realhomes-elementor-addon' ),
					'center'     => esc_html__( 'Center', 'realhomes-elementor-addon' ),
					'flex-end'   => esc_html__( 'Right', 'realhomes-elementor-addon' ),
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-property-taxonomy-term-title' => 'align-self: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'property_count_align',
			[
				'label'     => esc_html__( 'Property Count Alignment', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'flex-start',
				'options'   => [
					'flex-start' => esc_html__( 'Left', 'realhomes-elementor-addon' ),
					'center'     => esc_html__( 'Center', 'realhomes-elementor-addon' ),
					'flex-end'   => esc_html__( 'Right', 'realhomes-elementor-addon' ),
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-property-taxonomy-widget-inner' => 'align-items: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'name_typography',
				'label'    => esc_html__( 'Name Typography', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-property-taxonomy-term-title',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'counter_label_typography',
				'label'    => esc_html__( 'Counter Label Typography', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-property-taxonomy-property-label',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'counter_typography',
				'label'    => esc_html__( 'Counter Typography', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-property-taxonomy-property-count',
			]
		);

		$this->add_control(
			'property_taxonomy_color_hover',
			[
				'label'     => esc_html__( 'Name Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-property-taxonomy-term-title' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'property_counter_label_color',
			[
				'label'     => esc_html__( 'Counter Label Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-property-taxonomy-property-label' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'property_counter_color',
			[
				'label'     => esc_html__( 'Counter Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-property-taxonomy-property-count' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'overlay_heading',
			[
				'label'     => esc_html__( 'First Overlay', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->start_controls_tabs( 'overlay_tabs' );

		$this->start_controls_tab(
			'style_normal_tab',
			[
				'label' => esc_html__( 'Normal', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'overlay_color',
			[
				'label'     => esc_html__( 'Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-property-taxonomy-widget-wrapper:before' => 'background-color: {{VALUE}}',
				]
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'style_hover_tab',
			[
				'label' => esc_html__( 'Hover', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'overlay_hover_color',
			[
				'label'     => esc_html__( 'Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-property-taxonomy-widget-wrapper:hover:before' => 'background-color: {{VALUE}}',
				]
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'content_overlay_heading',
			[
				'label'     => esc_html__( 'Second Overlay', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name'       => 'background',
				'show_label' => false,
				'types'      => [ 'gradient' ],
				'exclude'    => [ 'image' ],
				'selector'   => '{{WRAPPER}} .rhea-property-taxonomy-widget-content-overlay',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'description_typography',
				'label'    => esc_html__( 'Description Typography', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-property-taxonomy-description',
				'condition' => [
					'show_description' => 'yes',
				],
			]
		);

		$this->add_control(
			'description_color',
			[
				'label'     => esc_html__( 'Description Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-property-taxonomy-description p' => 'color: {{VALUE}}',
				],
				'condition' => [
					'show_description' => 'yes',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$selected_taxonomy = $settings['select_property_taxonomy'];
		$selected_term     = str_replace( '-', '_', $selected_taxonomy );
		$image_attributes  = wp_get_attachment_image_src( $settings['image']['id'], 'large' );
		$term              = get_term_by( 'term_id', $settings[ $selected_term ], $selected_taxonomy );

		if ( $term ) {
			$term_id = apply_filters( 'wpml_object_id', $term->term_id, $selected_taxonomy, true );

			$label = $settings['property_plural_label'];
			if ( $term->count <= 1 ) {
				$label = $settings['property_singular_label'];
			}

			$widget_style = 'style-1';
			if ( isset( $settings['widget_style'] ) ) {
				$widget_style = $settings['widget_style'];
			}
			?>
            <div class="rhea-property-taxonomy-widget-outer-wrapper">
                <div class="rhea-property-taxonomy-widget-wrapper rhea-property-taxonomy-<?php echo esc_attr( $widget_style ); ?>" style='background-image: url("<?php echo esc_url( $image_attributes[0] ); ?>")'>
                    <div class="rhea-property-taxonomy-widget-content-overlay"></div>
                    <a class="rhea-property-taxonomy-widget-inner" href="<?php echo get_term_link( $term_id, $selected_taxonomy ); ?>">
                        <span class="rhea-property-taxonomy-term-title">
                            <?php
                            if ( ! empty( $settings['term_custom_name'] ) ) {
	                            echo esc_html( $settings['term_custom_name'] );
                            } else {
	                            echo esc_html( $term->name );
                            }
                            ?>
                        </span>
						<?php
						if ( 'yes' === $settings['show_property_count'] ) {
							?>
                            <span class="rhea-property-taxonomy-property-counter">
                              <span class="rhea-property-taxonomy-property-count"><?php echo esc_html( $term->count ); ?></span>
                              <span class="rhea-property-taxonomy-property-label"><?php echo esc_html( $label ); ?></span>
                            </span>
							<?php
						}
						?>
                    </a>
                </div>
	            <?php
	            if ( 'yes' === $settings['show_description'] ) {
		            $term_description = term_description( $term_id );
		            if ( ! empty( $settings['description'] ) ) {
			            ?>
                        <div class="rhea-property-taxonomy-description">
				            <p><?php echo esc_html( $settings['description'] ); ?></p>
                        </div>
			            <?php
		            } elseif ( ! empty( $term_description ) ) {
			            ?>
                        <div class="rhea-property-taxonomy-description">
				            <?php echo $term_description; ?>
                        </div>
			            <?php
		            }
	            }
	            ?>
            </div>
			<?php
		}
	}
}