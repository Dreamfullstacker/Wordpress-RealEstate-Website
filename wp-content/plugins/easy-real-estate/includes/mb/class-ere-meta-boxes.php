<?php
/**
 * Class ERE_Meta_Boxes
 *
 * Class to handle stuff related to meta boxes.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class ERE_Meta_Boxes {

	/**
	 * Initialize meta boxes
	 *
	 */
	public static function init() {
		do_action( 'ere_before_meta_boxes_init' );

		// Deactivate meta box plugin if it is installed and active
		add_action( 'init', array( __CLASS__, 'deactivate_meta_box_plugin' ) );

		self::includes();

		// Meta boxes helper functions
		include_once( ERE_PLUGIN_DIR . '/includes/mb/meta-box-helper-functions.php' );

		// Property meta boxes declaration
		include_once( ERE_PLUGIN_DIR . '/includes/mb/property-meta-boxes-config.php' );

		// Agent & Agency meta boxes declaration
		include_once( ERE_PLUGIN_DIR . '/includes/mb/agent-agency-meta-boxes-config.php' );

		// Partner meta boxes declaration
		include_once( ERE_PLUGIN_DIR . '/includes/mb/partner-meta-boxes-config.php' );

		// Templates meta boxes declaration
		include_once( ERE_PLUGIN_DIR . '/includes/mb/templates-meta-boxes-config.php' );

		do_action( 'ere_meta_boxes_init' );
	}

	/**
	 * Include meta box plugin and required extensions
	 *
	 * @since 1.0.0
	 */
	protected static function includes() {

		// Include meta box
		if ( ! class_exists( 'RW_Meta_Box' ) ) {
			if ( file_exists( ERE_PLUGIN_DIR . '/includes/mb/main/meta-box.php' ) ) {
				include_once( ERE_PLUGIN_DIR . '/includes/mb/main/meta-box.php' );
			}
		}

		// Include meta box tabs
		if ( ! class_exists( 'MB_Tabs' ) ) {
			if ( file_exists( ERE_PLUGIN_DIR . '/includes/mb/exts/meta-box-tabs/meta-box-tabs.php' ) ) {
				include_once( ERE_PLUGIN_DIR . '/includes/mb/exts/meta-box-tabs/meta-box-tabs.php' );
			}
		}

		// Include meta box rest api
		if ( ! class_exists( 'MB_Rest_API' ) ) {
			if ( file_exists( ERE_PLUGIN_DIR . '/includes/mb/exts/mb-rest-api/mb-rest-api.php' ) ) {
				include_once( ERE_PLUGIN_DIR . '/includes/mb/exts/mb-rest-api/mb-rest-api.php' );
			}
		}

		// Include columns extension
		if ( ! class_exists( 'MB_Columns' ) ) {
			if ( file_exists( ERE_PLUGIN_DIR . '/includes/mb/exts/meta-box-columns/meta-box-columns.php' ) ) {
				include_once( ERE_PLUGIN_DIR . '/includes/mb/exts/meta-box-columns/meta-box-columns.php' );
			}
		}

		// Include 'Include Exclude' extension
		if ( ! class_exists( 'MB_Include_Exclude' ) ) {
			if ( file_exists( ERE_PLUGIN_DIR . '/includes/mb/exts/meta-box-include-exclude/meta-box-include-exclude.php' ) ) {
				include_once( ERE_PLUGIN_DIR . '/includes/mb/exts/meta-box-include-exclude/meta-box-include-exclude.php' );
			}
		}

		// Include show hide extension
		if ( ! class_exists( 'MB_Show_Hide' ) ) {
			if ( file_exists( ERE_PLUGIN_DIR . '/includes/mb/exts/meta-box-show-hide/meta-box-show-hide.php' ) ) {
				include_once( ERE_PLUGIN_DIR . '/includes/mb/exts/meta-box-show-hide/meta-box-show-hide.php' );
			}
		}

		// Include conditional logic extension
		if ( ! class_exists( 'MB_Conditional_Logic' ) ) {
			if ( file_exists( ERE_PLUGIN_DIR . '/includes/mb/exts/meta-box-conditional-logic/meta-box-conditional-logic.php' ) ) {
				include_once( ERE_PLUGIN_DIR . '/includes/mb/exts/meta-box-conditional-logic/meta-box-conditional-logic.php' );
			}
		}

		// Include group extension
		if ( ! class_exists( 'RWMB_Group' ) ) {
			if ( file_exists( ERE_PLUGIN_DIR . '/includes/mb/exts/meta-box-group/meta-box-group.php' ) ) {
				include_once( ERE_PLUGIN_DIR . '/includes/mb/exts/meta-box-group/meta-box-group.php' );
			}
		}

		// Include term meta extension
		if ( ! class_exists( 'MB_Term_Meta_Box' ) ) {
			if ( file_exists( ERE_PLUGIN_DIR . '/includes/mb/exts/mb-term-meta/mb-term-meta.php' ) ) {
				include_once( ERE_PLUGIN_DIR . '/includes/mb/exts/mb-term-meta/mb-term-meta.php' );
			}
		}

		// Include settings page extension
		if ( ! class_exists( 'SettingsPage' ) ) {
			if ( file_exists( ERE_PLUGIN_DIR . '/includes/mb/exts/mb-settings-page/mb-settings-page.php' ) ) {
				include_once( ERE_PLUGIN_DIR . '/includes/mb/exts/mb-settings-page/mb-settings-page.php' );
			}
		}

		// Include custom 'sorter' field type
		if ( ! class_exists( 'RWMB_Sorter_Field' ) ) {
			if ( file_exists( ERE_PLUGIN_DIR . '/includes/mb/custom/custom-field-type-sorter.php' ) ) {
				require( ERE_PLUGIN_DIR . '/includes/mb/custom/custom-field-type-sorter.php' );
			}
		}
	}

	/**
	 * Deactivate meta box plugin if it is active.
	 */
	public static function deactivate_meta_box_plugin() {

		// Meta Box Plugin
		if ( is_plugin_active( 'meta-box/meta-box.php' ) ) {
			deactivate_plugins( 'meta-box/meta-box.php' );
			add_action( 'admin_notices', function () {
				?>
                <div class="update-nag notice is-dismissible">
                    <p><strong><?php _e( 'Meta Box plugin has been deactivated!', 'easy-real-estate' ); ?></strong></p>
                    <p><?php _e( 'As similar functionality is already embedded with in Easy Real Estate plugin.', 'easy-real-estate' ); ?></p>
                    <p>
                        <em><?php _e( 'So, You should completely remove it from your plugins.', 'easy-real-estate' ); ?></em>
                    </p>
                </div>
				<?php
			} );
		}

	}

}

/*
 * Initialize meta boxes.
 */
ERE_Meta_Boxes::init();