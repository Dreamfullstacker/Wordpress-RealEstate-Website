<?php
/**
 * Property card for similar properties.
 *
 * @package    realhomes
 * @subpackage classic
 */
?>
<article class="property-item clearfix">

	<figure>
		<a href="<?php the_permalink(); ?>">
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


	<h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
	<p><?php framework_excerpt( 9 ); ?>
		<a class="more-details" href="<?php the_permalink(); ?>"><?php esc_html_e( 'More Details ', 'framework' ); ?>
			<i class="fas fa-caret-right"></i></a></p>
	<?php
	$price = null;

	if ( function_exists('ere_get_property_price') ) {
		$price = ere_get_property_price();
	}

	if ( $price ) {
		echo '<span>' . $price . '</span>';
	}
	?>
</article>