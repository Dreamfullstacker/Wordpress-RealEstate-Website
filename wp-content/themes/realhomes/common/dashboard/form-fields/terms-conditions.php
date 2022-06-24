<?php
/**
 * Field: Terms & Conditions
 *
 * @since    3.0.1
 * @package realhomes/dashboard
 */

$terms_note    = get_option( 'inspiry_submit_property_terms_text', esc_html__( 'Accept Terms & Conditions before property submission.', 'framework' ) );
$acceptance    = get_option( 'inspiry_submit_property_terms_require' );
$terms_page_id = get_option( 'inspiry_submit_property_terms_page' );
$terms_class   = empty( $acceptance ) ? '' : 'required';

if ( ! empty( $terms_page_id ) ) {
	// Terms & conditions page link building.
	$terms_page_url = get_permalink( $terms_page_id );
	$head           = '<a href="' . esc_url( $terms_page_url ) . '" target="_blank">';
	$tail           = '</a>';
	$terms_note     = str_replace( array( '{', '}' ), array( $head, $tail ), $terms_note );
}
?>
<p class="checkbox-field">
    <input id="terms" name="terms" type="checkbox" class="<?php echo esc_attr( $terms_class ); ?>" title="<?php esc_attr_e( '* Please check this option.', 'framework' ); ?>"
		<?php
		if ( realhomes_dashboard_edit_property() ) {
			global $post_meta_data;
			if ( isset( $post_meta_data['REAL_HOMES_terms_conditions'] ) && ( 1 == $post_meta_data['REAL_HOMES_terms_conditions'][0] ) ) {
				echo 'checked ';
			}
		}
		echo esc_attr( $terms_class );
		?> />
    <label for="terms"><?php echo wp_kses( $terms_note, inspiry_allowed_html() ); ?></label>
</p>