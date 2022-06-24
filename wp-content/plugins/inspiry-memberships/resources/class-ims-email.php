<?php
/**
 * Class IMS_Email to send different kind of emails to users and admins.
 *
 * @since 2.1.0
 */
class IMS_Email {

	/**
	 * Membership cancellation email.
	 *
	 * @param int $user_id       - Current user ID whose package is being cancelled.
	 * @param int $membership_id - Membership ID that is being cancelled.
	 * @since     2.1.0
	 */
	public static function membership_cancel_email( $user_id = 0, $membership_id = 0 ) {
		// Bail if parameters are empty.
		if ( empty( $user_id ) || empty( $membership_id ) ) {
			return false;
		}

		// Get user.
		$user = get_user_by( 'id', $user_id );
		if ( ! empty( $user ) ) {
			$user_email = $user->user_email;
		}

		$site_name    = esc_html( get_bloginfo( 'name' ) );
		$site_url     = esc_url( get_bloginfo( 'url' ) );
		$admin_email  = get_bloginfo( 'admin_email' ); // Get admin email.
		$header_phone = get_option( 'theme_header_phone' ); // Get header phone number.
		$membership   = esc_html( get_the_title( $membership_id ) );
		$subject      = esc_html__( 'Membership Package Subscription is Canceled', 'inspiry-memberships' ) . ' - ' . get_bloginfo( 'name' );

		// translators: name of the membership package.
		$message  = sprintf( esc_html__( 'Your %s membership package subscription has been cancelled.', 'inspiry-memberships' ), '<strong>' . $membership . '</strong>' ) . '<br/><br/>';

		if ( is_email( $admin_email ) ) {
			$message .= esc_html__( 'For any further assistance, email us at', 'inspiry-memberships' ) . ' ' . $admin_email;

			if ( ! empty( $header_phone ) ) {
				$message .= esc_html__( ' OR call us at ', 'inspiry-memberships' ) . ' ' . $header_phone;
			}

			$message .= '<br/><br/>';
		}

		$message .= esc_html__( 'Regards', 'inspiry-memberships' );

		$message = apply_filters( 'ims_membership_cancelled_mail', $message, $user_id, $membership_id );

		if ( is_email( $user_email ) ) {
			self::send_email( $user_email, $subject, $message );
		}
	}

