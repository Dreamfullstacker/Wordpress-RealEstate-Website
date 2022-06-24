<?php
/**
 * Header Variation Two Template
 *
 * @package    realhomes
 * @subpackage modern
 */
?>
<header class="rh_temp_header_large_screens rh_var_header rh_var2_header">
    <div class="rh_var2_nav_wrapper">
        <div class="rh_var2_nav_container rh_var_container">
            <div class="rh_var2_top_nav">
				<?php get_template_part( 'assets/modern/partials/header/menu-list-large-screens' ); ?>
            </div>
            <div class="rh_var2_user_login user_menu_wrapper rh_user_menu_wrapper_large">
				<?php get_template_part( 'assets/modern/partials/header/user-menu' ); ?>
            </div>
        </div>
    </div>
    <div class="rh_var2_header_meta_wrapper ">
        <div class="rh_var2_header_meta_container">
            <div class="rh_left_box">
                <div class="rh_var2_logo hide-sm-device rh_logo_selective_refresh">
					<?php get_template_part( 'assets/modern/partials/header/site-logo' ); ?>
                </div>
                <?php get_template_part( 'assets/modern/partials/header/social-icons' ); ?>
            </div>
            <div class="rh_right_box">
				<?php get_template_part( 'assets/modern/partials/header/user-phone' ); ?>
				<?php get_template_part( 'assets/modern/partials/header/user-email' ); ?>
				<?php get_template_part( 'assets/modern/partials/header/submit-property' ); ?>
            </div>
        </div>
    </div>
</header>