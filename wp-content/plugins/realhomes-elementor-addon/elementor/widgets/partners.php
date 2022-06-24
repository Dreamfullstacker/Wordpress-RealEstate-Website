<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class RHEA_Partners_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'ere-partners-widget';
	}

	public function get_title() {
		return esc_html__( 'Partners', 'realhomes-elementor-addon' );
	}

	public function get_icon() {
		return 'eicon-carousel';
	}

	public function get_categories() {
		return [ 'real-homes' ];
	}

	protected function register_controls() {

		$grid_size_array = wp_get_additional_image_sizes();

		$prop_partner_size_array = array();
		foreach ( $grid_size_array as $key => $value ) {
			$str_rpl_key = ucwords( str_replace( "-", " ", $key ) );

			$prop_partner_size_array[ $key ] = $str_rpl_key . ' - ' . $value['width'] . 'x' . $value['height'];
		}

		unset( $prop_partner_size_array['property-detail-slider-thumb'] );
		unset( $prop_partner_size_array['post-thumbnail'] );
		unset( $prop_partner_size_array['agent-image'] );
		unset( $prop_partner_size_array['gallery-two-column-image'] );
		unset( $prop_partner_size_array['post-featured-image'] );




		$this->start_controls_section(
			'ere_partners_section',
			[
				'label' => esc_html__( 'Partners', 'realhomes-elementor-addon' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'ere_partners_grid_thumb_sizes',
			[
				'label'   => esc_html__( 'Thumbnail Size', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'property-thumb-image',
				'options' => $prop_partner_size_array
			]
		);

		$this->add_responsive_control(
			'ere_partners_spacing',
			[
				'label' => esc_html__( 'Spacing Between Icons (px)', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 10,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .rh_section__partners_elementor .rh_partner' => 'padding-left: {{SIZE}}{{UNIT}}; padding-right: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'ere_partners_bottom_spacing',
			[
				'label' => esc_html__( 'Icon Bottom Margin (px)', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
					],
				],
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => 10,
					'unit' => 'px',
				],
				'selectors' => [
					'{{WRAPPER}} .rh_section__partners_elementor .rh_partner' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_responsive_control(
			'ere_partners_sizes',
			[
				'label' => esc_html__( 'Icon Size (%)', 'realhomes-elementor-addon' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
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
				'devices' => [ 'desktop', 'tablet', 'mobile' ],
				'desktop_default' => [
					'size' => '16.666',
					'unit' => '%',
				],
				'selectors' => [
					'{{WRAPPER}} .rh_section__partners_elementor .rh_partner' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);


		$this->add_control(
			'number_of_partners',
			[
				'label'   => esc_html__( 'Number of Partners', 'realhomes-elementor-addon' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 1,
				'max'     => 100,
				'step'    => 1,
				'default' => 6,
			]
		);

		$this->end_controls_section();

	}

	protected function render() {

		$settings = $this->get_settings_for_display();

		if ( ! $settings[ 'number_of_partners' ] ) {
			$settings[ 'number_of_partners' ] = 20;
		}

		$partners_args = array(
			'post_type'      => 'partners',
			'posts_per_page' => $settings[ 'number_of_partners' ],
		);

		$ere_partners_grid_thumb_sizes = $settings['ere_partners_grid_thumb_sizes'];

		$partners_query = new WP_Query( apply_filters( 'rhea_modern_partners_widget', $partners_args ) );

		if ( $partners_query->have_posts() ) {
			?>
			<section class="rh_elementor_widget rh_wrapper_partners_elementor">

                <div class="rh_section__partners_elementor">
					<?php
					while ( $partners_query->have_posts() ) {

						$partners_query->the_post();

						$partner_url = get_post_meta( get_the_ID(), 'REAL_HOMES_partner_url', true );
						?>
                        <div <?php post_class( 'rh_partner' ); ?>>

							<?php if ( $partner_url ) { ?>
                            <a target="_blank" href="<?php echo esc_url( $partner_url ); ?>"
                               title="<?php the_title(); ?>">
								<?php }

								if ( has_post_thumbnail( get_the_ID() ) ) {
									the_post_thumbnail( $ere_partners_grid_thumb_sizes );
								} else {
									inspiry_image_placeholder( $ere_partners_grid_thumb_sizes );
								}

								if ( $partner_url ) { ?>
                            </a>
						    <?php } ?>

                        </div>
						<?php
					}

					wp_reset_postdata();
					?>
                </div>
			</section>
			<?php
		}

	}

}