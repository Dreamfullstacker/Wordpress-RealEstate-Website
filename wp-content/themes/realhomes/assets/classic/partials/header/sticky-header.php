<div class="rh_sticky_header_container">
    <div class="header_logo">
		<?php get_template_part( 'assets/classic/partials/header/logo' ); ?>
    </div>
    <div class="main-menu">
		<?php
		if ( has_nav_menu( 'main-menu' ) ) {
			wp_nav_menu( array(
				'theme_location' => 'main-menu',
				'walker'         => new RH_Walker_Nav_Menu(),
				'menu_class'     => 'rh_menu__main_menu clearfix',
				'fallback_cb'    => false // Do not fall back to wp_page_menu()
			) );
		}
		?>
    </div>
</div>