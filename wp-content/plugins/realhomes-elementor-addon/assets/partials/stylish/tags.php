<?php
global $settings;
$is_featured = get_post_meta( get_the_ID(), 'REAL_HOMES_featured', true );
$label_text  = get_post_meta( get_the_ID(), 'inspiry_property_label', true );

$ere_show_featured_tag = $settings['ere_show_featured_tag'];
$ere_show_label_tags   = $settings['ere_show_label_tags'];

if ( $ere_show_featured_tag == 'yes' || $ere_show_label_tags == 'yes' ) {
	?>
    <div class="rhea_tags_wrapper">
		<?php
		if ( $ere_show_featured_tag == 'yes' ) {
			if ( isset( $is_featured ) && $is_featured == '1' ) {
				?>
                <span class="rhea-tags rhea_featured"><?php include RHEA_ASSETS_DIR . 'icons/featured.svg'; ?>
                    <span class="rhea_tags_tooltip">
                                            <span class="rhea_tags_tooltip_inner"><?php echo esc_html( $settings['ere_property_featured_label'] ) ?></span>
                                            </span>
                                    </span>
				<?php
			}
		}
		if ( $ere_show_label_tags == 'yes' ) {
			if ( isset( $label_text ) && ! empty( $label_text ) ) {
				?>
                <span class="rhea-tags rhea_hot <?php if ( isset( $label_text_bg ) && ! empty( $label_text_bg ) ) {
					echo esc_attr( 'rhea_default_label' );
				} ?>"><?php include RHEA_ASSETS_DIR . 'icons/hot-icon.svg'; ?>
                    <span class="rhea_tags_tooltip">
                                            <span class="rhea_tags_tooltip_inner"><?php echo esc_html( $label_text ); ?></span>
                                            </span>
                                    </span>
				<?php
			}
		}
		?>
    </div>
	<?php
}
?>