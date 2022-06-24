<?php
/**
 * Properties Search Page
 *
 * @since 2.7.0
 * @package realhomes/classic
 */

get_header();

/* Theme Home Page Module */
$theme_search_module = get_option( 'theme_search_module' );

switch ( $theme_search_module ) {
	case 'properties-map':
		get_template_part( 'assets/classic/partials/banners/map' );
		break;

	default:
		get_template_part( 'assets/classic/partials/banners/default' );
		break;
}
?>

<!-- Content -->
<div class="container contents">
	<?php
		// Display any contents after the page banner and before the contents.
		do_action( 'inspiry_before_page_contents' );
	?>
	<div class="row">
		<div class="span12">
			<!-- Main Content -->
			<div class="main">
				<?php
					/* Advance Search Form */
					get_template_part( 'assets/classic/partials/properties/search/form-wrapper' );
				?>

				<section class="property-items">
					<?php
					/*
					 * number of properties to display on search results page.
					 */
					$number_of_properties = intval( get_option( 'theme_properties_on_search' ) );
					if ( ! $number_of_properties ) {
						$number_of_properties = 4;
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

					/* Apply Search Filter */
					$search_args = apply_filters( 'real_homes_search_parameters', $search_args );

					/* Sort Properties */
					$search_args = sort_properties( $search_args );

					global $search_query;
					$search_query = new WP_Query( $search_args );
					?>

					<div class="search-header inner-wrapper clearfix">
						<div class="properties-count">
							<span><strong><?php echo esc_html( $search_query->found_posts ); ?></strong>&nbsp;
								<?php
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
							// Sort controls.
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
						?>
					</div>

					<?php
						$search_listing_template = get_option('inspiry_search_template_variation', 'two-columns');

						//search template
						get_template_part( 'assets/classic/partials/properties/search/' . $search_listing_template );
					?>

					<?php theme_pagination( $search_query->max_num_pages ); ?>

				</section>

			</div><!-- End Main Content -->

			<?php
			if ( '1' === $get_content_position ) {
				if ( have_posts() ) {
					while ( have_posts() ) {
						the_post();
						?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class( ); ?>>
							<?php the_content(); ?>
                        </article>
						<?php
					}
				}
			}
			?>

		</div> <!-- End span12 -->

	</div><!-- End  row -->

</div><!-- End content -->

<?php get_footer(); ?>
