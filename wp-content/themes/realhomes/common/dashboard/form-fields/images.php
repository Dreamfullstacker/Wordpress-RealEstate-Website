<?php
/**
 * Field: Gallery
 *
 * @since    3.0.0
 * @package realhomes/dashboard
 */
global $target_property;

$get_images_count = 0;
if ( isset( $target_property ) ) {
	$images_count = get_post_meta( $target_property->ID, 'REAL_HOMES_property_images', false );
	if ( ! empty( $images_count ) ) {
		$get_images_count = count( array_filter( $images_count ) );
	}
}

$inspiry_submit_max_number_images = get_option( 'inspiry_submit_max_number_images', 48 );
?>
<div class="property-gallery-images">
    <label><?php esc_html_e( 'Property Images', 'framework' ); ?></label>
    <div id="gallery-thumbs-container" class="gallery-thumbs-container"><?php
		if ( realhomes_dashboard_edit_property() && function_exists( 'rwmb_meta' ) ) {
			$thumbnail_size    = 'thumbnail';
			$properties_images = rwmb_meta( 'REAL_HOMES_property_images', 'type=plupload_image&size=' . $thumbnail_size, $target_property->ID );
			$featured_image_id = get_post_thumbnail_id( $target_property->ID );
			if ( ! empty( $properties_images ) ) {
				foreach ( $properties_images as $prop_image_id => $prop_image_meta ) {
					$is_featured_image = ( $featured_image_id == $prop_image_id );
					$featured_icon     = ( $is_featured_image ) ? 'fas fa-star' : ' far fa-star';
					echo '<div class="gallery-thumb"><div class="gallery-thumb-inner">';
					echo '<img src="' . esc_url( $prop_image_meta['url'] ) . '" alt="' . esc_attr( $prop_image_meta['title'] ) . '" />';
					echo '<a class="remove-image" data-property-id="' . esc_attr( $target_property->ID ) . '" data-attachment-id="' . esc_attr( $prop_image_id ) . '" href="#remove-image" ><i class="fas fa-trash-alt"></i></a>';
					echo '<a class="mark-featured" data-property-id="' . esc_attr( $target_property->ID ) . '" data-attachment-id="' . esc_attr( $prop_image_id ) . '" href="#mark-featured" ><i class=" ' . esc_attr( $featured_icon ) . '"></i></a>';
					echo '<span class="loader"><i class="fas fa-spinner fa-spin"></i></span>';
					echo '<input type="hidden" class="gallery-image-id" name="gallery_image_ids[]" value="' . esc_attr( $prop_image_id ) . '"/>';
					if ( $is_featured_image ) {
						echo '<input type="hidden" class="featured-img-id" name="featured_image_id" value="' . esc_attr( $prop_image_id ) . '"/>';
					}
					echo '</div></div>';
				}
			}
		}
		?></div>
    <div id="drag-drop-container" class="drag-drop-container" data-max-images="<?php echo esc_attr( $inspiry_submit_max_number_images ); ?>">
        <div class="limit-left">
            <span class="uploaded"><?php echo esc_html( $get_images_count ); ?></span>/<?php echo esc_html( $inspiry_submit_max_number_images ); ?>
        </div>
        <i class="fas fa-cloud-upload-alt"></i>
        <strong><?php printf( esc_html__( 'Drag and drop up to %s images', 'framework' ), esc_html( $inspiry_submit_max_number_images ) ); ?></strong>
        <span><?php esc_html_e( 'or', 'framework' ); ?></span>
        <button type="button" id="select-images" class="btn btn-primary"><?php esc_html_e( 'Browse Images', 'framework' ); ?></button>
        <div class="description">
            <p><?php esc_html_e( '* Minimum required size is 1240px by 720px having 4:3 or 16:9 aspect ratio.', 'framework' ); ?></p>
            <p><?php esc_html_e( '* Mark an image as featured by clicking the star icon, otherwise first image will be considered featured image.', 'framework' ); ?></p>
        </div>
    </div>
    <span class="max-files-limit-message"><?php esc_html_e( 'You have reached maximum files upload limit.', 'framework' ); ?></span>
    <div id="errors-log"></div>
</div>

<div class="field-wrap checkbox-field has-field-dependent">
	<?php
	$settings_labels = array(
		'thumb-on-right'  => esc_html__( 'Default Gallery', 'framework' ),
		'thumb-on-bottom' => esc_html__( 'Gallery with Thumbnails', 'framework' ),
	);

	if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
		$settings_labels['thumb-on-right']  = esc_html__( 'Gallery with Thumbnails on Right', 'framework' );
		$settings_labels['thumb-on-bottom'] = esc_html__( 'Gallery with Thumbnails on Bottom', 'framework' );
	}

	$change_gallery_slider_type = '0';
	$gallery_slider_type        = 'thumb-on-bottom';
	if ( realhomes_dashboard_edit_property() ) {
		global $post_meta_data;
		if ( isset( $post_meta_data['REAL_HOMES_change_gallery_slider_type'] ) && ! empty( $post_meta_data['REAL_HOMES_change_gallery_slider_type'][0] ) ) {
			$change_gallery_slider_type = $post_meta_data['REAL_HOMES_change_gallery_slider_type'][0];
		}

		if ( isset( $post_meta_data['REAL_HOMES_gallery_slider_type'] ) && ! empty( $post_meta_data['REAL_HOMES_gallery_slider_type'][0] ) ) {
			$gallery_slider_type = $post_meta_data['REAL_HOMES_gallery_slider_type'][0];
		}
	}
	?>
    <input id="REAL_HOMES_change_gallery_slider_type" name="REAL_HOMES_change_gallery_slider_type" type="checkbox"<?php checked( $change_gallery_slider_type, '1'); ?>>
    <label for="REAL_HOMES_change_gallery_slider_type"><?php esc_html_e( 'Change Gallery Type', 'framework' ); ?></label>
    <div class="field-dependent">
        <label><?php esc_html_e( 'Gallery Type You Want to Use', 'framework' ); ?></label>
        <ul class="list-unstyled">
            <li class="radio-field">
                <input id="REAL_HOMES_gallery_slider_type_thumb-on-right" type="radio" name="REAL_HOMES_gallery_slider_type" value="thumb-on-right"<?php checked( $gallery_slider_type, 'thumb-on-right'); ?> />
                <label for="REAL_HOMES_gallery_slider_type_thumb-on-right"><?php echo esc_html( $settings_labels['thumb-on-right'] ); ?></label>
            </li>
            <li class="radio-field">
                <input id="REAL_HOMES_gallery_slider_type_thumb-on-bottom" type="radio" name="REAL_HOMES_gallery_slider_type" value="thumb-on-bottom"<?php checked( $gallery_slider_type, 'thumb-on-bottom'); ?> />
                <label for="REAL_HOMES_gallery_slider_type_thumb-on-bottom"><?php echo esc_html( $settings_labels['thumb-on-bottom'] ); ?></label>
            </li>
        </ul>
    </div>
</div>

