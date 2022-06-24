<?php
/**
 * Property Archive
 *
 * @package    realhomes
 * @subpackage classic
 */

get_header();

/* Determine the type header to be used for taxonomy */
$theme_listing_module = get_option( 'theme_listing_module' );

switch ( $theme_listing_module ) {
	case 'properties-map':
		get_template_part( 'assets/classic/partials/banners/map' );
		break;
	default:
		get_template_part( 'assets/classic/partials/banners/property-archive' );
		break;
}

/* Check View Type */
if ( isset( $_GET['view'] ) ) {
	$view_type = $_GET['view'];
} else {
	/* Theme Options Listing Layout */
	$view_type = get_option( 'theme_listing_layout' );
}
?>

<div class="container contents listing-grid-layout">
	<?php
		// Display any contents after the page banner and before the contents.
		do_action( 'inspiry_before_page_contents' );
	?>
	<div class="row">
		<div class="span9 main-wrap">

			<!-- Main Content -->
			<div class="main">

				<section class="listing-layout <?php if ( 'grid' == $view_type ) {
					echo 'property-grid';
				} ?>">

					<?php
					// Listing view type.
					get_template_part( 'assets/classic/partials/properties/view-buttons' );
					?>

					<div class="list-container clearfix">
						<?php
						get_template_part( 'assets/classic/partials/properties/sort-controls' );
						global $wp_query;
						if ( have_posts() ) :
							while ( have_posts() ) :
								the_post();
								if ( 'grid' == $view_type ) {
									// Display property in grid layout
									get_template_part( 'assets/classic/partials/properties/grid-card' );
								} else {
									// Display properpty in list layout
									get_template_part( 'assets/classic/partials/properties/list-card' );
								}
							endwhile;
						else :
							?>
							<div class="alert-wrapper">
								<h4><?php esc_html_e( 'No Property Found', 'framework' ); ?></h4>
							</div>
							<?php
						endif;
						?>
					</div>

					<?php theme_pagination( $wp_query->max_num_pages ); ?>

				</section>

			</div><!-- End Main Content -->

		</div> <!-- End span9 -->

		<?php get_sidebar( 'property-listing' ); ?>

	</div><!-- End contents row -->
</div>

<?php get_footer(); ?>
