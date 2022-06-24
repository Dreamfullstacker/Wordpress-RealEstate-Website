<?php
/**
 * Properties search results for sidebar templates.
 *
 * @package    realhomes
 * @subpackage classic
 */

?>

<div class="main fix-margins">

	<!-- listing layout -->
	<section class="listing-layout property-grid">

		<div class="list-container clearfix">

			<?php
			/* List of Properties on Homepage */
			$number_of_properties = intval( get_option( 'theme_properties_on_search' ) );
			if ( ! $number_of_properties ) {
				$number_of_properties = 6;
			}

			$paged = 1;
			if ( get_query_var( 'paged' ) ) {
				$paged = get_query_var( 'paged' );
			} elseif ( get_query_var( 'page' ) ) { // if is static front page
				$paged = get_query_var( 'page' );
			}

			$search_args = array(
				'post_type'      => 'property',
				'posts_per_page' => $number_of_properties,
				'paged'          => $paged,
			);

			// Apply Search Filter.
			$search_args = apply_filters( 'real_homes_search_parameters', $search_args );

			$search_args = sort_properties( $search_args );

			$search_query = new WP_Query( $search_args );

			?>

			<div class="search-header inner-wrapper clearfix">
				<div class="properties-count">
					<span><?php printf( _n( '<strong>%s</strong> Result', '<strong>%s</strong> Results', $search_query->found_posts, 'framework' ), number_format( $search_query->found_posts ) ); ?></span>
				</div>
				<div class="multi-control-wrap">
				<?php
					// Sort Controls.
					get_template_part( 'assets/classic/partials/properties/save-alert-button', '', array( 'search_args' => $search_args ) );
					get_template_part( 'assets/classic/partials/properties/sort-controls' );
				?>
				</div>
				<?php
				$get_content_position = get_post_meta( get_the_ID(), 'REAL_HOMES_content_area_above_footer', true );

				if ( $get_content_position !== '1' ) {
					if ( have_posts() ) {
						while ( have_posts() ) {
							the_post();
							?>
                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<?php the_content(); ?>
                            </article>
							<?php
						}
					}
				}

				?>
			</div>

			<?php

			if ( $search_query->have_posts() ) :
				$post_count = 0;
				while ( $search_query->have_posts() ) :
					$search_query->the_post();

					/* Display Property for Search Page */
					get_template_part( 'assets/classic/partials/properties/grid-card' );

					$post_count++;
					if ( 0 === ( $post_count % 3 ) ) {
						echo '<div class="clearfix"></div>';
					}

				endwhile;
				wp_reset_postdata();
			else :
				?>
                <div class="alert-wrapper">
					<?php
					$inspiry_search_template_no_result_text = get_option( 'inspiry_search_template_no_result_text' );

					if ( ! empty( $inspiry_search_template_no_result_text ) ) {
						?>
                        <h4><?php echo inspiry_kses( $inspiry_search_template_no_result_text ); ?></h4>
						<?php
					} else {
						?>
                        <h4><?php esc_html_e( 'No Property Found!', 'framework' ); ?></h4>
						<?php
					}
					?>
                </div>
				<?php
			endif;
			?>
		</div>

		<?php theme_pagination( $search_query->max_num_pages ); ?>

	</section><!-- end of listing layout -->

</div>
