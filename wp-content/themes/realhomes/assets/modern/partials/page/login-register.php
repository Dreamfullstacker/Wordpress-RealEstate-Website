<?php
/**
 * Page: Login or Register
 *
 * Page template for login or register.
 *
 * @since 	3.0.0
 * @package realhomes/modern
 */

get_header();

// Page Head.
$header_variation = get_option( 'inspiry_member_pages_header_variation', 'banner' );

if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/header' );
} elseif ( ! empty( $header_variation ) && ( 'banner' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/image' );
}

get_template_part( 'assets/modern/partials/properties/search/advance' ); ?>

<section class="rh_section rh_wrap rh_wrap--padding rh_wrap--topPadding">
	<?php
		// Display any contents after the page banner and before the contents.
		do_action( 'inspiry_before_page_contents' );
	?>
	<div class="rh_page">

		<div class="rh_page__head">

			<?php if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) : ?>
				<h2 class="rh_page__title">
					<?php
				    $page_title = get_post_meta( get_the_ID(), 'REAL_HOMES_banner_title', true );
				    if ( empty( $page_title ) ) {
				        $page_title = get_the_title( get_the_ID() );
				    }
					echo inspiry_get_exploded_heading( $page_title );
					?>
				</h2>
				<!-- /.rh_page__title -->
			<?php endif; ?>

		</div>
		<!-- /.rh_page__head -->

		<?php if ( ! is_user_logged_in() ) : ?>

			<div class="rh_form rh_form__login_wrap">

				<?php if ( have_posts() ) :
					while ( have_posts() ) :
						the_post();

						$page_content = get_the_content();

						if ( ! empty( $page_content ) ) {
							?>
                            <div class="rh_content">
								<?php the_content(); ?>
                            </div>
                            <!-- /.rh_content -->
							<?php
						}

					endwhile;
				endif;

				// Login Form
                ?>
                <div class="rh_property_detail_login">
					<?php
					get_template_part( 'assets/modern/partials/member/login-form' );

					// Register Form
					get_template_part( 'assets/modern/partials/member/register-form' );

					?>
                </div>

                <div class="inspiry_social_login inspiry_mod_social_login_page">
					<?php
					/*
					 * For social login
					 */
					do_action( 'wordpress_social_login' );

					/**
					 * RealHomes Social Login.
					 */
					do_action( 'realhomes_social_login' );
					?>
                </div>
			</div>
			<!-- /.rh_form -->

		<?php elseif ( is_user_logged_in() ) : ?>

			<?php alert( esc_html__( 'You are already logged in!', 'framework' ) ); ?>

		<?php endif; ?>

	</div>
	<!-- /.rh_page -->

</section>
<!-- /.rh_section rh_wrap rh_wrap--padding -->

<?php
get_footer();
