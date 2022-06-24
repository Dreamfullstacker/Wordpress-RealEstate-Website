<?php
if ( ! function_exists( 'realhomes_count_posts' ) ) {
	/**
	 * Count number of posts of a post type for user.
	 *
	 * @since 3.12
	 *
	 * @global wpdb $wpdb WordPress database abstraction object.
	 *
	 * @param string $type Optional. Post type to retrieve count. Default 'property'.
	 *
	 * @return object Number of posts for each status.
	 */
	function realhomes_count_posts( $type = 'property' ) {
		global $wpdb;

		if ( ! post_type_exists( $type ) ) {
			return new stdClass;
		}

		$query = "SELECT post_status, COUNT( * ) AS num_posts FROM {$wpdb->posts} WHERE post_type = %s";
		$query .= $wpdb->prepare( " AND post_author = %d", get_current_user_id() );
		$query .= ' GROUP BY post_status';

		$results = (array) $wpdb->get_results( $wpdb->prepare( $query, $type ), ARRAY_A );
		$counts  = array_fill_keys( get_post_stati(), 0 );

		foreach ( $results as $row ) {
			$counts[ $row['post_status'] ] = $row['num_posts'];
		}

		return (object) $counts;
	}
}

if ( ! function_exists( 'realhomes_count_featured_properties' ) ) {
	/**
	 * Counts number of featured properties for current user.
	 *
	 * @since 3.12
	 *
	 * @return string
	 */
	function realhomes_count_featured_properties() {
		global $wpdb;

		$query = " 
		SELECT COUNT( * ) AS featured_properties_count 
		FROM {$wpdb->posts}, {$wpdb->postmeta} 
		WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id
		AND $wpdb->posts.post_status = 'publish'
		AND $wpdb->posts.post_author = %d
		AND $wpdb->posts.post_type = %s
		AND $wpdb->postmeta.meta_key = %s 
		AND $wpdb->postmeta.meta_value = %s";

		$results = $wpdb->get_results( $wpdb->prepare( $query, get_current_user_id(), 'property', 'REAL_HOMES_featured', '1' ) );

		return $results[0]->featured_properties_count;
	}
}

if ( ! function_exists( 'realhomes_get_favorite_pro_ids' ) ) {
	/**
	 * Returns the favorite properties ids.
	 *
	 * @since 3.12
	 *
	 * @return array|bool
	 */
	function realhomes_get_favorite_pro_ids() {

		if ( is_user_logged_in() ) {
			$user_id    = wp_get_current_user()->ID;
			$properties = get_user_meta( $user_id, 'favorite_properties' );

			if ( ! empty( $properties ) && is_array( $properties ) ) {

				$favorite_properties = array();
				// Build a list of favorite properties excluding trashed/deleted properties.
				foreach ( $properties as $property_id ) {

					if ( 'publish' === get_post_status( $property_id ) ) {
						$favorite_properties[] = $property_id;
					}
				}

				if ( ! empty( $favorite_properties ) ) {
					return $favorite_properties;
				}
			}
		}

		return false;
	}
}

if ( ! function_exists( 'realhomes_get_template_permalink' ) ) {
	/**
	 * Retrieves the template permalink.
	 *
	 * @since 3.12
	 *
	 * @param $template
	 *
	 * @return string
	 */
	function realhomes_get_template_permalink( $template ) {

		$pages = get_pages( array(
			'meta_key'   => '_wp_page_template',
			'meta_value' => $template
		) );

		if ( $pages ) {
			return get_permalink( $pages[0]->ID );
		}

		return home_url( '/' );
	}

}

if ( ! function_exists( 'realhomes_get_dashboard_page_url' ) ) {
	/**
	 * Returns the dashboard page url.
	 *
	 * @since 3.12
	 *
	 * @param string $module
	 * @param array $args
	 *
	 * @return string
	 */
	function realhomes_get_dashboard_page_url( $module = '', $args = array() ) {

		$dashboard_page_id = get_option( 'inspiry_dashboard_page' );

		if ( ! empty( $dashboard_page_id ) ) {

			/* WPML filter to get translated page id if translation exists otherwise default id */
			$dashboard_page_id = apply_filters( 'wpml_object_id', $dashboard_page_id, 'page', true );

			$dashboard_url = get_permalink( $dashboard_page_id );

			if ( ! empty( $module ) ) {
				$dashboard_url = add_query_arg( array( 'module' => $module ), $dashboard_url );

				if ( ! empty( $args ) && is_array( $args ) ) {
					$dashboard_url = add_query_arg( $args, $dashboard_url );
				}
			}

			return $dashboard_url;
		}

		return false;
	}
}

if ( ! function_exists( 'realhomes_dashboard_menus' ) ) {
	/**
	 * Dashboard sidebar main and submenus.
	 *
	 * @since 3.12
	 *
	 * @return array
	 */
	function realhomes_dashboard_menus() {
		/**
		 * The elements in the array are :
		 * 0: Menu Title
		 * 1: Page Title
		 * 2: Icon for top level menu
		 * 3: Show in menu (bool)
		 */
		$menu = array();

		/**
		 * The elements in the array are :
		 * 0: Menu Title
		 * 1: Page Title
		 * 2: Query parameters
		 * 3: Show in menu (bool)
		 */
		$submenu = array();

		if ( is_user_logged_in() ) {

			$menu['dashboard'] = array(
				esc_html__( 'Dashboard', 'framework' ),
				esc_html__( 'Dashboard', 'framework' ),
				'fas fa-tachometer-alt',
				realhomes_dashboard_module_enabled( 'inspiry_dashboard_page_display' )
			);
		}

		if ( ( ! is_user_logged_in() && inspiry_guest_submission_enabled() ) || ( is_user_logged_in() && realhomes_dashboard_module_enabled( 'inspiry_submit_property_module_display' ) && ! realhomes_dashboard_module_enabled( 'inspiry_properties_module_display' ) ) ) {
			$menu['submit-property'] = array(
				esc_html__( 'Submit Property', 'framework' ),
				esc_html__( 'Submit Property', 'framework' ),
				'fas fa-home'
			);
		}

		if ( is_user_logged_in() && realhomes_dashboard_module_enabled( 'inspiry_properties_module_display' ) ) {

			if ( inspiry_no_membership_disable_stuff() ) {

				$menu['properties'] = array(
					esc_html__( 'My Properties', 'framework' ),
					esc_html__( 'My Properties', 'framework' ),
					'fas fa-home'
				);

				if ( realhomes_dashboard_module_enabled( 'inspiry_submit_property_module_display' ) ) {
					$submenu['properties']['submit-property'] = array(
						esc_html__( 'Add Property', 'framework' ),
						esc_html__( 'Add New Property', 'framework' ),
						array( 'submodule' => 'submit-property' )
					);
				}

				$submenu['properties']['publish'] = array(
					esc_html__( 'Published', 'framework' ),
					esc_html__( 'Published Properties', 'framework' ),
					array( 'status' => 'publish' )
				);

				$submenu['properties']['pending'] = array(
					esc_html__( 'Pending Review', 'framework' ),
					esc_html__( 'Pending Review', 'framework' ),
					array( 'status' => 'pending' )
				);
			}
		}

//		$menu['agents'] = array(
//			esc_html__( 'Agents', 'framework' ),
//			esc_html__( 'Agents', 'framework' ),
//			'fas fa-user-friends',
//			false
//		);

		if ( realhomes_dashboard_module_enabled( 'inspiry_favorites_module_display' ) ) {
			$favorites_after_login = get_option( 'inspiry_login_on_fav', 'no' );
			if ( ( is_user_logged_in() && 'yes' === $favorites_after_login ) || 'no' === $favorites_after_login ) {
				$menu['favorites'] = array(
					esc_html__( 'My Favorites', 'framework' ),
					esc_html__( 'My Favorites', 'framework' ),
					'fas fa-heart'
				);
			}
		}

		if ( is_user_logged_in() ) {

			if ( realhomes_dashboard_module_enabled( 'inspiry_profile_module_display' ) ) {
				$menu['profile'] = array(
					esc_html__( 'My Profile', 'framework' ),
					esc_html__( 'My Profile', 'framework' ),
					'fas fa-user-alt'
				);
			}

			$saved_searches_label = get_option( 'realhomes_saved_searches_label', esc_html__( 'Saved Searches', 'framework' ) );
			if ( inspiry_is_save_search_enabled() && ! empty( $saved_searches_label ) ) {
				$menu['saved-searches'] = array(
					$saved_searches_label,
					$saved_searches_label,
					'fas fa-bell',
				);
			}

			if ( class_exists( 'IMS_Helper_Functions' ) ) {
				if ( ! empty( IMS_Helper_Functions::is_memberships() ) ) {
					$menu['membership'] = array(
						esc_html__( 'My Membership', 'framework' ),
						esc_html__( 'My Membership Package', 'framework' ),
						'fas fa-clipboard-list'
					);

					$submenu['membership']['packages'] = array(
						esc_html__( 'Packages', 'framework' ),
						esc_html__( 'Packages', 'framework' ),
						array( 'submodule' => 'packages' ),
						false
					);

					$submenu['membership']['checkout'] = array(
						esc_html__( 'Checkout', 'framework' ),
						esc_html__( 'Checkout', 'framework' ),
						array( 'submodule' => 'checkout' ),
						false
					);

					$submenu['membership']['order'] = array(
						esc_html__( 'Order', 'framework' ),
						esc_html__( 'Order', 'framework' ),
						array( 'submodule' => 'order' ),
						false
					);
				}
			}
		}

		/**
		 * Filters the dashboard parent menu.
		 *
		 * @since 3.12
		 *
		 * @param array $menu The parent menu.
		 */
		$menu = apply_filters( 'realhomes_dashboard_menu', $menu );

		/**
		 * Filters the dashboard submenu.
		 *
		 * @since 3.12
		 *
		 * @param array $submenu The submenu.
		 * @param array $menu The parent menu.
		 */
		$submenu = apply_filters( 'realhomes_dashboard_submenu', $submenu, $menu );

		if ( is_user_logged_in() ) {
			$menu['logout'] = array(
				esc_html__( 'Logout', 'framework' ),
				esc_html__( 'Logout', 'framework' ),
				'fas fa-sign-out-alt'
			);
		}

		return array(
			'menu'    => $menu,
			'submenu' => $submenu
		);
	}
}

