<?php
/**
 * Favorite Properties Page
 *
 * Page template for favorite properties.
 *
 * @since 2.7.0
 * @package realhomes/classic
 */

get_header();

get_template_part( 'assets/classic/partials/banners/default' ); ?>

<!-- Content -->
<div class="container contents listing-grid-layout">
	<?php
		// Display any contents after the page banner and before the contents.
		do_action( 'inspiry_before_page_contents' );
	?>
    <div class="row">
        <div class="span9 main-wrap">

            <!-- Main Content -->
            <div class="main">
                <section class="listing-layout property-grid">

					<?php
					global $post;
					$title_display = get_post_meta( get_the_ID(), 'REAL_HOMES_page_title_display', true );
					if ( 'hide' !== $title_display ) {
						?>
                        <h3 class="title-heading"><?php the_title(); ?></h3>
						<?php
					}
					?>

                    <div class="list-container inner-wrapper clearfix favorite_properties_ajax">
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

						$require_login = get_option( 'inspiry_login_on_fav', 'no' );
						if ( ( is_user_logged_in() && 'yes' == $require_login ) || ( 'yes' != $require_login ) ) {

							$number_of_properties = 0;
							$favorite_pro_ids     = realhomes_get_favorite_pro_ids();
							if ( ! empty( $favorite_pro_ids ) ) {
								$number_of_properties = count( $favorite_pro_ids );
							}

							if ( $number_of_properties > 0 ) {

								$favorites_properties_args = array(
									'post_type'      => 'property',
									'posts_per_page' => $number_of_properties,
									'post__in'       => $favorite_pro_ids,
									'orderby'        => 'post__in',
								);

								$favorites_query = new WP_Query( $favorites_properties_args );

								if ( $favorites_query->have_posts() ) {
									while ( $favorites_query->have_posts() ) {
										$favorites_query->the_post();
										get_template_part( 'assets/classic/partials/properties/favorite-card' );
									}
									wp_reset_postdata();
								} else {
									?>
                                    <div class="alert-wrapper">
                                        <h4><?php esc_html_e( 'No property found!', 'framework' ); ?></h4>
                                    </div>
									<?php
								}
							} else {
								?>
                                <div class="alert-wrapper">
                                    <h4><?php esc_html_e( 'You have no property in favorites!', 'framework' ); ?></h4>
                                </div>
								<?php
							}
						} else {
							?>
                            <div class="alert-wrapper">
                                <h4><?php esc_html_e( 'Login Required!', 'framework' ); ?></h4>
                            </div>
							<?php
						}
						?>
                    </div>

                </section>

            </div><!-- End Main Content -->
        </div> <!-- End span9 -->

		<?php get_sidebar( 'property-listing' ); ?>

    </div><!-- End contents row -->
</div><!-- End Content -->
<?php
if ( '1' === $get_content_position ) {

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

<?php get_footer(); ?>
