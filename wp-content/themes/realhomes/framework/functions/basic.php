<?php
/**
 * This file contain theme's basic functions
 *
 * @package realhomes/functions
 */

if ( ! function_exists( 'inspiry_logo_img' ) ) {
	/**
	 * Display logo image
	 *
	 * @param string $logo_url Logo img url.
	 * @param string $retina_logo_url Retina logo image url.
	 *
	 * @return void
	 * @since 3.7.1
	 *
	 */
	function inspiry_logo_img( $logo_url, $retina_logo_url ) {

		global $is_IE;

		if ( ! empty( $logo_url ) && ! empty( $retina_logo_url ) && ! $is_IE ) {
			echo '<img alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" src="' . esc_url( $logo_url ) . '" srcset="' . esc_url( $logo_url ) . ', ' . esc_url( $retina_logo_url ) . ' 2x">';
		} else if ( ! empty( $retina_logo_url ) ) {
			echo '<img alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" src="' . esc_url( $retina_logo_url ) . '">';
		} else {
			echo '<img alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" src="' . esc_url( $logo_url ) . '">';
		}
	}
}

if ( ! function_exists( 'inspiry_post_nav' ) ) {

	/**
	 * Return link to previous and next entry.
	 *
	 * @param bool $same_category - True if from same category.
	 */
	function inspiry_post_nav( $same_category = false ) {

		if ( ( 'true' === get_option( 'inspiry_property_prev_next_link' ) && is_singular( 'property' ) )
		     || ( 'true' === get_option( 'inspiry_post_prev_next_link' ) && is_singular( 'post' ) )
		) {

			$entries['prev'] = get_previous_post( $same_category );
			$entries['next'] = get_next_post( $same_category );

			$output = '';

			foreach ( $entries as $key => $entry ) {
				if ( empty( $entry ) ) {
					continue;
				}

				$the_title = get_the_title( $entry->ID );
				$link      = get_permalink( $entry->ID );
				$image     = has_post_thumbnail( $entry );

				$entry_title = $entry_img = '';
				$class       = ( $image ) ? 'with-image' : 'without-image';
				$icon        = ( 'prev' == $key ) ? 'angle-left' : 'angle-right';

				?>
                <a class='inspiry-post-nav inspiry-post-<?php echo esc_attr( $key ) . ' ' . esc_attr( $class ); ?>' href='<?php echo esc_url( $link ); ?>'>
                    <span class='label'><i class="fas fa-<?php echo esc_attr( $icon ); ?>"></i></span>
                    <span class='entry-info-wrap'>
					<span class='entry-info'>
						<?php if ( 'prev' == $key ) : ?>
                            <span class='entry-title'><?php echo esc_html( $the_title ); ?></span>
							<?php if ( $image ) : ?>
                                <span class='entry-image'>
									<?php echo get_the_post_thumbnail( $entry, 'thumbnail' ); ?>
								</span>
							<?php else : ?>
                                <span class="entry-image">
									<img src="<?php echo esc_url( get_inspiry_image_placeholder_url( 'thumbnail' ) ); ?>">
								</span>
							<?php endif; ?><?php else : ?><?php if ( $image ) : ?>
                            <span class='entry-image'>
									<?php echo get_the_post_thumbnail( $entry, 'thumbnail' ); ?>
								</span>
						<?php else : ?>
                            <span class="entry-image">
									<img src="<?php echo esc_url( get_inspiry_image_placeholder_url( 'thumbnail' ) ); ?>">
								</span>
						<?php endif; ?>
							<span class='entry-title'><?php echo esc_html( $the_title ); ?></span>
						<?php endif; ?>
					</span>
				</span>
                </a>
				<?php
			}
		}
	}
}

if ( ! function_exists( 'list_gallery_images' ) ) {
	/**
	 * Get list of Gallery Images - use in gallery post format
	 *
	 * @param string $size
	 */
	function list_gallery_images( $size = 'post-featured-image' ) {
		global $post;

		if ( ! function_exists( 'rwmb_meta' ) ) {
			return;
		}
		$gallery_images = rwmb_meta( 'REAL_HOMES_gallery', 'type=plupload_image&size=' . $size, get_the_ID() );

		if ( ! empty( $gallery_images ) ) {
			foreach ( $gallery_images as $gallery_image ) {
				$caption = ( ! empty( $gallery_image['caption'] ) ) ? $gallery_image['caption'] : $gallery_image['alt'];
				echo '<li><a href="' . $gallery_image['full_url'] . '" title="' . $caption . '" data-fancybox="list-gallery" class="" >';
				echo '<img src="' . $gallery_image['url'] . '" alt="' . $gallery_image['title'] . '" />';
				echo '</a></li>';
			}
		} else if ( has_post_thumbnail( get_the_ID() ) ) {
			echo '<li><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" >';
			the_post_thumbnail( $size );
			echo '</a></li>';
		}
	}
}

if ( ! function_exists( 'framework_excerpt' ) ) {
	/**
	 * Output custom excerpt of required length
	 *
	 * @param int $len number of words
	 * @param string $trim string to appear after excerpt
	 */
	function framework_excerpt( $len = 15, $trim = "&hellip;" ) {
		echo get_framework_excerpt( $len, $trim );
	}
}

