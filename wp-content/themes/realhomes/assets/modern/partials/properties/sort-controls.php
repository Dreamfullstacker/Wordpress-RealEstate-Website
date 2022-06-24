<?php
/**
 * Sort Controls
 *
 * Properties sort controls.
 *
 * @since 	   3.0.0
 * @package    realhomes
 * @subpackage modern
 */
?>
<div class="rh_sort_controls">
	<?php $sort_by = inspiry_get_properties_sort_by_value(); ?>
	<select name="sort-properties" id="sort-properties" class="inspiry_select_picker_trigger inspiry_bs_default_mod inspiry_bs_listing inspiry_bs_green">
	    <option value="default"><?php esc_html_e( 'Default Order', 'framework' );?></option>
	    <option value="price-asc" <?php echo ( 'price-asc' == $sort_by ) ? 'selected' : '' ; ?>><?php esc_html_e( 'Price Low to High', 'framework' );?></option>
	    <option value="price-desc" <?php echo ( 'price-desc' == $sort_by ) ? 'selected' : '' ; ?>><?php esc_html_e( 'Price High to Low', 'framework' );?></option>
	    <option value="date-asc" <?php echo ( 'date-asc' == $sort_by ) ? 'selected' : '' ; ?>><?php esc_html_e( 'Date Old to New', 'framework' );?></option>
	    <option value="date-desc" <?php echo ( 'date-desc' == $sort_by ) ? 'selected' : '' ; ?>><?php esc_html_e( 'Date New to Old', 'framework' );?></option>
	</select>
</div><!-- /.rh_sort_controls -->