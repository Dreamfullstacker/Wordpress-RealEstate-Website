<?php
/**
 * This file contains functions related to submit property template
 */
if ( ! function_exists( 'inspiry_attachment_upload' ) ) {
	/**
	 * Ajax attachments upload for property submit and update
	 */
	function inspiry_attachment_upload() {

		// Verify Nonce
		$nonce = $_REQUEST['nonce'];
		if ( ! wp_verify_nonce( $nonce, 'inspiry_allow_upload' ) ) {
			$ajax_response = array(
				'success' => false,
				'reason'  => esc_html__( 'Security check failed!', 'framework' ),
			);
			echo wp_json_encode( $ajax_response );
			die;
		}

		$file   = $_FILES['inspiry_upload_file'];
		$upload = wp_handle_upload( $file, array( 'test_form' => false ) );

		if ( isset( $upload['error'] ) ) {
			$ajax_response = array(
				'success' => false,
				'reason'  => esc_html__( 'Attachment upload failed!', 'framework' )
			);
			echo wp_json_encode( $ajax_response );
			die;
		}

		$attachment_details = array(
			'post_title'     => wp_basename( $file['name'] ),
			'post_content'   => $upload['url'],
			'post_mime_type' => $upload['type'],
			'guid'           => $upload['url'],
			'post_status'    => 'inherit'
		);

		$attach_id   = wp_insert_attachment( $attachment_details, $upload['file'] );
		$attach_data = wp_generate_attachment_metadata( $attach_id, $upload['file'] );

		if ( ! empty( $attach_data ) ) {
			wp_update_attachment_metadata( $attach_id, $attach_data );
		}

		$ajax_response = array(
			'success'       => true,
			'attachment_id' => $attach_id,
			'type'          => $upload['type'],
			'post_title'    => get_the_title( $attach_id ),
		);
		echo wp_json_encode( $ajax_response );
		die;
	}

	add_action( 'wp_ajax_ajax_attachment_upload', 'inspiry_attachment_upload' ); // only for logged in user

	if ( inspiry_guest_submission_enabled() ) {
		add_action( 'wp_ajax_nopriv_ajax_attachment_upload', 'inspiry_attachment_upload' );
	}
}

if ( ! function_exists( 'inspiry_image_upload' ) ) {
	/**
	 * Ajax image upload for property submit and update
	 */
	function inspiry_image_upload() {

		// Verify Nonce
		$nonce = $_REQUEST['nonce'];
		if ( ! wp_verify_nonce( $nonce, 'inspiry_allow_upload' ) ) {
			$ajax_response = array(
				'success' => false,
				'reason'  => esc_html__( 'Security check failed!', 'framework' ),
			);
			echo json_encode( $ajax_response );
			die;
		}

		$submitted_file = $_FILES['inspiry_upload_file'];
		$uploaded_image = wp_handle_upload( $submitted_file, array( 'test_form' => false ) );   //Handle PHP uploads in WordPress, sanitizing file names, checking extensions for mime type, and moving the file to the appropriate directory within the uploads directory.

		if ( isset( $uploaded_image['file'] ) ) {
			$file_name = basename( $submitted_file['name'] );
			$file_type = wp_check_filetype( $uploaded_image['file'] );   // Retrieve the file type from the file name.

			if ( preg_match( '!^image/!', $file_type['type'] ) && file_is_displayable_image( $uploaded_image['file'] ) ) {

				// Prepare an array of post data for the attachment.
				$attachment_details = array(
					'guid'           => $uploaded_image['url'],
					'post_mime_type' => $file_type['type'],
					'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $file_name ) ),
					'post_content'   => '',
					'post_status'    => 'inherit'
				);
				$attach_id          = wp_insert_attachment( $attachment_details, $uploaded_image['file'] );     // This function inserts an attachment into the media library
				$attach_data        = wp_generate_attachment_metadata( $attach_id, $uploaded_image['file'] ); // This function generates metadata for an image attachment. It also creates a thumbnail and other intermediate sizes of the image attachment based on the sizes defined

				if ( ! empty( $attach_data ) ) {
					wp_update_attachment_metadata( $attach_id, $attach_data ); // Update metadata for an attachment.

					if ( isset( $_REQUEST['size'] ) ) {
						$thumbnail_url = inspiry_get_thumbnail_url( $attach_data, $_REQUEST['size'] );
					} else {
						$thumbnail_url = inspiry_get_thumbnail_url( $attach_data );
					}

					$ajax_response = array( 'success' => true, 'url' => $thumbnail_url, 'attachment_id' => $attach_id );
					echo json_encode( $ajax_response );
					die;
				}
			} else {
				$ajax_response = array(
					'success' => false,
					'reason'  => esc_html__( 'Invalid image format!', 'framework' )
				);
				echo json_encode( $ajax_response );
				die;
			}
		} else {
			$ajax_response = array( 'success' => false, 'reason' => esc_html__( 'Image upload failed!', 'framework' ) );
			echo json_encode( $ajax_response );
			die;
		}
	}

	add_action( 'wp_ajax_ajax_img_upload', 'inspiry_image_upload' ); // only for logged in user

	if ( inspiry_guest_submission_enabled() ) {
		add_action( 'wp_ajax_nopriv_ajax_img_upload', 'inspiry_image_upload' );
	}
}

