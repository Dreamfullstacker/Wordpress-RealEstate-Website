    <?php
/**
 * Header Variation: Center
 *
 * @package realhomes
 * @subpackage classic
 */

?>

<header id="header" class="clearfix">

	<div class="header__top">

		<div class="row">

			<div class="span5 header__switchers">

				<div class="social_nav clearfix" id="social_nav">
					<!-- User Navigation -->
					<?php get_template_part( 'assets/classic/partials/header/social-nav' ); ?>
				</div>
				<!-- /.social_nav -->
			</div>
			<!-- /.span6 -->

			<div class="span7 header__user_nav">

				<!-- User Navigation -->
				<?php get_template_part( 'assets/classic/partials/header/user-nav' ); ?>

				<?php get_template_part( 'assets/classic/partials/header/email' ); ?>

			</div>
			<!-- /.span6 -->

		</div>
		<!-- /.row -->

		<div class="row">

			<div class="span12 header__logo" id="logo">
				<?php get_template_part( 'assets/classic/partials/header/logo' ); ?>
			</div>
			<!-- /.span12 -->

		</div>
		<!-- /.row -->

	</div>
	<!-- /.header__top -->

	<div class="header__navigation clearfix">

		<div class="header__menu">
			<!-- Start Main Menu-->
			<nav class="main-menu">
				<div class="rh_menu__hamburger hamburger hamburger--squeeze">
					<div class="hamburger-box">
						<div class="hamburger-inner"></div>
					</div>
					<p><?php esc_html_e( 'Menu', 'framework' ); ?></p>
				</div>
				<?php
				if ( has_nav_menu( 'main-menu' ) ) {
					wp_nav_menu( array(
						'theme_location' => 'main-menu',
						'walker'         => new RH_Walker_Nav_Menu(),
						'menu_class'     => 'rh_menu__main_menu clearfix',
						'fallback_cb'    => false // Do not fall back to wp_page_menu()
					) );
				}
				if ( has_nav_menu( 'responsive-menu' ) ) {
					wp_nav_menu( array(
						'theme_location' => 'responsive-menu',
						'walker'         => new RH_Walker_Nav_Menu(),
						'menu_class'     => 'rh_menu__responsive clearfix',
						'fallback_cb'    => false // Do not fall back to wp_page_menu()
					) );
				} else {
					// Assign main menu as fallback.
					$locations = get_theme_mod( 'nav_menu_locations' );
					$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
					if ( ! empty( $main_menu ) ) {
						$locations['responsive-menu'] = $main_menu->term_id;
						set_theme_mod( 'nav_menu_locations', $locations );

						if ( has_nav_menu( 'responsive-menu' ) ) {
							wp_nav_menu( array(
								'theme_location' => 'responsive-menu',
								'walker'         => new RH_Walker_Nav_Menu(),
								'menu_class'     => 'rh_menu__responsive clearfix',
								'fallback_cb'    => false // Do not fall back to wp_page_menu()
							) );
						}
					}
				}
				?>
			</nav>
			<!-- End Main Menu -->
		</div>
		<!-- /.header__menu -->

		<div class="header__phone_number clearfix">
			<!-- Phone Number -->
			<?php get_template_part( 'assets/classic/partials/header/phone-number' ); ?>
		</div>
		<!-- /.header__phone_number -->

	</div>
	<!-- /.header__navigation -->

</header>
<!-- /#header.clearfix -->