if ( ! function_exists( 'realhomes_dashboard_submenu_validation' ) ) {
	/**
	 * Validates the submenu items.
	 *
	 * @since 3.12
	 *
	 * @return array|bool
	 */
	function realhomes_dashboard_submenu_validation() {

		$submenu = realhomes_dashboard_menus()['submenu'];
		if ( ! is_array( $submenu ) ) {
			return false;
		}

		$keys   = array();
		$values = array();

		foreach ( $submenu as $submenu_items ) {
			if ( is_array( $submenu_items ) ) {
				foreach ( $submenu_items as $submenu_item ) {
					if ( isset( $submenu_item[2] ) ) {
						$keys[]   = array_keys( $submenu_item[2] )[0];
						$values[] = array_values( $submenu_item[2] )[0];
					}
				}
			}
		}

		return array(
			array_unique( $keys ),
			array_unique( $values )
		);
	}
}

if ( ! function_exists( 'realhomes_dashboard_globals' ) ) {
	/**
	 * Prepares mostly used data for dashboard page template.
	 *
	 * @since 3.12
	 *
	 * @return array
	 */
	function realhomes_dashboard_globals() {

		// Variable to hold dashboard global data.
		$global = array(
			'dashboard_url'  => esc_url( realhomes_get_dashboard_page_url() ),
			'page_title'     => '',
			'current_module' => '',
			'submenu'        => false
		);

		// Set first menu item as default dashboard module if menu is not empty.
		$menu = realhomes_dashboard_menus()['menu'];
		if ( ! empty( $menu ) && is_array( $menu ) ) {
			$module                   = array_keys( $menu )[0];
			$global['page_title']     = $menu[ $module ][1];
			$global['current_module'] = $module;
		}

		if ( isset( $_GET['module'] ) && ! empty( $_GET['module'] ) ) {

			// Validate the current module and update global data on success.
			$module = sanitize_text_field( $_GET['module'] );
			if ( in_array( $module, array_keys( $menu ) ) ) {
				$global['page_title']     = $menu[ $module ][1];
				$global['current_module'] = $module;

				if ( isset( $_GET['status'] ) || isset( $_GET['submodule'] ) ) {

					$global['submenu'] = true;

					$submenu        = realhomes_dashboard_menus()['submenu'];
					$submenu_values = realhomes_dashboard_submenu_validation()[1];

					if ( ! empty( $_GET['status'] ) ) {

						// Check for valid post status and update global data on success.
						$status = sanitize_text_field( $_GET['status'] );
						if ( in_array( $status, $submenu_values ) ) {
							$global['submenu_page_title'] = $submenu[ $module ][ $status ][1];
						}

					} elseif ( ! empty( $_GET['submodule'] ) ) {

						// Validate the sub module and update global data on success.
						$submodule = sanitize_text_field( $_GET['submodule'] );
						if ( in_array( $submodule, $submenu_values ) ) {

							$global['submodule'] = $submodule;

							if ( 'submit-property' === $submodule && isset( $_GET['id'] ) ) {
								$global['submenu_page_title'] = esc_html__( 'Edit Property', 'framework' );
							} else {
								$global['submenu_page_title'] = $submenu[ $module ][ $submodule ][1];
							}
						}
					}
				}
			}
		}

		return $global;
	}
}

