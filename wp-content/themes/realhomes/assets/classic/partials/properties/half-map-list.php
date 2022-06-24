<?php
/**
 * Half Map with Properties List
 *
 * Displays properties in list layout
 *
 * @package    realhomes
 * @subpackage classic
 */

global $page;
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

                    <!-- Main Content -->
                    <div class="main">
                        <section class="listing-layout">
							<?php
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
							?>
                            <div class="list-container inner-wrapper clearfix">
                                <?php
                                if ( 'hide' !== $title_display ) {
                                    $theme_listing_module = get_option( 'theme_listing_module' );
                                    if( 'properties-map' == $theme_listing_module ) : ?>
                                        <h1 class="page-title"><?php the_title(); ?></h1>
                                    <?php else : ?>
                                        <h3 class="page-title"><?php the_title(); ?></h3>
                                        <?php
                                    endif;
                                }
                                ?>
								<?php get_template_part( 'assets/classic/partials/properties/sort-controls' ); ?>

								<?php

								$get_content_position = get_post_meta( get_the_ID(), 'REAL_HOMES_content_area_above_footer', true );

								if ( $get_content_position !== '1' ) {
									if ( have_posts() ) {
										while ( have_posts() ) {
											the_post();
											?>
                                            <article class="rh-listing-content"><?php the_content(); ?></article>
											<?php
										}
									}
								}

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

								if ( 'properties-map' == $theme_listing_module ) {

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

										get_template_part( 'assets/classic/partials/properties/list-card' );

									endwhile;
									wp_reset_postdata();
								else :
									?>
                                    <div class="alert-wrapper">
                                        <h4><?php esc_html_e( 'No Results Found!', 'framework' ); ?></h4>
                                    </div>
									<?php
								endif;
								?>
                            </div>

							<?php theme_pagination( $property_listing_query->max_num_pages ); ?>

                        </section>
                    </div><!-- End Main Content -->
                </div> <!-- End span12 -->
            </div><!-- End contents row -->
        </div>
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