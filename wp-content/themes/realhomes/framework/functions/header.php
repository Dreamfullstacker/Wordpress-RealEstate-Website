<?php
/**
 * Header Functions
 *
 * @since 1.0.0
 * @package realhomes/functions
 */
if ( ! function_exists( 'get_default_banner' ) ) {
	/**
	 * Get Default Banner
	 *
	 * @return string
	 */
	function get_default_banner() {
		$banner_image_path = get_option( 'theme_general_banner_image' );
		return empty( $banner_image_path ) ? INSPIRY_DIR_URI . '/images/banner.jpg' : $banner_image_path;
	}
}

if ( ! function_exists( 'add_opengraph_doctype' ) ) {
	/**
	 * Adding the Open Graph in the Language Attributes
	 *
	 * @param $output
	 *
	 * @return string
	 */
	function inspiry_add_opengraph_doctype( $output ) {
		if ( is_single() ) {

			if ( is_singular( 'property' ) && ( 'true' != get_option( 'theme_add_meta_tags' ) ) ) {
				return $output;
			}

			return $output . '
                    xmlns="https://www.w3.org/1999/xhtml"
                    xmlns:og="https://ogp.me/ns#" 
                    xmlns:fb="http://www.facebook.com/2008/fbml"';
		} else {
		    return $output;
        }
	}

	add_filter( 'language_attributes', 'inspiry_add_opengraph_doctype' );
}

if ( ! function_exists( 'inspiry_open_graph_tags' ) ) {
	/**
	 * Adding the Open Graph Meta Info to the single/detail pages
	 */
	function inspiry_open_graph_tags() {

		if ( is_single() ) {

			if ( is_singular( 'property' ) && ( 'true' != get_option( 'theme_add_meta_tags' ) ) ) {
				return;
			}

			global $post;

			if ( has_post_thumbnail( get_the_ID() ) ) {
				$img_src = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'agent-image' );
			} else {
				$img_src = get_inspiry_image_placeholder( 'agent-image' );
			}

			if ( has_excerpt( get_the_ID() ) ) {
				$description = strip_tags( get_the_excerpt() );
			} else {
				$description = str_replace( "\r\n", ' ', substr( strip_tags( strip_shortcodes( $post->post_content ) ), 0, 160 ) );
			}
			if ( empty( $description ) ) {
				$description = get_bloginfo( 'description' );
			}

			?>
            <meta property="og:title" content="<?php the_title(); ?>"/>
            <meta property="og:description" content="<?php echo esc_html( $description ); ?>"/>
            <meta property="og:type" content="article"/>
            <meta property="og:url" content="<?php the_permalink(); ?>"/>
            <meta property="og:site_name" content="<?php echo get_bloginfo( 'name' ); ?>"/>
            <meta property="og:image" content="<?php echo esc_url( $img_src[0] ); ?>"/>
			<?php
		}
	}

	add_action( 'wp_head', 'inspiry_open_graph_tags', 5 );
}

if ( ! function_exists( 'inspiry_sticky_header' ) ) {
	/**
	 * Sticky Header Class
	 *
	 * @param $classes
	 * @return array
	 */
	function inspiry_sticky_header( $classes ) {

		if ( 'true'  === get_option( 'theme_sticky_header', 'false' ) ) {
			$classes[] = 'sticky-header';
		}

		return $classes;
	}

	add_filter( 'body_class', 'inspiry_sticky_header' );
}

if ( ! function_exists( 'inspiry_get_search_bg_image' ) ) :
	/**
	 * Returns search background image url
	 * @return string
	 */
	function inspiry_get_search_bg_image() {
		$image_id        = get_post_meta( get_the_ID(), 'inspiry_home_search_bg_img', true );
		$search_bg_image = wp_get_attachment_url( $image_id );

		if ( ! empty( $search_bg_image ) ) {
			return esc_url( $search_bg_image );
		}

		return esc_url( inspiry_get_raw_placeholder_url( 'property-detail-video-image' ) );
	}
endif;

