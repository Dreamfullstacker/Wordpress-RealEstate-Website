<?php
/**
 * Field: Price
 *
 * Price field for advance property search.
 *
 * @since    3.0.0
 * @package realhomes/modern
 */

$inspiry_min_price_label = get_option( 'inspiry_min_price_label' );
$inspiry_max_price_label = get_option( 'inspiry_max_price_label' );
?>
<div class="rh_prop_search__option rh_prop_search__select price-for-others inspiry_select_picker_field">
    <label for="select-min-price">
		<?php
		if ( !empty( $inspiry_min_price_label ) ) {
			echo esc_html( $inspiry_min_price_label );
		} else {
			esc_html_e( 'Min Price', 'framework' );
		}
		?>
    </label>
    <span class="rh_prop_search__selectwrap">
		<select name="min-price" id="select-min-price" class="inspiry_select_picker_trigger inspiry_select_picker_price show-tick" data-size="5">
			<?php min_prices_list(); ?>
		</select>
	</span>
</div>

<div class="rh_prop_search__option rh_prop_search__select price-for-others inspiry_select_picker_field">
    <label for="select-max-price">
		<?php
		if ( !empty( $inspiry_max_price_label ) ) {
			echo esc_html( $inspiry_max_price_label );
		} else {
			esc_html_e( 'Max Price', 'framework' );
		}
		?>
    </label>
    <span class="rh_prop_search__selectwrap">
		<select name="max-price" id="select-max-price" class="inspiry_select_picker_trigger inspiry_select_picker_price show-tick" data-size="5">
			<?php max_prices_list(); ?>
		</select>
	</span>
</div>

<?php
/**
 * Prices for Rent
 */
?>
<div class="rh_prop_search__option rh_prop_search__select price-for-rent hide-fields inspiry_select_picker_field">
    <label for="select-min-price-for-rent">
		<?php
		if ( $inspiry_min_price_label ) {
			echo esc_html( $inspiry_min_price_label );
		} else {
			esc_html_e( 'Min Price', 'framework' );
		}
		?>
    </label>
    <span class="rh_prop_search__selectwrap">
	    <select name="min-price" id="select-min-price-for-rent" class="inspiry_select_picker_trigger inspiry_select_picker_price show-tick" data-size="5" disabled="disabled">
	        <?php min_prices_for_rent_list(); ?>
	    </select>
	</span>
</div>

<div class="rh_prop_search__option rh_prop_search__select price-for-rent hide-fields inspiry_select_picker_field">
    <label for="select-max-price-for-rent">
		<?php
		if ( $inspiry_max_price_label ) {
			echo esc_html( $inspiry_max_price_label );
		} else {
			esc_html_e( 'Max Price', 'framework' );
		}
		?>
    </label>
    <span class="rh_prop_search__selectwrap">
	    <select name="max-price" id="select-max-price-for-rent" class="inspiry_select_picker_trigger inspiry_select_picker_price show-tick" data-size="5" disabled="disabled">
	        <?php max_prices_for_rent_list(); ?>
	    </select>
	</span>
</div>
