<?php
/**
 * Add to favorites for property detail page.
 *
 * @package    realhomes
 * @subpackage classic
 */

$fav_button = get_option( 'theme_enable_fav_button' );
if ( 'true' === $fav_button ) {
	?>
    <span class="add-to-fav">
	<?php
	$require_login = get_option( 'inspiry_login_on_fav', 'no' );
	if ( ( is_user_logged_in() && 'yes' == $require_login ) || ( 'yes' != $require_login ) ) {
		$property_id = get_the_ID();
		$user_status = 'user_not_logged_in';
		if ( is_user_logged_in() ) {
			$user_status = 'user_logged_in';
		}

		if ( is_added_to_favorite( $property_id ) ) {
			?>
			<span class="favorite-btn-wrap favorite-btn-<?php echo esc_attr( $property_id ); ?>">
				<span class="btn-fav favorite-placeholder highlight__red <?php echo esc_attr( $user_status ); ?>" data-propertyid="<?php echo esc_attr( $property_id ); ?>" title="<?php esc_attr_e( 'Added to favorites', 'framework' ); ?>">
					<?php inspiry_safe_include_svg( '/images/icon-favorite.svg' ); ?>
				</span>
				<a href="#" class="btn-fav favorite add-to-favorite hide <?php echo esc_attr( $user_status ); ?>" title="<?php esc_attr_e( 'Add to favorite', 'framework' ); ?>" data-propertyid="<?php echo esc_attr( $property_id ); ?>">
					<?php inspiry_safe_include_svg( '/images/icon-favorite.svg' ); ?>
				</a>
			</span>
			<?php
		} else {
			?>
			<span class="favorite-btn-wrap favorite-btn-<?php echo esc_attr( $property_id ); ?>">
				<span class="btn-fav favorite-placeholder highlight__red hide <?php echo esc_attr( $user_status ); ?>" data-propertyid="<?php echo esc_attr( $property_id ); ?>" title="<?php esc_attr_e( 'Added to favorites', 'framework' ); ?>">
					<?php inspiry_safe_include_svg( '/images/icon-favorite.svg' ); ?>
				</span>
				<a href="#" class="btn-fav favorite add-to-favorite <?php echo esc_attr( $user_status ); ?>" title="<?php esc_attr_e( 'Add to favorite', 'framework' ); ?>" data-propertyid="<?php echo esc_attr( $property_id ); ?>">
					<?php inspiry_safe_include_svg( '/images/icon-favorite.svg' ); ?>
				</a>
			</span>
			<?php
		}
	} else {
		?>
        <a class="inspiry_submit_login_required" href="#login-modal" data-toggle="modal">
            <span class="btn-fav favorite-placeholder" title="<?php esc_attr_e( 'Add to favorites', 'framework' ); ?>">
            <?php inspiry_safe_include_svg( '/images/icon-favorite.svg' ); ?>
            </span>
        </a>
		<?php
	}
	?>
    </span>
	<?php
}
