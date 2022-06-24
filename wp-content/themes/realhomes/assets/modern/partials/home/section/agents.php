<?php
/**
 * Section: Agents
 *
 * Agents section on homepage.
 *
 * @since   3.0.0
 * @package realhomes/modern
 */

/* List of Agents on Homepage */
$number_of_agents = get_post_meta( get_the_ID(), 'inspiry_agents_on_home', true );
if ( ! $number_of_agents ) {
	$number_of_agents = 4;
}

$agents_args = array(
	'post_type'      => 'agent',
	'posts_per_page' => $number_of_agents,
);

$home_agents_query = new WP_Query( $agents_args );
$get_border_type   = get_post_meta( get_the_ID(), 'inspiry_home_sections_border', true );

if ( $get_border_type == 'diagonal-border') {
	$border_class = 'diagonal-mod';
} else {
	$border_class = 'flat-border';
}
?>

<section class="rh_section rh_section__agents <?php echo esc_attr($border_class); ?>">

	<div class="diagonal-mod-background"></div>

	<div class="wrapper-section-contents">
		<?php

		$inspiry_agents_sub_title  = get_post_meta( get_the_ID(), 'inspiry_home_agents_sub_title', true );
		$inspiry_home_agents_title = get_post_meta( get_the_ID(), 'inspiry_home_agents_title', true );
		$inspiry_home_agents_desc  = get_post_meta( get_the_ID(), 'inspiry_home_agents_desc', true );

		inspiry_modern_home_heading( $inspiry_agents_sub_title, $inspiry_home_agents_title, $inspiry_home_agents_desc );

		if ( $home_agents_query->have_posts() ) : ?>

			<div class="rh_section__agents_wrap">

				<?php while ( $home_agents_query->have_posts() ) : ?>

					<?php $home_agents_query->the_post(); ?>

					<?php get_template_part( 'assets/modern/partials/agent/home-card' ); ?>

				<?php endwhile; ?>

				<?php wp_reset_postdata(); ?>

			</div>
			<!-- /.rh_section__properties -->

		<?php endif; ?>

	</div>
</section>
<!-- /.rh_section rh_section__agents -->
