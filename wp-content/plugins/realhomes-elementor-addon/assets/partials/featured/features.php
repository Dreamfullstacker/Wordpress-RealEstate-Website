<?php
global $settings;
$features_terms = get_the_terms( get_the_ID(), 'property-feature' );

$rhea_get_term_count = '';
if ( $features_terms && count( $features_terms ) > 0 ) {
	$rhea_get_term_count = ( count( $features_terms ) );
}

if ( ! empty( $features_terms ) ) {
	?>
    <span class="rhea_features_title">
        <?php
        if ( $settings['ere_property_features_label'] ) {
	        echo esc_html( $settings['ere_property_features_label'] );
        } else {
	        echo esc_html__( 'Features', 'realhomes-elementor-addon' );
        }
        ?>
    </span>
    <ul class="rhea_fp_features_list">
		<?php

		$counter   = 0;
		$max_limit = $settings['show_max_features_list'];
		foreach ( $features_terms as $feature_term ) {
			if ( $counter < $max_limit ) {
				?>
                <li class="rhea_feature_item">
                    <span class="rhea_check_icon"><?php include RHEA_ASSETS_DIR . '/icons/check.svg'; ?></span>
                    <a href="<?php echo esc_attr( get_term_link( $feature_term, 'property-feature' ) ); ?>">
						<?php echo esc_html( $feature_term->name ); ?>
                    </a>
                </li>
				<?php
			}
			$counter ++;
		}
		if ( $rhea_get_term_count > $max_limit ) {
			?>
            <li class="rhea_fp_features_count">
				<?php
				$terms_left = $rhea_get_term_count - $max_limit;
				?>
                <span class="rhea_features_count_left">+<?php echo esc_html( $terms_left ); ?></span>
            </li>
			<?php
		}
		?>
    </ul>
	<?php
}