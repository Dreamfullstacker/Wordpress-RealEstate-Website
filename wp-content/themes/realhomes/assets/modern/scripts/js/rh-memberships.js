/**
 * Membership Template
 */
( function( $ ) {

	"use strict";

	$( document ).ready( function() {

		$( '#ims-btn-confirm' ).text( rh_memberships.cancel_membership );

        // Recurring Membership Checkbox
        var recurring_input = $( '#ims_recurring' );

        var recurring_label = $( '#ims_recurring_label' );
        var recurring_text = recurring_label.text();
        recurring_label.empty();
        recurring_label.addClass( 'rh_checkbox' );

        var select_label = jQuery( '<span></span>' );
        select_label.text( recurring_text );
        select_label.addClass( 'rh_checkbox__title' );

        var select_span = jQuery( '<span></span>' );
        select_span.addClass( 'rh_checkbox__indicator' );
        recurring_label.append( select_label );
        recurring_input.appendTo( recurring_label );
        recurring_label.append( select_span );

        // Stripe Button
        $( '#ims-stripe' ).addClass( 'rh_btn rh_btn--primary' );

        // Wire Transfer
        var wire_wrap = $( '.ims-wire-transfer' );
        var wire_title = wire_wrap.find( 'h4' );
        var wire_nonce = wire_wrap.find( '#membership_wire_nonce' );

        var wire_details_before = jQuery( '<div></div>' );
        wire_details_before.addClass( 'wire-details-before' );

        var wire_details_after = jQuery( '<div></div>' );
        wire_details_after.addClass( 'wire-details-after' );

        wire_details_before.insertAfter( wire_title );
        wire_details_after.insertBefore( wire_nonce );

	} );

} )( jQuery );
