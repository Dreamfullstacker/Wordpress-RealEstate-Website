<?php
if ( ! function_exists( 'inspiry_remove_my_property' ) ) {
	/**
	 * Remove my property
	 */
	function inspiry_remove_my_property() {
		if ( isset( $_POST[ 'property_id' ] ) ) {
			$property_id = intval( $_POST[ 'property_id' ] );
			if ( $property_id > 0 ) {
				if ( is_user_logged_in() ) {
					$trashed_post = wp_trash_post( $property_id );
					if ( $trashed_post ) {

						// WPML Related Code
						// Check if WPML is active
						if( class_exists( 'SitePress' ) ) {
							// Get active languages configured in WPML - https://wpml.org/wpml-hook/wpml_active_languages/
							$active_languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
							if ( ! empty( $active_languages ) ) {
								// loop through languages
								foreach ( $active_languages as $language ) {
									// get translated property ID if any for current language in loop - https://wpml.org/wpml-hook/wpml_object_id/
									$translated_property_id = apply_filters( 'wpml_object_id', $property_id, 'property', false, $language[ 'language_code' ] );
									if ( $translated_property_id && ( $translated_property_id != $property_id ) ) {
										// trash translated property
										wp_trash_post( $translated_property_id );
									}
								}
							}
						}

						echo json_encode( array(
								'success' => true,
								'message' => esc_html__( "Property Removed Successfully!", 'framework' )
							)
						);
						die;
					} else {
						echo json_encode( array(
								'success' => false,
								'message' => esc_html__( "Failed to Remove Property!", 'framework' )
							)
						);
						die;
					}
				}
			}
		}

		echo json_encode( array(
				'success' => false,
				'message' => esc_html__( "Invalid Parameters!", 'framework' )
			)
		);
		die;
	}

	add_action( 'wp_ajax_remove_my_property', 'inspiry_remove_my_property' );
	//add_action( 'wp_ajax_nopriv_remove_my_property', 'inspiry_remove_my_property' );
}