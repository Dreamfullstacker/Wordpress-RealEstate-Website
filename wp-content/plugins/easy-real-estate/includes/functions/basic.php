<?php
/**
 * Contains Basic Functions for Easy Real Estate plugin.
 */

/**
 * Get template part for ERE plugin.
 *
 * @access public
 *
 * @param mixed $slug Template slug.
 * @param string $name Template name (default: '').
 */
function ere_get_template_part( $slug, string $name = '' ) {
	$template = '';

	// Get slug-name.php.
	if ( $name && file_exists( ERE_PLUGIN_DIR . "/{$slug}-{$name}.php" ) ) {
		$template = ERE_PLUGIN_DIR . "/{$slug}-{$name}.php";
	}

	// Get slug.php.
	if ( ! $template && file_exists( ERE_PLUGIN_DIR . "/{$slug}.php" ) ) {
		$template = ERE_PLUGIN_DIR . "/{$slug}.php";
	}

	// Allow 3rd party plugins to filter template file from their plugin.
	$template = apply_filters( 'ere_get_template_part', $template, $slug, $name );

	if ( $template ) {
		load_template( $template, false );
	}
}

if ( ! function_exists( 'ere_log' ) ) {
	/**
	 * Function to help in debugging
	 *
	 * @param $message
	 */
	function ere_log( $message ) {
		if ( WP_DEBUG === true ) {
			if ( is_array( $message ) || is_object( $message ) ) {
				error_log( print_r( $message, true ) );
			} else {
				error_log( $message );
			}
		}
	}
}

if ( ! function_exists( 'ere_exclude_CPT_meta_keys_from_rest_api' ) ) {

	add_filter( 'ere_property_rest_api_meta', 'ere_exclude_CPT_meta_keys_from_rest_api' );
	add_filter( 'ere_agency_rest_api_meta', 'ere_exclude_CPT_meta_keys_from_rest_api' );
	add_filter( 'ere_agent_rest_api_meta', 'ere_exclude_CPT_meta_keys_from_rest_api' );

	function ere_exclude_CPT_meta_keys_from_rest_api( $post_meta ) {

		$exclude_keys = array(
			//'_thumbnail_id',
			'_vc_post_settings',
			'_dp_original',
			'_edit_lock',
			'_wp_old_slug',
			'slide_template',
			'REAL_HOMES_banner_sub_title',
		);

		// excluding keys
		foreach ( $exclude_keys as $key ) {
			if ( key_exists( $key, $post_meta ) ) {
				unset( $post_meta[ $key ] );
			}
		}

		// return the post meta
		return $post_meta;
	}
}

if ( ! function_exists( 'ere_get_current_user_ip' ) ) {
	/**
	 * Return current user IP
	 *
	 * @return string|string[]|null
	 */
	function ere_get_current_user_ip() {
		return preg_replace( '/[^0-9a-fA-F:., ]/', '', $_SERVER['REMOTE_ADDR'] );
	}
}

if ( ! function_exists( 'ere_generate_posts_list' ) ) {
	/**
	 * Generates options list for given post arguments
	 *
	 * @param $post_args
	 * @param int $selected
	 */
	function ere_generate_posts_list( $post_args, $selected = 0 ) {

		$defaults = array( 'posts_per_page' => -1, 'suppress_filters' => true );

		if ( is_array( $post_args ) ) {
			$post_args = wp_parse_args( $post_args, $defaults );
		} else {
			$post_args = wp_parse_args( array( 'post_type' => $post_args ), $defaults );
		}

		$posts = get_posts( $post_args );

		if ( isset( $selected ) && is_array( $selected ) ) {
			foreach ( $posts as $post ) :
				?><option value="<?php echo esc_attr( $post->ID ); ?>" <?php if ( in_array( $post->ID, $selected ) ) { echo "selected"; } ?>><?php echo esc_html( $post->post_title ); ?></option><?php
			endforeach;
		} else {
			foreach ( $posts as $post ) :
				?><option value="<?php echo esc_attr( $post->ID ); ?>" <?php if ( isset( $selected ) && ( $selected == $post->ID ) ) { echo "selected"; } ?>><?php echo esc_html( $post->post_title ); ?></option><?php
			endforeach;
		}
	}
}

