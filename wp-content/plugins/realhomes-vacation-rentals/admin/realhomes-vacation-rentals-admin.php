<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @since      1.0.0
 *
 * @package    realhomes_vacation_rentals
 * @subpackage realhomes_vacation_rentals/admin
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    realhomes_vacation_rentals
 * @subpackage realhomes_vacation_rentals/admin
 */
class Realhomes_Vacation_Rentals_Admin {

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->load_dependencies();

		$this->define_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Realhomes_Vacation_Realhomes_Loader. Orchestrates the hooks of the plugin.
	 * - Realhomes_Vacation_Realhomes_i18n. Defines internationalization functionality.
	 * - Realhomes_Vacation_Realhomes_Admin. Defines all hooks for the admin area.
	 * - Realhomes_Vacation_Realhomes_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * Realhomes Vacation Rentals admin menus
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/rvr-admin-menu.php';

		/**
		 * This file is responsible for the request booking handling
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/rvr-booking-request-handler.php';

		/**
		 * The class responsible for orchestrating the admin booking settings page
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/rvr-booking-settings.php';


		/**
		 * The class responsible for orchestrating the booking post type and related stuff
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/rvr-booking-post-type.php';

		/**
		 * The class responsible for orchestrating owner post type and related stuff
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/rvr-owner-post-type.php';

		/**
		 * The class responsible for orchestrating invoice post type and related stuff
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/rvr-invoice-post-type.php';

		/**
		 * RVR Property related meta boxes
		 */
		require_once RVR_PLUGIN_DIR . 'admin/rvr-property-metaboxes-config.php';

		/**
		 * PHP-Class to read a iCal-File (*.ics), parse it and give an array with its content.
		 */
		require_once RVR_PLUGIN_DIR . 'admin/class.iCalReader.php';

		/**
		 * Booking availability iCalendar synchronization functions.
		 */
		require_once RVR_PLUGIN_DIR . 'admin/rvr-icalendar.php';

		/**
		 * RVR customizer settings.
		 */
		require_once RVR_PLUGIN_DIR . 'admin/customizer/price-details.php';
		require_once RVR_PLUGIN_DIR . 'admin/customizer/seasonal-prices.php';
		require_once RVR_PLUGIN_DIR . 'admin/customizer/guests-accommodation.php';
		require_once RVR_PLUGIN_DIR . 'admin/customizer/availability-calendar.php';

	}

	/**
	 * Register all of the hooks related to the admin functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_hooks() {

		if ( class_exists( 'RVR_Booking' ) ) {
			$rvr_booking = new RVR_Booking();
			add_action( 'init', array( $rvr_booking, 'rvr_booking_post_type' ), 0 );
			add_action( 'rwmb_meta_boxes', array( $rvr_booking, 'rvr_booking_meta_boxes' ) );
			add_action( 'manage_edit-booking_columns', array( $rvr_booking, 'booking_edit_columns' ) );
			add_action( 'manage_posts_custom_column', array( $rvr_booking, 'booking_columns_values' ) );
			add_filter( 'manage_edit-booking_sortable_columns', array( $rvr_booking, 'booking_sortable_columns' ) );
			add_action( 'pre_get_posts', array( $rvr_booking, 'booking_status_orderby' ) );
			add_action( 'enter_title_here', array( $rvr_booking, 'booking_title_text' ) );
		}

		if ( class_exists( 'RVR_Owner' ) ) {
			$rvr_owner = new RVR_Owner();

			add_filter( 'rvr_sub_menus', array( $rvr_owner, 'rvr_sub_menus' ), 10 );
			add_action( 'init', array( $rvr_owner, 'rvr_owner_post_type' ), 0 );
			add_action( 'rwmb_meta_boxes', array( $rvr_owner, 'rvr_owner_meta_boxes' ) );
			add_action( 'manage_edit-owner_columns', array( $rvr_owner, 'owner_edit_columns' ) );
			add_action( 'manage_posts_custom_column', array( $rvr_owner, 'owner_columns_values' ) );
			add_action( 'enter_title_here', array( $rvr_owner, 'rvr_change_title_text' ) );
		}

		if ( class_exists( 'RVR_Invoice' ) ) {
			$rvr_invoice = new RVR_Invoice();

			add_action( 'init', array( $rvr_invoice, 'rvr_invoice_post_type' ), 0 );
			add_action( 'add_meta_boxes', array( $rvr_invoice, 'add_invoice_payment_metabox' ) );
			add_action( 'manage_edit-invoice_columns', array( $rvr_invoice, 'invoice_edit_columns' ) );
			add_action( 'manage_posts_custom_column', array( $rvr_invoice, 'invoice_columns_values' ) );
			add_action( 'enter_title_here', array( $rvr_invoice, 'invoice_title_text' ) );
		}

		if ( class_exists( 'RVR_Settings_Page' ) ) {
			$RVR_Settings_Page = new RVR_Settings_Page();
			add_action( 'admin_init', array( $RVR_Settings_Page, 'rvr_settings_init' ) );
			add_action( 'admin_menu', array( $RVR_Settings_Page, 'rvr_add_admin_menu' ), 10 );
			add_filter( 'rvr_sub_menus', array( $RVR_Settings_Page, 'rvr_sub_menus' ), 10 );
			add_filter( 'rvr_open_menus_slugs', array( $RVR_Settings_Page, 'rvr_real_homes_open_menus_slugs' ), 10 );
		}

		if ( class_exists( 'RVR_Owner_Widget' ) && ! function_exists( 'rvr_register_widgets' ) ) {
			/**
			 * Register custom widgets
			 */
			function rvr_register_widgets() {
				register_widget( 'RVR_Owner_Widget' );
				register_widget( 'RVR_Booking_Widget' );
			}

			add_action( 'widgets_init', 'rvr_register_widgets' );
		}
	}

}