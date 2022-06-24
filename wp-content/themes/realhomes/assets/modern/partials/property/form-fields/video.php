<?php
/**
 * Field: Virtual Tour Video URL
 *
 * @since 	3.0.0
 * @package realhomes/modern
 */

?>

<div class="rh_form__item rh_form--3-column rh_form--columnAlign">
	<label for="video-url"><?php esc_html_e( 'Virtual Tour Video URL', 'framework' ); ?></label>
	<input id="video-url" name="video-url" type="text" value="<?php
	if ( inspiry_is_edit_property() ) {
	    global $post_meta_data;
	    if ( isset( $post_meta_data['REAL_HOMES_tour_video_url'] ) ) {
	        echo esc_attr( $post_meta_data['REAL_HOMES_tour_video_url'][0] );
	    }
	} ?>" title="<?php esc_attr_e( 'Virtual Tour Video URL', 'framework' ); ?>"/>
</div>
<!-- /.rh_form__item -->
