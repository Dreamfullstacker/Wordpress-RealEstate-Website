<?php
/**
 * Header Variation One Template
 *
 * @package    realhomes
 * @subpackage modern
 */

$responsive_header_classes = array( 'rh_temp_header_responsive_view' );

if ( 'solid' === get_option( 'inspiry_responsive_header_option', 'solid' ) ) {
	$responsive_header_classes[] = 'rh_header_advance';
} else {
	$responsive_header_classes[] = 'rh_header_responsive';
}

if ( is_page_template( 'templates/home.php' ) ) {
	$responsive_header_classes[] = 'rh_header--shadow';
}
?>
<header class="rh_header <?php echo join( ' ', $responsive_header_classes ); ?>">
    <div class="rh_header__wrap">
        <div class="rh_logo rh_logo_wrapper">
            <div class="rh_logo_inner">
				<?php
				$theme_sitelogo_mobile        = get_option( 'theme_sitelogo_mobile' );
				$theme_sitelogo_retina_mobile = get_option( 'theme_sitelogo_retina_mobile' );
				if ( ! empty( $theme_sitelogo_mobile ) || ! empty( $theme_sitelogo_retina_mobile ) ) {
					get_template_part( 'assets/modern/partials/header/site-logo-responsive' );
				} else {
					get_template_part( 'assets/modern/partials/header/site-logo' );
				}
				?>
            </div>
        </div>
        <div class="rh_menu">
            <nav class="main-menu">
				<?php get_template_part( 'assets/modern/partials/header/menu-list-responsive' ); ?>
            </nav>
            <div class="rh_menu__user">
				<?php get_template_part( 'assets/modern/partials/header/user-phone' ); ?>
                <div class="user_menu_wrapper rh_user_menu_wrapper_responsive"></div>
				<?php get_template_part( 'assets/modern/partials/header/submit-property' ); ?>
            </div>
        </div>
    </div>
</header><!-- /.rh_header -->