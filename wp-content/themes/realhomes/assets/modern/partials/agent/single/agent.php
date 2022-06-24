<?php
/**
 * Single Agent
 *
 * Template for single agent.
 *
 * @since    3.0.0
 * @package  realhomes/modern
 */

get_header();

$header_variation = get_option( 'inspiry_agents_header_variation', 'none' );

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
						<span class="sub"><?php esc_html_e( 'Agent', 'framework' ); ?></span>
						<span class="title"><?php esc_html_e( 'Profile', 'framework' ); ?></span>
					</h2>
				</div>
			<?php endif; ?>
			<?php
			if ( have_posts() ) :
				while ( have_posts() ) :
					the_post();
					get_template_part( 'assets/modern/partials/agent/single/card' );
				endwhile;
			endif;

			if ( 'show' === get_option( 'inspiry_agent_single_properties', 'show' ) ) :
				?>
                <div class="rh_page__head rh_page--single_agent">
                    <h2 class="rh_page__title">
                        <span class="sub"><?php esc_html_e( 'My Listings', 'framework' ); ?></span>
                    </h2>
                </div>
                <div class="rh_page__section">
					<?php
					global $paged;

					$number_of_properties = intval( get_option( 'theme_number_of_properties_agent' ) );
					if ( ! $number_of_properties ) {
						$number_of_properties = 6;
					}

					$agent_properties_args = array(
						'post_type'      => 'property',
						'posts_per_page' => $number_of_properties,
						'meta_query'     => array(
							array(
								'key'     => 'REAL_HOMES_agents',
								'value'   => get_the_ID(),
								'compare' => '=',
							),
						),
						'paged' => $paged,
					);

					$agent_properties_listing_query = new WP_Query( apply_filters( 'inspiry_agent_single_properties', $agent_properties_args ) );

					if ( $agent_properties_listing_query->have_posts() ) :
						while ( $agent_properties_listing_query->have_posts() ) :
							$agent_properties_listing_query->the_post();

							/* Display Property for Listing */
							get_template_part( 'assets/modern/partials/properties/list-card' );

						endwhile;
						wp_reset_postdata();
					else :
						?>
                        <div class="rh_alert-wrapper">
                            <h4 class="no-results"><?php esc_html_e( 'No Properties Found', 'framework' ) ?></h4>
                        </div>
					<?php
					endif;
					?>
                </div><!-- /.rh_page__section -->
				<?php
				inspiry_theme_pagination( $agent_properties_listing_query->max_num_pages );
			endif;
			?>
		</div><!-- /.rh_page rh_page__main -->

        <?php if ( is_active_sidebar( 'agent-sidebar' ) ) : ?>
            <div class="rh_page rh_page__sidebar">
				<?php get_sidebar( 'agent' ); ?>
            </div><!-- /.rh_page rh_page__sidebar -->
		<?php endif; ?>
	</section><!-- /.rh_section rh_wrap rh_wrap--padding -->
<?php
}
get_footer();
