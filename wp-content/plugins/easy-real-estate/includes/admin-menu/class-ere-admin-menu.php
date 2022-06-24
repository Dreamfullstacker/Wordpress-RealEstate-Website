<?php
/**
 * Admin Menu Class for ERE
 *
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ERE_Admin_Menu {

	public static $_instance;
	public $menu_capability = 'edit_posts';
	public $ere_menu_slug = 'easy-real-estate';

	public function __construct() {

		// initialize ERE admin menu
		add_action( 'admin_menu', array( $this, 'ere_menu' ) );

		// Expand ERE admin menu when a sub menu is visited
		add_action( 'admin_footer', array( $this, 'expand_menu' ) );

	}

	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function ere_menu() {

		add_menu_page(
			__( 'Easy Real Estate', 'easy-real-estate' ),
			__( 'Easy Real Estate', 'easy-real-estate' ),
			$this->menu_capability,
			$this->ere_menu_slug,
			'',
			ERE_PLUGIN_URL . '/includes/admin-menu/ere-menu-icon.svg',
			'5'
		);

		// Add sub menus
		$sub_menus = [];
		$sub_menus['addnew'] = array(
			$this->ere_menu_slug,
			__( 'Add New Property', 'easy-real-estate' ),
			__( 'New Property', 'easy-real-estate' ),
			$this->menu_capability,
			'post-new.php?post_type=property',
		);

		// Getting all taxonomies from property post type.
		$property_tax = get_object_taxonomies( 'property', 'objects' );

		// Looping through the taxonomy object and building array with required format.
		foreach ( $property_tax as $single_tax ) {
			$sub_menus[ $single_tax->name ] = array(
				$this->ere_menu_slug,
				$single_tax->labels->add_new_item,
				$single_tax->labels->name,
				$this->menu_capability,
				'edit-tags.php?taxonomy=' . $single_tax->name . '&post_type=property',
			);
		}

		/**
		 * Allows menu item(s) addition after taxonomies menu items.
		 *
		 * @param $sub_menus
		 */
		$sub_menus = apply_filters( 'ere_after_taxonomies_sub_menu', $sub_menus );

		$sub_menus['agencies'] = array(
			$this->ere_menu_slug,
			esc_html__( 'Agencies', 'easy-real-estate' ),
			esc_html__( 'Agencies', 'easy-real-estate' ),
			$this->menu_capability,
			'edit.php?post_type=agency',
		);

		$sub_menus['agents'] = array(
			$this->ere_menu_slug,
			__( 'Agents', 'easy-real-estate' ),
			__( 'Agents', 'easy-real-estate' ),
			$this->menu_capability,
			'edit.php?post_type=agent',
		);

		$sub_menus['partners'] = array(
			$this->ere_menu_slug,
			__( 'Partners', 'easy-real-estate' ),
			__( 'Partners', 'easy-real-estate' ),
			$this->menu_capability,
			'edit.php?post_type=partners',
		);

		$sub_menus['slides'] = array(
			$this->ere_menu_slug,
			__( 'Slides', 'easy-real-estate' ),
			__( 'Slides', 'easy-real-estate' ),
			$this->menu_capability,
			'edit.php?post_type=slide',
		);

		$sub_menus['ere_settings'] = array(
			'easy-real-estate',
			__( 'Settings', 'easy-real-estate' ),
			__( 'Settings', 'easy-real-estate' ),
			'manage_options',
			'ere-settings',
			array( Easy_Real_Estate::instance(), 'settings_page' )
		);

		$sub_menus = apply_filters( 'inspiry_ere_admin_sub_menu', $sub_menus );

		if ( $sub_menus ) {
			foreach ( $sub_menus as $sub_menu ) {
				call_user_func_array( 'add_submenu_page', $sub_menu );
			}
		}
	}

	public function expand_menu() {

		// Get Current Screen.
		$screen    = get_current_screen();

		$menu_list = array(
			'agency',
			'agent',
			'partners',
			'slide'
		);

		$tax_names          = get_object_taxonomies( 'property', 'names' );
		$tax_names_prefixed = array_map( function ( $item ) {
			return 'edit-' . $item;
		}, $tax_names );

		$final_menu_list = array_merge( $menu_list, $tax_names_prefixed );
		$menu_arr        = apply_filters( 'ere_expand_menus_slugs', $final_menu_list );

		// Check if the current screen's ID has any of the above menu array items.
		if ( in_array( $screen->id, $menu_arr ) ) {

			// Filter $_GET array for security.
			$get_array = filter_input_array( INPUT_GET );
			$current_menu = '';

			foreach ( $tax_names as $tax_name ) {
				if ( isset( $get_array['taxonomy'] ) && ( $tax_name === $get_array['taxonomy'] ) ) {
					$current_menu = 'taxonomy=' . $tax_name;
					break;
				}
			}

			if ( empty( $current_menu ) && in_array( $screen->id, $menu_list ) ) {
				$current_menu = 'post_type=' . $screen->id;
			}

			if ( !empty( $current_menu ) ) {
			?>
			<script type="text/javascript">
				(function ($) {
					$("body").removeClass("sticky-menu");
					$("#toplevel_page_easy-real-estate").addClass('wp-has-current-submenu wp-menu-open').removeClass('wp-not-current-submenu');
					$("#toplevel_page_easy-real-estate > a").addClass('wp-has-current-submenu wp-menu-open').removeClass('wp-not-current-submenu');
                    $(document).ready(function () {
                        if ('<?php echo esc_html( $current_menu ); ?>') {
                            const anchors = $('#toplevel_page_easy-real-estate ul').find('li').children('a');
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
 * Initialize ERE admin menu class.
 */
function ere_admin_menu() {
	return ERE_Admin_Menu::instance();
}

ere_admin_menu();