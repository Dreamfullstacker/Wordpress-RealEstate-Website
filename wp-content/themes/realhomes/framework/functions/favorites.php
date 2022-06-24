<?php
/**
 *  This file contains functions related to add to favorites feature
 */


if ( ! function_exists( 'add_to_favorite' ) ) {
	/**
	 * Add a property to favorites
	 */
	function add_to_favorite() {

		/* if user is logged in then store in meta data */
		if ( isset( $_POST['property_id'] ) && is_user_logged_in() ) {
			$property_id = intval( $_POST['property_id'] );
			$user_id     = get_current_user_id();
			if ( ( $property_id > 0 ) && ( $user_id > 0 ) ) {
				if ( add_user_meta( $user_id, 'favorite_properties', $property_id ) ) {
					_e( 'Added to Favorites', 'framework' );
				} else {
					_e( 'Failed!', 'framework' );
				}
			}
		} else {
			echo 'false';
		}

		die;
	}

	add_action( 'wp_ajax_add_to_favorite', 'add_to_favorite' );
	add_action( 'wp_ajax_nopriv_add_to_favorite', 'add_to_favorite' );
}

if ( ! function_exists( 'display_favorite_properties' ) ) {
	/**
	 * Display favorite properties on the favorite page (only when user is not logged in).
	 */
	function display_favorite_properties() {

		// Switch the content language to the current WPML language.
		if ( isset( $_GET['wpml_lang'] ) ) {
			do_action( 'wpml_switch_language', sanitize_text_field( wp_unslash( $_GET['wpml_lang'] ) ) );
		}

		$design       = sanitize_text_field( $_POST['design_variation'] );
		$property_ids = $_POST['prop_ids'];

		if ( ! empty( $design ) && is_array( $_POST['prop_ids'] ) ) {

			$count = count( $property_ids );

			// My properties arguments.
			$favorites_properties_args = array(
				'post_type'      => 'property',
				'posts_per_page' => $count,
				'post__in'       => $property_ids,
				'orderby'        => 'post__in',
			);

			$favorites_query = new WP_Query( $favorites_properties_args );

			if ( $favorites_query->have_posts() ) {

				if ( 'dashboard' === $design ) :
					global $dashboard_globals;
					$dashboard_globals['current_module'] = 'favorites';
					?>
                    <div class="dashboard-posts-list">
					<?php get_template_part( 'common/dashboard/property-columns' ); ?>
                    <div class="dashboard-posts-list-body">
				<?php
				endif;

				while ( $favorites_query->have_posts() ) :
					$favorites_query->the_post();
					if ( 'dashboard' === $design ) {
						get_template_part( 'common/dashboard/property-card' );
					} else {
						get_template_part( 'assets/' . $design . '/partials/properties/favorite-card' );
					}
				endwhile;
				wp_reset_postdata();

				if ( 'dashboard' === $design ) :
					?>
                    </div>
                    </div>
				<?php
				endif;

			} else {
				if ( 'modern' === $_POST['design_variation'] ) {
					?>
					<div class="rh_alert-wrapper">
						<h4 class="no-results"><?php esc_html_e( 'No property found!', 'framework' ); ?></h4>
					</div>
					<?php
				} elseif ( 'classic' === $_POST['design_variation'] ) {
					?>
					<div class="alert-wrapper">
						<h4><?php esc_html_e( 'No property found!', 'framework' ); ?></h4>
					</div>
					<?php
				}
			}
		}

		die;
	}
	add_action( 'wp_ajax_display_favorite_properties', 'display_favorite_properties' );
	add_action( 'wp_ajax_nopriv_display_favorite_properties', 'display_favorite_properties' );
}


if ( ! function_exists( 'is_added_to_favorite' ) ) {
	/**
	 * Check if a property is already added to favorites
	 *
	 * @param $property_id
	 * @param $user_id
	 *
	 * @return bool
	 */
	function is_added_to_favorite( $property_id, $user_id = 0 ) {

		if ( $property_id > 0 ) {

			/* if user id is not provided then try to get current user id */
			if ( ! $user_id ) {
				$user_id = get_current_user_id();
			}

			if ( $user_id > 0 ) {
				/* if logged in check in database */
				global $wpdb;
				$results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->usermeta} WHERE meta_key= %s AND meta_value= %s AND user_id= %s", 'favorite_properties', $property_id, $user_id ) );
				if ( isset( $results[0]->meta_value ) && ( $results[0]->meta_value == $property_id ) ) {
					return true;
				}
			}
		}

		return false;
	}
}


