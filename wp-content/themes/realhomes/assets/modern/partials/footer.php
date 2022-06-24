<?php
/**
 * Footer template
 *
 * @package realhomes
 * @subpackage modern
 */

$site_footer_classes = 'rh_footer__before_fix';
if ( is_page_template( 'templates/home.php' ) ) {
	if ( 'diagonal-border' === get_post_meta( get_the_ID(), 'inspiry_home_sections_border', true ) ) {
		$site_footer_classes = 'diagonal-border-footer';
	}
}

// Add class to handle footer layout.
$site_footer_classes .= ' rh_footer_layout_' . get_option( 'realhomes_footer_layout', 'default' );
?>
<footer class="rh_footer <?php echo esc_attr( $site_footer_classes ); ?>">
	<?php
	$logo_enabled = get_option( 'inspiry_enable_footer_logo', 'true' );
	$desc_enabled = get_option( 'inspiry_enable_footer_tagline', 'true' );
	if ( 'true' === $logo_enabled || 'true' === $desc_enabled || ( function_exists( 'ere_social_networks' ) && ere_social_networks( array('echo' => 0 ) ) ) ) {
		?>
        <div class="rh_footer__wrap rh_footer__top_wrap rh_footer--alignCenter rh_footer--paddingBottom">
			<?php
			if ( 'true' === $logo_enabled || 'true' === $desc_enabled ) {
				?>
                <div class="rh_footer__logo">
					<?php
					$logo_path = get_option( 'inspiry_footer_logo' );
					if ( 'true' === $logo_enabled && ! empty( $logo_path ) ) {
						?>
                        <a title="<?php bloginfo( 'name' ); ?>" href="<?php echo esc_url( home_url() ); ?>">
                            <img src="<?php echo esc_url( $logo_path ); ?>" alt="<?php bloginfo( 'name' ); ?>">
                        </a>
						<?php
					} elseif ( 'true' === $logo_enabled ) {
						?>
                        <h2 class="rh_footer__heading">
                            <a href="<?php echo esc_url( home_url() ); ?>" title="<?php bloginfo( 'name' ); ?>">
								<?php bloginfo( 'name' ); ?>
                            </a>
                        </h2>
						<?php
					}

					$description = get_option( 'inspiry_footer_tagline' );
					if ( 'true' === $desc_enabled && ! empty( $description ) ) {
						echo '<p class="tag-line">';

						if ( 'true' === $logo_enabled ) {
							echo '<span class="separator">/</span>';
						}

						echo '<span class="text">';
						echo esc_html( $description );
						echo '</span></p>';
					}
					?>
                </div>
				<?php
			}
			?>
			<?php get_template_part( 'assets/modern/partials/footer/social-nav' ); ?>
        </div>
		<?php
	}
	?>
    <div class="rh_footer__wrap rh_footer__widgets_wrap rh_footer--alignTop">
		<?php
		$footer_columns = get_option( 'inspiry_footer_columns', '3' );

		switch ( $footer_columns ) {
			case '1' :
				$column_class = 'column-1';
				break;
			case '2' :
				$column_class = 'columns-2';
				break;
			case '4' :
				$column_class = 'columns-4';
				break;
			default:
				$column_class = 'columns-3';
		}
		?>
        <div class="rh_footer__widgets <?php echo esc_attr( $column_class ); ?>">
			<?php get_template_part( 'assets/modern/partials/footer/first-column' ); ?>
        </div>
		<?php
		if ( intval( $footer_columns ) >= 2 ) {
			?>
            <div class="rh_footer__widgets <?php echo esc_attr( $column_class ); ?>">
				<?php get_template_part( 'assets/modern/partials/footer/second-column' ); ?>
            </div>
			<?php
		}

		if ( intval( $footer_columns ) >= 3 ) {
			?>
            <div class="rh_footer__widgets <?php echo esc_attr( $column_class ); ?>">
				<?php get_template_part( 'assets/modern/partials/footer/third-column' ); ?>
            </div>
			<?php
		}

		if ( intval( $footer_columns ) == 4 ) {
			?>
            <div class="rh_footer__widgets <?php echo esc_attr( $column_class ); ?>">
				<?php get_template_part( 'assets/modern/partials/footer/fourth-column' ); ?>
            </div>
			<?php
		}
		?>
    </div>
	<?php
	$copyright_text_display = get_option( 'inspiry_copyright_text_display', 'true' );
	$designed_by            = apply_filters( 'inspiry_designed_by_text', get_option( 'theme_designed_by_text' ) );

	if ( 'true' === $copyright_text_display || ! empty( $designed_by ) ) {
		?>
        <div class="rh_footer__wrap rh_footer__bottom_wrap rh_footer--space_between">
			<?php
			if ( 'true' === $copyright_text_display ) {
				?>
                <p class="copyrights">
					<?php
					$copyrights = apply_filters( 'inspiry_copyright_text', get_option( 'theme_copyright_text' ) );
					if ( ! empty( $copyrights ) ) {
						echo wp_kses( $copyrights, inspiry_allowed_html() );
					} else {
						printf( '&copy; %s. %s', date_i18n( 'Y' ), esc_html__( 'All rights reserved.', 'framework' ) );
					}
					?>
                </p>
				<?php
			}
            ?>
            <div class="rh-footer-bottom-items-separator">|</div>
	        <?php
            
			if ( ! empty( $designed_by ) ) {
				?>
                <p class="designed-by">
					<?php echo wp_kses( $designed_by, inspiry_allowed_html() ); ?>
                </p>
				<?php
			}
			?>
        </div>
		<?php
	}
	?>
</footer><!-- /.rh_footer -->