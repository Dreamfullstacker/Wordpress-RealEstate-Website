<?php
/**
 * Property Features Checkboxes
 */
if ( class_exists( 'ERE_Data' ) ) {

	$all_features = ERE_Data::get_hierarchical_property_features();

	if ( ! empty( $all_features ) ) {

		/* features in search query */
		$searched_feature_slugs = array();
		if ( isset( $_GET['features'] ) ) {
			$searched_feature_slugs = $_GET['features'];
		}
		?>
        <div class="clearfix"></div>
        <div class="more-option-trigger">
            <a href="#">
                <i class="far <?php echo ( count( $searched_feature_slugs ) > 0 ) ? 'fa-minus-square' : 'fa-plus-square'; ?>"></i>
				<?php
				$inspiry_search_features_title = get_option( 'inspiry_search_features_title' );
				if ( $inspiry_search_features_title ) {
					echo esc_html( $inspiry_search_features_title );
				} else {
					esc_html_e( 'Looking for certain features', 'framework' );
				}
				?>
            </a>
        </div>
        <div class="more-options-wrapper clearfix <?php echo ( count( $searched_feature_slugs ) > 0 ) ? '' : 'collapsed'; ?>">
			<?php
			foreach ( $all_features as $feature ) {
				?>
                <div class="option-bar">
                    <input type="checkbox" id="feature-<?php echo esc_attr( $feature['slug'] ); ?>" name="features[]"
                           value="<?php echo esc_attr( $feature['slug'] ); ?>"<?php
                            if ( in_array( $feature['slug'] , $searched_feature_slugs ) ) {
							    echo 'checked';
						    } ?> />
                    <label for="feature-<?php echo esc_attr( $feature['slug'] ); ?>">
                        <?php echo esc_html( ucwords( $feature['name'] ) ); ?>
                        <small>(<?php echo esc_html( $feature['count'] ); ?>)</small>
                    </label>
                </div>
				<?php
			} ?>
        </div>
		<?php
	}
}