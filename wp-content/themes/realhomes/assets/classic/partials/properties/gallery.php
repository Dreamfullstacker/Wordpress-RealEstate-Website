<?php
/**
 * Properties Gallery
 *
 * @package    realhomes
 * @subpackage classic
 */

get_header();

// Page Head.
get_template_part( 'assets/classic/partials/banners/gallery' ); ?>

<!-- Content -->
<div class="container contents listing-grid-layout">
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
						?>
						<h3 class="title-heading"><?php the_title(); ?></h3>
						<?php
					}
					?>

					<!-- Gallery Filter -->
					<div id="filter-by" class="clearfix">
						<a href="#" data-filter="gallery-item" class="active"><?php esc_html_e( 'All', 'framework' ); ?></a><?php
						if ( class_exists( 'ERE_Data' ) ) {
							$all_statuses = ERE_Data::get_statuses_slug_name();
							if ( ! empty( $all_statuses ) ) {
								foreach ( $all_statuses as $term_slug => $term_name ) {
									echo '<a href="' . get_term_link( $term_slug, 'property-status' ) . '" data-filter="' . $term_slug . '" title="' . sprintf( esc_html__( 'View all Properties having %s status', 'framework' ), $term_name ) . '">' . $term_name . '</a>';
								}
							}
						}
						?>
					</div>

					<!-- Gallery Container -->
					<div id="gallery-container" class="inner-wrapper">
						<?php
						$inspiry_gallery_properties_sorting = get_option( 'inspiry_gallery_properties_sorting', 'hide' );
						if ( 'show' === $inspiry_gallery_properties_sorting ) {
							get_template_part( 'assets/classic/partials/properties/sort-controls' );
						}

						$get_content_position = get_post_meta( get_the_ID(), 'REAL_HOMES_content_area_above_footer',true );

						if(  $get_content_position !== '1') {

							if ( have_posts() ) {
								while ( have_posts() ) {
									the_post();
									?>
                                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>><?php the_content(); ?></article>
								<?php
								}
							}
						}
						?>

						<div class="<?php global $gallery_name; echo esc_attr( $gallery_name ); ?> isotope clearfix">
							<?php
							$paged = 1;
							if ( get_query_var( 'paged' ) ) {
								$paged = get_query_var( 'paged' );
							} elseif ( get_query_var( 'page' ) ) { // if is static front page
								$paged = get_query_var( 'page' );
							}

							// Gallery Query.
							$gallery_listing_args = array(
								'post_type' => 'property',
								'paged'     => $paged,
							);

							/**
							 * Gallery Property Arguments Filter.
							 *
							 * @var array
							 */
							$gallery_listing_args = apply_filters( 'inspiry_gallery_properties_filter', $gallery_listing_args );

							if ( 'show' === $inspiry_gallery_properties_sorting ) {
								$gallery_listing_args = sort_properties( $gallery_listing_args );
							}

							// Gallery Query and Start of Loop.
							$gallery_query = new WP_Query( $gallery_listing_args );
							while ( $gallery_query->have_posts() ) :
								$gallery_query->the_post();

								// Getting list of property status terms.
								$term_list = '';
								$terms     = get_the_terms( get_the_ID(), 'property-status' );
								if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) :
									foreach ( $terms as $term ) {
										$term_list .= ' ';
										$term_list .= $term->slug;
									}
								endif;

								if ( has_post_thumbnail() ) : ?>
									<div class="gallery-item isotope-item hentry<?php echo esc_attr( $term_list ); ?>">
										<?php
										$image_id       = get_post_thumbnail_id();
										$full_image_url = wp_get_attachment_url( $image_id );
										global $gallery_image_size;
										$featured_image = wp_get_attachment_image_src( $image_id, $gallery_image_size );
										?>
										<figure>
											<div class="media_container">
												<a data-fancybox-trigger="gallery-<?php echo esc_attr(get_the_ID()); ?>" data-this-id="<?php echo esc_attr(get_the_ID()); ?>" class="zoom" href="javascript:;" title="<?php the_title_attribute(); ?>">
													<?php inspiry_safe_include_svg( '/images/icon-zoom.svg' ); ?>
												</a>
												<a class="link" href="<?php the_permalink(); ?>">
													<?php inspiry_safe_include_svg( '/images/icon-link.svg' ); ?>
												</a>
											</div>
											<?php echo '<img class="img-border" src="' . esc_attr( $featured_image[0] ) . '" alt="' . the_title_attribute( 'echo=0' ) . '">'; ?>
										</figure>
										<h5 class="item-title entry-title">
											<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
										<time class="updated hide" datetime="<?php the_modified_time( 'c' ); ?>"><?php the_modified_time( 'M d, Y' ); ?></time>
										<span class="vcard hide">
											<?php
											printf(
												'<a class="url fn" href="%1$s" title="%2$s" rel="author">%3$s</a>',
												esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
												esc_attr( sprintf( esc_html__( 'View all posts by %s', 'framework' ), get_the_author() ) ),
												get_the_author()
											);
											?>
										</span>
										<?php
											$get_post_meta_image         = get_post_meta(get_the_ID(), 'REAL_HOMES_property_images', false);
											$get_prop_images             = count($get_post_meta_image);
											?>
											<div class="rh_property_images_load" style="display: none">
												<?php
												foreach ($get_post_meta_image as $item) {
													$images_src = wp_get_attachment_image_src($item, 'post-featured-image'); ?>
													<span style="display: none;" data-fancybox="gallery-<?php echo esc_attr(get_the_ID()); ?>" data-src="<?php echo esc_url($images_src[0]); ?>" data-thumb="<?php echo esc_url($images_src[0]); ?>"></span>
												<?php
												}
												?>

											</div>
									</div>
									<?php
								endif;

							endwhile;
							wp_reset_postdata();
							?>
						</div>
					</div>
					<!-- end of gallery container -->

					<?php theme_pagination( $gallery_query->max_num_pages ); ?>

				</section>

			</div><!-- End Main Content -->

            <?php
            if ('1' === $get_content_position ) {

	            if ( have_posts() ) {
		            while ( have_posts() ) {
			            the_post();
			            ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>><?php the_content(); ?></article>
			            <?php
		            }
	            }
            }
            ?>

		</div> <!-- End span12 -->

	</div><!-- End contents row -->

</div><!-- End Content -->

<?php get_footer(); ?>
