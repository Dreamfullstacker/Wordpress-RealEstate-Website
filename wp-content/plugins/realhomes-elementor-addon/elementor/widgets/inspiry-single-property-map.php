<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Single_Property_Map_Widget extends \Elementor\Widget_Base {

	public function __construct( array $data = [], array $args = null ) {
		parent::__construct( $data, $args );

		// Check for Google Map API key and enqueue required script and style.
		if ( ! empty( get_option( 'inspiry_google_maps_api_key', '' ) ) ) {
			wp_enqueue_script(
				'google-map-api',
				esc_url_raw(
					add_query_arg(
						apply_filters( 'inspiry_google_map_arguments', array() ), '//maps.google.com/maps/api/js' )
				),
				array(),
				false,
				false
			);
		} else {
			wp_enqueue_style( 'leaflet', 'https://unpkg.com/leaflet@1.3.4/dist/leaflet.css', array(), '1.3.4' );
			wp_enqueue_script( 'leaflet', 'https://unpkg.com/leaflet@1.3.4/dist/leaflet.js', array(), '1.3.4', true );
		}
	}

	public function get_name() {
		return 'rhea-single-property-map-widget';
	}

	public function get_title() {
		return esc_html__( 'Single Property Map', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-google-maps';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	public function get_keywords() {
		return [ 'google', 'map', 'embed', 'location' ];
	}

	protected function register_controls() {

		$this->start_controls_section(
			'map_section',
			[
				'label' => esc_html__( 'Map', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'lat',
			[
				'label'       => esc_html__( 'Latitude', 'realhomes-elementor-addon' ),
				'default'     => '27.664827',
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'separator'   => 'before',
			]
		);

		$this->add_control(
			'lng',
			[
				'label'       => esc_html__( 'Longitude', 'realhomes-elementor-addon' ),
				'default'     => '-81.515755',
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true
			]
		);

		$this->add_control(
			'zoom',
			[
				'label'   => esc_html__( 'Zoom', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SLIDER,
				'default' => [
					'size' => 12,
				],
				'range'   => [
					'px' => [
						'min' => 5,
						'max' => 20,
					],
				],
			]
		);

		$this->add_responsive_control(
			'width',
			[
				'label'     => esc_html__( 'Width', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-map' => 'width: {{SIZE}}%;',
				],
			]
		);

		$this->add_responsive_control(
			'height',
			[
				'label'           => esc_html__( 'Height', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 250,
						'max' => 750,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 460,
					'unit' => 'px',
				],
				'tablet_default'  => [
					'size' => 300,
					'unit' => 'px',
				],
				'mobile_default'  => [
					'size' => 250,
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea-single-property-map' => 'height: {{SIZE}}{{UNIT}};',
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'address_section',
			[
				'label' => esc_html__( 'Address', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_address_section',
			[
				'label'        => __( 'Show', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => __( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'location_label',
			[
				'label'       => esc_html__( 'Title', 'realhomes-elementor-addon' ),
				'default'     => esc_html__( 'Location', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
			]
		);

		$this->add_control(
			'contact_number',
			[
				'label'   => esc_html__( 'Phone', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->add_control(
			'email_address',
			[
				'label'   => esc_html__( 'Email', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => '',
			]
		);

		$this->add_control(
			'address',
			[
				'label'       => esc_html__( 'Address', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'HTML tags ( a, strong, b, em, i, br ) can be used in Address', 'realhomes-elementor-addon' ),
				'default'     => 'Merrick Way, Miami, <br />FL 33134, USA',
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
			]
		);

		$this->add_control(
			'show_field_icon',
			[
				'label'        => __( 'Show Field Icon', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => __( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_responsive_control(
			'field_content_align',
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
					'{{WRAPPER}} .rhea-single-property-map-info-inner' => 'text-align: {{VALUE}};',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'background_image',
			[
				'label'   => esc_html__( 'Section Background Image', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Image_Size::get_type(),
			[
				'name'      => 'thumbnail',
				// Usage: `{name}_size` and `{name}_custom_dimension`, in this case `thumbnail_size` and `thumbnail_custom_dimension`.
				'exclude'   => [ 'custom' ],
				'default'   => 'full',
				'separator' => 'none',
			]
		);

		$this->add_responsive_control(
			'address_section_width',
			[
				'label'     => esc_html__( 'Section Width', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-map-info' => 'width: {{SIZE}}%;',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'map_spaces_section',
			[
				'label' => esc_html__( 'Map', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'container_width',
			[
				'label'           => esc_html__( 'Container Width', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 400,
						'max' => 1600,
					],
					'%'  => [
						'min' => 50,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 1140,
					'unit' => 'px',
				],
				'tablet_default'  => [
					'size' => 100,
					'unit' => '%',
				],
				'mobile_default'  => [
					'size' => 100,
					'unit' => '%',
				],
				'size_units'      => [ 'px', '%' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea-single-property-map-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'swap_column_position',
			[
				'label'        => __( 'Swap Column Position', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => __( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'map_color',
			[
				'label'   => esc_html__( 'Map Color', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'alpha'   => false,
				'default' => '#1ea69a'
			]
		);

		$this->add_control(
			'map_marker',
			[
				'label'       => esc_html__( 'Map Marker', 'realhomes-elementor-addon' ),
				'description' => esc_html__( 'Recommended image size is 30x50.', 'realhomes-elementor-addon' ),
				'type'        => \Elementor\Controls_Manager::MEDIA,
				'default'     => [
					'url' => '',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'address_section_style',
			[
				'label' => esc_html__( 'Address', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'address_container_bg',
			[
				'label'     => esc_html__( 'Address Wrapper Background Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-map-wrapper .rhea-single-property-map-info-inner' => 'background-color: {{VALUE}}',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'heading_color',
			[
				'label'     => esc_html__( 'Title Color ', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-map-wrapper .rhea-single-property-map-heading' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'heading_typography',
				'label'    => esc_html__( 'Title Typography', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-single-property-map-wrapper .rhea-single-property-map-heading',
			]
		);

		$this->add_responsive_control(
			'heading_margin_bottom',
			[
				'label'     => esc_html__( 'Title Margin Bottom', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-map-wrapper .rhea-single-property-map-heading' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'phone_color',
			[
				'label'     => esc_html__( 'Phone Color ', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-map-wrapper .rhea-single-property-map-number a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'phone_hover_color',
			[
				'label'     => esc_html__( 'Phone Hover Color ', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-map-wrapper .rhea-single-property-map-number a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'phone_typography',
				'label'    => esc_html__( 'Phone Typography', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-single-property-map-wrapper .rhea-single-property-map-number',
			]
		);

		$this->add_responsive_control(
			'phone_margin_bottom',
			[
				'label'     => esc_html__( 'Phone Margin Bottom', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-map-wrapper .rhea-single-property-map-number' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'email_color',
			[
				'label'     => esc_html__( 'Email Color ', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-map-wrapper .rhea-single-property-map-email a' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'email_hover_color',
			[
				'label'     => esc_html__( 'Email Hover Color ', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-map-wrapper .rhea-single-property-map-email a:hover' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'email_typography',
				'label'    => esc_html__( 'Email Typography', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-single-property-map-wrapper .rhea-single-property-map-email',
			]
		);

		$this->add_responsive_control(
			'email_margin_bottom',
			[
				'label'     => esc_html__( 'Email Margin Bottom', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-map-wrapper .rhea-single-property-map-email' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'address_color',
			[
				'label'     => esc_html__( 'Address Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-map-wrapper .rhea-single-property-map-address' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'address_typography',
				'label'    => esc_html__( 'Address Typography', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-single-property-map-wrapper .rhea-single-property-map-address',
			]
		);

		$this->add_responsive_control(
			'address_margin_bottom',
			[
				'label'     => esc_html__( 'Address Margin Bottom', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-map-wrapper .rhea-single-property-map-address' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'icon_color',
			[
				'label'     => esc_html__( 'Icon Color ', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-map-wrapper p i' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'icon_size',
			[
				'label'     => esc_html__( 'Icon Size', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-map-wrapper p i' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_margin',
			[
				'label'     => esc_html__( 'Icon Spacing', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::SLIDER,
				'range'     => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .rhea-single-property-map-wrapper p i' => is_rtl() ? 'margin-left: {{SIZE}}{{UNIT}};' : 'margin-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings        = $this->get_settings_for_display();
		$widget_id       = $this->get_id();
		$container_class = 'rhea-single-property-map-wrapper';

		$address_section = ( 'yes' === $settings['show_address_section'] ) && ( $settings['location_label'] || $settings['address'] );
		if ( ! $address_section ) {
			$container_class .= ' rhea-single-property-map-fullwidth';
		}

		if ( 'yes' === $settings['swap_column_position'] ) {
			$container_class .= ' rhea-single-property-map-swap-col';
		}

		$show_field_icon = ( 'yes' === $settings['show_field_icon'] );
		?>
        <div id="rhea-single-property-map-wrapper-<?php echo esc_attr( $widget_id ); ?>" class="<?php echo esc_attr( $container_class ); ?>">
            <div id="rhea-single-property-map-<?php echo esc_attr( $widget_id ); ?>" class="rhea-single-property-map"></div>
			<?php
			if ( $address_section ) {
				?>
                <div class="rhea-single-property-map-info" style="background-image: url('<?php echo esc_url( \Elementor\Group_Control_Image_Size::get_attachment_image_src( $settings['background_image']['id'], 'thumbnail', $settings ) ); ?>');">
                    <div class="rhea-single-property-map-info-inner">
						<?php
						if ( $settings['location_label'] ) { ?>
                            <h4 class="rhea-single-property-map-heading"><?php echo esc_html( $settings['location_label'] ); ?></h4>
							<?php
						}

						if ( ! empty( $settings['contact_number'] ) ) { ?>
                            <p class="rhea-single-property-map-number">
								<?php if ( $show_field_icon ) { ?>
                                    <i class="fas fa-phone-alt"></i>
								<?php } ?>
                                <a href="tel:<?php echo esc_attr( $settings['contact_number'] ); ?>"><?php echo esc_html( $settings['contact_number'] ); ?></a>
                            </p>
							<?php
						}

						if ( ! empty( $settings['email_address'] ) ) { ?>
                            <p class="rhea-single-property-map-email">
								<?php if ( $show_field_icon ) { ?>
                                    <i class="fas fa-envelope"></i>
								<?php } ?>
                                <a href="mailto:<?php echo esc_attr( antispambot( $settings['email_address'] ) ); ?>"><?php echo esc_attr( antispambot( $settings['email_address'] ) ); ?></a>
                            </p>
							<?php
						}

						if ( $settings['address'] ) {
							?>
                            <p class="rhea-single-property-map-address">
								<?php if ( $show_field_icon ) { ?>
                                    <i class="fas fa-map-marker-alt"></i>
									<?php
								}
								echo wp_kses( $settings['address'], array(
									'a'      => array(
										'href'   => array(),
										'title'  => array(),
										'alt'    => array(),
										'target' => array(),
									),
									'br'     => array(),
									'i'      => array(
										'class' => array(),
									),
									'em'     => array(),
									'b'      => array(),
									'strong' => array(),
								) );
								?>
                            </p>
							<?php
						}
						?>
                    </div>
                </div>
				<?php
			}
			?>
        </div>
        <script type="application/javascript">
			<?php
			if ( 0 === absint( $settings['zoom']['size'] ) ) {
				$settings['zoom']['size'] = 10;
			}
			$map_data = array();
			$map_data['id'] = 'rhea-single-property-map-' . esc_attr( $this->get_id() );
			$map_data['lat'] = $settings['lat'];
			$map_data['lng'] = $settings['lng'];
			$map_data['zoom'] = $settings['zoom']['size'];
			$map_data['mapType'] = empty( get_option( 'inspiry_google_maps_api_key', '' ) ) ? 'os' : 'google';
			$map_data['mapWaterColor'] = $settings['map_color'];
			$map_data['mapMarker'] = esc_url( RHEA_PLUGIN_URL . 'assets/icons/map-pin.svg' );

			if ( ! empty( $settings['map_marker']['url'] ) ) {
				$map_data['mapMarker'] = esc_url( $settings['map_marker']['url'] );
			}
			?>
            (function ($) {
                'use strict';
                $(document).ready(function () {

                    let mapData = <?php echo wp_json_encode( $map_data ); ?>;
                    const mapContainer = document.getElementById(mapData.id);

                    if (mapData.lat && mapData.lng) {

                        // Google Map
                        if ('google' === mapData.mapType) {

                            const latLng = {lat: parseFloat(mapData.lat), lng: parseFloat(mapData.lng)};
                            const mapOptions = {
                                zoom: parseInt(mapData.zoom),
                                center: latLng,
                                streetViewControl: false,
                                scrollwheel: false,
                                styles: [{
                                    "featureType": "administrative",
                                    "elementType": "labels.text",
                                    "stylers": [{
                                        "color": "#000000"
                                    }]
                                }, {
                                    "featureType": "administrative",
                                    "elementType": "labels.text.fill",
                                    "stylers": [{
                                        "color": "#444444"
                                    }]
                                }, {
                                    "featureType": "administrative",
                                    "elementType": "labels.text.stroke",
                                    "stylers": [{
                                        "visibility": "off"
                                    }]
                                }, {
                                    "featureType": "administrative",
                                    "elementType": "labels.icon",
                                    "stylers": [{
                                        "visibility": "on"
                                    }, {
                                        "color": "#380d0d"
                                    }]
                                }, {
                                    "featureType": "landscape", "elementType": "all", "stylers": [{
                                        "color": "#f2f2f2"
                                    }]
                                }, {
                                    "featureType": "poi", "elementType": "all", "stylers": [{
                                        "visibility": "off"
                                    }]
                                }, {
                                    "featureType": "road", "elementType": "all", "stylers": [{
                                        "saturation": -100
                                    }, {
                                        "lightness": 45
                                    }]
                                }, {
                                    "featureType": "road", "elementType": "geometry", "stylers": [{
                                        "visibility": "on"
                                    }, {
                                        "color": "#dedddb"
                                    }]
                                }, {
                                    "featureType": "road", "elementType": "labels.text", "stylers": [{
                                        "color": "#000000"
                                    }]
                                }, {
                                    "featureType": "road", "elementType": "labels.text.fill", "stylers": [{
                                        "color": "#1f1b1b"
                                    }]
                                }, {
                                    "featureType": "road", "elementType": "labels.text.stroke", "stylers": [{
                                        "visibility": "off"
                                    }]
                                }, {
                                    "featureType": "road", "elementType": "labels.icon", "stylers": [{
                                        "visibility": "on"
                                    }, {
                                        "hue": "#ff0000"
                                    }]
                                }, {
                                    "featureType": "road.highway", "elementType": "all", "stylers": [{
                                        "visibility": "simplified"
                                    }]
                                }, {
                                    "featureType": "road.arterial",
                                    "elementType": "labels.icon",
                                    "stylers": [{
                                        "visibility": "off"
                                    }]
                                }, {
                                    "featureType": "transit", "elementType": "all", "stylers": [{
                                        "visibility": "off"
                                    }]
                                }, {
                                    "featureType": "water", "elementType": "all", "stylers": [{
                                        "color": mapData.mapWaterColor
                                    }, {
                                        "visibility": "on"
                                    }]
                                }]
                            };
                            const map = new google.maps.Map(mapContainer, mapOptions);

                            new google.maps.Marker({
                                position: latLng,
                                map,
                                icon: {
                                    url: mapData.mapMarker,
                                },
                            });

                        } else {

                            // Open Street Map
                            const tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                            });
                            const latLng = L.latLng(mapData.lat, mapData.lng);
                            const mapOptions = {
                                zoom: parseInt(mapData.zoom),
                                center: latLng,
                            };
                            const map = L.map(mapContainer, mapOptions);
                            map.scrollWheelZoom.disable();
                            map.addLayer(tileLayer);

                            // Marker
                            var markerOptions = {
                                icon: L.icon({
                                    iconUrl: mapData.mapMarker,
                                })
                            };

                            L.marker([mapData.lat, mapData.lng], markerOptions).addTo(map);
                        }
                    } else {
                        mapContainer.style.display = 'none';
                    }
                });
            })(jQuery);
        </script>
		<?php
	}
}