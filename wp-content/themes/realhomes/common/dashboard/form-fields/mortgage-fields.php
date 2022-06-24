<?php
$inspiry_property_tax   = get_option( 'inspiry_mc_first_field_value', '0' );
$inspiry_additional_fee = get_option( 'inspiry_mc_second_field_value', '0' );

if ( realhomes_dashboard_edit_property() ) {
	global $post_meta_data;

	if ( isset( $post_meta_data['inspiry_property_tax'] ) ) {
		$inspiry_property_tax = $post_meta_data['inspiry_property_tax'][0];
	}

	if ( isset( $post_meta_data['inspiry_additional_fee'] ) ) {
		$inspiry_additional_fee = $post_meta_data['inspiry_additional_fee'][0];
	}
}

if ( 'true' === get_option( 'inspiry_mc_first_field_display', 'true' ) ) :
	?>
    <div class="col-md-6">
        <p>
            <label for="inspiry_property_tax"><?php echo esc_html( get_option( 'inspiry_mc_first_field_title', esc_html__( 'Property Taxes', 'framework' ) ) ); ?></label>
            <input id="inspiry_property_tax" name="inspiry_property_tax" type="text"
                   value="<?php echo esc_attr( $inspiry_property_tax ); ?>"/>
            <span class="note"><?php echo esc_html( get_option( 'inspiry_mc_first_field_desc', esc_html__( 'Provide monthly property tax amount. It will be displayed in the mortgage calculator only.', 'framework' ) ) ); ?></span>
        </p>
    </div>
<?php
endif;

if ( 'true' === get_option( 'inspiry_mc_second_field_display', 'true' ) ) :
	?>
    <div class="col-md-6">
        <p>
            <label for="inspiry_additional_fee"><?php echo esc_html( get_option( 'inspiry_mc_second_field_title', esc_html__( 'Additional Fee', 'framework' ) ) ); ?></label>
            <input id="inspiry_additional_fee" name="inspiry_additional_fee" type="text"
                   value="<?php echo esc_attr( $inspiry_additional_fee ) ?>"/>
            <span class="note"><?php echo esc_html( get_option( 'inspiry_mc_second_field_desc', esc_html__( 'Provide monthly any additional fee. It will be displayed in the mortgage calculator only.', 'framework' ) ) ); ?></span>
        </p>
    </div>
<?php
endif;