<?php
/**
 * Properties search with half map.
 *
 * @package    realhomes
 * @subpackage classic
 */

get_header();
echo '</div>'; // close inspiry_half_map_header_wrapper in header.php
?>
<div class="half-map-layout">
    <div class="half-map-layout-map">
		<?php get_template_part( 'assets/classic/partials/banners/map' ); ?>
    </div><!-- /.half-map-layout-map -->

    <div class="half-map-layout-properties">
        <div class="container contents listing-grid-layout listing-grid-full-width-layout">
			<?php
				// Display any contents after the page banner and before the contents.
				do_action( 'inspiry_before_page_contents' );
			?>
            <div class="row">
                <div class="span12 main-wrap">
	                <?php get_template_part( 'assets/classic/partials/properties/search/form-wrapper' ); ?>
                    <div class="main">
                        <section class="listing-layout">
                            <div class="list-container inner-wrapper clearfix">
	                            <?php
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

                                if ( inspiry_is_search_page_map_visible() ) {

                                    $search_args['meta_query'] = array(
                                        array(
                                            'key'     => 'REAL_HOMES_property_address',
                                            'compare' => 'EXISTS',
                                        ),
                                    );

                                }

	                            /* Apply Search Filter */
	                            $search_args = apply_filters( 'real_homes_search_parameters', $search_args );

	                            /* Sort Properties */
	                            $search_args = sort_properties( $search_args );

	                            $search_query = new WP_Query( $search_args );

								?>
                                    <div class="properties-count">
                                    <span><strong><?php echo esc_html( $search_query->found_posts ); ?></strong>&nbsp;<?php
	                                    if ( 1 < $search_query->found_posts ) {
		                                    esc_html_e( 'Results', 'framework' );
	                                    } else {
		                                    esc_html_e( 'Result', 'framework' );
	                                    }
	                                    ?>
                                    </span>
                                    </div>
									<div class="multi-control-wrap">
									<?php
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
				                            $rh_content_is_empty = '';
				                            if ( ! get_the_content() ) {
					                            $rh_content_is_empty = 'rh_content_is_empty';
				                            }
				                            ?>
                                            <article id="post-<?php the_ID(); ?>" <?php post_class( $rh_content_is_empty ); ?>>
					                            <?php the_content(); ?>
                                            </article>
				                            <?php
			                            }
		                            }
	                            }

								if ( $search_query->have_posts() ) :
									while ( $search_query->have_posts() ) :
										$search_query->the_post();
										get_template_part( 'assets/classic/partials/properties/list-card' );
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
                        </section>
                    </div><!-- End Main Content -->
                </div> <!-- End span12 -->
            </div><!-- End contents row -->
        </div><!-- /.listing-grid-full-width-layout -->
    </div><!-- /.half-map-layout-properties -->
</div><!-- /.half-map-layout -->

<?php
if ( '1' === $get_content_position ) {
	if ( have_posts() ) {
		while ( have_posts() ) {
			the_post();
			?>
            <article class="rh-listing-content rh_content_above_footer"><?php the_content(); ?></article>
			<?php
		}
	}
}
?>

<?php get_footer(); ?>
