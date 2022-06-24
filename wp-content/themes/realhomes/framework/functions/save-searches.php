<?php
/**
 * Functions: Saved Searches.
 *
 * @since   3.13
 * @package rh/functions
 */

if ( ! function_exists( 'inspiry_is_save_search_enabled' ) ) {
	/**
	 * Check if Save Search feature is enabled.
	 */
	function inspiry_is_save_search_enabled() {
		$save_search_enabled = get_option( 'realhomes_saved_searches_enabled', 'yes' );

		if ( 'yes' === $save_search_enabled ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_save_search' ) ) {
	/**
	 * Save search for the alert to the user meta.
	 *
	 * @since  1.13
	 * @return void
	 */
	function inspiry_save_search() {

		if ( is_user_logged_in() && isset( $_POST['nonce'] ) ) {

			$nonce = $_POST['nonce'];

			if ( ! wp_verify_nonce( $nonce, 'inspiry_save_search' ) ) {
				echo wp_json_encode(
					array(
						'success' => false,
						'message' => esc_html__( 'Unverified Nonce!', 'framework' ),
					)
				);
				wp_die();
			}

			global $wpdb, $current_user;

			$user_id     = $current_user->ID;
			$search_args = $_POST['search_args'];
			$search_url  = $_POST['search_url'];
			$table_name  = $wpdb->prefix . 'realhomes_saved_searches';

			$wpdb->insert(
				$table_name,
				array(
					'user_id'              => $user_id,
					'search_wp_query_args' => $search_args,
					'search_query_str'     => $search_url,
					'time'                 => current_time( 'mysql' ),
				),
				array(
					'%d',
					'%s',
					'%s',
					'%s',
					'%s',
				)
			);

			echo wp_json_encode(
				array(
					'success' => true,
					'message' => esc_html__( 'Search is Saved!', 'framework' ),
				)
			);
			wp_die();
		} else {
			echo wp_json_encode(
				array(
					'success' => false,
					'message' => esc_html__( 'Invalid Request!', 'framework' ),
				)
			);
		}
		die;
	}

	add_action( 'wp_ajax_nopriv_inspiry_save_search', 'inspiry_save_search' );
	add_action( 'wp_ajax_inspiry_save_search', 'inspiry_save_search' );
}


if ( ! function_exists( 'inspiry_prepare_save_search_table' ) ) {
	/**
	 * Create required database table to save searches.
	 */
	function inspiry_prepare_save_search_table() {

		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();

		// sql query to create database table.
		$table_name      = $wpdb->prefix . 'realhomes_saved_searches';
		$charset_collate = $wpdb->get_charset_collate();
		$sql_query       = "CREATE TABLE $table_name (
							id mediumint(9) NOT NULL AUTO_INCREMENT,
							user_id mediumint(9) NOT NULL,
							search_wp_query_args longtext NOT NULL,
							search_query_str longtext DEFAULT '' NOT NULL,
							time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
							UNIQUE KEY id (id)
						) $charset_collate;";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql_query );
	}

	add_action( 'admin_head', 'inspiry_prepare_save_search_table' );
}

if ( ! function_exists( 'inspiry_tax_terms_string' ) ) {
	/**
	 * Return taxonomy terms as a single string.
	 *
	 * @param array  $slugs slugs of taxonomy.
	 * @param string $taxonomy_name Taxonomy name.
	 * @return string
	 */
	function inspiry_tax_terms_string( $slugs, $taxonomy_name ) {
		$terms_array = array();
		if ( is_array( $slugs ) && ! empty( $slugs ) ) {
			foreach ( $slugs as $slug ) {
				$term_obj      = get_term_by( 'slug', $slug, $taxonomy_name );
				$terms_array[] = $term_obj->name;
			}

			$result = join( ', ', $terms_array );
			return $result;
		} elseif ( ! empty( $slugs ) ) {
			$term_obj = get_term_by( 'slug', $slugs, $taxonomy_name );
			return $term_obj->name;
		}
		return '';
	}
}

if ( ! function_exists( 'inspiry_delete_saved_search_item' ) ) {
	/**
	 * Save search for the alert to the user meta.
	 *
	 * @since  1.13
	 * @return void
	 */
	function inspiry_delete_saved_search_item() {

		if ( is_user_logged_in() ) {
			global $wpdb, $current_user;
			$user_id        = $current_user->ID;
			$search_item_id = intval( $_POST['search_item_id'] );

			$table_name        = $wpdb->prefix . 'realhomes_saved_searches';
			$saved_search_item = $wpdb->get_row( 'SELECT * FROM ' . $table_name . ' WHERE id = ' . $search_item_id );

			if ( $user_id != $saved_search_item->user_id ) {
				echo wp_json_encode(
					array(
						'success' => false,
						'message' => esc_html__( 'Permissions Denied!', 'framework' ),
					)
				);
				wp_die();
			} else {
				$wpdb->delete( $table_name, array( 'id' => $search_item_id ), array( '%d' ) );
				echo wp_json_encode(
					array(
						'success' => true,
						'message' => esc_html__( 'Search item is deleted successfully!', 'framework' ),
					)
				);
				wp_die();
			}
		}
	}

	add_action( 'wp_ajax_nopriv_inspiry_delete_saved_search_item', 'inspiry_delete_saved_search_item' );
	add_action( 'wp_ajax_inspiry_delete_saved_search_item', 'inspiry_delete_saved_search_item' );
}

/**
 * Cron Job - Send new listing email matching saved searches.
 */
if ( ! function_exists( 'inspiry_init_searches_notification' ) ) {
	/**
	 * Initialze the cron job to notify saved searches.
	 */
	function inspiry_init_searches_notification() {
		$notify_duration = get_option( 'realhomes_search_emails_frequency', 'daily' );
		if ( inspiry_is_save_search_enabled() && ! wp_next_scheduled( 'realhomes_notify_searches' ) || wp_get_schedule( 'realhomes_notify_searches' ) !== $notify_duration ) {
			wp_clear_scheduled_hook( 'realhomes_notify_searches' );
			wp_schedule_event( time(), $notify_duration, 'realhomes_notify_searches' );
		}
	}
	inspiry_init_searches_notification();
}

if ( ! function_exists( 'inspiry_check_new_listing' ) ) {
	/**
	 * Check if new listing is published.
	 */
	function inspiry_check_new_listing() {

		$query_period = inspiry_get_query_period();

		$args = array(
			'post_type'     => 'property',
			'post_status'   => 'publish',
			'post_per_page' => -1,
			'date_query'    => $query_period,
		);

		$properties = new WP_QUERY( $args );

		if ( $properties->have_posts() ) {
			inspiry_send_new_listing_email();
		}
	}
	add_action( 'realhomes_notify_searches', 'inspiry_check_new_listing' );
}

if ( ! function_exists( 'inspiry_get_query_period' ) ) {
	/**
	 * Return formatted query date based on the notify duration.
	 */
	function inspiry_get_query_period() {

		$notify_duration = get_option( 'realhomes_search_emails_frequency', 'daily' );

		if ( 'weekly' === $notify_duration ) {
			$query_period = array(
				array(
					'year' => gmdate( 'Y' ),
					'week' => gmdate( 'W' ),
				),
			);
		} else {
			$current_date = getdate();
			$query_period = array(
				array(
					'year'  => $current_date['year'],
					'month' => $current_date['mon'],
					'day'   => $current_date['mday'],
				),
			);
		}
		return $query_period;
	}
}

if ( ! function_exists( 'inspiry_send_new_listing_email' ) ) {
	/**
	 * Send email notifications about new listing matching user saved searches.
	 */
	function inspiry_send_new_listing_email() {
		global $wpdb;
		$table_name     = $wpdb->prefix . 'realhomes_saved_searches';
		$saved_searches = $wpdb->get_results( 'SELECT * FROM ' . $table_name, OBJECT );

		// Build email subject.
		$default_subject = esc_html__( 'Check Out Latest Properties Matching Your Saved Search Criteria', 'framework' );
		$subject         = get_option( 'realhomes_saved_search_email_subject', $default_subject );
		$subject         = empty( $subject ) ? $default_subject : $subject;

		if ( 0 !== count( $saved_searches ) ) {

			foreach ( $saved_searches as $saved_search ) {

				$args         = unserialize( base64_decode( $saved_search->search_wp_query_args ) );
				$mail_content = inspiry_prepare_mail_template( $args, $saved_search->search_query_str );
				$user_info    = get_userdata( $saved_search->user_id );
				$user_email   = $user_info->user_email;

				if ( ! empty( $user_email ) && ! empty( $mail_content ) ) {

					$headers   = array();
					$headers[] = 'Content-Type: text/html; charset=UTF-8';
					$headers   = apply_filters( 'realhomes_saved_search_mail_header', $headers );
					$subject   = $subject . ' - ' . get_bloginfo( 'name' );

					$email_body = array();
					$email_body = ere_email_template( $mail_content );

					wp_mail( $user_email, $subject, $email_body, $headers );
				}
			}
		}
	}
}

if ( ! function_exists( 'inspiry_prepare_mail_template' ) ) {
	/**
	 * Prepare the template with properties data to send as email notification.
	 *
	 * @param array  $args WP_QUERY arguments.
	 * @param string $url_query Search query of URL.
	 */
	function inspiry_prepare_mail_template( $args, $url_query ) {

		$query_period       = inspiry_get_query_period();
		$args['date_query'] = $query_period;

		$properties   = new WP_QUERY( $args );
		$email_markup = '';

		if ( $properties->have_posts() ) {
			$number_of_properties = $properties->post_count;
			if ( 0 === $number_of_properties % 2 ) {
				$layout = 'even';
			} else {
				$layout = 'odd';
			}

			$email_markup .= '<div class="properties-wrap" style="text-align:center; margin-top: 20px; margin-right: -15px;">';

			$counter = 0;
			while ( $properties->have_posts() ) {
				$properties->the_post();

				if ( 'even' === $layout && ( $counter + 1 === $number_of_properties || $counter + 2 === $number_of_properties ) ) {
					$border_bottom = 'none';
				} elseif ( 'odd' === $layout && $counter + 1 === $number_of_properties ) {
					$border_bottom = 'none';
				} else {
					$border_bottom = '1px solid #dddddd';
				}

				$counter++;

				$email_markup .= '<div style="
					border-bottom: ' . $border_bottom . '; 
					margin-bottom: 15px;
					padding-bottom: 5px; 
					float: left;
					width: 47%;
					overflow: hidden;
					margin-right: 15px;
				">';

				if ( has_post_thumbnail() ) {
					$image_id         = get_post_thumbnail_id();
					$image_attributes = wp_get_attachment_image_src( $image_id, 'property-thumb-image' );
					$image_url        = $image_attributes[0];
				} else {
					$image_url = get_inspiry_image_placeholder_url( 'property-thumb-image' );
				}

				$email_markup .= '<a href="' . get_the_permalink() . '" target="_blank"><img src="' . $image_url . '" width="100%"></a><br>';
				$email_markup .= '<a href="' . get_the_permalink() . '" target="_blank" style="
					text-decoration: none;
					font-size: 15px;
				">' . get_the_title() . '</a>';
				$email_markup .= '<p style="margin:-10px 0 0;color:#1ea69a;font-size:13px;">' . ere_get_property_price() . '</p><br><br>';
				$email_markup .= '</div>';
			}
			$email_markup .= '</div>';
		} else {
			return '';
		}

		// Search results page url.
		$search_page_url    = inspiry_get_search_page_url();
		$search_results_url = $search_page_url . '?' . $url_query;

		// Email template header and footer text.
		$default_header_text = esc_html__( 'Following new properties are listed matching your search criteria. You can check the [search results here].', 'framework' );
		$default_footer_text = esc_html__( 'To stop getting such emails, Simply remove related saved search from your account.', 'framework' );

		$header_text = get_option( 'realhomes_saved_search_email_header', $default_header_text );
		$footer_text = get_option( 'realhomes_saved_search_email_footer', $default_footer_text );

		$header_text = empty( $header_text ) ? $default_header_text : $header_text;
		$footer_text = empty( $footer_text ) ? $default_footer_text : $footer_text;

		$header_text = str_replace( '[', '%1$s', $header_text );
		$header_text = str_replace( ']', '%2$s', $header_text );
		$header_text = sprintf( $header_text, '<a href="' . esc_url( $search_results_url ) . '">', '</a>' );

		$mail_content   = array();
		$mail_content[] = array(
			'name'  => '',
			'value' => $header_text,
		);

		$mail_content[] = array(
			'name'  => '',
			'value' => $email_markup,
		);

		$mail_content[] = array(
			'name'  => '',
			'value' => $footer_text,
		);

		return $mail_content;
	}
}

if ( ! function_exists( 'realhomes_saved_searches_migration' ) ) {
	/**
	 * Migrate saved searches from local to server.
	 */
	function realhomes_saved_searches_migration() {

		/* Ensure user login and data intigrity */
		if ( isset( $_POST['saved_searches'] ) && is_array( $_POST['saved_searches'] ) && is_user_logged_in() ) {

			// Ensure required table is created already otherwise create it.
			inspiry_prepare_save_search_table();

			foreach( $_POST['saved_searches'] as $saved_search ) {
				global $wpdb, $current_user;

				$user_id       = $current_user->ID;
				$wp_query_args = $saved_search['wp_query_args'];
				$query_str     = $saved_search['query_str'];
				$current_date  = $saved_search['time'];
				$table_name    = $wpdb->prefix . 'realhomes_saved_searches';

				$wpdb->insert(
					$table_name,
					array(
						'user_id'              => $user_id,
						'search_wp_query_args' => $wp_query_args,
						'search_query_str'     => $query_str,
						'time'                 => $current_date,
					),
					array(
						'%d',
						'%s',
						'%s',
						'%s',
						'%s',
					)
				);
			}

			echo 'true';
		} else {
			echo 'false';
		}

		die();
	}
	add_action( 'wp_ajax_realhomes_saved_searches_migration', 'realhomes_saved_searches_migration' );
	add_action( 'wp_ajax_nopriv_realhomes_saved_searches_migration', 'realhomes_saved_searches_migration' );
}
