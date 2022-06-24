<?php
/**
 * This file contains pagination functions
 */


if ( ! function_exists( 'theme_pagination' ) ) {
	/**
	 * Pagination
	 *
	 * @param string $pages
	 */
	function theme_pagination( $pages = '' ) {

		$paged = 1;
		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) { // if is static front page
			$paged = get_query_var( 'page' );
		}

		$prev       = $paged - 1;
		$next       = $paged + 1;
		$range      = 3; // only change it to show more links
		$show_items = ( $range * 2 ) + 1;

		if ( $pages == '' ) {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if ( ! $pages ) {
				$pages = 1;
			}
		}

		if ( 1 != $pages ) {

			echo "<div class='pagination rh_pagination_classic'>";

			if ( $paged > 2 && $paged > $range + 1 && $show_items < $pages ) {
				echo "<a href='" . get_pagenum_link( 1 ) . "' class='real-btn real-btn-jump rh_arrows_left'> " . esc_html__( 'First', 'framework' ) . "</a> ";
			}

			if ( $paged > 1 && $show_items < $pages ) {
				echo "<a href='" . get_pagenum_link( $prev ) . "' class='real-btn real-btn-jump rh_arrows_left' > " . esc_html__( 'Previous', 'framework' ) . "</a> ";
			}

			for ( $i = 1; $i <= $pages; $i ++ ) {
				if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $show_items ) ) {
					If ( $paged == $i ) {
						echo "<a href='" . get_pagenum_link( $i ) . "' class='real-btn current' >" . $i . "</a> ";
					} else {
						echo "<a href='" . get_pagenum_link( $i ) . "' class='real-btn'>" . $i . "</a> ";
					}
				}
			}

			if ( $paged < $pages && $show_items < $pages ) {
				echo "<a href='" . get_pagenum_link( $next ) . "' class='real-btn real-btn-jump rh_arrows_right' >" . esc_html__( 'Next', 'framework' ) . "</a> ";
			}

			if ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $show_items < $pages ) {
				echo "<a href='" . get_pagenum_link( $pages ) . "' class='real-btn real-btn-jump rh_arrows_right' >" . esc_html__( 'Last', 'framework' ) . "</a> ";
			}

			echo "</div>";
		}
	}
}


if ( ! function_exists( 'inspiry_theme_pagination' ) ) {
	/**
	 * Pagination
	 *
	 * @param string $pages - number of pages.
	 */
	function inspiry_theme_pagination( $pages = '' ) {

		$paged = 1;
		if ( get_query_var( 'paged' ) ) {
			$paged = get_query_var( 'paged' );
		} elseif ( get_query_var( 'page' ) ) { // if is static front page
			$paged = get_query_var( 'page' );
		}

		$prev       = $paged - 1;
		$next       = $paged + 1;
		$range      = 3; // only change it to show more links
		$show_items = ( $range * 2 ) + 1;

		if ( $pages == '' ) {
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if ( ! $pages ) {
				$pages = 1;
			}
		}

		if ( 1 != $pages ) {
			echo "<div class='rh_pagination'>";

			if ( $paged > 1 && $show_items < $pages ) {
				echo "<a href='" . get_pagenum_link( $prev ) . "' class='rh_pagination__btn rh_pagination__prev' >";
				inspiry_safe_include_svg( '/images/icons/icon-left.svg' );
				echo "</a>";
			}

			for ( $i = 1; $i <= $pages; $i ++ ) {
				if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $show_items ) ) {
					if ( $paged == $i ) {
						echo "<a href='" . get_pagenum_link( $i ) . "' class='rh_pagination__btn current' >" . $i . "</a> ";
					} else {
						echo "<a href='" . get_pagenum_link( $i ) . "' class='rh_pagination__btn'>" . $i . "</a> ";
					}
				}
			}

			if ( $paged < $pages && $show_items < $pages ) {
				echo "<a href='" . get_pagenum_link( $next ) . "' class='rh_pagination__btn rh_pagination__next' >";
				inspiry_safe_include_svg( '/images/icons/icon-right.svg' );
				echo "</a>";
			}

			echo "</div>";
		}
	}
}


if ( ! function_exists( 'theme_ajax_pagination' ) ) {
	/**
	 * Pagination function form homepage AJAX pagination
	 *
	 * @param string $pages
	 * @param WP_Query|mixed $current_query
	 */
	function theme_ajax_pagination( $pages = '', $current_query = '' ) {

		if ( empty( $current_query ) ) {
			global $wp_query;
			$current_query = $wp_query;
		}

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
			$pages = $current_query->max_num_pages;
			if ( ! $pages ) {
				$pages = 1;
			}
		}

		if ( 1 != $pages ) {
			echo "<div class='pagination'>";

			if ( ( $paged > 2 ) && ( $paged > $range + 1 ) && ( $pages_to_show < $pages ) ) {
				echo "<a href='" . get_pagenum_link( 1 ) . "' class='real-btn real-btn-jump'>&laquo; " . esc_html__( 'First', 'framework' ) . "</a> "; // First Page
			}

			if ( ( $paged > 1 ) && ( $pages_to_show < $pages ) ) {
				echo "<a href='" . get_pagenum_link( $prev ) . "' class='real-btn real-btn-jump'>&laquo; " . esc_html__( 'Previous', 'framework' ) . "</a> "; // Previous Page
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
				echo "<a href='" . get_pagenum_link( $next ) . "' class='real-btn real-btn-jump'>" . esc_html__( 'Next', 'framework' ) . " &raquo;</a> "; // Next Page
			}

			if ( ( $paged < $pages - 1 ) && ( $paged + $range - 1 < $pages ) && ( $pages_to_show < $pages ) ) {
				echo "<a href='" . get_pagenum_link( $pages ) . "' class='real-btn real-btn-jump'>" . esc_html__( 'Last', 'framework' ) . " &raquo;</a> "; // Last Page
			}

			echo "</div>";
		}
	}
}


