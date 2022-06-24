<?php
/**
 * Property Features Checkboxes
 */

global $the_widget_id;
global $settings;

/* all property features terms */

if ( 'yes' == $settings['show_advance_features'] ) {

	$all_features = get_terms( array( 'taxonomy' => 'property-feature' ) );

	if ( ! empty( $all_features ) && ! is_wp_error( $all_features ) ) {

		/* features in search query */
		$required_features_slugs = array();
		if ( isset( $_GET['features'] ) ) {
			$required_features_slugs = $_GET['features'];
		}
		?>
        <div class="rhea-more-options-mode-container" id="rhea_features_<?php echo esc_attr( $the_widget_id ); ?>">
            <div class="rhea-more-options-wrapper rhea-more-options-wrapper-mode clearfix <?php echo ( count( $required_features_slugs ) > 0 ) ? '' : 'collapsed'; ?>">
				<?php
				foreach ( $all_features as $feature ) {
					?>
                    <div class="rhea-option-bar">
                        <input type="checkbox"
                               id="feature-<?php echo esc_attr( $the_widget_id . '-' . $feature->slug ); ?>"
                               name="features[]"
                               value="<?php echo esc_attr( $feature->slug ); ?>"
							<?php if ( in_array( $feature->slug, $required_features_slugs ) ) {
								echo 'checked';
							} ?> />
                        <label for="feature-<?php echo esc_attr( $the_widget_id . '-' . $feature->slug ); ?>"><?php echo ucwords( $feature->name ); ?>
                            <small>(<?php echo esc_html( $feature->count ); ?>)</small>
                        </label>
                    </div>
					<?php

				} ?>
            </div>
            <span class="rhea_open_more_features">
        	<?php
	        $inspiry_search_features_title = $settings['advance_features_text'];
	        if ( $inspiry_search_features_title ) {
		        echo esc_html( $inspiry_search_features_title );
	        } else {
		        esc_html_e( 'Looking for certain features?', 'realhomes-elementor-addon' );
	        }
	        ?>
    </span>

        </div>
		<?php

	}

}