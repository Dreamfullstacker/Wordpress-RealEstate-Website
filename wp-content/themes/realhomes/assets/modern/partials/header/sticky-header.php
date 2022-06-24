<div class="rh_sticky_header_container">
    <div class="rh_sticky_header_logo">
	    <?php
	    $sticky_header_logo = get_option( 'realhomes_sticky_header_logo' );
	    if ( ! empty( $sticky_header_logo ) ) {
		    ?>
            <a title="<?php bloginfo( 'name' ); ?>" href="<?php echo esc_url( home_url() ); ?>">
			    <?php inspiry_logo_img( $sticky_header_logo, '' ); ?>
            </a>
		    <?php
	    } else {
		    get_template_part( 'assets/modern/partials/header/site-logo' );
	    }
	    ?>
    </div>
    <div class="rh_sticky_header_menu">
        <?php get_template_part( 'assets/modern/partials/header/menu-list-large-screens' ); ?>
        <?php get_template_part( 'assets/modern/partials/header/submit-property' ); ?>
    </div>
</div>