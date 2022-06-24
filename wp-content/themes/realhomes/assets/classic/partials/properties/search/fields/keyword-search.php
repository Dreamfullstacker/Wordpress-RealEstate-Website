<?php
/**
 * Keyword Search Field
 */
?>
<div class="option-bar rh-search-field rh_classic_keyword_field small">
	<label for="keyword-txt">
		<?php
		$inspiry_keyword_label = get_option( 'inspiry_keyword_label' );
		if ( ! empty( $inspiry_keyword_label ) ) {
			echo esc_html( $inspiry_keyword_label );
		} else {
			esc_html_e( 'Keyword', 'framework' );
		}
        ?>
	</label>
	<input type="text" name="keyword" id="keyword-txt"
	       value="<?php echo isset( $_GET[ 'keyword' ] ) ? esc_attr( $_GET[ 'keyword' ] ): ''; ?>"
	       placeholder="<?php
	       $inspiry_keyword_placeholder_text = get_option( 'inspiry_keyword_placeholder_text' );
	       if ( ! empty( $inspiry_keyword_placeholder_text ) ) {
		       echo esc_attr( $inspiry_keyword_placeholder_text );
	       } else {
               echo esc_attr( rh_any_text() );
	       } ?>" />
</div>