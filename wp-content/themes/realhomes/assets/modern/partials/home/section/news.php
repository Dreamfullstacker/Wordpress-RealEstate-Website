<?php
/**
 * Section: News
 *
 * News section on homepage.
 *
 * @package realhomes/modern
 */

$agents_args = array(
	'post_type'           => 'post',
	'posts_per_page'      => 3,
	'ignore_sticky_posts' => 1,
	'tax_query'           => array(
		array(
			'taxonomy' => 'post_format',
			'field'    => 'slug',
			'terms'    => array( 'post-format-quote', 'post-format-link', 'post-format-audio' ),
			'operator' => 'NOT IN'
		)
	),
	'meta_query'          => array(
		'relation' => 'OR',
		array(
			'key'     => '_thumbnail_id',
			'compare' => 'EXISTS'
		),
		array(
			'key'     => 'REAL_HOMES_embed_code',
			'compare' => 'EXISTS'
		),
		array(
			'key'     => 'REAL_HOMES_gallery',
			'compare' => 'EXISTS'
		)
	)
);

$home_news_query = new WP_Query( $agents_args );
$get_border_type = get_post_meta( get_the_ID(), 'inspiry_home_sections_border', true );

if ( $get_border_type == 'diagonal-border') {
	$border_class = 'diagonal-mod';
} else {
	$border_class = 'flat-border';
}
?>

<section class="rh_section rh_section__news <?php echo esc_attr( $border_class ); ?>">

	<div class="diagonal-mod-background"></div>

	<div class="wrapper-section-contents">
		<?php

		$inspiry_agents_sub_title  = get_post_meta( get_the_ID(), 'inspiry_home_news_sub_title', true );
		$inspiry_home_agents_title = get_post_meta( get_the_ID(), 'inspiry_home_news_title', true );
		$inspiry_home_agents_desc  = get_post_meta( get_the_ID(), 'inspiry_home_news_desc', true );

		inspiry_modern_home_heading( $inspiry_agents_sub_title, $inspiry_home_agents_title, $inspiry_home_agents_desc );

		if ( $home_news_query->have_posts() ) : ?>

			<div class="rh_section__news_wrap">

				<?php

				while ( $home_news_query->have_posts() ) :
					$home_news_query->the_post();
					$format = get_post_format( get_the_ID() );
					if ( false === $format ) {
						$format = 'standard';
					} ?>

					<article class="rh-wrapper-post">
						<div class="rh-wrapper-post-media">
							<?php get_template_part( "assets/modern/partials/blog/post-formats/$format" ); ?>
						</div>
						<div class="rh-wrapper-post-contents">
							<div class="post-meta">
								<span class="date"> <?php the_time( get_option( 'date_format' ) ); ?></span>
								<?php
								$get_categories = get_the_category();
								if ( is_array( $get_categories ) && ! empty( $get_categories ) ) {
									?>
									<span class="categories">
										<?php esc_html_e( 'In ', 'framework' ); ?>
										<?php
										foreach ( $get_categories as $category ) {
											?>
											<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>"><?php echo esc_attr( $category->name ); ?></a>
											<?php
										}
										?>
								</span>
									<?php
								}
								?>
							</div>
							<h3 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

							<p><?php framework_excerpt( 12 ); ?></p>

						    <span class="by-author"><?php esc_html_e( 'By', 'framework' ); ?><span class="author-link"><?php the_author() ?></span></span>

						</div>
					</article>

				<?php endwhile; ?>

				<?php wp_reset_postdata(); ?>

			</div><!-- /.rh_section__properties -->

		<?php endif; ?>

	</div>
</section><!-- /.rh_section rh_section__agents -->
