<?php
/**
 * View: My Property Card
 *
 * Property card for my properties page.
 *
 * @package    realhomes
 * @subpackage modern
 */

global $post;
?>

<div class="rh_my-property clearfix">

	<div class="rh_my-property__thumb">
		<?php
		if ( has_post_thumbnail( get_the_ID() ) ) {
			the_post_thumbnail( 'property-thumb-image' );
		} else {
			inspiry_image_placeholder( 'property-thumb-image' );
		}
		?>
	</div>
	<!-- /.rh_my-property__thumb -->

	<div class="rh_my-property__title">
		<h5><?php echo wp_trim_words( get_the_title(), 12 ); ?></h5>
		<div class="rh_my-property__btns">
			<?php
			// Payment Status.
			$payment_status = get_post_meta( get_the_ID(), 'payment_status', true );

			// Memberships enabled?
			if ( function_exists( 'IMS_Helper_Functions' ) ) {
				$ims_helper_functions  = IMS_Helper_Functions();
				$is_memberships_enable = $ims_helper_functions::is_memberships();
			}

			if ( 'Completed' === $payment_status ) {
				echo '<h5>';
				esc_html_e( 'Payment Completed', 'framework' );
				echo '</h5>';
			} elseif ( ! class_exists( 'IMS_Helper_Functions' ) ) {

				// PayPal Payment Button.
				if ( function_exists( 'rpp_paypal_button' ) ) {
					rpp_paypal_button( get_the_ID() );
				}

				// Stripe Payment Button.
				if ( function_exists( 'isp_stripe_button' ) ) {
					isp_stripe_button( get_the_ID() );
				}

				/**
				 * This action hook is used to add more payment options
				 * for property submission.
				 *
				 * @since 2.6.4
				 */
				do_action( 'inspiry_property_payments', get_the_ID() );
			}
			?>
		</div>
		<!-- /.rh_my-property__btns -->
	</div>
	<!-- /.rh_my-property__title -->

	<div class="rh_my-property__publish">
		<div class="property-date">
			<h5><i class="far fa-calendar-alt"></i><?php the_time( get_option( 'date_format' ) ); ?></h5>
		</div>
		<?php $property_status = get_post_status(); ?>
		<span class="property-status <?php echo ( 'publish' === $property_status ) ? 'publish' : 'other'; ?>">
		    <h5>
		    <?php
			    $property_statuses = get_post_statuses();
			    echo esc_html( $property_statuses[ $property_status ] );
		    ?>
		    </h5>
		</span>
	</div>
	<!-- /.rh_my-property__publish -->

	<div class="rh_my-property__controls">
		<?php
		/* Preview Post Link */
		if ( current_user_can( 'edit_posts' ) ) {
			$preview_link = set_url_scheme( get_permalink( get_the_ID() ) );
			$preview_link = esc_url( apply_filters( 'preview_post_link', add_query_arg( 'preview', 'true', $preview_link ) ) );
			if ( ! empty( $preview_link ) ) {
				?><a class="preview" target="_blank" href="<?php echo esc_url( $preview_link ); ?>">
				<i class="fas fa-eye"></i> <?php esc_html_e( 'Preview', 'framework' ); ?></a><?php
			}
		}

		/* Edit Post Link */
		$submit_url = inspiry_get_submit_property_url();
		if ( ! empty( $submit_url ) ) {
			$edit_link = esc_url( add_query_arg( 'edit_property', get_the_ID(), $submit_url ) );
			?><a class="edit" href="<?php echo esc_url( $edit_link ); ?>">
            <i class="fas fa-pencil-alt"></i> <?php esc_html_e( 'Edit', 'framework' ); ?></a><?php
		}

		/* Delete Post Link */
		if ( current_user_can( 'delete_posts' ) ) {
			?>
			<a class="delete" href="#">
                <i class="fas fa-trash-alt"></i> <?php esc_html_e( 'Delete', 'framework' ); ?>
			</a>
			<span class="confirmation hide">
				<a class="confirm remove-my-property"
				   data-property-id="<?php the_ID(); ?>"
				   href="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>"
				   title="<?php esc_attr_e( 'Remove This Property', 'framework' ); ?>">
					<i class="fas fa-check remove"></i>
					<i class="fas fa-spinner fa-spin loader"></i> <?php esc_html_e( 'Confirm', 'framework' ); ?>
				</a>
				<a href="#" class="cancel">
					<i class="fas fa-times"></i> <?php esc_html_e( 'Cancel', 'framework' ); ?>
				</a>
			</span>
			<?php
		}
		?>
		<div class="ajax-response"></div>
	</div>
	<!-- /.rh_my-property__controls -->

</div>
