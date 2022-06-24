<?php
/**
 * Half Map with Properties List
 *
 * @package    realhomes
 * @subpackage modern
 */

?>

<section class="rh_section rh_section--flex rh_section__map_listing">

	<div class="rh_page rh_page__listing_map">
		<?php get_template_part( 'assets/modern/partials/properties/map' ); ?>
	</div>
	<!-- /.rh_page rh_page__listing_map -->

	<div class="rh_page rh_page__map_properties">
		<?php
		$get_content_position = get_post_meta( get_the_ID(), 'REAL_HOMES_content_area_above_footer',true );

		if ( $get_content_position !== '1' ) {
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					?>
                    <div class="rh_content <?php if ( get_the_content() ) {
						echo esc_attr( 'rh_page__content' );
					} ?>">
						<?php the_content(); ?>
                    </div>
                    <!-- /.rh_content -->
					<?php
				}
			}
		}
		?>
		<div class="rh_page__head">


			<h2 class="rh_page__title">
				<?php
				// Page Title.
				$page_title = get_post_meta( get_the_ID(), 'REAL_HOMES_banner_title', true );
				if ( empty( $page_title ) ) {
					$page_title = get_the_title( get_the_ID() );
				}
				echo inspiry_get_exploded_heading( $page_title );
				?>
			</h2>
			<!-- /.rh_page__title -->

			<div class="rh_page__controls">
				<?php get_template_part( 'assets/modern/partials/properties/sort-controls' ); ?>
			</div>
			<!-- /.rh_page__controls -->

		</div>
		<!-- /.rh_page__head -->

		<div class="rh_page__listing">

			<?php
			$number_of_properties = intval( get_option( 'theme_number_of_properties' ) );
			if ( ! $number_of_properties ) {
				$number_of_properties = 6;
			}

			$paged = 1;
			if ( get_query_var( 'paged' ) ) {
				$paged = get_query_var( 'paged' );
			} elseif ( get_query_var( 'page' ) ) { // if is static front page
				$paged = get_query_var( 'page' );
			}

			$property_listing_args = array(
				'post_type'      => 'property',
				'posts_per_page' => $number_of_properties,
				'paged'          => $paged,
			);

			$theme_listing_module = get_option( 'theme_listing_module' );

			if ( $theme_listing_module === 'properties-map' ) {

				$property_listing_args['meta_query'] = array(
				    array(
				        'key'     => 'REAL_HOMES_property_address',
				        'compare' => 'EXISTS',
				    ),
				);

			}

			// Apply properties filter.
			$property_listing_args = apply_filters( 'inspiry_properties_filter', $property_listing_args );

			$property_listing_args = sort_properties( $property_listing_args );

			$property_listing_query = new WP_Query( $property_listing_args );

			if ( $property_listing_query->have_posts() ) :
				while ( $property_listing_query->have_posts() ) :
					$property_listing_query->the_post();
					get_template_part( 'assets/modern/partials/properties/half-map-card' );
				endwhile;
				wp_reset_postdata();
			else :
				?>
				<div class="rh_alert-wrapper">
					<h4><?php esc_html_e( 'No Results Found!', 'framework' ); ?></h4>
				</div>
				<?php
			endif;
			?>
		</div>
		<!-- /.rh_page__listing -->

		<?php inspiry_theme_pagination( $property_listing_query->max_num_pages ); ?>

	</div>
	<!-- /.rh_page rh_page__map_properties -->

</section>
<!-- /.rh_section rh_wrap rh_wrap--padding -->

<?php

if ( '1' === $get_content_position ) {
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			?>
            <div class="rh_content rh_content_above_footer <?php if ( get_the_content() ) {
				echo esc_attr( 'rh_page__content' );
			} ?>">
				<?php the_content(); ?>
            </div><!-- /.rh_content -->
			<?php
		}
	}
}
?>
