<?php
/**
 * Header Variation Three Template
 *
 * @package    realhomes
 * @subpackage modern
 */

$get_search_form_layout = get_option( 'inspiry_search_form_mod_layout_options', 'default' );
$get_header_variations  = apply_filters( 'inspiry_header_variation', get_option( 'inspiry_header_mod_variation_option', 'one' ) );

$form_fat_class = '';
if ( $get_search_form_layout == 'default' ) {
	$form_fat_class = 'rh_form_fat';
}
?>


<header class="rh_temp_header_large_screens rh_var_header rh_var3_header">


    <div class="rh_var3_header_box rh_var_container <?php echo esc_attr( $form_fat_class ); ?>">
        <div class="rh_var_logo rh_logo_selective_refresh">
			<?php get_template_part( 'assets/modern/partials/header/site-logo' ); ?>
        </div>
        <div class="rh_var2_top_nav">
			<?php get_template_part( 'assets/modern/partials/header/menu-list-large-screens' ); ?>
        </div>
        <div class="rh_var3_user_nav">
			<?php get_template_part( 'assets/modern/partials/header/user-phone' ); ?>
            <div class="user_menu_wrapper rh_user_menu_wrapper_large">
				<?php get_template_part( 'assets/modern/partials/header/user-menu' ); ?>
            </div>
			<?php get_template_part( 'assets/modern/partials/header/submit-property' ); ?>
        </div>

<!--        <div class="rh_prop_search_init rh_prop_search_in_header">-->
<!---->
<!--			--><?php
//			if ( $get_header_variations == 'three' ) {
//				switch ( $get_search_form_layout ) {
//					case 'default';
//						get_template_part( 'assets/modern/partials/properties/search/form' );
//						break;
//					case 'smart';
//						get_template_part( 'assets/modern/partials/properties/search/form-smart' );
//						break;
//				}
//			}
//
//			?>
<!--        </div>-->

		<?php
		$advance_search_expand = '';
		if ( inspiry_is_rvr_enabled() || 'false' === get_option( 'inspiry_search_advance_search_expander', 'true' ) ){
			$advance_search_expand = 'rh_hide_advance_fields';
		}
		?>
        <div class="rh_prop_search_init rh_prop_search_in_header <?php echo esc_attr( $advance_search_expand );?>">
        </div>

    </div>

</header>