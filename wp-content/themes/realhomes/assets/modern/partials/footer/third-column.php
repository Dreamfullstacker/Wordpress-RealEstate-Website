<?php
/**
 * Footer: Third Widget Column
 *
 * Third column of widget of footer.
 *
 * @since 	3.0.0
 * @package realhomes/modern
 */

if ( is_active_sidebar( 'footer-third-column' ) ) {
	?>
    <div class="rh_widgets">
		<?php dynamic_sidebar( 'footer-third-column' ); ?>
    </div>
    <!-- /.rh_widgets -->
	<?php
}
?>
