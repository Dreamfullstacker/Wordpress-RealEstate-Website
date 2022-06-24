<?php
/**
 * Video post format.
 *
 * @package    realhomes
 * @subpackage modern
 */

global $post;
$embed_code = get_post_meta( get_the_ID(), 'REAL_HOMES_embed_code', true );

if ( is_single() ) {
	if ( ! empty( $embed_code ) ) {
		?>
		<div class="post-video">
			<div class="video-wrapper">
				<?php echo stripslashes( wp_specialchars_decode( $embed_code ) ); ?>
			</div>
		</div>
		<?php
	} elseif ( has_post_thumbnail() ) {
		$image_id  = get_post_thumbnail_id();
		$image_url = wp_get_attachment_url( $image_id );

		?>
		<div class="post-video test">
			<a href="<?php echo esc_url( $image_url ); ?>" data-fancybox class="" title="<?php the_title_attribute(); ?>">
				<?php the_post_thumbnail( 'post-featured-image' ); ?>
			</a>
		</div>
		<?php
	}
} else {
	$image_id  = get_post_thumbnail_id();
	$image_url = wp_get_attachment_url( $image_id );

	?>
	<div class="post-video">
		<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
			<?php
			if( is_page_template('templates/home.php') ){
				?>
				<div class="wrapper-video-post-home">
				<?php
				the_post_thumbnail( 'modern-property-child-slider' );
				?>
				</div>
					<?php
			}else{
				the_post_thumbnail( 'post-featured-image' );
			}
			?>
		</a>
	</div>
	<?php
}
