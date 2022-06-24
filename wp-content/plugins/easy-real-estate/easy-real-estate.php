<?php
/**
 * Plugin Name: Easy Real Estate
 * Plugin URI: http://themeforest.net/item/real-homes-wordpress-real-estate-theme/5373914
 * Description: Provides real estate functionality for RealHomes theme.
 * Version: 1.1.3
 * Author: Inspiry Themes
 * Author URI: https://themeforest.net/user/inspirythemes/portfolio?order_by=sales
 * Text Domain: easy-real-estate
 * Domain Path: /languages
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Easy_Real_Estate' ) ) :

	final class Easy_Real_Estate {

		/**
		 * Plugin's current version
		 *
		 * @var string
		 */
		public $version;

		/**
		 * Plugin Name
		 *
		 * @var string
		 */
		public $plugin_name;

		/**
		 * Plugin's singleton instance.
		 *
		 * @var Easy_Real_Estate
		 */
		protected static $_instance;

		/**
		 * Constructor function.
		 */
		public function __construct() {

			$this->plugin_name = 'easy-real-estate';
			$this->version     = '1.1.3';

			$this->define_constants();

			$this->includes();

			$this->initialize_custom_post_types();

			$this->initialize_meta_boxes();

			$this->initialize_admin_menu();

			$this->init_hooks();

			do_action( 'ere_loaded' );  // Easy Real Estate plugin loaded action hook.
		}

		/**
		 * Provides singleton instance.
		 */
		public static function instance() {
			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}

			return self::$_instance;
		}

		/**
		 * Defines constants.
		 */
		protected function define_constants() {

			if ( ! defined( 'ERE_VERSION' ) ) {
				define( 'ERE_VERSION', $this->version );
			}

			// Full path and filename.
			if ( ! defined( 'ERE_PLUGIN_FILE' ) ) {
				define( 'ERE_PLUGIN_FILE', __FILE__ );
			}

			// Plugin directory path.
			if ( ! defined( 'ERE_PLUGIN_DIR' ) ) {
				define( 'ERE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}
			//Hook to add RHPE directory path
			do_action('rhpe_dir_const');
			

			// Plugin directory URL.
			if ( ! defined( 'ERE_PLUGIN_URL' ) ) {
				define( 'ERE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}


			// Plugin file path relative to plugins directory.
			if ( ! defined( 'ERE_PLUGIN_BASENAME' ) ) {
				define( 'ERE_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
			}

			// RealHomes selected design variation.
			if ( ! defined( 'INSPIRY_DESIGN_VARIATION' ) ) {
				define( 'INSPIRY_DESIGN_VARIATION', get_option( 'inspiry_design_variation', 'modern' ) );
			}


		}

		/**
		 * Includes files required on admin and on frontend.
		 */
		public function includes() {
			$this->include_functions();
			$this->include_shortcodes();
			$this->include_widgets();
			$this->include_social_login();
		}

		/**
		 * Includes social login feature related files.
		 */
		public function include_social_login() {
			require_once ERE_PLUGIN_DIR . 'includes/social-login/autoload.php';  // Social login feature.
		}

		/**
		 * Functions
		 */
		public function include_functions() {
			require_once ERE_PLUGIN_DIR . 'includes/functions/purchase-api.php'; // Purchase.
			require_once ERE_PLUGIN_DIR . 'includes/functions/data.php';  // data functions.
			require_once ERE_PLUGIN_DIR . 'includes/functions/basic.php';  // basic functions.
			require_once ERE_PLUGIN_DIR . 'includes/functions/price.php';   // price functions.
			require_once ERE_PLUGIN_DIR . 'includes/functions/real-estate.php';   // real estate functions.
			require_once ERE_PLUGIN_DIR . 'includes/functions/agents.php';   // agents functions.
			require_once ERE_PLUGIN_DIR . 'includes/functions/agencies.php';   // agencies functions.
			require_once ERE_PLUGIN_DIR . 'includes/functions/gdpr.php';   // gdpr functions.
			require_once ERE_PLUGIN_DIR . 'includes/functions/google-recaptcha.php';   // google recaptcha functions.
			require_once ERE_PLUGIN_DIR . 'includes/functions/form-handlers.php';   // form handlers.
			require_once ERE_PLUGIN_DIR . 'includes/functions/members.php';   // members functions.
			require_once ERE_PLUGIN_DIR . 'includes/functions/property-submit.php';   // members functions.
			require_once ERE_PLUGIN_DIR . 'includes/functions/subscription-api.php'; // Subscription.

			// Require property analytics feature related files if it's enabled.
			if ( inspiry_is_property_analytics_enabled() ) {
				require_once ERE_PLUGIN_DIR . 'includes/property-analytics/class-property-analytics.php';   // property analytics model.
				require_once ERE_PLUGIN_DIR . 'includes/property-analytics/class-property-analytics-view.php';   // property analytics view.
			}

			if ( class_exists( 'ERE_Subscription_API' ) && ERE_Subscription_API::status() ) {
				require_once ERE_PLUGIN_DIR . 'includes/functions/plugin-update.php';   // plugin update functions.
			}
		}

		/**
		 * Shortcodes
		 */
		public function include_shortcodes() {
			include_once ERE_PLUGIN_DIR . 'includes/shortcodes/columns.php';
			include_once ERE_PLUGIN_DIR . 'includes/shortcodes/elements.php';
			include_once ERE_PLUGIN_DIR . 'includes/shortcodes/vc-map.php';
		}

		/**
		 * Widgets
		 */
		public function include_widgets() {
			include_once ERE_PLUGIN_DIR . 'includes/widgets/agent-properties-widget.php';
			include_once ERE_PLUGIN_DIR . 'includes/widgets/agents-list-widget.php';
			include_once ERE_PLUGIN_DIR . 'includes/widgets/agent-featured-properties-widget.php';
			include_once ERE_PLUGIN_DIR . 'includes/widgets/featured-properties-widget.php';
			include_once ERE_PLUGIN_DIR . 'includes/widgets/properties-widget.php';
			include_once ERE_PLUGIN_DIR . 'includes/widgets/property-types-widget.php';
			include_once ERE_PLUGIN_DIR . 'includes/widgets/advance-search-widget.php';
			include_once ERE_PLUGIN_DIR . 'includes/widgets/contact-form-widget.php';
			include_once ERE_PLUGIN_DIR . 'includes/widgets/mortgage-calculator-widget.php';
			include_once ERE_PLUGIN_DIR . 'includes/widgets/rh-contact-information-widget.php';
		}

		/**
		 * Admin menu.
		 */
		public function initialize_admin_menu() {
			require_once ERE_PLUGIN_DIR . 'includes/admin-menu/class-ere-admin-menu.php';
		}

		/**
		 * Custom Post Types
		 */
		public function initialize_custom_post_types() {
			include_once ERE_PLUGIN_DIR . 'includes/custom-post-types/property.php';   // Property post type.
			include_once ERE_PLUGIN_DIR . 'includes/custom-post-types/agent.php';   // Agent post type.
			include_once ERE_PLUGIN_DIR . 'includes/custom-post-types/agency.php';   // Agency post type.
			include_once ERE_PLUGIN_DIR . 'includes/custom-post-types/partners.php';   // Partners post type.
			include_once ERE_PLUGIN_DIR . 'includes/custom-post-types/slide.php';   // Slide post type.
		}

		/**
		 * Meta boxes
		 */
		public function initialize_meta_boxes() {
			include_once ERE_PLUGIN_DIR . 'includes/mb/class-ere-meta-boxes.php';
			include_once ERE_PLUGIN_DIR . 'includes/mb/property-additional-fields.php';
		}

		/**
		 * Initialize hooks.
		 */
		public function init_hooks() {
			add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ) );  // plugin's admin styles.
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) ); // plugin's admin scrips.
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) ); // plugin's scripts.
		}

		/**
		 * Load text domain for translation.
		 */
		public function load_plugin_textdomain() {
			load_plugin_textdomain( 'easy-real-estate', false, dirname( ERE_PLUGIN_BASENAME ) . '/languages' );
		}

		/**
		 * Enqueue admin styles
		 */
		public function enqueue_admin_styles() {
			wp_enqueue_style( 'easy-real-estate-admin', ERE_PLUGIN_URL . 'css/ere-admin.css', array(), $this->version, 'all' );
		}

		/**
		 * Enqueue Admin JavaScript
		 */
		public function enqueue_admin_scripts() {
			wp_enqueue_script(
				'easy-real-estate-admin',
				ERE_PLUGIN_URL . 'js/ere-admin.js',
				array(
					'jquery',
					'jquery-ui-sortable',
				),
				$this->version
			);

			$ere_social_links_strings = array(
				'title'       => esc_html__( 'Title', 'easy-real-estate' ),
				'profileURL'  => esc_html__( 'Profile URL', 'easy-real-estate' ),
				'iconClass'   => esc_html__( 'Icon Class', 'easy-real-estate' ),
				'iconExample' => esc_html__( 'Example: fas fa-flicker', 'easy-real-estate' ),
				'iconLink'    => esc_html__( 'Get icon!', 'easy-real-estate' ),
			);
			wp_localize_script( 'easy-real-estate-admin', 'ereSocialLinksL10n', $ere_social_links_strings );

			$ere_price_number_format_Data = array(
				'local' => get_option( 'ere_price_number_format_language', 'en-US' ),
			);
			wp_localize_script( 'easy-real-estate-admin', 'erePriceNumberFormatData', $ere_price_number_format_Data );
		}

		/**
		 * Enqueue JavaScript
		 */
		public function enqueue_scripts() {

			// ERE frontend script.
			wp_register_script( 'jquery-validate', ERE_PLUGIN_URL . 'js/jquery.validate.min.js', array(
				'jquery',
				'jquery-form'
			), $this->version, true );
			wp_register_script( 'ere-frontend', ERE_PLUGIN_URL . 'js/ere-frontend.js', array( 'jquery-validate' ), $this->version, true );
			wp_localize_script( 'ere-frontend', 'ere_social_login_data', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
			wp_enqueue_script( 'ere-frontend' );

			if ( inspiry_is_property_analytics_enabled() && is_singular( 'property' ) ) {

				// Chart.js JS library for the property views graph.
				wp_enqueue_script( 'chart.js', ERE_PLUGIN_URL . 'includes/property-analytics/js/chart.min.js', array( 'jquery' ), $this->version, true );

				// Custom script to handle Property Views Ajax request and Graph display.
				wp_register_script( 'ere-property-analytics', ERE_PLUGIN_URL . 'includes/property-analytics/js/property-analytics.js', array( 'jquery' ), $this->version, true );

				// Localizing property views ajax request data information.
				wp_localize_script(
					'ere-property-analytics',
					'property_analytics',
					array(
						'ajax_url'     => admin_url( 'admin-ajax.php' ),
						'ajax_nonce'   => wp_create_nonce( 'ere-property-analytics' ),
						'property_id'  => get_the_ID(),
						'border_color' => ( 'classic' === INSPIRY_DESIGN_VARIATION ) ? '#ec894d' : '#1ea69a',
						'data_label'   => esc_html__( 'Property Views', 'easy-real-estate' ),
						'chart_type'   => get_option( 'inspiry_property_analytics_chart_type', 'line' ),
					)
				);

				wp_enqueue_script( 'ere-property-analytics' );
			}
		}

		/**
		 * Tabs
		 */
		public function tabs() {

			$tabs = array(
				'price'              => esc_html__( 'Price Format', 'easy-real-estate' ),
				'slug'               => esc_html__( 'URL Slugs', 'easy-real-estate' ),
				'map'                => esc_html__( 'Maps', 'easy-real-estate' ),
				'captcha'            => esc_html__( 'reCAPTCHA', 'easy-real-estate' ),
				'social'             => esc_html__( 'Social', 'easy-real-estate' ),
				'gdpr'               => esc_html__( 'GDPR', 'easy-real-estate' ),
				'property'           => esc_html__( 'Property', 'easy-real-estate' ),
				'property-analytics' => esc_html__( 'Property Analytics', 'easy-real-estate' ),
				'webhooks'           => esc_html__( 'Webhooks', 'easy-real-estate' ),
			);

			// Filter to add the New Settings tabs
			$tabs = apply_filters('ere_settings_tabs', $tabs);
			return $tabs;
		}
		/**
		 * Generates tabs navigation
		 */
		public function tabs_nav( $current_tab ) {

			$tabs = $this->tabs();
			?>
            <div id="inspiry-ere-tabs" class="inspiry-ere-tabs">
				<?php
				if ( ! empty( $tabs ) && is_array( $tabs ) ) {
					foreach ( $tabs as $slug => $title ) {
                        //TODO: use of RHPE_PLUGIN_DIR here is odd and we need to find out a better solution for this
						if ( file_exists( ERE_PLUGIN_DIR . 'includes/settings/' . $slug . '.php' ) || file_exists( RHPE_PLUGIN_DIR . 'includes/settings/' . $slug . '.php' )) {
							$active_tab = ( $current_tab === $slug ) ? ' inspiry-is-active-tab' : '';
							$admin_url  = ( $current_tab === $slug ) ? '#' : admin_url( 'admin.php?page=ere-settings&tab=' . $slug );
							echo '<a class="inspiry-ere-tab ' . esc_attr( $active_tab ) . '" href="' . esc_url_raw( $admin_url ) . '" data-tab="' . esc_attr( $slug ) . '">' . esc_html( $title ) . '</a>';
						}
					}
				}
				?>
            </div>
			<?php
		}

		/**
		 * Settings page callback
		 */
		public function settings_page() {
			require_once ERE_PLUGIN_DIR . 'includes/settings/settings.php';
		}

		/**
		 * Retrieves an option value based on an option name.
		 *
		 * @param string $option_name
		 * @param bool $default
		 * @param string $type
		 *
		 * @return mixed|string
		 */
		public function get_option( $option_name, $default = false, $type = 'text' ) {

			if ( isset( $_POST[ $option_name ] ) ) {
				$value = $_POST[ $option_name ];

				switch ( $type ) {
					case 'textarea':
						$value = wp_kses( $value, array(
							'a'      => array(
								'class'  => array(),
								'href'   => array(),
								'target' => array(),
								'title'  => array(),
							),
							'br'     => array(),
							'em'     => array(),
							'strong' => array(),
						) );
						break;

					default:
						$value = sanitize_text_field( $value );
				}

				return $value;
			}

			return get_option( $option_name, $default );
		}

		/**
		 * Sanitize additional social networks array.
		 */
		public function sanitize_social_networks( $social_networks ) {

			// Initialize the new array that will hold the sanitize values.
			$sanitized_social_networks = array();

			foreach ( $social_networks as $index => $social_network ) {
				foreach ( $social_network as $key => $value ) {
					$sanitized_social_networks[ $index ][ $key ] = sanitize_text_field( $value );
				}
			}

			return $sanitized_social_networks;
		}

		/**
		 * Add notice when settings are saved.
		 */
		public function notice() {
			?>
            <div id="setting-error-ere_settings_updated" class="updated notice is-dismissible">
                <p><strong><?php esc_html_e( 'Settings saved successfully!', 'easy-real-estate' ); ?></strong></p>
            </div>
			<?php
		}

		/**
		 * Cloning is forbidden.
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cloning is forbidden!', 'easy-real-estate' ), ERE_VERSION );
		}

		/**
		 * Unserializing instances of this class is forbidden.
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Unserializing is forbidden!', 'easy-real-estate' ), ERE_VERSION );
		}

	}

endif; // End if class_exists check.


// run on ERE activation
function ere_plugin_activated(){
	add_option( 'ere_plugin_activated', true );
}
register_activation_hook( __FILE__, 'ere_plugin_activated' );

/**
 * Check plugins conflict with ERE
 */
function ere_check_plugins_conflict() {

	// List of conflicted plugins.
	$conflicted_plugins = array(
		'easy-property-listings/easy-property-listings.php',
		'essential-real-estate/essential-real-estate.php',
		'real-estate-listing-realtyna-wpl/WPL.php',
		'wp-listings/plugin.php',
		'wp-property/wp-property.php',
	);

	// Get all installed plugins.
	$all_plugins = get_plugins();
	if ( ! empty( $all_plugins ) ) {

		// Current collection of conflicted plugins.
		$current_conflicted_plugins = array();

		foreach ( $all_plugins as $file => $plugin ) {
			if ( in_array( $file, $conflicted_plugins ) ) {
				$current_conflicted_plugins[] = $plugin['Name'];
			}
		}

		if ( ! empty( $current_conflicted_plugins ) ) :
			?>
			<div class="notice notice-warning is-dismissible">
				<p>
					<?php
					printf(
						esc_html__( '%sEasy Real Estate%s detected the following plugins that may create conflicts with RealHomes Theme functionality. Please delete these plugins to run your site smoothly.', 'easy-real-estate' ),
						'<strong>', '</strong>' );
					?>
				</p>
				<pre><?php
					foreach ( $current_conflicted_plugins as $conflicted_plugin ) {
						echo '- ' . esc_html( $conflicted_plugin ) . '<br />';
					}
					?></pre>
			</div>
		<?php
		endif;
	}
}

// hook plugins conflict check function to admin_notices
function ere_notify_conflicts() {
    if ( is_admin() && get_option( 'ere_plugin_activated', false ) ) {
		add_action( 'admin_notices', 'ere_check_plugins_conflict' );
        delete_option( 'ere_plugin_activated' );
    }
}
add_action( 'admin_init', 'ere_notify_conflicts' );

/**
 * Main instance of Easy_Real_Estate.
 *
 * Returns the main instance of Easy_Real_Estate to prevent the need to use globals.
 *
 * @return Easy_Real_Estate
 */
function ERR() {
	return Easy_Real_Estate::instance();
}

// Get ERR Running.
ERR();
