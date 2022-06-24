<?php
global $settings;
$show_fav_button = $settings['ere_enable_fav_properties'];
$fav_label       = $settings['ere_property_fav_label'];
$fav_added_label = $settings['ere_property_fav_added_label'];



$fav_button = get_option( 'theme_enable_fav_button' );
if ( 'true' === $fav_button ) {
	if ( 'yes' === $show_fav_button ) {
		?>
        <div class="rh_prop_card__btns rhea_svg_fav_icons ">
			<?php
			if ( is_added_to_favorite( get_the_ID() ) ) {
				?>
                <span class="favorite-placeholder highlight__red <?php echo esc_attr( $user_status ); ?>" data-propertyid="<?php echo esc_attr( $property_id ); ?>"
                      data-tooltip="<?php if ( $fav_added_label ) {
					      echo esc_attr( $fav_added_label );
				      } else {
					      echo esc_attr__( 'Added to favorites', 'realhomes-elementor-addon' );
				      }; ?>">
								<?php include RHEA_ASSETS_DIR . '/icons/favorite.svg'; ?>
							</span>
				<?php
			} else {
				?>
				<span class="favorite-btn-wrap favorite-btn-<?php echo esc_attr( $property_id ); ?>">
					<span class="favorite-placeholder highlight__red hide <?php echo esc_attr( $user_status ); ?>" data-propertyid="<?php echo esc_attr( $property_id ); ?>"
					data-tooltip="
					<?php
					if ( $fav_added_label ) {
						echo esc_attr( $fav_added_label );
					} else {
						echo esc_attr__( 'Added to favorites', 'realhomes-elementor-addon' );
					}; ?>">
						<?php include RHEA_ASSETS_DIR . '/icons/favorite.svg'; ?>
					</span>
					<a href="#" class="favorite ere-add-to-favorite <?php echo esc_attr( $user_status ); ?>"
					data-tooltip="
					<?php
					if ( $fav_label ) {
						echo esc_attr( $fav_label );
					} else {
						echo esc_attr__( 'Add to favorites', 'realhomes-elementor-addon' );
					}; ?>"
					data-propertyid="<?php echo esc_attr( $property_id ); ?>"
					>
					<?php include RHEA_ASSETS_DIR . '/icons/favorite.svg'; ?>
					</a>
				</span>
				<?php
			}
			?>
        </div>
		<?php
	}
}
?>