	/**
	 * Method: Mail User to notify about membership purchase.
	 *
	 * @param int     $user_id ID of the user purchasing membership.
	 * @param int     $membership_id - ID of the membership being purchased.
	 * @param string  $vendor - Vendor used by the user.
	 * @param boolean $recurring - True if recurring membership, false if not.
	 * @since         2.1.0
	 */
	public static function mail_user( $user_id = 0, $membership_id = 0, $vendor = null, $recurring = false ) {

		// Bail if user, membership or receipt id is empty.
		if ( empty( $user_id ) || empty( $membership_id ) ) {
			return;
		}

		// Set vendor.
		if ( ! empty( $vendor ) && 'paypal' === $vendor ) {
			$vendor = esc_html__( 'via PayPal', 'inspiry-memberships' );
		} elseif ( ! empty( $vendor ) && 'stripe' === $vendor ) {
			$vendor = esc_html__( 'via Stripe', 'inspiry-memberships' );
		} elseif ( ! empty( $vendor ) && 'wire' === $vendor ) {
			$vendor = esc_html__( 'via Wire Transfer', 'inspiry-memberships' );
		}

		// Get user.
		$user = get_user_by( 'id', $user_id );
		if ( ! empty( $user ) ) {
			$user_email = $user->user_email;
		}

		$membership_title = get_the_title( $membership_id );
		$admin_email      = get_bloginfo( 'admin_email' ); // Get admin email.
		$header_phone     = get_option( 'theme_header_phone' ); // Get header phone number.

		if ( empty( $recurring ) ) {
			$website_url = home_url( '/' );
			// Membership Activation Mail.
			$subject = esc_html__( 'Membership Package Subscription is Activated', 'inspiry-memberships' ) . ' - ' . get_bloginfo( 'name' );
			$message = sprintf( esc_html__( 'Your %1$s membership package subscription has been activated. For more details please visit %2$s page of your account on our %3$swebsite%4$s.', 'inspiry-memberships' ), '<strong>' . $membership_title . '</strong>', '<strong>' . esc_html__( 'My Membership', 'inspiry-membership' ) . '</strong>', '<a href="' . esc_url( $website_url ) . '" target="_blank">', '</a>' ) . '<br/><br/>';

			if ( is_email( $admin_email ) ) {
				$message .= esc_html__( 'For any further assistance, email us at', 'inspiry-memberships' ) . ' ' . $admin_email;

				if ( ! empty( $header_phone ) ) {
					$message .= esc_html__( ' OR call us at ', 'inspiry-memberships' ) . ' ' . $header_phone;
				}

				$message .= '<br/><br/>';
			}

			$message .= esc_html__( 'Regards', 'inspiry-memberships' );

			$message = apply_filters( 'ims_membership_user_mail', $message, $user_id, $membership_id, $vendor );
		} else {
			$website_url = home_url( '/' );

			// Update Membership Mail.
			$subject = esc_html__( 'Membership Package Subscription is Updated.', 'inspiry-memberships' ) . ' - ' . get_bloginfo( 'name' );
			$message = sprintf( esc_html__( 'Your %1$s membership package subscription has been updated. For more details please visit %2$s page of your account on our %3$swebsite%4$s.', 'inspiry-memberships' ), '<strong>' . $membership_title . '</strong>', '<strong>' . esc_html__( 'My Membership', 'inspiry-membership' ) . '</strong>', '<a href="' . esc_url( $website_url ) . '" target="_blank">', '</a>' ) . '<br/><br/>';

			if ( is_email( $admin_email ) ) {
				$message .= esc_html__( 'For any further assistance, email us at', 'inspiry-memberships' ) . ' ' . $admin_email;

				if ( ! empty( $header_phone ) ) {
					$message .= esc_html__( ' OR call us at ', 'inspiry-memberships' ) . ' ' . $header_phone;
				}

				$message .= '<br/><br/>';
			}

			$message .= esc_html__( 'Regards', 'inspiry-memberships' );
			$message  = apply_filters( 'ims_recurring_membership_user_mail', $message, $user_id, $membership_id, $vendor );
		}

		if ( is_email( $user_email ) ) {
			self::send_email( $user_email, $subject, $message );
		}
	}

	/**
	 * Method: Mail Admin to notify about membership purchase.
	 *
	 * @param int     $membership_id - ID of the membership user purchased to.
	 * @param int     $receipt_id - ID of the membership receipt being purchased.
	 * @param string  $vendor - Vendor used by the user.
	 * @param boolean $recurring - True if recurring membership, false if not.
	 * @since         2.1.0
	 */
	public static function mail_admin( $membership_id = 0, $receipt_id = 0, $vendor = null, $recurring = false ) {

		// Bail if membership or receipt id is empty.
		if ( empty( $membership_id ) || empty( $receipt_id ) ) {
			return;
		}

		// Set vendor.
		if ( ! empty( $vendor ) && 'paypal' === $vendor ) {
			$vendor = esc_html__( 'via PayPal', 'inspiry-memberships' );
		} elseif ( ! empty( $vendor ) && 'stripe' === $vendor ) {
			$vendor = esc_html__( 'via Stripe', 'inspiry-memberships' );
		} elseif ( ! empty( $vendor ) && 'wire' === $vendor ) {
			$vendor = esc_html__( 'via Wire Transfer', 'inspiry-memberships' );
		}

		$admin_email      = get_bloginfo( 'admin_email' ); // Get admin email.
		$receipt_title    = get_the_title( $receipt_id ); // Get receipt edit link.
		$membership_title = get_the_title( $membership_id );

		if ( empty( $recurring ) ) {

			$subject  = esc_html__( 'Membership Package Subscription is Activated', 'inspiry-memberships' ) . ' - ' . get_bloginfo( 'name' );
			$message  = sprintf( esc_html__( 'A %s membership package subscription is activated on your site.', 'inspiry-memberships' ), '<strong>' . $membership_title . '</strong>' ) . '<br/><br/>';
			$message .= sprintf( esc_html__( 'For more details please check %s', 'inspiry-memberships' ), '<strong>' . $receipt_title . '</strong>' );
			$message  = apply_filters( 'ims_membership_admin_mail', $message, $membership_id, $vendor );
		} elseif ( ! empty( $recurring ) ) {

			$subject  = esc_html__( 'Membership Package Subscription is Updated', 'inspiry-memberships' ) . ' - ' . get_bloginfo( 'name' );
			$message  = sprintf( esc_html__( 'A %s membership package subscription is updated on your site.', 'inspiry-memberships' ), '<strong>' . $membership_title . '</strong>' ) . '<br/><br/>';
			$message .= sprintf( esc_html__( 'For more details please check %s', 'inspiry-memberships' ), '<strong>' . $receipt_title . '</strong>' );
			$message  = apply_filters( 'ims_recurring_membership_admin_mail', $message, $membership_id, $vendor );
		}

		if ( is_email( $admin_email ) ) {
			self::send_email( $admin_email, $subject, $message );
		}
	}

