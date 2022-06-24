<?php
/**
 * Login & Register Template
 *
 * Page template for login & register.
 *
 * @since 2.7.0
 * @package realhomes/classic
 */

get_header();

// Page Head.
get_template_part( 'assets/classic/partials/banners/default' ); ?>

<!-- Content -->
<div class="container contents single login-register">
	<?php
		// Display any contents after the page banner and before the contents.
		do_action( 'inspiry_before_page_contents' );
	?>
	<div class="row">
		<div class="span12 main-wrap">

			<?php
			global $post;
			$title_display = get_post_meta( get_the_ID(), 'REAL_HOMES_page_title_display', true );
			if ( 'hide' !== $title_display ) {
				?>
				<h3><span><?php the_title(); ?></span></h3>
				<?php
			}
			?>

			<!-- Main Content -->
			<div class="main">

				<div class="inner-wrapper">
					<?php
					if ( have_posts() ) :
						while ( have_posts() ) :
							the_post();
								?>
								<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
									<?php the_content(); ?>
								</article>
								<?php
						endwhile;
					endif;

					if ( ! is_user_logged_in() ) {
						?>
                        <div class="forms-simple">

                            <div class="row-fluid">

                                <div class="span6">
									<?php get_template_part( 'assets/classic/partials/page/forms/login-form' ); ?>
                                </div>

                                <div class="span6">
									<?php get_template_part( 'assets/classic/partials/page/forms/register-form' ); ?>
                                </div><!-- end of .span6 -->

                            </div><!-- end of .row-fluid -->

                        </div><!-- end of .forms-simple -->
						<?php
					} else {
						echo '<h5>';
						esc_html_e( 'You are already logged in!', 'framework' );
						echo '</h5>';
						echo '<br>';
					}
					?>
				</div>

			</div><!-- End Main Content -->

		</div> <!-- End span12 -->

	</div><!-- End contents row -->

</div><!-- End Content -->

<?php get_footer(); ?>
