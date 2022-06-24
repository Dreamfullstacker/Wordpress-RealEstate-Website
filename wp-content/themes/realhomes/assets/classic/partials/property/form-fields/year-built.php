<?php
/**
 * Field: Year Built
 *
 * @since 3.3.0
 * @package realhomes/classic
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( inspiry_is_edit_property() ) {
	global $post_meta_data;
	if ( isset( $post_meta_data['REAL_HOMES_property_year_built'] ) ) {
		$year_built = $post_meta_data['REAL_HOMES_property_year_built'][0];
	}
}

?>

<div class="form-option year-built-field-wrapper">
	<label for="year-built"><?php esc_html_e( 'Year Built', 'framework' ); ?></label>
	<input id="year-built" name="year-built" type="text" value="<?php echo ( ! empty( $year_built ) ) ? esc_attr( $year_built ) : false; ?>"
	title="<?php esc_html_e( 'Year Built', 'framework' ); ?>"/>
</div>
