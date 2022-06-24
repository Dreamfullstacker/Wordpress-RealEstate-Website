<?php
$is_featured = get_post_meta( get_the_ID(), 'REAL_HOMES_featured', true );
$label_text  = get_post_meta( get_the_ID(), 'inspiry_property_label', true );
global $featured_text;
?>
<div class="rh_tags_wrapper">
	<?php
	if ( isset( $is_featured ) && $is_featured == '1' ) {
		?>
        <span class="rh-tags rh_featured">
             <?php
             ere_safe_include_svg( '/images/icons/featured.svg' );
             ?>
            <span class="rh_tags_tooltip">
                <span class="rh_tags_tooltip_inner">
                    		<?php
		                    if ( ! empty( $featured_text ) ) {
			                    echo esc_html( $featured_text );
		                    } else {
			                    esc_html_e( 'Featured', 'easy-real-estate' );
		                    }
		                    ?>
                </span>
            </span>
        </span>
		<?php
	}
	if ( isset( $label_text ) && ! empty( $label_text ) ) {
		?>
        <span class="rh-tags rh_hot <?php if ( isset( $label_text_bg ) && ! empty( $label_text_bg ) ) {
			echo esc_attr( 'rh_default_label' );
		} ?>">
             <?php
             ere_safe_include_svg( '/images/icons/hot-icon.svg' );
             ?>
            <span class="rh_tags_tooltip">
                <span class="rh_tags_tooltip_inner"><?php echo esc_html( $label_text ); ?></span>
            </span>
        </span>
		<?php
	}
	?>
</div>