	/**
	 * Method: Send email to user after selected period of time.
	 *
	 * @param int $user_id       - ID of the user to which reminder will be sent.
	 * @param int $membership_id - ID of the membership owned by the user.
	 * @since     2.1.0
	 */
	public static function membership_reminder_email( $user_id, $membership_id ) {

		// Bail if user, membership or receipt id is empty.
		if ( empty( $user_id ) || empty( $membership_id ) ) {
			return;
		}

		// Get user.
		$user = get_user_by( 'id', $user_id );
		if ( ! empty( $user ) ) {
			$user_email = $user->user_email;
		}

		$site_name    = esc_html( get_bloginfo( 'name' ) );
		$admin_email  = get_bloginfo( 'admin_email' ); // Get admin email.
		$header_phone = get_option( 'theme_header_phone' ); // Get header phone number.

		$subject  = esc_html__( 'Your membership package subscription is about to end', 'inspiry-memberships' ) . ' - ' . get_bloginfo( 'name' );
		$message  = sprintf( esc_html__( 'Your membership package subscription on %s is about to end.', 'inspiry-memberships' ), $site_name ) . "<br/><br/>";
		$message .= esc_html__( 'Please make sure that you renew your subscription within due date. Otherwise your subscription will be cancelled.', 'inspiry-memberships' ) . "<br/><br/>";

		if ( is_email( $admin_email ) ) {
			$message .= esc_html__( 'For any further assistance, email us at', 'inspiry-memberships' ) . ' ' . $admin_email;

			if ( ! empty( $header_phone ) ) {
				$message .= esc_html__( ' OR call us at ', 'inspiry-memberships' ) . ' ' . $header_phone;
			}

			$message .= '<br/><br/>';
		}

		$message .= esc_html__( 'Regards', 'inspiry-memberships' );
		$message  = apply_filters( 'ims_membership_reminder_mail', $message, $user_id, $membership_id );

		if ( is_email( $user_email ) ) {
			self::send_email( $user_email, $subject, $message );
		}

	}

	/**
	 * Method: Send Email.
	 *
	 * @param string $to_email Email receipiant.
	 * @param string $subject  Email subject.
	 * @param string $contents Email contents.
	 * @since        2.1.0
	 */
	public static function send_email( $to_email, $subject, $contents ) {

		// Email Headers ( Reply To and Content Type ).
		$headers = array();

		$headers[] = 'Content-Type: text/html; charset=UTF-8';
		$headers   = apply_filters( 'ims_email_header', $headers );

		// Apply HTML template to the email contents.
		$contents = IMS_EMail::apply_html_template( $contents );

		if ( wp_mail( $to_email, $subject, $contents, $headers ) ) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * This function applies HTML template to the given email contents.
	 *
	 * @since        2.1.0
	 * @param  string $contents - Email contents.
	 * @return string $contents - Email contents after applying the HTML template.
	 */
	public static function apply_html_template( $contents ) {

		// Prepare HTML template with contents if required function is available.
		if ( function_exists( 'ere_email_template' ) ) {
			$email_content[] = array(
				'name'  => '',
				'value' => $contents,
			);

			$contents = ere_email_template( $email_content ); // Generate HTML template with given email contents.
		}

		return $contents;
	}
}
