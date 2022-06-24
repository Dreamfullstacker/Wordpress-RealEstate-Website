<div class="form-option checkbox-option clearfix terms-field-wrapper">
	<?php

		$terms_note     = get_option( 'inspiry_submit_property_terms_text', esc_html__( 'Accept Terms & Conditions before property submission.', 'framework' ) );
		$acceptance     = get_option( 'inspiry_submit_property_terms_require' );
		$terms_class    = ( empty( $acceptance ) ) ? '' : 'required';
		$terms_page_id  = get_option( 'inspiry_submit_property_terms_page' );

		if( ! empty( $terms_page_id ) ) {

			// terms & conditions page link building
			$terms_page_url = get_permalink( $terms_page_id );
			$head = '<a href="' . esc_url( $terms_page_url ) . '" target="_blank">';
			$tail = '</a>';

			$terms_note = str_replace( array( '{', '}' ), array( $head, $tail ), $terms_note );
		}

	?><label for="terms"><?php echo wp_kses( $terms_note, inspiry_allowed_html() ); ?></label>
	<input id="terms" name="terms" type="checkbox" class="<?php echo esc_attr( $terms_class ); ?>" title="<?php esc_html_e( 'Please check this option.', 'framework' ); ?>" <?php
		if ( inspiry_is_edit_property() ) {
			global $post_meta_data;
			if ( isset( $post_meta_data['REAL_HOMES_terms_conditions'] ) && ( $post_meta_data['REAL_HOMES_terms_conditions'][0] == 1 ) ) {
				echo 'checked';
			}
		}
	?> />

</div>
