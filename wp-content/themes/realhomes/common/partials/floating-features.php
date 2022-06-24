<?php

$compare_properties_module = get_option( 'theme_compare_properties_module' );
$inspiry_compare_page      = get_option( 'inspiry_compare_page' );
$inspiry_language_switcher = get_option( 'theme_wpml_lang_switcher' );

if ( ( 'enable' === $compare_properties_module && $inspiry_compare_page ) ||
	( 'true' === $inspiry_language_switcher ) ||
	( class_exists( 'Realhomes_Currency_Switcher' ) )
	) {
	?>
	<div class="rh_wrapper_floating_features <?php echo ( 'classic' === INSPIRY_DESIGN_VARIATION ) ? 'rh_floating_classic' : ''; ?>">
		<?php

		if ( function_exists( 'realhomes_currency_switcher_button' ) ) {
			realhomes_currency_switcher_button();
		}

		if ( 'true' === $inspiry_language_switcher ) {

			if ( 'full' === get_theme_mod( 'inspiry_default_floating_button', 'half' )
				|| 'language_name_only' === get_option( 'theme_switcher_language_display' ) ) {
				$open_class = 'rh_language_open_full';
			} else {
				$open_class = '';
			}
			?>
			<div class="rh_wrapper_language_switcher <?php echo esc_attr( $open_class ); ?>">
				<?php
				/**
				 * Inspiry WPML Language Switcher
				 */
				inspiry_language_switcher();
				?>
			</div>
			<?php
		}

		if ( ( 'enable' === $compare_properties_module && $inspiry_compare_page ) ) {
			?>

			<div class="rh_wrapper_properties_compare">
				<div class="rh_floating_compare_button">
						<span class="rh_compare_icon">
							<?php include get_template_directory() . '/common/images/icon-compare-default.svg'; ?>
						</span>
					<span class="rh_compare_count"></span>
				</div>
				<div class="rh_fixed_side_bar_compare">
					<?php
					get_template_part( 'common/partials/compare-view' );
					?>
				</div>
			</div>

			<?php
		}
		?>
	</div>
	<?php
}
?>
