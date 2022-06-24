/*-----------------------------------------------------------------------------------*/
/*	Admin side JS
 /*-----------------------------------------------------------------------------------*/
(function($) {
    "use strict";

	$(document).ready( function() {

		$(document).on( 'click', '.rh_update_notice .notice-dismiss', function () {
	        // Read the "data-notice" information to track which notice
	        // is being dismissed and send it via AJAX
	        var type = $( this ).closest( '.rh_update_notice' ).data( 'notice' );
	        // Make an AJAX call
	        // Since WP 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
	        $.ajax( ajaxurl, {
	            type: 'POST',
	            data: {
	              action: 'update_notice_handler',
	              type: type,
	            }
	        } );
	    } );

	} );
} ) ( jQuery );