if ( ! function_exists( 'get_framework_excerpt' ) ) {
	/**
	 * Returns custom excerpt of required length
	 *
	 * @param int $len number of words
	 * @param string $trim string after excerpt
	 *
	 * @return array|string
	 */
	function get_framework_excerpt( $len = 15, $trim = "&hellip;" ) {
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

if ( ! function_exists( 'comment_custom_excerpt' ) ) {
	/**
	 * Output comment's excerpt of required length from given contents
	 *
	 * @param int $len number of words
	 * @param string $comment_content comment contents
	 * @param string $trim text after excerpt
	 */
	function comment_custom_excerpt( $len = 15, $comment_content = "", $trim = "&hellip;" ) {
		$limit     = $len + 1;
		$excerpt   = explode( ' ', $comment_content, $limit );
		$num_words = count( $excerpt );
		if ( $num_words >= $len ) {
			array_pop( $excerpt );
		} else {
			$trim = "";
		}
		$excerpt = implode( " ", $excerpt ) . "$trim";
		echo wp_kses( $excerpt, wp_kses_allowed_html( 'post' ) );
	}
}

if ( ! function_exists( 'get_framework_custom_excerpt' ) ) {
	/**
	 * Return excerpt of required length from given contents
	 *
	 * @param string $contents contents to extract excerpt
	 * @param int $len number of words
	 * @param string $trim string to appear after excerpt
	 *
	 * @return array|string
	 */
	function get_framework_custom_excerpt( $contents = "", $len = 15, $trim = "&hellip;" ) {
		$limit     = $len + 1;
		$excerpt   = explode( ' ', $contents, $limit );
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

if ( ! function_exists( 'admin_js' ) ) {
	/**
	 * Register and load admin javascript
	 *
	 * @param string $hook - Page name.
	 */
	function admin_js( $hook ) {
		if ( $hook == 'post.php' || $hook == 'post-new.php' ) {
			wp_register_script( 'admin-script', get_theme_file_uri( 'common/js/admin.js' ), array( 'jquery' ), INSPIRY_THEME_VERSION );
			wp_enqueue_script( 'admin-script' );
		}
	}

	add_action( 'admin_enqueue_scripts', 'admin_js', 10, 1 );
}

/**
 * Disable Post Format UI in WordPress 3.6 and Keep the Old One Working
 */
add_filter( 'enable_post_format_ui', '__return_false' );

if ( ! function_exists( 'remove_category_list_rel' ) ) {
	/**
	 * Remove rel attribute from the category list
	 *
	 * @param $output
	 *
	 * @return mixed
	 */
	function remove_category_list_rel( $output ) {
		$output = str_replace( ' rel="tag"', '', $output );
		$output = str_replace( ' rel="category"', '', $output );
		$output = str_replace( ' rel="category tag"', '', $output );

		return $output;
	}

	add_filter( 'wp_list_categories', 'remove_category_list_rel' );
	add_filter( 'the_category', 'remove_category_list_rel' );
}


if ( ! function_exists( 'addhttp' ) ) {
	/**
	 * Add http:// in url if not exists
	 *
	 * @param $url
	 *
	 * @return string
	 */
	function addhttp( $url ) {
		if ( ! preg_match( "~^(?:f|ht)tps?://~i", $url ) ) {
			$url = "http://" . $url;
		}

		return $url;
	}
}

if ( ! function_exists( 'custom_login_logo_url' ) ) {
	/**
	 * WordPress login page logo URL
	 *
	 * @return string|void
	 */
	function custom_login_logo_url() {
		return home_url();
	}

	add_filter( 'login_headerurl', 'custom_login_logo_url' );
}

if ( ! function_exists( 'custom_login_logo_title' ) ) {
	/**
	 * WordPress login page logo url title
	 *
	 * @return string|void
	 */
	function custom_login_logo_title() {
		return get_bloginfo( 'name' );
	}

	add_filter( 'login_headertext', 'custom_login_logo_title' );
}

if ( ! function_exists( 'custom_login_style' ) ) {
	/**
	 * WordPress login page custom styles
	 */
	function custom_login_style() {
		wp_enqueue_style( 'login-style', get_theme_file_uri( 'common/css/login-styles.min.css' ), false );
	}

	add_action( 'login_enqueue_scripts', 'custom_login_style' );
}

if ( ! function_exists( 'alert' ) ) {
	/**
	 * Alert function to display messages on member pages
	 *
	 * @param string $heading
	 * @param string $message
	 */
	function alert( $heading = '', $message = '' ) {
		echo '<div class="inspiry-message">';
		echo '<strong>' . $heading . '</strong> <span>' . $message . '</span>';
		echo '</div>';
	}
}

if ( ! function_exists( 'display_notice' ) ) {
	/**
	 * display_notice function to display messages on member pages
	 *
	 * @param array $notices
	 *
	 * @return bool|mixed
	 */
	function display_notice( $notices = array() ) {

		if ( ! is_array( $notices ) || empty( $notices ) ) {
			return false;
		}

		echo '<div class="inspiry-message">';
		foreach ( $notices as $notice ) {
			echo '<strong>' . esc_html( $notice['heading'] ) . '</strong> ';
			echo '<span>';
			echo ( ! empty( $notice['message'] ) ) ? esc_html( $notice['message'] ) : esc_html__( 'No more properties are available.', 'framework' );
			echo '</span><br>';
		}
		echo '</div>';
	}
}

if ( ! function_exists( 'modify_user_contact_methods' ) ) {
	/**
	 * Add Additional Contact Info to User Profile Page
	 *
	 * @param $user_contactmethods
	 *
	 * @return mixed
	 */
	function modify_user_contact_methods( $user_contactmethods ) {
		$user_contactmethods['mobile_number']   = esc_html__( 'Mobile Number', 'framework' );
		$user_contactmethods['office_number']   = esc_html__( 'Office Number', 'framework' );
		$user_contactmethods['fax_number']      = esc_html__( 'Fax Number', 'framework' );
		$user_contactmethods['whatsapp_number'] = esc_html__( 'WhatsApp Number', 'framework' );
		$user_contactmethods['facebook_url']    = esc_html__( 'Facebook URL', 'framework' );
		$user_contactmethods['twitter_url']     = esc_html__( 'Twitter URL', 'framework' );
		$user_contactmethods['linkedin_url']    = esc_html__( 'LinkedIn URL', 'framework' );
		$user_contactmethods['instagram_url']   = esc_html__( 'Instagram URL', 'framework' );
		$user_contactmethods['pinterest_url']   = esc_html__( 'Pinterest URL', 'framework' );
		$user_contactmethods['youtube_url']     = esc_html__( 'Youtube URL', 'framework' );

		return $user_contactmethods;
	}

	add_filter( 'user_contactmethods', 'modify_user_contact_methods' );
}

if ( ! function_exists( 'get_icon_for_extension' ) ) {
	/**
	 * Fontawsome icon based on file extension
	 *
	 * @param $ext
	 *
	 * @return string
	 */
	function get_icon_for_extension( $ext ) {
		switch ( $ext ) {
			/* PDF */
			case 'pdf':
				return '<i class="far fa-file-pdf"></i>';

			/* Images */
			case 'jpg':
			case 'png':
			case 'gif':
			case 'bmp':
			case 'jpeg':
			case 'tiff':
			case 'tif':
				return '<i class="far fa-file-image"></i>';

			/* Text */
			case 'txt':
			case 'log':
			case 'tex':
				return '<i class="far fa-file-alt"></i>';

			/* Documents */
			case 'doc':
			case 'odt':
			case 'msg':
			case 'docx':
			case 'rtf':
			case 'wps':
			case 'wpd':
			case 'pages':
				return '<i class="far fa-file-word"></i>';

			/* Spread Sheets */
			case 'csv':
			case 'xlsx':
			case 'xls':
			case 'xml':
			case 'xlr':
				return '<i class="far fa-file-excel"></i>';

			/* Zip */
			case 'zip':
			case 'rar':
			case '7z':
			case 'zipx':
			case 'tar.gz':
			case 'gz':
			case 'pkg':
				return '<i class="far fa-file-archive"></i>';

			/* Audio */
			case 'mp3':
			case 'wav':
			case 'm4a':
			case 'aif':
			case 'wma':
			case 'ra':
			case 'mpa':
			case 'iff':
			case 'm3u':
				return '<i class="far fa-file-audio"></i>';

			/* Video */
			case 'avi':
			case 'flv':
			case 'm4v':
			case 'mov':
			case 'mp4':
			case 'mpg':
			case 'rm':
			case 'swf':
			case 'wmv':
				return '<i class="far fa-file-video"></i>';

			/* Others */
			default:
				return '<i class="far fa-file"></i>';
		}
	}
}

if ( ! function_exists( 'inspiry_image_placeholder' ) ) {
	/**
	 * Output image place holder for given size
	 *
	 * @param string $image_size - Image size.
	 */
	function inspiry_image_placeholder( $image_size ) {
		echo get_inspiry_image_placeholder( $image_size );
	}
}


if ( ! function_exists( 'get_inspiry_image_placeholder' ) ) {
	/**
	 * Returns image place holder for given size
	 *
	 * @param string $image_size - Image size.
	 *
	 * @return string - Image HTML
	 */
	function get_inspiry_image_placeholder( $image_size ) {

		if ( empty( $image_size ) ) {
			return '';
		}

		// Get custom placeholder image if configured.
		$placeholder_custom_image_url = get_option( 'inspiry_properties_placeholder_image' );
		if ( ! empty( $placeholder_custom_image_url ) ) {
			$placeholder_custom_image_id = attachment_url_to_postid( $placeholder_custom_image_url );
			if ( ! empty( $placeholder_custom_image_id ) ) {
				return wp_get_attachment_image( $placeholder_custom_image_id, $image_size, false, '' );
			}

			// Otherwise get default placeholder
		} else {
			$placeholder_image_url = inspiry_get_raw_placeholder_url( $image_size );
			if ( ! empty( $placeholder_image_url ) ) {
				return sprintf( '<img src="%s" alt="%s">', esc_url( $placeholder_image_url ), the_title_attribute( 'echo=0' ) );
			}
		}

		return '';
	}
}


if ( ! function_exists( 'get_inspiry_image_placeholder_url' ) ) {
	/**
	 * Returns the URL of placeholder image.
	 *
	 * @param string $image_size - Image size.
	 *
	 * @return string|boolean - URL of the placeholder OR `false` on failure.
	 * @since 3.1.0
	 */
	function get_inspiry_image_placeholder_url( $image_size ) {

		// Get custom placeholder image if configured.
		$placeholder_custom_image_url = get_option( 'inspiry_properties_placeholder_image' );
		if ( ! empty( $placeholder_custom_image_url ) ) {
			$placeholder_custom_image_id = attachment_url_to_postid( $placeholder_custom_image_url );
			if ( ! empty( $placeholder_custom_image_id ) ) {
				return wp_get_attachment_image_url( $placeholder_custom_image_id, $image_size, false );
			}
		}

		return inspiry_get_raw_placeholder_url( $image_size );
	}
}


if ( ! function_exists( 'inspiry_get_raw_placeholder_url' ) ) {
	/**
	 * Returns the URL of placeholder image.
	 *
	 * @param string $image_size - Image size.
	 *
	 * @return string|boolean - URL of the placeholder OR `false` on failure.
	 * @since 3.10.2
	 */
	function inspiry_get_raw_placeholder_url( $image_size ) {

		global $_wp_additional_image_sizes;

		$holder_width  = 0;
		$holder_height = 0;
		$holder_text   = get_bloginfo( 'name' );

		if ( in_array( $image_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

			$holder_width  = get_option( $image_size . '_size_w' );
			$holder_height = get_option( $image_size . '_size_h' );

		} elseif ( isset( $_wp_additional_image_sizes[ $image_size ] ) ) {

			$holder_width  = $_wp_additional_image_sizes[ $image_size ]['width'];
			$holder_height = $_wp_additional_image_sizes[ $image_size ]['height'];

		}

		if ( intval( $holder_width ) > 0 && intval( $holder_height ) > 0 ) {
			return 'https://via.placeholder.com/' . $holder_width . 'x' . $holder_height . '&text=' . urlencode( $holder_text );
		}

		return false;
	}
}


if ( ! function_exists( 'inspiry_log' ) ) {
	/**
	 * Function to help in debugging
	 *
	 * @param $message
	 */
	function inspiry_log( $message ) {
		if ( WP_DEBUG === true ) {
			if ( is_array( $message ) || is_object( $message ) ) {
				error_log( print_r( $message, true ) );
			} else {
				error_log( $message );
			}
		}
	}
}

if ( ! function_exists( 'inspiry_get_maps_type' ) ) :
	/**
	 * Returns the type currently available for use.
	 */
	function inspiry_get_maps_type() {
		$google_maps_api_key = get_option( 'inspiry_google_maps_api_key', false );

		if ( ! empty( $google_maps_api_key ) ) {
			return 'google-maps';    // For Google Maps
		}

		return 'open-street-map';    // For OpenStreetMap https://www.openstreetmap.org/
	}
endif;

if ( ! function_exists( 'inspiry_is_map_needed' ) ) {
	/**
	 * Check if google map script is needed or not
	 *
	 * @return bool
	 */
	function inspiry_is_map_needed() {
		if ( is_page_template( 'templates/contact.php' ) && ( get_post_meta( get_the_ID(), 'theme_show_contact_map', true ) == '1' ) ) {
			return true;
		} elseif ( is_page_template( array( 'templates/submit-property.php', 'templates/dashboard.php' ) ) ) {
			return true;
		} elseif ( is_singular( 'property' ) && ( get_option( 'theme_display_google_map' ) == 'true' ) ) {
			return true;
		} elseif ( is_page_template( 'templates/home.php' ) ) {
			$theme_homepage_module = get_post_meta( get_the_ID(), 'theme_homepage_module', true );
			if ( isset( $_GET['module'] ) ) {
				$theme_homepage_module = $_GET['module'];
			}
			if ( $theme_homepage_module == 'properties-map' ) {
				return true;
			}
		} elseif ( is_page_template( 'templates/properties-search.php' ) ) {
			$theme_search_module = get_option( 'theme_search_module', 'properties-map' );
			if ( 'classic' === INSPIRY_DESIGN_VARIATION && ( 'properties-map' == $theme_search_module ) ) {
				return true;
			} elseif ( 'classic' === INSPIRY_DESIGN_VARIATION && ( 'simple-banner' == $theme_search_module ) ) {
				return false;
			} elseif ( 'modern' === INSPIRY_DESIGN_VARIATION ) {
				return true;
			}
		} elseif ( is_page_template( array(
			'templates/properties-search.php',
			'templates/properties-search-half-map.php',
			'templates/half-map-layout.php',
			'templates/properties-search-left-sidebar.php',
			'templates/properties-search-right-sidebar.php'
		) ) ) {
			return true;
		} elseif ( is_page_template( array(
				'templates/list-layout.php',
				'templates/grid-layout.php',
				'templates/list-layout-full-width.php',
				'templates/grid-layout-full-width.php'
			) ) || is_tax( 'property-city' ) || is_tax( 'property-status' ) || is_tax( 'property-type' ) || is_tax( 'property-feature' ) || is_post_type_archive( 'property' ) ) {
			// Theme Listing Page Module
			$theme_listing_module = get_option( 'theme_listing_module' );
			// Only for demo purpose only
			if ( isset( $_GET['module'] ) ) {
				$theme_listing_module = $_GET['module'];
			}
			if ( $theme_listing_module == 'properties-map' ) {
				return true;
			}
		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_map_needed_for_address' ) ) {

	function inspiry_map_needed_for_address() {
		$inspiry_address_lightbox_enable = get_option( 'inspiry_address_lightbox_enable', 'disable' );

		if ( 'enable' === $inspiry_address_lightbox_enable ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_hex_to_rgba' ) ) {

	/**
	 * Convert hexdec color string to rgb(a) string
	 *
	 * @param string $color - Color string in rgb.
	 * @param float $opacity - Opacity of the color.
	 * @param bool $value_only - Returns only rgb values.
	 *
	 * @since 2.6.2
	 *
	 * @return string
	 */
	function inspiry_hex_to_rgba( $color, $opacity = false, $value_only = false ) {

		$default = '';

		// Return default if no color provided
		if ( empty( $color ) ) {
			return $default;
		}

		// Sanitize $color if "#" is provided
		if ( $color[0] == '#' ) {
			$color = substr( $color, 1 );
		}

		// Check if color has 6 or 3 characters and get values
		if ( strlen( $color ) == 6 ) {
			$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
		} elseif ( strlen( $color ) == 3 ) {
			$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
		} else {
			return $default;
		}

		// Convert hexadec to rgb
		$rgb = array_map( 'hexdec', $hex );

		// Check if opacity is set(rgba or rgb)
		if ( $opacity ) {
			if ( abs( $opacity ) > 1 ) {
				$opacity = 1.0;
			}
			$output = 'rgba(' . implode( ",", $rgb ) . ',' . $opacity . ')';
		} elseif ( $value_only ){
			$output = implode( ",", $rgb );
        } else {
			$output = 'rgb(' . implode( ",", $rgb ) . ')';
		}

		// Return rgb(a) color string
		return $output;
	}
}

if ( ! function_exists( 'inspiry_hex_darken' ) ) {

	/**
	 * Function: Returns the hex color darken to percentage.
	 *
	 * @param string $hex - hex color.
	 * @param int $percent - percentage in number without % symbol.
	 *
	 * @return string
	 *
	 * @since 3.5.0
	 */

	function inspiry_hex_darken( $hex, $percent = 0 ) {
		$color = '';
		if ( ! empty( $hex ) ) {
			preg_match( '/^#?([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})$/i', $hex, $primary_colors );
			str_replace( '%', '', $percent );
			$color = "#";
			for ( $i = 1; $i <= 3; $i ++ ) {
				$primary_colors[ $i ] = hexdec( $primary_colors[ $i ] );
				$primary_colors[ $i ] = round( $primary_colors[ $i ] * ( 100 - ( $percent * 2 ) ) / 100 );
				$color                .= str_pad( dechex( $primary_colors[ $i ] ), 2, '0', STR_PAD_LEFT );
			}
		}

		return $color;
	}
}

if ( ! function_exists( 'inspiry_author_properties_count' ) ) {
	/**
	 * Function: Returns the number listed properties of an author.
	 *
	 * @param int $author_id - Author ID for properties.
	 *
	 * @return integer
	 *
	 * @since 3.3.2
	 */
	function inspiry_author_properties_count( $author_id ) {

		if ( empty( $author_id ) ) {
			return 0;
		}

		$properties_args = array(
			'post_type'      => 'property',
			'posts_per_page' => - 1,
			'author'         => $author_id,
			'meta_query'     => array(
				array(
					'key'     => 'REAL_HOMES_agent_display_option',
					'value'   => 'my_profile_info',
					'compare' => '=',
				),
			),
		);

		$properties = new WP_Query( $properties_args );
		if ( $properties->have_posts() ) {
			return $properties->found_posts;
		}

		return 0;
	}
}

if ( ! function_exists( 'inspiry_filter_excerpt_more' ) ) {

	/**
	 * Filter the more text of excerpt.
	 *
	 * @param string $more - More string of the excerpt.
	 *
	 * @return string
	 * @since  3.0.0
	 */
	function new_excerpt_more( $more ) {
		return '...';
	}

	add_filter( 'excerpt_more', 'new_excerpt_more' );
}

if ( ! function_exists( 'inspiry_backend_safe_string' ) ) {
	/**
	 * Create a lower case version of a string without spaces so we can use that string for database settings
	 *
	 * @param string $string to convert
	 *
	 * @return string the converted string
	 */
	function inspiry_backend_safe_string( $string, $replace = "_", $check_spaces = false ) {
		$string = strtolower( $string );

		$trans = array(
			'&\#\d+?;'       => '',
			'&\S+?;'         => '',
			'\s+'            => $replace,
			'ä'              => 'ae',
			'ö'              => 'oe',
			'ü'              => 'ue',
			'Ä'              => 'Ae',
			'Ö'              => 'Oe',
			'Ü'              => 'Ue',
			'ß'              => 'ss',
			'[^a-z0-9\-\._]' => '',
			$replace . '+'   => $replace,
			$replace . '$'   => $replace,
			'^' . $replace   => $replace,
			'\.+$'           => ''
		);

		$trans = apply_filters( 'inspiry_safe_string_trans', $trans, $string, $replace );

		$string = strip_tags( $string );

		foreach ( $trans as $key => $val ) {
			$string = preg_replace( "#" . $key . "#i", $val, $string );
		}

		if ( $check_spaces ) {
			if ( str_replace( '_', '', $string ) == '' ) {
				return;
			}
		}

		return stripslashes( $string );
	}
}

if ( ! function_exists( 'inspiry_hex2rgb' ) ) {
	/***
	 * Converts Hexadecimal color code to RGB
	 *
	 * @param $colour
	 * @param int $opacity
	 *
	 * @return bool|string
	 */
	function inspiry_hex2rgb( $colour, $opacity = 1 ) {
		if ( isset( $colour[0] ) && $colour[0] == '#' ) {
			$colour = substr( $colour, 1 );
		}
		if ( strlen( $colour ) == 6 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
		} elseif ( strlen( $colour ) == 3 ) {
			list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
		} else {
			return false;
		}
		$r = hexdec( $r );
		$g = hexdec( $g );
		$b = hexdec( $b );

		return "rgba({$r},{$g},{$b},{$opacity})";
	}
}

if ( ! function_exists( 'inspiry_get_exploded_heading' ) ) {
	/**
	 * Returned exploded title into title and sub-title.
	 * (Modern design specific)
	 *
	 * @param $page_title
	 *
	 * @return string
	 */
	function inspiry_get_exploded_heading( $page_title ) {

		$explode_title = get_option( 'inspiry_explode_listing_title', 'yes' );

		if ( 'yes' == $explode_title ) {
			$page_title = explode( ' ', $page_title, 2 );

			if ( ! empty( $page_title ) && ( 1 < count( $page_title ) ) ) {
				?>
                <span class="sub"><?php echo esc_html( $page_title[0] ); ?></span>
                <span class="title"><?php echo esc_html( $page_title[1] ); ?></span>
				<?php
			} else {
				?><span class="title"><?php echo esc_html( $page_title[0] ); ?></span><?php
			}

		} else {
			?><span class="title"><?php echo esc_html( $page_title ); ?></span><?php
		}
	}
}

if ( ! function_exists( 'inspiry_is_gdpr_enabled' ) ) {
	/**
	 * Check if GDPR is enabled on forms
	 * @return bool
	 */
	function inspiry_is_gdpr_enabled() {

		$inspiry_gdpr = intval( get_option( 'inspiry_gdpr', '0' ) );

		if ( $inspiry_gdpr ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_gdpr_agreement_content' ) ) {
	/**
	 * Return GDPR field label text
	 *
	 * @param string $type
	 *
	 * @return mixed|void
	 */
	function inspiry_gdpr_agreement_content( $type = 'text' ) {

		if ( 'label' == $type ) {
			$gdpr_agreement_content = get_option( 'inspiry_gdpr_label', esc_html__( 'GDPR Agreement', 'framework' ) );
		} else if ( 'validation-message' == $type ) {
			$gdpr_agreement_content = get_option( 'inspiry_gdpr_validation_text', esc_html__( '* Please accept GDPR agreement', 'framework' ) );
		} else {
			$gdpr_agreement_content = get_option( 'inspiry_gdpr_text', esc_html__( 'I consent to having this website store my submitted information so they can respond to my inquiry.', 'framework' ) );
		}

		return $gdpr_agreement_content;
	}
}

if ( ! function_exists( 'inspiry_is_rvr_enabled' ) ) {
	/**
	 * Check if Realhomes Vacation Rentals plugin is activated and enabled
	 *
	 * @return bool
	 */
	function inspiry_is_rvr_enabled() {
		$rvr_settings = get_option( 'rvr_settings' );
		$rvr_enabled  = isset( $rvr_settings['rvr_activation'] ) ? $rvr_settings['rvr_activation'] : false;

		if ( $rvr_enabled && class_exists( 'Realhomes_Vacation_Rentals' ) ) {
			return true;
		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_show_rvr_availability_calendar' ) ) {
	/**
	 * Checks for allowed property statuses to show availability calendar.
	 *
	 * @since 3.13.0
	 *
	 * @return bool
	 */
	function inspiry_show_rvr_availability_calendar() {

		// Get property statuses to show availability calendar.
		$property_statuses = ( array ) get_option( 'inspiry_statuses_to_show_availability_calendar', array() );
		$property_statuses = array_filter( $property_statuses );
		if ( ! empty( $property_statuses ) ) {

			// Get current property statuses
			$current_statuses = get_the_terms( get_the_ID(), 'property-status' );
			if ( ! empty( $current_statuses ) && ! is_wp_error( $current_statuses ) ) {
				$show = false;
				foreach ( $current_statuses as $current_status ) {
					// Stop if current status exists in allowed statuses.
					if ( in_array( $current_status->term_id, $property_statuses ) ) {
						$show = true;
						break;
					}
				}

				return $show;
			}
		}

		return true;
	}
}

if ( ! function_exists( 'inspiry_language_switcher' ) ) {
	/**
	 * Display language list of selected WPML languages.
	 *
	 * @since 3.6.1
	 */
	function inspiry_language_switcher() {
		echo inspiry_get_language_switcher();
	}
}

if ( ! function_exists( 'inspiry_get_language_switcher' ) ) {
	/**
	 * Retrieve language list of selected WPML languages.
	 *
	 * @since 3.6.1
	 */
	function inspiry_get_language_switcher() {

		if ( function_exists( 'wpml_get_active_languages_filter' ) ) {

			$inspiry_language_switcher = get_option( 'theme_wpml_lang_switcher', 'true' );

			if ( 'true' === $inspiry_language_switcher ) {

				$languages = wpml_get_active_languages_filter( null, null );

				if ( ! empty( $languages ) ) {

					$switcher_language_display = get_option( 'theme_switcher_language_display', 'language_name_and_flag' );
					$active_language           = '';
					$languages_list            = '';

					foreach ( $languages as $language ) {
						$code             = $language['code'];
						$native_name      = $language['native_name'];
						$language_code    = $language['language_code'];
						$country_flag_url = $language['country_flag_url'];

						$language_name_in_current_language = get_option( 'theme_switcher_language_name_in_current_language', 'native_name' );
						if ( 'translated_name' === $language_name_in_current_language ) {
							$native_name = $language['translated_name'];
						}

						if ( ! $language['active'] ) {
							$languages_list .= '<li class="inspiry-language ' . esc_attr( $code ) . '">';
							$languages_list .= '<a class="inspiry-language-link" href="' . esc_url( $language['url'] ) . '">';

							if ( 'language_flag_only' === $switcher_language_display ) {
								$languages_list .= '<img src="' . esc_url( $country_flag_url ) . '" alt="' . esc_attr( $language_code ) . '" />';
							} elseif ( 'language_name_only' == $switcher_language_display ) {
								$languages_list .= '<span class="inspiry-language-native">' . esc_html( $native_name ) . '</span>';

							} else {
								$languages_list .= '<img src="' . esc_url( $country_flag_url ) . '" alt="' . esc_attr( $language_code ) . '" />';
								$languages_list .= '<span class="inspiry-language-native">' . esc_html( $native_name ) . '</span>';
							}
							$languages_list .= '</a>';
							$languages_list .= '</li>';
						} else {
							$active_language .= '<li class="inspiry-language ' . esc_attr( $code ) . ' current" >';
							if ( 'language_flag_only' === $switcher_language_display ) {
								$active_language .= '<img class="inspiry-no-language-name" src="' . esc_url( $country_flag_url ) . '" alt="' . esc_attr( $language_code ) . '" />';
							} elseif ( 'language_name_only' == $switcher_language_display ) {
								$active_language .= '<span class="inspiry-language-native inspiry-no-language-flag">' . esc_html( $native_name ) . '</span>';
							} else {
								$active_language .= '<img src="' . esc_url( $country_flag_url ) . '" alt="' . esc_attr( $language_code ) . '" />';
								$active_language .= '<span class="inspiry-language-native">' . esc_html( $native_name ) . '</span>';
							}
						}
					}

					$html = '<div class="inspiry-language-switcher"><ul>';
					$html .= $active_language;

					if ( ! empty( $languages_list ) ) {
						$html .= '<ul class="rh_languages_available">' . $languages_list . '</ul>';
					}

					$html .= '</li></ul></div>';

					return $html;
				}
			}
		}
	}
}

if ( ! function_exists( 'inspiry_property_qr_code' ) ) {
	/**
	 * Display QR code image generated with google chart API.
	 */
	function inspiry_property_qr_code() {

		$inspiry_qr_code_url = 'https://chart.googleapis.com/chart?cht=qr&chs=90x90&chl=' . get_the_permalink() . '&choe=UTF-8';

		printf( '<img class="only-for-print inspiry-qr-code" src="%s" alt="%s">', esc_url( $inspiry_qr_code_url ), the_title_attribute( 'echo=0' ) );
	}
}

if ( ! function_exists( 'inspiry_property_detail_page_link_text' ) ) {
	/**
	 * Display property detail page link text.
	 */
	function inspiry_property_detail_page_link_text() {
		echo get_option( 'inspiry_property_detail_page_link_text', esc_html__( 'View Property', 'framework' ) );
	}
}

if ( ! function_exists( 'inspiry_embed_code_allowed_html' ) ) {
	/**
	 * @return array Array of allowed tags for embed code.
	 */
	function inspiry_embed_code_allowed_html() {
		$embed_code_allowed_html = wp_kses_allowed_html( 'post' );

		// iframe
		$embed_code_allowed_html['iframe'] = array(
			'src'             => array(),
			'height'          => array(),
			'width'           => array(),
			'frameborder'     => array(),
			'allowfullscreen' => array(),
			'allowvr'         => array(),
		);

		return apply_filters( 'inspiry_embed_code_allowed_html', $embed_code_allowed_html );
	}
}

if ( ! function_exists( 'inspiry_allowed_html' ) ) {
	/**
	 * @return array Array of allowed html tags.
	 */
	function inspiry_allowed_html() {

		$allowed_html = array(
			'a'      => array(
				'href'   => array(),
				'title'  => array(),
				'alt'    => array(),
				'target' => array(),
			),
			'b'      => array(),
			'br'     => array(),
			'div'    => array(
				'class' => array(),
				'id'    => array(),
			),
			'em'     => array(),
			'strong' => array(),
		);

		return apply_filters( 'inspiry_allowed_html', $allowed_html );
	}
}

if ( ! function_exists( 'inspiry_redirect' ) ) {
	/**
	 * Redirect to a page even header is sent already
	 *
	 * @param $url
	 */
	function inspiry_redirect( $url ) {
		$string = '<script type="text/javascript">';
		$string .= 'window.location = "' . esc_url( $url ) . '"';
		$string .= '</script>';

		echo wp_kses( $string, array(
			'script' => array(
				'type' => array()
			)
		) );
	}
}

if ( ! function_exists( 'inspiry_admin_body_classes' ) ) {
	/**
	 * Add classes to the body tag on admin side
	 *
	 * @param $classes
	 *
	 * @return string
	 */
	function inspiry_admin_body_classes( $classes ) {

		$classes .= ' design_' . INSPIRY_DESIGN_VARIATION; // design variation

		return $classes;
	}

	add_filter( 'admin_body_class', 'inspiry_admin_body_classes' );
}

if ( ! function_exists( 'inspiry_body_classes' ) ) {
	/**
	 * Add classes to the body tag on frontend side
	 *
	 * @param $classes
	 *
	 * @return array
	 */
	function inspiry_body_classes( $classes ) {

		$classes[] = ' design_' . INSPIRY_DESIGN_VARIATION; // design variation

		if ( 'modern' === INSPIRY_DESIGN_VARIATION && ( 'enable' === get_option( 'realhomes_round_corners', 'disable' ) ) ) {
		    // Body class to change theme elements border radius.
			$classes[] = 'realhomes-round-corners';
		}

		return $classes;
	}

	add_filter( 'body_class', 'inspiry_body_classes' );
}

if ( ! function_exists( 'inspiry_add_property_feed_data' ) ) {
	/**
	 * Adds Property important information to its feed
	 * Reference: https://wordpress.org/support/article/wordpress-feeds/
	 */
	function inspiry_add_property_feed_data() {

		if ( get_post_type() == 'property' ) {

			$property_id = get_the_ID();
			$meta_keys   = array(
				'REAL_HOMES_property_id',
				'REAL_HOMES_property_price',
				'REAL_HOMES_property_size',
				'REAL_HOMES_property_bedrooms',
				'REAL_HOMES_property_bathrooms',
				'REAL_HOMES_property_garage',
				'REAL_HOMES_property_year_built',
				'REAL_HOMES_property_location',
				'REAL_HOMES_property_address',
			);

			// add meta information to the feed
			echo "<meta>";
			foreach ( $meta_keys as $meta_key ) {
				if ( $meta_value = get_post_meta( $property_id, $meta_key, true ) ) {
					echo "<{$meta_key}>{$meta_value}</{$meta_key}>\n";
				}
			}
			echo "</meta>";


			$taxonomies = array(
				'property-city'    => array( 'locations', 'location' ),
				'property-status'  => array( 'statuses', 'status' ),
				'property-type'    => array( 'types', 'type' ),
				'property-feature' => array( 'features', 'feature' ),
			);

			// add taxonomies to the feed
			foreach ( $taxonomies as $taxonomy => $label ) {
				$terms = get_the_terms( $property_id, $taxonomy );
				if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
					echo "<{$label[0]}>";
					foreach ( $terms as $key => $term ) {
						echo "<{$label[1]}>{$term->name}</{$label[1]}>\n";
					}
					echo "</{$label[0]}>";
				}
			}
		}
	}

	add_action( 'rss2_item', 'inspiry_add_property_feed_data' );
}

if ( ! function_exists( 'inspiry_get_property_attachments' ) ) {
	/**
	 * Retrieves the property attachments.
	 *
	 * @since 3.12.2
	 *
	 * @param int $property_id
	 *
	 * @return array|mixed
	 */
	function inspiry_get_property_attachments( $property_id = 0 ) {

		if ( empty( $property_id ) ) {
			$property_id = get_the_ID();
		}

		$attachments = get_post_meta( $property_id, 'REAL_HOMES_attachments', false );
		if ( is_array( $attachments ) ) {
			$attachments = array_filter( $attachments );
			$attachments = array_unique( $attachments );
		}

		return $attachments;
	}
}

if ( ! function_exists( 'inspiry_walkscore' ) ) {
	/**
	 * Displays the property WalkScore.
	 *
	 * @since 3.10
	 */
	function inspiry_walkscore() {
		$api_key = get_option( 'inspiry_walkscore_api_key' );
		if ( empty( $api_key ) ) {
			echo '<p class="ws-api-key-error">' . esc_html__( 'Walkscore API key is missing', 'framework' ) . '</p>';

			return;
		}

		$property_address = get_post_meta( get_the_ID(), 'REAL_HOMES_property_address', true );
		if ( empty( $property_address ) ) {
			return;
		}

		echo '<div id="ws-walkscore-tile"></div>';
		$data = "var ws_wsid    = '" . esc_html( $api_key ) . "';
                 var ws_address = '" . esc_html( $property_address ) . "';
                 var ws_format  = 'wide';
                 var ws_width   = '550';
                 var ws_width   = '100%';
                 var ws_height  = '350';";
		wp_enqueue_script( 'inspiry-walkscore', 'https://www.walkscore.com/tile/show-walkscore-tile.php', array(), null, true );
		wp_add_inline_script( 'inspiry-walkscore', $data, 'before' );
	}
}

if ( ! function_exists( 'inspiry_yelp_query_api' ) ) {
	/**
	 * Makes a request to the Yelp API based on a search term and location.
	 *
	 * @since 3.10
	 *
	 * @param string $key Yelp Fusion API Key.
	 * @param string $term The search term.
	 * @param string $location The location within which to search.
	 *
	 * @return bool|array Associative array containing the response body.
	 */
	function inspiry_yelp_query_api( $key, $term, $location ) {

		$url = add_query_arg(
			array(
				'term'     => $term,
				'location' => $location,
				'limit'    => intval( get_option( 'inspiry_yelp_search_limit', '3' ) ),
			),
			'https://api.yelp.com/v3/businesses/search'
		);

		$args = array(
			'user-agent' => '',
			'headers'    => array(
				'authorization' => 'Bearer ' . $key,
			),
		);

		$response = wp_safe_remote_get( $url, $args );

		if ( is_wp_error( $response ) ) {
			return false;
		}

		if ( ! empty( $response['body'] ) && is_ssl() ) {
			$response['body'] = str_replace( 'http:', 'https:', $response['body'] );
		} elseif ( is_ssl() ) {
			$response = str_replace( 'http:', 'https:', $response );
		}
		$response = str_replace( 'http:', 'https:', $response );

		return json_decode( $response['body'] );
	}
}

if ( ! function_exists( 'inspiry_yelp_nearby_places' ) ) {
	/**
	 * Displays the Yelp Nearby Places.
	 *
	 * @since 3.10
	 */
	function inspiry_yelp_nearby_places() {
		echo inspiry_get_yelp_nearby_places();
	}
}

if ( ! function_exists( 'inspiry_get_yelp_nearby_places' ) ) {
	/**
	 * Returns the Yelp Nearby Places markup.
	 *
	 * @since 3.10
	 *
	 * @return bool|mixed
	 */
	function inspiry_get_yelp_nearby_places() {

		$yelp_api_key = get_option( 'inspiry_yelp_api_key' );
		if ( empty( $yelp_api_key ) ) {
			printf( '<div class="yelp-error">%s</div>', esc_html__( 'Yelp API key is missing', 'framework' ) );

			return false;
		}

		$property_location = get_post_meta( get_the_ID(), 'REAL_HOMES_property_location', true );
		if ( empty( $property_location ) ) {
			return false;
		}

		$distance            = false;
		$current_lat         = '';
		$current_lng         = '';
		$property_location   = explode( ',', $property_location );
		$property_location   = $property_location[0] . ',' . $property_location[1];
		$yelp_terms          = get_option( 'inspiry_yelp_terms', array( 'education', 'realestate', 'health' ) );
		$yelp_distance_unit  = get_option( 'inspiry_yelp_distance_unit', 'mi' );
		$yelp_dist_unit_text = esc_html__( 'mi', 'framework' );
		$yelp_dist_unit      = 1.1515;

		if ( 'km' === $yelp_distance_unit ) {
			$yelp_dist_unit_text = esc_html__( 'km', 'framework' );
			$yelp_dist_unit      = 1.609344;
		}

		$output = '<div class="yelp-nearby-places">';

		foreach ( $yelp_terms as $yelp_term ) {
			$term = inspiry_get_yelp_term( $yelp_term );
			if ( empty( $term ) ) {
				// Skip
				continue;
			}

			$response = inspiry_yelp_query_api( $yelp_api_key, $yelp_term, $property_location );

			// Check Yelp API response for an error
			if ( isset( $response->error ) ) {

				$error = '';
				if ( ! empty( $response->error->code ) ) {
					$error .= $response->error->code . ': ';
				}
				if ( ! empty( $response->error->description ) ) {
					$error .= $response->error->description;
				}
				$output .= '<div class="yelp-error">' . esc_html( $error ) . '</div>';

			} else {

				if ( isset( $response->businesses ) ) {
					$businesses = $response->businesses;
				} else {
					$businesses = array( $response );
				}

				if ( ! count( $businesses ) ) {
					// Skip
					continue;
				}

				$output .= '<div class="yelp-places-group">';
				$output .= sprintf( '<h4 class="yelp-places-group-title"><i class="%s"></i><span>%s</span></h4>', esc_attr( $term['icon'] ), esc_html( $term['name'] ) );
				$output .= '<ul class="yelp-places-list">';
				foreach ( $businesses as $business ) {
					$output .= '<li class="yelp-places-list-item">';
					$output .= '<div class="content-left-side">';
					if ( isset( $business->name ) ) {
						$output .= '<span class="yelp-place-title">' . esc_html( $business->name ) . '</span>';
					}
					if ( isset( $response->region->center ) ) {
						$distance    = true;
						$current_lat = $response->region->center->latitude;
						$current_lng = $response->region->center->longitude;
					}
					if ( $distance && isset( $business->coordinates ) ) {
						$location_lat      = $business->coordinates->latitude;
						$location_lng      = $business->coordinates->longitude;
						$d_location_lat    = deg2rad( $location_lat );
						$d_current_lat     = deg2rad( $current_lat );
						$theta             = $current_lng - $location_lng;
						$theta             = deg2rad( $theta );
						$dist              = sin( $d_current_lat ) * sin( $d_location_lat ) + cos( $d_current_lat ) * cos( $d_location_lat ) * cos( $theta );
						$dist              = acos( $dist );
						$dist              = rad2deg( $dist );
						$location_distance = round( ( $dist * 60 * $yelp_dist_unit ), 2 );
						$output            .= sprintf( ' <span class="yelp-place-distance">%s %s</span>', esc_html( $location_distance ), esc_html( $yelp_dist_unit_text ) );
					}
					$output .= '</div>';
					$output .= '<div class="content-right-side">';
					if ( isset( $business->review_count ) ) {
						$output .= '<span class="yelp-place-review">';
						$output .= sprintf( '<span class="yelp-place-review-count">%s</span> <span class="yelp-place-review-text">%s</span>', esc_html( $business->review_count ), esc_html__( 'Reviews', 'framework' ) );
						$output .= '</span>';
					}
					if ( isset( $business->rating ) ) {
						$output .= '<span class="yelp-place-rating rating-' . esc_attr( str_replace( '.', '-', $business->rating ) ) . '"></span>';
					}
					$output .= '</div>';
					$output .= '</li>';
				}
				$output .= '</ul>';
				$output .= '</div>';
			}
		}

		$output .= '<p class="yelp-logo">' . esc_html__( 'powered by', 'framework' ) . '<img src="' . get_template_directory_uri() . '/common/images/yelp-logo.png" alt="yelp"></p>';
		$output .= '</div>';

		return $output;
	}
}

if ( ! function_exists( 'inspiry_get_yelp_term' ) ) {
	/**
	 * Returns the term from preset terms if exists.
	 *
	 * @since 3.10
	 *
	 * @param $term
	 *
	 * @return bool|mixed
	 */
	function inspiry_get_yelp_term( $term ) {
		$terms = array(
			'active'             => array(
				'name' => esc_html__( 'Active Life', 'framework' ),
				'icon' => 'fas fa-bicycle'
			),
			'arts'               => array(
				'name' => esc_html__( 'Arts & Entertainment', 'framework' ),
				'icon' => 'far fa-image'
			),
			'auto'               => array(
				'name' => esc_html__( 'Automotive', 'framework' ),
				'icon' => 'fas fa-car'
			),
			'beautysvc'          => array(
				'name' => esc_html__( 'Beauty & Spas', 'framework' ),
				'icon' => 'fas fa-spa'
			),
			'education'          => array(
				'name' => esc_html__( 'Education', 'framework' ),
				'icon' => 'fas fa-graduation-cap'
			),
			'eventservices'      => array(
				'name' => esc_html__( 'Event Planning & Services', 'framework' ),
				'icon' => 'fas fa-birthday-cake'
			),
			'financialservices'  => array(
				'name' => esc_html__( 'Financial Services', 'framework' ),
				'icon' => 'far fa-money-bill-alt'
			),
			'food'               => array(
				'name' => esc_html__( 'Food', 'framework' ),
				'icon' => 'fas fa-shopping-basket'
			),
			'health'             => array(
				'name' => esc_html__( 'Health & Medical', 'framework' ),
				'icon' => 'fas fa-medkit'
			),
			'homeservices'       => array(
				'name' => esc_html__( 'Home Services ', 'framework' ),
				'icon' => 'fas fa-wrench'
			),
			'hotelstravel'       => array(
				'name' => esc_html__( 'Hotels & Travel', 'framework' ),
				'icon' => 'fas fa-bed'
			),
			'localflavor'        => array(
				'name' => esc_html__( 'Local Flavor', 'framework' ),
				'icon' => 'fas fa-coffee'
			),
			'localservices'      => array(
				'name' => esc_html__( 'Local Services', 'framework' ),
				'icon' => 'far fa-dot-circle'
			),
			'massmedia'          => array(
				'name' => esc_html__( 'Mass Media', 'framework' ),
				'icon' => 'fas fa-tv'
			),
			'nightlife'          => array(
				'name' => esc_html__( 'Nightlife', 'framework' ),
				'icon' => 'fas fa-glass-martini'
			),
			'pets'               => array(
				'name' => esc_html__( 'Pets', 'framework' ),
				'icon' => 'fas fa-paw'
			),
			'professional'       => array(
				'name' => esc_html__( 'Professional Services', 'framework' ),
				'icon' => 'fas fa-suitcase'
			),
			'publicservicesgovt' => array(
				'name' => esc_html__( 'Public Services & Government', 'framework' ),
				'icon' => 'fas fa-university'
			),
			'realestate'         => array(
				'name' => esc_html__( 'Real Estate', 'framework' ),
				'icon' => 'far fa-building'
			),
			'religiousorgs'      => array(
				'name' => esc_html__( 'Religious Organizations', 'framework' ),
				'icon' => 'fas fa-universal-access'
			),
			'restaurants'        => array(
				'name' => esc_html__( 'Restaurants', 'framework' ),
				'icon' => 'fas fa-utensils'
			),
			'shopping'           => array(
				'name' => esc_html__( 'Shopping', 'framework' ),
				'icon' => 'fas fa-shopping-bag'
			),
			'transport'          => array(
				'name' => esc_html__( 'Transportation', 'framework' ),
				'icon' => 'fas fa-bus'
			)
		);

		if ( isset( $terms[ $term ] ) ) {
			return $terms[ $term ];
		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_agent_custom_form' ) ) {
	/**
	 * Displays the agent custom contact form.
	 *
	 * @since 3.10
	 *
	 * @param string $agent_id
	 *
	 * @param bool $container
	 */
	function inspiry_agent_custom_form( $agent_id = '', $container = true ) {
		$form = inspiry_get_agent_custom_form( $agent_id );
		if ( $form ) {
			if ( $container ) {
				echo '<div class="agent-custom-contact-form">' . do_shortcode( $form ) . '</div>';
			} else {
				echo do_shortcode( $form );
			}
		}
	}
}

if ( ! function_exists( 'inspiry_get_agent_custom_form' ) ) {
	/**
	 * Returns the agent custom contact form shortcode if exists.
	 *
	 * @since 3.10
	 *
	 * @param string $agent_id
	 *
	 * @return bool|mixed
	 */
	function inspiry_get_agent_custom_form( $agent_id = '' ) {

		if ( empty( $agent_id ) ) {
			$agent_id = get_the_ID();
		}

		$metabox_form = get_post_meta( $agent_id, 'REAL_HOMES_custom_agent_contact_form', true );
		if ( ! empty( $metabox_form ) ) {
			return $metabox_form;
		}

		$customizer_form = get_option( 'theme_custom_agent_contact_form' );
		if ( ! empty( $customizer_form ) ) {
			return $customizer_form;
		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_is_property_analytics_enabled' ) ) {
	/**
	 * Check property analytics feature is enabled or disabled.
	 */
	function inspiry_is_property_analytics_enabled() {
		return 'enabled' === get_option( 'inspiry_property_analytics_status', 'disabled' );
	}
}

if ( ! function_exists( 'inspiry_agency_custom_form' ) ) {
	/**
	 * Displays the agency custom contact form.
	 *
	 * @since 3.10
	 *
	 * @param string $agency_id
	 *
	 * @param bool $container
	 */
	function inspiry_agency_custom_form( $agency_id = '', $container = true ) {
		$form = inspiry_get_agency_custom_form( $agency_id );
		if ( $form ) {
			if ( $container ) {
				echo '<div class="agent-custom-contact-form agency-custom-contact-form">' . do_shortcode( $form ) . '</div>';
			} else {
				echo do_shortcode( $form );
			}
		}
	}
}

if ( ! function_exists( 'inspiry_get_agency_custom_form' ) ) {
	/**
	 * Returns the agency custom contact form shortcode if exists.
	 *
	 * @since 3.10
	 *
	 * @param string $agency_id
	 *
	 * @return bool|mixed
	 */
	function inspiry_get_agency_custom_form( $agency_id = '' ) {

		if ( empty( $agency_id ) ) {
			$agency_id = get_the_ID();
		}

		$metabox_form = get_post_meta( $agency_id, 'REAL_HOMES_custom_agency_contact_form', true );
		if ( ! empty( $metabox_form ) ) {
			return $metabox_form;
		}

		$customizer_form = get_option( 'theme_custom_agency_contact_form' );
		if ( ! empty( $customizer_form ) ) {
			return $customizer_form;
		}

		return false;
	}
}

if ( ! function_exists( 'inspiry_get_property_single_template' ) ) {
	/**
	 * Sets the user selected template for property detail page using customizer setting.
	 *
	 * @param string $original_template
	 *
	 * @return string
	 */
	function inspiry_get_property_single_template( $original_template ) {

		if ( ! is_singular( 'property' ) ) {
			return $original_template;
		}

		if ( 'fullwidth' === get_option( 'inspiry_property_single_template', 'sidebar' ) ) {
			$global_property_template_override = get_post_meta( get_the_ID(), 'inspiry_global_property_template_override', true );
			$property_template                 = get_post_meta( get_the_ID(), '_wp_page_template', true );

			if ( ( '1' !== $global_property_template_override ) && ( 'default' === $property_template || empty( $property_template ) ) ) {
				$template = 'templates/property-full-width-layout.php';
				$located  = locate_template( $template );
				if ( $located && ! empty( $located ) ) {
					return $located;
				}
			}
		}

		return $original_template;
	}

	add_filter( 'single_template', 'inspiry_get_property_single_template' );
}

if ( ! function_exists( 'inspiry_property_single_template_body_classes' ) ) {
	/**
	 * Add classes to the body tag for property single template.
	 *
	 * @param $classes
	 *
	 * @return array
	 */
	function inspiry_property_single_template_body_classes( $classes ) {
		if ( is_singular( 'property' ) ) {
			if ( 'fullwidth' === get_option( 'inspiry_property_single_template', 'sidebar' ) ) {
				$classes[] = 'property-template-templates';
				$classes[] = 'property-template-property-full-width-layout';
				$classes   = array_diff( $classes, array( 'property-template-default' ) );
			}
		}

		return $classes;
	}

	add_filter( 'body_class', 'inspiry_property_single_template_body_classes' );
}

if ( ! function_exists( 'inspiry_term_description' ) ) {
	/**
	 * Displays the term description.
	 *
	 * @param int $term Optional. Term ID. Will use global term ID by default.
	 *
	 * @since 3.10.2
	 */
	function inspiry_term_description( $term = 0 ) {
		if ( 'show' === get_option( 'inspiry_term_description', 'hide' ) ) {
			$description = term_description( $term );
			if ( ! empty( $description ) ) {
				$wrapper = '<div class="inspiry-term-description">%s</div>';
				printf( $wrapper, $description );
			}
		}
	}
}

if ( ! function_exists( 'inspiry_pages' ) ) {
	/**
	 * Return an array of pages as ID & Title pair each.
	 *
	 * @since  3.10.2
	 *
	 * @param  array $args Custom query arguments.
	 *
	 * @return array       List of pages as an array.
	 */
	function inspiry_pages( $args = array() ) {
		$default_args = array(
			'post_type'      => 'page',
			'posts_per_page' => - 1,
		);
		$args = wp_parse_args( $args, $default_args );
		$inspiry_pages = array( 0 => esc_html__( 'None', 'framework' ) );
		$raw_pages     = get_posts( $args );
		if ( 0 < count( $raw_pages ) ) {
			foreach ( $raw_pages as $single_page ) {
				$inspiry_pages[ $single_page->ID ] = $single_page->post_title;
			}
		}
		return $inspiry_pages;
	}
}

if ( ! function_exists( 'realhomes_similar_properties_filters' ) ) {
	/**
	 * Prints the filters markup for similar properties on single property page.
	 *
	 * @since  3.13
	 *
	 * @param string $design
	 *
	 * @return mixed
	 */
	function realhomes_similar_properties_filters( $design = 'modern' ) {

		// Return if filters are disabled from customizer setting.
		if ( 'disable' === get_option( 'inspiry_similar_properties_frontend_filters', 'disable' ) ) {
			return false;
		}

		// Default values
		$similar_properties_default_filters = array(
			'property-feature' => esc_html__( 'Property Features', 'framework' ),
			'property-type'    => esc_html__( 'Property Type', 'framework' ),
			'property-city'    => esc_html__( 'Property Location', 'framework' ),
			'property-status'  => esc_html__( 'Property Status', 'framework' ),
			'property-agent'   => esc_html__( 'Property Agent', 'framework' ),
		);

		// Get the selected filters from customizer settings.
		$similar_properties_filters = get_option( 'inspiry_similar_properties_filters', array_keys( $similar_properties_default_filters ) );
		if ( ! empty( $similar_properties_filters ) && is_array( $similar_properties_filters ) ) {

			$btn_class         = 'rh-btn rh-btn-primary';
			$btn_class_current = 'rh-btn rh-btn-secondary';
			if ( 'classic' === $design ) {
				$btn_class         = 'real-btn';
				$btn_class_current = 'real-btn';
			}

			$output = sprintf( '<div id="%1$s" class="%1$s">', 'similar-properties-filters-wrapper' );
			$output .= sprintf( '<a class="%s current" href="#recommended" data-similar-properties-filter="recommended">%s</a>', esc_attr( $btn_class_current ), esc_html__( 'Recommended', 'framework' ) );

			foreach ( $similar_properties_filters as $similar_properties_filter ) {
				$output .= sprintf( '<a class="%1$s" href="#%2$s" data-similar-properties-filter="%2$s">%3$s</a>', esc_attr( $btn_class ), $similar_properties_filter, $similar_properties_default_filters[ $similar_properties_filter ] );
			}

			$output .= '</div>';

			// Print the filters markup
			echo $output;
		}
	}
}

if ( ! function_exists( 'realhomes_filter_similar_properties' ) ) {
	/**
	 * Returns the similar properties markup.
	 *
	 * @since  3.13
	 */
	function realhomes_filter_similar_properties() {

		// Default values
		$similar_properties_default_filters = array(
			'property-feature' => esc_html__( 'Property Features', 'framework' ),
			'property-type'    => esc_html__( 'Property Type', 'framework' ),
			'property-city'    => esc_html__( 'Property Location', 'framework' ),
			'property-status'  => esc_html__( 'Property Status', 'framework' ),
			'property-agent'   => esc_html__( 'Property Agent', 'framework' ),
		);

		// Get the selected filters from customizer settings.
		$similar_properties_filters = get_option( 'inspiry_similar_properties_filters', array_keys( $similar_properties_default_filters ) );

		$property_filter = '';
		if ( isset( $_POST['property_filter'] ) && ! empty( $_POST['property_filter'] ) ) {
			$property_filter = $_POST['property_filter'];
		}

		if ( ! empty( $similar_properties_filters ) && in_array( $property_filter, $similar_properties_filters ) ) {

			$property_id = 0;
			if ( isset( $_POST['property_id'] ) && ! empty( $_POST['property_id'] ) ) {
				$property_id = intval( $_POST['property_id'] );
			}

			$properties_per_page = 2;
			if ( isset( $_POST['properties_per_page'] ) && ! empty( $_POST['properties_per_page'] ) ) {
				$properties_per_page = $_POST['properties_per_page'];
			}

			$similar_properties_args = array(
				'post_type'           => 'property',
				'posts_per_page'      => intval( $properties_per_page ),
				'post__not_in'        => array( $property_id ),
				'post_parent__not_in' => array( $property_id ), // To avoid child posts from appearing in similar properties.
				'post_status'         => array( 'publish' )
			);

			// Sort Properties Based on Theme Option Selection
			$similar_properties_sorty_by = get_option( 'inspiry_similar_properties_sorty_by' );
			if ( ! empty( $similar_properties_sorty_by ) ) {
				if ( 'low-to-high' == $similar_properties_sorty_by ) {
					$similar_properties_args['orderby']  = 'meta_value_num';
					$similar_properties_args['meta_key'] = 'REAL_HOMES_property_price';
					$similar_properties_args['order']    = 'ASC';
				} elseif ( 'high-to-low' == $similar_properties_sorty_by ) {
					$similar_properties_args['orderby']  = 'meta_value_num';
					$similar_properties_args['meta_key'] = 'REAL_HOMES_property_price';
					$similar_properties_args['order']    = 'DESC';
				} elseif ( 'random' == $similar_properties_sorty_by ) {
					$similar_properties_args['orderby'] = 'rand';
				}
			}

			if ( 'property-agent' === $property_filter ) {
				$property_agents                       = get_post_meta( $property_id, 'REAL_HOMES_agents' );
				$similar_properties_args['meta_query'] = array(
					array(
						'key'     => 'REAL_HOMES_agents',
						'value'   => ( empty( $property_agents ) ? 0 : $property_agents ),
						'compare' => 'IN',
					),
				);
			} else {
				// Property Taxonomies Array
				$terms_array    = array();
				$property_terms = get_the_terms( $property_id, $property_filter );

				if ( ! empty( $property_terms ) && is_array( $property_terms ) ) {
					foreach ( $property_terms as $property_term ) {
						$terms_array[] = $property_term->term_id;
					}
				}

				$similar_properties_args['tax_query'] = array(
					array(
						'taxonomy'         => $property_filter,
						'terms'            => $terms_array,
						'include_children' => false
					)
				);
			}

			// Similar properties query.
			$similar_properties_query = new WP_Query( $similar_properties_args );

			if ( $similar_properties_query->have_posts() ) {
				while ( $similar_properties_query->have_posts() ) {
					$similar_properties_query->the_post();

					if ( isset( $_POST['design'] ) && 'classic' === $_POST['design'] ) {
						get_template_part( 'assets/classic/partials/property/single/similar-property-card' );
					} else {
						get_template_part( 'assets/modern/partials/property/single/similar-property-card' );
					}
				}
				wp_reset_postdata();
			} else {
				printf( '<div class="no-similar-property-found"><p>%s</p></div>', esc_html__( 'No property found for this criteria.', 'framework' ) );
			}
		} else {
			printf( '<div class="no-similar-property-found"><p>%s</p></div>', esc_html__( 'Invalid property filter provided.', 'framework' ) );
		}

		wp_die();
	}

	add_action( 'wp_ajax_realhomes_filter_similar_properties', 'realhomes_filter_similar_properties' );
	add_action( 'wp_ajax_nopriv_realhomes_filter_similar_properties', 'realhomes_filter_similar_properties' );
}

if ( ! function_exists( 'inspiry_lightbox_map_theme_essentials' ) ) {

	/**
	 * Get default values for map icons, marker type and color
	 */

	function inspiry_lightbox_map_theme_essentials() {

		$map_type = inspiry_get_maps_type();
		if ( 'google-maps' == $map_type ) {
			wp_register_script( 'lightbox-google-map', get_theme_file_uri( 'common/js/lightbox-google-map.js' ), array( 'jquery', 'google-map-api' ), INSPIRY_THEME_VERSION, true );

		} else {
			wp_register_script( 'lightbox-open-street-map', get_theme_file_uri( 'common/js/lightbox-open-street-map.js' ), array( 'jquery', 'leaflet' ), INSPIRY_THEME_VERSION, true );
		}


		$property_map_data = array();


		// Property map icon based on Property Type
		$type_terms = get_the_terms( get_the_ID(), 'property-type' );
		if ( $type_terms && ! is_wp_error( $type_terms ) ) {
			foreach ( $type_terms as $type_term ) {
				$icon_id = get_term_meta( $type_term->term_id, 'inspiry_property_type_icon', true );
				if ( ! empty ( $icon_id ) ) {
					$icon_url = wp_get_attachment_url( $icon_id );
					if ( $icon_url ) {
						$property_map_data['icon'] = esc_url( $icon_url );

						// Retina icon
						$retina_icon_id = get_term_meta( $type_term->term_id, 'inspiry_property_type_icon_retina', true );
						if ( ! empty ( $retina_icon_id ) ) {
							$retina_icon_url = wp_get_attachment_url( $retina_icon_id );
							if ( $retina_icon_url ) {
								$property_map_data['retinaIcon'] = esc_url( $retina_icon_url );
							}
						}
						break;
					}
				}
			}
		}

		// Set default icons if above code fails to sets any
		if ( ! isset( $property_map_data['icon'] ) ) {
			$property_map_data['icon']       = INSPIRY_DIR_URI . '/images/map/single-family-home-map-icon.png';           // default icon
			$property_map_data['retinaIcon'] = INSPIRY_DIR_URI . '/images/map/single-family-home-map-icon@2x.png';  // default retina icon
		}

		// Set Google Map Type & Zoom Level
		$property_map_data['marker_type']  = get_option( 'inspiry_property_map_marker_type', 'pin' );
		$property_map_data['marker_color'] = get_option( 'inspiry_property_map_marker_color', '#ea723d' );

		$property_map_data['styles'] = '';
		$styles_json                 = get_option( 'inspiry_google_maps_styles' );
		if ( ! empty( $styles_json ) ) {
			$property_map_data['styles'] = stripslashes( $styles_json );
		}

		$property_map_data['type'] = get_option( 'inspiry_property_map_type', 'roadmap' );


		$map_type = inspiry_get_maps_type();
		if ( 'google-maps' == $map_type ) {
			wp_localize_script( 'lightbox-google-map', 'propertyMapData', $property_map_data );
			wp_enqueue_script( 'lightbox-google-map' );
		} else {
			wp_localize_script( 'lightbox-open-street-map', 'propertyMapData', $property_map_data );
			wp_enqueue_script( 'lightbox-open-street-map' );
		}



	}
}

if ( ! function_exists( 'rh_stylish_meta' ) ) {

	function rh_stylish_meta( $label, $post_meta_key, $icon, $postfix = '' ) {

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
						include INSPIRY_THEME_DIR . '/icons/' . $icon . '.svg';
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
if ( ! function_exists( 'rh_stylish_meta_smart' ) ) {

	function rh_stylish_meta_smart( $label, $post_meta_key, $icon, $postfix = '' ) {

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
                    <span data-tooltip="<?php echo esc_html( $label ) ?>">
					<?php
					if ( $icon ) {
						include INSPIRY_THEME_DIR . '/icons/' . $icon . '.svg';
					}
					?>
                    </span>
                    <span class="rh_meta_smart_box">
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

if ( ! function_exists( 'rh_lightbox_data_attributes' ) ) {

	function rh_lightbox_data_attributes( $widget_id, $post_id, $classes = '' ) {

		if ( inspiry_map_needed_for_address() ) {

			$REAL_HOMES_property_map = get_post_meta( $post_id, 'REAL_HOMES_property_map', true );
			$property_location       = get_post_meta( $post_id, 'REAL_HOMES_property_location', true );

			if ( has_post_thumbnail() ) {
				$image_id         = get_post_thumbnail_id();
				$image_attributes = wp_get_attachment_image_src( $image_id, 'property-thumb-image' );
				if ( ! empty( $image_attributes[0] ) ) {
					$current_property_data = $image_attributes[0];
				}
			} else {
				$current_property_data = get_inspiry_image_placeholder_url( 'property-thumb-image' );
			}

			if ( ! empty( $property_location ) && $REAL_HOMES_property_map !== '1' ) {
				?>
                class="rhea_trigger_map rhea_facnybox_trigger-<?php echo esc_attr( $widget_id . ' ' . $classes ); ?>"
                data-rhea-map-source="rhea-map-source-<?php echo esc_attr( $widget_id ); ?>"
                data-rhea-map-location="<?php echo esc_attr( $property_location ); ?>"
                data-rhea-map-title="<?php echo esc_attr( get_the_title() ); ?>"
                data-rhea-map-price="<?php echo esc_attr( ere_get_property_price() ); ?>"
                data-rhea-map-thumb="<?php echo esc_attr( $current_property_data ) ?>"
				<?php
			}
		}
	}
}

if ( ! function_exists( 'rh_rvr_rating_average' ) ) {
	/**
	 * Display rating average based on approved comments with rating
	 */
	function rh_rvr_rating_average() {

		$args = array(
			'post_id' => get_the_ID(),
			'status'  => 'approve',
		);

		$comments = get_comments( $args );
		$ratings  = array();
		$count    = 0;

		foreach ( $comments as $comment ) {

			$rating = get_comment_meta( $comment->comment_ID, 'inspiry_rating', true );

			if ( ! empty( $rating ) ) {
				$ratings[] = absint( $rating );
				$count ++;
			}
		}


		$allowed_html = array(
			'span' => array(
				'class' => array(),
			),
			'i'    => array(
				'class' => array(),
			),
		);

		if ( 0 !== count( $ratings ) ) {

			$values_count = ( array_count_values( $ratings ) );


			$avg = round( array_sum( $ratings ) / count( $ratings ), 2 );
			?>
            <div class="rh_rvr_ratings">
                <div class="rh_stars_avg_rating"
                     title="<?php echo esc_html( $avg ) . ' / ' . esc_html__( '5 based on', 'framework' ) . ' ' . esc_html( $count ) . ' ' . esc_html__( 'reviews', 'framework' );
				     ?>"
                >
					<?php
					echo wp_kses( rhea_rating_stars( $avg ), $allowed_html );
					?>

                    <div class="rh_wrapper_rating_info">

						<?php


						$i = 5;
						while ( $i > 0 ) {
							?>
                            <p class="rh_rating_percentage">
                            <span class="rh_rating_sorting_label">
                                <?php
                                printf( _nx( '%s Star', '%s Stars', $i, 'Rating Stars', 'framework' ), number_format_i18n( $i ) );
                                ?>
                            </span>
								<?php
								if ( isset( $values_count[ $i ] ) && ! empty( $values_count[ $i ] ) ) {
									$stars = round( ( $values_count[ $i ] / ( count( $ratings ) ) ) * 100 );
								} else {
									$stars = 0;
								}
								?>

                                <span class="rh_rating_line">
                                <span class="rh_rating_line_inner"
                                      style="width: <?php echo esc_attr( $stars ); ?>%"></span>
                            </span>

                                <span class="rh_rating_text">
                            <span class="rh_rating_text_inner">

                                <?php echo esc_html( $stars ) . '%' ?>
                            </span>
                            </span>
                            </p>
							<?php

							$i --;
						}
						?>


                    </div>
                </div>
            </div>
			<?php

		}
	}
}


if ( ! function_exists( 'realhomes_property_agent_contact_methods' ) ) {
	/**
	 * Displays the whatsApp and call now buttons.
	 *
	 * @since 3.14.0
	 *
	 * @param string $contact_number
	 * @param string $whatsapp_number
	 * @param string $btn_class
	 */
	function realhomes_property_agent_contact_methods( $contact_number = '', $whatsapp_number = '', $btn_class = '' ) {

		if ( ! empty( $contact_number ) || ! empty( $whatsapp_number ) ) {

			if ( empty( $whatsapp_number ) ) {
				$whatsapp_number = $contact_number;
			}

			$args = array(
				'phone' => esc_html( $whatsapp_number )
			);

			$property_id    = get_the_ID();
			$property_title = get_the_title( $property_id );
			if ( ! empty( $property_title ) ) {
				$args['text'] = sprintf( esc_html__( "Hello, I'm interested in [%s] %s", 'framework' ), esc_html( $property_title ), esc_url( get_the_permalink( $property_id ) ) );
			}
			?>
            <a class="btn-whatsapp-chat <?php echo esc_attr( $btn_class ); ?>"
               href="<?php echo esc_url( add_query_arg( $args, 'https://api.whatsapp.com/send' ) ); ?>"
               target="_blank">
				<?php inspiry_safe_include_svg( '/images/icon-whatsapp.svg', '/common/' ); ?>
                <span class="btn-text"><?php echo esc_html( realhomes_get_agent_whatsapp_button_label() ); ?></span>
            </a>
			<?php
			if ( ! empty( $contact_number ) ) :
				?>
                <a class="btn-call-now <?php echo esc_attr( $btn_class ); ?>"
                   href="tel:<?php echo esc_attr( $contact_number ); ?>">
					<?php inspiry_safe_include_svg( '/images/icon-phone.svg', '/common/' ); ?>
                    <span class="btn-text"><?php echo esc_html( realhomes_get_agent_callnow_button_label() ); ?></span>
                </a>
			<?php
			endif;
		}
	}
}


if ( ! function_exists( 'realhomes_property_agent_sticky_bar' ) ) {
	/**
	 * Displays property agent contact methods sticky bar on mobile.
	 *
	 * @since 3.14.0
	 */
	function realhomes_property_agent_sticky_bar() {

		// Return if the page is not a single property page.
		if ( ! is_singular( 'property' ) ) {
			return false;
		}

		$property_id          = get_the_ID();
		$display_agent_info   = get_option( 'theme_display_agent_info' );
		$agent_display_option = get_post_meta( $property_id, 'REAL_HOMES_agent_display_option', true );

		// Display content if the agent related options are enabled.
		if ( ( 'true' === $display_agent_info ) && ( 'none' != $agent_display_option ) ) {

			// Collect agent information.
			$agent_args = array( 'agent_id' => '' );

			if ( 'my_profile_info' == $agent_display_option ) {
				$agent_args['display_author']      = true;
				$agent_args['author_id']           = get_the_author_meta( 'ID' );
				$agent_args['author_display_name'] = get_the_author_meta( 'display_name' );
				$agent_args['profile_image_id']    = intval( get_the_author_meta( 'profile_image_id' ) );
				$agent_args['agent_mobile']        = get_the_author_meta( 'mobile_number' );
				$agent_args['agent_whatsapp']      = get_the_author_meta( 'mobile_whatsapp' );
			} else {
				$property_agents = get_post_meta( $property_id, 'REAL_HOMES_agents' );

				// Remove invalid ids.
				$property_agents = array_filter( $property_agents, function ( $v ) {
					return ( $v > 0 );
				} );

				// Remove duplicated ids.
				$property_agents = array_unique( $property_agents );

				if ( ! empty( $property_agents ) ) {
					foreach ( $property_agents as $agent ) {
						$agent_args['agent_id']         = intval( $agent );
						$agent_args['agent_title_text'] = esc_html( get_the_title( $agent_args['agent_id'] ) );
						$agent_args['agent_mobile']     = get_post_meta( $agent_args['agent_id'], 'REAL_HOMES_mobile_number', true );
						$agent_args['agent_whatsapp']   = get_post_meta( $agent_args['agent_id'], 'REAL_HOMES_whatsapp_number', true );

						break;
					}
				}
			}

			$agent_id = $agent_args['agent_id'];
			?>
            <div id="property-agent-contact-methods-wrapper" class="property-agent-contact-methods-wrapper">
                <div class="property-agent-details">
					<?php
					if ( isset( $agent_args['display_author'] ) && ( $agent_args['display_author'] ) ) {
						if ( isset( $agent_args['profile_image_id'] ) && ( 0 < $agent_args['profile_image_id'] ) ) {
							echo wp_get_attachment_image( $agent_args['profile_image_id'], 'agent-image' );
						} elseif ( isset( $agent_args['agent_email'] ) ) {
							echo get_avatar( $agent_args['agent_email'], '210' );
						}
					} else {
						if ( isset( $agent_id ) && has_post_thumbnail( $agent_id ) ) :
							?>
                            <a href="<?php echo esc_url( get_permalink( $agent_id ) ); ?>">
								<?php echo get_the_post_thumbnail( $agent_id, 'agent-image' ); ?>
                            </a>
						<?php
						endif;
					}

					if ( isset( $agent_args['agent_title_text'] ) && ! empty( $agent_args['agent_title_text'] ) ) : ?>
                        <h4 class="property-agent-name">
                            <a href="<?php echo esc_url( get_permalink( $agent_id ) ); ?>"><?php echo esc_html( $agent_args['agent_title_text'] ); ?></a>
                        </h4>
					<?php
					endif;
					?>
                </div><!-- .property-agent-details -->
                <div class="property-agent-contact-methods">
					<?php
					$agent_contact_form = get_option( 'inspiry_property_agent_form', 'true' );
					if ( ! empty( $agent_id ) && 'true' === $agent_contact_form ) :
						?>
                        <a id="scroll-to-property-agent-form" class="agent-contact-method-btn agent-contact-method-mail-btn"
                           href="#<?php echo esc_attr( 'agent-form-id' . $agent_id ); ?>">
	                        <?php inspiry_safe_include_svg( '/images/icon-mail.svg', '/common/' ); ?>
                        </a>
					<?php
					endif;

					$contact_number  = $agent_args['agent_mobile'];
					$whatsapp_number = $agent_args['agent_whatsapp'];

					if ( ! empty( $contact_number ) || ! empty( $whatsapp_number ) ) :

						if ( empty( $whatsapp_number ) ) {
							$whatsapp_number = $contact_number;
						}

						$args = array(
							'phone' => esc_html( $whatsapp_number )
						);

						$property_title = get_the_title( $property_id );
						if ( ! empty( $property_title ) ) {
							$args['text'] = sprintf( esc_html__( "Hello, I'm interested in [%s] %s", 'framework' ), esc_html( $property_title ), esc_url( get_the_permalink( $property_id ) ) );
						}
						?>
                        <a class="agent-contact-method-btn agent-contact-method-whatsapp-btn" href="<?php echo esc_url( add_query_arg( $args, 'https://api.whatsapp.com/send' ) ); ?>" target="_blank">
	                        <?php inspiry_safe_include_svg( '/images/icon-whatsapp.svg', '/common/' ); ?>
                        </a>
						<?php
						if ( ! empty( $contact_number ) ) :
							?>
                            <a class="agent-contact-method-btn agent-contact-method-call-btn" href="tel:<?php echo esc_attr( $contact_number ); ?>">
	                            <?php inspiry_safe_include_svg( '/images/icon-phone.svg', '/common/' ); ?>
                            </a>
						<?php
						endif;
					endif;
					?>
                </div><!-- .property-agent-contact-methods -->
            </div>
			<?php
		}
	}

	add_action( 'wp_footer', 'realhomes_property_agent_sticky_bar', 10 );
}


if ( ! function_exists( 'realhomes_get_agent_default_message' ) ) {
	/**
	 * Returns Agent form's default message.
	 */
	function realhomes_get_agent_default_message(){
		return get_option( 'realhomes_agent_form_default_message', esc_html__( 'Hello, I am interested in [%s]', 'framework' ) );
	}
}

if ( ! function_exists( 'realhomes_get_agent_whatsapp_button_label' ) ) {
	/**
	 * Returns Agent WhatsApp Button Label
	 */
	function realhomes_get_agent_whatsapp_button_label(){
		return get_option( 'realhomes_agent_whatsapp_button_label', esc_html__( 'WhatsApp', 'framework' ) );
	}
}

if ( ! function_exists( 'realhomes_get_agent_callnow_button_label' ) ) {
	/**
	 * Returns Agent WhatsApp Button Label
	 */
	function realhomes_get_agent_callnow_button_label(){
		return get_option( 'realhomes_agent_callnow_button_label', esc_html__( 'Call Now', 'framework' ) );
	}
}