if ( ! function_exists( 'inspiry_users_pagination' ) ) {
	/**
	 * Pagination for users template
	 *
	 * @param $pages
	 */
	function inspiry_users_pagination( $pages ) {

		global $paged;
		if ( empty ( $paged ) ) {
			$paged = 1;
		}

		$prev = $paged - 1;
		$next = $paged + 1;

		$range     = 3; // only change it to show more links
		$showitems = ( $range * 2 ) + 1;

		if ( empty( $pages ) ) {
			$pages = 1;
		}

		$pagination_class = 'pagination';
		if ( 'modern' == INSPIRY_DESIGN_VARIATION ) {
			$pagination_class = 'rh_pagination';
		} elseif ( 'classic' == INSPIRY_DESIGN_VARIATION ) {
			$pagination_class = 'pagination';
		}

		if ( 1 != $pages ) {
			echo '<div class="' . $pagination_class . '">';

			if ( $paged > 2 && $paged > $range + 1 && $showitems < $pages ) {
				echo "<a href='" . get_pagenum_link( 1 ) . "' class='real-btn'>&laquo; " . esc_html__( 'First', 'framework' ) . "</a> ";
			}

			if ( $paged > 1 && $showitems < $pages ) {
				echo "<a href='" . get_pagenum_link( $prev ) . "' class='real-btn' >&laquo; " . esc_html__( 'Previous', 'framework' ) . "</a> ";
			}

			for ( $i = 1; $i <= $pages; $i ++ ) {
				if ( 1 != $pages && ( ! ( $i >= $paged + $range + 1 || $i <= $paged - $range - 1 ) || $pages <= $showitems ) ) {
					if ( $paged == $i ) {
						echo "<a href='" . get_pagenum_link( $i ) . "' class='real-btn current' >" . $i . "</a> ";
					} else {
						echo "<a href='" . get_pagenum_link( $i ) . "' class='real-btn'>" . $i . "</a> ";
					}
				}
			}

			if ( $paged < $pages && $showitems < $pages ) {
				echo "<a href='" . get_pagenum_link( $next ) . "' class='real-btn' >" . esc_html__( 'Next', 'framework' ) . " &raquo;</a> ";
			}

			if ( $paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages ) {
				echo "<a href='" . get_pagenum_link( $pages ) . "' class='real-btn' >" . esc_html__( 'Last', 'framework' ) . " &raquo;</a> ";
			}

			echo "</div>";
		}
	}
}


if ( ! function_exists( 'update_taxonomy_pagination' ) ) {
	/**
	 * Update Taxonomy Pagination Based on Number of Properties Provided in Theme Options
	 *
	 * @param $query
	 */
	function update_taxonomy_pagination( $query ) {
		if ( is_tax( 'property-type' ) || is_tax( 'property-status' ) || is_tax( 'property-city' ) || is_tax( 'property-feature' ) ) {
			if ( $query->is_main_query() ) {
				$number_of_properties = intval( get_option( 'theme_number_of_properties' ) );
				if ( ! $number_of_properties ) {
					$number_of_properties = 6;
				}
				$query->set( 'posts_per_page', $number_of_properties );
			}
		}
	}

	add_action( 'pre_get_posts', 'update_taxonomy_pagination' );
}


if ( ! function_exists( 'inspiry_property_archive_pagination' ) ) {
	/**
	 * Property archive pagination based on Number of Properties Provided in settings
	 *
	 * @param $query
	 */
	function inspiry_property_archive_pagination( $query ) {
		if ( ! is_admin() && is_post_type_archive( 'property' ) ) {
			if ( $query->is_main_query() ) {
				$number_of_properties = intval( get_option( 'theme_number_of_properties' ) );
				if ( ! $number_of_properties ) {
					$number_of_properties = 6;
				}
				$query->set( 'posts_per_page', $number_of_properties );
			}
		}
	}

	add_action( 'pre_get_posts', 'inspiry_property_archive_pagination' );
}


if ( ! function_exists( 'inspiry_author_pagination_fix' ) ) :
	function inspiry_author_pagination_fix( $query ) {
		if ( is_author() ) {
			if ( $query->is_main_query() ) {
				$query->set( 'post_type', array( 'property' ) );
				$number_of_properties = intval( get_option( 'theme_number_of_properties_agent' ) );
				if ( ! $number_of_properties ) {
					$number_of_properties = 6;
				}
				$query->set( 'posts_per_page', $number_of_properties );
			}
		}
	}

	add_action( 'pre_get_posts', 'inspiry_author_pagination_fix' );
endif;


if ( ! function_exists( 'inspiry_pagination_fix' ) ) :
	function inspiry_pagination_fix( $redirect_url ) {
		if ( is_singular( 'agent' ) || is_singular( 'agency' ) || is_front_page() ) {
			$redirect_url = false;
		}

		return $redirect_url;
	}

	add_filter( 'redirect_canonical', 'inspiry_pagination_fix' );
endif;
