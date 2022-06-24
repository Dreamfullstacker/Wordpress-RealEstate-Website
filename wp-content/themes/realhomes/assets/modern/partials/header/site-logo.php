<?php
$logo_path = get_option( 'theme_sitelogo' );
$retina_logo_path = get_option( 'theme_sitelogo_retina' );
if ( ! empty( $logo_path ) ) {
	?>
	<a title="<?php bloginfo( 'name' ); ?>" href="<?php echo esc_url( home_url() ); ?>">
		<?php inspiry_logo_img( $logo_path, $retina_logo_path ); ?>
	</a>
	<?php
} else {
	?>
	<h2 class="rh_logo__heading">
		<a href="<?php echo esc_url( home_url() ); ?>" title="<?php bloginfo( 'name' ); ?>">
			<?php bloginfo( 'name' ); ?>
		</a>
	</h2>
	<?php
}
?>
<p class="only-for-print">
	<?php bloginfo( 'description' ); ?>
</p><!-- /.only-for-print -->
