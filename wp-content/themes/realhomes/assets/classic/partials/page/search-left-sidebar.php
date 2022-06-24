<?php
/**
 * Properties search with left sidebar.
 *
 * @package    realhomes
 * @subpackage classic
 */

get_header();

/* Theme Search Module */
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

<!-- listing container - grid layout -->
<div class="container contents listing-grid-layout">
	<?php
		// Display any contents after the page banner and before the contents.
		do_action( 'inspiry_before_page_contents' );
	?>
	<div class="row">

		<!-- sidebar wrapper -->
		<div class="span3 sidebar-wrap">
			<aside class="sidebar">
				<?php
				if ( is_active_sidebar( 'property-search-sidebar' ) ) {
					dynamic_sidebar( 'property-search-sidebar' );
				}
				?>
			</aside>
		</div>
        <!-- end of sidebar wrapper -->

		<!-- main content wrapper -->
		<div class="span9 main-wrap">
			<?php get_template_part( 'assets/classic/partials/properties/search/results-with-sidebar' ); ?>
		</div><!-- end of main content wrapper -->

	</div><!-- end of .row -->

	<?php
	$get_content_position = get_post_meta( get_the_ID(), 'REAL_HOMES_content_area_above_footer', true );

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

</div><!-- end of listing container -->

<?php get_footer(); ?>
