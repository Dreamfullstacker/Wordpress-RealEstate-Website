<?php
/**
 * Properties for Homepage.
 *
 * @package    realhomes
 * @subpackage classic
 */

?>

<div class="container">

    <div class="row">

        <div class="span12">

            <div class="main">

                <section id="home-properties-section" class="property-items <?php if ( 'true' == get_post_meta( get_the_ID(), 'theme_ajax_pagination_home', true ) ) {
					echo 'ajax-pagination';
				} ?>">

					<?php get_template_part( 'assets/classic/partials/home/sections/home-slogan' ); // Homepage Slogan?>

                    <div id="home-properties-section-wrapper">

                        <div id="home-properties-section-inner">

                            <div id="home-properties-wrapper">

                                <div id="home-properties" class="property-items-container clearfix">
									<?php

									// Skip sticky properties.
									if ( function_exists( 'ere_skip_home_sticky_properties' ) ) {
										ere_skip_home_sticky_properties();
									}


									/* List of Properties on Homepage */
									$number_of_properties = intval( get_post_meta( get_the_ID(), 'theme_properties_on_home', true ) );
									if ( ! $number_of_properties ) {
										$number_of_properties = 4;
									}

									$paged = 1;
									if ( get_query_var( 'paged' ) ) {
										$paged = get_query_var( 'paged' );
									} elseif ( get_query_var( 'page' ) ) { // if is static front page
										$paged = get_query_var( 'page' );
									}

									$home_args = array(
										'post_type'      => 'property',
										'posts_per_page' => $number_of_properties,
										'paged'          => $paged
									);

									/* Modify home query arguments based on theme options - related filters resides in functions.php */
									$home_args = apply_filters( 'real_homes_homepage_properties', $home_args );

									/* Sort Properties Based on Theme Option Selection */
									$sorty_by = get_post_meta( get_the_ID(), 'theme_sorty_by', true );
									if ( ! empty( $sorty_by ) ) {
										if ( $sorty_by == 'low-to-high' ) {
											$home_args['orderby']  = 'meta_value_num';
											$home_args['meta_key'] = 'REAL_HOMES_property_price';
											$home_args['order']    = 'ASC';
										} elseif ( $sorty_by == 'high-to-low' ) {
											$home_args['orderby']  = 'meta_value_num';
											$home_args['meta_key'] = 'REAL_HOMES_property_price';
											$home_args['order']    = 'DESC';
										} elseif ( $sorty_by == 'random' ) {
											$home_args['orderby'] = 'rand';
										}
									}


									$home_properties_query = new WP_Query( $home_args );

									/* Homepage Properties Loop */
									if ( $home_properties_query->have_posts() ) :

										$post_count = 0;

										while ( $home_properties_query->have_posts() ) :

											$home_properties_query->the_post();

											/* Display Property for Home Page */
											get_template_part( 'assets/classic/partials/home/property-card' );

											/* To output clearfix after every 2 properties */
											$post_count ++;
											if ( 0 == ( $post_count % 2 ) ) {
												echo '<div class="clearfix"></div>';
											}

										endwhile;

										wp_reset_postdata();

									else:
										?>
                                        <div class="alert-wrapper">
                                            <h4><?php esc_html_e( 'No Properties Found!', 'framework' ) ?></h4>
                                        </div>
									    <?php
									endif;
									?>

                                </div><!-- end of #home-properties -->

                            </div><!-- end of #home-properties-wrapper -->

                            <div class="svg-loader">
                                <img src="<?php echo INSPIRY_DIR_URI; ?>/images/loading-bars.svg" width="32" height="32" alt="<?php esc_html_e( 'Loading...', 'framework' ); ?>">
                            </div>

							<?php
							if ( 'true' === get_post_meta( get_the_ID(), 'theme_ajax_pagination_home' ,true ) ) {
								theme_ajax_pagination( $home_properties_query->max_num_pages, $home_properties_query );
							} else {
								theme_pagination( $home_properties_query->max_num_pages );
							}
							?>
                        </div><!-- end of #home-properties-section-inner -->

                    </div><!-- end of #home-properties-section-wrapper -->

					<?php wp_reset_postdata(); ?>

                </section>

            </div>
            <!-- /.main -->

        </div>
        <!-- /.span12 -->

    </div>
    <!-- /.row -->

</div>
<!-- /.container -->
