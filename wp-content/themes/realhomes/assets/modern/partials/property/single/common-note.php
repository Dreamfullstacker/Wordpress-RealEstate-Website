<?php
/**
 * Common note of the single property.
 *
 * @package    realhomes
 * @subpackage modern
 */

$display_common_note = get_option( 'theme_display_common_note' );
if ( 'true' === $display_common_note ) {

	$common_note_title = get_option( 'theme_common_note_title' );
	$common_note       = get_option( 'theme_common_note' );

	if ( ! empty( $common_note_title ) || ! empty( $common_note ) ) {
		?>
		<div class="rh_property__common_note">
			<?php
			// Common note title.
			if ( ! empty( $common_note_title ) ) {
				?><h4 class="rh_property__heading"><?php echo esc_html( $common_note_title ); ?></h4><?php
			}

			// Common note text.
			if ( ! empty( $common_note ) ) {
				?><p><?php echo esc_html( $common_note ); ?></p><?php
			}
			?>
		</div>
		<?php
	}
}