if ( ! class_exists( 'RH_Walker_Nav_Menu' ) ) :

	class RH_Walker_Nav_Menu extends Walker_Nav_Menu {

		/**
		 * Starts the element output.
		 *
		 * @since 3.0.0
		 * @since 4.4.0 The {@see 'nav_menu_item_args'} filter was added.
		 *
		 * @see   Walker::start_el()
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param WP_Post $item  Menu item data object.
		 * @param int $depth     Depth of menu item. Used for padding.
		 * @param stdClass $args An object of wp_nav_menu() arguments.
		 * @param int $id        Current item ID.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			if ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) {
				$t = '';
				$n = '';
			} else {
				$t = "\t";
				$n = "\n";
			}
			$indent = ( $depth ) ? str_repeat( $t, $depth ) : '';

			$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			/**
			 * Filters the arguments for a single nav menu item.
			 *
			 * @since 4.4.0
			 *
			 * @param stdClass $args An object of wp_nav_menu() arguments.
			 * @param WP_Post $item  Menu item data object.
			 * @param int $depth     Depth of menu item. Used for padding.
			 */
			$args = apply_filters( 'nav_menu_item_args', $args, $item, $depth );

			/**
			 * Filters the CSS class(es) applied to a menu item's list item element.
			 *
			 * @since 3.0.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array $classes The CSS classes that are applied to the menu item's `<li>` element.
			 * @param WP_Post $item  The current menu item.
			 * @param stdClass $args An object of wp_nav_menu() arguments.
			 * @param int $depth     Depth of menu item. Used for padding.
			 */
			$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			/**
			 * Filters the ID applied to a menu item's list item element.
			 *
			 * @since 3.0.1
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param string $menu_id The ID that is applied to the menu item's `<li>` element.
			 * @param WP_Post $item   The current menu item.
			 * @param stdClass $args  An object of wp_nav_menu() arguments.
			 * @param int $depth      Depth of menu item. Used for padding.
			 */
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';

			$output .= $indent . '<li' . $id . $class_names . '>';

			$atts             = array();
			$atts[ 'title' ]  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts[ 'target' ] = ! empty( $item->target ) ? $item->target : '';
			$atts[ 'rel' ]    = ! empty( $item->xfn ) ? $item->xfn : '';
			$atts[ 'href' ]   = ! empty( $item->url ) ? $item->url : '';

			/**
			 * Filters the HTML attributes applied to a menu item's anchor element.
			 *
			 * @since 3.6.0
			 * @since 4.1.0 The `$depth` parameter was added.
			 *
			 * @param array $atts    {
			 *                       The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
			 *
			 * @type string $title   Title attribute.
			 * @type string $target  Target attribute.
			 * @type string $rel     The rel attribute.
			 * @type string $href    The href attribute.
			 * }
			 *
			 * @param WP_Post $item  The current menu item.
			 * @param stdClass $args An object of wp_nav_menu() arguments.
			 * @param int $depth     Depth of menu item. Used for padding.
			 */
			$atts = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );

			$attributes = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value      = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			/** This filter is documented in wp-includes/post-template.php */
			$title = apply_filters( 'the_title', $item->title, $item->ID );

			/**
			 * Filters a menu item's title.
			 *
			 * @since 4.4.0
			 *
			 * @param string $title  The menu item's title.
			 * @param WP_Post $item  The current menu item.
			 * @param stdClass $args An object of wp_nav_menu() arguments.
			 * @param int $depth     Depth of menu item. Used for padding.
			 */
			$title = apply_filters( 'nav_menu_item_title', $title, $item, $args, $depth );

			$item_output = $args->before;
			$item_output .= '<a' . $attributes . '>';
			$item_output .= $args->link_before . $title . $args->link_after;
			if ( ! empty( $item->description ) ) {
				$item_output .= '<span class="menu-item-desc">'. $item->description .'</span>';
			}
			$item_output .= '</a>';
			$item_output .= $args->after;

			/**
			 * Filters a menu item's starting output.
			 *
			 * The menu item's starting output only includes `$args->before`, the opening `<a>`,
			 * the menu item's title, the closing `</a>`, and `$args->after`. Currently, there is
			 * no filter for modifying the opening and closing `<li>` for a menu item.
			 *
			 * @since 3.0.0
			 *
			 * @param string $item_output The menu item's starting HTML output.
			 * @param WP_Post $item       Menu item data object.
			 * @param int $depth          Depth of menu item. Used for padding.
			 * @param stdClass $args      An object of wp_nav_menu() arguments.
			 */
			$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
		}

	}

endif;

if ( !class_exists( 'inspiry_pingback_header' ) ) :
	/**
	 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
	 */
	function inspiry_pingback_header() {
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
		}
	}

	add_action( 'wp_head', 'inspiry_pingback_header' );
endif;