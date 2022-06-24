<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_CTA_Three_Widget extends \Elementor\Widget_Base {
	public function get_name() {
		return 'ere-cta-three-widget';
	}

	public function get_title() {
		return esc_html__( 'Call to Action 3', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-posts-ticker';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Call to Action ', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'cta_top_title',
			[
				'label'   => esc_html__( 'Top Title', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => esc_html__( 'Find Great Places to Stay at Your Favorite Destinations', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'cta_main_description',
			[
				'label'   => esc_html__( 'Description', 'realhomes-elementor-addon' ),
				'description'     => esc_html__( 'You can use span, a, em, br, strong tags in text', 'realhomes-elementor-addon' ),

				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 8,
				'default' => esc_html__( 'Our rentals offer comfort with world class facilities to travellers around the globe. Explore best place to stay around your favorite destination and get great deals.', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'cta__btn_title',
			[
				'label'   => esc_html__( 'Button Title', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Explore Rentals', 'realhomes-elementor-addon' ),
				'separator'     => 'before',
			]
		);

		$this->add_control(
			'cta_btn_url',
			[
				'label'         => esc_html__( 'Button URL', 'realhomes-elementor-addon' ),
				'type'          => \Elementor\Controls_Manager::URL,
				'show_external' => true,
				'dynamic'       => [
					'active' => true,
				],
				'default'       => [
					'url' => '#',
				],
				'separator'     => 'after',
			]
		);

		$this->add_control(
			'ere_show_bg_image',
			[
				'label'        => esc_html__( 'Enable Background Image', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'cta_1_image',
			[
				'label'     => esc_html__( 'Background Image', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'default'   => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
				'condition' => [
					'ere_show_bg_image' => 'yes',
				],
			]
		);

		$this->add_control(
			'ere_cta_1_image_bg_size',
			[
				'label'     => esc_html__( 'Background Size', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'auto',
				'condition' => [
					'ere_show_bg_image' => 'yes',
				],
				'options'   => array(
					'cover'   => esc_html__( 'Cover', 'realhomes-elementor-addon' ),
					'contain' => esc_html__( 'Contain', 'realhomes-elementor-addon' ),
					'auto'    => esc_html__( 'Auto', 'realhomes-elementor-addon' ),
				)
			]
		);


		$this->add_control(
			'ere_enable_parallax_effect',
			[
				'label'        => esc_html__( 'Enable Parallax Effect', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
				'condition'    => [
					'ere_show_bg_image' => 'yes',
				],
			]
		);

		$this->add_control(
			'ere_enable_overlay',
			[
				'label'        => esc_html__( 'Enable Background Overlay', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);
		$this->end_controls_section();

		$this->start_controls_section(
			'ere_cta3_typo_section',
			[
				'label' => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'top_title_typography',
				'label'    => esc_html__( 'Top Title', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_label_cta_3',
			]
		);
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'main_desc_typography',
				'label'    => esc_html__( 'Description', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .wrapper_content_cta_3 .rhea_description_cta_3 p',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'button_typography',
				'label'    => esc_html__( 'Button', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .cta_three_elementor_button',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'ere_cta3_layout_section',
			[
				'label' => esc_html__( 'Layout', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'ere_cta_container_padding',
			[
				'label'      => esc_html__( 'Container Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rh_section__cta_elementor_three' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_cta_max-width',
			[
				'label'           => esc_html__( 'Container Fluid Max Width (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 320,
						'max' => 2500,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 1240,
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .wrapper_content_cta_3_box' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'cta_flip_image',
			[
				'label'        => esc_html__( 'Flip Background Image?', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'flip_content_cta',
			[
				'label'        => esc_html__( 'Flip Content Side?', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);


		$this->add_responsive_control(
			'ere_cta_content_max-width',
			[
				'label'           => esc_html__( 'Content Side Max Width (%)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%','px' ],
				'range'           => [
					'%' => [
						'min' => 0,
						'max' => 100,
					],
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 50,
					'unit' => '%',
				],
				'mobile_default'  => [
					'size' => 100,
					'unit' => '%',
				],
				'selectors'       => [
					'{{WRAPPER}} .wrapper_content_cta_3' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_cta_content_padding',
			[
				'label'      => esc_html__( 'Content Inner Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .wrapper_content_cta_3' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_cta_label_margin',
			[
				'label'           => esc_html__( 'Top Label Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .wrapper_content_cta_3 .rhea_label_cta_3' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_cta_main_desc_margin',
			[
				'label'           => esc_html__( 'Description Margin Bottom (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .wrapper_content_cta_3 .rhea_description_cta_3 p' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'ere_cta_button_padding',
			[
				'label'      => esc_html__( 'Button Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .cta_three_elementor_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'rhea_cta_align',
			[
				'label'   => esc_html__( 'Text Align', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'initial'         => [
						'title' => esc_html__( 'Left', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center'   => [
						'title' => esc_html__( 'Center', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default' => '',
				'toggle'  => true,
			]
		);


		$this->end_controls_section();
		$this->start_controls_section(
			'cta3_colors',
			[
				'label' => esc_html__( 'Colors', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'cta_bg_section',
			[
				'label'     => esc_html__( 'Background', 'realhomes-elementor-addon' ),
				'description'     => esc_html__( 'If no image is set for background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rh_section__cta_elementor_three' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cta_overlay',
			[
				'label'     => esc_html__( 'overlay Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_overlay_cta_3' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cta_content_color',
			[
				'label'     => esc_html__( 'Content Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .wrapper_content_cta_3' => 'background: {{VALUE}}',
				],
			]
		);



		$this->add_control(
			'cta_top_label',
			[
				'label'     => esc_html__( 'Top Label', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea_label_cta_3' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'cta_desc_color',
			[
				'label'     => esc_html__( 'Description', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .wrapper_content_cta_3 .rhea_description_cta_3 p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_first_button_color',
			[
				'label'     => esc_html__( 'Button Text', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta_three_elementor_button' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_first_button_hover_color',
			[
				'label'     => esc_html__( 'Button Text Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta_three_elementor_button:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_first_button_bg_color',
			[
				'label'     => esc_html__( 'Button Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta_three_elementor_button' => 'background-color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'ere_first_button_bg_hover_color',
			[
				'label'     => esc_html__( 'Button Background Hover', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .cta_three_elementor_button:hover' => 'background-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings     = $this->get_settings_for_display();
		$allowed_html = array(
			'a'      => array(
				'href'   => array(),
				'title'  => array(),
				'target' => array(),
                'style' => array(),
 			),
			'br'     => array(),
			'em'     => array(),
			'strong' => array(
				'style' => array(),
            ),
			'span' => array(
				'style' => array(),
            ),
			'i' => array(
				'style' => array(),
            ),
		);
		?>


		<?php
		$flip_content_cta = '';
		if( 'yes' == $settings['flip_content_cta']){
			$flip_content_cta = ' rhea_flip_content_cta';
		}

		$cta_flip_image = '';
		if( 'yes' == $settings['cta_flip_image']){
			$cta_flip_image = ' rhea_cta_flip_image';
		}
		?>

        <section
                class="rh_elementor_widget rh_section__cta_elementor_three rh_cta--featured_elementor
<?php echo esc_attr($flip_content_cta); ?> ">

            <div class="rh_bg_cta_three
    <?php
            if ( $settings['ere_enable_parallax_effect'] == 'yes' ) {
	            echo esc_attr( 'ere_cta_parallax' );
            }
            echo esc_attr($cta_flip_image);
            ?>"
                 <?php if ( ! empty( $settings['cta_1_image']['id'] ) ) { ?>
                 style="background-size: <?php echo esc_attr( $settings['ere_cta_1_image_bg_size'] ); ?>; background-image: url(<?php if ( $settings['ere_show_bg_image'] == 'yes' ) {
		                 echo esc_url( $settings['cta_1_image']['url'] );
                 } ?> ) "
            <?php } ?>
            ></div>

			<?php if ( $settings['ere_enable_overlay'] == 'yes' ) { ?>
                <div class="rhea_overlay_cta_3"></div>
			<?php } ?>

            <div class="wrapper_content_cta_3_box">

                <div class="wrapper_content_cta_3_gutter">
                </div>
                <div class="wrapper_content_cta_3"
                     <?php if(!empty( $settings['rhea_cta_align'])){ ?>
                     style="text-align: <?php echo esc_attr( $settings['rhea_cta_align'] ); ?> "
                     <?php } ?>
                >
					<?php
					if ( ! empty( $settings['cta_top_title'] ) ) {
						?>
                        <h2 class="rhea_label_cta_3">
							<?php echo esc_html( $settings['cta_top_title'] ) ?>
                        </h2>
						<?php
					}
					if ( ! empty( $settings['cta_main_description'] ) ) {
						?>
                        <div class="rhea_description_cta_3">
                            <p>
	                        <?php echo wp_kses( $settings['cta_main_description'], $allowed_html ) ?>
                            </p>
                        </div>
						<?php
					}

					if ( ! empty( $settings['cta__btn_title'] ) && ! empty( $settings['cta_btn_url']['url'] ) ) {
						$target            = $settings['cta_btn_url']['is_external'] ? ' target="_blank" ' : ' ';
						$nofollow          = $settings['cta_btn_url']['nofollow'] ? ' rel="nofollow" ' : ' ';
						$custom_attributes = $settings['cta_btn_url']['custom_attributes']? $settings['cta_btn_url']['custom_attributes'] : ' ';
						?>
                        <div class="rh_cta__btns_elementor_three">
                            <a class="cta_three_elementor_button"
								<?php echo $target . ' ' . $nofollow . ' ' . $custom_attributes ?>
                               href="<?php echo esc_url( $settings['cta_btn_url']['url'] ); ?>">
								<?php echo esc_html( $settings['cta__btn_title'] ); ?>
                            </a>
                        </div>
						<?php
					}
					?>

                </div>
            </div>

        </section>

        <?php

	}

}