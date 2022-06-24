<?php
/**
 * Plugin Name:     Real Estate CRM
 * Description:     Provides CRM functionality for Real Homes theme.
 * Version:         0.0.6
 * Author:          Inspiry Themes
 * Author URI:      https://inspirythemes.com/
 * License:         GPL-2.0
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     real-estate-crm
 * Domain Path:     /languages
 */


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! defined( 'RECRM_PLUGIN_BASENAME' ) ) {
	define( 'RECRM_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}

if ( ! defined( 'RECRM_PLUGIN_URL' ) ) {
	define( 'RECRM_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

if ( ! class_exists( 'RECRM_Real_Estate_CRM' ) ) {

	/**
	 * Main class of plugin
	 */
	class RECRM_Real_Estate_CRM {

		public static $version = '0.0.6';

		public function __construct() {

			$this->includes_initiate();
			$this->load_plugin_textdomain();

			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			add_filter( 'plugin_action_links_' . RECRM_PLUGIN_BASENAME, array( $this, 'action_links' ) );
		}

		public function enqueue_styles() {
			//Plugin's core style sheet
			wp_enqueue_style( 'recrm-admin-styles', plugin_dir_url( __FILE__ ) . 'css/recrm-admin.css' );
		}


		public function enqueue_scripts() {

			//Plugin's core scripts
			wp_enqueue_script( 'recrm-admin-scripts', plugin_dir_url( __FILE__ ) . 'js/recrm-admin.js', 'jquery', self::$version, true );

			$locals = array(
				'titleUpload' => esc_html__( 'Insert File', 'real-estate-crm' ),
				'useFile'     => esc_html__( 'Use this File', 'real-estate-crm' ),
			);
			wp_localize_script( 'recrm-admin-scripts', 'RECRM_admin_handle', $locals );

		}

		public function includes_initiate() {

			require plugin_dir_path( __FILE__ ) . 'inc/class-recrm-initiate.php';
		}

		public function load_plugin_textdomain() {

			load_plugin_textdomain( 'real-estate-crm', false, dirname( RECRM_PLUGIN_BASENAME ) . '/languages/' );

		}

		public function action_links( $links ) {
			$links[] = '<a href="' . get_admin_url( null, 'admin.php?page=recrm-settings' ) . '">' . esc_html__( 'Settings', 'real-estate-crm' ) . '</a>';

			return $links;
		}

	}

}


new RECRM_Real_Estate_CRM();