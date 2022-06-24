<?php
/**
 * Advance search section for homepage.
 *
 */

/* Theme Home Page Module */
$theme_homepage_module = get_post_meta( get_the_ID(), 'theme_homepage_module', true );
$main_border_class     = '';

/* For demo purpose only */
if ( isset( $_GET['module'] ) ) {
	$theme_homepage_module = $_GET['module'];
}

?>
<div class="container">
    <div class="row">
        <div class="span12">
			<?php
			if ( ! inspiry_is_search_page_configured() ) {
				$main_border_class = 'top-border';
			}
			?>
            <div class="main <?php echo esc_attr( $main_border_class ); ?>">
				<?php
				/* In case of search form over  image, we do not need to display search form below */
				if ( 'search-form-over-image' !== $theme_homepage_module ) {
					/* Display home search area widgets if there is any - otherwise display default advance search form */
					if ( is_active_sidebar( 'home-search-area' ) ) :
						dynamic_sidebar( 'home-search-area' );
					else :
						$show_home_search = get_post_meta( get_the_ID(), 'theme_show_home_search', true );

						if ( 'true' === $show_home_search ) {
							/* Advance Search Form for Homepage */
							get_template_part( 'assets/classic/partials/properties/search/form-wrapper' );
						}
					endif;
				}

				/* Homepage Contents from Page Editor */
				if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();
						?>
                        <div class="inner-wrapper <?php if ( empty( get_the_content() ) ) {
							echo esc_attr( 'rh_no_content' );
						} ?>">
                            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<?php the_content(); ?>
                            </article>
                        </div>
					<?php
					endwhile;
				endif;
				?>
            </div>
        </div>
    </div>
</div>
