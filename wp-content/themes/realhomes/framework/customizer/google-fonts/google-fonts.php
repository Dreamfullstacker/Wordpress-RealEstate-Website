<?php
/**
 * Return an array of all available Google Fonts.
 *
 * @return array All Google Fonts.
 */
function inspiry_get_google_fonts() {

	// Store fonts list.
	$fonts = array();

	$fonts_file = wp_remote_fopen( get_template_directory_uri() . '/framework/customizer/google-fonts/webfonts.json' );
	if ( ! empty( $fonts_file ) ) {

		// Change the object to a multidimensional array.
		$fonts_array = json_decode( $fonts_file, true );

		if ( isset( $fonts_array['items'] ) && is_array( $fonts_array['items'] ) ) {

			// Italic variants.
			$remove_variants = array(
				'italic',
				'100italic',
				'200italic',
				'300italic',
				'400italic',
				'500italic',
				'600italic',
				'700italic',
				'800italic',
				'900italic',
				'100i',
				'200i',
				'300i',
				'400i',
				'500i',
				'600i',
				'700i',
				'800i',
				'900i',
			);

			foreach ( $fonts_array['items'] as $font ) {

				// Remove italic variants.
				$font['variants'] = array_diff( $font['variants'], $remove_variants );

				// Change the array key to the font's ID.
				$font_id           = trim( str_replace( ' ', '+', $font['family'] ) );
				$fonts[ $font_id ] = $font;
			}
		}
	}

	return $fonts;
}

/**
 * This class provides the Google Fonts related functionality.
 */
class Inspiry_Google_Fonts {

	/**
	 * All Google fonts.
	 *
	 * @var array
	 */
	public static $fonts = array();

	/**
	 * Google font families list.
	 *
	 * @var array
	 */
	public static $fonts_list = array();

	/**
	 * Instance
	 *
	 * @var Inspiry_Google_Fonts The single instance of the class.
	 */
	private static $_instance = null;

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
	 * Let's get started.
	 */
	public function __construct() {
		self::$fonts      = inspiry_get_google_fonts();
		self::$fonts_list = self::get_list();
		add_action( 'wp_ajax_inspiry_get_font_weights', array( $this, 'get_font_weights_markup' ) );
	}

	/**
	 * Get the fonts list.
	 */
	private static function get_list() {
		$fonts_list = array();

		$fonts = self::$fonts;
		if ( ! empty( $fonts ) && is_array( $fonts ) ) {
			foreach ( $fonts as $font_id => $font ) {
				$fonts_list[ $font_id ] = esc_html( $font['family'] );
			}

			ksort( $fonts_list, SORT_STRING );
		}

		return array( 'Default' => esc_html__( 'Default', 'framework' ) ) + $fonts_list;
	}

	/**
	 * Get the font weights for given font ID.
	 *
	 * @param string $font_id The font ID.
	 * @param bool $show_default
	 * @param bool $join
	 *
	 * @return array|string
	 */
	public static function get_font_weights( $font_id, $show_default = true, $join = false ) {

		$font_weights = array();
		if ( $show_default ) {
			$font_weights['Default'] = esc_html__( 'Default', 'framework' );
		}

		if ( empty( $font_id ) || 'Default' === $font_id ) {
			return $font_weights;
		}

		if ( isset( self::$fonts[ $font_id ] ) ) {
			$variants = self::$fonts[ $font_id ]['variants'];
			if ( ! empty( $variants ) && is_array( $variants ) ) {
				foreach ( $variants as $variant ) {
					if ( 'regular' === $variant ) {
						$variant = '400';
					}
					$font_weights[ $variant ] = $variant;
				}
			}
		}

		if ( $join ) {
			return join( ',', $font_weights );
		}
		
		return $font_weights;
	}

	/**
	 * Get the font weights from ID and display markup.
	 */
	public function get_font_weights_markup() {
		if ( isset( $_POST['family'] ) && ! empty( $_POST['family'] ) ) {
			$weights = self::get_font_weights( sanitize_text_field( $_POST['family'] ) );
			$output  = '';
			if ( ! empty( $weights ) && is_array( $weights ) ) {
				foreach ( $weights as $weight ) {
					$output .= '<option value="' . $weight . '">' . $weight . '</option>';
				}
			}

			echo $output;
		}
	}

	/**
	 * Get the font family from ID for fonts URL.
	 *
	 * @param string $font_id The font ID.
	 *
	 * @return string
	 */
	public static function get_font_family( $font_id ) {
		$font = self::$fonts[ $font_id ];
		return sprintf( "'%s', %s", $font['family'], $font['category'] );
	}
}

// Main instance of Inspiry_Google_Fonts.
Inspiry_Google_Fonts::instance();