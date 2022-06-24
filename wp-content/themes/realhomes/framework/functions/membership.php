<?php
/**
 * Membership Functions
 *
 * Inspiry Memberships related functions file.
 *
 * @since    2.6.4
 * @package RealHomes
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


if ( ! function_exists( 'inspiry_add_membership_hooks' ) ) {
	/**
	 * Add hooks of membership related functions.
	 *
	 * @since 1.0.0
	 */
	function inspiry_add_membership_hooks() {

		// If inspiry memberships plugin is not active then return.
		if ( ! inspiry_is_ims_plugin_activated() ) {
			return;
		}

		// If membership module is not enabled then return.
		$ims_helper_functions  = IMS_Helper_Functions();
		$is_memberships_enable = $ims_helper_functions::is_memberships();

		if ( empty( $is_memberships_enable ) ) {
			return;
		}

		// Before property submit or update.
		add_filter( 'inspiry_before_property_submit', 'inspiry_filter_property_before_submit', 10, 1 );
		add_filter( 'inspiry_before_property_update', 'inspiry_filter_property_before_update', 10, 1 );

		// After property submit or update.
		add_action( 'inspiry_after_property_submit', 'inspiry_update_featured_props_number', 10, 1 );
		add_action( 'inspiry_after_property_update', 'inspiry_update_featured_props_number', 10, 1 );

		// some other hooks.
		add_filter( 'pre_delete_post', 'inspiry_update_package_numbers', 10, 3 );     // Update properties and featured tags remaining numbers.
		add_action( 'transition_post_status', 'inspiry_update_props_number', 10, 3 ); // Update properties remaing numbers.
	}

	add_action( 'init', 'inspiry_add_membership_hooks' );
}