if ( ! function_exists( 'remove_from_favorites' ) ) {
	/**
	 * Remove from favorites
	 */
	function remove_from_favorites() {
		if ( isset( $_POST['property_id'] ) ) {
			$property_id = intval( $_POST['property_id'] );
			if ( $property_id > 0 ) {

				if ( is_user_logged_in() ) {
					$user_id = get_current_user_id();

					if ( delete_user_meta( $user_id, 'favorite_properties', $property_id ) ) {
						echo json_encode( array(
								'success' => true,
								'message' => esc_html__( "Property removed form favorites successfully!", 'framework' )
							)
						);
						die;
					} else {
						echo json_encode( array(
								'success' => false,
								'message' => esc_html__( "Failed to remove property form favorites!", 'framework' )
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
	add_action( 'wp_ajax_remove_from_favorites', 'remove_from_favorites' );
	add_action( 'wp_ajax_nopriv_remove_from_favorites', 'remove_from_favorites' );
}

if ( ! function_exists( 'inspiry_favorite_prop_migration' ) ) {
	/**
	 * Migrate local favorited properties to server side.
	 */
	function inspiry_favorite_prop_migration() {

		/* Ensure user login and data intigrity */
		if ( isset( $_POST['prop_ids'] ) && is_array( $_POST['prop_ids'] ) && is_user_logged_in() ) {
			$prop_ids = $_POST['prop_ids'];

			foreach ( $prop_ids as $property_id ) {
				$user_id = get_current_user_id();
				if ( ( $property_id > 0 ) && ( $user_id > 0 ) && ! is_added_to_favorite( $property_id, $user_id ) ) {
					add_user_meta( $user_id, 'favorite_properties', $property_id );
				}
			}
			echo 'true';
		} else {
			echo 'false';
		}

		die();
	}
	add_action( 'wp_ajax_inspiry_favorite_prop_migration', 'inspiry_favorite_prop_migration' );
	add_action( 'wp_ajax_nopriv_inspiry_favorite_prop_migration', 'inspiry_favorite_prop_migration' );
}

if (! function_exists('inspiry_safe_include_favorite_svg_icon')) {
	/**
	 * Include SVG icons 
	 *
	 * @param string   $icon_path svg icon path i.e /common/images/icons/filename.svg
	 */

	function inspiry_include_favorite_svg_icon($icon_path=''){
		if (!empty($icon_path)) {
			inspiry_safe_include_svg($icon_path,'');
		}else{
			inspiry_safe_include_svg('/images/icons/icon-favorite.svg');
		}
	}

}

if ( ! function_exists( 'inspiry_favorite_button' ) ) {
	/**
	 * Display 'Add to Favorite' button
	 *
	 * @param null   $property_id Property ID.
	 * @param bool   $single If button is on property single apge.
	 * @param string $ele_add_label Elementor Label Option Add To Favourite.
	 * @param string $ele_added_label Elementor Label Option Added To Favourite.
	 * @param string $icon_path svg icon path i.e /common/images/icons/filename.svg
	 */
	function inspiry_favorite_button( $property_id = null, $single = false, $ele_add_label = '', $ele_added_label = '', $icon_path = '' ) {

		$fav_button = get_option( 'theme_enable_fav_button' );

		if ( 'true' === $fav_button ) {

			$require_login                       = get_option( 'inspiry_login_on_fav', 'no' );
			$inspiry_add_to_fav_property_label   = get_option( 'inspiry_add_to_fav_property_label' );
			$inspiry_added_to_fav_property_label = get_option( 'inspiry_added_to_fav_property_label' );

			if ( ! empty( $ele_add_label ) ) {
				$add_label = $ele_add_label;
			} elseif ( $inspiry_add_to_fav_property_label ) {
				$add_label = $inspiry_add_to_fav_property_label;
			} else {
				$add_label = __( 'Add to favorites', 'framework' );
			}

			if ( ! empty( $ele_added_label ) ) {
				$added_label = $ele_added_label;
			} elseif ( $inspiry_added_to_fav_property_label ) {
				$added_label = $inspiry_added_to_fav_property_label;
			} else {
				$added_label = __( 'Added to favorites', 'framework' );
			}

			if ( ( is_user_logged_in() && 'yes' === $require_login ) || ( 'yes' !== $require_login ) ) {

				if ( null === $property_id ) {
					$property_id = get_the_ID();
				}

				$user_status = 'user_not_logged_in';
				if ( is_user_logged_in() ) {
					$user_status = 'user_logged_in';
				}

				if ( is_added_to_favorite( $property_id ) ) {

					if ( $single ) {
						?>
						<span class="favorite-btn-wrap favorite-btn-<?php echo esc_attr( $property_id ); ?>">
							<span class="favorite-placeholder highlight__red <?php echo esc_attr( $user_status ); ?>" data-propertyid="<?php echo esc_attr( $property_id ); ?>">
								<?php inspiry_include_favorite_svg_icon($icon_path); ?>
								<span class="rh_tooltip">
									<p class="label">
										<?php echo esc_html( $added_label ); ?>
									</p>
								</span>
							</span>
							<a href="#" class="favorite add-to-favorite hide <?php echo esc_attr( $user_status ); ?>" data-propertyid="<?php echo esc_attr( $property_id ); ?>">
								<?php inspiry_include_favorite_svg_icon($icon_path); ?>
								<span class="rh_tooltip">
									<p class="label">
										<?php echo esc_html( $add_label ); ?>
									</p>
								</span>
							</a>
						</span>
						<?php
					} else {
						?>
						<span class="favorite-btn-wrap favorite-btn-<?php echo esc_attr( $property_id ); ?>">
							<span class="favorite-placeholder highlight__red <?php echo esc_attr( $user_status ); ?>" data-propertyid="<?php echo esc_attr( $property_id ); ?>" data-tooltip="<?php echo esc_html( $added_label ); ?>">
								<?php inspiry_include_favorite_svg_icon($icon_path); ?>
							</span>
							<a href="#" class="favorite add-to-favorite hide <?php echo esc_attr( $user_status ); ?>" data-tooltip="<?php echo esc_html( $add_label ); ?>" data-propertyid="<?php echo esc_attr( $property_id ); ?>">
								<?php inspiry_include_favorite_svg_icon($icon_path); ?>
							</a>
						</span>
						<?php
					}
				} else {
					if ( $single ) {
						?>
						<span class="favorite-btn-wrap favorite-btn-<?php echo esc_attr( $property_id ); ?>">
							<span class="favorite-placeholder highlight__red hide <?php echo esc_attr( $user_status ); ?>" data-propertyid="<?php echo esc_attr( $property_id ); ?>">
								<?php inspiry_include_favorite_svg_icon($icon_path); ?>
								<span class="rh_tooltip">
									<p class="label">
										<?php echo esc_html( $added_label ); ?>
									</p>
								</span>
							</span>
							<a href="#" class="favorite add-to-favorite <?php echo esc_attr( $user_status ); ?>" data-propertyid="<?php echo esc_attr( $property_id ); ?>">
								<?php inspiry_include_favorite_svg_icon($icon_path); ?>
								<span class="rh_tooltip">
									<p class="label">
										<?php echo esc_html( $add_label ); ?>
									</p>
								</span>
							</a>
						</span>
						<?php
					} else {
						?>
						<span class="favorite-btn-wrap favorite-btn-<?php echo esc_attr( $property_id ); ?>">
							<span class="favorite-placeholder highlight__red hide <?php echo esc_attr( $user_status ); ?>" data-propertyid="<?php echo esc_attr( $property_id ); ?>" data-tooltip="<?php echo esc_html( $added_label ); ?>">
								<?php inspiry_include_favorite_svg_icon($icon_path); ?>
							</span>
							<a href="#" class="favorite add-to-favorite <?php echo esc_attr( $user_status ); ?>" data-tooltip="<?php echo esc_html( $add_label ); ?>" data-propertyid="<?php echo esc_attr( $property_id ); ?>">
								<?php inspiry_include_favorite_svg_icon($icon_path); ?>
							</a>
						</span>
						<?php
					}
				}
			} else {

				$theme_login_url = inspiry_get_login_register_url(); // login and register page URL.

				if ( $single ) {
					?>
					<a href="#" class="favorite add-to-favorite require-login" data-login="<?php echo esc_url( $theme_login_url ); ?>">
						<?php inspiry_include_favorite_svg_icon($icon_path); ?>
						<span class="rh_tooltip">
						<p class="label">
							<?php echo esc_html( $add_label ); ?>
						</p>
						</span>
					</a>
					<?php
				} else {
					?>
					<a href="#" class="favorite add-to-favorite require-login" data-tooltip="<?php echo esc_attr( $add_label ); ?>" data-login="<?php echo esc_url( $theme_login_url ); ?>">
						<?php inspiry_include_favorite_svg_icon($icon_path); ?>
					</a>
					<?php
				}
			}
		}
	}
}
