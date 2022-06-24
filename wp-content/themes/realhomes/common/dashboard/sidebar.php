<div id="dashboard-sidebar" class="dashboard-sidebar">
	<?php
	global $dashboard_globals, $current_module;

	/**
	 * Fires before the sidebar menu.
	 *
	 * @since 3.12
	 */
	do_action( 'realhomes_dashboard_before_menu' );

	$dashboard_url = $dashboard_globals['dashboard_url'];
	$menu          = realhomes_dashboard_menus()['menu'];
	if ( ! empty( $menu ) && is_array( $menu ) ) :
		$submenu = realhomes_dashboard_menus()['submenu'];
		?>
        <ul id="dashboard-menu" class="dashboard-menu">
			<?php
			// 0 = menu_title, 1 = page_title, 2 = icon, 3 = show_in_menu
			foreach ( $menu as $key => $item ) {

				if ( isset( $item[3] ) && ! $item[3] ) {
					continue;
				}

				$icon          = '';
				$arrow         = '';
				$class         = array();
				$submenu_items = array();

				if ( ! empty( $submenu[ $key ] ) ) {
					$class[]       = 'has-submenu';
					$arrow         = '<i class="fas fa-angle-down"></i>';
					$submenu_items = $submenu[ $key ];
				}

				$class[] = 'menu-item-' . esc_attr( $key );

				if ( $key === $current_module ) {
					$class[] = 'current';
				}

				$class = $class ? ' class="' . join( ' ', $class ) . '"' : '';

				if ( ! empty( $item[2] ) ) {
					$icon = '<i class="' . esc_attr( $item[2] ) . '"></i>';
				}

				$title = wptexturize( $item[0] );

				$url = add_query_arg( 'module', $key, $dashboard_url );

				if ( 'logout' === $key ) {
					$url = esc_url( wp_logout_url( home_url( '/' ) ) );
				}

				$submenu_list_items = '';
				if ( ! empty( $submenu_items ) ) {
					// 0 = menu_title, 1 = page_title, 2 = Query parameters
					foreach ( $submenu_items as $sub_key => $sub_item ) {

						if ( isset( $sub_item[3] ) && ! $sub_item[3] ) {
							continue;
						}

						$sub_item_class = array();

						$sub_item_class[] = 'sub-menu-item-' . esc_attr( $sub_key );

						if ( $dashboard_globals['submenu'] ) {
							if ( isset( $_GET ) && ! empty( $_GET ) ) {
								if ( in_array( $sub_key, array_values( $_GET ) ) ) {
									$sub_item_class[] = 'current';
								}
							}
						}

						$sub_item_url = $url;

						if ( isset( $sub_item[2] ) && ! empty( $sub_item[2] ) ) {
							$sub_item_url = add_query_arg( $sub_item[2], $sub_item_url );
						}

						$sub_item_class          = $sub_item_class ? ' class="' . join( ' ', $sub_item_class ) . '"' : '';
						$sub_item_title = wptexturize( $sub_item[0] );
						$sub_item_url   = esc_url( $sub_item_url );

						$submenu_list_items .= "<li$sub_item_class><a href='$sub_item_url'>{$sub_item_title}</a></li>";
					}
				}

				echo "\n\t<li$class>";

				if ( ! empty( $submenu_list_items ) ) {
					echo "\n\t<a href='{$url}'>$icon<span class='menu-item-name'>{$title}</span>$arrow</a>";
					echo "\n\t<ul class='submenu'>{$submenu_list_items}</ul>";
				} else {
					echo "\n\t<a href='{$url}'>$icon<span class='menu-item-name'>{$title}</span></a>";
				}

				echo '</li>';
			}
			?>
        </ul><!-- #dashboard-menu -->
	<?php
	endif;

	/**
	 * Fires after the sidebar menu.
	 *
	 * @since 3.12
	 */
	do_action( 'realhomes_dashboard_after_menu' );
	?>
</div><!-- #dashboard-sidebar -->