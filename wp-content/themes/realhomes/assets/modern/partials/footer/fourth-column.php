<?php
/**
 * Footer: Fourth Widget Column
 *
 * Fourth column of widget of footer.
 *
 * @since    3.5.0
 * @package realhomes/modern
 */

if ( is_active_sidebar( 'footer-fourth-column' ) ) {
	?>
    <div class="rh_widgets">
		<?php dynamic_sidebar( 'footer-fourth-column' ); ?>
    </div>
    <!-- /.rh_widgets -->
	<?php
}
?>