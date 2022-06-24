<?php
global $target_property;

$add_in_slider = 'no';
if ( realhomes_dashboard_edit_property() ) {
	global $post_meta_data;

	if ( isset( $post_meta_data['REAL_HOMES_add_in_slider'] ) && ! empty( $post_meta_data['REAL_HOMES_add_in_slider'][0] ) ) {
		$add_in_slider = $post_meta_data['REAL_HOMES_add_in_slider'][0];
	}
}
?>
<div class="field-wrap checkbox-field has-field-dependent">
	<input id="REAL_HOMES_add_in_slider" name="REAL_HOMES_add_in_slider" type="checkbox"<?php checked( $add_in_slider, 'yes'); ?>>
	<label for="REAL_HOMES_add_in_slider"><?php esc_html_e( 'Do you want to add this property in Homepage Slider?', 'framework' ); ?></label>
	<div class="field-dependent">
        <div class="property-slider-image">
            <div id="slider-image-drag-drop" class="slider-image-drag-drop">
                <div class="slider-image-drag-drop-controls">
                    <button type="button" id="select-slider-image" class="btn btn-primary"><?php esc_html_e( 'Upload Image', 'framework' ); ?></button>
                    <span><?php esc_html_e( 'or', 'framework' ); ?></span>
                    <strong><?php esc_html_e( 'Drag and drop image', 'framework' ); ?></strong>
                </div>
                <div class="description">
                    <p><?php esc_html_e( '* The recommended image size is 1970px by 850px.', 'framework' ); ?></p>
                    <p><?php esc_html_e( '* Big or Small image is allowed with same size ratio.', 'framework' ); ?></p>
                </div>
            </div>
            <div id="slider-thumb-container" class="slider-thumb-container">
		        <?php
		        if ( realhomes_dashboard_edit_property() && function_exists( 'rwmb_meta' ) ) {
			        $slider_images = rwmb_meta( 'REAL_HOMES_slider_image', 'type=plupload_image&size=' . 'thumbnail', $target_property->ID );
			        if ( ! empty( $slider_images ) ) {
				        foreach ( $slider_images as $prop_image_id => $prop_image_meta ) {
					        echo '<div class="slider-thumb"><div class="slider-thumb-inner">';
					        echo '<img src="' . esc_url( $prop_image_meta['url'] ) . '" alt="' . esc_attr( $prop_image_meta['title'] ) . '" />';
					        echo '<a class="remove-slider-image" data-property-id="' . esc_attr( $target_property->ID ) . '" data-attachment-id="' . esc_attr( $prop_image_id ) . '" href="#remove-image" ><i class="fas fa-trash-alt"></i></a>';
					        echo '<span class="loader"><i class="fas fa-spinner fa-spin"></i></span>';
					        echo '<input type="hidden" class="slider-image-id" name="slider_image_id" value="' . esc_attr( $prop_image_id ) . '"/>';
					        echo '</div></div>';
				        }
			        }
		        }
		        ?>
            </div>
            <div class="errors-log"></div>
        </div>
	</div>
</div>