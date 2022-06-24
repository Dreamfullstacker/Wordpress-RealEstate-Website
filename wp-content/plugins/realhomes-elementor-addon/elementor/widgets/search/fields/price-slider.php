<?php
/**
 * Field: Price Slider
 *
 * Agent field for advance property search widget.
 *
 */

global $settings;
global $the_widget_id;

$rhea_searched_price_min='';
$rhea_searched_price_max='';
$custom_min_price = rhea_get_min_max_price( 'min' );
$custom_max_price = rhea_get_min_max_price( 'max' );
if(isset($_GET['min-price'])){
	$rhea_searched_price_min = $_GET['min-price'];
	$custom_min_price = $_GET['min-price'];
}

if(isset($_GET['max-price'])){
	$rhea_searched_price_max = $_GET['max-price'];
	$custom_max_price = $_GET['max-price'];
}


$search_fields_to_display = RHEA_Search_Form_Widget::rhea_search_select_sort();
if ( is_array( $search_fields_to_display ) && in_array( 'min-max-price', $search_fields_to_display ) ) {

	$field_key = array_search( 'min-max-price', $search_fields_to_display );
	$field_key = intval( $field_key ) + 1;


// TODO: support for currency converter
//	$rhea_price_post_fix = get_post_meta( get_the_ID(), 'REAL_HOMES_property_price_postfix', true );
//	$rhea_currency            = ere_get_currency_sign();
//	$rhea_decimals            = intval( get_option( 'theme_decimals', '2' ) );
//	$rhea_decimal_point       = get_option( 'theme_dec_point', '.' );
//	$rhea_thousands_separator = get_option( 'theme_thousands_sep', ',' );
//	$rhea_currency_position   = get_option( 'theme_currency_position' );


    $price_range_on_top = '';

    if('yes' == $settings['price_range_on_top']){
        $price_range_on_top = 'rhea_price_range_on_top';
    }
	?>
    <div style="order: <?php echo esc_attr( $field_key ); ?>"
         class="rhea_prop_search__option  rhea_price_slider_field <?php echo esc_attr($price_range_on_top);?>"
         id="price-slider-<?php echo esc_attr( $the_widget_id ); ?>"
         data-key-position="<?php echo esc_attr( $field_key ); ?>"
    >


		<?php
		if ( 'yes' === $settings['show_labels'] ) {
			?>
            <label class="rhea_fields_labels" for="rhea_slider_<?php echo esc_attr( $the_widget_id ); ?>">
				<?php if ( ! empty( $settings['keyword-label'] ) ) {
					echo esc_html( $settings['keyword-label'] );
				} else {
					esc_html_e( 'Price Range', 'realhomes-elementor-addon' );
				} ?>
            </label>
			<?php
		}
		?>

        <input name="min-price" type="hidden" value="<?php echo esc_attr($rhea_searched_price_min);?>" class="rhea_slider_value rhea_min_value" data-index="0"/>
        <input name="max-price" type="hidden" value="<?php echo esc_attr($rhea_searched_price_max);?>" class="rhea_slider_value rhea_max_value" data-index="1"/>

        <div class="rhea_price_slider_wrapper" id="rhea_slider_<?php echo esc_attr( $the_widget_id ) ?>">
            <div class="rhea_price_label">
				<?php
				if ( ! empty( $settings['slider_range_label'] ) ) {
					echo esc_html( $settings['slider_range_label'] );
				} else {
					esc_html_e( 'Price Range:', 'realhomes-elementor-addon' );
				}
				?>
            </div>
            <div class="rhea_price_slider"></div>
            <div class="rhea_price_range">
				<?php
				if ( ! empty( $settings['slider_range_from'] ) ) {
					echo esc_html( $settings['slider_range_from'] );
				} else {
					esc_html_e( 'From', 'realhomes-elementor-addon' );
				}
				?>
                <span class="rhea_price_display rhea_min_slide"
                      data-index="0"><?php echo rhea_get_custom_price( $custom_min_price ) ?></span>
				<?php
				if ( ! empty( $settings['slider_range_to'] ) ) {
					echo esc_html( $settings['slider_range_to'] );
				} else {
					esc_html_e( 'To', 'realhomes-elementor-addon' );
				}
				?>
                <span class="rhea_price_display rhea_max_slide"
                      data-index="1"><?php echo rhea_get_custom_price( $custom_max_price ) ?></span>
            </div>
        </div>

    </div>

	<?php
}
?>