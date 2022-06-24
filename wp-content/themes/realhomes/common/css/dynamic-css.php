<?php
/**
 * Dynamic CSS File
 *
 * Dynamic css file for handling user options.
 *
 * @since    3.0.0
 * @package realhomes/common
 */
if ( ! function_exists( 'inspiry_generate_common_dynamic_css' ) ) {
	/**
	 * Function: Generate Dynamic CSS.
	 *
	 * @since 3.0.0
	 */
	function inspiry_generate_common_dynamic_css( $realhomes_common_custom_css ) {

		$theme_currency_switcher_background                = get_option( 'theme_currency_switcher_background' );
		$theme_currency_switcher_selected_text             = get_option( 'theme_currency_switcher_selected_text' );
		$theme_currency_switcher_background_open           = get_option( 'theme_currency_switcher_background_open' );
		$theme_currency_switcher_text_open                 = get_option( 'theme_currency_switcher_text_open' );
		$theme_currency_switcher_background_dropdown       = get_option( 'theme_currency_switcher_background_dropdown' );
		$theme_currency_switcher_text_dropdown             = get_option( 'theme_currency_switcher_text_dropdown' );
		$theme_currency_switcher_background_hover_dropdown = get_option( 'theme_currency_switcher_background_hover_dropdown' );
		$theme_currency_switcher_text_hover_dropdown       = get_option( 'theme_currency_switcher_text_hover_dropdown' );


		$theme_language_switcher_background                = get_option( 'theme_language_switcher_background' );
		$theme_language_switcher_selected_text             = get_option( 'theme_language_switcher_selected_text' );
		$theme_language_switcher_background_open           = get_option( 'theme_language_switcher_background_open' );
		$theme_language_switcher_text_open                 = get_option( 'theme_language_switcher_text_open' );
		$theme_language_switcher_background_dropdown       = get_option( 'theme_language_switcher_background_dropdown' );
		$theme_language_switcher_text_dropdown             = get_option( 'theme_language_switcher_text_dropdown' );
		$theme_language_switcher_background_hover_dropdown = get_option( 'theme_language_switcher_background_hover_dropdown' );
		$theme_language_switcher_text_hover_dropdown       = get_option( 'theme_language_switcher_text_hover_dropdown' );


		$theme_compare_switcher_background             = get_option( 'theme_compare_switcher_background' );
		$theme_compare_switcher_selected_text          = get_option( 'theme_compare_switcher_selected_text' );
		$theme_compare_switcher_background_open        = get_option( 'theme_compare_switcher_background_open' );
		$theme_compare_switcher_text_open              = get_option( 'theme_compare_switcher_text_open' );
		$theme_compare_view_background                 = get_option( 'theme_compare_view_background' );
		$theme_compare_view_title_color                = get_option( 'theme_compare_view_title_color' );
		$theme_compare_view_property_title_color       = get_option( 'theme_compare_view_property_title_color' );
		$theme_compare_view_property_title_hover_color = get_option( 'theme_compare_view_property_title_hover_color' );
		$theme_compare_view_property_button_background = get_option( 'theme_compare_view_property_button_background' );
		$theme_compare_view_property_button_text       = get_option( 'theme_compare_view_property_button_text' );
		$theme_compare_view_property_button_hover      = get_option( 'theme_compare_view_property_button_hover' );
		$theme_compare_view_property_button_text_hover = get_option( 'theme_compare_view_property_button_text_hover' );

		$theme_floating_responsive_background = get_option( 'theme_floating_responsive_background' );
		$inspiry_floating_position            = get_option( 'inspiry_floating_position' );


		$styles = array(

			array(
				'elements' => '#currency-switcher-form',
				'property' => 'background',
				'value'    => $theme_currency_switcher_background,
			),

			array(
				'elements' => '#currency-switcher #selected-currency',
				'property' => 'color',
				'value'    => $theme_currency_switcher_selected_text,
			),


			array(
				'elements' => '#currency-switcher.open #selected-currency',
				'property' => 'background',
				'value'    => $theme_currency_switcher_background_open,
			),

			array(
				'elements' => '.rh_currency_open_full #currency-switcher #selected-currency:hover',
				'property' => 'background',
				'value'    => $theme_currency_switcher_background_open,
			),


			array(
				'elements' => '.rh_currency_open_full #currency-switcher #selected-currency:hover',
				'property' => 'color',
				'value'    => $theme_currency_switcher_text_open,
			),


			array(
				'elements' => '#currency-switcher.open #selected-currency',
				'property' => 'color',
				'value'    => $theme_currency_switcher_text_open,
			),


			array(
				'elements' => '#currency-switcher-list li',
				'property' => 'background',
				'value'    => $theme_currency_switcher_background_dropdown,
			),


			array(
				'elements' => '#currency-switcher-list li',
				'property' => 'color',
				'value'    => $theme_currency_switcher_text_dropdown,
			),


			array(
				'elements' => '#currency-switcher-list li:hover',
				'property' => 'background',
				'value'    => $theme_currency_switcher_background_hover_dropdown,
			),

			array(
				'elements' => '#currency-switcher-list li:hover',
				'property' => 'color',
				'value'    => $theme_currency_switcher_text_hover_dropdown,
			),

			array(
				'elements' => '#currency-switcher ::-webkit-scrollbar',
				'property' => 'background-color',
				'value'    => $theme_currency_switcher_background_dropdown,
			),

			array(
				'elements' => '#currency-switcher ::-webkit-scrollbar-thumb',
				'property' => 'background-color',
				'value'    => $theme_currency_switcher_background_hover_dropdown,
			),


			array(
				'elements' => '.inspiry-language-switcher',
				'property' => 'background',
				'value'    => $theme_language_switcher_background,
			),


			array(
				'elements' => '.inspiry-language-switcher .inspiry-language.current',
				'property' => 'color',
				'value'    => $theme_language_switcher_selected_text,
			),


			array(
				'elements' => '.inspiry-language-switcher > ul > li.open',
				'property' => 'background',
				'value'    => $theme_language_switcher_background_open,
			),

			array(
				'elements' => '.rh_language_open_full .inspiry-language-switcher .inspiry-language.current:hover',
				'property' => 'background',
				'value'    => $theme_language_switcher_background_open,
			),
			array(
				'elements' => '.rh_language_open_full .inspiry-language-switcher .inspiry-language.current:hover:after,
								.rh_language_open_full .inspiry-language-switcher .inspiry-language.current:hover > span',
				'property' => 'color',
				'value'    => $theme_language_switcher_text_open,
			),


			array(
				'elements' => '.inspiry-language-switcher > ul > li.open span',
				'property' => 'color',
				'value'    => $theme_language_switcher_text_open,
			),


			array(
				'elements' => '.inspiry-language-switcher > ul > li > ul',
				'property' => 'background',
				'value'    => $theme_language_switcher_background_dropdown,
			),


			array(
				'elements' => '.inspiry-language-switcher li .rh_languages_available li a span',
				'property' => 'color',
				'value'    => $theme_language_switcher_text_dropdown,
			),


			array(
				'elements' => '.inspiry-language-switcher li a:hover',
				'property' => 'background',
				'value'    => $theme_language_switcher_background_hover_dropdown,
			),

			array(
				'elements' => '.inspiry-language-switcher li .rh_languages_available li a:hover span',
				'property' => 'color',
				'value'    => $theme_language_switcher_text_hover_dropdown,
			),

			array(
				'elements' => '.rh_wrapper_language_switcher parent_open ::-webkit-scrollbar',
				'property' => 'background-color',
				'value'    => $theme_language_switcher_background_dropdown,
			),

			array(
				'elements' => '.rh_wrapper_language_switcher parent_open ::-webkit-scrollbar-thumb',
				'property' => 'background-color',
				'value'    => $theme_language_switcher_background_hover_dropdown,
			),


			array(
				'elements' => '.rh_floating_compare_button',
				'property' => 'background',
				'value'    => $theme_compare_switcher_background,
			),

			array(
				'elements' => '.rh_floating_compare_button',
				'property' => 'color',
				'value'    => $theme_compare_switcher_selected_text,
			),


			array(
				'elements' => '.rh_floating_compare_button svg',
				'property' => 'fill',
				'value'    => $theme_compare_switcher_selected_text,
			),


			array(
				'elements' => '.rh_compare_open .rh_floating_compare_button',
				'property' => 'background',
				'value'    => $theme_compare_switcher_background_open,
			),

			array(
				'elements' => '.rh_floating_compare_button:hover',
				'property' => 'background',
				'value'    => $theme_compare_switcher_background_open,
			),


			array(
				'elements' => '.rh_floating_compare_button:hover',
				'property' => 'color',
				'value'    => $theme_compare_switcher_text_open,
			),

			array(
				'elements' => '.rh_floating_compare_button:hover svg',
				'property' => 'fill',
				'value'    => $theme_compare_switcher_text_open,
			),


			array(
				'elements' => '.rh_compare_open .rh_floating_compare_button',
				'property' => 'color',
				'value'    => $theme_compare_switcher_text_open,
			),
			array(
				'elements' => '.rh_compare_open .rh_floating_compare_button svg',
				'property' => 'fill',
				'value'    => $theme_compare_switcher_text_open,
			),

			array(
				'elements' => '.rh_compare',
				'property' => 'background',
				'value'    => $theme_compare_view_background,
			),

			array(
				'elements' => '.rh_compare .title',
				'property' => 'color',
				'value'    => $theme_compare_view_title_color,
			),
			array(
				'elements' => '.rh_compare__slide_img .rh_compare_view_title',
				'property' => 'color',
				'value'    => $theme_compare_view_property_title_color,
			),

			array(
				'elements' => '.rh_compare__slide_img .rh_compare_view_title:hover,
								.rh_floating_classic .rh_compare__slide_img .rh_compare_view_title:hover',
				'property' => 'color',
				'value'    => $theme_compare_view_property_title_hover_color,
			),

			array(
				'elements' => '.rh_fixed_side_bar_compare .rh_compare__submit',
				'property' => 'background',
				'value'    => $theme_compare_view_property_button_background,
			),

			array(
				'elements' => '.rh_fixed_side_bar_compare .rh_compare__submit',
				'property' => 'color',
				'value'    => $theme_compare_view_property_button_text,
			),
			array(
				'elements' => '.rh_fixed_side_bar_compare .rh_compare__submit:hover',
				'property' => 'background',
				'value'    => $theme_compare_view_property_button_hover,
			),
			array(
				'elements' => '.rh_fixed_side_bar_compare .rh_compare__submit:hover',
				'property' => 'color',
				'value'    => $theme_compare_view_property_button_text_hover,
			),


		);

		$prop_count_cta = count( $styles );

		if ( $prop_count_cta > 0 ) {
			foreach ( $styles as $css_unit ) {
				if ( ! empty( $css_unit['value'] ) ) {
					$realhomes_common_custom_css .= strip_tags( $css_unit['elements'] . " { " . $css_unit['property'] . " : " . $css_unit['value'] . ";" . " }\n" );
				}
			}
		}

		$styles_min_891   = array();
		if ( ! empty( $inspiry_floating_position ) ) {
			$styles_min_891[] = array(
				'elements' => '.rh_wrapper_floating_features',
				'property' => 'top',
				'value'    => $inspiry_floating_position,
			);
		}

		if ( ! empty( $styles_min_891 ) ) {
			$realhomes_common_custom_css .= "@media ( min-width: 891px ) {\n";
			foreach ( $styles_min_891 as $css_unit ) {
				if ( ! empty( $css_unit['value'] ) ) {
					$realhomes_common_custom_css .= strip_tags( $css_unit['elements'] . " { " . $css_unit['property'] . " : " . $css_unit['value'] . ";" . " }\n" );
				}
			}
			$realhomes_common_custom_css .= "}\n";
		}

		$styles_max_890 = array();
		if ( ! empty( $theme_floating_responsive_background ) ) {
			$styles_max_890[] = array(
				'elements' => '.rh_wrapper_floating_features',
				'property' => 'background',
				'value'    => $theme_floating_responsive_background,
			);
		}

		if ( ! empty( $styles_max_890 ) ) {
			$realhomes_common_custom_css .= "@media ( max-width: 890px ) {\n";
			foreach ( $styles_max_890 as $css_unit ) {
				if ( ! empty( $css_unit['value'] ) ) {
					$realhomes_common_custom_css .= strip_tags( $css_unit['elements'] . " { " . $css_unit['property'] . " : " . $css_unit['value'] . ";" . " }\n" );
				}
			}
			$realhomes_common_custom_css .= "}\n";
		}

		$inspiry_logo_filter_for_print = get_option( 'inspiry_logo_filter_for_print', 'none' );
		if ( 'none' !== $inspiry_logo_filter_for_print ) {
			$realhomes_common_custom_css .= '@media print { #logo img, .rh_logo img {';
            $realhomes_common_custom_css .= '-webkit-filter: ' . esc_html( $inspiry_logo_filter_for_print ) . '(100%);';
            $realhomes_common_custom_css .= 'filter: ' . esc_html( $inspiry_logo_filter_for_print ) . '(100%); }}';
		}

		return $realhomes_common_custom_css;
	}
}
add_filter( 'realhomes_common_custom_css', 'inspiry_generate_common_dynamic_css' );

