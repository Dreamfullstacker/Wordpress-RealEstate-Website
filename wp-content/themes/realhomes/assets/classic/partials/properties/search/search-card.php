<?php
/**
 * Property card for search results page
 *
 * @package    realhomes
 * @subpackage classic
 */

global $post;
?>
<div class="span6">
	<article class="property-item clearfix">
		<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
		<figure>
			<a href="<?php the_permalink(); ?>">
				<?php
				if ( has_post_thumbnail( get_the_ID() ) ) {
					the_post_thumbnail( 'property-thumb-image' );
				} else {
					inspiry_image_placeholder( 'property-thumb-image' );
				}
				?>
			</a>
			<?php
			inspiry_display_property_label( get_the_ID() );
			display_figcaption( get_the_ID() );
			?>
		</figure>

		<div class="detail">
			<h5 class="price">
				<?php
				// Price.
				if ( function_exists( 'ere_property_price' ) ) {
					ere_property_price();
				}

				// Property types.
				echo inspiry_get_property_types( get_the_ID() );
				?>
			</h5>
			<p><?php framework_excerpt( 12 ); ?></p>
			<a class="more-details" href="<?php the_permalink() ?>"><?php esc_html_e( 'More Details ', 'framework' ); ?>
				<i class="fas fa-caret-right"></i></a>
		</div>

		<?php
		$compare_properties_module = get_option( 'theme_compare_properties_module' );
		$inspiry_compare_page      = get_option( 'inspiry_compare_page' );
		?>
		<div class="property-meta clearfix <?php echo ( ( 'enable' === $compare_properties_module ) && ( $inspiry_compare_page ) ) ? 'compare-meta' : ''; ?>">
			<?php get_template_part( 'assets/classic/partials/property/single/metas' ); ?>
			<?php
			if ( ( 'enable' === $compare_properties_module ) && ( $inspiry_compare_page ) ) {
				get_template_part( 'assets/classic/partials/properties/compare/search-card-button' );
			}
			?>
		</div>
	</article>
</div>
