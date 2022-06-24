<?php
/**
 * Single Agency
 *
 * Template for single agency.
 *
 * @since    3.5.0
 * @package  realhomes/modern
 */

get_header();

$header_variation = get_option( 'inspiry_agencies_header_variation', 'none' );

if ( ! empty( $header_variation ) && ( 'banner' === $header_variation ) ) :
	get_template_part( 'assets/modern/partials/banner/image' );
elseif ( empty( $header_variation ) || ( 'none' === $header_variation ) ) :
	get_template_part( 'assets/modern/partials/banner/header' );
endif;

if ( inspiry_show_header_search_form() ) {
	get_template_part( 'assets/modern/partials/properties/search/advance' );
}
if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
	?>
    <section class="rh_section rh_section--flex rh_wrap--padding rh_wrap--topPadding">
		<?php
			// Display any contents after the page banner and before the contents.
			do_action( 'inspiry_before_page_contents' );
		?>
		<div class="rh_page rh_page__agents rh_page__main">
			<?php if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) : ?>
                <div class="rh_page__head">
                    <h2 class="rh_page__title">
                        <span class="sub"><?php esc_html_e( 'Agency', 'framework' ); ?></span>
                        <span class="title"><?php esc_html_e( 'Profile', 'framework' ); ?></span>
                    </h2>
                </div>
			<?php endif;

			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					get_template_part( 'assets/modern/partials/agency/single/card' );
				endwhile;
			endif;

			$number_of_properties = intval( get_option( 'inspiry_number_of_agents_agency', 6 ) );

			$paged = 1;
			if ( get_query_var( 'paged' ) ) {
				$paged = get_query_var( 'paged' );
			}

			$agency_agents_args = array(
				'post_type'      => 'agent',
				'posts_per_page' => $number_of_properties,
				'meta_query'     => array(
					array(
						'key'     => 'REAL_HOMES_agency',
						'value'   => get_the_ID(),
						'compare' => '=',
					),
				),
				'paged'          => $paged,
			);

			$agency_agents_query = new WP_Query( apply_filters( 'realhomes_agency_agents', $agency_agents_args ) );

			if ( $agency_agents_query->have_posts() ) {

				?>
                <div class="rh_page__head rh_page--single_agent">
                    <h2 class="rh_page__title">
                        <span class="sub"><?php esc_html_e( 'Our Agents', 'framework' ); ?></span>
                    </h2>
                </div>

                <div class="rh_page__section">
					<?php
					while ( $agency_agents_query->have_posts() ) :
						$agency_agents_query->the_post();
						get_template_part( 'assets/modern/partials/agent/card' );
					endwhile;
					wp_reset_postdata();
					?>
                </div>
				<?php
				inspiry_theme_pagination( $agency_agents_query->max_num_pages );
			}
			?>
        </div>

		<?php if ( is_active_sidebar( 'agency-sidebar' ) ) : ?>
            <div class="rh_page rh_page__sidebar">
				<?php get_sidebar( 'agency' ); ?>
            </div>
		<?php endif; ?>

    </section>
	<?php
}
get_footer();
