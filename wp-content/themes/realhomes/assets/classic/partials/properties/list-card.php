<?php
/**
 * Property card for list layout.
 *
 * @package    realhomes
 * @subpackage classic
 */

?>

<div class="property-item-wrapper rh_popup_info_map" data-RH-ID="RH-<?php echo get_the_ID();?>">
	<article class="property-item clearfix">

		<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>

		<figure>
			<a href="<?php the_permalink() ?>">
				<?php
				global $post;
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

				// Property Type. For example: Villa, Single Family Home.
				echo inspiry_get_property_types( get_the_ID() );
				?>
			</h5>

			<?php
			$theme_listing_excerpt_length = get_option('theme_listing_excerpt_length');

			if(!empty($theme_listing_excerpt_length) && (0 < $theme_listing_excerpt_length)){
				$card_excerpt = $theme_listing_excerpt_length;
			}else{
				$card_excerpt = 25;
			}
			?>
			<p><?php framework_excerpt( $card_excerpt ); ?></p>
			<a class="more-details" href="<?php the_permalink() ?>"><?php esc_html_e( 'More Details ', 'framework' ); ?>
				<i class="fas fa-caret-right"></i></a>
		</div>

		<div class="property-meta">
			<?php
			get_template_part( 'assets/classic/partials/property/single/metas' );

			inspiry_add_to_compare_button(); // Display add to compare button.
			?>
		</div>

	</article>
</div>
