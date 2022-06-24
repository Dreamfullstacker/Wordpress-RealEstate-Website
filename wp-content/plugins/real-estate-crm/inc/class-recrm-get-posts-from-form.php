<?php

if ( ! class_exists( 'RECRM_get_posts_from_form' ) ) {

	/**
	 * Get field values from contact/agent form generate post and update post meta for contact/enquiry custom post types
	 *
	 * Insert comments as communication history in contact/enquiry custom post types
	 */
	class RECRM_get_posts_from_form {

		public function __construct() {
			add_action( 'inspiry_after_contact_form_submit', array( $this, 'save_contact_form_to_contact_cpt' ) );
			add_action( 'inspiry_after_agent_form_submit', array( $this, 'save_contact_form_to_contact_cpt' ) );
			add_action( 'rhea_after_inquiry_form_submit', array( $this, 'save_contact_form_to_contact_cpt' ) );
		}

		public function save_contact_form_to_contact_cpt() {

			$contact_title = '';
			if ( isset( $_POST['name'] ) ) {
				$contact_title = sanitize_text_field( $_POST['name'] );
			}

			$contact_enquiry_message = '';
			if ( isset( $_POST['message'] ) ) {
				$contact_enquiry_message = sanitize_textarea_field( $_POST['message'] );
			}

			$contact_email = '';
			if ( isset( $_POST['email'] ) ) {
				$contact_email = sanitize_email( $_POST['email'] );
			}

			$contact_number = '';
			if ( isset( $_POST['number'] ) ) {
				$contact_number = sanitize_text_field( $_POST['number'] );
			} elseif ( isset( $_POST['phone'] ) ) {
				$contact_number = sanitize_text_field( $_POST['phone'] );
			}

			$home_phone = '';
			if(isset($_POST['home'])){
				$home_phone = $_POST['home'];
			}
			$work_phone = '';
			if(isset($_POST['work'])){
				$work_phone = $_POST['work'];
			}
			$country = '';
			if(isset($_POST['country'])){
				$country = $_POST['country'];
			}
			$address = '';
			if(isset($_POST['address'])){
				$address = $_POST['address'];
			}
			$city = '';
			if(isset($_POST['city'])){
				$city = $_POST['city'];
			}
			$state = '';
			if ( isset( $_POST['state'] ) ) {
				$state = $_POST['state'];
			}
			$zip = '';
			if ( isset( $_POST['zip'] ) ) {
				$zip = $_POST['zip'];
			}
			$source = '';
			if ( isset( $_POST['source'] ) ) {
				$source = $_POST['source'];
			}
			$prefix = '';
			if ( isset( $_POST['prefix'] ) ) {
				$prefix = $_POST['prefix'];
			}


			$property_id = '';
			if ( isset( $_POST['property_id'] ) ) {
				$property_id = sanitize_text_field( $_POST['property_id'] );
			}
			$property_title = '';
			if ( isset( $_POST['property_title'] ) ) {
				$property_title = sanitize_text_field( $_POST['property_title'] );
			}

			$property_url = '';
			if ( isset( $_POST['property_permalink'] ) ) {
				$property_url = sanitize_text_field( $_POST['property_permalink'] );
			}

			$agent_id = '';
			if ( isset( $_POST['agent_id'] ) ) {
				$agent_id = sanitize_text_field( $_POST['agent_id'] );
			}


			$author_name = '';
			if ( isset( $_POST['author_name'] ) ) {
				$author_name = sanitize_text_field( $_POST['author_name'] );
			}

			$author_id = '';
			if ( isset( $_POST['author_id'] ) ) {
				$author_id = sanitize_text_field( $_POST['author_id'] );
			}

			$agent_name = '';
			if ( isset( $_POST['agent-name'] ) ) {
				$agent_name = sanitize_text_field( $_POST['agent-name'] );
			}


			$contact_statuses = RECRM_meta_boxes::select_options(
				RECRM_meta_boxes::get_option( 'recrm_contact_status_settings', 'recrm_settings', esc_html__( 'Lead,Customer', 'real-estate-crm' ) )
			);

			$set_status       = '';
			if ( is_array( $contact_statuses ) && ! empty( $contact_statuses ) ) {
				$set_status = $contact_statuses[0];
			}

			$enquiry_status     = RECRM_meta_boxes::select_options(
				RECRM_meta_boxes::get_option( 'recrm_enquiry_status_settings', 'recrm_settings', esc_html__( 'Open, Close', 'real-estate-crm' ) )
			);
			$set_enquiry_status = '';
			if ( is_array( $enquiry_status ) && ! empty( $enquiry_status ) ) {
				$set_enquiry_status = $enquiry_status[0];
			}

			$contact_source = RECRM_meta_boxes::select_options(
				RECRM_meta_boxes::get_option( 'recrm_contact_source_settings', 'recrm_settings', esc_html__( 'Website, Word of Mouth, Newspaper, Friend', 'real-estate-crm' ) )
			);

			$set_source     = '';
			if ( is_array( $contact_source ) && ! empty( $contact_source ) ) {
				$set_source = $contact_source[0];
			}

			if ( ! isset( $commentdata['comment_agent'] ) ) {
				$commentdata['comment_agent'] = isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '';
			}
			if ( empty( $commentdata['comment_date'] ) ) {
				$commentdata['comment_date'] = current_time( 'mysql' );
			}

			if ( empty( $commentdata['comment_date_gmt'] ) ) {
				$commentdata['comment_date_gmt'] = current_time( 'mysql', 1 );
			}


			$commentdata['comment_agent'] = substr( $commentdata['comment_agent'], 0, 254 );


			$meta_args = array(
				'post_type'      => 'contact',
				'posts_per_page' => - 1,
				'meta_query'     => array(
					array(
						'key'     => 'recrm_contact_email',
						'value'   => $contact_email,
						'compare' => '=',
					)
				)
			);

			$get_posts = get_posts( $meta_args );
			if ( $get_posts ) {
				foreach ( $get_posts as $get_post ) {
					$get_id = $get_post->ID;
				}
			}

			if ( ! empty( $get_id ) ) {

				$contact_post_id = $get_id;

				$data = array(
					'comment_post_ID'      => $get_id,
					'comment_author'       => $contact_title,
					'comment_author_email' => $contact_email,
					'comment_content'      => $contact_enquiry_message,
					'comment_agent'        => $commentdata['comment_agent'],
					'comment_date'         => $commentdata['comment_date'],
					'comment_date_gmt'     => $commentdata['comment_date_gmt'],
					'comment_approved'     => 1,
				);

				// Insert the comment into the database
				wp_insert_comment( $data );

			} else {

				$name       = $contact_title;
				$parts      = explode( " ", $name );
				$first_name = array_shift( $parts );
				$last_name  = implode( " ", $parts );

				$args    = array(
					'post_type'   => 'contact',
					'post_status' => 'publish',
					'post_title'  => esc_html( $contact_title ),

				);

				$contact_post_id = wp_insert_post( $args );

				if ( ! is_wp_error( $contact_post_id ) ) {

					update_post_meta( $contact_post_id, 'recrm_contact_id', $contact_post_id );
					update_post_meta( $contact_post_id, 'recrm_contact_email', $contact_email );
					update_post_meta( $contact_post_id, 'recrm_contact_mobile', $contact_number );
					update_post_meta( $contact_post_id, 'recrm_contact_home_phone', $home_phone );
					update_post_meta( $contact_post_id, 'recrm_contact_work_phone', $work_phone );
					update_post_meta( $contact_post_id, 'recrm_contact_country', $country );
					update_post_meta( $contact_post_id, 'recrm_contact_address', $address );
					update_post_meta( $contact_post_id, 'recrm_contact_city', $city );
					update_post_meta( $contact_post_id, 'recrm_contact_state', $state );
					update_post_meta( $contact_post_id, 'recrm_contact_zip_code', $zip );
					update_post_meta( $contact_post_id, 'recrm_contact_source', $source );
					update_post_meta( $contact_post_id, 'recrm_contact_status', $set_status );
					update_post_meta( $contact_post_id, 'recrm_contact_prefix', $prefix );
					update_post_meta( $contact_post_id, 'recrm_contact_first_name', $first_name );
					update_post_meta( $contact_post_id, 'recrm_contact_last_name', $last_name );


					$data = array(
						'comment_post_ID'      => $contact_post_id,
						'comment_author'       => $contact_title,
						'comment_author_email' => $contact_email,
						'comment_content'      => $contact_enquiry_message,
						'comment_agent'        => $commentdata['comment_agent'],
						'comment_date'         => $commentdata['comment_date'],
						'comment_date_gmt'     => $commentdata['comment_date_gmt'],
						'comment_approved'     => 1,
					);

					// Insert the comment into the database
					wp_insert_comment( $data );
				}

			}

			$enq_args = array(
				'post_type'    => 'enquiry',
				'post_status'  => 'publish',
				'post_content' => $contact_enquiry_message,
			);


			$post_id_enquiry = wp_insert_post( $enq_args );

			if ( ! is_wp_error( $post_id_enquiry ) ) {

				// Adding auto generated title based on enquiry ID will help in searching enquiry using ID
				wp_update_post( array(
					'ID'           => $post_id_enquiry,
					'post_title'   => 'Enquiry# ' . $post_id_enquiry,
				) );

				update_post_meta( $post_id_enquiry, 'recrm_contact_enquiry_id', $contact_post_id );
				update_post_meta( $post_id_enquiry, 'recrm_enquiry_id', $post_id_enquiry );
				update_post_meta( $post_id_enquiry, 'recrm_enquiry_property_title', $property_title );
				update_post_meta( $post_id_enquiry, 'recrm_enquiry_property_url', $property_url );
				update_post_meta( $post_id_enquiry, 'recrm_enquiry_name', $contact_title );
				update_post_meta( $post_id_enquiry, 'recrm_enquiry_email', $contact_email );
				update_post_meta( $post_id_enquiry, 'recrm_enquiry_phone', $contact_number );
				update_post_meta( $post_id_enquiry, 'recrm_enquiry_status', $set_enquiry_status );
				update_post_meta( $post_id_enquiry, 'recrm_enquiry_source', $set_source );
				update_post_meta( $post_id_enquiry, 'recrm_enquiry_property_id', $property_id );
				update_post_meta( $post_id_enquiry, 'recrm_enquiry_agent_id', $agent_id );
				update_post_meta( $post_id_enquiry, 'recrm_enquiry_author_name', $author_name );
				update_post_meta( $post_id_enquiry, 'recrm_enquiry_author_id', $author_id );
				update_post_meta( $post_id_enquiry, 'recrm_acf_agent_name', $agent_name );

			}

		}

	}

	new RECRM_get_posts_from_form();
}

