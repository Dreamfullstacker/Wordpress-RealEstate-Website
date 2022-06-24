<?php
/**
 * `Membership` Metabox
 *
 * Class to create and manage `Membership` metaboxes.
 *
 * @since    1.0.0
 * @package IMS
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * IMS_Membership_Meta_Boxes.
 *
 * This class creates and manage `Membership` meta boxes.
 *
 * @since 1.0.0
 */

if ( ! class_exists( 'IMS_Membership_Meta_Boxes' ) ) :

	class IMS_Membership_Meta_Boxes {

		/**
		 * Add membership metaboxes.
		 *
		 * @since 1.0.0
		 */
		public function add_membership_meta_box() {

			add_meta_box(
				'membership-settings-metabox',
				esc_html__( 'Membership Detail', 'inspiry-membership' ),
				array( $this, 'meta_box_content' ),
				'ims_membership',
				'normal',
				'high',
			);

			// Hook after the membership metaboxes are added.
			do_action( 'ims_membership_meta_box_added' );

		}

		/**
		 * Membership metabox contents.
		 *
		 * @since 1.0.0
		 */
		public function meta_box_content( $membership, $box ) {

			wp_nonce_field( basename( __FILE__ ), 'membership_meta_box_nonce' );
			$prefix = apply_filters( 'ims_membership_meta_prefix', 'ims_membership_' ); ?>
			<style>
				.form-table th {
					width: 300px;
				}

			@media screen and (max-width: 782px) {
				.form-table th {
					width: auto;
				}
			}
			</style>
			<table class="form-table">
				<tr valign="top">
					<th scope="row" valign="top">
						<label for="allowed_properties">
							<?php esc_html_e( 'Total number of allowed properties', 'inspiry-membership' ); ?>
						</label>
					</th>
					<td>
					<input type="number" name="allowed_properties" id="allowed_properties" value="<?php echo esc_attr( get_post_meta( $membership->ID, "{$prefix}allowed_properties", true ) ); ?>" />
						<p class="description"><?php esc_html_e( 'Example: 20', 'inspiry-membership' ); ?></p>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row" valign="top">
						<label for="featured_properties">
							<?php esc_html_e( 'Max number of featured properties', 'inspiry-membership' ); ?>
						</label>
					</th>
					<td>
						<input type="number" name="featured_properties" id="featured_properties" value="<?php echo esc_attr( get_post_meta( $membership->ID, "{$prefix}featured_properties", true ) ); ?>" />
						<p class="description"><?php esc_html_e( 'Example: 4', 'inspiry-membership' ); ?></p>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row" valign="top">
						<label for="price">
							<?php esc_html_e( 'Membership price', 'inspiry-membership' ); ?>
						</label>
					</th>
					<td>
						<?php $price = floatval( get_post_meta( $membership->ID, "{$prefix}price", true ) ); ?>
						<?php if ( empty( $price ) ) : ?>
							<input type="number" name="price" id="price" step="any" value="<?php echo esc_attr( $price ); ?>" <?php echo ( ! empty( $price ) ) ? 'disabled' : ''; ?> />
						<?php else : ?>
							<input type="hidden" name="price" id="price" step="any" value="<?php echo esc_attr( $price ); ?>" />
							<input type="number" step="any" value="<?php echo esc_attr( $price ); ?>" <?php echo ( ! empty( $price ) ) ? 'disabled' : ''; ?> />
						<?php endif; ?>
						<p class="description"><?php esc_html_e( 'Example: 20', 'inspiry-membership' ); ?></p>
						<p class="description doc-note">
							<?php
							esc_html_e( 'Note: Please consult the ', 'inspiry-membership' );
							echo '<a href="' . esc_url( IMS_DOCS_URL ) . '" target="_blank">documentation</a>';
							esc_html_e( ' of the plugin for changing the price of the membership', 'inspiry-membership' );
							?>
						</p>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row" valign="top">
						<label for="duration">
							<?php esc_html_e( 'Membership billing period', 'inspiry-membership' ); ?>
					</label>
					</th>
					<td>
						<input type="number" name="duration" id="duration" value="<?php echo esc_attr( get_post_meta( $membership->ID, "{$prefix}duration", true ) ); ?>" />
						<?php $duration_unit = get_post_meta( $membership->ID, "{$prefix}duration_unit", true ); ?>
						<select name="duration_unit" id="duration_unit">
							<option value="" <?php echo ( '' == $duration_unit ) ? 'selected' : ''; ?> disabled>
								<?php esc_html_e( 'None', 'inspiry-memberships' ); ?>
							</option>
							<option value="days" <?php echo ( 'days' == $duration_unit ) ? 'selected' : ''; ?> >
								<?php esc_html_e( 'Days', 'inspiry-memberships' ); ?>
							</option>
							<option value="weeks" <?php echo ( 'weeks' == $duration_unit ) ? 'selected' : ''; ?> >
								<?php esc_html_e( 'Weeks', 'inspiry-memberships' ); ?>
							</option>
							<option value="months" <?php echo ( 'months' == $duration_unit ) ? 'selected' : ''; ?> >
								<?php esc_html_e( 'Months', 'inspiry-memberships' ); ?>
							</option>
							<option value="years" <?php echo ( 'years' == $duration_unit ) ? 'selected' : ''; ?> >
								<?php esc_html_e( 'Years', 'inspiry-memberships' ); ?>
							</option>
						</select>
						<p class="description"><?php esc_html_e( 'Provide a number and select related duration.', 'inspiry-membership' ); ?></p>
					</td>
				</tr>

				<tr valign="top">
					<th scope="row" valign="top"></th>
					<td>
						<?php $is_popular = ! empty( get_post_meta( $membership->ID, "{$prefix}is_popular", true ) ) ? '1' : '0'; ?>
						<input class="checkbox" type="checkbox"<?php checked( $is_popular ); ?> id="is_popular" name="is_popular"/>
						<label for="is_popular"><strong><?php esc_html_e( 'Mark this package as Popular?', 'inspiry-membership' ); ?></strong></label>
					</td>
				</tr>

				<tr>
					<td colspan="2"><hr></td>
				</tr>

				<tr valign="top">
					<th scope="row" valign="top">
						<label for="stripe_plan_id">
							<?php esc_html_e( 'Stripe Product Price ID', 'inspiry-membership' ); ?>
						</label>
					</th>
					<td>
						<input type="text" name="stripe_plan_id" id="stripe_plan_id" value="<?php echo esc_attr( get_post_meta( $membership->ID, "{$prefix}stripe_plan_id", true ) ); ?>" />
						<p class="description"><?php esc_html_e( 'Required, If you are using Stripe for recurring payments.', 'inspiry-membership' ); ?></p>
					</td>
				</tr>

				<?php do_action( 'ims_membership_add_meta_box', $membership->ID ); // Membership meta box action hook. ?>

			</table>

			<?php
		}

		/**
		 * Save metabox.
		 *
		 * @since 1.0.0
		 */
		public function save_meta_box( $membership_id, $membership ) {

			// Verify the nonce before proceeding.
			if ( ! isset( $_POST['membership_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['membership_meta_box_nonce'], basename( __FILE__ ) ) ) {
				return $membership_id;
			}

			// Get the post type object.
			$post_type = get_post_type_object( $membership->post_type );

			// Check if the post type is membership.
			if ( 'ims_membership' != $membership->post_type ) {
				return $membership_id;
			}

			// Check if the current user has permission to edit the post.
			if ( ! current_user_can( $post_type->cap->edit_post, $membership_id ) ) {
				return $membership_id;
			}

			// Get the posted data and sanitize it for use as an HTML class.
			$ims_meta_value                        = array();
			$ims_meta_value['allowed_properties']  = ( isset( $_POST['allowed_properties'] ) ) ? intval( $_POST['allowed_properties'] ) : '';
			$ims_meta_value['featured_properties'] = ( isset( $_POST['featured_properties'] ) ) ? intval( $_POST['featured_properties'] ) : '';
			$ims_meta_value['price']               = ( isset( $_POST['price'] ) ) ? floatval( $_POST['price'] ) : '';
			$ims_meta_value['duration']            = ( isset( $_POST['duration'] ) ) ? intval( $_POST['duration'] ) : '';
			$ims_meta_value['duration_unit']       = ( isset( $_POST['duration_unit'] ) ) ? sanitize_text_field( $_POST['duration_unit'] ) : '';
			$ims_meta_value['is_popular']          = ( isset( $_POST['is_popular'] ) ) ? sanitize_text_field( $_POST['is_popular'] ) : '';
			$ims_meta_value['stripe_plan_id']      = ( isset( $_POST['stripe_plan_id'] ) ) ? sanitize_text_field( $_POST['stripe_plan_id'] ) : '';

			// Filter the values of meta data being saved by membership post type.
			$ims_meta_value = apply_filters( 'ims_membership_before_save_meta_values', $ims_meta_value, $membership_id );

			// Meta data prefix.
			$prefix = apply_filters( 'ims_membership_meta_prefix', 'ims_membership_' );

			// Save the meta values.
			$this->save_meta_value( $membership_id, "{$prefix}allowed_properties", $ims_meta_value['allowed_properties'] );
			$this->save_meta_value( $membership_id, "{$prefix}featured_properties", $ims_meta_value['featured_properties'] );
			$this->save_meta_value( $membership_id, "{$prefix}price", $ims_meta_value['price'] );
			$this->save_meta_value( $membership_id, "{$prefix}duration", $ims_meta_value['duration'] );
			$this->save_meta_value( $membership_id, "{$prefix}duration_unit", $ims_meta_value['duration_unit'] );
			$this->save_meta_value( $membership_id, "{$prefix}is_popular", $ims_meta_value['is_popular'] );
			$this->save_meta_value( $membership_id, "{$prefix}stripe_plan_id", $ims_meta_value['stripe_plan_id'] );

			// After save meta box values action hook.
			do_action( 'ims_membership_after_save_meta_values', $ims_meta_value, $membership_id );
		}

		/**
		 * Save Metabox Value.
		 *
		 * @since 1.0.0
		 */
		public function save_meta_value( $post_id, $meta_key, $new_meta_value ) {

			// Get the old meta value of the meta key.
			$old_meta_value = get_post_meta( $post_id, $meta_key, true );

			if ( $new_meta_value && '' == $old_meta_value ) {

				// If a new meta value was added and there was no previous value, add it.
				add_post_meta( $post_id, $meta_key, $new_meta_value, true );

			} elseif ( $new_meta_value && $old_meta_value != $new_meta_value ) {

				// If the new meta value does not match the old value, update it.
				update_post_meta( $post_id, $meta_key, $new_meta_value );

			} elseif ( '' == $new_meta_value && $old_meta_value ) {

				// If there is no new meta value but an old value exists, delete it.
				delete_post_meta( $post_id, $meta_key, $old_meta_value );

			}
		}

		/**
		 * Add styles file.
		 *
		 * @since 1.0.0
		 */
		public function add_styles() {

			global $post_type;
			if ( 'ims_membership' === $post_type ) {
				wp_enqueue_style( 'ims-admin-styles', IMS_BASE_URL . 'resources/css/membership.css', array(), IMS_VERSION );
			}
		}
	}

endif;
