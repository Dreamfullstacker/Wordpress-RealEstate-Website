<?php
/**
 * Contains Basic Functions for RealHomes Elementor Addon plugin.
 */

/**
 * Get template part for RHEA plugin.
 *
 * @access public
 *
 * @param mixed $slug Template slug.
 * @param string $name Template name (default: '').
 */
function rhea_get_template_part( $slug, $name = '' ) {
	$template = '';

	// Get slug-name.php.
	if ( ! $template && $name && file_exists( RHEA_PLUGIN_DIR . "/{$slug}-{$name}.php" ) ) {
		$template = RHEA_PLUGIN_DIR . "/{$slug}-{$name}.php";
	}

	// Get slug.php.
	if ( ! $template && file_exists( RHEA_PLUGIN_DIR . "/{$slug}.php" ) ) {
		$template = RHEA_PLUGIN_DIR . "/{$slug}.php";
	}

	// Allow 3rd party plugins to filter template file from their plugin.
	$template = apply_filters( 'rhea_get_template_part', $template, $slug, $name );

	if ( $template ) {
		load_template( $template, false );
	}
}


if ( ! function_exists( 'rhea_allowed_tags' ) ) :
	/**
	 * Returns array of allowed tags to be used in wp_kses function.
	 *
	 * @return array
	 */
	function rhea_allowed_tags() {

		return array(
			'a'      => array(
				'href'  => array(),
				'title' => array(),
				'alt'   => array(),
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

	}
endif;


if ( ! function_exists( 'rhea_list_gallery_images' ) ) {
	/**
	 * Get list of Gallery Images - use in gallery post format
	 *
	 * @param string $size
	 */
	function rhea_list_gallery_images( $size = 'post-featured-image' ) {

		$gallery_images = rwmb_meta( 'REAL_HOMES_gallery', 'type=plupload_image&size=' . $size, get_the_ID() );

		if ( ! empty( $gallery_images ) ) {
			foreach ( $gallery_images as $gallery_image ) {
				$caption = ( ! empty( $gallery_image['caption'] ) ) ? $gallery_image['caption'] : $gallery_image['alt'];
				echo '<li><a href="' . esc_url( $gallery_image['full_url'] ) . '" title="' . esc_attr( $caption ) . '" data-fancybox="thumbnail-'.get_the_ID().'">';
				echo '<img src="' . esc_url( $gallery_image['url'] ) . '" alt="' . esc_attr( $gallery_image['title'] ) . '" />';
				echo '</a></li>';
			}
		} else if ( has_post_thumbnail( get_the_ID() ) ) {
			echo '<li><a href="' . get_permalink() . '" title="' . get_the_title() . '" >';
			the_post_thumbnail( $size );
			echo '</a></li>';
		}
	}
}


if ( ! function_exists( 'rhea_framework_excerpt' ) ) {
	/**
	 * Output custom excerpt of required length
	 *
	 * @param int $len number of words
	 * @param string $trim string to appear after excerpt
	 */
	function rhea_framework_excerpt( $len = 15, $trim = "&hellip;" ) {
		echo rhea_get_framework_excerpt( $len, $trim );
	}
}


if ( ! function_exists( 'rhea_get_framework_excerpt' ) ) {
	/**
	 * Returns custom excerpt of required length
	 *
	 * @param int $len number of words
	 * @param string $trim string after excerpt
	 *
	 * @return string
	 */
	function rhea_get_framework_excerpt( $len = 15, $trim = "&hellip;" ) {
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

if ( ! function_exists( 'rhea_get_framework_excerpt_by_id' ) ) {
	/**
	 * Returns custom excerpt of required length
	 *
	 * @param int $id post ID
	 * @param int $len number of words
	 * @param string $trim string after excerpt
	 *
	 * @return string
	 */
	function rhea_get_framework_excerpt_by_id( $id, $len = 15, $trim = "&hellip;" ) {
		$limit     = $len + 1;
		$excerpt   = explode( ' ', get_the_excerpt( $id ), $limit );
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


if ( ! function_exists( 'RHEA_ajax_pagination' ) ) {
	/**
	 * Function for Widgets AJAX pagination
	 *
	 * @param string $pages
	 */
	function RHEA_ajax_pagination( $pages = '' ) {

		global $wp_query;

		$paged = 1;
		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) { // if is static front page
			$paged = get_query_var( 'page' );
		}

		$prev          = $paged - 1;
		$next          = $paged + 1;
		$range         = 3;                             // change it to show more links
		$pages_to_show = ( $range * 2 ) + 1;

		if ( $pages == '' ) {
			$pages = $wp_query->max_num_pages;
			if ( ! $pages ) {
				$pages = 1;
			}
		}

		if ( 1 != $pages ) {
			echo "<div class='rhea_pagination_wrapper'>";
			echo "<div class='pagination rhea-pagination-clean'>";

			if ( ( $paged > 2 ) && ( $paged > $range + 1 ) && ( $pages_to_show < $pages ) ) {
				echo "<a href='" . get_pagenum_link( 1 ) . "' class='real-btn'> " . esc_html__( 'First', 'realhomes-elementor-addon' ) . "</a> "; // First Page
			}

			if ( ( $paged > 1 ) && ( $pages_to_show < $pages ) ) {
				echo "<a href='" . get_pagenum_link( $prev ) . "' class='real-btn'> " . esc_html__( 'Prev', 'realhomes-elementor-addon' ) . "</a> "; // Previous Page
			}

			$min_page_number = $paged - $range - 1;
			$max_page_number = $paged + $range + 1;

			for ( $i = 1; $i <= $pages; $i ++ ) {
				if ( ( ( $i > $min_page_number ) && ( $i < $max_page_number ) ) || ( $pages <= $pages_to_show ) ) {
					$current_class = 'real-btn';
					$current_class .= ( $paged == $i ) ? ' current' : '';
					echo "<a href='" . get_pagenum_link( $i ) . "' class='" . $current_class . "' >" . $i . "</a> ";
				}
			}

			if ( ( $paged < $pages ) && ( $pages_to_show < $pages ) ) {
				echo "<a href='" . get_pagenum_link( $next ) . "' class='real-btn'>" . esc_html__( 'Next', 'realhomes-elementor-addon' ) . " </a> "; // Next Page
			}

			if ( ( $paged < $pages - 1 ) && ( $paged + $range - 1 < $pages ) && ( $pages_to_show < $pages ) ) {
				echo "<a href='" . get_pagenum_link( $pages ) . "' class='real-btn'>" . esc_html__( 'Last', 'realhomes-elementor-addon' ) . " </a> "; // Last Page
			}

			echo "</div>";
			echo "</div>";
		}
	}
}

if ( ! function_exists( 'rhea_property_price' ) ) {
	/**
	 * Output property price
	 */
	function rhea_property_price() {
		echo rhea_get_property_price();
	}
}

if ( ! function_exists( 'rhea_get_property_price' ) ) {
	/**
	 * Returns property price in configured format
	 *
	 * @return mixed|string
	 */
	function rhea_get_property_price() {

		// get property price
		$price_digits = doubleval( get_post_meta( get_the_ID(), 'REAL_HOMES_property_price', true ) );

		if ( $price_digits ) {
			// get price prefix and postfix
			$price_pre_fix  = get_post_meta( get_the_ID(), 'REAL_HOMES_property_price_prefix', true );
			$price_post_fix = get_post_meta( get_the_ID(), 'REAL_HOMES_property_price_postfix', true );

			// if wp-currencies plugin installed and current currency cookie is set
			if ( class_exists( 'WP_Currencies' ) && isset( $_COOKIE["current_currency"] ) ) {
				$current_currency = $_COOKIE["current_currency"];
				if ( currency_exists( $current_currency ) ) {    // validate current currency
					$base_currency             = ere_get_base_currency();
					$converted_price           = convert_currency( $price_digits, $base_currency, $current_currency );
					$formatted_converted_price = format_currency( $converted_price, $current_currency );
					$formatted_converted_price = apply_filters( 'inspiry_property_converted_price', $formatted_converted_price, $price_digits );

					return $price_pre_fix . ' ' . $formatted_converted_price . ' ' . $price_post_fix;
				}
			}

			// otherwise go with default approach.
			$currency            = ere_get_currency_sign();
			$decimals            = intval( get_option( 'theme_decimals', '0' ) );
			$decimal_point       = get_option( 'theme_dec_point', '.' );
			$thousands_separator = get_option( 'theme_thousands_sep', ',' );
			$currency_position   = get_option( 'theme_currency_position', 'before' );
			$formatted_price     = number_format( $price_digits, $decimals, $decimal_point, $thousands_separator );
			$formatted_price     = apply_filters( 'inspiry_property_price', $formatted_price, $price_digits );

			if ( 'after' === $currency_position ) {
				return $price_pre_fix . ' ' . $formatted_price . $currency . ' <span>' . $price_post_fix . '</span>';
			} else {
				return $price_pre_fix . ' ' . $currency . $formatted_price . ' <span>' . $price_post_fix . '</span>';
			}

		} else {
			return ere_no_price_text();
		}
	}
}

if ( ! function_exists( 'rhea_display_property_label' ) ) {
	/**
	 * Display property label
	 *
	 * @param $post_id
	 */
	function rhea_display_property_label( $post_id ) {

		$label_text = get_post_meta( $post_id, 'inspiry_property_label', true );
		$color      = get_post_meta( $post_id, 'inspiry_property_label_color', true );
		if ( ! empty ( $label_text ) ) {
			?>
            <span style="background: <?php echo esc_attr( $color ); ?>"
                  class='rhea-property-label'><?php echo esc_html( $label_text ); ?></span>
			<?php

		}
	}
}

if ( ! function_exists( 'rhea_get_maps_type' ) ) {
	/**
	 * Returns the type currently available for use.
	 */
	function rhea_get_maps_type() {
		$google_maps_api_key = get_option( 'inspiry_google_maps_api_key', false );

		if ( ! empty( $google_maps_api_key ) ) {
			return 'google-maps';    // For Google Maps
		}

		return 'open-street-map';    // For OpenStreetMap https://www.openstreetmap.org/
	}
}

if ( ! function_exists( 'rhea_switch_currency_plain' ) ) {
	/**
	 * Convert and format given amount from base currency to current currency.
	 *
	 * @since  1.0.0
	 *
	 * @param  string $amount Amount in digits to change currency for.
	 *
	 * @return string
	 */
	function rhea_switch_currency_plain( $amount ) {

		if ( function_exists( 'realhomes_currency_switcher_enabled' ) && realhomes_currency_switcher_enabled() ) {
			$base_currency    = realhomes_get_base_currency();
			$current_currency = realhomes_get_current_currency();
			$converted_amount = realhomes_convert_currency( $amount, $base_currency, $current_currency );

			return apply_filters( 'realhomes_switch_currency', $converted_amount );
		}
	}
}


if ( ! function_exists( 'rhea_get_location_options' ) ) {

	/**
	 * Return Property Locations as Options List in Json format
	 */
	function rhea_get_location_options() {


		$options         = array(); // A list of location options will be passed to this array
		$number          = 15; // Number of locations that will be returned per Ajax request
		$locations_order = array(
			'orderby' => 'count',
			'order'   => 'desc',
		);

		$offset = '';
		if(isset($_GET['page'])){
			$offset          = $number * ( $_GET['page'] - 1 ); // Offset of locations list for the current Ajax request
		}

		if ( isset( $_GET['sortplpha'] ) && 'yes' == $_GET['sortplpha'] ) {
			$locations_order['orderby'] = 'name';
			$locations_order['order']   = 'asc';
		}


		if ( isset( $_GET['hideemptyfields'] ) && 'yes' == $_GET['hideemptyfields'] ) {
			$hide_empty_location = true;
		} else {
			$hide_empty_location = false;
		}


		// Prepare a query to fetch property locations from database
		$terms_query = array(
			'taxonomy'   => 'property-city',
			'number'     => $number,
			'offset'     => $offset,
			'hide_empty' => $hide_empty_location,
			'orderby'    => $locations_order['orderby'],
			'order'      => $locations_order['order'],
		);

		// If there is a search parameter
		if ( isset( $_GET['query'] ) ) {
			$terms_query['name__like'] = $_GET['query'];
		}

		$locations = get_terms( $terms_query );

		// Build an array of locations info form their objects
		if ( ! empty( $locations ) && ! is_wp_error( $locations ) ) {
			foreach ( $locations as $location ) {
				$options[] = array( $location->slug, $location->name );
			}
		}

		echo json_encode( $options ); // Return locations list in Json format
		die;
	}

	add_action( 'wp_ajax_rhea_get_location_options', 'rhea_get_location_options' );
	add_action( 'wp_ajax_nopriv_rhea_get_location_options', 'rhea_get_location_options' );

}

if ( ! function_exists( 'rhea_searched_ajax_locations' ) ) {
	/**
	 * Display Property Ajax Searched Locations Select Options
	 */

	function rhea_searched_ajax_locations() {

		$searched_locations = '';
		if ( isset( $_GET['location'] ) ) {
			$searched_locations = $_GET['location'];
		}

		if ( is_array( $searched_locations ) && ! empty( $_GET['location'] ) ) {

			foreach ( $searched_locations as $location ) {
				$searched_terms = get_term_by( 'slug', $location, 'property-city' );
				?>
                <option value="<?php echo esc_attr( $searched_terms->slug ) ?>"
                        selected="selected"><?php echo esc_html( $searched_terms->name ) ?></option>
				<?php
			}
		} elseif ( ! empty( $searched_terms ) ) {
			$searched_terms = get_term_by( 'slug', $searched_locations, 'property-city' );
			?>
            <option value="<?php echo esc_attr( $searched_terms->slug ) ?>"
                    selected="selected"><?php echo esc_html( $searched_terms->name ) ?></option>
			<?php
		}

	}
}

if ( ! function_exists( 'rhea_rvr_rating_average' ) ) {
	/**
	 * Display rating average based on approved comments with rating
	 */
	function rhea_rvr_rating_average() {

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
            <div class="rhea_rvr_ratings">
                <div class="rhea_stars_avg_rating"
                     title="<?php echo esc_html( $avg ) . ' / ' . esc_html__( '5 based on', 'realhomes-elementor-addon' ) . ' ' . esc_html( $count ) . ' ' . esc_html__( 'reviews', 'realhomes-elementor-addon' );
				     ?>"
                >
					<?php
					echo wp_kses( rhea_rating_stars( $avg ), $allowed_html );
					?>

                    <div class="rhea_wrapper_rating_info">

						<?php


						$i = 5;
						while ( $i > 0 ) {
							?>
                            <p class="rhea_rating_percentage">
                            <span class="rhea_rating_sorting_label">
                                <?php
                                printf( _nx( '%s Star', '%s Stars', $i, 'Rating Stars', 'realhomes-elementor-addon' ), number_format_i18n( $i ) );
                                ?>
                            </span>
								<?php
								if ( isset( $values_count[ $i ] ) && ! empty( $values_count[ $i ] ) ) {
									$stars = round( ( $values_count[ $i ] / ( count( $ratings ) ) ) * 100 );
								} else {
									$stars = 0;
								}
								?>

                                <span class="rhea_rating_line">
                                <span class="rhea_rating_line_inner"
                                      style="width: <?php echo esc_attr( $stars ); ?>%"></span>
                            </span>

                                <span class="rhea_rating_text">
                            <span class="rhea_rating_text_inner">

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

if ( ! function_exists( 'rhea_rating_stars' ) ) {
	/**
	 * Display rated stars based on given number of rating
	 *
	 * @param int $rating - Average rating.
	 *
	 * @return string
	 */
	function rhea_rating_stars( $rating ) {

		$output = '';

		if ( ! empty( $rating ) ) {

			$whole    = floor( $rating );
			$fraction = $rating - $whole;

			$round = round( $fraction, 2 );

			$output = '<span class="rating-stars">';

			for ( $count = 1; $count <= $whole; $count ++ ) {
				$output .= '<i class="fas fa-star rated"></i>'; //3
			}
			$half = 0;
			if ( $round <= .24 ) {
				$half = 0;
			} elseif ( $round >= .25 && $round <= .74 ) {
				$half   = 1;
				$output .= '<i class="fas fa-star-half-alt"></i>';
			} elseif ( $round >= .75 ) {
				$half   = 1;
				$output .= '<i class="fas fa-star rated"></i>';
			}

			$unrated = 5 - ( $whole + $half );
			for ( $count = 1; $count <= $unrated; $count ++ ) {
				$output .= '<i class="far fa-star"></i>';
			}

			$output .= '</span>';
		}

		return $output;
	}
}

if ( ! function_exists( 'rhea_stylish_meta' ) ) {

	function rhea_stylish_meta( $label, $post_meta_key, $icon, $postfix = '' ) {

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
					<?php
					if ( $icon ) {
						include RHEA_ASSETS_DIR . '/icons/' . $icon . '.svg';
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
if ( ! function_exists( 'rhea_stylish_meta_smart' ) ) {

	function rhea_stylish_meta_smart( $label, $post_meta_key, $icon, $postfix = '' ) {

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
						include RHEA_ASSETS_DIR . '/icons/' . $icon . '.svg';
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

if ( ! function_exists( 'rhea_allowed_html' ) ) {
	/**
	 * @return array Array of allowed html tags.
	 */
	function rhea_allowed_html() {

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

		return apply_filters( 'rhea_allowed_html', $allowed_html );
	}
}

if ( ! function_exists( 'rhea_send_message_to_agent' ) ) {
	/**
	 * Handler for agent's contact form
	 */
	function rhea_send_message_to_agent() {
		if ( isset( $_POST['email'] ) ):
			/*
			 *  Verify Nonce
			 */
			$nonce = $_POST['nonce'];
			if ( ! wp_verify_nonce( $nonce, 'agent_message_nonce' ) ) {
				echo json_encode( array(
					'success' => false,
					'message' => ' <span class="rhea_error_log"><i class="fas fa-exclamation-circle"></i> ' . esc_html__( 'Unverified Nonce!', 'realhomes-elementor-addon' ) . '</span>',
				) );
				die;
			}

			/* Verify Google reCAPTCHA */
			ere_verify_google_recaptcha();

			/* Sanitize and Validate Target email address that is coming from agent form */
			$to_email = sanitize_email( $_POST['target'] );
			$to_email = is_email( $to_email );
			if ( ! $to_email ) {
				echo json_encode( array(
					'success' => false,
					'message' => ' <span class="rhea_error_log"><i class="fas fa-exclamation-circle"></i> ' . esc_html__( 'Target Email address is not properly configured!', 'realhomes-elementor-addon' ) . '</span>',
				) );
				die;
			}

			/* Sanitize and Validate contact form input data */
			$from_name  = sanitize_text_field( $_POST['name'] );
			$from_phone = isset($_POST['phone']) ? sanitize_text_field( $_POST['phone'] ): '';
			$message    = stripslashes( $_POST['message'] );

			/*
			 * From email
			 */
			$from_email = sanitize_email( $_POST['email'] );
			$from_email = is_email( $from_email );
			if ( ! $from_email ) {
				echo json_encode( array(
					'success' => false,
					'message' => ' <span class="rhea_error_log"><i class="fas fa-exclamation-circle"></i> ' . esc_html__( 'Provided Email address is invalid!', 'realhomes-elementor-addon' ) . ' </span>',
				) );
				die;
			}

			/*
			 * Email Subject
			 */
			$is_agency_form = ( isset( $_POST['form_of'] ) && 'agency' == $_POST['form_of'] );
			$form_of        = $is_agency_form ? esc_html__( 'using agency contact form at', 'realhomes-elementor-addon' ) : esc_html__( 'using agent contact form at', 'realhomes-elementor-addon' );
			$email_subject  = esc_html__( 'New message sent by', 'realhomes-elementor-addon' ) . ' ' . $from_name . ' ' . $form_of . ' ' . get_bloginfo( 'name' );

			/*
			 * Email body
			 */
			$email_body = array();

			if ( isset( $_POST['property_title'] ) ) {
				$property_title = sanitize_text_field( $_POST['property_title'] );
				if ( ! empty( $property_title ) ) {
					$email_body[] = array(
						'name'  => esc_html__( 'Property Title', 'realhomes-elementor-addon' ),
						'value' => $property_title,
					);
				}
			}

			if ( isset( $_POST['property_permalink'] ) ) {
				$property_permalink = esc_url( $_POST['property_permalink'] );
				if ( ! empty( $property_permalink ) ) {
					$email_body[] = array(
						'name'  => esc_html__( 'Property URL', 'realhomes-elementor-addon' ),
						'value' => $property_permalink,
					);
				}
			}

			$email_body[] = array(
				'name'  => esc_html__( 'Name', 'realhomes-elementor-addon' ),
				'value' => $from_name,
			);

			$email_body[] = array(
				'name'  => esc_html__( 'Email', 'realhomes-elementor-addon' ),
				'value' => $from_email,
			);

			if ( ! empty( $from_phone ) ) {
				$email_body[] = array(
					'name'  => esc_html__( 'Contact Number', 'realhomes-elementor-addon' ),
					'value' => $from_phone,
				);
			}

			$email_body[] = array(
				'name'  => esc_html__( 'Message', 'realhomes-elementor-addon' ),
				'value' => $message,
			);

			if ( '1' == get_option( 'inspiry_gdpr_in_email', '0' ) ) {
				$GDPR_agreement = $_POST['gdpr'];
				if ( ! empty( $GDPR_agreement ) ) {
					$email_body[] = array(
						'name'  => esc_html__( 'GDPR Agreement', 'realhomes-elementor-addon' ),
						'value' => $GDPR_agreement,
					);
				}
			}

			$email_body = ere_email_template( $email_body, 'agent_contact_form' );

			/*
			 * Email Headers ( Reply To and Content Type )
			 */
			$headers   = array();
			$headers[] = "Reply-To: $from_name <$from_email>";
			$headers[] = "Content-Type: text/html; charset=UTF-8";
			$headers   = apply_filters( "inspiry_agent_mail_header", $headers );    // just in case if you want to modify the header in child theme

			/* Send copy of message to admin if configured */
			$theme_send_message_copy = get_option( 'theme_send_message_copy' );
			if ( $theme_send_message_copy == 'true' ) {
				$cc_email = get_option( 'theme_message_copy_email' );
				$cc_email = explode( ',', $cc_email );
				if ( ! empty( $cc_email ) ) {
					foreach ( $cc_email as $ind_email ) {
						$ind_email = sanitize_email( $ind_email );
						$ind_email = is_email( $ind_email );
						if ( $ind_email ) {
							$headers[] = "Cc: $ind_email";
						}
					}
				}
			}

			if ( wp_mail( $to_email, $email_subject, $email_body, $headers ) ) {

				if ( '1' === get_option( 'ere_agency_form_webhook_integration', '0' ) && $is_agency_form ) {
					ere_forms_safe_webhook_post( $_POST, 'agency_contact_form' );
				} elseif ( '1' === get_option( 'ere_agent_form_webhook_integration', '0' ) ) {
					ere_forms_safe_webhook_post( $_POST, 'agent_contact_form' );
				}

				echo json_encode( array(
					'success' => true,
					'message' => ' <span class="rhea_success_log"><i class="far fa-check-circle"></i> ' . esc_html__( 'Message Sent Successfully!', 'realhomes-elementor-addon' ) . '</span>',
				) );
			} else {
				echo json_encode( array(
						'success' => false,
						'message' => ' <span class="rhea_error_log"><i class="fas fa-exclamation-circle"></i> ' . esc_html__( 'Server Error: WordPress mail function failed!', 'realhomes-elementor-addon' ) . '</span>',
					)
				);
			}

		else:
			echo json_encode( array(
					'success' => false,
					'message' => ' <span class="rhea_error_log"><i class="fas fa-exclamation-circle"></i> ' . esc_html__( 'Invalid Request !', 'realhomes-elementor-addon' ) . '</span>',
				)
			);
		endif;

		do_action( 'inspiry_after_agent_form_submit' );

		die;
	}

	add_action( 'wp_ajax_nopriv_rhea_send_message_to_agent', 'rhea_send_message_to_agent' );
	add_action( 'wp_ajax_rhea_send_message_to_agent', 'rhea_send_message_to_agent' );
}

if ( ! function_exists( 'rhea_schedule_tour_form_mail' ) ) {
	/**
	 * Handler for schedule form email.
	 */
	function rhea_schedule_tour_form_mail() {

		if ( isset( $_POST['email'] ) ):

            // Verify Nonce.
			$nonce = $_POST['nonce'];
			if ( ! wp_verify_nonce( $nonce, 'schedule_tour_form_nonce' ) ) {
				echo json_encode( array(
					'success' => false,
					'message' => ' <label class="error"><i class="fas fa-exclamation-circle"></i> ' . esc_html__( 'Unverified Nonce!', 'realhomes-elementor-addon' ) . '</label>',
				) );
				die;
			}

			// Sanitize and Validate target email address that is coming from the form.
			$to_email = sanitize_email( $_POST['target'] );
			$to_email = is_email( $to_email );
			if ( ! $to_email ) {
				echo json_encode( array(
					'success' => false,
					'message' => ' <label class="error"><i class="fas fa-exclamation-circle"></i> ' . esc_html__( 'Target Email address is not properly configured!', 'realhomes-elementor-addon' ) . '</label>',
				) );
				die;
			}

			// Sanitize and validate form input data.
			$from_name = sanitize_text_field( $_POST['name'] );
			$date      = sanitize_text_field( $_POST['date'] );
			$message   = stripslashes( $_POST['message'] );

			// From email.
			$from_email = sanitize_email( $_POST['email'] );
			$from_email = is_email( $from_email );
			if ( ! $from_email ) {
				echo json_encode( array(
					'success' => false,
					'message' => ' <label class="error"><i class="fas fa-exclamation-circle"></i> ' . esc_html__( 'Provided Email address is invalid!', 'realhomes-elementor-addon' ) . ' </label>',
				) );
				die;
			}

			// Email Subject.
			$email_subject  = esc_html__( 'New message sent by', 'realhomes-elementor-addon' ) . ' ' . $from_name . ' ' . esc_html__( 'using schedule tour form at', 'realhomes-elementor-addon' ) . ' ' . get_bloginfo( 'name' );

			// Email Body.
			$email_body = array();

			$email_body[] = array(
				'name'  => esc_html__( 'Name', 'realhomes-elementor-addon' ),
				'value' => $from_name,
			);

			$email_body[] = array(
				'name'  => esc_html__( 'Email', 'realhomes-elementor-addon' ),
				'value' => $from_email,
			);

			if ( ! empty( $date )  ) {
			    $timestamp = strtotime( $date );
				$email_body[] = array(
					'name'  => esc_html__( 'Desired Date & Time', 'realhomes-elementor-addon' ),
					'value' => date_i18n( get_option( 'date_format' ),  $timestamp ) . ' ' . date_i18n( get_option( 'time_format' ), $timestamp ),
				);
			}

			$email_body[] = array(
				'name'  => esc_html__( 'Message', 'realhomes-elementor-addon' ),
				'value' => $message,
			);

			// Apply default emil template.
			$email_body = ere_email_template( $email_body, 'schedule_tour_form' );

			// Email Headers ( Reply To and Content Type ).
			$headers   = array();
			$headers[] = "Reply-To: $from_name <$from_email>";
			$headers[] = "Content-Type: text/html; charset=UTF-8";
			$headers   = apply_filters( "inspiry_schedule_tour_form_mail_header", $headers ); // just in case if you want to modify the header in child theme

			if ( wp_mail( $to_email, $email_subject, $email_body, $headers ) ) {
				echo json_encode( array(
					'success' => true,
					'message' => ' <label class="success"><i class="far fa-check-circle"></i> ' . esc_html__( 'Message Sent Successfully!', 'realhomes-elementor-addon' ) . '</label>',
				) );
			} else {
				echo json_encode( array(
						'success' => false,
						'message' => ' <label class="error"><i class="fas fa-exclamation-circle"></i> ' . esc_html__( 'Server Error: WordPress mail function failed!', 'realhomes-elementor-addon' ) . '</label>',
					)
				);
			}

		else:
			echo json_encode( array(
					'success' => false,
					'message' => ' <label class="error"><i class="fas fa-exclamation-circle"></i> ' . esc_html__( 'Invalid Request !', 'realhomes-elementor-addon' ) . '</label>',
				)
			);
		endif;

		die;
	}

	add_action( 'wp_ajax_nopriv_rhea_schedule_tour_form_mail', 'rhea_schedule_tour_form_mail' );
	add_action( 'wp_ajax_rhea_schedule_tour_form_mail', 'rhea_schedule_tour_form_mail' );
}

if ( ! function_exists( 'rhea_safe_include_svg' ) ) {
	/**
	 * Includes svg file in the RHEA Plugin.
	 *
	 * @param string $file
	 *
	 * @since 0.7.2
	 */
	function rhea_safe_include_svg( $file ) {
		$file = RHEA_ASSETS_DIR . $file;
		if ( file_exists( $file ) ) {
			include( $file );
		}
	}

}

if(! function_exists ('rhea_lightbox_data_attributes')){

	function rhea_lightbox_data_attributes($widget_id,$post_id,$classes = ''){

		$REAL_HOMES_property_map     = get_post_meta( $post_id, 'REAL_HOMES_property_map', true );
		$property_location = get_post_meta( $post_id, 'REAL_HOMES_property_location', true );

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