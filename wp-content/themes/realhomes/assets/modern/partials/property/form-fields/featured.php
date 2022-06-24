<?php
/**
 * Field: Featured
 *
 * @since 	3.0.0
 * @package realhomes/modern
 */

?>

<div class="rh_form__item rh_form--1-column rh_form--columnAlign featured-field-wrapper">
	<div class="rh_checkbox rh_checkbox__featured">
		<label for="featured">
			<span class="rh_checkbox__title"><?php esc_html_e( 'Mark this property as featured property', 'framework' ); ?></span>
			<input id="featured" name="featured" type="checkbox" <?php
			if ( inspiry_is_edit_property() ) {
			    global $post_meta_data;
			    if ( isset( $post_meta_data['REAL_HOMES_featured'] ) && ( 1 == $post_meta_data['REAL_HOMES_featured'][0] ) ) {
			        echo 'checked';
			    }
			}
			?> />
			<span class="rh_checkbox__indicator"></span>
		</label>
	</div>
	<!-- /.rh_checkbox -->
</div>
<!-- /.rh_form__item -->
