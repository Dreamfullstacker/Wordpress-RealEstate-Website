<?php
/**
 * Design variation related functions
 *
 * This file contains all the functions related to design
 * variations of this theme.
 *
 * @package realhomes
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'inspiry_header_print_scripts' ) ) {
	/**
	 * Print header scripts.
	 */
	function inspiry_header_print_scripts() {
		?>
        <script>
			<?php
			// Generate ajax url to use across the website.
			$ajax_url = admin_url( 'admin-ajax.php' );
			$wpml_current_lang = apply_filters( 'wpml_current_language', null );
			if ( $wpml_current_lang ) {
				$ajax_url = add_query_arg( 'wpml_lang', $wpml_current_lang, $ajax_url );
			}
			?>// Declare some common JS variables.
            var ajaxurl = "<?php echo esc_url( $ajax_url ); ?>";
        </script>
		<?php
	}

	add_action( 'wp_print_scripts', 'inspiry_header_print_scripts' );
}

if ( ! function_exists( 'inspiry_enqueue_theme_styles' ) ) {
	/**
	 * Load Required CSS Styles
	 */
	function inspiry_enqueue_theme_styles() {
		if ( ! is_page_template( 'templates/dashboard.php' ) ) {
			if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
				inspiry_enqueue_classic_styles();
			} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
				inspiry_enqueue_modern_styles();
			}

			inspiry_enqueue_common_styles();
		}
	}

	add_action( 'wp_enqueue_scripts', 'inspiry_enqueue_theme_styles' );
}


if ( ! function_exists( 'inspiry_enqueue_theme_scripts' ) ) {
	/**
	 * Enqueue JavaScripts required for this theme
	 */
	function inspiry_enqueue_theme_scripts() {
		if ( ! is_page_template( 'templates/dashboard.php' ) ) {
			if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
				inspiry_enqueue_classic_scripts();
			} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
				inspiry_enqueue_modern_scripts();
			}

			inspiry_enqueue_common_scripts();
		}
	}

	add_action( 'wp_enqueue_scripts', 'inspiry_enqueue_theme_scripts' );
}


if ( ! function_exists( 'inspiry_enqueue_classic_styles' ) ) {
	/**
	 * Function to load classic styles.
	 *
	 * @since 2.7.0
	 */
	function inspiry_enqueue_classic_styles() {
		if ( ! is_admin() ) {

			$js_dir_path  = '/assets/' . INSPIRY_DESIGN_VARIATION . '/scripts/';
			$css_dir_path = '/assets/' . INSPIRY_DESIGN_VARIATION . '/styles/';

			/*
			 * Register Default and Custom Styles
			 */
			wp_register_style(
				'parent-default',
				get_stylesheet_uri(),
				array(),
				INSPIRY_THEME_VERSION,
				'all'
			);

			// Flex Slider
			wp_dequeue_style( 'flexslider' );       // dequeue flexslider if it registered by a plugin.
			wp_deregister_style( 'flexslider' );    // deregister flexslider if it registered by a plugin.

			// Main CSS in minified format
			wp_enqueue_style(
				'main-css',
				get_theme_file_uri( $css_dir_path . 'css/main.min.css' ),
				array(),
				INSPIRY_THEME_VERSION,
				'all'
			);

			/*
			 * RTL Styles
			 */
			if ( is_rtl() ) {
				wp_enqueue_style(
					'rtl-main-css',
					get_theme_file_uri( $css_dir_path . 'css/rtl-main.min.css' ),
					array(),
					INSPIRY_THEME_VERSION,
					'all'
				);
			}

			wp_add_inline_style( 'main-css', apply_filters( 'realhomes_classic_custom_css', '' ) );

			/*
			 * IF Visual Composer Plugins installed and activated
			 */
			if ( class_exists( 'Vc_Manager' ) ) {
				wp_enqueue_style(
					'vc-css',
					get_theme_file_uri( $css_dir_path . 'css/visual-composer.min.css' ),
					array(),
					INSPIRY_THEME_VERSION,
					'all'
				);
			}

			// default css.
			wp_enqueue_style( 'parent-default' );
		}
	}
}


