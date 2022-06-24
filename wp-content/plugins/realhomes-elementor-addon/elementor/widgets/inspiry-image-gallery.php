<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Image_Gallery_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'inspiry-image-gallery-widget';
	}

	public function get_title() {
		return esc_html__( 'Gallery :: RealHomes', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_keywords() {
		return [ 'image', 'photo', 'visual', 'gallery' ];
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_gallery',
			[
				'label' => esc_html__( 'Settings', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'gallery_type',
			[
				'label'       => esc_html__( 'Type', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Choose Multiple to enable filterable galleries.', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => 'single',
				'options'     => [
					'single'   => esc_html__( 'Single', 'realhomes-elementor-addon' ),
					'multiple' => esc_html__( 'Multiple', 'realhomes-elementor-addon' ),
				],
			]
		);

		$this->add_control(
			'single_gallery',
			[
				'label'     => esc_html__( 'Add Images', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::GALLERY,
				'condition' => [
					'gallery_type' => 'single',
				],
			]
		);

		$gallery_repeater = new \Elementor\Repeater();

		$gallery_repeater->add_control(
			'gallery_title',
			[
				'label'   => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'New Gallery', 'realhomes-elementor-addon' ),
			]
		);

		$gallery_repeater->add_control(
			'gallery_images',
			[
				'label'   => esc_html__( 'Add Images', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::GALLERY,
				'default' => [],
			]
		);

		$this->add_control(
			'multiple_galleries',
			[
				'label'       => esc_html__( 'Galleries', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $gallery_repeater->get_controls(),
				'default'     => [
					[
						'gallery_title' => esc_html__( 'Gallery One', 'realhomes-elementor-addon' ),
					],
					[
						'gallery_title' => esc_html__( 'Gallery Two', 'realhomes-elementor-addon' ),
					],
				],
				'title_field' => ' {{{ gallery_title }}}',
				'condition'   => [
					'gallery_type' => 'multiple',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'default'   => 'partners-logo',
				'separator' => 'none',
			]
		);

		$this->add_control(
			'all_filter_label',
			[
				'label'     => esc_html__( 'All Filter Label', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::TEXT,
				'default'   => '',
				'condition' => [
					'gallery_type' => 'multiple',
				],
			]
		);

		$this->add_control(
			'gallery_layout',
			[
				'label'     => esc_html__( 'Layout', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'masonry',
				'options'   => [
					'masonry'  => esc_html__( 'Masonry', 'realhomes-elementor-addon' ),
					'grid'     => esc_html__( 'Grid', 'realhomes-elementor-addon' ),
				],
			]
		);

		$this->add_responsive_control(
			'gallery_columns',
			[
				'label'     => esc_html__( 'Columns', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 4,
				'options' => [
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
					5 => 5,
					6 => 6,
				],
			]
		);

		$this->add_responsive_control(
			'spacing_custom',
			[
				'label'     => esc_html__( 'Spacing', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'max' => 90,
					],
				],
				'default'   => [
					'size' => 30,
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-image-gallery'      => 'margin-left: -{{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .rhea-image-gallery-item' => 'padding-left: {{SIZE}}{{UNIT}}; margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'link_to',
			[
				'label'   => esc_html__( 'Link', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'file',
				'options' => [
					'file' => esc_html__( 'Media File', 'realhomes-elementor-addon' ),
					'none' => esc_html__( 'None', 'realhomes-elementor-addon' ),
				],
			]
		);

		$this->add_control(
			'open_lightbox',
			[
				'label'     => esc_html__( 'Lightbox', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => 'default',
				'options'   => [
					'default' => esc_html__( 'Default', 'realhomes-elementor-addon' ),
					'yes'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
					'no'      => esc_html__( 'No', 'realhomes-elementor-addon' ),
				],
				'condition' => [
					'link_to' => 'file',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_gallery_images',
			[
				'label' => esc_html__( 'Images', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-image-gallery-item img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name'     => 'image_border',
				'selector' => '{{WRAPPER}} .rhea-image-gallery img',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_filters',
			[
				'label' => esc_html__( 'Filters', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
				'condition'   => [
					'gallery_type' => 'multiple',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'      => 'section_filters_typography',
				'label'     => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'scheme'    => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector'  => '{{WRAPPER}} .rhea-image-gallery-filters a',
				'separator' => 'after',
				'condition'   => [
					'gallery_type' => 'multiple',
				],
			]
		);

		$this->start_controls_tabs( 'filters_tabs' );

		$this->start_controls_tab(
			'section_filters_normal',
			[
				'label' => esc_html__( 'Normal', 'realhomes-elementor-addon' ),
				'condition'   => [
					'gallery_type' => 'multiple',
				],
			]
		);

		$this->add_control(
			'section_filters_color',
			[
				'label'     => esc_html__( 'Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-image-gallery-filters a' => 'color: {{VALUE}};',
				],
				'condition'   => [
					'gallery_type' => 'multiple',
				],
			]
		);

		$this->add_control(
			'section_filters_bg_color',
			[
				'label'     => esc_html__( 'Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-image-gallery-filters a' => 'background: {{VALUE}};',
				],
				'condition'   => [
					'gallery_type' => 'multiple',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'section_filters_hover',
			[
				'label' => esc_html__( 'Hover', 'realhomes-elementor-addon' ),
				'condition'   => [
					'gallery_type' => 'multiple',
				],
			]
		);

		$this->add_control(
			'section_filters_hover_color',
			[
				'label'     => esc_html__( 'Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-image-gallery-filters a:hover'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .rhea-image-gallery-filters a:focus'   => 'color: {{VALUE}};',
					'{{WRAPPER}} .rhea-image-gallery-filters a.current' => 'color: {{VALUE}};',
				],
				'condition'   => [
					'gallery_type' => 'multiple',
				],
			]
		);

		$this->add_control(
			'section_filters_hover_bg_color',
			[
				'label'     => esc_html__( 'Background', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-image-gallery-filters a:hover'   => 'background: {{VALUE}};',
					'{{WRAPPER}} .rhea-image-gallery-filters a:focus'   => 'background: {{VALUE}};',
					'{{WRAPPER}} .rhea-image-gallery-filters a.current' => 'background: {{VALUE}};',
				],
				'condition'   => [
					'gallery_type' => 'multiple',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'section_filters_border_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-image-gallery-filters a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'   => [
					'gallery_type' => 'multiple',
				],
			]
		);

		$this->add_responsive_control(
			'section_filters_padding',
			[
				'label'     => esc_html__( 'Padding', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .rhea-image-gallery-filters a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'   => [
					'gallery_type' => 'multiple',
				],
			]
		);

		$this->add_responsive_control(
			'section_filters_margin',
			[
				'label'     => esc_html__( 'Margin', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .rhea-image-gallery-filters'   => 'margin-right: -{{RIGHT}}{{UNIT}}; margin-left: -{{LEFT}}{{UNIT}}; margin-bottom: {{BOTTOM}}{{UNIT}};',
					'{{WRAPPER}} .rhea-image-gallery-filters a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'   => [
					'gallery_type' => 'multiple',
				],
			]
		);

		$this->add_responsive_control(
			'section_filters_align',
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
					'{{WRAPPER}} .rhea-image-gallery-filters' => 'text-align: {{VALUE}};',
				],
				'separator' => 'before',
				'condition'   => [
					'gallery_type' => 'multiple',
				],
			]
		);

		$this->end_controls_section();

	}

	protected function render() {
		$settings          = $this->get_settings_for_display();
		$widget_id         = $this->get_id();
		$container_classes = array();

		$container_classes[] = 'rhea-image-gallery';

		if ( $settings['gallery_columns'] ) {
			$container_classes[] = 'rhea-image-gallery-column-' . esc_html( $settings['gallery_columns'] );
		}

		if ( isset( $settings['gallery_columns_widescreen'] ) ) {
			$container_classes[] = 'rhea-image-gallery-column-widescreen-' . esc_html( $settings['gallery_columns_widescreen'] );
		}

		if ( isset( $settings['gallery_columns_laptop'] ) ) {
			$container_classes[] = 'rhea-image-gallery-column-laptop-' . esc_html( $settings['gallery_columns_laptop'] );
		}

		if ( isset( $settings['gallery_columns_tablet_extra'] ) ) {
			$container_classes[] = 'rhea-image-gallery-column-tablet_extra-' . esc_html( $settings['gallery_columns_tablet_extra'] );
		}

		if ( isset( $settings['gallery_columns_tablet'] ) ) {
			$container_classes[] = 'rhea-image-gallery-column-tablet-' . esc_html( $settings['gallery_columns_tablet'] );
		}

		if ( isset( $settings['gallery_columns_mobile_extra'] ) ) {
			$container_classes[] = 'rhea-image-gallery-column-mobile_extra-' . esc_html( $settings['gallery_columns_mobile_extra'] );
		}

        if ( isset( $settings['gallery_columns_mobile'] ) ) {
            $container_classes[] = 'rhea-image-gallery-column-mobile-' . esc_html( $settings['gallery_columns_mobile'] );
        }
		?>
        <div id="rhea-image-gallery-wrapper-<?php echo esc_attr( $widget_id ); ?>" class="rhea-image-gallery-wrapper">

			<?php if ( in_array( $settings['gallery_layout'], array( 'masonry', 'grid' ) ) && 'multiple' === $settings['gallery_type'] ) { ?>
                <div id="rhea-image-gallery-filters-<?php echo esc_attr( $widget_id ); ?>"
                     class="rhea-image-gallery-filters">
                    <a href="#" data-filter="rhea-image-gallery-item"
                       class="current"><?php
						if ( $settings['all_filter_label'] ) {
							echo esc_html( $settings['all_filter_label'] );
						} else {
							esc_html_e( 'All', 'realhomes-elementor-addon' );
						}
						?></a><?php
					foreach ( $settings['multiple_galleries'] as $single_gallery ) {
						if ( ! empty( $single_gallery['gallery_title'] ) ) {
							$title = $single_gallery['gallery_title'];
							$slug  = str_replace( ' ', '', strtolower( $title ) );

							echo '<a href="#" data-filter="' . esc_attr( $slug ) . '">' . esc_html( $title ) . '</a>';
						}
					}
					?>
                </div><!-- .rhea-image-gallery-filters -->
			<?php } ?>

            <div id="rhea-image-gallery-<?php echo esc_attr( $widget_id ); ?>" class="<?php echo join( ' ', $container_classes ); ?>">
                <?php
                $link_to = ( 'none' !== $settings['link_to'] );
                if ( 'multiple' === $settings['gallery_type'] ) {
                    foreach ( $settings['multiple_galleries'] as $single_gallery ) {
                        $this->gallery_items( $single_gallery, $settings, $link_to );
                    }
                }
                if ( 'single' === $settings['gallery_type'] && $link_to ) {
                  $this->gallery_items( $settings['single_gallery'], $settings, $link_to );
                }
                ?>
            </div><!-- .rhea-image-gallery -->

        </div><!-- .rhea-image-gallery-wrapper -->
		<?php
		$gallery_options                 = array();
		$gallery_options['containerId']  = '#rhea-image-gallery-' . esc_html( $widget_id );
		$gallery_options['filters']      = '#rhea-image-gallery-filters-' . esc_html( $widget_id ) . ' a';
		$gallery_options['itemSelector'] = '.rhea-image-gallery-item';
		$gallery_options['layout']       = $settings['gallery_layout'];
		?>
        <script type="application/javascript">
            (function ($, elementorFrontend) {
                'use strict';
		        <?php
		        if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
		        ?>
                elementorFrontend.hooks.addAction('frontend/element_ready/inspiry-image-gallery-widget.default', function () {
                    setTimeout(function () {
                        rheaImageGallery(<?php echo wp_json_encode( $gallery_options ); ?>);
                   }, 2500);
                });
		        <?php
		        } else {
		        ?>
                $(window).on('elementor/frontend/init load', function () {
                    rheaImageGallery(<?php echo wp_json_encode( $gallery_options ); ?>);
                });
		        <?php
		        }
		        ?>
            })(jQuery, window.elementorFrontend);
        </script>
		<?php
	}

	private function gallery_items( $gallery, $settings, $link_to ) {
		$gallery_images = [];
		$gallery_id     = '';
		$item_class     = 'rhea-image-gallery-item';
		if ( 'multiple' === $settings['gallery_type'] ) {
			$item_class .= ' ' . str_replace( ' ', '', strtolower( $gallery['gallery_title'] ) );
			$gallery_id = $gallery['_id'] . '_';
			$gallery    = $gallery['gallery_images'];
		}

		foreach ( $gallery as $index => $gallery_image ) {

				if ( ! empty( $gallery_image['id'] ) ) {

				$gallery_image_id = $gallery_image['id'];

				$image_url  = \Elementor\Group_Control_Image_Size::get_attachment_image_src( $gallery_image_id, 'thumbnail', $settings );
				$image_html = '<img class="rhea-image-gallery-item-image" src="' . esc_attr( $image_url ) . '" alt="' . esc_attr( \Elementor\Control_Media::get_image_alt( $gallery_image ) ) . '" />';

				$link_tag = '';
				$link = '';
				if ( $link_to ) {
					$link = [ 'url' => wp_get_attachment_url( $gallery_image_id ) ];
					$link_key = 'link_' . $gallery_id . $index;

					$this->add_lightbox_data_attributes( $link_key, $gallery_image_id, $settings['open_lightbox'], $this->get_id() );

					if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
						$this->add_render_attribute( $link_key, [ 'class' => 'elementor-clickable', ] );
					}

					$this->add_link_attributes( $link_key, $link );

					$link_tag = '<a ' . $this->get_render_attribute_string( $link_key ) . '>';
				}

				$gallery_image_html = '<div class="' . esc_attr( $item_class ) . '">' . '<figure>' . $link_tag . $image_html;

				if ( $link ) {
					$gallery_image_html .= '</a>';
				}

				$gallery_image_html .= '</figure>';

				$gallery_image_html .= '</div>';

				$gallery_images[] = $gallery_image_html;

			}

		}

		if ( ! empty( $gallery_images ) ) {
			echo implode( '', $gallery_images );
		}
	}
}
