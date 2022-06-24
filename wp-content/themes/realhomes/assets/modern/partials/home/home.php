<?php
/**
 * Homepage Template
 *
 * @package realhomes
 * @subpackage modern
 */

get_header();

/* Theme Home Page Module */
$theme_homepage_module = get_post_meta( get_the_ID(), 'theme_homepage_module', true );

switch ( $theme_homepage_module ) {
	case 'properties-slider':
		get_template_part( 'assets/modern/partials/home/slider/property' );
		break;

	case 'properties-map':
		get_template_part( 'assets/modern/partials/home/slider/map' );
		break;

	case 'search-form-over-image':
		get_template_part( 'assets/modern/partials/home/slider/search-form-over-image' );
		break;

	case 'slides-slider':
		get_template_part( 'assets/modern/partials/home/slider/slides' );
		break;

	case 'revolution-slider':
		$rev_slider_alias = trim( get_post_meta( get_the_ID(), 'theme_rev_alias', true ) );
		if ( function_exists( 'putRevSlider' ) && ( ! empty( $rev_slider_alias ) ) ) {
			putRevSlider( $rev_slider_alias );
		} else {
			get_template_part( 'assets/modern/partials/banner/header' );
		}
		break;

	case 'simple-banner':
		get_template_part( 'assets/modern/partials/banner/image' );
		break;

	case 'contact-form-slider':
		get_template_part( 'assets/modern/partials/home/slider/contact-form-slider' );
		break;

	default:
		get_template_part( 'assets/modern/partials/banner/header' );
		break;
}
//home-properties,featured-properties,testimonials,cta,agents,features,partners,cta-contact

// Show sections options.

if('search-form-over-image' != $theme_homepage_module){
$inspiry_show_home_search = get_post_meta( get_the_ID(), 'theme_show_home_search', true ); // Advance Search.
}

if ( is_active_sidebar( 'home-search-area' ) ) : ?>
    <div class="rh_prop_search rh_wrap--padding">
		<?php dynamic_sidebar( 'home-search-area' ); ?>
    </div>
    <!-- /.rh_prop_search -->
<?php
elseif ( ! empty( $inspiry_show_home_search ) && 'true' === $inspiry_show_home_search ) :
	get_template_part( 'assets/modern/partials/properties/search/advance' );
endif;


$sections                        = array();
$sections['content']             = get_post_meta( get_the_ID(), 'theme_show_home_contents', true ); // Home Contents.
$sections['latest-properties']   = get_post_meta( get_the_ID(), 'theme_show_home_properties', true ); // Home properties.
$sections['featured-properties'] = get_post_meta( get_the_ID(), 'theme_show_featured_properties', true ); // Featured Properties.
$sections['testimonial']         = get_post_meta( get_the_ID(), 'inspiry_show_testimonial', true ); // Testimonial.
$sections['cta']                 = get_post_meta( get_the_ID(), 'inspiry_show_cta', true ); // Call to Action.
$sections['agents']              = get_post_meta( get_the_ID(), 'inspiry_show_agents', true ); // Agents.
$sections['features']            = get_post_meta( get_the_ID(), 'inspiry_show_home_features', true ); // Features.
$sections['partners']            = get_post_meta( get_the_ID(), 'inspiry_show_home_partners', true ); // Partners.
$sections['news']                = get_post_meta( get_the_ID(), 'inspiry_show_home_news_modern', true ); // News.
$sections['cta-contact']         = get_post_meta( get_the_ID(), 'inspiry_show_home_cta_contact', true ); // CTA Contact.


/**
 * Get the order in which sections are to be displayed
 */

$section_ordering = get_post_meta( get_the_ID(), 'inspiry_home_sections_order_default', true );


if ( ! empty( $section_ordering ) && $section_ordering == 'default' ) {
	$home_sections = 'content,latest-properties,featured-properties,testimonial,cta,agents,features,partners,news,cta-contact';
	$home_sections = explode( ',', $home_sections );
} else {
	$home_sections = get_post_meta( get_the_ID(), 'inspiry_home_sections_order_mod', true );
	$home_sections = ( ! empty( $home_sections ) ) ? $home_sections : 'content,latest-properties,featured-properties,testimonial,cta,agents,features,partners,news,cta-contact';
	$home_sections = explode( ',', $home_sections );
}
/**
 * Display sections according to their order
 */
if ( ! empty( $home_sections ) && is_array( $home_sections ) ) {

	$get_border_type = get_post_meta( get_the_ID(), 'inspiry_home_sections_border', true );

	if ( is_rtl() && $get_border_type == 'diagonal-border' ) {
		$border_class = 'diagonal-mod-wrapper diagonal-rtl';
	} elseif ( $get_border_type == 'diagonal-border' ) {
		$border_class = 'diagonal-mod-wrapper';
	} else {
		$border_class = '';
	}


	?>
    <div class="wrapper-home-sections <?php echo esc_attr( $border_class ); ?>">
		<?php
//				get_template_part( 'assets/modern/partials/home/section/content' );

		foreach ( $home_sections as $home_section ) {
			if ( isset($sections[ $home_section ]) && 'true' === $sections[ $home_section ]) {
				get_template_part( 'assets/modern/partials/home/section/' . $home_section );
			}
		}
		?>
    </div>
	<?php
}

get_footer();
