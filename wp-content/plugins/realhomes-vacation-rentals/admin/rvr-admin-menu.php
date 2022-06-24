<?php
/**
 * Register a custom RVR menu page.
 *
 * @package    realhomes_vacation_rentals
 * @subpackage realhomes_vacation_rentals/admin
 */
if ( ! class_exists( 'RVR_Admin_Menu' ) ) {
	/**
	 * RVR_Admin_Menu
	 *
	 * Class for creating admin menu of Realhomes Vacation Rentals.
	 */
	class RVR_Admin_Menu {

		/**
		 * Class instance.
		 *
		 * @var object
		 */
		public static $_instance;

		/**
		 * RVR_Admin_Menu constructor.
		 */
		public function __construct() {

			// Admin menu
			add_action( 'admin_menu', array( $this, 'rvr_menu_page' ), 10 );

			// Current menu when clicked on a tab
			add_action( 'admin_footer', array( $this, 'open_menu' ) );

		}

		/**
		 * Return instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		public function rvr_menu_page() {
			add_menu_page(
				esc_html__( 'Vacation Rentals', 'realhomes-vacation-rentals' ),
				esc_html__( 'Vacation Rentals', 'realhomes-vacation-rentals' ),
				'edit_posts',
				'rvr',
				'',
				RVR_PLUGIN_URL . '/assets/images/rvr-menu-icon.svg',
				'6'
			);

			// Add all sub menus.
			// $sub_menus = array(
			// 	'add_new_booking' => array(
			// 		'rvr',
			// 		esc_html__( 'Add New Booking', 'realhomes-vacation-rentals' ),
			// 		esc_html__( 'New Booking', 'realhomes-vacation-rentals' ),
			// 		'edit_posts',
			// 		'post-new.php?post_type=booking',
			// 	)
			// );

			$sub_menus = array();

			// Third-party can add more sub_menus.
			$sub_menus = apply_filters( 'rvr_sub_menus', $sub_menus, 20 );

			// add sub-menus
			if ( $sub_menus ) {
				foreach ( $sub_menus as $sub_menu ) {
					call_user_func_array( 'add_submenu_page', $sub_menu );
				}
			}
		}

		/**
		 * WP menu open.
		 *
		 * Open Vacation Rentals menu when clicked on a tab.
		 */
		public function open_menu() {
			// Get Current Screen.
			$screen   = get_current_screen();
			$menu_arr = apply_filters( 'rvr_open_menus_slugs', array( 'owner' ) );

			// Check if the current screen's ID has any of the above menu array items.
			if ( in_array( $screen->id, $menu_arr ) ) { ?>
                <script type="text/javascript">
                    jQuery("body").removeClass("sticky-menu");
                    jQuery("#toplevel_page_rvr").addClass('wp-has-current-submenu wp-menu-open').removeClass('wp-not-current-submenu');
                    jQuery("#toplevel_page_rvr > a").addClass('wp-has-current-submenu wp-menu-open').removeClass('wp-not-current-submenu');
					<?php
					// Filter $_GET array for security.
					$get_array = filter_input_array( INPUT_GET );
					$current_menu = '';

					if ( isset( $get_array['page'] ) && ( 'rvr-settings' === $get_array['page'] ) ) {
						$current_menu = 'page=rvr-settings';
					}
					?>
                    (function ($) {
                        $(document).ready(function () {
                            if ('<?php echo esc_html( $current_menu ); ?>') {
                                const anchors = $('#toplevel_page_rvr ul').find('li').children('a');
                                anchors.each(function () {
                                    if (this.href.indexOf('<?php echo esc_html( $current_menu ); ?>') >= 0) {
                                        $(this).parent('li').addClass("current");
                                    }
                                });
                            }
                        });
                    })(jQuery);
                </script>
				<?php
			}
		}
	}
}

/**
 * Initialize admin menu class.
 */
function rvr_admin_menu() {
	return RVR_Admin_Menu::instance();
}

rvr_admin_menu();