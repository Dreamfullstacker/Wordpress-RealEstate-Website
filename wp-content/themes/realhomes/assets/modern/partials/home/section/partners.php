<?php
/**
 * Partners section of the homepage.
 *
 * @package    realhomes
 * @subpackage modern
 */
$number_of_partners  = get_post_meta( get_the_ID(), 'inspiry_home_partners_to_show', true );
$partners_args       = array(
	'post_type'      => 'partners',
	'posts_per_page' => empty( $number_of_partners ) ? 20 : intval( $number_of_partners ),
);
$home_partners_query = new WP_Query( $partners_args );
$get_border_type     = get_post_meta( get_the_ID(), 'inspiry_home_sections_border', true );

if ( $get_border_type == 'diagonal-border' ) {
	$border_class = 'diagonal-mod';
} else {
	$border_class = 'flat-border';
}
?>
<section class="rh_section rh_section__partners <?php echo esc_attr( $border_class ); ?>">
    <div class="diagonal-mod-background"></div>
    <div class="wrapper-section-contents">
		<?php
		$inspiry_home_partners_subtitle = get_post_meta( get_the_ID(), 'inspiry_home_partners_sub_title', true );
		$inspiry_home_partners_title    = get_post_meta( get_the_ID(), 'inspiry_home_partners_title', true );
		$inspiry_home_partners_desc     = get_post_meta( get_the_ID(), 'inspiry_home_partners_desc', true );

		inspiry_modern_home_heading( $inspiry_home_partners_subtitle, $inspiry_home_partners_title, $inspiry_home_partners_desc );

		if ( $home_partners_query->have_posts() ) :
			if ( 'simple' == get_post_meta( get_the_ID(), 'inpsiry_modern_partners_variation', true ) ) : ?>
                <div class="rh_section__partners_wrap">
					<?php while ( $home_partners_query->have_posts() ) : $home_partners_query->the_post(); ?>
                        <div class="rh_partner">
							<?php
                            $partner_url = get_post_meta( get_the_ID(), 'REAL_HOMES_partner_url', true );
							$thumb_title = trim( strip_tags( get_the_title( get_the_ID() ) ) );
							?>
                            <a target="_blank" href="<?php echo esc_url( $partner_url ); ?>" title="<?php the_title_attribute(); ?>">
								<?php the_post_thumbnail( 'partners-logo', array( 'alt' => $thumb_title, 'title' => $thumb_title, ) ); ?>
                            </a>
                        </div>
					<?php endwhile; ?>
                </div>
			<?php else : ?>
                <div class="brands-owl-carousel owl-carousel">
					<?php
                    while ( $home_partners_query->have_posts() ) : $home_partners_query->the_post();
						$partner_url = get_post_meta( get_the_ID(), 'REAL_HOMES_partner_url', true );
                        $thumb_title = trim( strip_tags( get_the_title( get_the_ID() ) ) );
	                    ?>
                        <div class="brands-carousel-item">
                            <a target="_blank" href="<?php echo esc_url( $partner_url ); ?>" title="<?php the_title_attribute(); ?>">
								<?php the_post_thumbnail( 'partners-logo', array( 'alt'   => $thumb_title, 'title' => $thumb_title, ) ); ?>
                            </a>
                        </div>
					<?php endwhile; ?>
                </div>
				<?php
			endif;
			wp_reset_query();
		endif;
		?>
    </div>
</section><!-- /.rh_section rh_section__partners -->