<?php
/**
 * Dynamic CSS File
 *
 * Dynamic css file for handling user options.
 *
 * @since   3.0.0
 * @package realhomes/modern
 */
if ( ! function_exists( 'inspiry_generate_dynamic_css' ) ) {
	/**
	 * Function: Generate Dynamic CSS.
	 *
	 * @param $realhomes_modern_custom_css
	 *
	 * @return string
	 * @since 3.0.0
	 *
	 */
	function inspiry_generate_dynamic_css( $realhomes_modern_custom_css ) {

		$is_rtl = is_rtl();

		//  CTA section image styles
		$inspiry_home_cta_contact_bg_image = get_post_meta( get_the_ID(), 'inspiry_home_cta_contact_bg_image', true );
		$inspiry_cta_background_image      = get_post_meta( get_the_ID(), 'inspiry_cta_background_image', true );

		if ( ! empty( $inspiry_home_cta_contact_bg_image ) ) {
			$inspiry_home_cta_contact_bg_image = wp_get_attachment_url( $inspiry_home_cta_contact_bg_image );
		}

		if ( ! empty( $inspiry_cta_background_image ) ) {
			$inspiry_cta_background_image = wp_get_attachment_url( $inspiry_cta_background_image );
		}

		$cta_styles = array();

		if ( ! empty( $inspiry_home_cta_contact_bg_image ) ) {
			$cta_styles[] = array(
				'elements' => '.rh_cta--contact .rh_cta',
				'property' => 'background-image',
				'value'    => 'url("' . $inspiry_home_cta_contact_bg_image . '")',
			);
		}

		if ( ! empty( $inspiry_cta_background_image ) ) {
			$cta_styles[] = array(
				'elements' => '.rh_cta--featured .rh_cta',
				'property' => 'background-image',
				'value'    => 'url("' . $inspiry_cta_background_image . '")',
			);
		}

		$prop_count_cta = count( $cta_styles );
		if ( $prop_count_cta > 0 ) {
			foreach ( $cta_styles as $css_unit ) {
				if ( ! empty( $css_unit['value'] ) ) {
					$realhomes_modern_custom_css .= strip_tags( $css_unit['elements'] . " { " . $css_unit['property'] . " : " . $css_unit['value'] . ";" . " }\n" );
				}
			}
		}

		// Scroll to top position
		$inspiry_stp_position_from_bottom = get_option( 'inspiry_stp_position_from_bottom', '40px' );
		$stp_bottom_position              = array();
		if ( ! empty( $inspiry_stp_position_from_bottom ) ) {
			$stp_bottom_position[] = array(
				'elements' => '#scroll-top',
				'property' => 'bottom',
				'value'    => $inspiry_stp_position_from_bottom,
			);
		}
		$stp_count = count( $stp_bottom_position );
		if ( $stp_count > 0 ) {
			foreach ( $stp_bottom_position as $css_unit ) {
				if ( ! empty( $css_unit['value'] ) ) {
					$realhomes_modern_custom_css .= strip_tags( $css_unit['elements'] . " { " . $css_unit['property'] . " : " . $css_unit['value'] . ";" . " }\n" );
				}
			}
		}

		$dynamic_font_css = array();

		// Base Font
		$body_font = get_option( 'inspiry_body_font', 'Default' );
		if ( 'Default' !== $body_font ) {
			$body_font_selectors = '
			 body,
			 .rh_theme_card__priceLabel_sty span.rh_theme_card__status_sty, 
			 .rh_theme_card__priceLabel_sty .rh_theme_card__price_sty, 
			 .rh_my-property .rh_my-property__btns .stripe-button-el span
			 ';

			$dynamic_font_css[] = array(
				'elements' => $body_font_selectors,
				'property' => 'font-family',
				'value'    => Inspiry_Google_Fonts::get_font_family( $body_font ),
			);

			$body_font_weight = get_option( 'inspiry_body_font_weight', 'Default' );
			if ( 'Default' !== $body_font_weight ) {
				$dynamic_font_css[] = array(
					'elements' => $body_font_selectors,
					'property' => 'font-weight',
					'value'    => $body_font_weight,
				);
			}
		}

		// Headings Font
		$headings_font = get_option( 'inspiry_heading_font', 'Default' );
		if ( 'Default' !== $headings_font ) {
			$heading_font_selectors = 'h1, h2, h3, h4, h5, h6';

			$dynamic_font_css[] = array(
				'elements' => $heading_font_selectors,
				'property' => 'font-family',
				'value'    => Inspiry_Google_Fonts::get_font_family( $headings_font )
			);

			$headings_font_weight = get_option( 'inspiry_heading_font_weight', 'Default' );
			if ( 'Default' !== $headings_font_weight ) {
				$dynamic_font_css[] = array(
					'elements' => $heading_font_selectors,
					'property' => 'font-weight',
					'value'    => $headings_font_weight,
				);
			}
		}

		// Secondary Font
		$secondary_font = get_option( 'inspiry_secondary_font', 'Default' );
		if ( 'Default' !== $secondary_font ) {
			$secondary_font_selectors = '
			.rh_prop_stylish_card__excerpt p, 
			.rh_prop_stylish_card__excerpt .rh_agent_form .rh_agent_form__row,
			.rh_agent_form .rh_prop_stylish_card__excerpt .rh_agent_form__row
			';

			$dynamic_font_css[] = array(
				'elements' => $secondary_font_selectors,
				'property' => 'font-family',
				'value'    => Inspiry_Google_Fonts::get_font_family( $secondary_font ),
			);

			$secondary_font_weight = get_option( 'inspiry_secondary_font_weight', 'Default' );
			if ( 'Default' !== $secondary_font_weight ) {
				$dynamic_font_css[] = array(
					'elements' => $secondary_font_selectors,
					'property' => 'font-weight',
					'value'    => $secondary_font_weight,
				);
			}
		}

		$dynamic_font_css_count = count( $dynamic_font_css );
		if ( $dynamic_font_css_count > 0 ) {
			foreach ( $dynamic_font_css as $font_unit ) {
				if ( ! empty( $font_unit['value'] ) ) {
					$realhomes_modern_custom_css .= strip_tags( $font_unit['elements'] . " { " . $font_unit['property'] . " : " . $font_unit['value'] . ";" . " }\n" );
				}
			}
		}

		$inspiry_banner_height = get_option( 'inspiry_banner_height' );
		$banner_ind_styles     = array();
		if ( ! empty( $inspiry_banner_height ) ) {
			$banner_ind_styles[] = array(
				'elements' => '.rh_banner,
								.inspiry_mod_header_variation_two.inspiry_mod_search_form_default .rh_banner__image,
								.inspiry_mod_header_variation_three .rh_banner__image',
				'property' => 'height',
				'value'    => $inspiry_banner_height,
			);
		}

		$banner_height_ind_count = count( $banner_ind_styles );
		if ( $banner_height_ind_count > 0 ) {
			foreach ( $banner_ind_styles as $banner_unit ) {
				if ( ! empty( $banner_unit['value'] ) ) {
					$realhomes_modern_custom_css .= strip_tags( $banner_unit['elements'] . " { " . $banner_unit['property'] . " : " . $banner_unit['value'] . ";" . " }\n" );
				}
			}
		}

		// Skip adding dynamic styles for default color scheme option.
		if ( 'default' === get_option( 'realhomes_color_scheme', 'custom' ) ) {
			return $realhomes_modern_custom_css;
		}

		$global_colors_css = array();

		// Heading Color
		$inspiry_heading_font_color = get_option( 'inspiry_heading_font_color' );
		if ( $inspiry_heading_font_color ) {
			$global_colors_css[] = array(
				'elements' => 'h1, h2, h3, h4, h5, h6, .rh_logo .rh_logo__heading a,
							.rh_user .rh_user__details .rh_user__msg,
							.rh_slide__desc h3 .title, .rh_section .rh_section__head .rh_section__subtitle,
							.rh_page__head .rh_page__title .title, .rh_modal .rh_modal__wrap .rh_modal__dashboard .rh_modal__dash_link,
							.rh_page__head .rh_page__title .sub,
							.rh_page__head .rh_page__title .sub, .rh_agent_card__wrap .rh_agent_card__head .rh_agent_card__name .name a,
							body .rh_prop_card__details_elementor h3 a,
							body .rh_section__agents_elementor .rh_agent_elementor .rh_agent__details h3 a,
							body .classic_properties_elementor_wrapper .rhea_property_title a,
							.rh_prop_card .rh_prop_card__details h3 a,
							.property-thumbnail .property-title a',
				'property' => 'color',
				'value'    => $inspiry_heading_font_color,
			);
		}

		$global_colors_css_count = count( $global_colors_css );
		if ( $global_colors_css_count > 0 ) {
			foreach ( $global_colors_css as $font_unit ) {
				if ( ! empty( $font_unit['value'] ) ) {
					$realhomes_modern_custom_css .= strip_tags( $font_unit['elements'] . " { " . $font_unit['property'] . " : " . $font_unit['value'] . ";" . " }\n" );
				}
			}
		}

		$inspiry_SFOI_overlay_opacity   = get_post_meta( get_the_ID(), 'inspiry_SFOI_overlay_opacity', true );
		$inspiry_SFOI_overlay_color     = inspiry_hex2rgb( get_post_meta( get_the_ID(), 'inspiry_SFOI_overlay_color', true ), $inspiry_SFOI_overlay_opacity );
		$inspiry_SFOI_title_color       = get_post_meta( get_the_ID(), 'inspiry_SFOI_title_color', true );
		$inspiry_SFOI_description_color = get_post_meta( get_the_ID(), 'inspiry_SFOI_description_color', true );

		$dynamic_banner_styles = array();

		if ( ! empty( $inspiry_SFOI_overlay_color ) ) {
			$dynamic_banner_styles[] = array(
				'elements' => '.rh_mod_sfoi_overlay',
				'property' => 'background-color',
				'value'    => $inspiry_SFOI_overlay_color,
			);
		}

		if ( ! empty( $inspiry_SFOI_title_color ) ) {
			$dynamic_banner_styles[] = array(
				'elements' => '.rh_mod_sfoi_wrapper h2',
				'property' => 'color',
				'value'    => $inspiry_SFOI_title_color,
			);
		}

		if ( ! empty( $inspiry_SFOI_description_color ) ) {
			$dynamic_banner_styles[] = array(
				'elements' => '.rh_mod_sfoi_wrapper .SFOI__description',
				'property' => 'color',
				'value'    => $inspiry_SFOI_description_color,
			);
		}

		$dynamic_banner_styles_count = count( $dynamic_banner_styles );
		if ( $dynamic_banner_styles_count > 0 ) {
			foreach ( $dynamic_banner_styles as $banner_unit ) {
				if ( ! empty( $banner_unit['value'] ) ) {
					$realhomes_modern_custom_css .= strip_tags( $banner_unit['elements'] . " { " . $banner_unit['property'] . " : " . $banner_unit['value'] . ";" . " }\n" );
				}
			}
		}

		$theme_banner_bg_color           = get_option( 'theme_banner_bg_color' );
		$theme_banner_bg_overlay_color   = get_option( 'theme_banner_bg_overlay_color' );
		$theme_banner_bg_overlay_opacity = get_option( 'theme_banner_bg_overlay_opacity' );
		$theme_banner_text_color         = get_option( 'theme_banner_text_color', '#ffffff' );

		if ( ! empty( $theme_banner_bg_color ) ) {
			$banner_styles[] = array(
				'elements' => 'body .rh_banner',
				'property' => 'background-color',
				'value'    => $theme_banner_bg_color,
			);
		}

		if ( ! empty( $theme_banner_bg_overlay_color ) ) {
			$banner_styles[] = array(
				'elements' => '.rh_banner__cover',
				'property' => 'background',
				'value'    => $theme_banner_bg_overlay_color,
			);
		}

		if ( ! empty( $theme_banner_bg_overlay_opacity ) ) {
			$banner_styles[] = array(
				'elements' => '.rh_banner__cover',
				'property' => 'opacity',
				'value'    => $theme_banner_bg_overlay_opacity,
			);
		}

		$banner_styles[] = array(
			'elements' => '.rh_banner .rh_banner__title',
			'property' => 'color',
			'value'    => $theme_banner_text_color,
		);

		$banner_styles_count = count( $banner_styles );

		if ( $banner_styles_count > 0 ) {
			foreach ( $banner_styles as $banner_unit ) {
				if ( ! empty( $banner_unit['value'] ) ) {
					$realhomes_modern_custom_css .= strip_tags( $banner_unit['elements'] . " { " . $banner_unit['property'] . " : " . $banner_unit['value'] . ";" . " }\n" );
				}
			}
		}

		$body_bg = get_background_color();

		// Core
		$core_orange_color     = get_option( 'theme_core_mod_color_orange' );
		$core_green_color      = get_option( 'theme_core_mod_color_green' );
		$core_green_dark_color = get_option( 'theme_core_mod_color_green_dark' );
		$selection_bg_color    = get_option( 'realhomes_selection_bg_color', '#1ea69a');

		// Header.
		$theme_header_bg_color             = get_option( 'theme_header_bg_color' );
		$theme_header_menu_top_color       = get_option( 'theme_header_menu_top_color' );
		$theme_header_meta_bg_color        = get_option( 'theme_header_meta_bg_color' );
		$theme_main_menu_text_color        = get_option( 'theme_main_menu_text_color' );
		$theme_main_menu_text_hover_color  = get_option( 'theme_main_menu_text_hover_color' );
		$inspiry_top_menu_gradient_color   = get_option( 'inspiry_top_menu_gradient_color' );

		$inspiry_main_menu_hover_bg           = get_option( 'inspiry_main_menu_hover_bg' );
		$theme_menu_bg_color                  = get_option( 'theme_menu_bg_color', '#fff' );
		$theme_menu_text_color                = get_option( 'theme_menu_text_color', '#808080' );
		$theme_menu_hover_bg_color            = get_option( 'theme_menu_hover_bg_color' );
		$theme_menu_hover_text_color          = get_option( 'theme_menu_hover_text_color' );
		$theme_phone_text_color               = get_option( 'theme_phone_text_color', '#ffffff' );
		$theme_phone_text_color_hover         = get_option( 'theme_phone_text_color_hover', '#ffffff' );
		$theme_header_social_icon_color       = get_option( 'theme_header_social_icon_color' );
		$theme_header_social_icon_color_hover = get_option( 'theme_header_social_icon_color_hover' );

		// sticky Header
		$theme_modern_sticky_header_bg_color               = get_option( 'theme_modern_sticky_header_bg_color' );
		$theme_modern_sticky_header_menu_color             = get_option( 'theme_modern_sticky_header_menu_color' );
		$theme_modern_sticky_header_menu_hover_color       = get_option( 'theme_modern_sticky_header_menu_hover_color' );
		$theme_modern_sticky_header_menu_text_hover_color  = get_option( 'theme_modern_sticky_header_menu_text_hover_color' );
		$theme_modern_sticky_header_btn_color              = get_option( 'theme_modern_sticky_header_btn_color' );
		$theme_modern_sticky_header_btn_hover_color        = get_option( 'theme_modern_sticky_header_btn_hover_color' );
		$theme_modern_sticky_header_btn_text_color         = get_option( 'theme_modern_sticky_header_btn_text_color' );
		$theme_modern_sticky_header_btn_hover_text_color   = get_option( 'theme_modern_sticky_header_btn_hover_text_color' );
		$theme_modern_sticky_header_site_title_color       = get_option( 'theme_modern_sticky_header_site_title_color' );
		$theme_modern_sticky_header_site_title_hover_color = get_option( 'theme_modern_sticky_header_site_title_hover_color' );

		// Logo.
		$theme_logo_text_color       = get_option( 'theme_logo_text_color', '#fff' );
		$theme_logo_text_hover_color = get_option( 'theme_logo_text_hover_color', '#1ea69a' );

		// Home Sections.
		$inspiry_home_properties_title_span_color     = get_option( 'inspiry_home_properties_title_span_color' );
		$inspiry_home_properties_title_color          = get_option( 'inspiry_home_properties_title_color' );
		$inspiry_home_properties_desc_color           = get_option( 'inspiry_home_properties_desc_color' );
		$inspiry_home_properties_bg_color             = get_option( 'inspiry_home_properties_background_color' );
		$theme_featured_prop_title_span_color         = get_option( 'theme_featured_prop_title_span_color' );
		$theme_featured_prop_title_color              = get_option( 'theme_featured_prop_title_color' );
		$theme_featured_prop_text_color               = get_option( 'theme_featured_prop_text_color' );
		$inspiry_featured_properties_background_color = get_option( 'inspiry_featured_properties_background_color' );
		$inspiry_home_agents_title_span_color         = get_option( 'inspiry_home_agents_title_span_color' );
		$inspiry_home_agents_title_color              = get_option( 'inspiry_home_agents_title_color' );
		$inspiry_home_agents_desc_color               = get_option( 'inspiry_home_agents_desc_color' );
		$inspiry_home_agents_bg_color                 = get_option( 'inspiry_agents_background_color' );

		// Home Testimonial.
		$inspiry_testimonial_bg         = get_option( 'inspiry_testimonial_bg' );
		$inspiry_testimonial_bg_quote   = get_option( 'inspiry_testimonial_bg_quote' );
		$inspiry_testimonial_color      = get_option( 'inspiry_testimonial_color' );
		$inspiry_testimonial_name_color = get_option( 'inspiry_testimonial_name_color' );
		$inspiry_testimonial_url_color  = get_option( 'inspiry_testimonial_url_color' );

		// Home CTA BG.
		$inspiry_cta_title_color      = get_option( 'inspiry_cta_title_color' );
		$inspiry_cta_desc_color       = get_option( 'inspiry_cta_desc_color' );
		$inspiry_cta_btn_one_color    = get_option( 'inspiry_cta_btn_one_color' );
		$inspiry_cta_btn_one_bg       = get_option( 'inspiry_cta_btn_one_bg' );
		$inspiry_cta_btn_one_hover_bg = inspiry_hex_to_rgba( $inspiry_cta_btn_one_bg, 0.8 );
		$inspiry_cta_btn_two_color    = get_option( 'inspiry_cta_btn_two_color' );
		$inspiry_cta_btn_two_bg       = get_option( 'inspiry_cta_btn_two_bg', '#ffffff' );
		$inspiry_cta_btn_two_bg_rgba  = inspiry_hex_to_rgba( $inspiry_cta_btn_two_bg, 0.25 );
		$inspiry_cta_btn_two_hover_bg = inspiry_hex_to_rgba( $inspiry_cta_btn_two_bg, 0.4 );

		// Home CTA Contact BG.
		$inspiry_cta_contact_title_color      = get_option( 'inspiry_cta_contact_title_color' );
		$inspiry_cta_contact_desc_color       = get_option( 'inspiry_cta_contact_desc_color' );
		$inspiry_home_cta_bg_color            = get_option( 'inspiry_home_cta_bg_color' );
		$inspiry_home_cta_bg_color            = inspiry_hex_to_rgba( $inspiry_home_cta_bg_color, 0.8 );
		$inspiry_cta_contact_btn_one_color    = get_option( 'inspiry_cta_contact_btn_one_color' );
		$inspiry_cta_contact_btn_one_bg       = get_option( 'inspiry_cta_contact_btn_one_bg', '#303030' );
		$inspiry_cta_contact_btn_one_hover_bg = inspiry_hex_to_rgba( $inspiry_cta_contact_btn_one_bg, 0.8 );
		$inspiry_cta_contact_btn_two_color    = get_option( 'inspiry_cta_contact_btn_two_color' );
		$inspiry_cta_contact_btn_two_bg       = get_option( 'inspiry_cta_contact_btn_two_bg', '#ffffff' );
		$inspiry_cta_contact_btn_two_hover_bg = inspiry_hex_to_rgba( $inspiry_cta_contact_btn_two_bg, 0.8 );

		// Home Agents.
		$inspiry_agents_title_color        = get_option( 'inspiry_agents_title_color' );
		$inspiry_agents_title_hover_color  = get_option( 'inspiry_agents_title_hover_color' );
		$inspiry_agents_text_color         = get_option( 'inspiry_agents_text_color' );
		$inspiry_agents_phone_color        = get_option( 'inspiry_agents_phone_color' );
		$inspiry_agents_listed_props_color = get_option( 'inspiry_agents_listed_props_color' );

		// Home Features.
		$inspiry_home_features_title_span_color  = get_option( 'inspiry_home_features_title_span_color' );
		$inspiry_home_features_title_color       = get_option( 'inspiry_home_features_title_color' );
		$inspiry_home_features_desc_color        = get_option( 'inspiry_home_features_desc_color' );
		$inspiry_home_feature_title_color        = get_option( 'inspiry_home_feature_title_color' );
		$inspiry_home_feature_text_color         = get_option( 'inspiry_home_feature_text_color' );
		$inspiry_home_features_background_colors = get_option( 'inspiry_home_features_background_colors' );

		// Home Partners.
		$inspiry_home_partners_title_span_color  = get_option( 'inspiry_home_partners_title_span_color' );
		$inspiry_home_partners_title_color       = get_option( 'inspiry_home_partners_title_color' );
		$inspiry_home_partners_desc_color        = get_option( 'inspiry_home_partners_desc_color' );
		$inspiry_home_partners_background_colors = get_option( 'inspiry_home_partners_background_colors' );

		//Home News
		$inspiry_home_news_title_span_color  = get_option( 'inspiry_home_news_title_span_color' );
		$inspiry_home_news_title_color       = get_option( 'inspiry_home_news_title_color' );
		$inspiry_home_news_desc_color        = get_option( 'inspiry_home_news_desc_color' );
		$inspiry_home_news_background_colors = get_option( 'inspiry_home_news_background_colors' );

		// Property item.
		$theme_property_item_bg_color        = get_option( 'theme_property_item_bg_color' );
		$theme_property_title_color          = get_option( 'theme_property_title_color' );
		$theme_property_title_hover_color    = get_option( 'theme_property_title_hover_color' );
		$theme_property_price_text_color     = get_option( 'theme_property_price_text_color' );
		$theme_property_desc_text_color      = get_option( 'theme_property_desc_text_color' );
		$theme_property_meta_text_color      = get_option( 'theme_property_meta_text_color' );
		$inspiry_property_meta_heading_color = get_option( 'inspiry_property_meta_heading_color' );
		$inspiry_property_meta_icon_color    = get_option( 'inspiry_property_meta_icon_color' );
		$inspiry_property_image_overlay      = get_option( 'inspiry_property_image_overlay' );
		$inspiry_property_overlay_rgba       = inspiry_hex_to_rgba( $inspiry_property_image_overlay, 0.7 );
		$inspiry_property_featured_label_bg  = get_option( 'inspiry_property_featured_label_bg' );
		$featured_label_property             =  $is_rtl ? 'border-right-color' : 'border-left-color';

		// Footer.
		$inspiry_footer_bg                     = get_option( 'inspiry_footer_bg' );
		$theme_footer_widget_text_color        = get_option( 'theme_footer_widget_text_color' );
		$theme_footer_widget_link_color        = get_option( 'theme_footer_widget_link_color' );
		$theme_footer_widget_link_hover_color  = get_option( 'theme_footer_widget_link_hover_color' );
		$theme_footer_widget_title_hover_color = get_option( 'theme_footer_widget_title_hover_color' );

		// Buttons.
		$theme_button_text_color                  = get_option( 'theme_button_text_color' );
		$theme_button_bg_color                    = get_option( 'theme_button_bg_color' );
		$theme_button_hover_text_color            = get_option( 'theme_button_hover_text_color' );
		$theme_button_hover_bg_color              = get_option( 'theme_button_hover_bg_color' );
		$inspiry_advance_search_btn_bg            = get_option( 'inspiry_advance_search_btn_bg' );
		$inspiry_advance_search_btn_hover_bg      = get_option( 'inspiry_advance_search_btn_hover_bg' );
		$inspiry_advance_search_btn_text          = get_option( 'inspiry_advance_search_btn_text' );
		$inspiry_advance_search_btn_text_hover    = get_option( 'inspiry_advance_search_btn_text_hover' );
		$inspiry_advance_search_arrow_and_text    = get_option( 'inspiry_advance_search_arrow_and_text' );

		// Gallery.
		$inspiry_gallery_hover_color = get_option( 'inspiry_gallery_hover_color' );
		$inspiry_gallery_hover_color = inspiry_hex_to_rgba( $inspiry_gallery_hover_color, 0.9 );

		// News.
		$inspiry_post_meta_bg    = get_option( 'inspiry_post_meta_bg' );

		// Slider.
		$theme_slide_title_color           = get_option( 'theme_slide_title_color' );
		$theme_slide_title_hover_color     = get_option( 'theme_slide_title_hover_color' );
		$theme_slide_desc_text_color       = get_option( 'theme_slide_desc_text_color' );
		$theme_slide_price_color           = get_option( 'theme_slide_price_color' );
		$inspiry_slider_meta_heading_color = get_option( 'inspiry_slider_meta_heading_color' );
		$inspiry_slider_meta_text_color    = get_option( 'inspiry_slider_meta_text_color' );
		$inspiry_slider_meta_icon_color    = get_option( 'inspiry_slider_meta_icon_color' );
		$inspiry_slider_featured_label_bg  = get_option( 'inspiry_slider_featured_label_bg' );
		$slider_featured_label_property    = $is_rtl ? 'border-right-color' : 'border-left-color';

		// Responsive Header
		$theme_responsive_header_bg_color           = get_option( 'theme_responsive_header_bg_color' );
		$theme_logo_responsive_text_color           = get_option( 'theme_logo_responsive_text_color' );
		$theme_responsive_phone_text_color          = get_option( 'theme_responsive_phone_text_color' );
		$theme_responsive_phone_text_color_hover    = get_option( 'theme_responsive_phone_text_color_hover' );
		$theme_responsive_submit_button_bg          = get_option( 'theme_responsive_submit_button_bg' );
		$theme_responsive_submit_button_bg_hover    = get_option( 'theme_responsive_submit_button_bg_hover' );
		$theme_responsive_submit_button_color       = get_option( 'theme_responsive_submit_button_color' );
		$theme_responsive_submit_button_color_hover = get_option( 'theme_responsive_submit_button_color_hover' );
		$theme_responsive_menu_icon_color           = get_option( 'theme_responsive_menu_icon_color' );
		$theme_responsive_menu_bg_color             = get_option( 'theme_responsive_menu_bg_color' );
		$theme_responsive_menu_text_color           = get_option( 'theme_responsive_menu_text_color' );
		$theme_responsive_menu_text_hover_color     = get_option( 'theme_responsive_menu_text_hover_color' );

		$inspiry_search_form_primary_color   = get_option( 'inspiry_search_form_primary_color' );
		$inspiry_search_form_secondary_color = get_option( 'inspiry_search_form_secondary_color' );
		$inspiry_search_form_active_text     = get_option( 'inspiry_search_form_active_text' );

		$dynamic_css = array(
			// #ea723d
			array(
				'elements' => '.inspiry_mod_header_varition_one ul.rh_menu__main li a:hover,
							   .inspiry_mod_header_varition_one ul.rh_menu__main > .current-menu-item > a,
							   .inspiry_mod_header_varition_one ul.rh_menu__main > .current-menu-ancestor > a,
							   .inspiry_mod_header_varition_one ul.rh_menu__main li:hover, 
							   .rh_menu--hover,
							   .rh_section__featured .rh_flexslider__nav a:hover,
							   [data-tooltip]::after,
							   .dsidx-widget-guided-search form input[type=submit]:hover,
							   .dsidx-widget-quick-search form input[type=submit]:hover,
							   #ihf-main-container .btn-primary.active,
							   .rh_prop_search__buttons_smart .rh_prop_search__advance a,
							   .rh_prop_search__buttons_smart .rh_prop_search__searchBtn button,
							   .rh_header_var_1 ul.rh_menu__main li:hover,
							   .rh_header_var_1 ul.rh_menu__main > .current-menu-item > a,
							   .rh_header_var_1 ul.rh_menu__main > .current-menu-ancestor > a,
							   .rh_header_var_1 ul.rh_menu__main li a:hover,
							   .rh_btn--secondary, 
							   .mc4wp-form-fields input[type="submit"],
							   .inspiry_mod_search_form_smart .rh_prop_search__buttons_smart .rh_prop_search__searchBtn button,
							   .inspiry_mod_search_form_smart .rh_prop_search__buttons_smart .rh_prop_search__advance a,
							   .rh_form__item .inspiry-details-wrapper .inspiry-detail .add-detail,
							   .brands-owl-carousel .owl-nav button.owl-prev:hover:not(.disabled), 
							   .brands-owl-carousel .owl-nav button.owl-next:hover:not(.disabled),
							   .rh_agent_options label .control__indicator:after,
							   .inspiry_bs_orange div.dropdown-menu,
							   .rh_prop_search__form_smart .inspiry_select_picker_trigger.open button.dropdown-toggle,
							   .rh_prop_search__form_smart .inspiry_select_picker_trigger div.dropdown-menu,
							   .widget.RVR_Booking_Widget h4.title,
							   .rvr_phone_icon,
							   .rh_cfos .cfos_phone_icon,
							   .woocommerce span.onsale, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce .widget_price_filter .price_slider_wrapper .ui-widget-content',
				'property' => 'background',
				'value'    => $core_orange_color,
			),
			array(
				'elements' => '.rh_cfos .cfos_phone_icon:after,
								.rvr_phone_icon:after',
				'property' => 'border-left-color',
				'value'    => $core_orange_color,
			),
			array(
				'elements' => '.rtl .rh_cfos .cfos_phone_icon:before,
								.rh_prop_search__form_smart .rh_form_smart_top_fields .inspiry_select_picker_trigger.open button.dropdown-toggle',
				'property' => 'border-right-color',
				'value'    => $core_orange_color,
			),

			array(
				'elements' => '.rh_agent_card__wrap .rh_agent_card__details .rh_agent_card__contact .rh_agent_card__link .rh_agent_form .rh_agent_form__row,
				               .rh_agent_form .rh_agent_card__wrap .rh_agent_card__details .rh_agent_card__contact .rh_agent_card__link .rh_agent_form__row,
							   .rh_agent_card__wrap .rh_agent_card__details .rh_agent_card__contact .rh_agent_card__link p,
							   .rh_agent_card__wrap .rh_agent_card__details .rh_agent_card__contact .rh_agent_card__link span,
							   .rh_agent_card__wrap .rh_agent_card__details .rh_agent_card__contact .rh_agent_card__link i,
							   .qe-faqs-filters-container li a:hover,
							   #dsidx-top-search span.dsidx-search-bar-openclose:hover,
							   #dsidx.dsidx-results .dsidx-paging-control a:hover,
							   .dsidx-results-widget .dsidx-expanded .featured-listing>h4 a:hover,
							   .commentlist article .comment-detail-wrap .comment-reply-link:hover,
							   .rh_modal .rh_modal__wrap a:hover,
							   .agent-content-wrapper .description a, 
							   .agent-content-wrapper .rh_agent_card__link,
							   .rh_prop_search__wrap_smart .open_more_features,
							   .inspiry_mod_search_form_smart .rh_prop_search__wrap_smart .open_more_features,
							   .rh_section__news_wrap .categories a:hover,
							   .rh_agent .rh_agent__details .rh_agent__phone a:hover,
							   .rvr_optional_services_status li.rh_property__feature .rvr_not_available i,
							   .rh_address_sty a:hover,
							   .rvr_fa_icon
							   ',
				'property' => 'color',
				'value'    => $core_orange_color,
			),
			array(
				'elements' => '.rh_prop_search__buttons_smart .rh_prop_search__searchBtn button:hover,
								.inspiry_mod_search_form_smart .rh_prop_search__buttons_smart .rh_prop_search__searchBtn button:hover,
								.rh_form__item .inspiry-details-wrapper .inspiry-detail .add-detail:hover
								',
				'property' => 'background',
				'value'    => inspiry_hex_darken( $core_orange_color, 4 ),
			),
			array(
				'elements' => '.inspiry_bs_orange div.dropdown-menu li.selected a,
								.inspiry_bs_orange div.dropdown-menu li:hover a,
								.rh_prop_search__form_smart .inspiry_select_picker_trigger div.dropdown-menu li.selected a,
								.rh_prop_search__form_smart .inspiry_select_picker_trigger div.dropdown-menu li:hover a,
								.rh_prop_search__form_smart .inspiry_select_picker_trigger div.dropdown-menu ::-webkit-scrollbar-thumb,
								.rh_prop_search__form_smart .inspiry_select_picker_trigger .bs-actionsbox .btn-block .bs-select-all:hover,
								.rh_prop_search__form_smart .inspiry_select_picker_trigger .bs-actionsbox .btn-block .bs-deselect-all:hover',
				'property' => 'background',
				'value'    => inspiry_hex_darken( $core_orange_color, 8 ),
			),
			array(
				'elements' => '.rh_prop_search__form_smart .inspiry_select_picker_trigger div.dropdown-menu ::-webkit-scrollbar-thumb',
				'property' => 'outline-color',
				'value'    => inspiry_hex_darken( $core_orange_color, 8 ),
			),

			array(
				'elements' => '.rh_prop_search__form_smart .inspiry_select_picker_trigger div.dropdown-menu ::-webkit-scrollbar-track',
				'property' => 'box-shadow',
				'value'    => ' inset 0 0 6px ' . inspiry_hex_darken( $core_orange_color, 8 ),
			),
			array(
				'elements' => '.rh_cta__wrap .rh_cta__btns .rh_btn--secondary,
				.availability-calendar table td.unavailable,
				div.daterangepicker .calendar-table td.reserved,
				.rh_property__ava_calendar_wrap .calendar-guide ul li.reserved-days::before',
				'property' => 'background',
				'value'    => inspiry_hex_to_rgba( $core_orange_color, 1 ),
			),
			array(
				'elements' => '.rh_cta__wrap .rh_cta__btns .rh_btn--secondary:hover, 
								.rh_btn--secondary:hover, .mc4wp-form-fields input:hover[type="submit"],
								.inspiry_mod_search_form_smart .rh_prop_search__buttons_smart .rh_prop_search__advance a',
				'property' => 'background',
				'value'    => inspiry_hex_to_rgba( $core_orange_color, .8 ),
			),
			array(
				'elements' => '.rh_modal .rh_modal__wrap .rh_modal__dashboard .rh_modal__dash_link:hover svg,
								.rh_property__features_wrap .rh_property__feature .rh_done_icon svg,
								.rh_prop_card .rh_prop_card__thumbnail .rh_prop_card__btns a:hover svg path,
								.rh_list_card__wrap .rh_list_card__thumbnail .rh_list_card__btns a:hover svg path,
								.rh_list_card__wrap .rh_list_card__map_thumbnail .rh_list_card__btns a:hover svg path,
								.rh_property__print .rh_single_compare_button .highlight svg path,
								.rh_double_check,
								.rh_fav_icon_box a:hover svg path,
								.rh_address_sty a:hover svg,
								.highlight svg path',
				'property' => 'fill',
				'value'    => $core_orange_color,
			),
			array(
				'elements' => 'ul.rh_menu__main ul.sub-menu,
							   [data-tooltip]:not([flow])::before, [data-tooltip][flow^=up]::before,
							   .rh_header_var_1 ul.rh_menu__main ul.sub-menu,
							   .rh_header_var_1 ul.rh_menu__main ul.sub-menu ul.sub-menu',
				'property' => 'border-top-color',
				'value'    => $core_orange_color,
			),
			array(
				'elements' => '.qe-testimonial-wrapper .qe-testimonial-img a:hover .avatar,
							   .commentlist article>a:hover img,
							   .rh_var_header .rh_menu__main .current-menu-ancestor,
							    .rh_var_header .rh_menu__main .current-menu-item,
							    .rh_var_header .rh_menu__main > li:hover,
							    .rh_prop_search__form_smart .inspiry_select_picker_trigger.open button.dropdown-toggle
							    ',
				'property' => 'border-color',
				'value'    => $core_orange_color,
			),
			// #1ea69a
			array(
				'elements' => '::selection',
				'property' => 'background-color',
				'value'    => $selection_bg_color,
			),
			array(
				'elements' => '::-moz-selection',
				'property' => 'background-color',
				'value'    => $selection_bg_color,
			),
			array(
				'elements' => '.rh_slide__desc .rh_slide_prop_price span,
							   .rh_slide__desc h3 .title:hover,
							   .rh_section--props_padding .rh_section__head .rh_section__subtitle,
							   .rh_section .rh_section__head .rh_section__subtitle,
							   .rh_prop_card .rh_prop_card__details h3 a:hover,
							   .rh_list_card__wrap .rh_list_card__map_wrap h3 a:hover,
							   .rh_list_card__wrap .rh_list_card__details_wrap h3 a:hover,
							   .rh_prop_card .rh_prop_card__details .rh_prop_card__priceLabel .rh_prop_card__price,
							   .rh_list_card__wrap .rh_list_card__map_details .rh_list_card__priceLabel .rh_list_card__price .price,
							   .rh_list_card__wrap .rh_list_card__priceLabel .rh_list_card__price .price,
							   .rh_prop_card .rh_prop_card__thumbnail .rh_overlay__contents a:hover,
							   .rh_agent .rh_agent__details h3 a:hover,
							   .rh_agent .rh_agent__details .rh_agent__phone a,
							   .rh_agent .rh_agent__details .rh_agent__email:hover,
							   .rh_agent .rh_agent__details .rh_agent__listed .figure,
							   .rh_list_card__wrap .rh_list_card__thumbnail .rh_overlay__contents a:hover,
							   .property-template-default .rh_page__property_price .price,
							   .rh_page__property .rh_page__property_price .price,
							   .rh_property_agent .rh_property_agent__agent_info .email .value,
							   .rh_property__id .id,
							   .rh_property__heading,
							   .rvr_price_details_wrap .rvr_price_details ul li.bulk-pricing-heading,
							   .rh_agent_card__wrap .rh_agent_card__head .rh_agent_card__listings .count,
							   .rh_agent_card__wrap .rh_agent_card__details .rh_agent_card__contact .rh_agent_card__link:hover .rh_agent_form .rh_agent_form__row,
							   .rh_agent_form .rh_agent_card__wrap .rh_agent_card__details .rh_agent_card__contact .rh_agent_card__link:hover .rh_agent_form__row,
							   .rh_agent_card__wrap .rh_agent_card__details .rh_agent_card__contact .rh_agent_card__link:hover p,
							   .rh_agent_card__wrap .rh_agent_card__details .rh_agent_card__contact .rh_agent_card__link:hover span,
							   .rh_agent_card__wrap .rh_agent_card__details .rh_agent_card__contact .rh_agent_card__link:hover i,
							   .rh_agent_card__wrap .rh_agent_card__head .rh_agent_card__name .name a:hover,
							   .rh_agent_card__wrap .rh_agent_card__details .rh_agent_card__contact .rh_agent_card__contact_wrap .contact a:hover,
							   .rh_agent_profile__wrap .rh_agent_profile__head .rh_agent_profile__details .detail a:hover,
							   .rh_agent_profile__wrap .rh_agent_profile__head .rh_agent_profile__dp .listed_properties .number,
							   .agent-content-wrapper .listed_properties .number,
							   .rh_page__head .rh_page__title .sub,
							   .rh_gallery__wrap .rh_gallery__item .item-title a:hover,
							   .qe-testimonial-wrapper .qe-testimonial-byline a,
							   .qe-faqs-filters-container li a,
							   ol.dsidx-results li.dsidx-prop-summary .dsidx-prop-features>div:before,
							   #dsidx-top-search span.dsidx-search-bar-openclose,
							   #dsidx.dsidx-results .dsidx-paging-control a,
							   .dsidx-results:not(.dsidx-results-grid) #dsidx-listings .dsidx-listing .dsidx-data .dsidx-primary-data .dsidx-price,
							   .dsidx-results:not(.dsidx-results-grid) #dsidx-listings .dsidx-listing .dsidx-data .dsidx-secondary-data>div:before,
							   .dsidx-results-widget .dsidx-expanded .featured-listing ul li:before,
							   #ihf-main-container a:focus,
							   #ihf-main-container a:hover,
							   #ihf-main-container h4.ihf-price,
							   #ihf-main-container a:hover .ihf-grid-result-address,
							   #ihf-main-container a:focus .ihf-grid-result-address,
							   .commentlist article .comment-detail-wrap .comment-reply-link,
							   .page-breadcrumbs-modern li a,
							   .page-breadcrumbs-modern li i,
							   .agent-content-wrapper .description a:hover,
							   .agent-content-wrapper .rh_agent_card__link:hover,
							   .property-thumbnail .property-price p,
							   .property-thumbnail .property-title a:hover,
							   .rh_property__agent_head .description p a:hover,
							   .rh_property__agent_head .contacts-list .contact.email a:hover,
							   .rh_section__news_wrap .categories a,
							   .rh_section__news_wrap h3 a:hover,
							   .rh_compare__slide_img .rh_compare_view_title:hover,
							   div.rh_login_modal_wrapper .rh_login_tabs li.rh_active,
							   div.rh_login_modal_wrapper .rh_login_tabs li:hover,
							   .rh_list_card__wrap .rh_list_card__map_thumbnail .rh_overlay__contents a:hover,
							   body .leaflet-popup-content p,
							   body .leaflet-popup-content .osm-popup-title a:hover,
							   body .rh_compare__slide_img .rh_compare_view_title:hover,
							   .rh_my-property .rh_my-property__publish .publish h5,
							   .rh_property__yelp_wrap .yelp-places-group-title i,
							   .infoBox .map-info-window p,
							   .rvr_request_cta_number_wrapper .rvr-phone-number a,
							   .widget.RVR_Owner_Widget .rvr_widget_owner_label,
							   .infoBox .map-info-window a:hover,
							   .woocommerce ul.products li.product .price, .woocommerce div.product p.price, .woocommerce div.product .rh_agent_form .price.rh_agent_form__row, .rh_agent_form .woocommerce div.product .price.rh_agent_form__row, .woocommerce div.product span.price, .woocommerce ul.cart_list li .amount, .woocommerce ul.product_list_widget li .amount,
							   .rh_property__meta_wrap .rh_property__meta i,
							   .commentlist article .comment-detail-wrap .url,
							   h3.rh_heading_stylish a:hover,
							   .rh_theme_card__priceLabel_sty .rh_theme_card__price_sty,
							   .floor-plans-accordions .floor-plan-title .floor-plan-meta .floor-price-value,
							   .rvr_guests_accommodation_wrap .rvr_guests_accommodation ul li i.fas
							   ',
				'property' => 'color',
				'value'    => $core_green_color,
			),
			array(
				'elements' => '.rh_btn--primary, 
							   .post-password-form input[type="submit"],
							   .widget .searchform input[type="submit"],
							   .comment-form .form-submit .submit,
							   .rh_memberships__selection .ims-stripe-button .stripe-button-el,
							   .rh_memberships__selection #ims-free-button,
							   .rh_contact__form .wpcf7-form input[type="submit"],
							   .widget_mortgage-calculator .mc-wrapper p input[type="submit"],
							   .rh_memberships__selection .ims-receipt-button #ims-receipt,
							   .rh_contact__form .rh_contact__input input[type="submit"],
							   .rh_form__item input[type="submit"], .rh_pagination__pages-nav a,
							   .rh_prop_search__form .rh_prop_search__buttons .rh_prop_search__searchBtn .rh_btn__prop_search,
							   .rh_modal .rh_modal__wrap button,
							   .rh_section__testimonial .diagonal-mod-background,
							   .rh_section__testimonial.flat-border,
							   .rh_blog__post .entry-header,
							   .rh_prop_search__form .rh_prop_search__fields .rh_prop_search__active,
							   .dsidx-widget-guided-search form input[type=submit],
							   .dsidx-widget-quick-search form input[type=submit],
							   ol.dsidx-results li.dsidx-prop-summary .dsidx-prop-title,
							   .rh_blog__post .entry-header,
							   .dsidx-results:not(.dsidx-results-grid) #dsidx-listings .dsidx-listing .dsidx-media .dsidx-photo .dsidx-photo-count,
							   #dsidx-top-search #dsidx-search-bar .dsidx-search-controls .button button,
							   .dsidx-results-grid #dsidx-listings .dsidx-listing .dsidx-data .dsidx-primary-data .dsidx-price,
							   .dsidx-results-grid #dsidx-listings .dsidx-listing .dsidx-media .dsidx-photo .dsidx-photo-count,
							   #dsidx .dsidx-large-button,
							   #dsidx .dsidx-small-button,
							   body.dsidx .dsidx-large-button,
							   body.dsidx .dsidx-small-button,
							   #dsidx-rentzestimate-notice,
							   #dsidx-zestimate-notice,
							   #dsidx.dsidx-details .dsidx-headerbar-green,
							   #ihf-main-container .title-bar-1,
							   #ihf-main-container .btn-primary,
							   #ihf-main-container .dropdown-menu>.active>a,
							   #ihf-main-container .dropdown-menu>li>a:hover,
							   #ihf-main-container .pagination li:first-child>a,
							   #ihf-main-container .pagination li:first-child>span,
							   #ihf-main-container .pagination li:last-child>a,
							   #ihf-main-container .pagination li:last-child>span,
							   #ihf-main-container .ihf-map-search-refine-link,
							   #ihf-main-container .btn-default,
							   .rh_sidebar .widget_ihomefinderpropertiesgallery>a,
							   #ihf-main-container .ihf-social-share .ihf-share-btn-email,
							   #ihf-main-container .ihf-social-share .ihf-share-btn-facebook,
							   #ihf-main-container .ihf-social-share .ihf-share-btn-more,
							   #ihf-main-container .ihf-social-share .ihf-share-btn-print,
							   button,
							   #ihf-main-container .modal-footer .btn,
							   .ihf-map-icon,
							   .rh_var2_header_meta_wrapper,
							   .rh_var3_header,
							   .open_more_features,
							   #home-properties-section .pagination a.current,
							   #home-properties-section .pagination a:hover,
							   .inspiry-floor-plans-group-wrapper .inspiry-btn-group .real-btn,
							   body .rh_fixed_side_bar_compare .rh_compare__submit,
							   .agent-custom-contact-form .wpcf7 input[type="submit"],
							   .rh_mod_sfoi_wrapper .rh_prop_search__select.rh_prop_search__active,
							   body .leaflet-popup-tip,
							   body .marker-cluster-small div,
							   .rh_prop_search__form .rh_prop_search__fields .inspiry_bs_is_open,
							   .rh_prop_search__form .rh_prop_search__fields .inspiry_bs_is_open .inspiry_select_picker_trigger button.dropdown-toggle,
							   .rh_prop_search__form .rh_prop_search__fields .inspiry_select_picker_field .inspiry_select_picker_trigger div.dropdown-menu,
							   #ui-datepicker-div .ui-datepicker-header,
							   #ui-datepicker-div .ui-datepicker-calendar tbody tr td.ui-datepicker-today, 
							   #ui-datepicker-div .ui-datepicker-calendar tbody tr td.ui-datepicker-current-day,
							   form.rh_sfoi_advance_search_form .inspiry_bs_is_open,
							   form.rh_sfoi_advance_search_form .inspiry_select_picker_trigger div.dropdown-menu,
							   .inspiry_bs_green div.dropdown-menu,
							   .widget.RVR_Booking_Widget .rvr-booking-form-wrap .rvr-booking-form .submission-area input[type="submit"],
							   .availability-calendar .paging,
							    .cluster div,
							    .ere_latest_properties_ajax .pagination a.current,
							    .ere_latest_properties_ajax .pagination a:hover,
							    .woocommerce #respond input#submit:hover, .woocommerce-page-wrapper .woocommerce a.button:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover,
							    .woocommerce .widget_price_filter .ui-slider .ui-slider-range,
							    .select2-container--open .select2-dropdown--below, .select2-container--open .select2-dropdown--above,
								div.daterangepicker td.active, div.daterangepicker td.active:hover,
								.availability-calendar table td.today,
								.rh_property__ava_calendar_wrap .calendar-guide ul li.today::before,
								.success.booking-notice',
				'property' => 'background',
				'value'    => $core_green_color,
			),

			array(
				'elements' => '.rh_property__mc_wrap .rh_property__mc .rh_mc_field .rh_form__item input[type=range]::-webkit-slider-thumb',
				'property' => 'background',
				'value'    => $core_green_color,
			),
			array(
				'elements' => '.rh_property__mc_wrap .rh_property__mc .rh_mc_field .rh_form__item input[type=range]::-moz-range-thumb ',
				'property' => 'background',
				'value'    => $core_green_color,
			),
			array(
				'elements' => '.rh_property__mc_wrap .rh_property__mc .rh_mc_field .rh_form__item input[type=range]::-ms-thumb',
				'property' => 'background',
				'value'    => $core_green_color,
			),

			array(
				'elements' => '.rh_property__mc_wrap .rh_property__mc .mc_cost_graph_circle .mc_graph_svg .mc_graph_interest',
				'property' => 'stroke',
				'value'    => $core_orange_color,
			),
			array(
				'elements' => '.rh_property__mc_wrap .rh_property__mc .mc_cost_graph_circle .mc_graph_svg .mc_graph_tax',
				'property' => 'stroke',
				'value'    => $core_green_color,
			),
			array(
				'elements' => '.rh_property__mc_wrap .rh_property__mc .mc_cost_graph_circle .mc_graph_svg .mc_graph_hoa',
				'property' => 'stroke',
				'value'    => inspiry_hex_to_rgba( $core_green_color, .3 ),
			),

			array(
				'elements' => '.rh_property__mc_wrap .rh_property__mc .mc_cost li.mc_cost_interest::before',
				'property' => 'background-color',
				'value'    => $core_orange_color,
			),
			array(
				'elements' => '.rh_property__mc_wrap .rh_property__mc .mc_cost li.mc_cost_tax::before',
				'property' => 'background-color',
				'value'    => $core_green_color,
			),
			array(
				'elements' => '.rh_property__mc_wrap .rh_property__mc .mc_cost li.mc_cost_hoa::before',
				'property' => 'background-color',
				'value'    => inspiry_hex_to_rgba( $core_green_color, .3 ),
			),
			array(
				'elements' => '#ihf-main-container .btn-primary:active,
							   #ihf-main-container .btn-primary:focus,
							   #ihf-main-container .btn-primary:hover,
							   #ihf-main-container .pagination li:first-child>a:hover,
							   #ihf-main-container .pagination li:first-child>span:hover,
							   #ihf-main-container .pagination li:last-child>a:hover,
							   #ihf-main-container .pagination li:last-child>span:hover,
							   #ihf-main-container .ihf-map-search-refine-link,
							   #ihf-main-container .btn-default:active,
							   #ihf-main-container .btn-default:focus,
							   #ihf-main-container .btn-default:hover,
							   .rh_sidebar .widget_ihomefinderpropertiesgallery>a:hover,
							   #ihf-main-container .ihf-social-share .ihf-share-btn-email:hover,
							   #ihf-main-container .ihf-social-share .ihf-share-btn-facebook:hover,
							   #ihf-main-container .ihf-social-share .ihf-share-btn-more:hover,
							   #ihf-main-container .ihf-social-share .ihf-share-btn-print:hover,
							   #ihf-main-container .modal-footer .btn:active,
							   #ihf-main-container .modal-footer .btn:focus,
							   #ihf-main-container .modal-footer .btn:hover,
							   .inspiry-floor-plans-group-wrapper .inspiry-btn-group .real-btn:hover,
							   .agent-custom-contact-form .wpcf7 input[type="submit"]:hover,
							   .widget.RVR_Booking_Widget .rvr-booking-form-wrap .rvr-booking-form .submission-area input[type="submit"]:hover,
							   .rh_mode_sfoi_search_btn button:hover',
				'property' => 'background',
				'value'    => inspiry_hex_darken( $core_green_color, 4 ),
			),
			array(
				'elements' => '.rh_prop_search__form .rh_prop_search__fields .inspiry_select_picker_field .inspiry_select_picker_trigger div.dropdown-menu li.selected,
								.rh_prop_search__form .rh_prop_search__fields .inspiry_select_picker_field .inspiry_select_picker_trigger div.dropdown-menu li:hover,
								.rh_prop_search__form .rh_prop_search__fields .inspiry_select_picker_field .inspiry_select_picker_trigger div.dropdown-menu ::-webkit-scrollbar-thumb,
								form.rh_sfoi_advance_search_form .inspiry_select_picker_trigger div.dropdown-menu li.selected,
								form.rh_sfoi_advance_search_form .inspiry_select_picker_trigger div.dropdown-menu li:hover,
								form.rh_sfoi_advance_search_form .inspiry_select_picker_trigger div.dropdown-menu ::-webkit-scrollbar-thumb,
								.inspiry_bs_green div.dropdown-menu li.selected a,
								#ui-datepicker-div .ui-datepicker-calendar tbody tr td:hover,
								form.rh_sfoi_advance_search_form .inspiry_select_picker_trigger div.dropdown-menu .actions-btn:hover,
								.rh_prop_search__form .rh_prop_search__fields .inspiry_select_picker_field .inspiry_select_picker_trigger div.dropdown-menu .actions-btn:hover,
								.inspiry_bs_green div.dropdown-menu ::-webkit-scrollbar-thumb,
								.inspiry_bs_green div.dropdown-menu li:hover a',
				'property' => 'background',
				'value'    => inspiry_hex_darken( $core_green_color, 8 ),
			),
			array(
				'elements' => '.rh_prop_search__form .rh_prop_search__fields .inspiry_select_picker_field .inspiry_select_picker_trigger div.dropdown-menu ::-webkit-scrollbar-thumb,
								form.rh_sfoi_advance_search_form .inspiry_select_picker_trigger div.dropdown-menu ::-webkit-scrollbar-thumb,
								.inspiry_bs_green div.dropdown-menu ::-webkit-scrollbar-thumb',
				'property' => 'outline-color',
				'value'    => inspiry_hex_darken( $core_green_color, 8 ),
			),
			array(
				'elements' => '.rh_prop_search__form .rh_prop_search__fields .inspiry_select_picker_field .inspiry_select_picker_trigger div.dropdown-menu ::-webkit-scrollbar-track,
								form.rh_sfoi_advance_search_form .inspiry_select_picker_trigger div.dropdown-menu ::-webkit-scrollbar-track,
								.inspiry_bs_green div.dropdown-menu ::-webkit-scrollbar-track',
				'property' => 'box-shadow',
				'value'    => ' inset 0 0 6px ' . inspiry_hex_darken( $core_green_color, 8 ),
			),
			array(
				'elements' => '.rh_overlay',
				'property' => 'background',
				'value'    => inspiry_hex_to_rgba( $core_green_color, .7 ),
			),
			array(
				'elements' => '#dsidx-zestimate,#dsidx-rentzestimate',
				'property' => 'background-color',
				'value'    => inspiry_hex_to_rgba( $core_green_color, .1 ),
			),
			array(
				'elements' => '.rh_my-property .rh_my-property__publish .publish ',
				'property' => 'background-color',
				'value'    => inspiry_hex_to_rgba( $core_green_color, .3 ),
			),
			array(
				'elements' => '.rh_cta--contact .rh_cta .rh_cta__overlay',
				'property' => 'background-color',
				'value'    => inspiry_hex_to_rgba( $core_green_color, .8 ),
			),
			array(
				'elements' => '.rh_gallery__wrap .rh_gallery__item .media_container',
				'property' => 'background-color',
				'value'    => inspiry_hex_to_rgba( $core_green_color, .9 ),
			),
			array(
				'elements' => 'blockquote,
				               .qe-faq-toggle .qe-toggle-title',
				'property' => 'background-color',
				'value'    => inspiry_hex_to_rgba( $core_green_color, .1 ),
			),
			array(
				'elements' => '.qe-faq-toggle .qe-toggle-title:hover,.qe-faq-toggle.active .qe-toggle-title, div.daterangepicker td.in-range:not(.active,.ends), .availability-calendar table td.available:not(.past-date,.today), .rh_property__ava_calendar_wrap .calendar-guide ul li.available-days::before',
				'property' => 'background-color',
				'value'    => inspiry_hex_to_rgba( $core_green_color, .2 ),
			),
			array(
				'elements' => '.qe-faq-toggle .qe-toggle-content',
				'property' => 'background-color',
				'value'    => inspiry_hex_to_rgba( $core_green_color, .05 ),
			),
			array(
				'elements' => 'body .marker-cluster-small, .cluster',
				'property' => 'background-color',
				'value'    => inspiry_hex_to_rgba( $core_green_color, .5 ),
			),
			array(
				'elements' => '.rh_page__gallery_filters a.active,
							   .rh_page__gallery_filters a:hover,
							   .rh_page__head .rh_page__nav .active,
							   .rh_page__head .rh_page__nav .rh_page__nav_item:hover,
							   div.rh_login_modal_wrapper .rh_login_tabs li.rh_active,
							   div.rh_login_modal_wrapper .rh_login_tabs li:hover,
							   body .leaflet-popup-content-wrapper,
							   .infoBox .map-info-window',
				'property' => 'border-bottom-color',
				'value'    => $core_green_color,
			),
			array(
				'elements' => '.ihf-map-icon:after, .infoBox .map-info-window .arrow-down,
							   .rh_latest_properties_2 .rh_tags_wrapper .rh_featured:before',
				'property' => 'border-top-color',
				'value'    => $core_green_color,
			),
			array(
				'elements' => 'blockquote,
							   .qe-testimonial-wrapper .qe-testimonial-img a .avatar,
							   #dsidx-rentzestimate, #dsidx-zestimate,
							   #dsidx.dsidx-details .dsidx-headerbar-green,
							   #dsidx.dsidx-details .dsidx-contact-form,
							   .commentlist article>a img,
							   .woocommerce #respond input#submit:hover, .woocommerce-page-wrapper .woocommerce a.button:hover, .woocommerce a.button:hover, .woocommerce button.button:hover, .woocommerce input.button:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover',
				'property' => 'border-color',
				'value'    => $core_green_color,
			),
			array(
				'elements' => 'blockquote,
							   #dsidx-rentzestimate-triangle, #dsidx-zestimate-triangle,
							   .rh_latest_properties_2 .rh_tags_wrapper .rh_featured:before',
				'property' => 'border-left-color',
				'value'    => $core_green_color,
			),
			array(
				'elements' => '.rh_latest_properties_2 .rh_tags_wrapper .rh_featured:before',
				'property' => 'border-right-color',
				'value'    => $core_green_color,
			),
			array(
				'elements' => '.rh_slide__prop_meta .rh_svg,
							   .rh_svg,
							   .rh_banner .rh_view_type .active path,
							   .rh_banner .rh_view_type a:hover path,
							   .rh_view_type a.active svg path,
							   .rh_view_type a:hover svg path,							  
							   div.rh_modal_login_loader svg path',
				'property' => 'fill',
				'value'    => $core_green_color,
			),

			//#0b8278
			array(
				'elements' => '.rh_btn--primary:hover, 
							   .post-password-form input[type="submit"]:hover,
							   .widget .searchform input[type="submit"]:hover,
							   .comment-form .form-submit .submit:hover,
							   .rh_memberships__selection .ims-stripe-button .stripe-button-el:hover,
							   .rh_memberships__selection #ims-free-button:hover,
							   .rh_contact__form .wpcf7-form input[type="submit"]:hover,
							   .widget_mortgage-calculator .mc-wrapper p input[type="submit"]:hover,
							   .rh_memberships__selection .ims-receipt-button #ims-receipt:hover,
							   .rh_contact__form .rh_contact__input input[type="submit"]:hover,
							   .rh_form__item input[type="submit"]:hover, .rh_pagination__pages-nav a:hover,
							   .rh_prop_search__form .rh_prop_search__buttons .rh_prop_search__searchBtn .rh_btn__prop_search:hover,
							   .rh_modal .rh_modal__wrap button:hover,
							   #dsidx .dsidx-large-button:hover,
							   #dsidx .dsidx-small-button:hover,
							   body.dsidx .dsidx-large-button:hover,
							   body.dsidx .dsidx-small-button:hover,
							   .open_more_features:hover,
							   #rh_save_search button:hover,
							   body .rh_fixed_side_bar_compare .rh_compare__submit:hover,
							   .select2-container--default .select2-results__option[aria-selected=true], 
							   .select2-container--default .select2-results__option[data-selected=true],
							   div.rh_login_modal_wrapper button:not(.dropdown-toggle):hover
							   ',
				'property' => 'background',
				'value'    => $core_green_dark_color,
			),
			array(
				'elements' => '.page-breadcrumbs-modern li a:hover',
				'property' => 'color',
				'value'    => $core_green_dark_color,
			),
			array(
				'elements' => '.rh_section__testimonial .quotes-marks svg,
				               .rh_view_type a svg path',
				'property' => 'fill',
				'value'    => $core_green_dark_color,
			),
			array(
				'elements' => '.rh_var2_nav_wrapper,
								.rh_var3_header',
				'property' => 'background',
				'value'    => $theme_header_menu_top_color,
			),
			array(
				'elements' => '.rh_var2_header_meta_wrapper',
				'property' => 'background',
				'value'    => $theme_header_meta_bg_color,
			),
			array(
				'elements' => '.rh_banner',
				'property' => 'background-color',
				'value'    => $theme_header_bg_color,
			),
			array(
				'elements' => '.rh_logo .rh_logo__heading a,
								.rh_var_header .rh_logo__heading a',
				'property' => 'color',
				'value'    => $theme_logo_text_color,
			),
			array(
				'elements' => '.rh_logo .rh_logo__heading a:hover,
								.rh_var_header .rh_logo__heading a:hover',
				'property' => 'color',
				'value'    => $theme_logo_text_hover_color,
			),
			array(
				'elements' => '.rh_var_header ul.rh_menu__main li a, 
								.rh_var3_header.rh_var_header ul.rh_menu__main li a, 
								.rh_header_var_1 ul.rh_menu__main li a
								',
				'property' => 'color',
				'value'    => $theme_main_menu_text_color,
			),

			array(
				'elements' => '.rh_var3_header.rh_var_header .rh_menu__main > li > a:after,
								.rh_var3_header.rh_var_header .rh_menu__main > current-menu-item > a:after
								',
				'property' => 'background',
				'value'    => $theme_main_menu_text_hover_color,
			),
			array(
				'elements' => '.rh_header_var_1 ul.rh_menu__main li:hover > a,
								.rh_header_var_1 ul.rh_menu__main .current-menu-item > a,
								.rh_var3_header.rh_var_header ul.rh_menu__main li:hover > a, 
								.rh_var3_header.rh_var_header ul.rh_menu__main .current-menu-item a, 
								.rh_var_header .rh_menu__main li:hover > a,
								.rh_var_header .rh_menu__main .current-menu-item > a
								',
				'property' => 'color',
				'value'    => $theme_main_menu_text_hover_color,
			),
			array(
				'elements' => '.rh_header_var_1 ul.rh_menu__main > .current-menu-item > a,
							   .rh_header_var_1 ul.rh_menu__main li:hover,
							   .rh_header_var_1 ul.rh_menu__main li a:hover,
							   .rh_header_var_1 ul.rh_menu__main li:hover > a 
							   ',
				'property' => 'background',
				'value'    => $inspiry_main_menu_hover_bg,
			),
			array(
				'elements' => 'ul.rh_menu__main ul.sub-menu,
							    .rh_header_var_1 ul.rh_menu__main ul.sub-menu,
							    .rh_header_var_1 ul.rh_menu__main ul.sub-menu ul.sub-menu,
							    .rh_var2_header .rh_menu__main .current-menu-item, 
							    .rh_var2_header .rh_menu__main > li:hover
								',
				'property' => 'border-top-color',
				'value'    => $inspiry_main_menu_hover_bg,
			),
			array(
				'elements' => '.rh_var2_header .rh_menu__main .current-menu-item, 
							    .rh_var2_header .rh_menu__main > li:hover
								',
				'property' => 'border-color',
				'value'    => $inspiry_main_menu_hover_bg,
			),
			array(
				'elements' => 'ul.rh_menu__main ul.sub-menu, 
							   ul.rh_menu__main ul.sub-menu ul.sub-menu,
							   .rh_header_var_1 ul.rh_menu__main ul.sub-menu,
							   .rh_header_var_1 ul.rh_menu__main ul.sub-menu ul.sub-menu',
				'property' => 'background',
				'value'    => $theme_menu_bg_color,
			),
			array(
				'elements' => 'ul.rh_menu__main ul.sub-menu, ul.rh_menu__main ul.sub-menu ul.sub-menu',
				'property' => 'border-top-color',
				'value'    => $inspiry_main_menu_hover_bg,
			),
			array(
				'elements' => 'ul.rh_menu__main ul.sub-menu li a, 
								ul.rh_menu__main ul.sub-menu ul.sub-menu a,
								.rh_header_var_1 ul.rh_menu__main ul.sub-menu li a,
								.rh_header_var_1 ul.rh_menu__main ul.sub-menu li ul.sub-menu li a,								
								.rh_var3_header ul.rh_menu__main ul.sub-menu li a,
								.rh_var3_header ul.rh_menu__main ul.sub-menu li ul.sub-menu li a
								',
				'property' => 'color',
				'value'    => $theme_menu_text_color,
			),
			array(
				'elements' => '.rh_header_var_1 ul.rh_menu__main ul.sub-menu li.current-menu-item a,
								.rh_header_var_1 ul.rh_menu__main ul.sub-menu li:hover > a,
								.rh_header_var_1 ul.rh_menu__main ul.sub-menu ul.sub-menu li:hover > a,
								.rh_var2_header ul.rh_menu__main ul.sub-menu li:hover > a,
								.rh_var2_header ul.rh_menu__main ul.sub-menu ul.sub-menu li:hover > a,								
								.rh_var3_header ul.rh_menu__main ul.sub-menu li:hover > a,
								.rh_var3_header ul.rh_menu__main ul.sub-menu ul.sub-menu li:hover > a,
								.rh_var_header .rh_menu__main li .current-menu-parent, 
								.rh_var_header .rh_menu__main li .current-menu-item
								',
				'property' => 'background',
				'value'    => $theme_menu_hover_bg_color,
			),
			array(
				'elements' => '.rh_header_var_1 ul.rh_menu__main ul.sub-menu li.current-menu-item a,
								.rh_header_var_1 ul.rh_menu__main ul.sub-menu li:hover > a,
								.rh_header_var_1 ul.rh_menu__main ul.sub-menu ul.sub-menu li:hover > a,
								.rh_var2_header ul.rh_menu__main ul.sub-menu li:hover > a,
								.rh_var2_header ul.rh_menu__main ul.sub-menu ul.sub-menu li:hover > a,
								.rh_var3_header ul.rh_menu__main ul.sub-menu li:hover > a,
								.rh_var3_header ul.rh_menu__main ul.sub-menu ul.sub-menu li:hover > a,
								.rh_var_header .rh_menu__main li .current-menu-parent > a, 
								.rh_var_header .rh_menu__main li .current-menu-item > a
								',
				'property' => 'color',
				'value'    => $theme_menu_hover_text_color,
			),
			array(
				'elements' => '.rh_menu__user .rh_menu__user_phone .contact-number,
								.rh_var2_header_meta_container .rh_right_box .contact-number,
								.rh_var3_user_nav a.contact-number,
								.rh_var2_header_meta_container .rh_right_box .contact-email',
				'property' => 'color',
				'value'    => $theme_phone_text_color,
			),
			array(
				'elements' => '.rh_var2_header_meta_container .rh_right_box .rh_menu__user_phone:hover a, 
								.rh_menu__user .rh_menu__user_phone:hover .contact-number,
								.rh_var2_header_meta_container .rh_right_box .rh_menu__user_email:hover a,
								.rh_var3_user_nav .rh_menu__user_phone:hover a.contact-number',
				'property' => 'color',
				'value'    => $theme_phone_text_color_hover,
			),
			array(
				'elements' => '.rh_var2_social_icons:before,
							   .rh_var2_social_icons a',
				'property' => 'color',
				'value'    => $theme_header_social_icon_color,
			),
			array(
				'elements' => '.rh_var2_social_icons a:hover',
				'property' => 'color',
				'value'    => $theme_header_social_icon_color_hover,
			),
			array(
				'elements' => '.rh_menu__user .rh_menu__user_phone svg,
								.rh_var3_user_nav svg,
								.rh_var2_header_meta_container .rh_right_box svg',
				'property' => 'fill',
				'value'    => $theme_phone_text_color,
			),
			array(
				'elements' => '.rh_var2_header_meta_container .rh_right_box .rh_menu__user_phone:hover svg, 
								.rh_var2_header_meta_container .rh_right_box .rh_menu__user_email:hover svg,
								.rh_menu__user .rh_menu__user_phone:hover svg,
								.rh_var3_user_nav:hover svg',
				'property' => 'fill',
				'value'    => $theme_phone_text_color_hover,
			),
			array(
				'elements' => '.rh_mod_sticky_header.sticky_header_custom',
				'property' => 'background',
				'value'    =>  $theme_modern_sticky_header_bg_color,
			),
			array(
				'elements' => '.rh_mod_sticky_header.sticky_header_custom .menu-main-menu-container > ul > li > a',
				'property' => 'color',
				'value'    => $theme_modern_sticky_header_menu_color,
			),
			array(
				'elements' => '.rh_mod_sticky_header.sticky_header_custom .menu-main-menu-container > ul > li:hover > a, 
				.rh_mod_sticky_header.sticky_header_custom .menu-main-menu-container > ul > li.current-menu-item > a',
				'property' => 'color',
				'value'    => $theme_modern_sticky_header_menu_text_hover_color,
			),
			array(
				'elements' => '.rh_mod_sticky_header.sticky_header_custom .menu-main-menu-container li .sub-menu',
				'property' => 'border-top-color',
				'value'    => $theme_modern_sticky_header_menu_text_hover_color,
			),
			array(
				'elements' => '.rh_mod_sticky_header.sticky_header_custom .rh_menu__user_submit a, .rh_mod_sticky_header.sticky_header_custom .rh_menu__user_submit a:hover',
				'property' => 'background-color',
				'value'    => $theme_modern_sticky_header_btn_color,
			),
			array(
				'elements' => '.rh_mod_sticky_header.sticky_header_custom .rh_menu__user_submit a:before',
				'property' => 'background-color',
				'value'    => $theme_modern_sticky_header_btn_hover_color,
			),
			array(
				'elements' => '.rh_mod_sticky_header.sticky_header_custom .rh_menu__user_submit a',
				'property' => 'color',
				'value'    => $theme_modern_sticky_header_btn_text_color,
			),
			array(
				'elements' => '.rh_mod_sticky_header.sticky_header_custom .rh_menu__user_submit a:hover',
				'property' => 'color',
				'value'    => $theme_modern_sticky_header_btn_hover_text_color,
			),
			array(
				'elements' => '.rh_mod_sticky_header.sticky_header_custom .rh_logo__heading a',
				'property' => 'color',
				'value'    => $theme_modern_sticky_header_site_title_color,
			),
			array(
				'elements' => '.rh_mod_sticky_header.sticky_header_custom .rh_logo__heading a:hover',
				'property' => 'color',
				'value'    => $theme_modern_sticky_header_site_title_hover_color,
			),
			array(
				'elements' => '.rh_section--props_padding .rh_section__head .rh_section__subtitle',
				'property' => 'color',
				'value'    => $inspiry_home_properties_title_span_color,
			),
			array(
				'elements' => '.rh_section--props_padding .rh_section__head .rh_section__title',
				'property' => 'color',
				'value'    => $inspiry_home_properties_title_color,
			),
			array(
				'elements' => '.rh_section--props_padding .rh_section__head .rh_section__desc',
				'property' => 'color',
				'value'    => $inspiry_home_properties_desc_color,
			),
			array(
				'elements' => '.rh_section--featured .rh_section__head .rh_section__subtitle',
				'property' => 'color',
				'value'    => $theme_featured_prop_title_span_color,
			),
			array(
				'elements' => '.rh_section--featured .rh_section__head .rh_section__title',
				'property' => 'color',
				'value'    => $theme_featured_prop_title_color,
			),
			array(
				'elements' => '.rh_section--featured .rh_section__head .rh_section__desc',
				'property' => 'color',
				'value'    => $theme_featured_prop_text_color,
			),
			array(
				'elements' => '.rh_section__agents .rh_section__head .rh_section__subtitle',
				'property' => 'color',
				'value'    => $inspiry_home_agents_title_span_color,
			),
			array(
				'elements' => '.rh_section__agents .rh_section__head .rh_section__title',
				'property' => 'color',
				'value'    => $inspiry_home_agents_title_color,
			),
			array(
				'elements' => '.rh_section__agents .rh_section__head .rh_section__desc',
				'property' => 'color',
				'value'    => $inspiry_home_agents_desc_color,
			),
			array(
				'elements' => '.rh_cta--featured .rh_cta__title',
				'property' => 'color',
				'value'    => $inspiry_cta_title_color,
			),
			array(
				'elements' => '.rh_cta--featured .rh_cta__quote',
				'property' => 'color',
				'value'    => $inspiry_cta_desc_color,
			),
			array(
				'elements' => '.rh_cta__wrap .rh_cta__btns .rh_btn--secondary',
				'property' => 'color',
				'value'    => $inspiry_cta_btn_one_color,
			),
			array(
				'elements' => '.rh_cta__wrap .rh_cta__btns .rh_btn--secondary',
				'property' => 'background',
				'value'    => inspiry_hex_to_rgba( $inspiry_cta_btn_one_bg, 1 ),
			),
			array(
				'elements' => '.rh_cta__wrap .rh_cta__btns .rh_btn--secondary:hover',
				'property' => 'background',
				'value'    => $inspiry_cta_btn_one_hover_bg,
			),
			array(
				'elements' => '.rh_cta__wrap .rh_cta__btns .rh_btn--greyBG',
				'property' => 'color',
				'value'    => $inspiry_cta_btn_two_color,
			),
			array(
				'elements' => '.rh_cta__wrap .rh_cta__btns .rh_btn--greyBG',
				'property' => 'background',
				'value'    => $inspiry_cta_btn_two_bg_rgba,
			),
			array(
				'elements' => '.rh_cta__wrap .rh_cta__btns .rh_btn--greyBG:hover',
				'property' => 'background',
				'value'    => $inspiry_cta_btn_two_hover_bg,
			),
			array(
				'elements' => '.rh_cta--contact .rh_cta .rh_cta__overlay',
				'property' => 'background-color',
				'value'    => $inspiry_home_cta_bg_color,
			),
			array(
				'elements' => '.rh_cta--contact .rh_cta__title',
				'property' => 'color',
				'value'    => $inspiry_cta_contact_title_color,
			),
			array(
				'elements' => '.rh_cta--contact .rh_cta__quote',
				'property' => 'color',
				'value'    => $inspiry_cta_contact_desc_color,
			),
			array(
				'elements' => '.rh_cta__wrap .rh_cta__btns .rh_btn--blackBG',
				'property' => 'color',
				'value'    => $inspiry_cta_contact_btn_one_color,
			),
			array(
				'elements' => '.rh_cta__wrap .rh_cta__btns .rh_btn--blackBG',
				'property' => 'background',
				'value'    => $inspiry_cta_contact_btn_one_bg,
			),
			array(
				'elements' => '.rh_cta__wrap .rh_cta__btns .rh_btn--blackBG:hover',
				'property' => 'background',
				'value'    => $inspiry_cta_contact_btn_one_hover_bg,
			),
			array(
				'elements' => '.rh_cta__wrap .rh_cta__btns .rh_btn--whiteBG',
				'property' => 'color',
				'value'    => $inspiry_cta_contact_btn_two_color,
			),
			array(
				'elements' => '.rh_cta__wrap .rh_cta__btns .rh_btn--whiteBG',
				'property' => 'background',
				'value'    => $inspiry_cta_contact_btn_two_bg,
			),
			array(
				'elements' => '.rh_cta__wrap .rh_cta__btns .rh_btn--whiteBG:hover',
				'property' => 'background',
				'value'    => $inspiry_cta_contact_btn_two_hover_bg,
			),
			array(
				'elements' => '.rh_testimonial blockquote,
								.rh_section__testimonial .diagonal-mod-background,
								.rh_section__testimonial.flat-border',
				'property' => 'background-color',
				'value'    => $inspiry_testimonial_bg,
			),
			array(
				'elements' => '.rh_testimonial blockquote',
				'property' => 'border-left-color',
				'value'    => $inspiry_testimonial_bg,
			),
			array(
				'elements' => '.rh_latest-properties .diagonal-mod-background,
								.rh_latest-properties.flat-border',
				'property' => 'background-color',
				'value'    => $inspiry_home_properties_bg_color,
			),
			array(
				'elements' => '.rh_section--featured .diagonal-mod-background,
								.rh_section--featured.flat-border',
				'property' => 'background-color',
				'value'    => $inspiry_featured_properties_background_color,
			),
			array(
				'elements' => '.rh_section__testimonial.diagonal-border:before',
				'property' => 'border-bottom-color',
				'value'    => $inspiry_testimonial_bg,
			),
			array(
				'elements' => '.rh_section__testimonial.diagonal-border:after',
				'property' => 'border-top-color',
				'value'    => $inspiry_testimonial_bg,
			),
			array(
				'elements' => '.rh_section__testimonial .quotes-marks svg',
				'property' => 'fill',
				'value'    => $inspiry_testimonial_bg_quote,
			),
			array(
				'elements' => '.rh_testimonial .rh_testimonial__quote',
				'property' => 'color',
				'value'    => $inspiry_testimonial_color,
			),
			array(
				'elements' => '.rh_testimonial .rh_testimonial__author .rh_testimonial__author_name',
				'property' => 'color',
				'value'    => $inspiry_testimonial_name_color,
			),
			array(
				'elements' => '.rh_testimonial .rh_testimonial__author .rh_testimonial__author__link a',
				'property' => 'color',
				'value'    => $inspiry_testimonial_url_color,
			),
			array(
				'elements' => '.rh_agent .rh_agent__details h3 a',
				'property' => 'color',
				'value'    => $inspiry_agents_title_color,
			),
			array(
				'elements' => '.rh_agent .rh_agent__details h3 a:hover',
				'property' => 'color',
				'value'    => $inspiry_agents_title_hover_color,
			),
			array(
				'elements' => '.rh_agent .rh_agent__details .rh_agent__email, .rh_agent .rh_agent__details .rh_agent__listed .heading',
				'property' => 'color',
				'value'    => $inspiry_agents_text_color,
			),
			array(
				'elements' => '.rh_agent .rh_agent__details .rh_agent__phone, .rh_agent .rh_agent__details .rh_agent__email:hover',
				'property' => 'color',
				'value'    => $inspiry_agents_phone_color,
			),
			array(
				'elements' => '.rh_agent .rh_agent__details .rh_agent__listed .figure',
				'property' => 'color',
				'value'    => $inspiry_agents_listed_props_color,
			),
			array(
				'elements' => '.rh_section__agents .diagonal-mod-background,
								.rh_section__agents.flat-border',
				'property' => 'background-color',
				'value'    => $inspiry_home_agents_bg_color,
			),
			array(
				'elements' => '.rh_section__features .rh_section__head .rh_section__subtitle',
				'property' => 'color',
				'value'    => $inspiry_home_features_title_span_color,
			),
			array(
				'elements' => '.rh_section__features .rh_section__head .rh_section__title',
				'property' => 'color',
				'value'    => $inspiry_home_features_title_color,
			),
			array(
				'elements' => '.rh_section__features .rh_section__head .rh_section__desc',
				'property' => 'color',
				'value'    => $inspiry_home_features_desc_color,
			),
			array(
				'elements' => '.rh_feature h4.rh_feature__title, .rh_feature h4.rh_feature__title a',
				'property' => 'color',
				'value'    => $inspiry_home_feature_title_color,
			),
			array(
				'elements' => '.rh_feature .rh_feature__desc p',
				'property' => 'color',
				'value'    => $inspiry_home_feature_text_color,
			),
			array(
				'elements' => '.rh_section__features .diagonal-mod-background,
								.rh_section__features.flat-border',
				'property' => 'background-color',
				'value'    => $inspiry_home_features_background_colors,
			),
			array(
				'elements' => '.rh_section__partners .rh_section__head .rh_section__subtitle',
				'property' => 'color',
				'value'    => $inspiry_home_partners_title_span_color,
			),
			array(
				'elements' => '.rh_section__partners .rh_section__head .rh_section__title',
				'property' => 'color',
				'value'    => $inspiry_home_partners_title_color,
			),
			array(
				'elements' => '.rh_section__partners .rh_section__head .rh_section__desc',
				'property' => 'color',
				'value'    => $inspiry_home_partners_desc_color,
			),
			array(
				'elements' => '.rh_section__partners .diagonal-mod-background,
								.rh_section__partners.flat-border',
				'property' => 'background-color',
				'value'    => $inspiry_home_partners_background_colors,
			),
			array(
				'elements' => '.rh_section__news .rh_section__head .rh_section__subtitle',
				'property' => 'color',
				'value'    => $inspiry_home_news_title_span_color,
			),
			array(
				'elements' => '.rh_section__news .rh_section__head .rh_section__title',
				'property' => 'color',
				'value'    => $inspiry_home_news_title_color,
			),
			array(
				'elements' => '.rh_section__news .rh_section__head .rh_section__desc',
				'property' => 'color',
				'value'    => $inspiry_home_news_desc_color,
			),
			array(
				'elements' => '.rh_section__news .diagonal-mod-background,
								.rh_section__news.flat-border',
				'property' => 'background-color',
				'value'    => $inspiry_home_news_background_colors,
			),
			array(
				'elements' => '.rh_prop_card .rh_prop_card__details, .rh_list_card__wrap .rh_list_card__details_wrap, .rh_list_card__wrap .rh_list_card__map_wrap',
				'property' => 'background-color',
				'value'    => $theme_property_item_bg_color,
			),
			array(
				'elements' => '.rh_prop_card .rh_prop_card__details h3 a, .rh_list_card__wrap .rh_list_card__map_wrap h3 a, .rh_list_card__wrap .rh_list_card__details_wrap h3 a',
				'property' => 'color',
				'value'    => $theme_property_title_color,
			),
			array(
				'elements' => '.rh_prop_card .rh_prop_card__details h3 a:hover, .rh_list_card__wrap .rh_list_card__map_wrap h3 a:hover, .rh_list_card__wrap .rh_list_card__details_wrap h3 a:hover',
				'property' => 'color',
				'value'    => $theme_property_title_hover_color,
			),
			array(
				'elements' => '.rh_prop_card .rh_prop_card__details .rh_prop_card__priceLabel .rh_prop_card__price, .rh_list_card__wrap .rh_list_card__map_details .rh_list_card__priceLabel .rh_list_card__price .price, .rh_list_card__wrap .rh_list_card__priceLabel .rh_list_card__price .price',
				'property' => 'color',
				'value'    => $theme_property_price_text_color,
			),
			array(
				'elements' => '.rh_list_card__wrap .rh_list_card__details_wrap .rh_list_card__excerpt, .rh_prop_card .rh_prop_card__details .rh_prop_card__excerpt',
				'property' => 'color',
				'value'    => $theme_property_desc_text_color,
			),
			array(
				'elements' => '.rh_prop_card .rh_prop_card__details .rh_prop_card__meta .figure, .rh_prop_card .rh_prop_card__details .rh_prop_card__meta .label, .rh_list_card__meta div .label, .rh_list_card__meta div .figure',
				'property' => 'color',
				'value'    => $theme_property_meta_text_color,
			),
			array(
				'elements' => '.rh_prop_card .rh_prop_card__details .rh_prop_card__meta span.rh_meta_titles, 
								.rh_prop_card .rh_prop_card__details .rh_prop_card__priceLabel .rh_prop_card__status, 
								.rh_list_card__wrap .rh_list_card__map_details .rh_list_card__priceLabel .rh_list_card__price .status, 
								.rh_list_card__meta h4, .rh_list_card__wrap .rh_list_card__priceLabel .rh_list_card__price .status, 
								.rh_list_card__wrap .rh_list_card__priceLabel .rh_list_card__author span',
				'property' => 'color',
				'value'    => $inspiry_property_meta_heading_color,
			),
			array(
				'elements' => '.rh_prop_card .rh_prop_card__details .rh_prop_card__meta svg, .rh_list_card__meta div svg',
				'property' => 'fill',
				'value'    => $inspiry_property_meta_icon_color,
			),
			array(
				'elements' => '.rh_overlay',
				'property' => 'background',
				'value'    => $inspiry_property_overlay_rgba,
			),
			array(
				'elements' => '.rh_prop_card .rh_prop_card__thumbnail .rh_overlay__contents a:hover, .rh_list_card__wrap .rh_list_card__thumbnail .rh_overlay__contents a:hover, .rh_list_card__wrap .rh_list_card__map_thumbnail .rh_overlay__contents a:hover',
				'property' => 'color',
				'value'    => $inspiry_property_image_overlay,
			),
			array(
				'elements' => '.rh_label',
				'property' => 'background',
				'value'    => $inspiry_property_featured_label_bg,
			),
			array(
				'elements' => 'div.rh_label span',
				'property' => $featured_label_property,
				'value'    => $inspiry_property_featured_label_bg ? $inspiry_property_featured_label_bg . ' !important' : '',
			),
			array(
				'elements' => '#rh_slider__home .rh_label span',
				'property' => $featured_label_property,
				'value'    => $inspiry_slider_featured_label_bg,
			),
			array(
				'elements' => '.rh_footer',
				'property' => 'background',
				'value'    => $inspiry_footer_bg,
			),
			array(
				'elements' => '.rh_footer:before',
				'property' => 'border-right-color',
				'value'    => $inspiry_footer_bg,
			),
			array(
				'elements' => '.rh_footer a, .rh_footer .rh_footer__wrap .designed-by a, .rh_footer .rh_footer__wrap .copyrights a, .rh_footer .rh_footer__social a',
				'property' => 'color',
				'value'    => $theme_footer_widget_link_color,
			),
			array(
				'elements' => '.rh_footer .Property_Types_Widget li::before, 
								.rh_footer .widget_recent_comments li::before, 
								.rh_footer .widget_recent_entries li::before, 
								.rh_footer .widget_categories li::before, 
								.rh_footer .widget_nav_menu li::before, 
								.rh_footer .widget_archive li::before, 
								.rh_footer .widget_pages li::before, 
								.rh_footer .widget_meta li::before',
				'property' => $is_rtl ? 'border-right-color' : 'border-left-color',
				'value'    => $theme_footer_widget_link_color,
			),
			array(
				'elements' => '.rh_footer a:hover, .rh_footer .rh_contact_widget .rh_contact_widget__item a.content:hover, .rh_footer .rh_footer__wrap .designed-by a:hover, .rh_footer .rh_footer__wrap .copyrights a:hover, .rh_footer .rh_footer__social a:hover',
				'property' => 'color',
				'value'    => $theme_footer_widget_link_hover_color,
			),
			array(
				'elements' => '.rh_footer__widgets .widget .title',
				'property' => 'color',
				'value'    => $theme_footer_widget_title_hover_color,
			),
			array(
				'elements' => '.rh_footer, .rh_footer .rh_footer__logo .tag-line, .rh_footer__widgets .textwidget p, .rh_footer__widgets .textwidget, .rh_footer .rh_footer__wrap .copyrights, .rh_footer .rh_footer__wrap .designed-by, .rh_contact_widget .rh_contact_widget__item .content',
				'property' => 'color',
				'value'    => $theme_footer_widget_text_color,
			),
			array(
				'elements' => '.rh_contact_widget .rh_contact_widget__item .icon svg',
				'property' => 'fill',
				'value'    => $theme_footer_widget_text_color,
			),
			array(
				'elements' => ' .rh_btn--primary, 
				                .rh-btn-primary,
				                .rh_pagination .current,
							    .rh_pagination .rh_pagination__btn:hover,	
							    #scroll-top, 
							    #scroll-top:hover, 
							    #scroll-top:active,		               
								.post-password-form input[type="submit"], 
								.widget .searchform input[type="submit"], 
								.comment-form .form-submit .submit, 
								.rh_memberships__selection .ims-stripe-button .stripe-button-el, 
								.rh_memberships__selection #ims-free-button, 
								.rh_contact__form .wpcf7-form input[type="submit"], 
								.widget_mortgage-calculator .mc-wrapper p input[type="submit"], 
								.rh_memberships__selection .ims-receipt-button #ims-receipt, 
								.rh_contact__form .rh_contact__input input[type="submit"], 
								.rh_form__item input[type="submit"], 
								.rh_pagination__pages-nav a, 
								.rh_prop_search__form .rh_prop_search__buttons .rh_prop_search__searchBtn .rh_btn__prop_search, 
								.rh_modal .rh_modal__wrap button,
								.widget .tagcloud a,
								.inspiry_mod_search_form_smart .rh_prop_search__buttons_smart .rh_prop_search__searchBtn button',
				'property' => 'background',
				'value'    => $theme_button_bg_color,
			),
			array(
				'elements' => ' .rh_btn--primary:hover,
							    .rh-btn-primary:hover, 	
								#scroll-top:before,								
								.post-password-form input[type="submit"]:hover, 
								.widget .searchform input[type="submit"]:hover, 
								.comment-form .form-submit .submit:hover, 
								.rh_memberships__selection .ims-stripe-button .stripe-button-el:hover, 
								.rh_memberships__selection #ims-free-button:hover, 
								.rh_contact__form .wpcf7-form input[type="submit"]:hover, 
								.widget_mortgage-calculator .mc-wrapper p input[type="submit"]:hover, 
								.rh_memberships__selection .ims-receipt-button #ims-receipt:hover, 
								.rh_contact__form .rh_contact__input input[type="submit"]:hover, 
								.rh_form__item input[type="submit"]:hover, .rh_pagination__pages-nav a:hover, 
								.rh_prop_search__form .rh_prop_search__buttons .rh_prop_search__searchBtn .rh_btn__prop_search:hover, 
								.rh_modal .rh_modal__wrap button:hover,
								.widget .tagcloud a:hover,
								.inspiry_mod_search_form_smart .rh_prop_search__buttons_smart .rh_prop_search__searchBtn button:hover',
				'property' => 'background',
				'value'    => $theme_button_hover_bg_color,
			),
			array(
				'elements' => '.rh_btn--primary,
				                .rh-btn-primary,
				                 #scroll-top,  		
				                 .rh_var2_header_meta_container .rh_right_box .rh-btn-primary,	               
								.post-password-form input[type="submit"], 
								.widget .searchform input[type="submit"], 
								.comment-form .form-submit .submit, 
								.rh_memberships__selection .ims-stripe-button .stripe-button-el, 
								.rh_memberships__selection #ims-free-button, 
								.rh_contact__form .wpcf7-form input[type="submit"], 
								.widget_mortgage-calculator .mc-wrapper p input[type="submit"], 
								.rh_memberships__selection .ims-receipt-button #ims-receipt, 
								.rh_contact__form .rh_contact__input input[type="submit"], 
								.rh_form__item input[type="submit"], 
								.rh_pagination__pages-nav a, 
								.rh_prop_search__form .rh_prop_search__buttons .rh_prop_search__searchBtn .rh_btn__prop_search, 
								.rh_modal .rh_modal__wrap button,
								.widget .tagcloud a,
								.inspiry_mod_search_form_smart .rh_prop_search__buttons_smart .rh_prop_search__searchBtn button,
								.success.booking-notice',
				'property' => 'color',
				'value'    => $theme_button_text_color,
			),
			array(
				'elements' => ' .rh_btn--primary:hover, 
				                .rh-btn-primary:hover,	
				                #scroll-top:hover, 
							    #scroll-top:active,		
							    .rh_var2_header_meta_container .rh_right_box .rh-btn-primary:hover,		    
				                .post-password-form input[type="submit"]:hover, 
								.widget .searchform input[type="submit"]:hover, 
								.comment-form .form-submit .submit:hover, 
								.rh_memberships__selection .ims-stripe-button .stripe-button-el:hover, 
								.rh_memberships__selection #ims-free-button:hover, 
								.rh_contact__form .wpcf7-form input[type="submit"]:hover, 
								.widget_mortgage-calculator .mc-wrapper p input[type="submit"]:hover, 
								.rh_memberships__selection .ims-receipt-button #ims-receipt:hover, 
								.rh_contact__form .rh_contact__input input[type="submit"]:hover, 
								.rh_form__item input[type="submit"]:hover, 
								.rh_pagination__pages-nav a:hover, 
								.rh_prop_search__form .rh_prop_search__buttons .rh_prop_search__searchBtn .rh_btn__prop_search:hover, 
								.rh_modal .rh_modal__wrap button:hover,
								.widget .tagcloud a:hover,
								.inspiry_mod_search_form_smart .rh_prop_search__buttons_smart .rh_prop_search__searchBtn button:hover',
				'property' => 'color',
				'value'    => $theme_button_hover_text_color,
			),
			array(
				'elements' => '.rh_var2_header_meta_container .rh-btn-primary, .rh_var3_header .rh-btn-primary',
				'property' => 'border-color',
				'value'    => get_option( 'inspiry_submit_button_border_color' ),
			),
			array(
				'elements' => '.rh_var2_header_meta_container .rh-btn-primary:hover, .rh_var3_header .rh-btn-primary:hover',
				'property' => 'border-color',
				'value'    => get_option( 'inspiry_submit_button_border_hover_color' ),
			),
			array(
				'elements' => '.rh-btn-primary svg, .rh-btn-primary svg path',
				'property' => 'fill',
				'value'    => $theme_button_text_color,
			),
			array(
				'elements' => '.rh-btn-primary:hover svg, .rh-btn-primary:hover svg path',
				'property' => 'fill',
				'value'    => $theme_button_hover_text_color,
			),
			array(
				'elements' => '.rh_prop_search__form .icon-search, .inspiry_mod_search_form_smart .rh_prop_search__buttons_smart .icon-search',
				'property' => 'stroke',
				'value'    => $theme_button_text_color,
			),
			array(
				'elements' => '.rh_prop_search__form .rh_btn__prop_search:hover .icon-search, .inspiry_mod_search_form_smart .rh_prop_search__buttons_smart button:hover .icon-search',
				'property' => 'stroke',
				'value'    => $theme_button_hover_text_color,
			),
			array(
				'elements' => '.rh_prop_search__form .rh_prop_search__buttons .rh_prop_search__searchBtn .rh_btn__prop_search',
				'property' => 'border-bottom-color',
				'value'    => $theme_button_bg_color,
			),
			array(
				'elements' => '.rh_prop_search__form .rh_prop_search__buttons .rh_prop_search__searchBtn .rh_btn__prop_search:hover',
				'property' => 'border-bottom-color',
				'value'    => $theme_button_hover_bg_color,
			),
			array(
				'elements' => '.rh_prop_search__form .rh_prop_search__buttons .rh_prop_search__advance,
								.inspiry_mod_search_form_smart .rh_prop_search__buttons_smart .rh_prop_search__advance a',
				'property' => 'background',
				'value'    => $inspiry_advance_search_btn_bg,
			),
			array(
				'elements' => '.rh_prop_search__form .rh_prop_search__buttons .rh_prop_search__advance a:hover,
								.inspiry_mod_search_form_smart .rh_prop_search__buttons_smart .rh_prop_search__advance a:hover',
				'property' => 'background',
				'value'    => $inspiry_advance_search_btn_hover_bg,
			),
			array(
				'elements' => '.rh_prop_search__form .icon-search-plus,
								.inspiry_mod_search_form_smart .rh_prop_search__buttons_smart .rh_prop_search__advance a .icon-search-plus,
								.inspiry_mod_search_form_smart .rh_prop_search__buttons_smart .rh_prop_search__advance a .rh_icon__search',
				'property' => 'stroke',
				'value'    => $inspiry_advance_search_btn_text,
			),
			array(
				'elements' => '.rh_prop_search__form .rh_prop_search__advance_btn:hover .icon-search-plus,
								.inspiry_mod_search_form_smart .rh_prop_search__buttons_smart .rh_prop_search__advance a:hover .icon-search-plus,
								.inspiry_mod_search_form_smart .rh_prop_search__buttons_smart .rh_prop_search__advance a:hover .rh_icon__search',
				'property' => 'stroke',
				'value'    => $inspiry_advance_search_btn_text_hover,
			),
			array(
				'elements' => '.rh_prop_search__form .rh_prop_search__buttons .rh_prop_search__advance .advance-search-arrow .arrow-inner span',
				'property' => 'color',
				'value'    => $inspiry_advance_search_arrow_and_text,
			),
			array(
				'elements' => '.rh_prop_search__form .rh_prop_search__buttons .rh_prop_search__advance .advance-search-arrow .arrow-inner svg g',
				'property' => 'stroke',
				'value'    => $inspiry_advance_search_arrow_and_text,
			),
			array(
				'elements' => '.rh_gallery__wrap .rh_gallery__item .media_container',
				'property' => 'background',
				'value'    => $inspiry_gallery_hover_color,
			),
			array(
				'elements' => '.rh_blog__post .entry-header',
				'property' => 'background',
				'value'    => $inspiry_post_meta_bg,
			),
			array(
				'elements' => '.rh_blog__post .entry-header .entry-meta',
				'property' => 'color',
				'value'    => get_option( 'inspiry_post_meta_color', '#1a1a1a' ),
			),
			array(
				'elements' => '.rh_blog__post .entry-header .entry-meta a:hover',
				'property' => 'color',
				'value'    => get_option( 'inspiry_post_meta_hover_color', '#fff' ),
			),
			array(
				'elements' => '.rh_slide__desc h3 .title, .rh_slide__desc h3',
				'property' => 'color',
				'value'    => $theme_slide_title_color,
			),
			array(
				'elements' => '.rh_slide__desc h3 .title:hover',
				'property' => 'color',
				'value'    => $theme_slide_title_hover_color,
			),
			array(
				'elements' => '.rh_slide__desc p',
				'property' => 'color',
				'value'    => $theme_slide_desc_text_color,
			),
			array(
				'elements' => '.rh_slide__desc .rh_slide_prop_price span',
				'property' => 'color',
				'value'    => $theme_slide_price_color,
			),
			array(
				'elements' => '.rh_slide__desc .rh_slide__meta_wrap .rh_slide__prop_meta span.rh_meta_titles,
								.rh_slide__desc .rh_slide_prop_price .rh_price_sym',
				'property' => 'color',
				'value'    => $inspiry_slider_meta_heading_color,
			),
			array(
				'elements' => '.rh_slide__desc .rh_slide__meta_wrap .rh_slide__prop_meta div span',
				'property' => 'color',
				'value'    => $inspiry_slider_meta_text_color,
			),
			array(
				'elements' => '.rh_slide__prop_meta .rh_svg',
				'property' => 'fill',
				'value'    => $inspiry_slider_meta_icon_color,
			),
			array(
				'elements' => '.rh_slide__desc .rh_label',
				'property' => 'background',
				'value'    => $inspiry_slider_featured_label_bg,
			),
			array(
				'elements' => '.rh_slide__desc .rh_label span',
				'property' => $slider_featured_label_property,
				'value'    => $inspiry_slider_featured_label_bg,
			),

			array(
				'elements' => '.rh_temp_header_responsive_view.rh_header',
				'property' => 'background',
				'value'    => $theme_responsive_header_bg_color,
			),
			array(
				'elements' => '.rh_temp_header_responsive_view .rh_logo__heading a',
				'property' => 'color',
				'value'    => $theme_logo_responsive_text_color,
			),
			array(
				'elements' => '.rh_temp_header_responsive_view .rh_menu__user_phone .contact-number',
				'property' => 'color',
				'value'    => $theme_responsive_phone_text_color,
			),
			array(
				'elements' => '.rh_temp_header_responsive_view .rh_menu__user_phone svg',
				'property' => 'fill',
				'value'    => $theme_responsive_phone_text_color,
			),
			array(
				'elements' => '.rh_temp_header_responsive_view .rh_menu__user_phone:hover .contact-number',
				'property' => 'color',
				'value'    => $theme_responsive_phone_text_color_hover,
			),
			array(
				'elements' => '.rh_temp_header_responsive_view .rh_menu__user_phone:hover svg',
				'property' => 'fill',
				'value'    => $theme_responsive_phone_text_color_hover,
			),
			array(
				'elements' => '.rh_temp_header_responsive_view .rh_menu__user_submit a, .rh_temp_header_responsive_view .rh_menu__user_submit a:hover',
				'property' => 'background',
				'value'    => $theme_responsive_submit_button_bg,
			),
			array(
				'elements' => '.rh_temp_header_responsive_view .rh_menu__user_submit a:before',
				'property' => 'background',
				'value'    => $theme_responsive_submit_button_bg_hover,
			),
			array(
				'elements' => '.rh_temp_header_responsive_view .rh_menu__user_submit a',
				'property' => 'color',
				'value'    => $theme_responsive_submit_button_color,
			),
			array(
				'elements' => '.rh_temp_header_responsive_view .rh_menu__user_submit a:hover',
				'property' => 'color',
				'value'    => $theme_responsive_submit_button_color_hover,
			),
			array(
				'elements' => '.hamburger-inner, .hamburger-inner::before, .hamburger-inner::after',
				'property' => 'background-color',
				'value'    => $theme_responsive_menu_icon_color,
			),
			array(
				'elements' => '.rh_menu__responsive',
				'property' => 'background-color',
				'value'    => $theme_responsive_menu_bg_color,
			),
			array(
				'elements' => '.rh_menu__responsive ul.sub-menu',
				'property' => 'background-color',
				'value'    => inspiry_hex_darken( $theme_responsive_menu_bg_color, 4 ),
			),
			array(
				'elements' => '.rh_menu__responsive ul.sub-menu ul.sub-menu',
				'property' => 'background-color',
				'value'    => inspiry_hex_darken( $theme_responsive_menu_bg_color, 6 ),
			),
			array(
				'elements' => '.rh_menu__responsive li a,
							   .rh_menu__responsive .rh_menu__indicator',
				'property' => 'color',
				'value'    => $theme_responsive_menu_text_color,
			),
			array(
				'elements' => '.rh_menu__responsive li a:hover',
				'property' => 'color',
				'value'    => $theme_responsive_menu_text_hover_color,
			),
			array(
				'elements' => '.rh_prop_search__form .rh_prop_search__buttons .rh_prop_search__searchBtn .rh_btn__prop_search,
				.rh_prop_search__form .rh_prop_search__fields .inspiry_bs_is_open,
				.rh_prop_search__form .rh_prop_search__fields .inspiry_bs_is_open .inspiry_select_picker_trigger button.dropdown-toggle,
				.rh_prop_search__form .rh_prop_search__fields .inspiry_select_picker_field .inspiry_select_picker_trigger div.dropdown-menu,
				.inspiry_mod_search_form_smart .rh_prop_search__buttons_smart .rh_prop_search__searchBtn button,
				.inspiry_mod_search_form_smart .rh_prop_search__buttons_smart .rh_prop_search__advance a,
				.rtl .rh_cfos .cfos_phone_icon:before, .rh_prop_search__form_smart .rh_form_smart_top_fields .inspiry_select_picker_trigger.open button.dropdown-toggle,
				.rh_prop_search__form_smart .inspiry_select_picker_trigger div.dropdown-menu,
				.rh_prop_search__form_smart .inspiry_select_picker_trigger.open button.dropdown-toggle,
				form.rh_sfoi_advance_search_form .inspiry_bs_is_open,
				form.rh_sfoi_advance_search_form .inspiry_select_picker_trigger div.dropdown-menu,
				.rh_mode_sfoi_search_btn button
				',
				'property' => 'background',
				'value'    => $inspiry_search_form_primary_color,
			),
			array(
				'elements' => '.rh_prop_search__form_smart .inspiry_select_picker_trigger.open button.dropdown-toggle
				',
				'property' => 'border-color',
				'value'    => $inspiry_search_form_primary_color,
			),
			array(
				'elements' => '.rtl .rh_cfos .cfos_phone_icon:before, .rh_prop_search__form_smart .rh_form_smart_top_fields .inspiry_select_picker_trigger.open button.dropdown-toggle
				',
				'property' => 'border-right-color',
				'value'    => $inspiry_search_form_primary_color,
			),
			array(
				'elements' => '.inspiry_mod_search_form_smart .rh_prop_search__wrap_smart .open_more_features
				',
				'property' => 'color',
				'value'    => $inspiry_search_form_primary_color,
			),
			array(
				'elements' => '.rh_prop_search__form .rh_prop_search__buttons .rh_prop_search__searchBtn .rh_btn__prop_search:hover,
								span.open_more_features.featured-open,
								span.open_more_features:hover',
				'property' => 'background',
				'value'    => $inspiry_search_form_secondary_color,
			),
			array(
				'elements' => '.rh_prop_search__form .rh_prop_search__buttons div.rh_prop_search__advance,
				span.open_more_features,
				.inspiry_mod_search_form_smart .rh_prop_search__buttons_smart .rh_prop_search__searchBtn button:hover,
				.rh_mode_sfoi_search_btn button:hover,
				 div.rh_mod_sfoi_advanced_expander',
				'property' => 'background-color',
				'value'    => inspiry_hex_darken( $inspiry_search_form_primary_color, 4 ),
			),
			array(
				'elements' => '.rh_prop_search__form .rh_prop_search__buttons div.rh_prop_search__advance a:hover, 
				div.rh_mod_sfoi_advanced_expander:hover, 
				.rh_prop_search__form .rh_prop_search__fields .inspiry_select_picker_field .inspiry_select_picker_trigger div.dropdown-menu li.selected,
				.rh_prop_search__form .rh_prop_search__fields .inspiry_select_picker_field .inspiry_select_picker_trigger div.dropdown-menu li:hover,
				div.rh_mod_sfoi_advanced_expander.rh_sfoi_is_open,
				.rh_prop_search__form .rh_prop_search__fields .inspiry_select_picker_field .inspiry_select_picker_trigger div.dropdown-menu .actions-btn:hover,
				.rh_prop_search__form_smart .inspiry_select_picker_trigger div.dropdown-menu li.no-results,
				.rh_prop_search__form_smart .inspiry_select_picker_trigger div.dropdown-menu li.selected a,
				.rh_prop_search__form_smart .inspiry_select_picker_trigger div.dropdown-menu li:hover a,
				.rh_prop_search__form_smart .inspiry_select_picker_trigger .bs-actionsbox .btn-block .bs-select-all:hover,
				.rh_prop_search__form_smart .inspiry_select_picker_trigger .bs-actionsbox .btn-block .bs-deselect-all:hover,
				form.rh_sfoi_advance_search_form .inspiry_select_picker_trigger div.dropdown-menu li.selected,
				form.rh_sfoi_advance_search_form .inspiry_select_picker_trigger div.dropdown-menu li:hover,
				form.rh_sfoi_advance_search_form .inspiry_select_picker_trigger div.dropdown-menu .actions-btn:hover,
				.rh_mod_sfoi_advanced_expander.rh_sfoi_is_open
				',
				'property' => 'background-color',
				'value'    => inspiry_hex_darken( $inspiry_search_form_primary_color, 8 ),
			),
			array(
				'elements' => '.rh_prop_search__form .rh_prop_search__fields .inspiry_select_picker_field .inspiry_select_picker_trigger div.dropdown-menu ::-webkit-scrollbar-thumb,
				.rh_prop_search__form_smart .inspiry_select_picker_trigger div.dropdown-menu ::-webkit-scrollbar-thumb,
				form.rh_sfoi_advance_search_form .inspiry_select_picker_trigger div.dropdown-menu ::-webkit-scrollbar-thumb,
				.rh_sfoi_advance_search_form .inspiry_select_picker_trigger div.dropdown-menu ::-webkit-scrollbar-thumb
				 ',
				'property' => 'outline-color',
				'value'    => inspiry_hex_darken( $inspiry_search_form_primary_color, 8 ),
			),
			array(
				'elements' => '.rh_prop_search__form .rh_prop_search__fields .inspiry_select_picker_field .inspiry_select_picker_trigger div.dropdown-menu ::-webkit-scrollbar-thumb,
				.rh_prop_search__form_smart .inspiry_select_picker_trigger div.dropdown-menu ::-webkit-scrollbar-thumb,
				form.rh_sfoi_advance_search_form .inspiry_select_picker_trigger div.dropdown-menu ::-webkit-scrollbar-thumb
				',
				'property' => 'background-color',
				'value'    => inspiry_hex_darken( $inspiry_search_form_primary_color, 8 ),
			),
			array(
				'elements' => '.rh_prop_search__form .rh_prop_search__fields .inspiry_select_picker_field .inspiry_select_picker_trigger div.dropdown-menu ::-webkit-scrollbar-track,
				 form.rh_sfoi_advance_search_form .inspiry_select_picker_trigger div.dropdown-menu ::-webkit-scrollbar-track, 
				 form.rh_prop_search__form_smart .inspiry_select_picker_trigger div.dropdown-menu ::-webkit-scrollbar-track,
				 form.rh_sfoi_advance_search_form .inspiry_select_picker_trigger div.dropdown-menu ::-webkit-scrollbar-track
				',
				'property' => 'box-shadow',
				'value'    => ' inset 0 0 6px ' . inspiry_hex_darken( $inspiry_search_form_primary_color, 8 ),
			),
			array(
				'elements' => '
				.rh_prop_search__form .rh_prop_search__buttons .rh_prop_search__searchBtn .rh_btn__prop_search,
				.rh_prop_search__form .rh_prop_search__buttons .rh_prop_search__searchBtn .rh_btn__prop_search:hover,
				.rh_prop_search__form .rh_prop_search__fields .inspiry_bs_is_open label,
				.rh_prop_search__form .rh_prop_search__fields .inspiry_bs_is_open .inspiry_select_picker_trigger button.dropdown-toggle,
				.rh_prop_search__form .rh_prop_search__fields .inspiry_select_picker_field .inspiry_select_picker_trigger div.dropdown-menu li a,
				.rh_prop_search__form .rh_prop_search__fields .inspiry_select_picker_field .inspiry_select_picker_trigger .form-control,
				.inspiry_mod_search_form_smart .rh_prop_search__buttons_smart .rh_prop_search__searchBtn button,
				.inspiry_mod_search_form_smart .rh_prop_search__buttons_smart .rh_prop_search__searchBtn button:hover,
				.rh_prop_search__form_smart .inspiry_select_picker_trigger.open button.dropdown-toggle,
				.rh_prop_search__form_smart .inspiry_select_picker_trigger div.dropdown-menu li a,
				.rh_prop_search__form_smart .inspiry_select_picker_trigger div.dropdown-menu li.selected a,
				.rh_prop_search__form_smart .inspiry_select_picker_trigger div.dropdown-menu li.no-results,
				span.open_more_features,
				.rh_mode_sfoi_search_btn button,
				.rh_mode_sfoi_search_btn button:hover,
				form.rh_sfoi_advance_search_form .inspiry_select_picker_trigger div.dropdown-menu li a,
				form.rh_sfoi_advance_search_form .inspiry_select_picker_trigger .form-control
				',
				'property' => 'color',
				'value'    => $inspiry_search_form_active_text,
			),
			array(
				'elements' => '.rh_prop_search__form_smart .inspiry_select_picker_trigger .form-control,
				form.rh_sfoi_advance_search_form .inspiry_bs_is_open label
				',
				'property' => 'color',
				'value'    => $inspiry_search_form_active_text . '!important',
			),
			array(
				'elements' => '.rh_prop_search__form .rh_prop_search__fields .inspiry_select_picker_field .inspiry_select_picker_trigger .form-control,
				.rh_prop_search__form .rh_prop_search__fields .inspiry_select_picker_field .inspiry_select_picker_trigger div.dropdown-menu .btn-block,
				.rh_prop_search__form_smart .inspiry_select_picker_trigger .form-control,
				form.rh_sfoi_advance_search_form .inspiry_select_picker_trigger .form-control,
				.rh_prop_search__form_smart .inspiry_select_picker_trigger > .dropdown-menu .btn-block,
				form.rh_sfoi_advance_search_form .inspiry_select_picker_trigger div.dropdown-menu .btn-block
				',
				'property' => 'border-color',
				'value'    => $inspiry_search_form_active_text,
			),
			array(
				'elements' => '.rh_prop_search__form_smart .inspiry_select_picker_trigger .form-control
				',
				'property' => 'border-color',
				'value'    => $inspiry_search_form_active_text . '!important',
			),
			array(
				'elements' => '.rh_prop_search__form .rh_prop_search__fields .inspiry_bs_is_open .inspiry_select_picker_trigger button.dropdown-toggle .caret,
				.rh_prop_search__form_smart .inspiry_select_picker_trigger.open span.caret,
				form.rh_sfoi_advance_search_form .inspiry_bs_is_open .inspiry_select_picker_trigger button.dropdown-toggle span.caret
				',
				'property' => 'border-top-color',
				'value'    => $inspiry_search_form_active_text,
			),
			array(
				'elements' => '	.rh_prop_search__form .rh_btn__prop_search .icon-search, 
				.inspiry_mod_search_form_smart .rh_prop_search__buttons_smart button .icon-search,
				.rh_prop_search__form .rh_btn__prop_search:hover .icon-search, 
				.inspiry_mod_search_form_smart .rh_prop_search__buttons_smart button:hover .icon-search,
				form.rh_sfoi_advance_search_form .icon-search,
				.icon-search-plus,
				.rh_prop_search__form .rh_prop_search__fields .inspiry_select_picker_field .inspiry_select_picker_trigger div.dropdown-menu .actions-btn svg .rh-st0,
				.rh_prop_search__form_smart .inspiry_select_picker_trigger .bs-actionsbox .btn-block .bs-deselect-all .inspiry_bs_deselect svg .rh-st0,
				.rh_prop_search__form_smart .inspiry_select_picker_trigger .bs-actionsbox .btn-block .bs-deselect-all:hover .inspiry_bs_deselect svg .rh-st0,
				form.rh_sfoi_advance_search_form .inspiry_select_picker_trigger div.dropdown-menu .actions-btn svg .rh-st0
				',
				'property' => 'stroke',
				'value'    => $inspiry_search_form_active_text,
			),
			array(
				'elements' => 'form.rh_prop_search__form .rh_prop_search__fields .inspiry_select_picker_field .inspiry_select_picker_trigger div.dropdown-menu .actions-btn svg,
				.rh_prop_search__form .rh_prop_search__fields .inspiry_select_picker_field .inspiry_select_picker_trigger div.dropdown-menu .actions-btn:hover svg,
				.rh_prop_search__form_smart .inspiry_select_picker_trigger .bs-actionsbox .btn-block .bs-select-all .inspiry_bs_select svg,
				.rh_prop_search__form_smart .inspiry_select_picker_trigger .bs-actionsbox .btn-block .bs-select-all:hover .inspiry_bs_select svg,
				form.rh_sfoi_advance_search_form .inspiry_select_picker_trigger div.dropdown-menu .actions-btn svg,
				form.rh_sfoi_advance_search_form .inspiry_select_picker_trigger div.dropdown-menu .actions-btn:hover svg
				',
				'property' => 'fill',
				'value'    => $inspiry_search_form_active_text,
			),

		);

		if ( ! empty( $inspiry_top_menu_gradient_color ) ) {
			$gradient_staring = inspiry_hex_to_rgba( $inspiry_top_menu_gradient_color, .7 );
		} else {
			$gradient_staring = 'rgba(0, 0, 0, 0.7)';
		}
		$dynamic_css[] = array(
			'elements' => '.rh_header--shadow',
			'property' => 'background',
			'value'    => 'linear-gradient(180deg,' . $gradient_staring . '0%, rgba(255, 255, 255, 0) 100%);',
		);

		if ( ! empty( $core_orange_color ) ) {
			$dynamic_css[] = array(
				'elements' => '.cls-1',
				'property' => 'fill',
				'value'    => $core_orange_color . '!important',
			);
		}

		if ( ! empty( $core_green_color ) ) {
			$dynamic_css[] = array(
				'elements' => '#ihf-main-container .ihf-select-options .ihf-select-available-option>span.ihf-selected, .ihf-eureka .ihf-select-options .ihf-select-available-option>span.ihf-selected,
				#ihf-main-container .btn-primary, #ihf-main-container .btn.btn-default, #ihf-main-container .ihf-btn.ihf-btn-primary, .ihf-eureka .btn-primary, .ihf-eureka .btn.btn-default, .ihf-eureka .ihf-btn.ihf-btn-primary',
				'property' => 'background-color',
				'value'    => $core_green_color . ' !important',
			);
			$dynamic_css[] = array(
				'elements' => '#ihf-main-container .btn-primary, #ihf-main-container .btn.btn-default,#ihf-main-container .ihf-btn.ihf-btn-primary, .ihf-eureka .btn-primary, .ihf-eureka .btn.btn-default, .ihf-eureka .ihf-btn.ihf-btn-primary',
				'property' => 'border-color',
				'value'    => $core_green_color . ' !important',
			);
			$dynamic_css[] = array(
				'elements' => '#ihf-main-container .ihf-detail-tab-content #ihf-detail-features-tab .title-bar-1',
				'property' => 'background-color',
				'value'    => $core_green_color . ' !important',
			);
		}

		if ( ! empty( $body_bg ) ) {
			$dynamic_css[] = array(
				'elements' => '.rh_section--props_padding:after,.rh_section__agents:after',
				'property' => 'border-left-color',
				'value'    => '#' . $body_bg,
			);
			$dynamic_css[] = array(
				'elements' => '.rh_section__agents:before',
				'property' => 'border-right-color',
				'value'    => '#' . $body_bg,
			);
		}

		if ( ! empty( $core_green_color ) ) {
			$dynamic_css[] = array(
				'elements' => '#ihf-main-container .btn-primary:active, #ihf-main-container .btn-primary:focus, #ihf-main-container .btn-primary:hover, #ihf-main-container .btn.btn-default:active, #ihf-main-container .btn.btn-default:focus, #ihf-main-container .btn.btn-default:hover, #ihf-main-container .ihf-btn.ihf-btn-primary:active, #ihf-main-container .ihf-btn.ihf-btn-primary:focus, #ihf-main-container .ihf-btn.ihf-btn-primary:hover, .ihf-eureka .btn-primary:active, .ihf-eureka .btn-primary:focus, .ihf-eureka .btn-primary:hover, .ihf-eureka .btn.btn-default:active, .ihf-eureka .btn.btn-default:focus, .ihf-eureka .btn.btn-default:hover, .ihf-eureka .ihf-btn.ihf-btn-primary:active, .ihf-eureka .ihf-btn.ihf-btn-primary:focus, .ihf-eureka .ihf-btn.ihf-btn-primary:hover',
				'property' => 'background-color',
				'value'    => $core_green_dark_color . ' !important',
			);
			$dynamic_css[] = array(
				'elements' => '#ihf-main-container .btn-primary:active, #ihf-main-container .btn-primary:focus, #ihf-main-container .btn-primary:hover, #ihf-main-container .btn.btn-default:active, #ihf-main-container .btn.btn-default:focus, #ihf-main-container .btn.btn-default:hover, #ihf-main-container .ihf-btn.ihf-btn-primary:active, #ihf-main-container .ihf-btn.ihf-btn-primary:focus, #ihf-main-container .ihf-btn.ihf-btn-primary:hover, .ihf-eureka .btn-primary:active, .ihf-eureka .btn-primary:focus, .ihf-eureka .btn-primary:hover, .ihf-eureka .btn.btn-default:active, .ihf-eureka .btn.btn-default:focus, .ihf-eureka .btn.btn-default:hover, .ihf-eureka .ihf-btn.ihf-btn-primary:active, .ihf-eureka .ihf-btn.ihf-btn-primary:focus, .ihf-eureka .ihf-btn.ihf-btn-primary:hover',
				'property' => 'border-color',
				'value'    => $core_green_dark_color . ' !important',
			);
		}

		if ( empty( $inspiry_advance_search_btn_bg ) ) {
			$dynamic_css[] = array(
				'elements' => '.rh_prop_search__form .rh_prop_search__buttons .rh_prop_search__advance,
								.rh_mod_sfoi_advanced_expander',
				'property' => 'background-color',
				'value'    => inspiry_hex_darken( $core_green_color, 4 ),
			);
		}

		if ( empty( $inspiry_advance_search_btn_hover_bg ) ) {
			$dynamic_css[] = array(
				'elements' => '.rh_prop_search__form .rh_prop_search__buttons .rh_prop_search__advance a:hover,
								.rh_mod_sfoi_advanced_expander:hover,
								.rh_mod_sfoi_advanced_expander.rh_sfoi_is_open',
				'property' => 'background-color',
				'value'    => inspiry_hex_darken( $core_green_color, 8 ),
			);
		}


		/* Property labels background color */
		$dynamic_css_above_320px  = array();
		$dynamic_css_above_480px  = array();
		$dynamic_css_above_768px  = array();
		$dynamic_css_above_1024px = array(
			array(
				'elements' => '.open_more_features.featured-open',
				'property' => 'background',
				'value'    => $core_green_dark_color,
			),
		);
		$dynamic_css_above_1140px = array();
		$dynamic_css_above_1280px = array();

		$prop_count = count( $dynamic_css );
		if ( $prop_count > 0 ) {

			foreach ( $dynamic_css as $css_unit ) {
				if ( ! empty( $css_unit['value'] ) ) {
					$realhomes_modern_custom_css .= strip_tags( $css_unit['elements'] . " { " . $css_unit['property'] . " : " . $css_unit['value'] . ";" . " }\n" );
				}
			}

			/* CSS For min-width: 320px */
			if ( ! empty( $dynamic_css_above_320px ) ) {
				$realhomes_modern_custom_css .= "@media ( min-width: 320px ) {\n";
				foreach ( $dynamic_css_above_320px as $css_unit ) {
					if ( ! empty( $css_unit['value'] ) ) {
						$realhomes_modern_custom_css .= strip_tags( $css_unit['elements'] . " { " . $css_unit['property'] . " : " . $css_unit['value'] . ";" . " }\n" );
					}
				}
				$realhomes_modern_custom_css .= "}\n";
			}

			/* CSS For min-width: 480px */
			if ( ! empty( $dynamic_css_above_480px ) ) {
				$realhomes_modern_custom_css .= "@media ( min-width: 480px ) {\n";
				foreach ( $dynamic_css_above_480px as $css_unit ) {
					if ( ! empty( $css_unit['value'] ) ) {
						$realhomes_modern_custom_css .= strip_tags( $css_unit['elements'] . " { " . $css_unit['property'] . " : " . $css_unit['value'] . ";" . " }\n" );
					}
				}
				$realhomes_modern_custom_css .= "}\n";
			}

			/* CSS For min-width: 768px */
			if ( ! empty( $dynamic_css_above_768px ) ) {
				$realhomes_modern_custom_css .= "@media ( min-width: 768px ) {\n";
				foreach ( $dynamic_css_above_768px as $css_unit ) {
					if ( ! empty( $css_unit['value'] ) ) {
						$realhomes_modern_custom_css .= strip_tags( $css_unit['elements'] . " { " . $css_unit['property'] . " : " . $css_unit['value'] . ";" . " }\n" );
					}
				}
				$realhomes_modern_custom_css .= "}\n";
			}

			/* CSS For min-width: 1024px */
			if ( ! empty( $dynamic_css_above_1024px ) ) {
				$realhomes_modern_custom_css .= "@media ( min-width: 1024px ) {\n";
				foreach ( $dynamic_css_above_1024px as $css_unit ) {
					if ( ! empty( $css_unit['value'] ) ) {
						$realhomes_modern_custom_css .= strip_tags( $css_unit['elements'] . " { " . $css_unit['property'] . " : " . $css_unit['value'] . ";" . " }\n" );
					}
				}
				$realhomes_modern_custom_css .= "}\n";
			}

			/* CSS For min-width: 1140px */
			if ( ! empty( $dynamic_css_above_1140px ) ) {
				$realhomes_modern_custom_css .= "@media ( min-width: 1140px ) {\n";
				foreach ( $dynamic_css_above_1140px as $css_unit ) {
					if ( ! empty( $css_unit['value'] ) ) {
						$realhomes_modern_custom_css .= strip_tags( $css_unit['elements'] . " { " . $css_unit['property'] . " : " . $css_unit['value'] . ";" . " }\n" );
					}
				}
				$realhomes_modern_custom_css .= "}\n";
			}

			/* CSS For min-width: 1280px */
			if ( ! empty( $dynamic_css_above_1280px ) ) {
				$realhomes_modern_custom_css .= "@media ( min-width: 1280px ) {\n";
				foreach ( $dynamic_css_above_1280px as $css_unit ) {
					if ( ! empty( $css_unit['value'] ) ) {
						$realhomes_modern_custom_css .= strip_tags( $css_unit['elements'] . " { " . $css_unit['property'] . " : " . $css_unit['value'] . ";" . " }\n" );
					}
				}
				$realhomes_modern_custom_css .= "}\n";
			}
		}

		return $realhomes_modern_custom_css;
	}
}

add_filter( 'realhomes_modern_custom_css', 'inspiry_generate_dynamic_css' );