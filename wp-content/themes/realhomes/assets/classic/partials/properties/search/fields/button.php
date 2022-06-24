<?php
/**
 * Search Button
 */
?>
<div class="option-bar">
	<?php $inspiry_search_button_text = get_option( 'inspiry_search_button_text' ); ?>
    <input type="submit"
           value="<?php echo !empty( $inspiry_search_button_text ) ? esc_attr( $inspiry_search_button_text ) : esc_attr__( 'Search', 'framework' ); ?>"
           class="real-btn btn">
</div>