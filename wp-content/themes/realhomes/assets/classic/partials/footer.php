<?php
/**
 * Footer Template
 *
 * @package    realhomes
 * @subpackage classic
 */

get_template_part( 'assets/classic/partials/footer/partners' ); ?>

<!-- Start Footer -->
<footer id="footer-wrapper">

	<div id="footer" class="container">

		<div class="row">
			<?php

				$footer_columns = get_option( 'inspiry_footer_columns', '4' );

				switch ( $footer_columns ) {
					case '1' :
						$column_class = 'span12';
						break;
					case '2' :
						$column_class = 'span6';
						break;
					case '3' :
						$column_class = 'span4';
						break;
					default:
						$column_class = 'span3';
				}
			?>
			<div class="<?php echo esc_attr( $column_class ); ?>">
				<?php
				if ( is_active_sidebar( 'footer-first-column' ) ) {
					dynamic_sidebar( 'footer-first-column' );
				}
                ?>
			</div>
			<?php
				if ( intval( $footer_columns ) >= 2 ) {
					?>
					<div class="<?php echo esc_attr( $column_class ); ?>">
						<?php
						if ( is_active_sidebar( 'footer-second-column' ) ) {
							dynamic_sidebar( 'footer-second-column' );
						}
						?>
					</div>
					<?php
				}

				if ( intval( $footer_columns ) >= 3 ) {
					?>
					<div class="clearfix visible-tablet"></div>
					<div class="<?php echo esc_attr( $column_class ); ?>">
						<?php
						if ( is_active_sidebar( 'footer-third-column' ) ) {
							dynamic_sidebar( 'footer-third-column' );
						}
						?>
					</div>
					<?php
				}

				if ( intval( $footer_columns ) == 4 ) {
					?>
					<div class="<?php echo esc_attr( $column_class ); ?>">
						<?php
						if ( is_active_sidebar( 'footer-fourth-column' ) ) {
							dynamic_sidebar( 'footer-fourth-column' );
						}
						?>
					</div>
					<?php
				}
			?>
		</div>

	</div>

	<div id="footer-bottom" class="container">
		<div class="row">
			<div class="span6">
				<?php
				if ( 'true' === get_option( 'inspiry_copyright_text_display', 'true' ) ) {
					$copyrights = apply_filters( 'inspiry_copyright_text', get_option( 'theme_copyright_text' ) );
					if ( ! empty( $copyrights ) ) {
						?><p class="copyright"><?php echo wp_kses( $copyrights, inspiry_allowed_html() ); ?></p><?php
					} else {
						printf( '<p class="copyright">&copy; %s. %s</p>', date_i18n( 'Y' ), esc_html__( 'All rights reserved.', 'framework' ) );
					}
				}
				?>
			</div>
			<div class="span6">
				<?php
				$designed_by = apply_filters( 'inspiry_designed_by_text', get_option( 'theme_designed_by_text' ) );
				if ( !empty( $designed_by ) ) {
				    ?><p class="designed-by"><?php echo wp_kses( $designed_by, inspiry_allowed_html() ); ?></p><?php
                }
				?>
			</div>
		</div>
	</div>

</footer>

