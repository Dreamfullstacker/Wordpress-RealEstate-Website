<?php
/**
 * Display properties in grid layout.
 *
 * @package realhomes
 * @subpackage classic
 */
?>
<!-- Content -->
<div class="container contents listing-grid-layout listing-grid-full-width-layout">
	<?php
		// Display any contents after the page banner and before the contents.
		do_action( 'inspiry_before_page_contents' );
	?>
	<div class="row">
		<div class="span12 main-wrap">
			<!-- Main Content -->
			<div class="main">
				<section class="listing-layout property-grid">
					<?php
					/*
					 * Page title.
					 */
					$title_display = get_post_meta( get_the_ID(), 'REAL_HOMES_page_title_display', true );
					if ( 'hide' !== $title_display ) {
						$theme_listing_module = get_option( 'theme_listing_module' );
					    if( 'properties-map' == $theme_listing_module ) : ?>
						    <h1 class="title-heading"><?php the_title(); ?></h1>
						<?php else : ?>
                            <h3 class="title-heading"><?php the_title(); ?></h3>
                        <?php
                        endif;
					}

					/*
					 * Grid or List View Buttons.
					 */
					get_template_part( 'assets/classic/partials/properties/view-buttons' );
					?>

					<div class="list-container inner-wrapper clearfix">
						<?php
						/*
						 * Sort controls.
						 */
						get_template_part( 'assets/classic/partials/properties/sort-controls' );

						/*
						 * Page contents.
						 */
						$get_content_position = get_post_meta( get_the_ID(), 'REAL_HOMES_content_area_above_footer', true );

						if ( $get_content_position !== '1' ) {
							if ( have_posts() ) {
								while ( have_posts() ) {
									the_post();
									?>
                                    <article <?php post_class(); ?>>
										<?php the_content(); ?>
                                    </article>
									<?php
								}
							}
						}

						/*
						 * Number of properties to display.
						 */
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

						$properties_query_args = array(
							'post_type'      => 'property',
							'posts_per_page' => $number_of_properties,
							'paged'          => $paged,
						);

						// Apply properties filter.
						$properties_query_args = apply_filters( 'inspiry_properties_filter', $properties_query_args );

						// Add sorting arguments in properties query.
						$properties_query_args = sort_properties( $properties_query_args );

						$properties_query = new WP_Query( $properties_query_args );

						if ( $properties_query->have_posts() ) : ?>
                            <div class="grid-inner-row">
                                <?php

                                $counter = 1;
                                while ( $properties_query->have_posts() ) :
                                    $properties_query->the_post();

                                    // properties grid card.
                                    get_template_part( 'assets/classic/partials/properties/grid-card' );

                                    if ( $counter % 2 == 0 ) {
                                        ?>
                                        <div class="clearfix rh-visible-xs"></div>
                                        <?php
                                    }

                                    if ( $counter % 3 == 0 ) {
                                        ?>
                                        <div class="clearfix rh-visible-sm rh-visible-md rh-visible-lg"></div>
                                        <?php
                                    }
                                    $counter ++;
                                endwhile;
                                wp_reset_postdata();
                                ?>
                            </div>
                            <?php
						else :
							?>
							<div class="alert-wrapper">
								<h4><?php esc_html_e( 'No Results Found!', 'framework' ); ?></h4>
							</div>
							<?php
						endif;
						?>
					</div>

					<?php theme_pagination( $properties_query->max_num_pages ); ?>

				</section>
			</div><!-- End Main Content -->

			<?php
			if ('1' === $get_content_position ) {
				if ( have_posts() ) {
					while ( have_posts() ) {
						the_post();
						?>
                        <article <?php post_class(); ?>>
							<?php the_content(); ?>
                        </article>
						<?php
					}
				}
			}
			?>

		</div> <!-- End span12 -->
	</div><!-- End contents row -->
</div><!-- End Content -->
