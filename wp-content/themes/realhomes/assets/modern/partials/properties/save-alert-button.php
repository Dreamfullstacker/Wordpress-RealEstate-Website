<?php
/**
 * Save Search Form.
 *
 * @package realhomes/modern/search
 */

if ( inspiry_is_save_search_enabled() && ! empty( $_SERVER['QUERY_STRING'] ) ) {
	$save_search_label  = get_option( 'realhomes_save_search_btn_label', esc_html__( 'Save Search', 'framework' ) );
	$search_saved_label = get_option( 'realhomes_search_saved_btn_label', esc_html__( 'Search Saved', 'framework' ) );
	$save_sarch_tooltip = get_option( 'realhomes_save_search_btn_tooltip', esc_html__( 'Receive email notification for the latest properties matching your search criteria.', 'framework' ) );
	if ( ! empty( $save_search_label ) && ! empty( $search_saved_label ) ) {
		?>
		<div id="rh_save_search">
			<?php
			if ( is_user_logged_in() ) {
				?>
				<form action="post">
					<input class="rh_wp_query_args" type="hidden" name="search_args" value="<?php print base64_encode( serialize( $args['search_args'] ) ); ?>">
					<input class="rh_url_query_str" type="hidden" name="search_url" value="<?php echo esc_attr( rawurldecode( $_SERVER['QUERY_STRING'] ) ); ?>">
					<input class="rh_save_search_nonce" type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'inspiry_save_search' ) ); ?>"/>
					<button id="rh_save_search_btn" data-saved-label="<?php echo esc_attr( $search_saved_label ); ?>" <?php echo ( ! empty( $save_sarch_tooltip ) ) ? 'data-tooltip="' . esc_attr( $save_sarch_tooltip ) . '"' : ''; ?>>
						<i class="far fa-bell"></i><?php echo esc_html( $save_search_label ); ?>
					</button>
				</form>
				<?php
			} else {
				$theme_login_url = inspiry_get_login_register_url(); // login and register page URL.
				?>
				<form action="post">
					<input class="rh_wp_query_args" type="hidden" name="search_args" value="<?php print base64_encode( serialize( $args['search_args'] ) ); ?>">
					<input class="rh_url_query_str" type="hidden" name="search_url" value="<?php echo esc_attr( rawurldecode( $_SERVER['QUERY_STRING'] ) ); ?>">

					<!--- Non logged in user specific part --->
					<input class="rh_current_time" type="hidden" name="current_time" value="<?php echo esc_attr( current_time( 'mysql' ) ); ?>">
					<button id="rh_save_search_btn" class="require-login" data-saved-label="<?php echo esc_attr( $search_saved_label ); ?>" data-login="<?php echo esc_url( $theme_login_url ); ?>" <?php echo ( ! empty( $save_sarch_tooltip ) ) ? 'data-tooltip="' . esc_attr( $save_sarch_tooltip ) . '"' : ''; ?>>
						<i class="far fa-bell"></i><?php echo esc_html( $save_search_label ); ?>
					</button>

				</form>
				<?php
			}
			?>
		</div>
		<?php
	}
}
?>