if ( ! function_exists( 'inspiry_enqueue_classic_scripts' ) ) {
	/**
	 * Function to load classic scripts.
	 *
	 * @since 2.7.0
	 */
	function inspiry_enqueue_classic_scripts() {
		if ( ! is_admin() ) {

			$js_dir_path = '/assets/' . INSPIRY_DESIGN_VARIATION . '/scripts/';

			// flexslider
			wp_dequeue_script( 'flexslider' );      // dequeue flexslider if it is enqueue by some plugin.

			/**
			 * Registering of Scripts
			 */

			// Search form script.
			wp_register_script(
				'inspiry-search',
				get_theme_file_uri( $js_dir_path . 'js/inspiry-search-form.js' ),
				array( 'jquery' ),
				INSPIRY_THEME_VERSION,
				true
			);

			// Theme's main script.
			wp_register_script(
				'custom',
				get_theme_file_uri( $js_dir_path . 'js/custom.js' ),
				array( 'jquery' ),
				INSPIRY_THEME_VERSION,
				true
			);

			/**
			 * Enqueue Scripts that are needed on all the pages
			 */
			wp_enqueue_script( 'jquery-ui-autocomplete' );
			wp_enqueue_script( 'jquery-form' );

			/*
			 * Classic Vendors Minified JS, includes the following scripts
             * 1. jquery.easing.min.js
             * 2. elastislide/jquery.elastislide.js
             * 3. jquery.jcarousel.min.js
             * 4. jquery.transit.min.js
			 */
			wp_enqueue_script(
				'classic-vendors-js',
				get_theme_file_uri( $js_dir_path . 'vendors/vendors.min.js' ),
				array( 'jquery', ),
				INSPIRY_THEME_VERSION,
				true
			);

			/**
			 * Maps Script
			 */
			$map_type = inspiry_get_maps_type();
			if ( 'google-maps' == $map_type ) {
				inspiry_enqueue_google_maps();
			} else {
				inspiry_enqueue_open_street_map();
			}

			/**
			 * Property Submit and Edit page
			 */
			if ( is_page_template( 'templates/submit-property.php' ) ) {

				// For image upload.
				wp_enqueue_script( 'plupload' );

				// For sortable additional details.
				wp_enqueue_script( 'jquery-ui-sortable' );

				// Property Submit Script.
				wp_register_script(
					'property-submit',
					get_theme_file_uri( $js_dir_path . 'js/property-submit.js' ),
					array( 'jquery', 'wp-util', 'jquery-ui-sortable', 'plupload' ),
					INSPIRY_THEME_VERSION,
					true
				);

				// Data to print in JavaScript format above property submit script tag in HTML.
				$property_submit_data = array(
					'ajaxURL'       => admin_url( 'admin-ajax.php' ),
					'uploadNonce'   => wp_create_nonce( 'inspiry_allow_upload' ),
					'fileTypeTitle' => esc_html__( 'Valid file formats', 'framework' ),
				);

				wp_localize_script( 'property-submit', 'propertySubmit', $property_submit_data );
				wp_enqueue_script( 'property-submit' );

			}

			/**
			 * Edit profile template
			 */
			if ( is_page_template( 'templates/edit-profile.php' ) ) {

				// For image upload.
				wp_enqueue_script( 'plupload' );

				wp_register_script(
					'edit-profile',
					get_theme_file_uri( $js_dir_path . 'js/edit-profile.js' ),
					array( 'jquery', 'plupload' ),
					INSPIRY_THEME_VERSION,
					true
				);

				// Data to print in JavaScript format above edit profile script tag in HTML.
				$edit_profile_data = array(
					'ajaxURL'       => admin_url( 'admin-ajax.php' ),
					'uploadNonce'   => wp_create_nonce( 'inspiry_allow_upload' ),
					'fileTypeTitle' => esc_html__( 'Valid file formats', 'framework' ),
				);

				wp_localize_script( 'edit-profile', 'editProfile', $edit_profile_data );
				wp_enqueue_script( 'edit-profile' );
			}

			/**
			 * Script for comments reply
			 */
			if ( is_singular( 'post' ) || is_page() || is_singular( 'property' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}

			/* Print select status for rent to switch prices in properties search form */
			$rent_slug               = get_option( 'theme_status_for_rent' );
			$localized_search_params = array();
			if ( ! empty( $rent_slug ) ) {
				$localized_search_params['rent_slug'] = $rent_slug;
			}

			/* localize search parameters */
			wp_localize_script( 'inspiry-search', 'localizedSearchParams', $localized_search_params );

			/* Inspiry search form script */
			wp_enqueue_script( 'inspiry-search' );

			/*
			 * Google reCaptcha
			 */
			if ( class_exists( 'Easy_Real_Estate' ) ) {
				if ( ere_is_reCAPTCHA_configured() ) {

					$inspiry_contact_form_shortcode = get_option( 'inspiry_contact_form_shortcode' );
					$reCPATCHA_type                 = get_option( 'inspiry_reCAPTCHA_type', 'v2' );

					if ( 'v3' === $reCPATCHA_type ) {
						$render = get_option( 'theme_recaptcha_public_key' );
					} else {
						$render = 'explicit';
					}

					$recaptcha_src = esc_url_raw( add_query_arg( array(
						'render' => $render,
						'onload' => 'loadInspiryReCAPTCHA',
					), '//www.google.com/recaptcha/api.js' ) );

					if ( ! is_page_template( 'templates/contact.php' ) ) {
						// Enqueue google reCAPTCHA API.
						wp_enqueue_script(
							'rh-google-recaptcha',
							$recaptcha_src,
							array(),
							INSPIRY_THEME_VERSION,
							true
						);
					} elseif ( empty( $inspiry_contact_form_shortcode ) ) {
						// Enqueue google reCAPTCHA API.
						wp_enqueue_script(
							'rh-google-recaptcha',
							$recaptcha_src,
							array(),
							INSPIRY_THEME_VERSION,
							true
						);
					}
				}
			}

			/* custom js localization */
			$localized_array = array(
				'nav_title'          => esc_html__( 'Go to...', 'framework' ),
				'more_search_fields' => esc_html__( 'More fields', 'framework' ),
				'less_search_fields' => esc_html__( 'Less fields', 'framework' )
			);
			wp_localize_script( 'custom', 'localized', $localized_array );

			// Data to print in JavaScript format above custom js script tag in HTML.
			$custom_data = array(
				'video_width'  => get_option( 'inpsiry_property_video_popup_width', 1778 ),
				'video_height' => get_option( 'inspiry_property_video_popup_height', 1000 ),
			);
			wp_localize_script( 'custom', 'customData', $custom_data );

			$select_string = array(
				'select_noResult' => get_option( 'inspiry_select2_no_result_string', esc_html__( 'No Results Found!', 'framework' ), true )
			);
			wp_localize_script( 'custom', 'localizeSelect', $select_string );

			if ( is_page_template( 'templates/home.php' ) ) {
				$inspiry_cfos_success_redirect_page = get_post_meta( get_the_ID(), 'inspiry_cfos_success_redirect_page', true );
				if ( ! empty( $inspiry_cfos_success_redirect_page ) ) {
					$CFOSData = array( 'redirectPageUrl' => get_the_permalink( $inspiry_cfos_success_redirect_page ) );
					wp_localize_script( 'custom', 'CFOSData', $CFOSData );
				}
			}

			if ( is_page_template( 'templates/contact.php' ) ) {
				$inspiry_contact_form_success_redirect_page = get_post_meta( get_the_ID(), 'inspiry_contact_form_success_redirect_page', true );
				if ( ! empty( $inspiry_contact_form_success_redirect_page ) ) {
					$contactFromData = array( 'redirectPageUrl' => get_the_permalink( $inspiry_contact_form_success_redirect_page ) );
					wp_localize_script( 'custom', 'contactFromData', $contactFromData );
				}
			}

			/* Finally enqueue theme's main script */
			wp_enqueue_script( 'custom' );

		}
	}

}


if ( ! function_exists( 'inspiry_enqueue_modern_styles' ) ) {
	/**
	 * Function to load modern styles.
	 *
	 * @since 3.0.0
	 */
	function inspiry_enqueue_modern_styles() {

		if ( ! is_admin() ) {

			$js_dir_path  = '/assets/' . INSPIRY_DESIGN_VARIATION . '/scripts/';
			$css_dir_path = '/assets/' . INSPIRY_DESIGN_VARIATION . '/styles/';

			/**
			 * Register Default and Custom Styles
			 */
			wp_register_style(
				'parent-default',
				get_stylesheet_uri(),
				array(),
				INSPIRY_THEME_VERSION,
				'all'
			);

			// Flex Slider
			wp_dequeue_style( 'flexslider' );       // dequeue flexslider if it registered by a plugin.
			wp_deregister_style( 'flexslider' );    // deregister flexslider if it registered by a plugin.

			if ( is_singular( 'property' ) ) {

				// entypo fonts.
				wp_enqueue_style(
					'entypo-fonts',
					get_theme_file_uri( $css_dir_path . 'css/entypo.min.css' ),
					array(),
					INSPIRY_THEME_VERSION,
					'all'
				);
			}

			/**
			 * Main CSS
			 */
			wp_enqueue_style(
				'main-css',
				get_theme_file_uri( $css_dir_path . 'css/main.min.css' ),
				array(),
				INSPIRY_THEME_VERSION,
				'all'
			);

			wp_add_inline_style( 'main-css', apply_filters( 'realhomes_modern_custom_css', '' ) );

			/**
			 * RTL Styles
			 */
			if ( is_rtl() ) {
				wp_enqueue_style(
					'rtl-main-css',
					get_theme_file_uri( $css_dir_path . 'css/rtl-main.min.css' ),
					array(),
					INSPIRY_THEME_VERSION,
					'all'
				);
			}

			// default css.
			wp_enqueue_style( 'parent-default' );

		}
	}
}


if ( ! function_exists( 'inspiry_enqueue_modern_scripts' ) ) {
	/**
	 * Function to load modern scripts.
	 *
	 * @since 3.0.0
	 */
	function inspiry_enqueue_modern_scripts() {

		if ( ! is_admin() ) {

			$js_dir_path = '/assets/' . INSPIRY_DESIGN_VARIATION . '/scripts/';

			// Flexslider.
			wp_dequeue_script( 'flexslider' );      // dequeue flexslider if it is enqueue by some plugin.

			// Progress bar.
			wp_register_script(
				'progress-bar',
				get_theme_file_uri( $js_dir_path . 'vendors/progressbar/dist/progressbar.min.js' ),
				array( 'jquery' ),
				'1.0.1',
				true
			);


			/**
			 * Edit profile template
			 */
			wp_enqueue_script( 'progress-bar' );
			wp_enqueue_script( 'jquery-form' );

			/**
			 * Maps Script
			 */
			$map_type = inspiry_get_maps_type();
			if ( 'google-maps' == $map_type ) {
				inspiry_enqueue_google_maps();
			} else {
				inspiry_enqueue_open_street_map();
			}

			// Search form script.
			wp_register_script(
				'inspiry-search',
				get_theme_file_uri( $js_dir_path . 'js/inspiry-search-form.js' ),
				array( 'jquery' ),
				INSPIRY_THEME_VERSION,
				true
			);

			// Theme's main script.
			wp_register_script(
				'custom',
				get_theme_file_uri( $js_dir_path . 'js/custom.js' ),
				array( 'jquery' ),
				INSPIRY_THEME_VERSION,
				true
			);

			/**
			 * Edit profile template
			 */
			if ( is_page_template( 'templates/edit-profile.php' ) ) {

				// For image upload.
				wp_enqueue_script( 'plupload' );

				wp_register_script(
					'edit-profile',
					get_theme_file_uri( $js_dir_path . 'js/edit-profile.js' ),
					array( 'jquery', 'plupload' ),
					INSPIRY_THEME_VERSION,
					true
				);

				// Data to print in JavaScript format above edit profile script tag in HTML.
				$edit_profile_data = array(
					'ajaxURL'       => admin_url( 'admin-ajax.php' ),
					'uploadNonce'   => wp_create_nonce( 'inspiry_allow_upload' ),
					'fileTypeTitle' => esc_html__( 'Valid file formats', 'framework' ),
				);

				wp_localize_script( 'edit-profile', 'editProfile', $edit_profile_data );
				wp_enqueue_script( 'edit-profile' );
			}

			/**
			 * Memberships template
			 */
			if ( is_page_template( 'templates/membership-plans.php' ) ) {

				wp_register_script(
					'rh-memberships',
					get_theme_file_uri( $js_dir_path . 'js/rh-memberships.js' ),
					array( 'jquery' ),
					INSPIRY_THEME_VERSION,
					true
				);

				// Localize the 'rh-memberships' script with needed data.
				$translation_array = array(
					'cancel_membership' => esc_html__( 'Cancel Membership', 'framework' ),
				);
				wp_localize_script( 'rh-memberships', 'rh_memberships', $translation_array );

				wp_enqueue_script( 'rh-memberships' );
			}

			/**
			 * My Properties Template
			 */
			if ( is_page_template( 'templates/my-properties.php' ) ) {
				wp_register_script(
					'my-properties',
					get_theme_file_uri( $js_dir_path . 'js/my-properties.js' ),
					array( 'jquery' ),
					INSPIRY_THEME_VERSION,
					true
				);
				wp_enqueue_script( 'my-properties' );
			}

			/**
			 * Property Submit and Edit page
			 */
			if ( is_page_template( 'templates/submit-property.php' ) ) {

				// For image upload.
				wp_enqueue_script( 'plupload' );

				// For sortable additional details.
				wp_enqueue_script( 'jquery-ui-sortable' );

				// Property Submit Script.
				wp_register_script(
					'property-submit',
					get_theme_file_uri( $js_dir_path . 'js/property-submit.js' ),
					array( 'jquery', 'wp-util', 'jquery-ui-sortable', 'plupload' ),
					INSPIRY_THEME_VERSION,
					true
				);

				// Data to print in JavaScript format above property submit script tag in HTML.
				$property_submit_data = array(
					'ajaxURL'       => admin_url( 'admin-ajax.php' ),
					'uploadNonce'   => wp_create_nonce( 'inspiry_allow_upload' ),
					'fileTypeTitle' => esc_html__( 'Valid file formats', 'framework' ),
				);

				wp_localize_script( 'property-submit', 'propertySubmit', $property_submit_data );
				wp_enqueue_script( 'property-submit' );
			}

			if ( is_singular( 'property' ) ) {

				wp_enqueue_script(
					'share-js',
					get_theme_file_uri( $js_dir_path . 'vendors/share.min.js' ),
					array( 'jquery' ),
					INSPIRY_THEME_VERSION,
					true
				);

				wp_enqueue_script(
					'property-share',
					get_theme_file_uri( $js_dir_path . 'js/property-share.js' ),
					array( 'jquery' ),
					INSPIRY_THEME_VERSION,
					true
				);

				if ( 'true' === get_option( 'realhomes_line_social_share', 'false' ) ) {
					$realhomes_line_social_share = "
					(function($) { 
					    'use strict';
						$(document).ready(function () {
							$(window).on('load', function () {
							    var shareThisDiv = $('.share-this');
							    shareThisDiv.addClass('realhomes-line-social-share-enabled');
								shareThisDiv.find('ul').append('<li class=\"entypo-line\" id=\"realhomes-line-social-share\"><i class=\"fab fa-line\"></i></li>');
							});
							$(document).on('click', '#realhomes-line-social-share', function () {
								window.open(
									'https://social-plugins.line.me/lineit/share?url=' + encodeURIComponent(window.location.href),
									'_blank',
									'location=yes,height=570,width=520,scrollbars=yes,status=yes'
								);
							});
						});
					})(jQuery);";
					wp_add_inline_script( 'property-share', $realhomes_line_social_share );
				}
			}

			/**
			 * Script for comments reply
			 */
			if ( is_singular( 'post' ) || is_page() || is_singular( 'property' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}

			/* Print select status for rent to switch prices in properties search form */
			$rent_slug               = get_option( 'theme_status_for_rent' );
			$localized_search_params = array();
			if ( ! empty( $rent_slug ) ) {
				$localized_search_params['rent_slug'] = $rent_slug;
			}

			/* localize search parameters */
			wp_localize_script( 'inspiry-search', 'localizedSearchParams', $localized_search_params );

			wp_localize_script( 'inspiry-search', 'frontEndAjaxUrl', array( 'sfoiajaxurl' => admin_url( 'admin-ajax.php' ) ) );

			/* Inspiry search form script */
			wp_enqueue_script( 'inspiry-search' );

			/**
			 * Google reCaptcha
			 */
			if ( class_exists( 'Easy_Real_Estate' ) ) {
				if ( ere_is_reCAPTCHA_configured() ) {

					$inspiry_contact_form_shortcode = get_option( 'inspiry_contact_form_shortcode' );
					$reCPATCHA_type                 = get_option( 'inspiry_reCAPTCHA_type', 'v2' );

					if ( 'v3' === $reCPATCHA_type ) {
						$render = get_option( 'theme_recaptcha_public_key' );
					} else {
						$render = 'explicit';
					}

					$modern_recaptcha_src = esc_url_raw( add_query_arg( array(
						'render' => $render,
						'onload' => 'loadInspiryReCAPTCHA',
					), '//www.google.com/recaptcha/api.js' ) );

					if ( ! is_page_template( 'templates/contact.php' ) ) {
						// Enqueue google reCAPTCHA API.
						wp_enqueue_script(
							'inspiry-google-recaptcha',
							$modern_recaptcha_src,
							array(),
							INSPIRY_THEME_VERSION,
							true
						);
					} elseif ( empty( $inspiry_contact_form_shortcode ) ) {
						// Enqueue google reCAPTCHA API.
						wp_enqueue_script(
							'inspiry-google-recaptcha',
							$modern_recaptcha_src,
							array(),
							INSPIRY_THEME_VERSION,
							true
						);
					} else {
						remove_action( 'wp_footer', 'ere_recaptcha_callback_generator' );
					}
				}
			}

			// Data to print in JavaScript format above custom js script tag in HTML.
			$custom_data = array(
				'video_width'  => get_option( 'inpsiry_property_video_popup_width', 1778 ),
				'video_height' => get_option( 'inspiry_property_video_popup_height', 1000 ),
			);
			wp_localize_script( 'custom', 'customData', $custom_data );

			$select_string = array(
				'select_noResult' => get_option( 'inspiry_select2_no_result_string', esc_html__( 'No Results Found!', 'framework' ), true ),
			);
			wp_localize_script( 'custom', 'localizeSelect', $select_string );

			if ( is_page_template( 'templates/home.php' ) ) {
				$inspiry_cfos_success_redirect_page = get_post_meta( get_the_ID(), 'inspiry_cfos_success_redirect_page', true );
				if ( ! empty( $inspiry_cfos_success_redirect_page ) ) {
					$CFOSData = array( 'redirectPageUrl' => get_the_permalink( $inspiry_cfos_success_redirect_page ) );
					wp_localize_script( 'custom', 'CFOSData', $CFOSData );
				}
			}

			if ( is_page_template( 'templates/contact.php' ) ) {
				$inspiry_contact_form_success_redirect_page = get_post_meta( get_the_ID(), 'inspiry_contact_form_success_redirect_page', true );
				if ( ! empty( $inspiry_contact_form_success_redirect_page ) ) {
					$contactFromData = array( 'redirectPageUrl' => get_the_permalink( $inspiry_contact_form_success_redirect_page ) );
					wp_localize_script( 'custom', 'contactFromData', $contactFromData );
				}
			}

			wp_enqueue_script( 'custom' );

		}
	}
}


if ( ! function_exists( 'inspiry_enqueue_common_styles' ) ) {

	/**
	 * Function to load common styles.
	 *
	 * @since  3.0.2
	 */
	function inspiry_enqueue_common_styles() {

		$common_dir_path = '/common/';

		// Google Fonts
		wp_enqueue_style(
			'inspiry-google-fonts',
			inspiry_google_fonts(),
			array(),
			INSPIRY_THEME_VERSION
		);

		// FontAwesome 5 Stylesheet
		wp_enqueue_style( 'font-awesome-5-all',
			get_theme_file_uri( $common_dir_path . 'font-awesome/css/all.min.css' ),
			array(),
			'5.13.1',
			'all' );

		if ( is_singular( 'property' ) ) {
			wp_enqueue_style(
				'rh-font-awesome-stars',
				get_theme_file_uri( $common_dir_path . 'font-awesome/css/fontawesome-stars.css' ),
				array(),
				'1.0.0',
				'all'
			);
		}

		// Contains vendors styles.
		wp_enqueue_style(
			'vendors-css',
			get_theme_file_uri( 'common/optimize/vendors.css' ),
			array(),
			INSPIRY_THEME_VERSION,
			'all'
		);

		// parent theme custom css
		wp_enqueue_style(
			'parent-custom',
			get_theme_file_uri( 'assets/' . INSPIRY_DESIGN_VARIATION . '/styles/css/custom.css' ),
			array(),
			INSPIRY_THEME_VERSION,
			'all'
		);

		wp_add_inline_style( 'parent-custom', apply_filters( 'realhomes_common_custom_css', '' ) );
	}
}


if ( ! function_exists( 'inspiry_enqueue_common_scripts' ) ) {

	/**
	 * Function to load common scripts.
	 *
	 * @since  3.0.2
	 */
	function inspiry_enqueue_common_scripts() {

		$common_js_dir_path = '/common/js/';


		// BarRating JS.
		$property_ratings = get_option( 'inspiry_property_ratings', 'false' );
		if ( 'true' === $property_ratings && is_singular( 'property' ) ) {
			// jQuery Bar Rating.
			wp_enqueue_script(
				'rh-jquery-bar-rating',
				get_theme_file_uri( $common_js_dir_path . 'jquery.barrating.min.js' ),
				array( 'jquery' ),
				INSPIRY_THEME_VERSION,
				true
			);
		}


		/**
		 * Login Script
		 */
		if ( ! is_user_logged_in() ) {
			wp_enqueue_script(
				'inspiry-login',
				get_theme_file_uri( 'common/js/inspiry-login.js' ),
				array( 'jquery' ),
				INSPIRY_THEME_VERSION,
				true
			);
		}

		inspiry_lightbox_map_theme_essentials();

		if ( inspiry_is_rvr_enabled() ) {
			// Availability Calendar
			wp_enqueue_script(
				'availability-calendar',
				get_theme_file_uri( $common_js_dir_path . 'availability-calendar.min.js' ),
				array( 'jquery' ),
				INSPIRY_THEME_VERSION,
				true
			);
		}


		if ( ( 'enable' === get_option( 'theme_compare_properties_module' ) && get_option( 'inspiry_compare_page' ) ) ) {
			wp_enqueue_script(
				'compare-js',
				get_theme_file_uri( $common_js_dir_path . 'compare-properties.js' ),
				array( 'jquery' ),
				INSPIRY_THEME_VERSION,
				true
			);
		}

		wp_enqueue_script(
			'vendors-js',
			get_theme_file_uri( 'common/optimize/vendors.js' ),
			array( 'jquery' ),
			INSPIRY_THEME_VERSION,
			true
		);

		// locations related script
		wp_register_script(
			'realhomes-locations',
			get_theme_file_uri( $common_js_dir_path . 'locations.js' ),
			array( 'jquery' ),
			INSPIRY_THEME_VERSION,
			true
		);

		// Common Custom.
		wp_register_script(
			'common-custom',
			get_theme_file_uri( $common_js_dir_path . 'common-custom.js' ),
			array( 'jquery' ),
			INSPIRY_THEME_VERSION,
			true
		);

		wp_register_script(
			'inspiry-cfos-js',
			get_theme_file_uri( $common_js_dir_path . 'cfos.js' ),
			array( 'jquery', 'vendors-js' ),
			INSPIRY_THEME_VERSION,
			true
		);

		$utils_path = array(
			'stylesheet_directory' => get_theme_file_uri( 'common/js/utils.js' ),
		);
		wp_localize_script( 'inspiry-cfos-js', 'inspiryUtilsPath', $utils_path );

		$select_string = array(
			'select_noResult'  => get_option( 'inspiry_select2_no_result_string', esc_html__( 'No Results Found!', 'framework' ), true ),
			'ajax_url'         => admin_url( 'admin-ajax.php' ),
			'page_template'    => get_page_template_slug(),
			'searching_string' => esc_html__( 'Searching...', 'framework' ),
			'loadingMore'      => esc_html__( 'Loading more results...', 'framework' ),
		);
		wp_localize_script( 'common-custom', 'localizeSelect', $select_string );

		if ( is_singular( 'property' ) ) {

			$inspiry_agent_form_success_redirect_page = get_option( 'inspiry_agent_form_success_redirect_page' );
			if ( ! empty( $inspiry_agent_form_success_redirect_page ) ) {
				$agentData = array( 'redirectPageUrl' => get_the_permalink( $inspiry_agent_form_success_redirect_page ) );
				wp_localize_script( 'common-custom', 'agentData', $agentData );
			}

			if ( 'enable' === get_option( 'inspiry_similar_properties_frontend_filters', 'disable' ) ) {

				$properties_per_page = get_option( 'theme_number_of_similar_properties' );
				if ( is_page_template( 'templates/property-full-width-layout.php' ) ) {
					$properties_per_page = 3;
				}

				$similarPropertiesData = array(
					'design'            => INSPIRY_DESIGN_VARIATION,
					'propertyId'        => get_the_ID(),
					'propertiesPerPage' => $properties_per_page,

				);

				wp_localize_script( 'common-custom', 'similarPropertiesData', $similarPropertiesData );
			}
		}

		wp_enqueue_script( 'realhomes-locations' );
		wp_enqueue_script( 'common-custom' );
		wp_enqueue_script( 'inspiry-cfos-js' );
	}
}

/**
 * Dynamic CSS
 */
if ( file_exists( INSPIRY_THEME_DIR . '/styles/css/dynamic-css.php' ) ) {
	include_once( INSPIRY_THEME_DIR . '/styles/css/dynamic-css.php' );
}

/**
 * Common Dynamic CSS
 */
if ( file_exists( INSPIRY_COMMON_DIR . '/css/dynamic-css.php' ) ) {
	include_once( INSPIRY_COMMON_DIR . '/css/dynamic-css.php' );
}

if ( ! function_exists( 'realhomes_css_vars' ) ) {
	/**
	 * Provides RealHomes design variations css variables.
	 *
	 * @param $custom_css
	 *
	 * @return string
	 * @since 3.14.0
	 *
	 */
	function realhomes_css_vars( $custom_css ) {
		// Modern variation color settings.
		$rh_global_color_primary   = get_option( 'theme_core_mod_color_green', '#1ea69a' );
		$rh_global_color_secondary = get_option( 'theme_core_mod_color_orange', '#ea723d' );

		$output = sprintf( '--rh-global-color-primary: %s;', $rh_global_color_primary );
		$output .= sprintf( '--rh-global-color-primary-dark: %s;', get_option( 'theme_core_mod_color_green_dark', '#0b8278' ) );
		$output .= sprintf( '--rh-global-color-primary-rgb: %s;', inspiry_hex_to_rgba( $rh_global_color_primary, false, true ) );
		$output .= sprintf( '--rh-global-color-secondary: %s;', $rh_global_color_secondary );
		$output .= sprintf( '--rh-global-color-secondary-dark: %s;', get_option( 'theme_core_mod_color_orange_dark', '#ea5819' ) );
		$output .= sprintf( '--rh-global-color-secondary-rgb: %s;', inspiry_hex_to_rgba( $rh_global_color_secondary, false, true ) );
		$output .= sprintf( '--rh-global-color-text: %s;', get_option( 'inspiry_body_font_color', '#808080' ) );
		$output .= sprintf( '--rh-global-color-headings: %s;', get_option( 'inspiry_heading_font_color', '#1a1a1a' ) );
		$output .= sprintf( '--rh-global-color-headings-hover: %s;', get_option( 'realhomes_global_headings_hover_color', '#ea723d' ) );
		$output .= sprintf( '--rh-global-color-link: %s;', get_option( 'realhomes_global_link_color', '#444' ) );
		$output .= sprintf( '--rh-global-color-link-hover: %s;', get_option( 'realhomes_global_link_hover_color', '#ea723d' ) );

		// CSS variables to hold round corners values for modern design variation.
		if ( 'modern' === INSPIRY_DESIGN_VARIATION && ( 'enable' === get_option( 'realhomes_round_corners', 'disable' ) ) ) {
			$output .= sprintf( '--rh-small-border-radius: %spx;', get_option( 'realhomes_round_corners_small', '4' ) );
			$output .= sprintf( '--rh-medium-border-radius: %spx;', get_option( 'realhomes_round_corners_medium', '8' ) );
			$output .= sprintf( '--rh-large-border-radius: %spx;', get_option( 'realhomes_round_corners_large', '12' ) );
		}

		if ( 'classic' === INSPIRY_DESIGN_VARIATION ) {
			// CSS variables for classic design variation.
			$output .= sprintf( '--realhomes-core-color-orange-light: %s;', get_option( 'theme_core_color_orange_light', '#ec894d' ) );
			$output .= sprintf( '--realhomes-core-color-orange-dark: %s;', get_option( 'theme_core_color_orange_dark', '#dc7d44' ) );
			$output .= sprintf( '--realhomes-core-color-orange-glow: %s;', get_option( 'theme_core_color_orange_glow', '#e3712c' ) );
			$output .= sprintf( '--realhomes-core-color-orange-burnt: %s;', get_option( 'theme_core_color_orange_burnt', '#df5400' ) );
			$output .= sprintf( '--realhomes-core-color-blue-light: %s;', get_option( 'theme_core_color_blue_light', '#4dc7ec' ) );
			$output .= sprintf( '--realhomes-core-color-blue-dark: %s;', get_option( 'theme_core_color_blue_dark', '#37b3d9' ) );
		}

		$custom_css .= sprintf( ":root{%s}", $output );

		return $custom_css;
	}

	add_filter( 'realhomes_common_custom_css', 'realhomes_css_vars' );
}

if ( ! function_exists( 'realhomes_buttons_transition_style' ) ) {
	/**
	 * Adds the buttons transition style.
	 *
	 * @param $custom_css
	 *
	 * @return string
	 * @since 3.17.0
	 */
	function realhomes_buttons_transition_style( $custom_css ) {

		if ( 'modern' !== INSPIRY_DESIGN_VARIATION ) {
			return $custom_css;
		}

		$buttons_transition_style = get_option( 'inspiry_buttons_transition_style', 'default' );
		if ( 'default' === $buttons_transition_style ) {
			return $custom_css;
		}

		$output = '';

        // Common css that all buttons will share is written in this block. Then every block has its own specific styles under its condition block.
		if ( in_array( $buttons_transition_style, array( 'style_1', 'style_2', 'style_3', 'style_4', 'style_5' ) ) ) {
			$output = "
.rh-btn-primary,
.rh-btn-secondary,
.rhea-btn-primary,
.rhea-btn-secondary {
  position: relative;
  z-index: 1;
  overflow: hidden;
}
.rh-btn-primary:before,
.rh-btn-secondary:before,
.rhea-btn-primary:before,
.rhea-btn-secondary:before {
  display: block;
  content: '';
  position: absolute;
  z-index: -1;
  transition: all 0.3s ease-in-out;
}
.rh-btn-primary:hover:before,
.rh-btn-secondary:hover:before,
.rhea-btn-primary:hover:before,
.rhea-btn-secondary:hover:before {
  transition: all 0.3s ease-in-out;
}
.rh-btn-primary,
.rh-btn-primary:hover,
.rhea-btn-primary,
.rhea-btn-primary:hover {
  background: var(--rh-global-color-primary);
  color: #fff;
}
.rh-btn-primary:before, 
.rhea-btn-primary:before{
  background: var(--rh-global-color-primary-dark, rgba(0, 0, 0, .2));
}
.rh-btn-secondary,
.rh-btn-secondary:hover,
.rhea-btn-secondary,
.rhea-btn-secondary:hover {
  background: var(--rh-global-color-secondary);
  color: #fff;
}
.rh-btn-secondary:before,
.rhea-btn-secondary:before {
  background: var(--rh-global-color-secondary-dark, rgba(0, 0, 0, .2));
}
";

			if ( 'style_1' === $buttons_transition_style ) {
				$output .= "
.rh-btn-primary:before,
.rh-btn-secondary:before,
.rhea-btn-primary:before,
.rhea-btn-secondary:before {
  top: 0;
  right: 0;
  width: 0;
  height: 100%;
}
.rh-btn-primary:hover:before,
.rh-btn-secondary:hover:before,
.rhea-btn-primary:hover:before,
.rhea-btn-secondary:hover:before {
  right: auto;
  left: 0;
  width: 100%;
}
";
			} elseif ( 'style_2' === $buttons_transition_style ) {
				$output .= "
.rh-btn-primary:before,
.rh-btn-secondary:before,
.rhea-btn-primary:before,
.rhea-btn-secondary:before {
  top: 0;
  left: 0;
  width: 0;
  height: 100%;
}
.rh-btn-primary:hover:before,
.rh-btn-secondary:hover:before,
.rhea-btn-primary:hover:before,
.rhea-btn-secondary:hover:before {
  left: auto;
  right: 0;
  width: 100%;
}
";
			} elseif ( 'style_3' === $buttons_transition_style ) {
				$output .= "
.rh-btn-primary:before,
.rh-btn-secondary:before,
.rhea-btn-primary:before,
.rhea-btn-secondary:before {
  top: 0;
  left: 0;
  width: 100%;
  height: 0;
}
.rh-btn-primary:hover:before,
.rh-btn-secondary:hover:before,
.rhea-btn-primary:hover:before,
.rhea-btn-secondary:hover:before {
  top: auto;
  bottom: 0;
  height: 100%;
}
";
			} elseif ( 'style_4' === $buttons_transition_style ) {
				$output .= "
.rh-btn-primary:before,
.rh-btn-secondary:before,
.rhea-btn-primary:before,
.rhea-btn-secondary:before {
  bottom: 0;
  left: 0;
  width: 100%;
  height: 0;
}

.rh-btn-primary:hover:before,
.rh-btn-secondary:hover:before,
.rhea-btn-primary:hover:before,
.rhea-btn-secondary:hover:before {
  top: 0;
  bottom: auto;
  height: 100%;
}
";
			} elseif ( 'style_5' === $buttons_transition_style ) {
				$output .= "
.rh-btn-primary:before,
.rh-btn-secondary:before,
.rhea-btn-primary:before,
.rhea-btn-secondary:before {
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  width: 0;
  height: 0;
  margin: auto;
}
.rh-btn-primary:hover:before,
.rh-btn-secondary:hover:before,
.rhea-btn-primary:hover:before,
.rhea-btn-secondary:hover:before {
  width: 100%;
  height: 100%;
}
";
			}
		}

		$custom_css .= sprintf( "%s", $output );

		return $custom_css;
	}

	add_filter( 'realhomes_common_custom_css', 'realhomes_buttons_transition_style' );
}