if ( ! function_exists( 'output_quick_css' ) ) {
	/**
	 * Output Quick CSS Fix
	 */
	function output_quick_css( $realhomes_common_custom_css ) {
		// Quick CSS from Theme Options
		$quick_css = stripslashes( get_option( 'theme_quick_css' ) );
		if ( ! empty( $quick_css ) ) {
			$realhomes_common_custom_css .= "\n";
			$realhomes_common_custom_css .= strip_tags( $quick_css );
		}

		return $realhomes_common_custom_css;
	}
}
add_filter( 'realhomes_common_custom_css', 'output_quick_css' );

if ( ! function_exists( 'inspiry_property_features_icons_css' ) ) {
	/**
	 * Generate CSS Style for property features icons.
	 *
	 * @since 3.10
	 */
	function inspiry_property_features_icons_css( $realhomes_common_custom_css ) {
		if ( ! is_singular( 'property' ) ) {
			return $realhomes_common_custom_css;
		}

		$features_terms = get_the_terms( get_the_ID(), 'property-feature' );
		if ( empty( $features_terms ) ) {
			return $realhomes_common_custom_css;
		}

		$css = '';

		foreach ( $features_terms as $feature_term ) {
			$term_id         = $feature_term->term_id;
			$feature_icon_id = get_term_meta( $feature_term->term_id, 'inspiry_property_feature_icon', true );
			$feature_icon    = ! empty( $feature_icon_id ) ? wp_get_attachment_url( $feature_icon_id ) : false;

			if ( empty( $feature_icon ) ) {
				continue;
			}

			if ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
				$css .= "
						.rh_property__features_wrap #rh_property__feature_{$term_id} .rh_done_icon{
							display: none;
						}
						
						.rh_property__features_wrap #rh_property__feature_{$term_id}:before{
						    content: '';
							position: relative;
							display: block;
							width: 14px;
							height: 14px;
							background: url('{$feature_icon}') no-repeat;
							background-size: 14px;
						";
				$css .= is_rtl() ? "margin: 0 -20px 0 5px;" : "margin: 0 5px 0 -20px;";
				$css .= "}\n";
			} else {
				$css .= "
						#overview .property-item .features #rh_property__feature_{$term_id}:before{
							background: url('{$feature_icon}') no-repeat center center;
							background-size: 20px;
						}
						";
			}
		}

		$realhomes_common_custom_css .= $css;

		return $realhomes_common_custom_css;
	}
}
add_filter( 'realhomes_common_custom_css', 'inspiry_property_features_icons_css' );