if ( ! function_exists( 'ere_display_property_label' ) ) {
	/**
	 * Display property label
	 *
	 * @param $post_id
	 */
	function ere_display_property_label( $post_id ) {

		$label_text = get_post_meta( $post_id, 'inspiry_property_label', true );
		$color      = get_post_meta( $post_id, 'inspiry_property_label_color', true );
		if ( ! empty ( $label_text ) ) {
			?>
            <span <?php if ( ! empty( $color ) ){ ?>style="background: <?php echo esc_attr( $color ); ?>"<?php } ?>
                  class='property-label'><?php echo esc_html( $label_text ); ?></span>
			<?php

		}
	}
}

if ( ! function_exists( 'ere_include_compare_icon' ) ) {
	/**
	 * Include compare icon
	 */
	function ere_include_compare_icon() {

		if ( defined( 'INSPIRY_THEME_DIR' ) ) {
			include( INSPIRY_THEME_DIR . '/images/icons/icon-compare.svg' );
		} else {
			include( ERE_PLUGIN_DIR . '/images/icons/icon-compare.svg' );
        }

	}
}

if ( ! function_exists( 'ere_framework_excerpt' ) ) {
	/**
	 * Output custom excerpt of required length
	 *
	 * @param int $len number of words
	 * @param string $trim string to appear after excerpt
	 */
	function ere_framework_excerpt( $len = 15, $trim = "&hellip;" ) {
		echo ere_get_framework_excerpt( $len, $trim );
	}
}

if ( ! function_exists( 'ere_get_framework_excerpt' ) ) {
	/**
	 * Returns custom excerpt of required length
	 *
	 * @param int $len number of words
	 * @param string $trim string after excerpt
	 *
	 * @return array|string
	 */
	function ere_get_framework_excerpt( $len = 15, $trim = "&hellip;" ) {
		$limit     = $len + 1;
		$excerpt   = explode( ' ', get_the_excerpt(), $limit );
		$num_words = count( $excerpt );
		if ( $num_words >= $len ) {
			array_pop( $excerpt );
		} else {
			$trim = "";
		}
		$excerpt = implode( " ", $excerpt ) . "$trim";

		return $excerpt;
	}
}

