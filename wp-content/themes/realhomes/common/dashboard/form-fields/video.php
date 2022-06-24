<div class="inspiry-repeater-wrapper">
    <label class="label-boxed"><?php esc_html_e( 'Add Multiple Videos', 'framework' ); ?></label>
    <div class="inspiry-repeater-header">
        <p class="title"><?php esc_html_e( 'Title', 'framework' ); ?></p>
        <p class="value">
            <?php esc_html_e( 'Virtual Tour Video URL', 'framework' ); ?>
            <span class="note"><?php esc_html_e( 'YouTube, Vimeo, SWF File and MOV File are supported', 'framework' ); ?></span>
        </p>
    </div>
    <div id="inspiry-repeater-container-video-group" class="inspiry-repeater-container">
		<?php
		$inspiry_video_group_image_fields = '';
		$inspiry_video_group_fields       = array(
			array( 'name' => 'inspiry_video_group[0][inspiry_video_group_title]' ),
			array( 'name' => 'inspiry_video_group[0][inspiry_video_group_url]' )
		);

		if ( realhomes_dashboard_edit_property() ) {
			global $target_property;

			// Migrate property video url from old metabox to new.
			$previous_video_url = get_post_meta( $target_property->ID, 'REAL_HOMES_tour_video_url', true );
			if ( ! empty( $previous_video_url ) ) {
				$inspiry_video_group = array( array( 'inspiry_video_group_url' => esc_url_raw( $previous_video_url ) ) );
				if ( update_post_meta( $target_property->ID, 'inspiry_video_group', $inspiry_video_group ) ) {
					delete_post_meta( $target_property->ID, 'REAL_HOMES_tour_video_url' );
				}
			}

			$inspiry_video_group = get_post_meta( $target_property->ID, 'inspiry_video_group', true );
			if ( ! empty( $inspiry_video_group ) ) {
				// Remove empty values.
				$inspiry_video_group = array_filter( $inspiry_video_group );
			}

			if ( ! empty( $inspiry_video_group ) ) {
				foreach ( $inspiry_video_group as $key => $video_group ) {
					$inspiry_video_group_fields[0]['name'] = 'inspiry_video_group[' . $key . '][inspiry_video_group_title]';
					$inspiry_video_group_fields[1]['name'] = 'inspiry_video_group[' . $key . '][inspiry_video_group_url]';
					$inspiry_video_group_fields[0]['value'] = isset( $video_group['inspiry_video_group_title'] ) ? esc_html( $video_group['inspiry_video_group_title'] ) : '';
					$inspiry_video_group_fields[1]['value'] = isset( $video_group['inspiry_video_group_url'] ) ? esc_url( $video_group['inspiry_video_group_url'] ) : '';
					inspiry_repeater_group( $inspiry_video_group_fields, false, $key );

					if ( isset( $video_group['inspiry_video_group_image'] ) ) {
						$video_group_image = is_array( $video_group['inspiry_video_group_image'] ) ? $video_group['inspiry_video_group_image'][0] : $video_group['inspiry_video_group_image'];
						$inspiry_video_group_image_fields .= sprintf( '<input type="hidden" name="inspiry_video_group[%s][inspiry_video_group_image]" value="%s">', esc_html( $key ), esc_html( $video_group_image ) );
					}
				}
			} else {
				inspiry_repeater_group( $inspiry_video_group_fields );
			}
		} else {
			inspiry_repeater_group( $inspiry_video_group_fields );
		}
		?>
    </div>
    <?php
    // Print image fields here to avoid ordering issue.
    if ( ! empty( $inspiry_video_group_image_fields ) ) {
	    echo $inspiry_video_group_image_fields;
    }
    ?>
    <button class="inspiry-repeater-add-field-btn btn btn-primary"><i
                class="fas fa-plus"></i><?php esc_attr_e( 'Add More', 'framework' ); ?></button>
</div>