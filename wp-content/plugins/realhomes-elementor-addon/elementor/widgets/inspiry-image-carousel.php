<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Image_Carousel_Widget extends \Elementor\Widget_Base {

	public function __construct( array $data = [], array $args = null ) {
		parent::__construct( $data, $args );
		wp_enqueue_script( 'jquery-slick' );
	}

	public function get_name() {
		return 'inspiry-image-carousel-widget';
	}

	public function get_title() {
		return esc_html__( 'Image Carousel :: RealHomes', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_keywords() {
		return [ 'image', 'photo', 'visual', 'carousel', 'slider' ];
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_image_carousel',
			[
				'label' => esc_html__( 'Image Carousel', 'realhomes-elementor-addon' ),
			]
		);

		$this->add_control(
			'carousel',
			[
				'label'      => esc_html__( 'Add Images', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::GALLERY,
				'default'    => [],
				'show_label' => false,
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


		$slides_to_show = array(
			'' => esc_html__( 'Default', 'realhomes-elementor-addon' ),
			'1'  => 1,
			'2'  => 2,
			'3'  => 3,
			'4'  => 4,
			'5'  => 5,
			'6'  => 6,
			'7'  => 7,
			'8'  => 8,
			'9'  => 9,
			'10' => 10,
		);

        $this->add_responsive_control(
			'slides_to_show',
			[
				'label' => esc_html__( 'Slides to Show', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SELECT,
                'options' => $slides_to_show,
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'slides_to_scroll',
			[
				'label' => __( 'Slides to Scroll', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'description' => esc_html__( 'Set how many slides are scrolled per swipe.', 'realhomes-elementor-addon' ),
				'options' => $slides_to_show,
				'condition' => [
					'slides_to_show!' => '1',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'image_stretch',
			[
				'label' => esc_html__( 'Image Stretch', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'no' => esc_html__( 'No', 'realhomes-elementor-addon' ),
					'yes' => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				],
			]
		);

		$this->add_control(
			'link_to',
			[
				'label'   => esc_html__( 'Link', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'none',
				'options' => [
					'none'   => esc_html__( 'None', 'realhomes-elementor-addon' ),
					'file'   => esc_html__( 'Media File', 'realhomes-elementor-addon' ),
					'custom' => esc_html__( 'Custom URL', 'realhomes-elementor-addon' ),
				],
			]
		);

		$this->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'realhomes-elementor-addon' ),
				'condition'   => [
					'link_to' => 'custom',
				],
				'show_label'  => false,
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
			'settings',
			[
				'label' => esc_html__( 'Additional Settings', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'effect',
			[
				'label' => esc_html__( 'Effect', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => [
					'slide' => esc_html__( 'Slide', 'realhomes-elementor-addon' ),
					'fade' => esc_html__( 'Fade', 'realhomes-elementor-addon' ),
				],
				'condition' => [
					'slides_to_show' => '1',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay',
			[
				'label' => esc_html__( 'Autoplay', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes' => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
					'no' => esc_html__( 'No', 'realhomes-elementor-addon' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'pause_on_hover',
			[
				'label' => esc_html__( 'Pause on Hover', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes' => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
					'no' => esc_html__( 'No', 'realhomes-elementor-addon' ),
				],
				'condition' => [
					'autoplay' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'pause_on_interaction',
			[
				'label' => esc_html__( 'Pause on Interaction', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes' => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
					'no' => esc_html__( 'No', 'realhomes-elementor-addon' ),
				],
				'condition' => [
					'autoplay' => 'yes',
				],
				'frontend_available' => true,
			]
		);

		// Loop requires a re-render so no 'render_type = none'
		$this->add_control(
			'infinite',
			[
				'label' => esc_html__( 'Infinite Loop', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'yes',
				'options' => [
					'yes' => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
					'no' => esc_html__( 'No', 'realhomes-elementor-addon' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label' => esc_html__( 'Autoplay Speed', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 3000,
				'condition' => [
					'autoplay' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'speed',
			[
				'label' => esc_html__( 'Animation Speed', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'default' => 500,
				'frontend_available' => true,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_carousel',
			[
				'label' => esc_html__( 'Carousel', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'image_carousel_radius',
			[
				'label'      => esc_html__( 'Border Radius', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-image-carousel-wrapper .rhea-image-carousel' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style_navigation',
			[
				'label' => esc_html__( 'Navigation', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'dots_align',
			[
				'label'     => esc_html__( 'Alignment', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::CHOOSE,
				'options'   => [
					'left'   => [
						'title' => esc_html__( 'Left', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'realhomes-elementor-addon' ),
						'icon'  => 'eicon-text-align-right',
					],
				],
				'default'   => 'center',
				'selectors' => [
					'{{WRAPPER}} .rhea-image-carousel .slick-dots' => 'text-align: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dots_color',
			[
				'label' => esc_html__( 'Color', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-image-carousel .slick-dots li button' => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dots_hover_color',
			[
				'label'     => esc_html__( 'Hover Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-image-carousel .slick-dots li.slick-active button' => 'background: {{VALUE}};',
					'{{WRAPPER}} .rhea-image-carousel .slick-dots li:hover button'  => 'background: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'dots_size',
			[
				'label' => esc_html__( 'Size', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 6,
						'max' => 24,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-image-carousel .slick-dots li button' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings  = $this->get_settings_for_display();
		$widget_id = $this->get_id();
		$link_to   = $this->get_link_url( $settings );

		if ( empty( $settings['carousel'] ) ) {
			return;
		}

		$container_classes = array('rhea-image-carousel');
		if( 'yes' === $settings['image_stretch']) {
			$container_classes[] = 'rhea-stretch-carousel-image';
		}

		$carousel_items = [];
		foreach ( $settings['carousel'] as $index => $attachment ) {
			$attachment_id = $attachment['id'];

			$image_url = \Elementor\Group_Control_Image_Size::get_attachment_image_src( $attachment_id, 'thumbnail', $settings );
			if ( ! $image_url && isset( $attachment['url'] ) ) {
				$image_url = $attachment['url'];
			}

			$image_html = '<img class="rhea-image-carousel-image" src="' . esc_url( $image_url ) . '" alt="' . esc_attr( \Elementor\Control_Media::get_image_alt( $attachment ) ) . '" />';

			$link_tag = '';
			$link     = $link_to;
			
			if ( empty( $link ) ) {
				$link = [ 'url' => wp_get_attachment_url( $attachment_id ) ];
            }

			if ( $link ) {

				$link_key = 'link_' . $index;

				$this->add_lightbox_data_attributes( $link_key, $attachment_id, $settings['open_lightbox'], $this->get_id() );

				if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
					$this->add_render_attribute( $link_key, [
						'class' => 'elementor-clickable',
					] );
				}

				$this->add_link_attributes( $link_key, $link );

				$link_tag = '<a ' . $this->get_render_attribute_string( $link_key ) . '>';
			}

			$slide_html = '<div class="rhea-image-carousel-item">' . $link_tag . $image_html;

			if ( $link ) {
				$slide_html .= '</a>';
			}

			$slide_html .= '</div>';

			$carousel_items[] = $slide_html;
		}

		if ( empty( $carousel_items ) ) {
			return;
		}
		?>
        <div id="rhea-image-carousel-wrapper-<?php echo esc_attr( $widget_id ); ?>" class="rhea-image-carousel-wrapper">
            <div id="rhea-image-carousel-<?php echo esc_attr( $widget_id ); ?>" class="<?php echo join(' ', $container_classes ); ?>">
				<?php echo implode( '', $carousel_items ); ?>
            </div>
        </div>
		<?php
        $slides_to_show = 1;
		if( $settings['slides_to_show'] ){
			$slides_to_show = $settings['slides_to_show'];
		}

        $slides_to_scroll = 1;
        if( $settings['slides_to_scroll'] ){
	        $slides_to_scroll = $settings['slides_to_scroll'];
        }

		$slides_to_show_tablet = 1;
		if( $settings['slides_to_show_tablet'] ){
			$slides_to_show_tablet = $settings['slides_to_show_tablet'];
		}

		$slides_to_scroll_tablet = 1;
		if( $settings['slides_to_scroll_tablet'] ){
			$slides_to_scroll_tablet = $settings['slides_to_scroll_tablet'];
		}

		$slides_to_show_mobile = 1;
		if( $settings['slides_to_show_mobile'] ){
			$slides_to_show_mobile = $settings['slides_to_show_mobile'];
		}

		$slides_to_scroll_mobile = 1;
		if( $settings['slides_to_scroll_mobile'] ){
			$slides_to_scroll_mobile = $settings['slides_to_scroll_mobile'];
		}

		$carousel_options                         = array();
		$carousel_options['id']                   = '#rhea-image-carousel-' . esc_html( $widget_id );
		$carousel_options['slidesToShow']         = (int) $slides_to_show;
		$carousel_options['slidesToScroll']       = (int) $slides_to_scroll;
		$carousel_options['slidesToShowTablet']   = (int) $slides_to_show_tablet;
		$carousel_options['slidesToScrollTablet'] = (int) $slides_to_scroll_tablet;
		$carousel_options['slidesToShowMobile']   = (int) $slides_to_show_mobile;
		$carousel_options['slidesToScrollMobile'] = (int) $slides_to_scroll_mobile;
		$carousel_options['speed']                = (int) $settings['speed'];
		$carousel_options['autoplaySpeed']        = (int) $settings['autoplay_speed'];
		$carousel_options['autoplay']             = ( 'yes' == $settings['autoplay'] );
		$carousel_options['pauseOnHover']         = ( 'yes' == $settings['pause_on_hover'] );
		$carousel_options['pauseOnInteraction']   = ( 'yes' == $settings['pause_on_interaction'] );
		$carousel_options['infinite']             = ( 'yes' == $settings['infinite'] );
		$carousel_options['fade']                 = ( 'fade' == $settings['effect'] );
		?>
        <script type="application/javascript">
            (function ($) {
                'use strict';
                $(document).ready(function () {
                    rheaImageCarousel(<?php echo wp_json_encode( $carousel_options ); ?>);
                });
            })(jQuery);
        </script>
		<?php
	}

	private function get_link_url( $instance ) {
		if ( 'none' === $instance['link_to'] ) {
			return false;
		}

		if ( 'custom' === $instance['link_to'] ) {
			if ( empty( $instance['link']['url'] ) ) {
				return false;
			}

			return $instance['link'];
		}
	}
}
