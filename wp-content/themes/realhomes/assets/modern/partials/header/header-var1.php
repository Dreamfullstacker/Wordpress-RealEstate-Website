<?php
/**
 * Header Variation One Template
 *
 * @package    realhomes
 * @subpackage modern
 */

$get_responsive_header = get_option( 'inspiry_responsive_header_option', 'solid' );
$responsive_class      = 'rh_header_responsive';

if ( $get_responsive_header == 'solid' ) {
	$responsive_class = 'rh_header_advance';
}

if ( is_page_template( array(
		'templates/home.php',
		'templates/property-full-width-layout.php',
		'elementor_header_footer',
	) ) || ( is_singular( 'property' ) && 'fullwidth' === get_option( 'inspiry_property_single_template', 'sidebar' ) )
) {
	$responsive_class .= ' rh_header--shadow';
}
	?>
	<header class="rh_header_var_1 rh_temp_header_large_screens rh_header <?php echo esc_attr( $responsive_class ); ?>">

		<div class="rh_header__wrap">

			<div class="rh_logo rh_logo_wrapper rh_logo_selective_refresh">

				<div class="rh_logo_inner">
					<?php get_template_part( 'assets/modern/partials/header/site-logo' ); ?>

				</div>

			</div>
			<!-- /.rh_logo -->

			<div class="rh_menu">

				<!-- Start Main Menu-->
				<nav class="main-menu">
					<?php get_template_part( 'assets/modern/partials/header/menu-list-large-screens' ); ?>
				</nav>
				<!-- End Main Menu -->

				<div class="rh_menu__user">
					<?php

					get_template_part( 'assets/modern/partials/header/user-phone' );


					?>
					<div class="user_menu_wrapper rh_user_menu_wrapper_large">
						<?php get_template_part( 'assets/modern/partials/header/user-menu' ); ?>
					</div>
					<?php get_template_part( 'assets/modern/partials/header/submit-property' ); ?>
				</div>
				<!-- /.rh_menu__user -->

			</div>
			<!-- /.rh_menu -->

		</div>
		<!-- /.rh_header__wrap -->

	</header>
	<!-- /.rh_header -->