if ( ! function_exists( 'realhomes_dashboard_module_enabled' ) ) {
	/**
	 * Determines whether the given dashboard module is enabled or not.
	 *
	 * @since 3.12
	 *
	 * @param $option_id
	 *
	 * @return bool
	 */
	function realhomes_dashboard_module_enabled( $option_id ) {

		if ( 'true' === get_option( $option_id, 'true' ) ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'realhomes_dashboard_header_menu' ) ) {
	/**
	 * Renders the dashboard pages link in header as dropdown menu.
	 *
	 * @since 3.12
	 */
	function realhomes_dashboard_header_menu() {

		$profile_url = inspiry_get_edit_profile_url();
		if ( realhomes_get_dashboard_page_url() && realhomes_dashboard_module_enabled( 'inspiry_profile_module_display' ) ) {
			$profile_url = realhomes_get_dashboard_page_url( 'profile' );
		}

		if ( ! empty( $profile_url ) ) :
			?>
            <a href="<?php echo esc_url( $profile_url ); ?>">
				<?php inspiry_safe_include_svg( 'images/icon-dash-profile.svg', '/common/' ); ?>
                <span><?php esc_html_e( 'My Profile', 'framework' ); ?></span>
            </a>
		<?php
		endif;

		$my_properties_url = inspiry_get_my_properties_url();
		if ( realhomes_get_dashboard_page_url() && realhomes_dashboard_module_enabled( 'inspiry_properties_module_display' ) ) {
			$my_properties_url = realhomes_get_dashboard_page_url( 'properties' );
		}

		if ( ! empty( $my_properties_url ) && inspiry_no_membership_disable_stuff() ) :
			?>
            <a href="<?php echo esc_url( $my_properties_url ); ?>">
				<?php inspiry_safe_include_svg( 'images/icon-dash-my-properties.svg', '/common/' ); ?>
                <span><?php esc_html_e( 'My Properties', 'framework' ); ?></span>
            </a>
		<?php
		endif;

		$favorites_url             = inspiry_get_favorites_url();
		if ( realhomes_get_dashboard_page_url() && realhomes_dashboard_module_enabled( 'inspiry_favorites_module_display' ) ) {
			$favorites_url = realhomes_get_dashboard_page_url( 'favorites' );
		}

		if ( ! empty( $favorites_url ) ) :
			?>
            <a href="<?php echo esc_url( $favorites_url ); ?>">
				<?php inspiry_safe_include_svg( 'images/icon-dash-favorite.svg', '/common/' ); ?>
                <span><?php esc_html_e( 'My Favorites', 'framework' ); ?></span>
            </a>
		<?php
		endif;

		if ( inspiry_is_save_search_enabled() ) {
			$saved_searches_url = '';
			if ( realhomes_get_dashboard_page_url() ) {
				$saved_searches_url = realhomes_get_dashboard_page_url( 'saved-searches' );
			}

			$saved_searches_label = get_option( 'realhomes_saved_searches_label', esc_html__( 'Saved Searches', 'framework' ) );
			if ( ! empty( $saved_searches_url ) && ! empty( $saved_searches_label ) ) :
				?>
                <a href="<?php echo esc_url( $saved_searches_url ); ?>">
					<?php inspiry_safe_include_svg( 'images/icon-dash-alert.svg', '/common/' ); ?>
                    <span><?php echo esc_html( $saved_searches_label ); ?></span>
                </a>
			<?php
			endif;
		}

		if ( function_exists( 'IMS_Helper_Functions' ) ) :
			$ims_helper_functions = IMS_Helper_Functions();
			$is_memberships_enable = $ims_helper_functions::is_memberships();

			$membership_url = inspiry_get_membership_url();
			if ( realhomes_get_dashboard_page_url() ) {
				$membership_url = realhomes_get_dashboard_page_url( 'membership' );
			}

			if ( ! empty( $is_memberships_enable ) && ! empty( $membership_url ) ) :
				?>
                <a href="<?php echo esc_url( $membership_url ); ?>">
					<?php inspiry_safe_include_svg( 'images/icon-membership.svg', '/common/' ); ?>
                    <span><?php esc_html_e( 'My Membership', 'framework' ); ?></span>
                </a>
			<?php
			endif;
		endif;
		?>
        <a href="<?php echo esc_url( wp_logout_url( home_url() ) ); ?>">
			<?php inspiry_safe_include_svg( 'images/icon-dash-logout.svg', '/common/' ); ?>
            <span><?php esc_html_e( 'Logout', 'framework' ); ?></span>
        </a>
		<?php
	}
}

if ( ! function_exists( 'realhomes_dashboard_posts_per_page_list' ) ) {
	/**
	 * Provides the posts per page list for dashboard posts list pages.
	 *
	 * @since 3.12
	 *
	 * @return array
	 */
	function realhomes_dashboard_posts_per_page_list() {

		$list = array(
			'-1'  => esc_html__( 'All', 'framework' ),
			'5'   => esc_html__( '5', 'framework' ),
			'10'  => esc_html__( '10', 'framework' ),
			'15'  => esc_html__( '15', 'framework' ),
			'20'  => esc_html__( '20', 'framework' ),
			'25'  => esc_html__( '25', 'framework' ),
			'50'  => esc_html__( '50', 'framework' ),
			'75'  => esc_html__( '75', 'framework' ),
			'100' => esc_html__( '100', 'framework' ),
		);

		return apply_filters( 'realhomes_dashboard_posts_per_page_list', $list );
	}
}

if ( ! function_exists( 'realhomes_dashboard_posts_per_page' ) ) {
	/**
	 * Provides the post per page current value.
	 *
	 * @since 3.12
	 *
	 * @return int
	 */
	function realhomes_dashboard_posts_per_page() {

		$posts_per_page = get_option( 'inspiry_dashboard_posts_per_page', '10' );

		if ( isset( $_GET['posts_per_page'] ) && ! empty( $_GET['posts_per_page'] ) ) {
			if ( in_array( $_GET['posts_per_page'], array_keys( realhomes_dashboard_posts_per_page_list() ) ) ) {
				$posts_per_page = $_GET['posts_per_page'];
			}
		}

		return intval( $posts_per_page );
	}
}

if ( ! function_exists( 'realhomes_dashboard_properties_status_filter' ) ) {
	/**
	 * Filters the properties as per selected property status value.
	 *
	 * @since 3.12
	 *
	 * @return string
	 */
	function realhomes_dashboard_properties_status_filter() {

		$property_status_filter = '-1';

		if ( isset( $_GET['property_status_filter'] ) && ! empty( $_GET['property_status_filter'] ) ) {
			$property_status_filter = sanitize_text_field( $_GET['property_status_filter'] );
		}

		return $property_status_filter;
	}
}

if ( ! function_exists( 'realhomes_dashboard_no_items' ) ) {
	/**
	 * Shows no property found message for dashboard posts list pages.
	 *
	 * @since 3.12
	 *
	 * @param string $message
	 */
	function realhomes_dashboard_no_items( $message = '' ) {

		if ( empty( $message ) ) {
			$message = esc_html__( 'No Property Found!', 'framework' );
		}

		printf( '<div class="dashboard-no-items"><p><strong>%s</strong></p></div>', esc_html( $message ) );
	}
}

if ( ! function_exists( 'realhomes_dashboard_notice' ) ) {
	/**
	 * Displays dashboard notices.
	 *
	 * @since 3.12
	 *
	 * @param $message
	 * @param string $type
	 * @param bool $dismissible
	 */
	function realhomes_dashboard_notice( $message, $type = 'info', $dismissible = false ) {

		$allowed_html = array(
			'button' => array(
				'type'  => array(),
				'class' => array(),
			),
			'a'      => array(
				'href'   => array(),
				'class'  => array(),
				'target' => array(),
			),
			'i'      => array(
				'class' => array(),
			),
			'br'     => array(),
			'strong' => array(),
			'em'     => array(),
			'h5'     => array(),
			'p'      => array(),
		);

		if ( is_array( $message ) && ! empty( $message ) ) {
			$count = count( $message );
			if ( $count === 2 ) {
				$output = sprintf( '<h5>%s</h5><p>%s</p>', $message[0], $message[1] );
			} else {
				$output = sprintf( '<p>%s</p>', $message[0] );
			}
		} else {
			$output = sprintf( '<p>%s</p>', $message );
		}

		if ( $dismissible ) {
			$output .= '<button type="button" class="dashboard-notice-dismiss-button"><i class="fas fa-times"></i></button>';
			printf( '<div class="dashboard-notice %s is-dismissible">%s</div>', esc_attr( $type ), wp_kses( $output, $allowed_html ) );
		} else {
			printf( '<div class="dashboard-notice %s">%s</div>', esc_attr( $type ), wp_kses( $output, $allowed_html ) );
		}
	}
}

if ( ! function_exists( 'realhomes_dashboard_edit_property' ) ) {
	/**
	 * Checks for dashboard edit property.
	 *
	 * @since 3.12
	 *
	 * @return bool
	 */
	function realhomes_dashboard_edit_property() {
		global $target_property;

		if ( ! empty( $target_property ) ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'realhomes_dashboard_submit_property' ) ) {
	/**
	 * Provides the functionality to add or update property.
	 *
	 * @since 3.12
	 */
	function realhomes_dashboard_submit_property() {
		global $submitted_successfully, $updated_successfully;

		$response               = array();
		$submitted_successfully = false;
		$updated_successfully   = false;

		// Verify nonce.
		if ( ! wp_verify_nonce( $_POST['property_nonce'], 'submit_property' ) ) {
			$response['message'] = esc_html__( 'Security check failed!', 'framework' );
			wp_send_json_error( $response );
		}

		// Verifies the google recaptcha challenge.
		if ( ! is_user_logged_in() && inspiry_guest_submission_enabled() && class_exists( 'Easy_Real_Estate' ) ) {
			ere_verify_google_recaptcha();
		}

		/* Start with basic array */
		$new_property = array( 'post_type' => 'property' );

		/* Title */
		if ( isset( $_POST['inspiry_property_title'] ) && ! empty( $_POST['inspiry_property_title'] ) ) {
			$new_property['post_title'] = sanitize_text_field( $_POST['inspiry_property_title'] );
		}

		/* Description */
		if ( isset( $_POST['description'] ) ) {
			$new_property['post_content'] = wp_kses_post( $_POST['description'] );
		}

		/* Get current user */
		$current_user                = wp_get_current_user();
		$new_property['post_author'] = $current_user->ID;

		/* Check the type of action */
		$action      = $_POST['action'];
		$property_id = 0;

		/* Parent Property ID */
		if ( isset( $_POST['property_parent_id'] ) && ! empty( $_POST['property_parent_id'] ) ) {
			$new_property['post_parent'] = $_POST['property_parent_id'];
		} else {
			$new_property['post_parent'] = 0;
		}

		/* Add or Update Property */
		if ( 'add_property' == $action ) {

			$submitted_property_status = get_option( 'theme_submitted_status' );
			if ( ! empty( $submitted_property_status ) ) {
				$new_property['post_status'] = $submitted_property_status;
			} else {
				$new_property['post_status'] = 'pending';
			}

			/* This filter is used to filter the submission arguments of property before inserting it. */
			$new_property = apply_filters( 'inspiry_before_property_submit', $new_property );

			// Insert Property and get Property ID.
			$property_id = wp_insert_post( $new_property );
			if ( $property_id > 0 ) {
				$submitted_successfully = true;
			}
		} elseif ( 'update_property' == $action ) {

			// If individual payments are enabled then set the property status accordingly.
			$isp_settings   = get_option( 'isp_settings' ); // Stripe settings.
			$rpp_settings   = get_option( 'rpp_settings' ); // PayPal settings.
			$rhwpa_settings = get_option( 'rhwpa_property_payment_settings' ); // Property WooCommerce payments settings.

			// Check if PayPal or Stripe payment is enabled.
			if ( ! empty( $isp_settings['enable_stripe'] ) || ! empty( $rpp_settings['enable_paypal'] ) || ! empty( $rhwpa_settings['enable_wc_payments'] ) ) {
				if ( 'Completed' === get_post_meta( $_POST['property_id'], 'payment_status', true ) ) {
					$new_property['post_status'] = get_option( 'inspiry_updated_property_status', 'publish' );
				} else {
					$new_property['post_status'] = 'pending';
				}
			} else {
				$new_property['post_status'] = get_option( 'inspiry_updated_property_status', 'publish' );
			}

			$new_property['ID'] = intval( $_POST['property_id'] );

			/* This filter is used to filter the submission arguments of property before update */
			$new_property = apply_filters( 'inspiry_before_property_update', $new_property );

			// Update Property and get Property ID.
			$property_id = wp_update_post( $new_property );
			if ( $property_id > 0 ) {
				$updated_successfully = true;
			}
		}

		// If property is added or updated successfully then move ahead
		if ( $property_id > 0 ) {

			/* Attach Property Type(s) with Newly Created Property */
			if ( isset( $_POST['type'] ) ) {
				if ( ! empty( $_POST['type'] ) && is_array( $_POST['type'] ) ) {
					$property_types = array();
					foreach ( $_POST['type'] as $property_type_id ) {
						$property_types[] = intval( $property_type_id );
					}
					wp_set_object_terms( $property_id, $property_types, 'property-type' );
				}
			}

			/* Attach Property Location with Newly Created Property */
			$location_select_names = inspiry_get_location_select_names();
			$locations_count       = count( $location_select_names );
			for ( $l = $locations_count - 1; $l >= 0; $l -- ) {
				if ( isset( $_POST[ $location_select_names[ $l ] ] ) ) {
					$current_location = $_POST[ $location_select_names[ $l ] ];
					if ( ( ! empty( $current_location ) ) && ( $current_location != inspiry_any_value() ) ) {
						wp_set_object_terms( $property_id, $current_location, 'property-city' );
						break;
					}
				}
			}

			/* Attach Property Status with Newly Created Property */
			if ( isset( $_POST['status'] ) && ( '-1' != $_POST['status'] ) ) {
				wp_set_object_terms( $property_id, intval( $_POST['status'] ), 'property-status' );
			}

			/* Attach Property Features with Newly Created Property */
			if ( isset( $_POST['features'] ) ) {
				if ( ! empty( $_POST['features'] ) && is_array( $_POST['features'] ) ) {
					$property_features = array();
					foreach ( $_POST['features'] as $property_feature_id ) {
						$property_features[] = intval( $property_feature_id );
					}
					wp_set_object_terms( $property_id, $property_features, 'property-feature' );
				}
			} else {
				wp_delete_object_term_relationships( $property_id, 'property-feature' );
			}

			/* Attach Price Post Meta */
			if ( isset( $_POST['price'] ) && ! empty( $_POST['price'] ) ) {
				update_post_meta( $property_id, 'REAL_HOMES_property_price', sanitize_text_field( $_POST['price'] ) );

				if ( isset( $_POST['price-postfix'] ) && ! empty( $_POST['price-postfix'] ) ) {
					update_post_meta( $property_id, 'REAL_HOMES_property_price_postfix', sanitize_text_field( $_POST['price-postfix'] ) );
				}
			} else {
				delete_post_meta( $property_id, 'REAL_HOMES_property_price' );
			}

			/* Attach Old Price Post Meta */
			if ( isset( $_POST['old-price'] ) && ! empty( $_POST['old-price'] ) ) {
				update_post_meta( $property_id, 'REAL_HOMES_property_old_price', sanitize_text_field( $_POST['old-price'] ) );
			} else {
				delete_post_meta( $property_id, 'REAL_HOMES_property_old_price' );
			}

			if ( isset( $_POST['price-postfix'] ) && empty( $_POST['price-postfix'] ) ) {
				delete_post_meta( $property_id, 'REAL_HOMES_property_price_postfix' );
			}

			if ( isset( $_POST['price-prefix'] ) ) {
				update_post_meta( $property_id, 'REAL_HOMES_property_price_prefix', sanitize_text_field( $_POST['price-prefix'] ) );
			}

			/* Attach Size Post Meta */
			if ( isset( $_POST['size'] ) && ! empty( $_POST['size'] ) ) {
				update_post_meta( $property_id, 'REAL_HOMES_property_size', sanitize_text_field( $_POST['size'] ) );

				if ( isset( $_POST['area-postfix'] ) && ! empty( $_POST['area-postfix'] ) ) {
					update_post_meta( $property_id, 'REAL_HOMES_property_size_postfix', sanitize_text_field( $_POST['area-postfix'] ) );
				}
			} else {
				delete_post_meta( $property_id, 'REAL_HOMES_property_size' );
			}

			if ( isset( $_POST['area-postfix'] ) && empty( $_POST['area-postfix'] ) ) {
				delete_post_meta( $property_id, 'REAL_HOMES_property_size_postfix' );
			}

			/* Attach Lot Size Post Meta */
			if ( isset( $_POST['lot-size'] ) && ! empty( $_POST['lot-size'] ) ) {
				update_post_meta( $property_id, 'REAL_HOMES_property_lot_size', sanitize_text_field( $_POST['lot-size'] ) );

				if ( isset( $_POST['lot-size-postfix'] ) && ! empty( $_POST['lot-size-postfix'] ) ) {
					update_post_meta( $property_id, 'REAL_HOMES_property_lot_size_postfix', sanitize_text_field( $_POST['lot-size-postfix'] ) );
				}
			} else {
				delete_post_meta( $property_id, 'REAL_HOMES_property_lot_size' );
			}

			if ( isset( $_POST['lot-size-postfix'] ) && empty( $_POST['lot-size-postfix'] ) ) {
				delete_post_meta( $property_id, 'REAL_HOMES_property_lot_size_postfix' );
			}

			/* Attach Bedrooms Post Meta */
			if ( isset( $_POST['bedrooms'] ) && ! empty( $_POST['bedrooms'] ) ) {
				update_post_meta( $property_id, 'REAL_HOMES_property_bedrooms', floatval( $_POST['bedrooms'] ) );
			} else {
				delete_post_meta( $property_id, 'REAL_HOMES_property_bedrooms' );
			}

			/* Attach Bathrooms Post Meta */
			if ( isset( $_POST['bathrooms'] ) && ! empty( $_POST['bathrooms'] ) ) {
				update_post_meta( $property_id, 'REAL_HOMES_property_bathrooms', floatval( $_POST['bathrooms'] ) );
			} else {
				delete_post_meta( $property_id, 'REAL_HOMES_property_bathrooms' );
			}

			/* Attach Garages Post Meta */
			if ( isset( $_POST['garages'] ) && ! empty( $_POST['garages'] ) ) {
				update_post_meta( $property_id, 'REAL_HOMES_property_garage', floatval( $_POST['garages'] ) );
			} else {
				delete_post_meta( $property_id, 'REAL_HOMES_property_garage' );
			}

			/* Attach Year Built Post Meta */
			if ( isset( $_POST['year-built'] ) && ! empty( $_POST['year-built'] ) ) {
				update_post_meta( $property_id, 'REAL_HOMES_property_year_built', floatval( $_POST['year-built'] ) );
			}

			/* Attach Energy Performance Certificate Meta */
			if ( isset( $_POST['energy-class'] ) && ! empty( $_POST['energy-class'] ) ) {
				update_post_meta( $property_id, 'REAL_HOMES_energy_class', sanitize_text_field( $_POST['energy-class'] ) );
			}

			if ( isset( $_POST['energy-performance'] ) && ! empty( $_POST['energy-performance'] ) ) {
				update_post_meta( $property_id, 'REAL_HOMES_energy_performance', sanitize_text_field( $_POST['energy-performance'] ) );
			}

			if ( isset( $_POST['epc-current-rating'] ) && ! empty( $_POST['epc-current-rating'] ) ) {
				update_post_meta( $property_id, 'REAL_HOMES_epc_current_rating', sanitize_text_field( $_POST['epc-current-rating'] ) );
			}

			if ( isset( $_POST['epc-potential-rating'] ) && ! empty( $_POST['epc-potential-rating'] ) ) {
				update_post_meta( $property_id, 'REAL_HOMES_epc_potential_rating', sanitize_text_field( $_POST['epc-potential-rating'] ) );
			}

			/* Attach Address Post Meta */
			if ( isset( $_POST['address'] ) && ! empty( $_POST['address'] ) ) {
				update_post_meta( $property_id, 'REAL_HOMES_property_address', sanitize_text_field( $_POST['address'] ) );
			}

			/**
			 * RVR meta fields
			 * @since 3.13.0
			 */
			if ( inspiry_is_rvr_enabled() ) {
				if ( isset( $_POST['rvr_guests_capacity'] ) ) {
					update_post_meta( $property_id, 'rvr_guests_capacity', sanitize_text_field( $_POST['rvr_guests_capacity'] ) );
				}

				if ( isset( $_POST['rvr_min_stay'] ) ) {
					update_post_meta( $property_id, 'rvr_min_stay', sanitize_text_field( $_POST['rvr_min_stay'] ) );
				}

				if ( isset( $_POST['rvr_govt_tax'] ) ) {
					update_post_meta( $property_id, 'rvr_govt_tax', sanitize_text_field( $_POST['rvr_govt_tax'] ) );
				}

				if ( isset( $_POST['rvr_service_charges'] ) ) {
					update_post_meta( $property_id, 'rvr_service_charges', sanitize_text_field( $_POST['rvr_service_charges'] ) );
				}

				if ( isset( $_POST['rvr_property_owner'] ) ) {
					update_post_meta( $property_id, 'rvr_property_owner', sanitize_text_field( $_POST['rvr_property_owner'] ) );
				}

				$rvr_outdoor_features_sanitized = array();
				if ( isset( $_POST['rvr_outdoor_features'] ) && ! empty( $_POST['rvr_outdoor_features'] ) ) {
					$rvr_outdoor_features = $_POST['rvr_outdoor_features'];
					if ( is_array( $rvr_outdoor_features ) ) {
						foreach ( $rvr_outdoor_features as $rvr_outdoor_feature ) {
							if ( ! empty( $rvr_outdoor_feature ) ) {
								$rvr_outdoor_features_sanitized[] = sanitize_text_field( $rvr_outdoor_feature );
							}
						}
					}
				}
				update_post_meta( $property_id, 'rvr_outdoor_features', $rvr_outdoor_features_sanitized );

				$rvr_included_sanitized = array();
				if ( isset( $_POST['rvr_included'] ) && ! empty( $_POST['rvr_included'] ) ) {
					$rvr_included = $_POST['rvr_included'];
					if ( is_array( $rvr_included ) ) {
						foreach ( $rvr_included as $rvr_included_field ) {
							if ( ! empty( $rvr_included_field ) ) {
								$rvr_included_sanitized[] = sanitize_text_field( $rvr_included_field );
							}
						}
					}
				}
				update_post_meta( $property_id, 'rvr_included', $rvr_included_sanitized );

				$rvr_not_included_sanitized = array();
				if ( isset( $_POST['rvr_not_included'] ) && ! empty( $_POST['rvr_not_included'] ) ) {
					$rvr_not_included = $_POST['rvr_not_included'];
					if ( is_array( $rvr_not_included ) ) {
						foreach ( $rvr_not_included as $rvr_not_included_field ) {
							if ( ! empty( $rvr_not_included_field ) ) {
								$rvr_not_included_sanitized[] = sanitize_text_field( $rvr_not_included_field );
							}
						}
					}
				}
				update_post_meta( $property_id, 'rvr_not_included', $rvr_not_included_sanitized );

				$rvr_surroundings_sanitized = array();
				if ( isset( $_POST['rvr_surroundings'] ) && ! empty( $_POST['rvr_surroundings'] ) ) {
					$rvr_surroundings = $_POST['rvr_surroundings'];
					if ( is_array( $rvr_surroundings ) ) {
						foreach ( $rvr_surroundings as $k => $v ) {
							if ( ! empty( $v['rvr_surrounding_point'] ) || ! empty( $v['rvr_surrounding_point_distance'] ) ) {
								$rvr_surroundings_sanitized[ $k ] = array(
									'rvr_surrounding_point'          => sanitize_text_field( $v['rvr_surrounding_point'] ),
									'rvr_surrounding_point_distance' => sanitize_text_field( $v['rvr_surrounding_point_distance'] )
								);
							}
						}
					}
				}
				update_post_meta( $property_id, 'rvr_surroundings', $rvr_surroundings_sanitized );

				$rvr_policies_sanitized = array();
				if ( isset( $_POST['rvr_policies'] ) && ! empty( $_POST['rvr_policies'] ) ) {
					$rvr_policies = $_POST['rvr_policies'];
					if ( is_array( $rvr_policies ) ) {
						foreach ( $rvr_policies as $k => $v ) {
							if ( ! empty( $v['rvr_policy_detail'] ) || ! empty( $v['rvr_policy_icon'] ) ) {
								$rvr_policies_sanitized[ $k ] = array(
									'rvr_policy_detail' => sanitize_text_field( $v['rvr_policy_detail'] ),
									'rvr_policy_icon'   => sanitize_text_field( $v['rvr_policy_icon'] )
								);
							}
						}
					}
				}
				update_post_meta( $property_id, 'rvr_policies', $rvr_policies_sanitized );
			}

			/* Attach Address Post Meta */
			if ( isset( $_POST['coordinates'] ) && ! empty( $_POST['coordinates'] ) ) {
				update_post_meta( $property_id, 'REAL_HOMES_property_location', $_POST['coordinates'] );
			}

			/* Agent Display Option */
			if ( isset( $_POST['agent_display_option'] ) && ! empty( $_POST['agent_display_option'] ) ) {
				update_post_meta( $property_id, 'REAL_HOMES_agent_display_option', $_POST['agent_display_option'] );
				if ( ( $_POST['agent_display_option'] == 'agent_info' ) && isset( $_POST['agent_id'] ) ) {
					delete_post_meta( $property_id, 'REAL_HOMES_agents' );
					foreach ( $_POST['agent_id'] as $agent_id ) {
						add_post_meta( $property_id, 'REAL_HOMES_agents', $agent_id );
					}
				} else {
					delete_post_meta( $property_id, 'REAL_HOMES_agents' );
				}
			}

			/* Attach Property ID Post Meta */
			if ( isset( $_POST['property-id'] ) && ! empty( $_POST['property-id'] ) ) {
				update_post_meta( $property_id, 'REAL_HOMES_property_id', sanitize_text_field( $_POST['property-id'] ) );
			} else {
				$auto_property_id    = get_option( 'inspiry_auto_property_id_check' );
				$property_id_pattern = get_option( 'inspiry_auto_property_id_pattern' );
				if ( ! empty( $auto_property_id ) && ( 'true' === $auto_property_id ) && ! empty( $property_id_pattern ) ) {
					$property_id_value = preg_replace( '/{ID}/', $property_id, $property_id_pattern );
					update_post_meta( $property_id, 'REAL_HOMES_property_id', sanitize_text_field( $property_id_value ) );
				}
			}

			/* Attach Virtual Tour Video URL Post Meta */
			if ( isset( $_POST['video-url'] ) && ! empty( $_POST['video-url'] ) ) {
				update_post_meta( $property_id, 'REAL_HOMES_tour_video_url', esc_url_raw( $_POST['video-url'] ) );
			} else {
				delete_post_meta( $property_id, 'REAL_HOMES_tour_video_url' );
			}

			$inspiry_video_group_sanitized = array();
			if ( isset( $_POST['inspiry_video_group'] ) && ! empty( $_POST['inspiry_video_group'] ) ) {
				$inspiry_video_group = $_POST['inspiry_video_group'];
				if ( is_array( $inspiry_video_group ) ) {
					foreach ( $inspiry_video_group as $k => $v ) {
						if ( isset( $v['inspiry_video_group_url'] ) && ! empty( $v['inspiry_video_group_url'] ) ) {
							$inspiry_video_group_sanitized[ $k ]['inspiry_video_group_url'] = esc_url_raw( $v['inspiry_video_group_url'] );

							if ( isset( $v['inspiry_video_group_title'] ) ) {
								$inspiry_video_group_sanitized[ $k ]['inspiry_video_group_title'] = sanitize_text_field( $v['inspiry_video_group_title'] );
							}

							if ( isset( $v['inspiry_video_group_image'] ) ) {
								$inspiry_video_group_sanitized[ $k ]['inspiry_video_group_image'] = sanitize_text_field( $v['inspiry_video_group_image'] );
							}
						}
					}
				}
			}
			update_post_meta( $property_id, 'inspiry_video_group', $inspiry_video_group_sanitized );

			/* Attach 360 Virtual Tour Post Meta */
			if ( isset( $_POST['REAL_HOMES_360_virtual_tour'] ) ) {
				update_post_meta( $property_id, 'REAL_HOMES_360_virtual_tour', wp_kses( $_POST['REAL_HOMES_360_virtual_tour'], inspiry_embed_code_allowed_html() ) );
			}

			/* Attach Message to Reviewer */
			if ( isset( $_POST['message_to_reviewer'] ) && ! empty( $_POST['message_to_reviewer'] ) ) {
				update_post_meta( $property_id, 'inspiry_message_to_reviewer', esc_textarea( $_POST['message_to_reviewer'] ) );
			}

			/* Attach floor plans details with property */
			if ( isset( $_POST['inspiry_floor_plans'] ) && ! empty( $_POST['inspiry_floor_plans'] ) ) {
				inspiry_submit_floor_plans( $property_id, $_POST['inspiry_floor_plans'] );
			} else {
				delete_post_meta( $property_id, 'inspiry_floor_plans' );
			}

			/* Attach additional details with property */
			if ( isset( $_POST['detail-titles'] ) && isset( $_POST['detail-values'] ) ) {

				$additional_details_titles = $_POST['detail-titles'];
				$additional_details_values = $_POST['detail-values'];

				$titles_count = count( $additional_details_titles );
				$values_count = count( $additional_details_values );

				// to skip empty values on submission
				if ( $titles_count == 1 && $values_count == 1 && empty( $additional_details_titles[0] ) && empty( $additional_details_values[0] ) ) {
					// do nothing and let it go
				} else {

					if ( ! empty( $additional_details_titles ) && ! empty( $additional_details_values ) ) {
						$additional_details = array_combine( $additional_details_titles, $additional_details_values );

						// Remove empty values before adding to database
						$additional_details = array_filter( $additional_details, 'strlen' );

						$additional_details_meta = array();
						foreach ( $additional_details as $title => $value ) {
							$additional_details_meta[] = array( $title, $value );
						}

						update_post_meta( $property_id, 'REAL_HOMES_additional_details_list', $additional_details_meta );
					}
				}
			} else {
				delete_post_meta( $property_id, 'REAL_HOMES_additional_details_list' );
			}

			/* Attach Property as Featured Post Meta */
			$featured = ( isset( $_POST['featured'] ) && ! empty( $_POST['featured'] ) ) ? 1 : 0;
			update_post_meta( $property_id, 'REAL_HOMES_featured', $featured );

			/* Property Submission Terms & Conditions */
			$terms = ( isset( $_POST['terms'] ) && ! empty( $_POST['terms'] ) ) ? 1 : 0;
			update_post_meta( $property_id, 'REAL_HOMES_terms_conditions', $terms );

			/* Tour video image - in case of update */
			$tour_video_image    = '';
			$tour_video_image_id = 0;
			if ( $action == 'update_property' ) {
				$tour_video_image_id = get_post_meta( $property_id, 'REAL_HOMES_tour_video_image', true );
				if ( ! empty( $tour_video_image_id ) ) {
					$tour_video_image_src = wp_get_attachment_image_src( $tour_video_image_id, 'property-detail-video-image' );
					$tour_video_image     = $tour_video_image_src[0];
				}
			}

			/* Property Attachments */
			if ( isset( $_POST['property_attachment_ids'] ) && ! empty( $_POST['property_attachment_ids'] ) ) {
				if ( is_array( $_POST['property_attachment_ids'] ) ) {
					foreach ( $_POST['property_attachment_ids'] as $property_attachment_id ) {
						add_post_meta( $property_id, 'REAL_HOMES_attachments', $property_attachment_id );
					}
				}
			} else {
				delete_post_meta( $property_id, 'REAL_HOMES_attachments' );
			}

			/* If property is being updated, clean up the old meta information related to images */
			if ( $action == 'update_property' ) {
				delete_post_meta( $property_id, 'REAL_HOMES_property_images' );
				delete_post_meta( $property_id, '_thumbnail_id' );
			}

			/* Attach gallery images with newly created property */
			if ( isset( $_POST['gallery_image_ids'] ) ) {
				if ( ! empty( $_POST['gallery_image_ids'] ) && is_array( $_POST['gallery_image_ids'] ) ) {
					$gallery_image_ids = array();
					foreach ( $_POST['gallery_image_ids'] as $gallery_image_id ) {
						$gallery_image_ids[] = intval( $gallery_image_id );
						add_post_meta( $property_id, 'REAL_HOMES_property_images', $gallery_image_id );
					}
					if ( isset( $_POST['featured_image_id'] ) ) {
						$featured_image_id = intval( $_POST['featured_image_id'] );
						if ( in_array( $featured_image_id, $gallery_image_ids ) ) {     // validate featured image id
							update_post_meta( $property_id, '_thumbnail_id', $featured_image_id );

							/* if video url is provided but there is no video image then use featured image as video image */
							if ( empty( $tour_video_image ) && ! empty( $_POST['video-url'] ) ) {
								update_post_meta( $property_id, 'REAL_HOMES_tour_video_image', $featured_image_id );
							}
						}
					} elseif ( ! empty( $gallery_image_ids ) ) {
						update_post_meta( $property_id, '_thumbnail_id', $gallery_image_ids[0] );

						/* if video url is provided but there is no video image then use featured image as video image */
						if ( empty( $tour_video_image ) && ! empty( $_POST['video-url'] ) ) {
							update_post_meta( $property_id, 'REAL_HOMES_tour_video_image', $gallery_image_ids[0] );
						}
					}
				}
			}

			// Property Single Gallery Type
			$change_gallery_slider_type = ( isset( $_POST['REAL_HOMES_change_gallery_slider_type'] ) && ! empty( $_POST['REAL_HOMES_change_gallery_slider_type'] ) ) ? 1 : 0;
			update_post_meta( $property_id, 'REAL_HOMES_change_gallery_slider_type', $change_gallery_slider_type );
			if ( $change_gallery_slider_type ) {
				if ( isset( $_POST['REAL_HOMES_gallery_slider_type'] ) && in_array( $_POST['REAL_HOMES_gallery_slider_type'], array(
						'thumb-on-right',
						'thumb-on-bottom'
					) ) ) {
					update_post_meta( $property_id, 'REAL_HOMES_gallery_slider_type', sanitize_text_field( $_POST['REAL_HOMES_gallery_slider_type'] ) );
				}
			}

			// Property Homepage Slider Image
			$add_in_slider = ( isset( $_POST['REAL_HOMES_add_in_slider'] ) && ! empty( $_POST['REAL_HOMES_add_in_slider'] ) ) ? 'yes' : 'no';
			update_post_meta( $property_id, 'REAL_HOMES_add_in_slider', $add_in_slider );
			if ( 'yes' === $add_in_slider ) {
				if ( isset( $_POST['slider_image_id'] ) && ! empty( $_POST['slider_image_id'] ) ) {
					add_post_meta( $property_id, 'REAL_HOMES_slider_image', intval( $_POST['slider_image_id'] ) );
				}
			}

			// Property Tax ( Mortgage Calculator )
			if ( isset( $_POST['inspiry_property_tax'] ) ) {
				update_post_meta( $property_id, 'inspiry_property_tax', sanitize_text_field( $_POST['inspiry_property_tax'] ) );
			}

			// Additional Fee ( Mortgage Calculator )
			if ( isset( $_POST['inspiry_additional_fee'] ) ) {
				update_post_meta( $property_id, 'inspiry_additional_fee', sanitize_text_field( $_POST['inspiry_additional_fee'] ) );
			}

			// Property Label
			if ( isset( $_POST['inspiry_property_label'] ) ) {
				update_post_meta( $property_id, 'inspiry_property_label', sanitize_text_field( $_POST['inspiry_property_label'] ) );
			}

			// Property Label Background Color
			if ( isset( $_POST['inspiry_property_label_color'] ) ) {
				update_post_meta( $property_id, 'inspiry_property_label_color', sanitize_text_field( $_POST['inspiry_property_label_color'] ) );
			}

			// Property Owner Name
			if ( isset( $_POST['inspiry_property_owner_name'] ) ) {
				update_post_meta( $property_id, 'inspiry_property_owner_name', sanitize_text_field( $_POST['inspiry_property_owner_name'] ) );
			}

			// Property Owner Contact
			if ( isset( $_POST['inspiry_property_owner_contact'] ) ) {
				update_post_meta( $property_id, 'inspiry_property_owner_contact', sanitize_text_field( $_POST['inspiry_property_owner_contact'] ) );
			}

			// Property Owner Address
			if ( isset( $_POST['inspiry_property_owner_address'] ) ) {
				update_post_meta( $property_id, 'inspiry_property_owner_address', sanitize_text_field( $_POST['inspiry_property_owner_address'] ) );
			}

			if ( 'add_property' == $_POST['action'] ) {
				/**
				 * ere_submit_notice function in /plugins/easy-real-estate/includes/functions/property-submit.php is hooked with this hook.
				 */
				do_action( 'inspiry_after_property_submit', $property_id );

				// Send success response with guest submission on.
				if ( ! is_user_logged_in() && inspiry_guest_submission_enabled() ) {
					$response['guest_submission'] = true;
					wp_send_json_success( $response );
				}

			} elseif ( 'update_property' == $_POST['action'] ) {
				/**
				 * No default theme function is hooked with this hook.
				 */
				do_action( 'inspiry_after_property_update', $property_id );
			}

			// Send success response with redirect url.
			$response['redirect_url'] = inspiry_property_submit_redirect( $updated_successfully, true );
			wp_send_json_success( $response );
		}
	}

	add_action( 'wp_ajax_add_property', 'realhomes_dashboard_submit_property' );
	add_action( 'wp_ajax_update_property', 'realhomes_dashboard_submit_property' );

	// Adds action when guest submission is enabled.
	if ( ! is_user_logged_in() && inspiry_guest_submission_enabled() ) {
		add_action( 'wp_ajax_nopriv_add_property', 'realhomes_dashboard_submit_property' );
	}
}

if ( ! function_exists( 'realhomes_dashboard_js_templates' ) ) {
	/**
	 * Adds the js templates in the footer related to dashboard template.
	 *
	 * @since 3.12
	 */
	function realhomes_dashboard_js_templates() {
		if ( ! is_page_template( array( 'templates/dashboard.php', 'templates/submit-property.php' ) ) ) {
			return;
		}
		?>
        <script id="tmpl-floor-plan-clone" type="text/template">
            <div class="inspiry-clone inspiry-group-clone" data-floor-plan="{{data}}">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="inspiry-field">
                            <label for="inspiry_floor_plan_name_{{data}}"><?php esc_html_e( 'Floor Name', 'framework' ); ?></label>
                            <input type="text" id="inspiry_floor_plan_name_{{data}}"
                                   name="inspiry_floor_plans[{{data}}][inspiry_floor_plan_name]" value="">
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="inspiry-field inspiry-file-input-wrapper">
                            <label><?php esc_html_e( 'Floor Plan Image', 'framework' ); ?>
                                <span><?php esc_html_e( '* Minimum width is 770px and height is flexible.', 'framework' ); ?></span></label>
                            <div class="inspiry-btn-group clearfix">
                                <input type="text" class="inspiry-file-input"
                                       name="inspiry_floor_plans[{{data}}][inspiry_floor_plan_image]" value="">
                                <button id="inspiry-file-select-{{data}}"
                                        class="inspiry-file-select real-btn btn btn-primary"><?php esc_html_e( 'Select Image', 'framework' ); ?></button>
                                <button id="inspiry-file-remove-{{data}}"
                                        class="inspiry-file-remove real-btn btn btn-secondary hidden"><?php esc_html_e( 'Remove', 'framework' ); ?></button>
                            </div>
                        </div>
                        <div class="errors-log"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="inspiry-field">
                            <label for="inspiry_floor_plan_descr_{{data}}"><?php esc_html_e( 'Description', 'framework' ); ?></label>
                            <textarea id="inspiry_floor_plan_descr_{{data}}" class="inspiry-textarea"
                                      name="inspiry_floor_plans[{{data}}][inspiry_floor_plan_descr]"></textarea>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="inspiry-field">
                                    <label for="inspiry_floor_plan_price_{{data}}"><?php esc_html_e( 'Floor Price', 'framework' ); ?>
                                        <span><?php esc_html_e( '( Only digits )', 'framework' ); ?></span></label>
                                    <input type="text" id="inspiry_floor_plan_price_{{data}}"
                                           name="inspiry_floor_plans[{{data}}][inspiry_floor_plan_price]" value="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="inspiry-field">
                                    <label for="inspiry_floor_plan_price_postfix_{{data}}"><?php esc_html_e( 'Price Postfix', 'framework' ); ?></label>
                                    <input type="text" id="inspiry_floor_plan_price_postfix_{{data}}"
                                           name="inspiry_floor_plans[{{data}}][inspiry_floor_plan_price_postfix]"
                                           value="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="inspiry-field">
                                    <label for="inspiry_floor_plan_size_{{data}}"><?php esc_html_e( 'Floor Size', 'framework' ); ?>
                                        <span><?php esc_html_e( '( Only digits )', 'framework' ); ?></span></label>
                                    <input type="text" id="inspiry_floor_plan_size_{{data}}"
                                           name="inspiry_floor_plans[{{data}}][inspiry_floor_plan_size]" value="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="inspiry-field">
                                    <label for="inspiry_floor_plan_size_postfix_{{data}}"><?php esc_html_e( 'Size Postfix', 'framework' ); ?></label>
                                    <input type="text" id="inspiry_floor_plan_size_postfix_{{data}}"
                                           name="inspiry_floor_plans[{{data}}][inspiry_floor_plan_size_postfix]"
                                           value="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="inspiry-field">
                                    <label for="inspiry_floor_plan_bedrooms_{{data}}"><?php esc_html_e( 'Bedrooms', 'framework' ); ?></label>
                                    <input type="text" id="inspiry_floor_plan_bedrooms_{{data}}"
                                           name="inspiry_floor_plans[{{data}}][inspiry_floor_plan_bedrooms]" value="">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="inspiry-field">
                                    <label for="inspiry_floor_plan_bathrooms_{{data}}"><?php esc_html_e( 'Bathrooms', 'framework' ); ?></label>
                                    <input type="text" id="inspiry_floor_plan_bathrooms_{{data}}"
                                           name="inspiry_floor_plans[{{data}}][inspiry_floor_plan_bathrooms]" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="inspiry-remove-clone"><i class="fas fa-minus"></i></button>
            </div>
        </script>
        <script id="tmpl-additional-details" type="text/template">
            <div class="inspiry-detail">
                <div class="inspiry-detail-sort-handle"><i class="fas fa-grip-horizontal"></i></div>
                <div class="inspiry-detail-title">
                    <input type="text" name="detail-titles[]"
                           placeholder="<?php esc_attr_e( 'Title', 'framework' ); ?>"/>
                </div>
                <div class="inspiry-detail-value">
                    <input type="text" name="detail-values[]"
                           placeholder="<?php esc_attr_e( 'Value', 'framework' ); ?>"/>
                </div>
                <div class="inspiry-detail-remove-detail">
                    <button class="remove-detail btn btn-primary"><i class="fas fa-trash-alt"></i></button>
                </div>
            </div>
        </script>
        <script id="tmpl-dashboard-notice" type="text/template">
            <div class="dashboard-notice {{ data.type }} is-dismissible">
                <p>{{ data.message }}</p>
                <button type="button" class="dashboard-notice-dismiss-button"><i class="fas fa-times"></i></button>
            </div>
        </script>
        <script id="tmpl-video-group" type="text/template">
			<?php
			$inspiry_video_group_fields = array(
				array( 'name' => 'inspiry_video_group[{{data}}][inspiry_video_group_title]' ),
				array( 'name' => 'inspiry_video_group[{{data}}][inspiry_video_group_url]' )
			);
			inspiry_repeater_group( $inspiry_video_group_fields, true );
			?>
        </script>
		<?php
		if ( inspiry_is_rvr_enabled() ) :
			/**
			 * Js templates for RVR repeater fields.
			 *
			 * @since 3.13.0
			 */
			?>
            <script id="tmpl-rvr-outdoor-features" type="text/template">
				<?php
				$rvr_outdoor_features_fields = array( array( 'name' => 'rvr_outdoor_features[]' ) );
				inspiry_repeater_group( $rvr_outdoor_features_fields, true );
				?>
            </script>
            <script id="tmpl-rvr-included" type="text/template">
				<?php
				$rvr_included_fields = array( array( 'name' => 'rvr_included[]' ) );
				inspiry_repeater_group( $rvr_included_fields, true );
				?>
            </script>
            <script id="tmpl-rvr-not-included" type="text/template">
				<?php
				$rvr_not_included_fields = array( array( 'name' => 'rvr_not_included[]' ) );
				inspiry_repeater_group( $rvr_not_included_fields, true );
				?>
            </script>
            <script id="tmpl-rvr-surroundings" type="text/template">
				<?php
				$rvr_surroundings_fields = array(
					array( 'name' => 'rvr_surroundings[{{data}}][rvr_surrounding_point]' ),
					array( 'name' => 'rvr_surroundings[{{data}}][rvr_surrounding_point_distance]' )
				);
				inspiry_repeater_group( $rvr_surroundings_fields, true );
				?>
            </script>
            <script id="tmpl-rvr-policies" type="text/template">
				<?php
				$rvr_policies_fields = array(
					array( 'name' => 'rvr_policies[{{data}}][rvr_policy_detail]' ),
					array( 'name' => 'rvr_policies[{{data}}][rvr_policy_icon]' )
				);
				inspiry_repeater_group( $rvr_policies_fields, true );
				?>
            </script>
		<?php
		endif;
	}

	add_action( "wp_footer", "realhomes_dashboard_js_templates" );
}

if ( ! function_exists( 'realhomes_dashboard_assets' ) ) {
	/**
	 * Provides dashboard assets.
	 *
	 * @since 3.12
	 */
	function realhomes_dashboard_assets() {

		if ( ! is_page_template( 'templates/dashboard.php' ) ) {
			return;
		}

		// Bootstrap Select
		wp_enqueue_style(
			'vendors-css',
			get_theme_file_uri( 'common/js/vendors/bootstrap-select/bootstrap-select.min.css' ),
			array(),
			INSPIRY_THEME_VERSION,
			'all'
		);

		// Google Fonts
		wp_enqueue_style(
			'dashboard-font',
			inspiry_google_fonts(),
			array(),
			INSPIRY_THEME_VERSION
		);

		// FontAwesome 5
		wp_enqueue_style( 'font-awesome-5-all',
			get_theme_file_uri( 'common/font-awesome/css/all.min.css' ),
			array(),
			'5.13.1',
			'all'
		);


		// Dashboard Styles
		wp_enqueue_style(
			'dashboard-styles',
			get_theme_file_uri( 'common/css/dashboard.min.css' ),
			array(),
			INSPIRY_THEME_VERSION,
			'all'
		);

		// Adds inline dashboard styles
		wp_add_inline_style( 'dashboard-styles', apply_filters( 'realhomes_dashboard_custom_css', '' ) );

		// Remove ERE plugin script
		wp_dequeue_script( 'ere-frontend' );

		// Bootstrap plugin script
		wp_enqueue_script(
			'bootstrap-min',
			get_theme_file_uri( 'common/js/vendors/bootstrap-select/bootstrap.min.js' ),
			array( 'jquery' ),
			INSPIRY_THEME_VERSION,
			true
		);

		wp_enqueue_script(
			'bootstrap-select-min',
			get_theme_file_uri( 'common/js/vendors/bootstrap-select/bootstrap-select.min.js' ),
			array( 'jquery' ),
			INSPIRY_THEME_VERSION,
			true
		);

		// Login Script
		if ( ! is_user_logged_in() ) {
			wp_enqueue_script(
				'inspiry-login',
				get_theme_file_uri( 'common/js/inspiry-login.js' ),
				array( 'jquery' ),
				INSPIRY_THEME_VERSION,
				true
			);
		}

		// jQuery validate
		wp_enqueue_script(
			'jquery-validate',
			get_theme_file_uri( 'common/js/vendors/jquery.validate.min.js' ),
			array( 'jquery', 'jquery-form' ),
			INSPIRY_THEME_VERSION,
			true
		);

		// Maps Script
		wp_enqueue_script( 'jquery-ui-autocomplete' );
		if ( 'google-maps' == inspiry_get_maps_type() ) {
			inspiry_enqueue_google_maps();
		} else {
			inspiry_enqueue_open_street_map();
		}

		// Google reCaptcha
		if ( class_exists( 'Easy_Real_Estate' ) && ere_is_reCAPTCHA_configured() ) {
			$reCPATCHA_type = get_option( 'inspiry_reCAPTCHA_type', 'v2' );

			if ( 'v3' === $reCPATCHA_type ) {
				$render = get_option( 'theme_recaptcha_public_key' );
			} else {
				$render = 'explicit';
			}

			$recaptcha_src = esc_url_raw( add_query_arg( array(
				'render' => $render,
				'onload' => 'loadInspiryReCAPTCHA',
			), '//www.google.com/recaptcha/api.js' ) );

			// Enqueue google reCAPTCHA API.
			wp_enqueue_script( 'rh-google-recaptcha', $recaptcha_src, array(), INSPIRY_THEME_VERSION, true );
		}

		// WP Picker
		if ( in_array( 'label-and-color', inspiry_get_submit_fields(), true ) ) {

			wp_enqueue_style( 'wp-color-picker' );

			wp_enqueue_script(
				'iris',
				admin_url( 'js/iris.min.js' ),
				array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ),
				false,
				1
			);

			wp_enqueue_script(
				'wp-color-picker',
				admin_url( 'js/color-picker.min.js' ),
				array( 'iris' ),
				false,
				1
			);
		}

		// locations related script
		wp_enqueue_script(
			'realhomes-locations',
			get_theme_file_uri( 'common/js/locations.js' ),
			array( 'jquery' ),
			INSPIRY_THEME_VERSION,
			true
		);

		// Dashboard Scrips
		wp_enqueue_script(
			'dashboard-js',
			get_theme_file_uri( 'common/js/dashboard.js' ),
			array( 'jquery', 'wp-util', 'jquery-ui-sortable', 'plupload' ),
			INSPIRY_THEME_VERSION,
			true
		);

		// Dashboard js data.
		$dashboard_data = array(
			'url'               => esc_url( realhomes_get_dashboard_page_url() ),
			'ajaxURL'           => admin_url( 'admin-ajax.php' ),
			'uploadNonce'       => wp_create_nonce( 'inspiry_allow_upload' ),
			'fileTypeTitle'     => esc_html__( 'Valid file formats', 'framework' ),
			'cancel_membership' => esc_html__( 'Cancel Membership', 'framework' ),
			'clear'             => esc_html__( 'Clear', 'framework' ),
			'pick'              => esc_html__( 'Select Color', 'framework' ),
			'select_noResult'   => get_option( 'inspiry_select2_no_result_string', esc_html__( 'No Results Found!', 'framework' ), true ),
			'searching_string'  => esc_html__( 'Searching...', 'framework' ),
			'loadingMore'       => esc_html__( 'Loading more results...', 'framework' ),
			'returnValue'       => esc_html__( 'Are you sure you want to exit?', 'framework' ),
			'local'             => get_option( 'ere_price_number_format_language', 'en-US' ),
		);

		// Adds inline dashboard script
		wp_localize_script( 'dashboard-js', 'dashboardData', $dashboard_data );

		if ( isset( $_GET['ask-for-login'] ) && ! empty( $_GET['ask-for-login'] && $_GET['ask-for-login'] === 'true' ) ) {
			wp_add_inline_script( 'dashboard-js', "jQuery(document).ready(function(){ jQuery('body .ask-for-login').trigger('click'); });" );
		}
	}

	add_action( 'wp_enqueue_scripts', 'realhomes_dashboard_assets' );
}

if ( ! function_exists( 'realhomes_dashboard_color_settings' ) ) {
	/**
	 * Provides dashboard color settings list.
	 *
	 * @since 3.12
	 *
	 * @return array
	 */
	function realhomes_dashboard_color_settings() {

		$color_settings = array(
			array(
				'id'      => 'primary_color',
				'label'   => esc_html__( 'Primary Color', 'framework' ),
				'default' => '#1ea69a'
			),
			array(
				'id'      => 'secondary_color',
				'label'   => esc_html__( 'Secondary Color', 'framework' ),
				'default' => '#ea723d'
			),
			array(
				'id'      => 'body_color',
				'label'   => esc_html__( 'Body Text Color', 'framework' ),
				'default' => '#808080'
			),
			array(
				'id'      => 'heading_color',
				'label'   => esc_html__( 'Heading Color', 'framework' ),
				'default' => '#333333'
			),
			array(
				'id'      => 'link_color',
				'label'   => esc_html__( 'Link Color', 'framework' ),
				'default' => '#333333'
			),
			array(
				'id'      => 'link_hover_color',
				'label'   => esc_html__( 'Link Hover Color', 'framework' ),
				'default' => '#e86126'
			),
			array(
				'id'      => 'logo_container_bg_color',
				'label'   => esc_html__( 'Logo Background Color', 'framework' ),
				'default' => '#2f3534'
			),
			array(
				'id'      => 'logo_color',
				'label'   => esc_html__( 'Logo Color', 'framework' ),
				'default' => '#fff'
			),
			array(
				'id'      => 'logo_hover_color',
				'label'   => esc_html__( 'Logo Hover Color', 'framework' ),
				'default' => '#fff'
			),
			array(
				'id'      => 'sidebar_bg_color',
				'label'   => esc_html__( 'Sidebar Background Color', 'framework' ),
				'default' => '#1e2323'
			),
			array(
				'id'      => 'sidebar_menu_color',
				'label'   => esc_html__( 'Sidebar Menu Text Color', 'framework' ),
				'default' => '#91afad'
			),
			array(
				'id'      => 'sidebar_menu_bg_color',
				'label'   => esc_html__( 'Sidebar Menu Background Color', 'framework' ),
				'default' => '#1e2323'
			),
			array(
				'id'      => 'sidebar_menu_hover_color',
				'label'   => esc_html__( 'Sidebar Menu Text Hover Color', 'framework' ),
				'default' => '#ffffff'
			),
			array(
				'id'      => 'sidebar_menu_hover_bg_color',
				'label'   => esc_html__( 'Sidebar Menu Hover Background Color', 'framework' ),
				'default' => '#1e3331'
			),
			array(
				'id'      => 'sidebar_current_submenu_color',
				'label'   => esc_html__( 'Sidebar Active Submenu Text Color', 'framework' ),
				'default' => '#ffffff'
			),
			array(
				'id'      => 'sidebar_current_submenu_bg_color',
				'label'   => esc_html__( 'Sidebar Active Submenu Background Color', 'framework' ),
				'default' => '#171b1b'
			),
		);

		/**
		 * Membership package color settings.
		 * @since  3.12
		 */
		if ( class_exists( 'IMS_Helper_Functions' ) ) {

			$color_settings[] = array(
				'id'      => 'package_background_color',
				'label'   => esc_html__( 'Membership Package Background Color', 'framework' ),
				'default' => '#d5f0eb'
			);

			$color_settings[] = array(
				'id'      => 'popular_package_background_color',
				'label'   => esc_html__( 'Popular Membership Package Background Color', 'framework' ),
				'default' => '#f7daca'
			);
		}

		return $color_settings;
	}
}

if ( ! function_exists( 'realhomes_dashboard_dynamic_css' ) ) {
	/**
	 * Adds dashboard dynamic css.
	 *
	 * @since 3.12
	 *
	 * @param $custom_css
	 *
	 * @return string
	 */
	function realhomes_dashboard_dynamic_css( $custom_css ) {

		$color_settings = realhomes_dashboard_color_settings();

		$custom_css .= ":root {";

		if ( is_array( $color_settings ) && ! empty( $color_settings ) ) {
			foreach ( $color_settings as $setting ) {
				$custom_css .= sprintf( '--dashboard-%s: %s;', str_replace( '_', '-', esc_html( $setting['id'] ) ), get_option( 'inspiry_dashboard_' . $setting['id'], $setting['default'] ) );
			}
		}

		$custom_css .= sprintf( '--dashboard-primary-hover-color: %s;', inspiry_hex_darken( get_option( 'inspiry_dashboard_primary_color', '#1ea69a' ), 5 ) );
		$custom_css .= sprintf( '--dashboard-secondary-hover-color: %s;', inspiry_hex_darken( get_option( 'inspiry_dashboard_secondary_color', '#ea723d' ), 5 ) );

		$custom_css .= "}";

		return $custom_css;
	}

	add_filter( 'realhomes_dashboard_custom_css', 'realhomes_dashboard_dynamic_css' );
}
