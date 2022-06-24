<?php
/**
 * Field: Property Area
 *
 * Area field for advance property search.
 *
 * @since 	3.0.0
 * @package realhomes/modern
 */

$area_unit 				= get_option( 'theme_area_unit' );
$min_area_placeholder 	= get_option( 'inspiry_min_area_placeholder_text' );
$max_area_placeholder 	= get_option( 'inspiry_max_area_placeholder_text' );
?>
<div class="rh_prop_search__option rh_mod_text_field rh_min_area_field_wrapper">
	<label for="min-area">
		<span class="label">
			<?php
		    $inspiry_min_area_label = get_option( 'inspiry_min_area_label' );
			if ( $inspiry_min_area_label ) {
				echo esc_html( $inspiry_min_area_label );
			} else {
				esc_html_e( 'Min Area', 'framework' );
			}
		    ?>
	    </span>
		<span class="unit">
			<?php
			if ( $area_unit ) {
		        echo esc_html( "($area_unit)" );
		    }
		    ?>
	    </span>
	</label>
	<input type="text" autocomplete="off" name="min-area" id="min-area" pattern="[0-9]+"
	       value="<?php echo isset( $_GET['min-area'] ) ? $_GET['min-area'] : ''; ?>"
	       placeholder="<?php echo empty( $min_area_placeholder ) ? esc_attr( rh_any_text() ) : esc_attr( $min_area_placeholder ); ?>"
	       title="<?php esc_attr_e( 'Only provide digits!', 'framework' ); ?>" />
</div>

<div class="rh_prop_search__option rh_mod_text_field rh_max_area_field_wrapper">
	<label for="max-area">
		<span class="label">
			<?php
		    $inspiry_max_area_label = get_option( 'inspiry_max_area_label' );
			if ( $inspiry_max_area_label ) {
				echo esc_html( $inspiry_max_area_label );
			} else {
				esc_html_e( 'Max Area', 'framework' );
			}
		    ?>
	    </span>
		<span class="unit">
			<?php
			if ( $area_unit ) {
	            echo esc_html( "($area_unit)" );
	        }
	        ?>
		</span>
	</label>
	<input type="text" autocomplete="off" name="max-area" id="max-area" pattern="[0-9]+"
	       value="<?php echo isset( $_GET['max-area'] ) ? esc_attr( $_GET['max-area'] ) : '' ; ?>"
	       placeholder="<?php echo empty( $max_area_placeholder ) ? esc_attr( rh_any_text() ) : esc_attr( $max_area_placeholder ); ?>"
	       title="<?php esc_attr_e( 'Only provide digits!', 'framework' ); ?>" />
</div>
