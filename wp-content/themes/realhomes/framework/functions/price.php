<?php
/**
 * This file contains price related functions
 */

if( !function_exists( 'inspiry_mortgage_calculator_amount' ) ) :
	/**
	 * Function to pass property price value to mortgage calculator
	 */
    function inspiry_mortgage_calculator_amount( $mortgage_amount ) {
        if ( is_singular( 'property' ) ) {
	        $price_digits = doubleval( get_post_meta( get_the_ID(), 'REAL_HOMES_property_price', true ) ); // get property price
	        if ( $price_digits ) {
		        return $price_digits;
	        }
        }
	    return $mortgage_amount;
    }
	add_filter( 'mc_total_amount', 'inspiry_mortgage_calculator_amount' );
endif;