if ( ! function_exists( 'inspiry_is_ims_plugin_activated' ) ) {
	/**
	 * Checks if memberships plugin is activated.
	 *
	 * @since 3.13
	 *
	 * @return bool
	 */
	function inspiry_is_ims_plugin_activated() {

		if ( class_exists( 'IMS_Helper_Functions' ) ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_is_membership_enabled' ) ) {
	/**
	 * Checks if memberships plugin is enabled.
	 *
	 * @since 3.13
	 *
	 * @return bool
	 */
	function inspiry_is_membership_enabled() {

		if ( inspiry_is_ims_plugin_activated() ) {
			if ( ! empty( IMS_Helper_Functions::is_memberships() ) ) {
				return true;
			}
		}

		return false;
	}
}

if ( ! function_exists( 'realhomes_is_wc_ims_payment_enabled' ) ) {
	/**
	 * Check if woocommerce payments method enabled.
	 */
	function realhomes_is_wc_ims_payment_enabled() {

		$ims_basic_settings = get_option( 'ims_basic_settings' );

		if ( ! empty( $ims_basic_settings['ims_payment_method'] ) ) {
			$payment_method = $ims_basic_settings['ims_payment_method'];
		} else {
			$payment_method = 'custom';
		}

		if ( class_exists( 'WooCommerce' ) && class_exists( 'Realhomes_WC_Payments_Addon' ) && 'woocommerce' === $payment_method ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_has_user_membership' ) ) {
	/**
	 * Checks if the current user has a memberships package or not.
	 *
	 * @since 3.13
	 *
	 * @return bool
	 */
	function inspiry_has_user_membership() {

		if ( inspiry_is_membership_enabled() ) {
			$membership = IMS_Helper_Functions::ims_get_membership_by_user( wp_get_current_user() );
			if ( is_array( $membership ) && ! empty( $membership ) ) {
				return true;
			}
		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_no_membership_disable_stuff' ) ) {
	/**
	 * Disables the submit property functionality based on customizer setting 'inspiry_disable_submit_property' enabled and user has no membership package.
	 *
	 * @since 3.13
	 *
	 * @return bool
	 */
	function inspiry_no_membership_disable_stuff() {

		// Check if inspiry memberships plugin is enabled.
		if ( ! inspiry_is_membership_enabled() ) {
			return true;
		}

		// Check submit property customizer option.
		if ( 'false' === get_option( 'inspiry_disable_submit_property', 'true' ) ) {
			return true;
		}

		// Check if the current user has a memberships package.
		if ( inspiry_has_user_membership() ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_get_properties_by_user' ) ) {
	function inspiry_get_properties_by_user( $user_id, $post_status = 'publish', $posts_per_page = -1, $order = 'DESC' ) {

		if ( empty( $user_id ) || 0 >= $user_id ) {
			return false;
		}

		return get_posts( array(
			'author'         => $user_id,
			'post_type'      => 'property',
			'post_status'    => $post_status,
			'posts_per_page' => $posts_per_page,
			'order'          => $order,
		) );
	}
}

if ( ! function_exists( 'inspiry_get_featured_properties_by_user' ) ) {
	function inspiry_get_featured_properties_by_user( $user_id, $post_status = array( 'publish' ), $posts_per_page = - 1, $order = 'DESC' ) {

		if ( empty( $user_id ) || 0 >= $user_id ) {
			return false;
		}

		return get_posts( array(
			'author'         => $user_id,
			'post_type'      => 'property',
			'post_status'    => $post_status,
			'posts_per_page' => $posts_per_page,
			'order'          => $order,
			'meta_compare'   => '=',
			'meta_key'       => 'REAL_HOMES_featured',
			'meta_value'     => '1',
		) );
	}
}

if ( ! function_exists( 'inspiry_filter_property_before_submit' ) ) {
	/**
	 * Filter property arguments before submitting it on
	 * the frontend.
	 *
	 * @since 2.6.4
	 */
	function inspiry_filter_property_before_submit( $property ) {

		// Get current user.
		$current_user    = wp_get_current_user();
		$current_user_id = $current_user->ID;

		// Get current user membership.
		$current_membership = get_user_meta( $current_user_id, 'ims_current_membership', true );

		// Add appropriate post status to property before publishing it.
		if ( ! empty( $current_membership ) ) {

			// Get current number of properties
			$current_properties = get_user_meta( $current_user_id, 'ims_current_properties', true );

			if ( ! empty( $current_properties ) && $current_properties >= 1 && 'true' === get_option( 'theme_publish_on_payment' ) ) {
				$property['post_status'] = 'publish';
			} elseif ( empty( $current_properties ) || ( 0 == $current_properties ) ) {
				$property['post_status'] = 'pending';
			}

		} elseif ( empty( $current_membership ) ) {
			$property['post_status'] = 'pending';
		}

		return $property;
	}
}

if ( ! function_exists( 'inspiry_filter_property_before_update' ) ) {
	/**
	 * Filter property arguments before updating it on
	 * the frontend.
	 *
	 * @since 2.6.4
	 */
	function inspiry_filter_property_before_update( $property ) {

		// Get current user.
		$current_user    = wp_get_current_user();
		$current_user_id = $current_user->ID;

		// Get current user membership.
		$current_membership = get_user_meta( $current_user_id, 'ims_current_membership', true );

		// Add appropriate post status to property before publishing it.
		if ( ! empty( $current_membership ) ) {

			// Get property status
			$property_status = get_post_status( $property['ID'] );

			// Get current number of properties
			$current_properties = get_user_meta( $current_user_id, 'ims_current_properties', true );

			// Get default status for update property.
			$updated_property_default_status = get_option( 'inspiry_updated_property_status', 'publish' );

			if ( ! empty( $current_properties ) && $current_properties >= 1 ) {
				$property['post_status'] = $updated_property_default_status;
			} elseif ( ( 'publish' !== $property_status ) && ( empty( $current_properties ) || ( 0 == $current_properties ) ) ) {
				$property['post_status'] = 'pending';
			} elseif ( ( 'publish' === $property_status ) && ( empty( $current_properties ) || ( 0 == $current_properties ) ) ) {
				$property['post_status'] = $updated_property_default_status;
			}

		} elseif ( empty( $current_membership ) ) {
			$property['post_status'] = 'pending';
		}

		return $property;
	}
}

if ( ! function_exists( 'inspiry_update_props_number' ) ) {
	/**
	 * Update number of properties in user meta for memberships
	 * when property is posted.
	 *
	 * @since 2.6.4
	 */
	function inspiry_update_props_number( $new, $old, $post ) {

		if ( 'property' === $post->post_type ) {

			// Get current user id.
			$user_id = $post->post_author;

			if ( ! empty( $user_id ) ) {
				// Get current number of properties.
				$current_properties = get_user_meta( $user_id, 'ims_current_properties', true );
			}

			if ( 'trash' === $new ) {
				++$current_properties;
			} elseif ( ( 'publish' === $new ) && ( 'publish' !== $old ) ) {
				--$current_properties;
			}

			if ( $current_properties > 0 ) {
				update_user_meta( $user_id, 'ims_current_properties', $current_properties );
			} else {
				update_user_meta( $user_id, 'ims_current_properties', 0 );
			}
		}
	}
}

if ( ! function_exists( 'inspiry_update_featured_props_number' ) ) {
	/**
	 * Save number of featured properties in user meta for
	 * memberships when property is posted.
	 *
	 * @param int $property_id
	 *
	 * @since 2.6.4
	 */
	function inspiry_update_featured_props_number( $property_id ) {

		// Get property.
		$property = get_post( $property_id );

		if ( ! empty( $property ) ) {

			// Get post author id.
			$user_id = $property->post_author;

			// Get remaining number of featured properties.
			$remaining_properties = get_user_meta( $user_id, 'ims_current_featured_props', true );

			// Check if current property is featured.
			$is_property_featured  = get_post_meta( $property_id, 'REAL_HOMES_featured', true );
			$was_property_featured = get_post_meta( $property_id, 'inspiry_prop_was_featured', true );

			if ( $is_property_featured && ! $was_property_featured ) {

				if ( ( intval( $remaining_properties ) - 1 ) >= 0 ) {
					update_user_meta( $user_id, 'ims_current_featured_props', $remaining_properties - 1 );

					// To check on next property update if property wouldn't be featured anymore.
					update_post_meta( $property_id, 'inspiry_prop_was_featured', 1 );
				} else {
					update_user_meta( $user_id, 'ims_current_featured_props', 0 );
					update_post_meta( $property_id, 'REAL_HOMES_featured', 0 );
				}
			} elseif ( ! $is_property_featured && $was_property_featured ) {

				update_post_meta( $property_id, 'inspiry_prop_was_featured', 0 );

				++$remaining_properties;
				update_user_meta( $user_id, 'ims_current_featured_props', $remaining_properties );
			}
		}
	}
}

if ( ! function_exists( 'inspiry_update_package_numbers' ) ) {
	/**
	 * Update: Properties number when property is deleted.
	 *
	 * @since 2.6.4
	 */
	function inspiry_update_package_numbers( $null, $property, $force_delete ) {

		// Get property ID.
		$property_id = $property->ID;

		// Check if the post type is property.
		if ( ! empty( $property_id ) && 'property' === $property->post_type && 'publish' === $property->post_status ) {

			// Get property author id.
			$user_id = $property->post_author;

			$current_properties = get_user_meta( $user_id, 'ims_current_properties', true ); // Get current number of properties.
			$package_properties = get_user_meta( $user_id, 'ims_package_properties', true ); // Get allowed number of properties.

			// Update current properties number.
			if ( $current_properties < $package_properties ) {
				update_user_meta( $user_id, 'ims_current_properties', $current_properties + 1 );
			}

			$is_property_featured = get_post_meta( $property_id, 'REAL_HOMES_featured', true );    // Check if the post was featured or not.
			$featured_properties  = get_user_meta( $user_id, 'ims_current_featured_props', true ); // Get current number of featured properties.
			$package_featured     = get_user_meta( $user_id, 'ims_package_featured_props', true ); // Get allowed number of featured properties.

			if ( ! empty( $is_property_featured ) && ( $featured_properties < $package_featured ) ) {
				update_user_meta( $user_id, 'ims_current_featured_props', $featured_properties + 1 );
			}
		}
	}
}

if ( ! function_exists( 'inspiry_update_properties' ) ) {
	/**
	 * Do the stuff on a membership cancellation.
	 *
	 * @param int $user_id       - User ID of whom membership being cancelled.
	 * @param int $membership_id - Membership ID that's being cancelled.
	 */
	function inspiry_update_properties( $user_id = 0, $membership_id = 0 ) {

		// Return if any of the parameters is empty.
		if ( empty( $user_id ) || empty( $membership_id ) ) {
			return;
		}

		$properties_args = array(
			'author'         => $user_id,
			'post_type'      => 'property',
			'post_status'    => array( 'publish' ),
			'posts_per_page' => -1,
		);

		/**
		 * Get all published properties and change their status to pending.
		 */
		$properties = get_posts( $properties_args );
		if ( ! empty( $properties ) ) {
			foreach ( $properties as $property ) {
				$property_args = array(
					'ID'          => $property->ID,
					'post_status' => 'pending',
				);
				wp_update_post( $property_args );
			}
		}
	}

	add_action( 'ims_user_membership_cancelled', 'inspiry_update_properties', 10, 2 );
}

if ( ! function_exists( 'inspiry_update_membership_benefits' ) ) {
	/**
	 * Update user membership benefits on buying another membership.
	 *
	 * @param int $user_id               - User ID of whom membership is being updated.
	 * @param int $prev_membership_id    - Previoud Membership ID.
	 * @param int $current_membership_id - Current Membership ID.
	 */
	function inspiry_update_membership_benefits( $user_id, $prev_membership_id, $current_membership_id ) {

		// Return if any of the parameters is empty.
		if ( empty( $user_id ) || empty( $prev_membership_id ) || empty( $current_membership_id ) ) {
			return false;
		}

		$current_membership = ims_get_membership_object( $current_membership_id );

		/**
		 * Updating Properties status.
		 */

		// Update properties.
		$allowed_properties_count = $current_membership->get_properties();

		// Get pending properties that can be published on upgrading membership.
		$user_properties = inspiry_get_properties_by_user( $user_id, array( 'publish', 'pending', 'draft' ) );

		if ( ! empty( $user_properties ) ) {
			$published_counter = 0;
			foreach ( $user_properties as $property ) {
				if ( $published_counter < $allowed_properties_count ) {
					$property_status = 'publish';
					$published_counter++;
				} else {
					$property_status = 'pending';
				}
				$property_args = array(
					'ID'          => $property->ID,
					'post_status' => $property_status,
				);
				wp_update_post( $property_args );
			}
		}

		update_user_meta( $user_id, 'ims_current_properties', $allowed_properties_count - $published_counter );

		/**
		 * Updating Properties Featured Tag.
		 */
		$allowed_featured_count = $current_membership->get_featured_properties();
		$featured_properties    = inspiry_get_featured_properties_by_user( $user_id );
		$user_featured_count    = count( $featured_properties );

		if ( $allowed_featured_count < $user_featured_count ) {
			if ( ! empty( $featured_properties ) ) {
				$featured_counter = 0;
				foreach ( $featured_properties as $featured_property ) {
					if ( $featured_counter < $allowed_featured_count ) {
						$featured_counter++;
					} else {
						update_post_meta( $featured_property->ID, 'REAL_HOMES_featured', false );
					}
				}
			}
		} else {
			$featured_counter = $user_featured_count;
		}

		update_user_meta( $user_id, 'ims_current_featured_props', $allowed_featured_count - $featured_counter );
	}

	add_action( 'ims_user_membership_updated', 'inspiry_update_membership_benefits', 10, 3 );
}

if ( ! function_exists( 'inspiry_add_membership' ) ) {
	/**
	 * Manage properties while buying a membership.
	 *
	 * @since 1.0.0
	 */
	function inspiry_add_membership( $user_id, $membership_id ) {

		// If inspiry memberships plugin is not active then return.
		if ( ! function_exists( 'ims_get_membership_object' ) ) {
			return false;
		}

		// Bail if parameters are empty.
		if ( empty( $user_id ) || empty( $membership_id ) ) {
			return false;
		}

		$membership_obj             = ims_get_membership_object( $membership_id );
		$properties_number          = $membership_obj->get_properties();
		$featured_properties_number = $membership_obj->get_featured_properties();

		/**
		 * The WordPress Query class.
		 * @link http://codex.wordpress.org/Function_Reference/WP_Query
		 *
		 */
		$properties_args = array(
			'author'         => $user_id, // Author Parameters
			'post_type'      => 'property', // Type & Status Parameters
			'post_status'    => array( 'pending' ),
			'posts_per_page' => -1
		);

		// Get properties of the user.
		$properties     = get_posts( $properties_args );
		$count          = count( $properties );
		$featured_count = 0;

		if ( $count <= $properties_number ) {

			if ( ! empty( $properties ) ) {

				foreach ( $properties as $property ) {

					// Update the property status to publish.
					$property_args = array(
						'ID'          => $property->ID,
						'post_status' => 'publish'
					);
					wp_update_post( $property_args );

					/**
					 * Get featured meta of property and update
					 * the number of featured properties
					 * accordingly.
					 */
					$is_featured = get_post_meta( $property->ID, 'REAL_HOMES_featured', true );

					if ( ! empty( $is_featured ) && ( $featured_count < $featured_properties_number ) ) {
						$featured_count ++;
					} elseif ( ! empty( $is_featured ) && ( $featured_count >= $featured_properties_number ) ) {
						update_post_meta( $property->ID, 'REAL_HOMES_featured', false );
						update_post_meta( $property->ID, 'pre_feature_state', false );
					}

				}

				$featured_difference = $featured_properties_number - $featured_count;
				update_user_meta( $user_id, 'ims_current_featured_props', $featured_difference );

			}

			// Deduct the number of properties already present.
			$difference = $properties_number - $count;
			update_user_meta( $user_id, 'ims_current_properties', $difference );

		} elseif ( $count > $properties_number ) {

			if ( ! empty( $properties ) ) {

				foreach ( $properties as $property ) {

					/**
					 * When properties count reaches zero,
					 * turn the remaining properties to pending.
					 */
					if ( $properties_number > 0 ) {

						$property_args = array(
							'ID'          => $property->ID,
							'post_status' => 'publish'
						);
						wp_update_post( $property_args );
						$properties_number --;

					} elseif ( $properties_number <= 0 ) {

						$property_args = array(
							'ID'          => $property->ID,
							'post_status' => 'pending'
						);
						wp_update_post( $property_args );

					}

					/**
					 * Get featured meta of property and update
					 * the number of featured properties
					 * accordingly.
					 */
					$is_featured = get_post_meta( $property->ID, 'REAL_HOMES_featured', true );

					if ( ! empty( $is_featured ) && ( $featured_count < $featured_properties_number ) ) {
						$featured_count ++;
					} elseif ( ! empty( $is_featured ) && ( $featured_count >= $featured_properties_number ) ) {
						update_post_meta( $property->ID, 'REAL_HOMES_featured', false );
						update_post_meta( $property->ID, 'pre_feature_state', false );
					}

				}

				update_user_meta( $user_id, 'ims_current_properties', $properties_number );
				$featured_difference = $featured_properties_number - $featured_count;
				update_user_meta( $user_id, 'ims_current_featured_props', $featured_difference );

			}
		}
	}

	add_action( 'ims_add_user_membership', 'inspiry_add_membership', 10, 2 );
}

if ( ! function_exists( 'inspiry_user_membership_update_routine' ) ) {
	/**
	 * This method updates the number of properties after modification
	 * of the membership from admin panel.
	 *
	 * @since 2.6.4
	 */
	function inspiry_user_membership_update_routine( $user_id, $membership_id, $prev_membership_details ) {

		// Bail if parameters are empty.
		if ( empty( $user_id ) || empty( $membership_id ) || empty( $prev_membership_details ) ) {
			return false;
		}

		if ( ! function_exists( 'ims_get_membership_object' ) ) {
			return false;
		}

		// Sanitize the parameters.
		$user_id       = intval( $user_id );
		$membership_id = intval( $membership_id );

		// Extracting previous membership details.
		$prev_package_properties = ( isset( $prev_membership_details['package_properties'] ) ) ? $prev_membership_details['package_properties'] : false;
		$prev_current_properties = ( isset( $prev_membership_details['current_properties'] ) ) ? $prev_membership_details['current_properties'] : false;
		$prev_package_featured   = ( isset( $prev_membership_details['package_featured'] ) ) ? $prev_membership_details['package_featured'] : false;
		$prev_current_featured   = ( isset( $prev_membership_details['current_featured'] ) ) ? $prev_membership_details['current_featured'] : false;

		// Getting new membership details.
		$membership_obj = ims_get_membership_object( $membership_id );
		$properties     = $membership_obj->get_properties();
		$featured_props = $membership_obj->get_featured_properties();

		// Package properties use cases checks.
		if ( $properties == $prev_package_properties ) {
			// Do nothing.
		} elseif ( $properties > $prev_package_properties ) {

			$user_properties = $prev_package_properties - $prev_current_properties;
			update_user_meta( $user_id, 'ims_current_properties', $properties - $user_properties );


		} elseif ( $properties < $prev_package_properties ) {

			$user_properties = $prev_package_properties - $prev_current_properties;

			if ( $properties >= $user_properties ) {
				update_user_meta( $user_id, 'ims_current_properties', $properties - $user_properties );
			} elseif ( $properties < $user_properties ) {

				$number_of_properties_to_update = $user_properties - $properties;
				$properties_to_update           = inspiry_get_properties_by_user( $user_id, 'publish', $number_of_properties_to_update, 'ASC' );

				if ( ! empty( $properties_to_update ) ) {
					foreach ( $properties_to_update as $property ) {
						$property_args = array(
							'ID'          => $property->ID,
							'post_status' => 'pending',
						);
						wp_update_post( $property_args );
					}
				}
				update_user_meta( $user_id, 'ims_current_properties', 0 );
			}
		}

		// Package featured properties use cases checks.
		if ( $featured_props == $prev_package_featured ) {
			// Do nothing.
		} elseif ( $featured_props > $prev_package_featured ) {

			$user_featured_properties = $prev_package_featured - $prev_current_featured;
			update_user_meta( $user_id, 'ims_current_featured_props', $featured_props - $user_featured_properties );

		} elseif ( $featured_props < $prev_package_featured ) {

			$user_featured_properties = $prev_package_featured - $prev_current_featured;

			if ( $featured_props >= $user_featured_properties ) {
				update_user_meta( $user_id, 'ims_current_featured_props', $featured_props - $user_featured_properties );
			} elseif ( $featured_props < $user_featured_properties ) {

				$number_of_properties_to_update = $user_featured_properties - $featured_props;
				$properties_to_update           = inspiry_get_featured_properties_by_user( $user_id, array( 'publish' ), $number_of_properties_to_update, 'ASC' );

				if ( ! empty( $properties_to_update ) ) {
					foreach ( $properties_to_update as $property ) {
						update_post_meta( $property->ID, 'REAL_HOMES_featured', false );
						update_post_meta( $property->ID, 'pre_feature_state', false );
					}
				}
				update_user_meta( $user_id, 'ims_current_featured_props', 0 );
			}
		}
	}

	add_action( 'ims_update_user_recurring_membership', 'inspiry_user_membership_update_routine', 10, 3 );
}
