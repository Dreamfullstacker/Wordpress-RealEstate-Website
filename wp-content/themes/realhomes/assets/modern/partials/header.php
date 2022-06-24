<?php
/**
 * Header Template
 *
 * @package    realhomes
 * @subpackage modern
 */
?>
<div id="rh_progress"></div>

<?php
if ( 'true' === get_option( 'theme_sticky_header', 'false' ) ) {
	$sticky_header_class        = 'sticky_header_dark';
	$sticky_header_color_scheme = get_option( 'realhomes_sticky_header_color_scheme', 'dark' );
	if ( 'light' === $sticky_header_color_scheme ) {
		$sticky_header_class = 'sticky_header_light';
	} elseif ( 'custom' === $sticky_header_color_scheme ) {
		$sticky_header_class = 'sticky_header_custom';
	}
	?>
    <div class="rh_mod_sticky_header <?php echo esc_attr( $sticky_header_class ); ?>">
		<?php get_template_part( 'assets/modern/partials/header/sticky-header' ); ?>
    </div>
	<?php
}
?>

<div class="rh_responsive_header_temp">
	<?php get_template_part( 'assets/modern/partials/header-responsive' ); ?>
</div>

<div class="rh_long_screen_header_temp <?php echo esc_attr( 'rh_header_layout_' . get_option( 'realhomes_header_layout', 'default' ) ); ?>">
	<?php
	$get_header_variations = apply_filters( 'inspiry_header_variation', get_option( 'inspiry_header_mod_variation_option', 'one' ) );
	switch ( $get_header_variations ) {
		case 'two':
			get_template_part( 'assets/modern/partials/header/header-var2' );
			break;
		case 'three':
			get_template_part( 'assets/modern/partials/header/header-var3' );
			break;
		case 'four':
			get_template_part( 'assets/modern/partials/header/header-var4' );
			break;
		default:
			get_template_part( 'assets/modern/partials/header/header-var1' );
	}
	?>
</div>