if ( ! function_exists( 'ere_social_networks' ) ) {
	/**
	 * Print social networks
	 *
	 * @param array $args Optional. Arguments to change container and icon classes.
	 *
	 * @return string
	 */
	function ere_social_networks( $args = array() ) {

	    // Return if social menu display options is disabled.
		if ( 'true' !== get_option( 'theme_show_social_menu', 'false' ) ) {
			return false;
		}

		$defaults = array(
			'echo'            => 1,
			'container'       => 'ul',
			'container_class' => 'social_networks clearfix',
			'icon_size_class' => 'fa-lg',
			'replace_icons'   => array(),
			'link_target'     => '_blank',
		);

		$args = wp_parse_args( $args, $defaults );

		$default_social_networks = array(
			'facebook'  => array(
				'url'  => get_option( 'theme_facebook_link' ),
				'icon' => 'fab fa-facebook-square'
			),
			'twitter'   => array(
				'url'  => get_option( 'theme_twitter_link' ),
				'icon' => 'fab fa-twitter'
			),
			'linkedin'  => array(
				'url'  => get_option( 'theme_linkedin_link' ),
				'icon' => 'fab fa-linkedin'
			),
			'instagram' => array(
				'url'  => get_option( 'theme_instagram_link' ),
				'icon' => 'fab fa-instagram'
			),
			'pinterest' => array(
				'url'  => get_option( 'theme_pinterest_link' ),
				'icon' => 'fab fa-pinterest'
			),
			'youtube'   => array(
				'url'  => get_option( 'theme_youtube_link' ),
				'icon' => 'fab fa-youtube'
			),
			'skype'     => array(
				'url'  => get_option( 'theme_skype_username' ),
				'icon' => 'fab fa-skype'
			),
			'rss'       => array(
				'url'  => get_option( 'theme_rss_link' ),
				'icon' => 'fas fa-rss'
			),
			'line'      => array(
				'url'  => get_option( 'theme_line_id' ),
				'icon' => 'fab fa-line'
			),
		);

		$additional_social_networks = get_option( 'theme_social_networks', array() );
		$social_networks            = apply_filters( 'inspiry_header_social_networks', $default_social_networks + $additional_social_networks );

		$html = '<' . $args['container'] . ' class="' . esc_attr( $args['container_class'] ) . '">';

		foreach ( $social_networks as $title => $social_network ) {

			$social_network_title = $title;
			$social_network_url   = $social_network['url'];
			$social_network_icon  = $social_network['icon'];

			if ( isset( $social_network['title'] ) && ! empty( $social_network['title'] ) ) {
				$social_network_title = strtolower( str_replace( ' ', '-', $social_network['title'] ) );
			}

			if ( ! empty( $social_network_title ) && ! empty( $social_network_url ) && ! empty( $social_network_icon ) ) {

				if ( 'skype' === $social_network_title ) {
					$social_network_url = esc_attr( 'skype:' . $social_network_url );
				} elseif ( 'line' === $social_network_title ) {
					$social_network_url = esc_url( 'https://line.me/ti/p/' . $social_network_url );
				} else {
					$social_network_url = esc_url( $social_network_url );
				}

				if ( ! empty( $args['replace_icons'] ) ) {

					if ( array_key_exists( $social_network_title, $args['replace_icons'] ) ) {
						$social_network_icon = $args['replace_icons'][ $social_network_title ];
					}
				}

				$social_network_icon = array(
					$social_network_icon,
					$args['icon_size_class']
				);
				$icon_classes        = implode( " ", $social_network_icon );

				if ( 'ul' === $args['container'] ) {
					$format = '<li class="%s"><a href="%s" target="%s"><i class="%s"></i></a></li>';
				} else {
					$format = '<a class="%s" href="%s" target="%s"><i class="%s"></i></a>';
				}

				$html .= sprintf( $format, esc_attr( $social_network_title ), $social_network_url, esc_attr( $args['link_target'] ), esc_attr( $icon_classes ) );
			}
		}

		$html .= '</' . $args['container'] . '>';

		if ( $args['echo'] ) {
			echo $html;
		} else {
			return $html;
		}
	}
}

if ( is_admin() && ! function_exists( 'inspiry_remove_revolution_slider_meta_boxes' ) ) {
	/**
	 * Remove Rev Slider Metabox
	 */
	function inspiry_remove_revolution_slider_meta_boxes() {

		$post_types = apply_filters( 'inspiry_remove_revolution_slider_meta_boxes',
			array(
				'page',
				'post',
				'property',
				'agency',
				'agent',
				'partners',
				'slide',
			)
		);

		remove_meta_box( 'mymetabox_revslider_0', $post_types, 'normal' );
	}

	add_action( 'do_meta_boxes', 'inspiry_remove_revolution_slider_meta_boxes' );
}

if ( ! function_exists( 'inspiry_is_property_analytics_enabled' ) ) {
	/**
	 * Check property analytics feature is enabled or disabled.
	 */
	function inspiry_is_property_analytics_enabled() {
		return 'enabled' === get_option( 'inspiry_property_analytics_status', 'disabled' );
	}
}

if ( ! function_exists( 'ere_epc_default_fields' ) ) {
	/**
	 * Return Enenergy Performance Certificate default fields.
	 */
	function ere_epc_default_fields() {

		return apply_filters(
			'ere_epc_default_fields',
			array(
				array(
					'name'  => 'A+',
					'color' => '#00845a',
				),
				array(
					'name'  => 'A',
					'color' => '#18b058',
				),
				array(
					'name'  => 'B',
					'color' => '#8dc643',
				),
				array(
					'name'  => 'C',
					'color' => '#ffcc01',
				),
				array(
					'name'  => 'D',
					'color' => '#f6ac63',
				),
				array(
					'name'  => 'E',
					'color' => '#f78622',
				),
				array(
					'name'  => 'F',
					'color' => '#ef1d3a',
				),
				array(
					'name'  => 'G',
					'color' => '#d10400',
				),
			)
		);
	}
}

