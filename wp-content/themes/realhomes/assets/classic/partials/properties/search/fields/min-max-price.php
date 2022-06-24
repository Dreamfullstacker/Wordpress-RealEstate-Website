<?php
/**
 * Minimum and Maximum Price Fields
 */

$inspiry_min_price_label = get_option( 'inspiry_min_price_label' );
$inspiry_max_price_label = get_option( 'inspiry_max_price_label' );
?>
<div class="option-bar rh-search-field small rh_field_one_others price-for-others">
    <label for="select-min-price">
		<?php echo !empty( $inspiry_min_price_label ) ? esc_html( $inspiry_min_price_label ) : esc_html__( 'Min Price', 'framework' ); ?>
    </label>
    <span class="selectwrap">
        <select name="min-price" id="select-min-price" class="inspiry_select_picker_trigger inspiry_select_picker_price show-tick">
            <?php min_prices_list(); ?>
        </select>
    </span>
</div>

<div class="option-bar rh-search-field small rh_field_two_others price-for-others">
    <label for="select-max-price">
		<?php echo !empty( $inspiry_max_price_label ) ? esc_html( $inspiry_max_price_label ) : esc_html__( 'Max Price', 'framework' ); ?>
    </label>
    <span class="selectwrap">
        <select name="max-price" id="select-max-price" class="inspiry_select_picker_trigger inspiry_select_picker_price show-tick">
            <?php max_prices_list(); ?>
        </select>
    </span>
</div>

<?php
/**
 * Prices for Rent
 */
?>
<div class="option-bar rh-search-field small price-for-rent rh_field_one_rent hide-fields">
    <label for="select-min-price-for-rent">
		<?php echo !empty( $inspiry_min_price_label ) ? esc_html( $inspiry_min_price_label ) : esc_html__( 'Min Price', 'framework' ); ?>
    </label>
    <span class="selectwrap">
        <select name="min-price" id="select-min-price-for-rent" class="inspiry_select_picker_trigger inspiry_select_picker_price show-tick" disabled="disabled">
            <?php min_prices_for_rent_list(); ?>
        </select>
    </span>
</div>

<div class="option-bar rh-search-field small rh_field_two_rent price-for-rent hide-fields">
    <label for="select-max-price-for-rent">
		<?php echo !empty( $inspiry_max_price_label ) ? esc_html( $inspiry_max_price_label ) : esc_html__( 'Max Price', 'framework' ); ?>
    </label>
    <span class="selectwrap">
        <select name="max-price" id="select-max-price-for-rent" class="inspiry_select_picker_trigger inspiry_select_picker_price show-tick" disabled="disabled">
            <?php max_prices_for_rent_list(); ?>
        </select>
    </span>
</div>