if ( ! function_exists( 'inspiry_get_thumbnail_url' ) ) {
	/**
	 * Get thumbnail url based on attachment data
	 *
	 * @param $attach_data
	 * @param $size
	 *
	 * @return string
	 */
	function inspiry_get_thumbnail_url( $attach_data, $size = 'thumbnail' ) {
		$upload_dir = wp_upload_dir();

		if ( 'full' === $size ) {
			return $upload_dir['baseurl'] . '/' . $attach_data['file'];
		}

		$image_path_array = explode( '/', $attach_data['file'] );
		$image_path_array = array_slice( $image_path_array, 0, count( $image_path_array ) - 1 );
		$image_path       = implode( '/', $image_path_array );
		$thumbnail_name   = $attach_data['sizes'][ $size ]['file'];

		return $upload_dir['baseurl'] . '/' . $image_path . '/' . $thumbnail_name;
	}
}

if ( ! function_exists( 'inspiry_remove_gallery_image' ) ) {
	/**
	 * Property Submit Form - Gallery Image Removal
	 */
	function inspiry_remove_gallery_image() {

		// Verify Nonce
		$nonce = $_POST['nonce'];
		if ( ! wp_verify_nonce( $nonce, 'inspiry_allow_upload' ) ) {
			$ajax_response = array(
				'post_meta_removed'  => false,
				'attachment_removed' => false,
				'reason'             => esc_html__( 'Security check failed!', 'framework' )
			);
			echo json_encode( $ajax_response );
			die;
		}

		$post_meta_removed  = false;
		$attachment_removed = false;

		// Default Meta Key
		$meta_key = 'REAL_HOMES_property_images';
		if ( isset( $_POST['meta_key'] ) && ! empty( $_POST['meta_key'] ) ) {
			$meta_key = $_POST['meta_key'];
		}

		if ( isset( $_POST['property_id'] ) && isset( $_POST['attachment_id'] ) ) {
			$property_id   = intval( $_POST['property_id'] );
			$attachment_id = intval( $_POST['attachment_id'] );
			if ( $property_id > 0 && $attachment_id > 0 ) {
				$post_meta_removed  = delete_post_meta( $property_id, $meta_key, $attachment_id );
				$attachment_removed = wp_delete_attachment( $attachment_id );
			} else if ( $attachment_id > 0 ) {
				if ( false === wp_delete_attachment( $attachment_id ) ) {
					$attachment_removed = false;
				} else {
					$attachment_removed = true;
				}
			}
		}

		$ajax_response = array(
			'post_meta_removed'  => $post_meta_removed,
			'attachment_removed' => $attachment_removed,
		);

		echo json_encode( $ajax_response );
		die;

	}

	add_action( 'wp_ajax_remove_gallery_image', 'inspiry_remove_gallery_image' );

	if ( inspiry_guest_submission_enabled() ) {
		add_action( 'wp_ajax_nopriv_remove_gallery_image', 'inspiry_remove_gallery_image' );
	}
}

if ( ! function_exists( 'insert_attachment' ) ) {
	/**
	 * Insert Attachment Method for Property Submit Template
	 *
	 * @param $file_handler
	 * @param $post_id
	 * @param bool|false $setthumb
	 *
	 * @return int|WP_Error
	 */
	function insert_attachment( $file_handler, $post_id, $setthumb = false ) {

		// check to make sure its a successful upload
		if ( $_FILES[ $file_handler ]['error'] !== UPLOAD_ERR_OK ) {
			__return_false();
		}

		require_once( ABSPATH . "wp-admin" . '/includes/image.php' );
		require_once( ABSPATH . "wp-admin" . '/includes/file.php' );
		require_once( ABSPATH . "wp-admin" . '/includes/media.php' );

		$attach_id = media_handle_upload( $file_handler, $post_id );

		if ( $setthumb ) {
			update_post_meta( $post_id, '_thumbnail_id', $attach_id );
		}

		return $attach_id;
	}
}

if ( ! function_exists( 'realhomes_edit_form_hierarchical_options' ) ) {
	/**
	 * Property Edit Form Hierarchical Taxonomy Options
	 *
	 * @param $property_id
	 * @param $taxonomy_name
	 */
	function realhomes_edit_form_hierarchical_options( $property_id, $taxonomy_name ) {
		if ( ! $property_id || ! class_exists( 'ERE_Data' ) ) {
			return;
		}

		// Collect existing term ids in an array
		$existing_terms_ids = array();
		$property_existing_terms = get_the_terms( $property_id, $taxonomy_name );
		if ( ! empty( $property_existing_terms ) && ! is_wp_error( $property_existing_terms ) ) {
			foreach ( $property_existing_terms as $existing_term ) {
				$existing_terms_ids[] = $existing_term->term_id;
			}
		}

		// Add None option
		if ( empty( $existing_terms_ids ) ) {
			echo '<option value="-1" selected="selected">' . esc_html__( 'None', 'framework' ) . '</option>';
		} else {
			echo '<option value="-1">' . esc_html__( 'None', 'framework' ) . '</option>';
		}

		// Add remaining options
		$hierarchical_terms = array();
		if ( 'property-type' == $taxonomy_name ) {
			$hierarchical_terms = ERE_Data::get_hierarchical_property_types();
		}
		if ( 'property-status' == $taxonomy_name ) {
			$hierarchical_terms = ERE_Data::get_hierarchical_property_statuses();
		}

		realhomes_id_based_hierarchical_options( $hierarchical_terms, $existing_terms_ids );
	}
}