if ( ! function_exists( 'ere_safe_include_svg' ) ) {
	/**
	 * Includes svg file in the ERE Plugin.
	 *
	 * @param string $file
	 *
	 */
	function ere_safe_include_svg( $file ) {
		$file = ERE_PLUGIN_DIR . $file;
		if ( file_exists( $file ) ) {
			include( $file );
		}
	}

}

if ( ! function_exists( 'ere_stylish_meta' ) ) {

	function ere_stylish_meta( $label, $post_meta_key, $icon, $postfix = '' ) {

		$post_meta = get_post_meta( get_the_ID(), $post_meta_key, true );

		$get_postfix = get_post_meta( get_the_ID(), $postfix, true );
		if ( isset( $post_meta ) && ! empty( $post_meta ) ) {
			?>
            <div class="rh_prop_card__meta">
				<?php
				if ( $label ) {
					?>
                    <span class="rh_meta_titles"><?php echo esc_html( $label ); ?></span>
					<?php
				}
				?>
                <div class="rh_meta_icon_wrapper">
					<?php
					if ( $icon ) {
						ere_safe_include_svg( '/images/icons/'.$icon.'.svg' );
					}
					?>
                    <span class="figure"><?php echo esc_html( $post_meta ); ?></span>
					<?php if ( isset( $postfix ) && ! empty( $postfix ) && ! empty( $get_postfix ) ) { ?>
                        <span class="label"><?php echo esc_html( get_post_meta( get_the_ID(), $postfix, true ) ); ?></span>
					<?php } ?>
                </div>
            </div>
			<?php
		}

	}
}

if ( ! function_exists( 'ere_stylish_meta_smart' ) ) {

	function ere_stylish_meta_smart( $label, $post_meta_key, $icon, $postfix = '' ) {

		$post_meta = get_post_meta( get_the_ID(), $post_meta_key, true );

		$get_postfix = get_post_meta( get_the_ID(), $postfix, true );
		if ( isset( $post_meta ) && ! empty( $post_meta ) ) {
			?>
            <div class="rh_prop_card__meta">
				<?php
				if ( $label ) {
					?>
                    <span class="rhea_meta_titles"><?php echo esc_html( $label ); ?></span>
					<?php
				}
				?>
                <div class="rhea_meta_icon_wrapper">
                    <span data-tooltip="<?php echo esc_html( $label ) ?>">
					<?php
					if ( $icon ) {
						ere_safe_include_svg( '/images/icons/'.$icon.'.svg' );
					}
					?>
                    </span>
                    <span class="rhea_meta_smart_box">
                    <span class="figure"><?php echo esc_html( $post_meta ); ?></span>
						<?php if ( isset( $postfix ) && ! empty( $postfix ) && ! empty( $get_postfix ) ) { ?>
                            <span class="label"><?php echo esc_html( get_post_meta( get_the_ID(), $postfix, true ) ); ?></span>
						<?php } ?>
                    </span>
                </div>
            </div>
			<?php
		}

	}
}

if ( ! function_exists( 'ere_display_property_status_html' ) ) {
	/**
	 * Display property status.
	 *
	 * @param $post_id
	 *
	 */
	function ere_display_property_status_html( $post_id ) {
		$status_terms = get_the_terms( $post_id, 'property-status' );

		if ( ! empty( $status_terms ) && ! is_wp_error( $status_terms ) ) {


			foreach ( $status_terms as $term ) {

				$inspiry_property_status_bg = get_term_meta($term->term_id,'inspiry_property_status_bg',true);
				$status_bg = '';
				if(!empty($inspiry_property_status_bg)){
					$status_bg = " background:" . "$inspiry_property_status_bg; ";
				}
				$inspiry_property_status_text = get_term_meta($term->term_id,'inspiry_property_status_text',true);

				$status_text = '';
				if(!empty($inspiry_property_status_text)){
					$status_text = " color:" . "$inspiry_property_status_text; ";
				}

				?>
                <span class="rh_prop_status_sty" style="<?php echo esc_attr($status_bg . $status_text)?>">
                <?php
                echo esc_html($term->name);
                ?>
				</span>
				<?php
			}
		}

	}
}