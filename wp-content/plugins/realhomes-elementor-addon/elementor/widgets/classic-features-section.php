<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Classic_Features_Section_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ere-classic-features-section-widget';
	}

	public function get_title() {
		return esc_html__( 'Classic Features Section', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-featured-image';
	}

	public function get_categories() {
		return [ 'classic-real-homes' ];
	}

	protected function register_controls() {

		$grid_size_array = wp_get_additional_image_sizes();


		$prop_grid_size_array = array(
			'thumbnail'    => 'Thumbnail',
			'medium'       => 'Medium',
			'medium_large' => 'Medium Large',
			'large'        => 'Large',
		);
		foreach ( $grid_size_array as $key => $value ) {
			$str_rpl_key = ucwords( str_replace( "-", " ", $key ) );

			$prop_grid_size_array[ $key ] = $str_rpl_key . ' - ' . $value['width'] . 'x' . $value['height'];
		}

		unset( $prop_grid_size_array['partners-logo'] );
		unset( $prop_grid_size_array['property-detail-slider-thumb'] );
		unset( $prop_grid_size_array['post-thumbnail'] );
		unset( $prop_grid_size_array['gallery-two-column-image'] );
		unset( $prop_grid_size_array['post-featured-image'] );

//			$default_prop_grid_size = 'agent-image';


		$this->start_controls_section(
			'ere_features',
			[
				'label' => esc_html__( 'Features', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'main_title',
			[
				'label'       => esc_html__( 'Main Title', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Amazing Features', 'realhomes-elementor-addon' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'main_description',
			[
				'label'       => esc_html__( 'Main Description', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'rows'        => 5,
				'default'     => esc_html__( 'Some amazing features of RealHomes theme.', 'realhomes-elementor-addon' ),
				'placeholder' => esc_html__( 'Type your description here', 'realhomes-elementor-addon' ),
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
			'features_bg_image',
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
				'default'      => 'yes',
			]
		);

		$this->add_responsive_control(
			'ere_section_align',
			[
				'label'     => esc_html__( 'Alignment', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-h-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-h-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-h-align-right',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_features_section_elementor' => 'text-align: {{VALUE}};',
				],
			]
		);


		$this->end_controls_section();


		$this->start_controls_section(
			'ere_features_section',
			[
				'label' => esc_html__( 'Add Section', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'ere_use_thumb_sizes',
			[
				'label'        => esc_html__( 'Use Pre Defined Thumbnail Size', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'ere_features_grid_thumb_sizes',
			[
				'label'     => esc_html__( 'Thumbnail Size', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'agent-image',
				'options'   => $prop_grid_size_array,
				'condition' => [
					'ere_use_thumb_sizes' => 'yes',
				],
			]
		);


		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'section_title',
			[
				'label'       => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Section Title', 'realhomes-elementor-addon' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'section_image',
			[
				'label'   => esc_html__( 'Choose Image', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$repeater->add_control(
			'section_description',
			[
				'label'       => esc_html__( 'Description', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => esc_html__( 'Default description', 'realhomes-elementor-addon' ),
				'placeholder' => esc_html__( 'Type your description here', 'realhomes-elementor-addon' ),
			]
		);


		$this->add_control(
			'ere_section_feature',
			[
				'label'       => '',
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => ' {{{ section_title }}}',
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'ere_features_typography',
			[
				'label' => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]

		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'main_title_typography',
				'label'    => esc_html__( 'Main Title', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_classic_features_section_elementor .rhea_heading_wrapper h2',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'main_description_typography',
				'label'    => esc_html__( 'Main Description', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_classic_features_section_elementor .rhea_heading_wrapper p',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'section_title_typography',
				'label'    => esc_html__( 'Section Title', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea_classic_features_section_elementor .rhea_features_section h4',
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'ere_features_styles_sizes',
			[
				'label' => esc_html__( 'Spaces & Sizes', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]

		);

		$this->add_responsive_control(
			'ere_section_padding',
			[
				'label'      => esc_html__( 'Container Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea_classic_features_section_elementor' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'main_title_bottom_margin',
			[
				'label'           => esc_html__( 'Main Title Bottom Margin (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_classic_features_section_elementor .rhea_heading_wrapper h2' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'main_description_bottom_margin',
			[
				'label'           => esc_html__( 'Main Description Bottom Margin (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_classic_features_section_elementor .rhea_heading_wrapper p' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
		$this->add_responsive_control(
			'feature_single_width',
			[
				'label'           => esc_html__( 'Feature Width (%)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ '%', 'px' ],
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
				'selectors'       => [
					'{{WRAPPER}} .rhea_classic_features_section_elementor .rhea_features_section' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_feature_single_padding',
			[
				'label'      => esc_html__( 'Feature Padding', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea_classic_features_section_elementor .rhea_features_section' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'feature_single_image_bottom_margin',
			[
				'label'           => esc_html__( 'Feature Image Bottom Margin (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_classic_features_section_elementor .rhea_features_image' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);
	$this->add_responsive_control(
			'feature_single_title_bottom_margin',
			[
				'label'           => esc_html__( 'Feature Title Bottom Margin (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_classic_features_section_elementor .rhea_features_section h4' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

	$this->add_responsive_control(
			'feature_single_description_bottom_margin',
			[
				'label'           => esc_html__( 'Feature Description Bottom Margin (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 300,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea_classic_features_section_elementor .rhea_features_section .rhea_features_content_area' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'ere_features_styles_colors',
			[
				'label' => esc_html__( 'Colors', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]

		);

		$this->add_control(
			'ere_main_title_color',
			[
				'label'     => esc_html__( 'Main Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_features_section_elementor .rhea_heading_wrapper h2' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_main_description_color',
			[
				'label'     => esc_html__( 'Main Description', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_features_section_elementor .rhea_heading_wrapper p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_section_title_color',
			[
				'label'     => esc_html__( 'Section Title', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_features_section_elementor .rhea_features_section h4' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_section_description_color',
			[
				'label'     => esc_html__( 'Section Description', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_features_section_elementor .rhea_features_section .rhea_features_content_area' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'ere_over_lay_color',
			[
				'label'     => esc_html__( 'Overlay Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea_classic_features_section_elementor .rhea_features_overlay' => 'background: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {

		$settings = $this->get_settings_for_display();


		?>
        <div id="rh-<?php echo $this->get_id(); ?>" class="rh_elementor_widget rhea_classic_features_section_elementor rhea_class_features_background <?php if ( $settings['ere_enable_parallax_effect'] == 'yes' ) {
			echo esc_attr( 'rhea_image_parallax' );
		} ?>" style="background-image: url(<?php echo esc_url( $settings['features_bg_image']['url'] ) ?> ) ">
			<?php
			if ( $settings['ere_enable_overlay'] == 'yes' ) {
				?>
                <div class="rhea_features_overlay"></div>
			<?php } ?>
            <div class="rhea_classic_features_section_container">
				<?php
				if ( $settings['main_title'] || $settings['main_description'] ) {
					?>
                    <div class="rhea_heading_wrapper">
						<?php
						if ( $settings['main_title'] ) {
							?>
                            <h2><?php echo esc_html( $settings['main_title'] ) ?></h2>
							<?php
						}
						if ( $settings['main_description'] ) {
							?>
                            <p><?php echo esc_html( $settings['main_description'] ) ?></p>

							<?php
						}
						?>
                    </div>
					<?php
				}

				if ( $settings['ere_section_feature'] ) {
					?>
                    <div class="rhea_features">
						<?php
						foreach ( $settings['ere_section_feature'] as $item ) {
							?>
                            <div class="rhea_features_section">
							<?php
							if ( $item['section_image'] ) {
								?>
                                <div class="rhea_features_image"><?php echo wp_get_attachment_image( $item['section_image']['id'], $settings['ere_features_grid_thumb_sizes'] ); ?></div>
								<?php
							}
							if ( $item['section_title'] ) {
								?>
                                <h4><?php echo esc_html( $item['section_title'] ) ?></h4>
								<?php
							}
							if ( $item['section_description'] ) {
								?>
                                <div class="rhea_features_content_area"><?php echo esc_html($item['section_description']); ?></div>
                                </div>

								<?php
							}
						}
						?>
                    </div>

					<?php
				}
				?>
            </div>
        </div>
        <script type="application/javascript">

            var classicFeatureHeight = function (id) {

                var imageHeight = -1;
                jQuery(id).each(function () {
                    if (jQuery(this).prop("complete", "complete")) {
                        imageHeight = imageHeight > jQuery(this).outerHeight() ? imageHeight : jQuery(this).outerHeight();
                    } else {
                        jQuery(this).on('load', function () {
                            imageHeight = imageHeight > jQuery(this).outerHeight() ? imageHeight : jQuery(this).outerHeight();
                        });
                    }
                });

                jQuery(id).css({
                    height: imageHeight
                });

            };

            jQuery(document).on('ready',function () {
                classicFeatureHeight('#rh-<?php echo $this->get_id(); ?> .rhea_features_image');
            });
            jQuery(window).on('load',function () {
                classicFeatureHeight('#rh-<?php echo $this->get_id(); ?> .rhea_features_image')
            });


            function isInViewport(node) {
                var rect = node.getBoundingClientRect()
                return (
                    (rect.height > 0 || rect.width > 0) &&
                    rect.bottom >= 0 &&
                    rect.right >= 0 &&
                    rect.top <= (window.innerHeight || document.documentElement.clientHeight) &&
                    rect.left <= (window.innerWidth || document.documentElement.clientWidth)
                )
            }

            function scrollParallax(selector) {
                var scrolled = jQuery(window).scrollTop();
                jQuery(selector).each(function (index, element) {
                    var initY = jQuery(this).offset().top;
                    var height = jQuery(this).height();
                    var endY = initY + jQuery(this).height();

                    // Check if the element is in the viewport.
                    var visible = isInViewport(this);
                    if (visible) {
                        var diff = scrolled - initY;
                        var ratio = Math.round((diff / height) * 100);
                        jQuery(this).css('background-position', 'center ' + parseInt((ratio * 1)) + 'px')
                    }

                })
            }

            jQuery('.rhea_image_parallax').each(function () {
                scrollParallax(this);
            });
            jQuery(window).scroll(function () {
                jQuery('.rhea_image_parallax').each(function () {
                    scrollParallax(this);
                });

            });




        </script>
		<?php

	}

}