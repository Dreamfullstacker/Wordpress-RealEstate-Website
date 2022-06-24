<?php
/**
 * First column of widget of footer.
 *
 * @package realhomes
 * @subpackage modern
 */


if ( is_active_sidebar( 'footer-first-column' ) ) {
	?>
    <div class="rh_widgets">
		<?php dynamic_sidebar( 'footer-first-column' ); ?>
    </div>
    <!-- /.rh_widgets -->
	<?php
}
?>
