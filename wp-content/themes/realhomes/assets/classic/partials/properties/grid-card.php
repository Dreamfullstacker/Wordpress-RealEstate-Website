<?php
/**
 * Property Card for Grid Layout.
 *
 * @package    realhomes
 * @subpackage classic
 */

global $post;
?>

<article class="property-item clearfix">

	<figure>
		<a href="<?php the_permalink(); ?>"><?php
			if ( has_post_thumbnail( get_the_ID() ) ) {
				// Featured image.
				the_post_thumbnail( 'property-thumb-image' );
			} else {
				// OR: Placeholder.
				inspiry_image_placeholder( 'property-thumb-image' );
			}
			?></a><?php

		// Property Label.
		inspiry_display_property_label( get_the_ID() );

		// Property Status.
		display_figcaption( get_the_ID() );
		?>
	</figure>

	<h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>

	<?php
	$theme_listing_excerpt_length = get_option('theme_listing_excerpt_length');

	if(!empty($theme_listing_excerpt_length) && (0 < $theme_listing_excerpt_length)){
		$card_excerpt = $theme_listing_excerpt_length;
	}else{
		$card_excerpt = 9;
	}
	?>
	<p><?php framework_excerpt( $card_excerpt ); ?>
		<a class="more-details" href="<?php the_permalink() ?>"><?php esc_html_e( 'More Details ', 'framework' ); ?>
			<i class="fas fa-caret-right"></i></a></p>
	<?php

	/*
	 * Property Price.
	 */
	if ( function_exists( 'ere_get_property_price' ) ) : ?>
        <span><?php ere_property_price(); ?></span>
	<?php
	endif;

	inspiry_add_to_compare_button(); // Display add to compare button.
	?>
</article>
