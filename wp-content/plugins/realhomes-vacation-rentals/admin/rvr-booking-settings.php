<?php
/**
 * This file add and manage realhomes vacation rentals settings.
 *
 * @package    realhomes_vacation_rentals
 * @subpackage realhomes_vacation_rentals/admin
 */

if ( ! class_exists( 'RVR_Settings_Page' ) ) {
	/**
	 * Class RVR_Settings_Page
	 */
	class RVR_Settings_Page {

		function __construct() {

			// update settings to default initially.
			$rvr_settings = get_option( 'rvr_settings' );

			$rvr_settings_default = array(
				'rvr_activation'                      => '0',
				'rvr_contact_phone'                   => '',
				'rvr_contact_page'                    => '',
				'rvr_notification_email'              => get_option( 'admin_email' ),
				'rvr_owner_notification'              => '0',
				'rvr_terms_info'                      => '0',
				'rvr_terms_anchor_text'               => '',
				'rvr_outdoor_features_label'          => esc_html__( 'Outdoor Features', 'realhomes-vacation-rentals' ),
				'rvr_optional_services_label'         => esc_html__( 'Services', 'realhomes-vacation-rentals' ),
				'rvr_optional_services_inc_label'     => esc_html__( 'What is included', 'realhomes-vacation-rentals' ),
				'rvr_optional_services_not_inc_label' => esc_html__( 'What is not included', 'realhomes-vacation-rentals' ),
				'rvr_property_policies_label'         => esc_html__( 'Property Rules', 'realhomes-vacation-rentals' ),
				'rvr_surroundings_label'              => esc_html__( 'Surroundings', 'realhomes-vacation-rentals' ),
				'rvr_wc_payments'                     => '0',
				'rvr_wc_payments_scope'               => 'property',
				'rvr_instant_booking_button_label'    => esc_html__( 'Instant Booking', 'realhomes-vacation-rentals' ),
			);

			if ( ! $rvr_settings ) {
				update_option( 'rvr_settings', $rvr_settings_default );
			} else {
				foreach ( $rvr_settings_default as $key => $value ) {
					if ( ! isset( $rvr_settings[ $key ] ) ) {
						$rvr_settings[ $key ] = $value;
					}
				}
				update_option( 'rvr_settings', $rvr_settings );
			}
		}

		public function rvr_add_admin_menu() {

			add_submenu_page(
				'edit.php?post_type=booking',
				esc_html__( 'Settings', 'realhomes-vacation-rentals' ),
				esc_html__( 'Settings', 'realhomes-vacation-rentals' ),
				'manage_options',
				'rvr-settings',
				array( __CLASS__, 'rvr_options_page' )
			);

		}

		/**
		 * Register Realhomes Vacation Rentals settings sub menu under Real Homes dashboard menu
		 *
		 * @param $sub_menus
		 *
		 * @return array
		 */
		public function rvr_sub_menus( $sub_menus ) {

			$new_menu_item = array(
				'rvr_settings' => array(
					'rvr',
					esc_html__( 'Settings', 'realhomes-vacation-rentals' ),
					esc_html__( 'Settings', 'realhomes-vacation-rentals' ),
					'edit_posts',
					'admin.php?page=rvr-settings',
				),
			);

			$key   = 'owner';
			$keys  = array_keys( $sub_menus );
			$index = array_search( $key, $keys );
			$pos   = false === $index ? count( $sub_menus ) : $index + 1;

			return array_merge( array_slice( $sub_menus, 0, $pos ), $new_menu_item, array_slice( $sub_menus, $pos ) );
		}


		/**
		 * Open Bookings menu when on a booking post edit page.
		 *
		 * @param $sub_menus
		 *
		 * @return array
		 */
		public function rvr_real_homes_open_menus_slugs( $sub_menus ) {

			$new_menu_item_slug = array(
				'admin_page_rvr-settings',
			);

			$key   = 'owner';
			$keys  = array_keys( $sub_menus );
			$index = array_search( $key, $keys );
			$pos   = false === $index ? count( $sub_menus ) : $index + 1;

			return array_merge( array_slice( $sub_menus, 0, $pos ), $new_menu_item_slug, array_slice( $sub_menus, $pos ) );
		}

		public static function rvr_options_page() {

			?>
            <form action='options.php' method='post'>

                <h1><?php esc_html_e( 'Realhomes Vacation Rentals Settings', 'realhomes-vacation-rentals' ); ?></h1>
				<?php
				settings_errors();
				settings_fields( 'rvr_settings_page' );
				do_settings_sections( 'rvr_settings_page' );
				submit_button();
				?>

            </form>
			<?php
		}

		public function rvr_settings_init() {

			register_setting( 'rvr_settings_page', 'rvr_settings' );

			add_settings_section(
				'rvr_settings_general_section',
				'', // no heading.
				'', // no callback function.
				'rvr_settings_page'
			);

			add_settings_section(
				'rvr_settings_contact_section',
				esc_html__( 'Contact Information', 'realhomes-vacation-rentals' ),
				'', // no callback function.
				'rvr_settings_page'
			);

			add_settings_section(
				'rvr_settings_terms_section',
				esc_html__( 'Terms and Conditions', 'realhomes-vacation-rentals' ),
				'', // no callback function.
				'rvr_settings_page'
			);

			add_settings_section(
				'rvr_settings_labels_section',
				esc_html__( 'Labels for Various Sections', 'realhomes-vacation-rentals' ),
				'', // no callback function.
				'rvr_settings_page'
			);
			if ( class_exists( 'WooCommerce' ) && class_exists( 'Realhomes_WC_Payments_Addon' ) ) {
				add_settings_section(
					'rvr_settings_payment_section',
					esc_html__( 'Booking Payments', 'realhomes-vacation-rentals' ),
					'', // no callback function.
					'rvr_settings_page'
				);
			}

			add_settings_field(
				'rvr_activation_button',
				esc_html__( 'Realhomes Vacation Rentals', 'realhomes-vacation-rentals' ),
				array( __CLASS__, 'rvr_activation_button_render' ),
				'rvr_settings_page',
				'rvr_settings_general_section'
			);

			add_settings_field(
				'rvr_contact_phone_field',
				esc_html__( 'Booking Phone Number *', 'realhomes-vacation-rentals' ),
				array( __CLASS__, 'rvr_contact_phone_render' ),
				'rvr_settings_page',
				'rvr_settings_contact_section'
			);

			add_settings_field(
				'rvr_contact_page_field',
				esc_html__( 'Contact Page', 'realhomes-vacation-rentals' ),
				array( __CLASS__, 'rvr_contact_page_render' ),
				'rvr_settings_page',
				'rvr_settings_contact_section'
			);

			add_settings_field(
				'rvr_notification_email_field',
				esc_html__( 'Booking Email *', 'realhomes-vacation-rentals' ),
				array( __CLASS__, 'rvr_notification_email_render' ),
				'rvr_settings_page',
				'rvr_settings_contact_section'
			);

			add_settings_field(
				'rvr_owner_notification_button',
				esc_html__( 'Booking Request Notification for Owner', 'realhomes-vacation-rentals' ),
				array( __CLASS__, 'rvr_owner_notification_render' ),
				'rvr_settings_page',
				'rvr_settings_contact_section'
			);

			add_settings_field(
				'rvr_terms_button',
				esc_html__( 'Terms & Conditions Info', 'realhomes-vacation-rentals' ),
				array( __CLASS__, 'rvr_terms_button_render' ),
				'rvr_settings_page',
				'rvr_settings_terms_section'
			);

			add_settings_field(
				'rvr_terms_anchor_text_field',
				esc_html__( 'Terms & Conditions Text', 'realhomes-vacation-rentals' ),
				array( __CLASS__, 'rvr_terms_anchor_text_render' ),
				'rvr_settings_page',
				'rvr_settings_terms_section'
			);

			add_settings_field(
				'rvr_outdoor_features_label',
				esc_html__( 'Label for Outdoor Features', 'realhomes-vacation-rentals' ),
				array( __CLASS__, 'rvr_outdoor_features_label_render' ),
				'rvr_settings_page',
				'rvr_settings_labels_section'
			);

			add_settings_field(
				'rvr_optional_services_label',
				esc_html__( 'Labels for Optional Services', 'realhomes-vacation-rentals' ),
				array( __CLASS__, 'rvr_optional_services_label_render' ),
				'rvr_settings_page',
				'rvr_settings_labels_section'
			);

			add_settings_field(
				'rvr_property_policies_label',
				esc_html__( 'Label for Property Policies', 'realhomes-vacation-rentals' ),
				array( __CLASS__, 'rvr_property_policies_label_render' ),
				'rvr_settings_page',
				'rvr_settings_labels_section'
			);

			add_settings_field(
				'rvr_surroundings_label',
				esc_html__( 'Label for Surroundings', 'realhomes-vacation-rentals' ),
				array( __CLASS__, 'rvr_surroundings_label_render' ),
				'rvr_settings_page',
				'rvr_settings_labels_section'
			);

			// Add payment and instant booking options if "WooCommerce" and "RealHomes WooCommerce Payments Addon" plugins are active.
			if ( class_exists( 'WooCommerce' ) && class_exists( 'Realhomes_WC_Payments_Addon' ) ) {
				add_settings_field(
					'rvr_booking_payment_button',
					esc_html__( 'Enable WooCommerce Payments for Bookings', 'realhomes-vacation-rentals' ),
					array( __CLASS__, 'rvr_payment_button_render' ),
					'rvr_settings_page',
					'rvr_settings_payment_section'
				);

				add_settings_field(
					'rvr_instant_booking_scope',
					esc_html__( 'Instant Booking Scope', 'realhomes-vacation-rentals' ),
					array( __CLASS__, 'rvr_payment_scope_render' ),
					'rvr_settings_page',
					'rvr_settings_payment_section'
				);

				add_settings_field(
					'rvr_instant_booking_button_label',
					esc_html__( 'Instant Booking Button Label', 'realhomes-vacation-rentals' ),
					array( __CLASS__, 'rvr_instant_booking_button_label' ),
					'rvr_settings_page',
					'rvr_settings_payment_section'
				);
			}
		}

		public static function rvr_activation_button_render() {

			$options = get_option( 'rvr_settings' );
			?>
            <label for="rvr_activation_enable">
                <input type='radio' id="rvr_activation_enable"
                       name='rvr_settings[rvr_activation]' <?php checked( $options['rvr_activation'], 1 ); ?> value='1'>
				<?php esc_html_e( 'Enable', 'realhomes-vacation-rentals' ); ?>
            </label>
            <label for="rvr_activation_disable">
                <input type='radio' id="rvr_activation_disable"
                       name='rvr_settings[rvr_activation]' <?php checked( $options['rvr_activation'], 0 ); ?> value='0'>
				<?php esc_html_e( 'Disable', 'realhomes-vacation-rentals' ); ?>
            </label>
            <p class="description"><?php esc_html_e( 'Enabling this will replace real estate functionality with vacation rentals functionality.', 'realhomes-vacation-rentals' ); ?></p>
			<?php
		}

		public static function rvr_contact_phone_render() {

			$options = get_option( 'rvr_settings' );
			?>
            <input type='text' name='rvr_settings[rvr_contact_phone]'
                   value='<?php echo esc_attr( $options['rvr_contact_phone'] ); ?>' required>
            <p class="description"><?php esc_html_e( 'To receive booking calls as it will be displayed on front-end booking widget.', 'realhomes-vacation-rentals' ); ?></p>
			<?php

		}

		public static function rvr_contact_page_render() {

			$options = get_option( 'rvr_settings' );
			wp_dropdown_pages(
				array(
					'name'             => 'rvr_settings[rvr_contact_page]',
					'selected'         => $options['rvr_contact_page'],
					'show_option_none' => esc_html__( 'None', 'realhomes-vacation-rentals' ),
				)
			);
			?>
            <p class="description"><?php esc_html_e( 'Select a page where users can ask Pre-Booking questions (e.g: contact page).', 'realhomes-vacation-rentals' ); ?></p>
			<?php

		}

		public static function rvr_notification_email_render() {

			$options = get_option( 'rvr_settings' );
			?>
            <input type='email' name='rvr_settings[rvr_notification_email]'
                   value='<?php echo sanitize_email( $options['rvr_notification_email'] ); ?>' required>
            <p class="description"><?php esc_html_e( 'Provide an email address to receive new booking request notification.', 'realhomes-vacation-rentals' ); ?></p>
			<?php

		}

		public static function rvr_owner_notification_render() {

			$options = get_option( 'rvr_settings' );
			?>
            <label for="rvr_owner_notification_enable">
                <input type='radio' id="rvr_owner_notification_enable"
                       name='rvr_settings[rvr_owner_notification]' <?php checked( $options['rvr_owner_notification'], 1 ); ?>
                       value='1'>
				<?php esc_html_e( 'Enable', 'realhomes-vacation-rentals' ); ?>
            </label>
            <label for="rvr_owner_notification_disable">
                <input type='radio' id="rvr_owner_notification_disable"
                       name='rvr_settings[rvr_owner_notification]' <?php checked( $options['rvr_owner_notification'], 0 ); ?>
                       value='0'>
				<?php esc_html_e( 'Disable', 'realhomes-vacation-rentals' ); ?>
            </label>
			<?php

		}

		public static function rvr_terms_button_render() {

			$options = get_option( 'rvr_settings' );
			?>
            <label for="rvr_terms_info_enable">
                <input type='radio' id="rvr_terms_info_enable"
                       name='rvr_settings[rvr_terms_info]' <?php checked( $options['rvr_terms_info'], 1 ); ?> value='1'>
				<?php esc_html_e( 'Show', 'realhomes-vacation-rentals' ); ?>
            </label>
            <label for="rvr_terms_info_disable">
                <input type='radio' id="rvr_terms_info_disable"
                       name='rvr_settings[rvr_terms_info]' <?php checked( $options['rvr_terms_info'], 0 ); ?> value='0'>
				<?php esc_html_e( 'Hide', 'realhomes-vacation-rentals' ); ?>
            </label>
            <p class="description"><?php esc_html_e( 'If shown, user must accept it for booking form submission.', 'realhomes-vacation-rentals' ); ?></p>
			<?php
		}

		public static function rvr_terms_anchor_text_render() {

			$options = get_option( 'rvr_settings' );
			?>
            <textarea name='rvr_settings[rvr_terms_anchor_text]' cols="50"
                      rows="5"><?php echo esc_html( $options['rvr_terms_anchor_text'] ); ?></textarea>
            <p class="description"><?php echo sprintf( esc_html__( 'Provide Terms and Conditions option label text that will be displayed on booking form. You may use %s tag in your text to link separate Terms and Conditions page.', 'realhomes-vacation-rentals' ), '<a href="https://www.w3schools.com/tags/tag_a.asp" target="_blank">' . htmlspecialchars( '<a>' ) . '</a>' ); ?></p>
			<?php
		}

		public static function rvr_outdoor_features_label_render() {

			$options = get_option( 'rvr_settings' );
			?>
            <input type='text' name='rvr_settings[rvr_outdoor_features_label]'
                   value='<?php echo esc_attr( $options['rvr_outdoor_features_label'] ); ?>'>
			<?php
		}

		public static function rvr_optional_services_label_render() {

			$options = get_option( 'rvr_settings' );
			?>
            <input type='text' name='rvr_settings[rvr_optional_services_label]'
                   value='<?php echo esc_attr( $options['rvr_optional_services_label'] ); ?>'>
            <p class="description"><?php esc_html_e( 'Provide "Optional Services" section label.', 'realhomes-vacation-rentals' ); ?></p>
            <input type='text' name='rvr_settings[rvr_optional_services_inc_label]'
                   value='<?php echo esc_attr( $options['rvr_optional_services_inc_label'] ); ?>'>
            <p class="description"><?php esc_html_e( 'Provide "Included" sub-section label.', 'realhomes-vacation-rentals' ); ?></p>
            <input type='text' name='rvr_settings[rvr_optional_services_not_inc_label]'
                   value='<?php echo esc_attr( $options['rvr_optional_services_not_inc_label'] ); ?>'>
            <p class="description"><?php esc_html_e( 'Provide "Not Included" sub-section label.', 'realhomes-vacation-rentals' ); ?></p>
			<?php
		}

		public static function rvr_property_policies_label_render() {

			$options = get_option( 'rvr_settings' );
			?>
            <input type='text' name='rvr_settings[rvr_property_policies_label]'
                   value='<?php echo esc_attr( $options['rvr_property_policies_label'] ); ?>'>
			<?php
		}

		public static function rvr_surroundings_label_render() {
			$options = get_option( 'rvr_settings' );
			?>
            <input type="text" name="rvr_settings[rvr_surroundings_label]"
                   value="<?php echo esc_attr( $options['rvr_surroundings_label'] ); ?>">
			<?php
		}

		public static function rvr_payment_button_render() {

			$options = get_option( 'rvr_settings' );
			?>
            <label for="rvr_wc_payments_enable">
                <input type='radio' id="rvr_wc_payments_enable"
                       name='rvr_settings[rvr_wc_payments]' <?php checked( $options['rvr_wc_payments'], 1 ); ?>
                       value='1'>
				<?php esc_html_e( 'Enable', 'realhomes-vacation-rentals' ); ?>
            </label>
            <label for="rvr_wc_payments_disable">
                <input type='radio' id="rvr_wc_payments_disable"
                       name='rvr_settings[rvr_wc_payments]' <?php checked( $options['rvr_wc_payments'], 0 ); ?>
                       value='0'>
				<?php esc_html_e( 'Disable', 'realhomes-vacation-rentals' ); ?>
            </label>
            <p class="description"><?php esc_html_e( 'Enable WooCommerce payments for the bookings on your website.', 'realhomes-vacation-rentals' ); ?></p>
			<?php
		}

		public static function rvr_payment_scope_render() {

			$options = get_option( 'rvr_settings' );
			?>
            <label for="rvr_wc_payments_scope_global">
                <input type='radio' id="rvr_wc_payments_scope_global"
                       name='rvr_settings[rvr_wc_payments_scope]' <?php checked( $options['rvr_wc_payments_scope'], 'global' ); ?>
                       value='global'>
				<?php esc_html_e( 'For All Properties', 'realhomes-vacation-rentals' ); ?>
            </label>
            <label for="rvr_wc_payments_scope_individual">
                <input type='radio' id="rvr_wc_payments_scope_individual"
                       name='rvr_settings[rvr_wc_payments_scope]' <?php checked( $options['rvr_wc_payments_scope'], 'property' ); ?>
                       value='property'>
				<?php esc_html_e( 'For Individual Property', 'realhomes-vacation-rentals' ); ?>
            </label>
            <p class="description"><?php esc_html_e( 'If you choose "For Individual Property" option then you would need to enable the instant booking for properties individually from their add/edit page.', 'realhomes-vacation-rentals' ); ?></p>
			<?php
		}

		public static function rvr_instant_booking_button_label() {

			$options = get_option( 'rvr_settings' );
			?>
            <input type='text' name='rvr_settings[rvr_instant_booking_button_label]'
                   value='<?php echo esc_attr( $options['rvr_instant_booking_button_label'] ); ?>'>
            <p class="description"><?php esc_html_e( 'This booking button label will be display for only instant booking enabled properties.', 'realhomes-vacation-rentals' ); ?></p>
			<?php
		}
	}
}
