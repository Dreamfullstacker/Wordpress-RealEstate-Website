<?php
$header_variation = get_option( 'inspiry_pages_header_variation' );
$banner_title     = esc_html__( '404 - Page Not Found!', 'framework' );
$banner_details   = esc_html__( 'The page you are looking for is not here!', 'framework' );

if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) {
	get_template_part( 'assets/modern/partials/banner/header' );
} elseif ( ! empty( $header_variation ) && ( 'banner' === $header_variation ) ) {
	// Banner Image.
	$banner_image_path = get_default_banner();
	?>
	<section class="rh_banner rh_banner__image" style="background-image: url('<?php echo esc_url( $banner_image_path ); ?>');">

		<div class="rh_banner__cover"></div>
		<!-- /.rh_banner__cover -->

		<div class="rh_banner__wrap">

			<h2 class="rh_banner__title">
				<?php echo esc_html( $banner_title ); ?>
			</h2>
			<!-- /.rh_banner__title -->

		</div>
		<!-- /.rh_banner__wrap -->

	</section>
	<!-- /.rh_banner -->
	<?php
}
?>

	<section class="rh_section rh_wrap rh_wrap--padding rh_wrap--topPadding">
		<?php
			// Display any contents after the page banner and before the contents.
			do_action( 'inspiry_before_page_contents' );
		?>
		<div class="rh_page">

			<div class="rh_page__head">

				<h2 class="rh_page__title">
					<?php if ( empty( $header_variation ) || ( 'none' === $header_variation ) ) : ?>
						<span class="sub"><?php echo esc_html( $banner_title ); ?></span>
						<!-- /.sub -->
					<?php endif; ?>
					<span class="title"><?php echo esc_html( $banner_details ); ?></span>
				</h2>
				<!-- /.rh_page__title -->

			</div>
			<!-- /.rh_page__wrap -->

			<div class="rh_alert-wrapper rh_alert__404">
				<h4 class="no-results"><?php esc_html_e( 'Please try top navigation!', 'framework' ); ?></h4>
			</div>

		</div>
		<!-- /.rh_page -->

	</section>
	<!-- /.rh_section rh_wrap rh_wrap--padding -->