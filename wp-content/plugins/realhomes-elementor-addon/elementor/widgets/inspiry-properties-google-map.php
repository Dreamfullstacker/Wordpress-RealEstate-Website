<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Properties_Google_Map_Widget extends \Elementor\Widget_Base {

	public function __construct( array $data = [], array $args = null ) {
		parent::__construct( $data, $args );

		$google_map_arguments = array();

		wp_enqueue_script(
			'google-map-api',
			esc_url_raw(
				add_query_arg(
					apply_filters( 'inspiry_google_map_arguments', $google_map_arguments ), '//maps.google.com/maps/api/js' )
			),
			array(),
			false,
			false
		);

		$this->rhea_enqueue_google_map_clusterer_spiderfier();
		$this->rhea_enqueue_google_map_info_box();


	}

	public function get_name() {
		return 'rhea-properties-google-map-widget';
	}

	public function get_title() {
		return esc_html__( 'Properties Google Map', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		// More classes for icons can be found at https://pojome.github.io/elementor-icons/
		return 'eicon-google-maps';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}


    public function rhea_enqueue_google_map_clusterer_spiderfier(){
	    wp_enqueue_script(  'google-map-marker-clusterer', RHEA_PLUGIN_URL . 'elementor/js/markerclusterer.js', array( 'google-map-api' ), '2.1.1' );
	    wp_enqueue_script(  'google-map-oms', RHEA_PLUGIN_URL . 'elementor/js/oms.min.js', array( 'google-map-api' ), '0.3.3' );
    }

    public function rhea_enqueue_google_map_info_box(){
	    wp_enqueue_script(  'google-map-info-box', RHEA_PLUGIN_URL . 'elementor/js/infobox.js', array( 'google-map-api' ), '1.1.9' );

    }

	protected function register_controls() {

		$allowed_html = array(
			'a'      => array(
				'href'  => array(),
				'title' => array()
			),
			'br'     => array(),
			'em'     => array(),
			'strong' => array(),
		);

		$this->start_controls_section(
			'ere_properties_section',
			[
				'label' => esc_html__( 'Properties', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'posts_per_page',
			[
				'label'   => esc_html__( 'Number of Properties', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 1000,
				'step'    => 1,
				'default' => 6,
			]
		);

		$property_taxonomies = get_object_taxonomies( 'property', 'objects' );
		if ( ! empty( $property_taxonomies ) && ! is_wp_error( $property_taxonomies ) ) {
			foreach ( $property_taxonomies as $single_tax ) {
				$options = [];
				$terms   = get_terms( $single_tax->name );

				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
					foreach ( $terms as $term ) {
						$options[ $term->slug ] = $term->name;
					}
				}

				$this->add_control(
					$single_tax->name,
					[
						'label'       => $single_tax->label,
						'type'        => \Elementor\Controls_Manager::SELECT2,
						'multiple'    => true,
						'label_block' => true,
						'options'     => $options,
					]
				);
			}
		}

		$this->add_control(
			'orderby',
			[
				'label'   => esc_html__( 'Order By', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'date'       => esc_html__( 'Date', 'realhomes-elementor-addon' ),
					'price'      => esc_html__( 'Price', 'realhomes-elementor-addon' ),
					'title'      => esc_html__( 'Title', 'realhomes-elementor-addon' ),
					'menu_order' => esc_html__( 'Menu Order', 'realhomes-elementor-addon' ),
					'rand'       => esc_html__( 'Random', 'realhomes-elementor-addon' ),
				],
				'default' => 'date',
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => esc_html__( 'Order', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'asc'  => esc_html__( 'Ascending', 'realhomes-elementor-addon' ),
					'desc' => esc_html__( 'Descending', 'realhomes-elementor-addon' ),
				],
				'default' => 'desc',
			]
		);

		$this->add_control(
			'show_only_featured',
			[
				'label'        => esc_html__( 'Show Only Featured Properties', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'skip_sticky_properties',
			[
				'label'        => esc_html__( 'Skip Sticky Properties', 'realhomes-elementor-addon' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'realhomes-elementor-addon' ),
				'label_off'    => esc_html__( 'No', 'realhomes-elementor-addon' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'offset',
			[
				'label'   => esc_html__( 'Offset or Skip From Start', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'default' => '0',
			]
		);


		$this->end_controls_section();
		$this->start_controls_section(
			'ere_google_map_options',
			[
				'label' => esc_html__( 'Google Map Options', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'map_styles',
			[
				'label'   => esc_html__( 'Map Styles', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'roadmap'   => esc_html__( 'RoadMap', 'realhomes-elementor-addon' ),
					'satellite' => esc_html__( 'Satellite', 'realhomes-elementor-addon' ),
					'hybrid'    => esc_html__( 'Hybrid', 'realhomes-elementor-addon' ),
					'terrain'   => esc_html__( 'Terrain', 'realhomes-elementor-addon' ),
				],
				'default' => 'roadmap',
			]
		);


		$this->add_control(
			'cta_map_style_json',
			[
				'label'   => esc_html__( 'Google Maps Styles JSON (optional)', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 10,
				'description'  => wp_kses( __( 'You can create Google Maps styles JSON using <a href="https://mapstyle.withgoogle.com" target="_blank">Google Styling Wizard</a> or <a href="https://snazzymaps.com/" target="_blank">Snazzy Maps</a>', 'realhomes-elementor-addon' ), $allowed_html ),

			]
		);


		$this->end_controls_section();
		$this->start_controls_section(
			'ere_property_typo_section',
			[
				'label' => esc_html__( 'Typography', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_heading_typography',
				'label'    => esc_html__( 'Popup Title', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .prop-title a',
			]
		);


		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'property_price_typography',
				'label'    => esc_html__( 'Popup Price', 'realhomes-elementor-addon' ),
				'scheme'   => \Elementor\Core\Schemes\Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .rhea-popup-price',
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'ere_property_style_section',
			[
				'label' => esc_html__( 'Spacings And Sizes', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_responsive_control(
			'ere_property_map_height',
			[
				'label'           => esc_html__( 'Map Height (px)', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 1000,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 600,
					'unit' => 'px',
				],
				'selectors'       => [
					'{{WRAPPER}} .rhea-listing-google-map' => 'height: {{SIZE}}{{UNIT}};',

				],
			]
		);

		$this->add_responsive_control(
			'ere_property_popup_title_Padding',
			[
				'label'      => esc_html__( 'Popup Title Padding (px)', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .prop-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_property_popup_price_Padding',
			[
				'label'      => esc_html__( 'Popup Price Padding (px)', 'realhomes-elementor-addon' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors'  => [
					'{{WRAPPER}} .rhea-popup-price' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'ere_property_popup_border_size',
			[
				'label'           => esc_html__( 'Popup Border Bottom Size', 'realhomes-elementor-addon' ),
				'type'            => \Elementor\Controls_Manager::SLIDER,
				'range'           => [
					'px' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'devices'         => [ 'desktop', 'tablet', 'mobile' ],
				'selectors'       => [
					'{{WRAPPER}} .rhea-map-info-window' => 'border-bottom-width: {{SIZE}}{{UNIT}};',

				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'ere_property_colors_section',
			[
				'label' => esc_html__( 'Colors', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'rhea_popup_content_bg_color',
			[
				'label'     => esc_html__( 'Popup Background Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-map-info-window' => 'background: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_popup_title_color',
			[
				'label'     => esc_html__( 'Popup Title Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .prop-title  a' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'rhea_popup_title_hover_color',
			[
				'label'     => esc_html__( 'Popup Title Hover Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .prop-title a:hover' => 'color: {{VALUE}}',
				],
			]
		);
		$this->add_control(
			'rhea_popup_price_color',
			[
				'label'     => esc_html__( 'Popup Price Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-popup-price' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'rhea_popup_wrapper_border_color',
			[
				'label'     => esc_html__( 'Popup Border and Tip Color', 'realhomes-elementor-addon' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => [
					'{{WRAPPER}} .rhea-map-info-window' => 'border-bottom-color: {{VALUE}}',
					'{{WRAPPER}} .arrow-down'             => 'border-top-color: {{VALUE}}',
				],
			]
		);

		$this->end_controls_section();
	}


	public function inject_content() {
		$settings = $this->get_settings_for_display();


		$map_stuff['modernHome'] = true;
		$properties_map_options['type'] = $settings['map_styles'];

		// Remove sticky properties filter.
		if ( $settings['skip_sticky_properties'] == 'yes' ) {
			remove_filter( 'the_posts', 'inspiry_make_properties_stick_at_top', 10 );
		}

		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) { // if is static front page
			$paged = get_query_var( 'page' );
		} else {
			$paged = 1;
		}

		if ( $settings['offset'] ) {
			$offset = $settings['offset'] + ( $paged - 1 ) * $settings['posts_per_page'];
		} else {
			$offset = '';
		}

		// Basic Query
		$properties_args = array(
			'post_type'      => 'property',
			'posts_per_page' => $settings['posts_per_page'],
			'order'          => $settings['order'],
			'offset'         => $offset,
			'post_status'    => 'publish',
			'paged'          => $paged,
		);

// Sorting
		if ( 'price' === $settings['orderby'] ) {
			$properties_args['orderby']  = 'meta_value_num';
			$properties_args['meta_key'] = 'REAL_HOMES_property_price';
		} else {
			// for date, title, menu_order and rand
			$properties_args['orderby'] = $settings['orderby'];
		}

		// Filter based on custom taxonomies
		$property_taxonomies = get_object_taxonomies( 'property', 'objects' );
		if ( ! empty( $property_taxonomies ) && ! is_wp_error( $property_taxonomies ) ) {
			foreach ( $property_taxonomies as $single_tax ) {
				$setting_key = $single_tax->name;
				if ( ! empty( $settings[ $setting_key ] ) ) {
					$properties_args['tax_query'][] = [
						'taxonomy' => $setting_key,
						'field'    => 'slug',
						'terms'    => $settings[ $setting_key ],
					];
				}
			}

			if ( isset( $properties_args['tax_query'] ) && count( $properties_args['tax_query'] ) > 1 ) {
				$properties_args['tax_query']['relation'] = 'AND';
			}
		}


		$meta_query = array();
		if ( 'yes' === $settings['show_only_featured'] ) {
			$meta_query[] = array(
				'key'     => 'REAL_HOMES_featured',
				'value'   => 1,
				'compare' => '=',
				'type'    => 'NUMERIC',
			);

			$properties_args['meta_query'] = $meta_query;
		}


		$map_properties_query = new WP_Query( apply_filters( 'rhea_google_maps_properties_widget', $properties_args ) );

		$current_section_id = array();

		$current_section_id['section_id'] = $this->get_id();

		$properties_map_data = array();


		if ( $map_properties_query->have_posts() ) {
			while ( $map_properties_query->have_posts() ) {
				$map_properties_query->the_post();

				$current_property_data = array();
				$current_property_data[ 'title' ] = get_the_title();

				if ( function_exists('ere_get_property_price') ) {
					$current_property_data[ 'price' ] = ere_get_property_price();
				} else {
					$current_property_data[ 'price' ] = null;
				}

				$current_property_data[ 'url' ] = get_permalink();

				// property location
				$property_location = get_post_meta( get_the_ID(), 'REAL_HOMES_property_location', true );
				if ( ! empty( $property_location ) ) {
					$lat_lng = explode( ',', $property_location );
					$current_property_data[ 'lat' ] = $lat_lng[ 0 ];
					$current_property_data[ 'lng' ] = $lat_lng[ 1 ];
				}

				// property thumbnail
				if ( has_post_thumbnail() ) {
					$image_id         = get_post_thumbnail_id();
					$image_attributes = wp_get_attachment_image_src( $image_id, 'property-thumb-image' );
					if ( ! empty( $image_attributes[ 0 ] ) ) {
						$current_property_data[ 'thumb' ] = $image_attributes[ 0 ];
					}
				}

				// Property map icon based on Property Type
				$type_terms = get_the_terms( get_the_ID(), 'property-type' );
				if ( $type_terms && ! is_wp_error( $type_terms ) ) {
					foreach ( $type_terms as $type_term ) {
						$icon_id = get_term_meta( $type_term->term_id, 'inspiry_property_type_icon', true );
						if ( ! empty ( $icon_id ) ) {
							$icon_url = wp_get_attachment_url( $icon_id );
							if ( $icon_url ) {
								$current_property_data[ 'icon' ] = esc_url( $icon_url );

								// Retina icon
								$retina_icon_id = get_term_meta( $type_term->term_id, 'inspiry_property_type_icon_retina', true );
								if ( ! empty ( $retina_icon_id ) ) {
									$retina_icon_url = wp_get_attachment_url( $retina_icon_id );
									if ( $retina_icon_url ) {
										$current_property_data[ 'retinaIcon' ] = esc_url( $retina_icon_url );
									}
								}
								break;
							}
						}
					}
				}

				// Set default icons if above code fails to sets any
				if ( ! isset( $current_property_data[ 'icon' ] ) ) {
					$current_property_data[ 'icon' ]       = INSPIRY_DIR_URI . '/images/map/single-family-home-map-icon.png';           // default icon
					$current_property_data[ 'retinaIcon' ] = INSPIRY_DIR_URI . '/images/map/single-family-home-map-icon@2x.png';  // default retina icon
				}

				$styles_json = $settings['cta_map_style_json'];
				if ( ! empty( $styles_json ) ) {
					$properties_map_options['styles'] = stripslashes( $styles_json );
				}

				$properties_map_data[] = $current_property_data;

			}
			wp_reset_postdata();
			$map_stuff['closeIcon'] = INSPIRY_DIR_URI . '/images/map/close.png';
			$map_stuff['clusterIcon'] = INSPIRY_DIR_URI . '/images/map/cluster-icon.png';
			$map_stuff['infoBoxPlaceholder'] = get_inspiry_image_placeholder_url( 'property-thumb-image' );
			?>

            <div id="rhea-<?php echo $this->get_id(); ?>" class="rhea-listing-google-map"></div>

            <script type="application/javascript">
                jQuery(document).bind("ready", function () {
                    rheaLoadGoogleMap("<?php echo 'rhea-' . $this->get_id(); ?>", <?php echo json_encode( $properties_map_data );?> , <?php echo json_encode($properties_map_options);?> , <?php echo json_encode($map_stuff);?> );
                });
            </script>

			<?php


			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				?>
                <script type="application/javascript">
                    rheaLoadGoogleMap("<?php echo 'rhea-' . $this->get_id(); ?>", <?php echo json_encode( $properties_map_data );?> , <?php echo json_encode($properties_map_options);?> , <?php echo json_encode($map_stuff);?> );
                </script>
				<?php
			} else {
				?>
                <script type="application/javascript">
                    jQuery(document).bind("ready", function () {
                        rheaLoadGoogleMap("<?php echo 'rhea-' . $this->get_id(); ?>", <?php echo json_encode( $properties_map_data );?> , <?php echo json_encode($properties_map_options);?> , <?php echo json_encode($map_stuff);?> );
                    });
                </script>
				<?php
			}


		}
	}

	public function render() {
		?>
        <div class="rhea_wrapper_properties_map">

            <div class="rhea-map-head">
		        <?php
		        $this->inject_content();
		        ?>
            </div>

        </div>
		<?php
	}


}