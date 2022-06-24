<?php
$logo_path        = apply_filters( 'inspiry_logo', get_option( 'theme_sitelogo' ) );
$retina_logo_path = apply_filters( 'inspiry_logo_retina', get_option( 'theme_sitelogo_retina' ) );
$logo_url         = apply_filters( 'inspiry_logo_url', home_url( '/' ) );
if ( ! empty( $logo_path ) || ! empty( $retina_logo_path ) ) : ?>
    <a class="site-logo" href="<?php echo esc_url( $logo_url ); ?>" title="<?php bloginfo( 'name' ); ?>">
		<?php inspiry_logo_img( $logo_path, $retina_logo_path ); ?>
    </a>
<?php else : ?>
    <h2 class="logo-heading">
        <a href="<?php echo esc_url( home_url() ); ?>" title="<?php bloginfo( 'name' ); ?>"><?php bloginfo( 'name' ); ?></a>
    </h2>
	<?php
endif;

$description = get_bloginfo( 'description' );
if ( $description ) : ?>
    <div class="tag-line"><span><?php echo esc_html( $description ); ?></span></div>
<?php endif; ?>