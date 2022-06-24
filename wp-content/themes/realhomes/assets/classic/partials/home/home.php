<?php
/**
 * Homepage
 *
 * @package    realhomes
 * @subpackage classic
 */

get_header();


/* Theme Home Page Module */
$theme_homepage_module = get_post_meta( get_the_ID(), 'theme_homepage_module', true );
$main_border_class     = '';

/* For demo purpose only */
if ( isset( $_GET['module'] ) ) {
	$theme_homepage_module = $_GET['module'];
}

switch ( $theme_homepage_module ) {
	case 'properties-slider':
		get_template_part( 'assets/classic/partials/home/slider/properties' );
		break;

	case 'search-form-over-image':
		get_template_part( 'assets/classic/partials/home/slider/search-form-over-image' );
		break;

	case 'slides-slider':
		get_template_part( 'assets/classic/partials/home/slider/slides' );
		break;

	case 'properties-map':
		get_template_part( 'assets/classic/partials/banners/map' );
		break;

	case 'contact-form-slider':
		get_template_part( 'assets/classic/partials/home/slider/contact-form-slider' );
		break;

	case 'revolution-slider':
		$rev_slider_alias = trim( get_post_meta( get_the_ID(), 'theme_rev_alias', true ) );
		if ( function_exists( 'putRevSlider' ) && ( ! empty( $rev_slider_alias ) ) ) {
			putRevSlider( $rev_slider_alias );
		} else {
			get_template_part( 'assets/classic/partials/banners/default' );
		}
		break;
    case 'simple-banner':
	    get_template_part( 'assets/classic/partials/banners/default' );
	    $main_border_class = 'top-border';
	    break;
}
?>

<div class="main-wrapper contents">

	<?php
	/**
	 * Advance Search
	 */
	get_template_part( 'assets/classic/partials/home/sections/advance-search' );

	/**
	 * Get all the sections to be displayed on Homepage
	 */
	$sections                        = array();
	$sections['home-properties']     = get_post_meta( get_the_ID(), 'theme_show_home_properties', true );
	$sections['features-section']    = get_post_meta( get_the_ID(), 'inspiry_show_features_section', true );
	$sections['featured-properties'] = get_post_meta( get_the_ID(), 'theme_show_featured_properties', true );
	$sections['blog-posts']          = get_post_meta( get_the_ID(), 'theme_show_news_posts', true );

	// For demo purpose only.
	if ( isset( $_GET['show-features'] ) ) {
		$show_home_features = $_GET['show-features'];
	}

	/**
	 * Get the order in which sections are to be displayed
	 */

	$section_ordering = get_post_meta( get_the_ID(), 'inspiry_home_sections_order_default', true );

	if ( ! empty( $section_ordering ) && $section_ordering == 'default' ) {
		$home_sections = 'home-properties,features-section,featured-properties,blog-posts';
		$home_sections = explode( ',', $home_sections );
	} else {
		$home_sections = get_post_meta( get_the_ID(), 'inspiry_home_sections_order', true );
		$home_sections = ( ! empty( $home_sections ) ) ? $home_sections : 'home-properties,features-section,featured-properties,blog-posts';
		$home_sections = explode( ',', $home_sections );
	}
	/**
	 * Display sections according to their order
	 */
	if ( ! empty( $home_sections ) && is_array( $home_sections ) ) {
		foreach ( $home_sections as $home_section ) {
			if ( isset($sections[ $home_section ]) && 'true' === $sections[ $home_section ]) {
				get_template_part( 'assets/classic/partials/home/sections/' . $home_section );
			}
		}
	}
	?>

</div>
<!-- /.main-wrapper -->

<?php get_footer(); ?>
