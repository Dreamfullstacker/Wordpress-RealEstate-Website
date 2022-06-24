<?php
/**
 * Second column of widget of footer.
 *
 * @package realhomes
 * @subpackage modern
 */


if ( is_active_sidebar( 'footer-second-column' ) ) {
	?>
    <div class="rh_widgets">
		<?php dynamic_sidebar( 'footer-second-column' ); ?>
    </div>
    <!-- /.rh_widgets -->
	<?php
}
?>
