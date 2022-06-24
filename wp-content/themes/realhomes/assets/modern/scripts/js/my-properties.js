(function ($) {
	"use strict";

	$(document).ready(function () {

		$( '.delete' ).click( function( e ) {
			e.preventDefault();

			var link = $( this );
			var link_parent = link.parent();
			var confirm_span = link_parent.find( '.confirmation' );

			link.addClass( 'hide' );
			confirm_span.removeClass( 'hide' );

		} );

		$( '.cancel' ).click( function( e ) {
			e.preventDefault();

			var link = $( this );
			var link_wrap = link.parent();
			var link_parent = link.parents( '.rh_my-property__controls' );
			var link_delete = link_parent.find( '.delete' );

			link_wrap.addClass( 'hide' );
			link_delete.removeClass( 'hide' );

		} );

		/*-----------------------------------------------------------------------------------*/
		/* Remove my property
		 /*-----------------------------------------------------------------------------------*/
		$('a.remove-my-property').on('click', function (event) {
			event.preventDefault();
			var $this = $(this);
			var property_item = $this.closest('.rh_my-property');
			var loader = $this.find('.loader');
			var remover = $this.find('.remove');
			var ajax_response = property_item.find('.ajax-response');

			remover.hide();
			loader.css('display','inline-block');
			$this.css( 'cursor', 'default' );

			var remove_property_request = $.ajax({
				url: $this.attr('href'),
				type: "POST",
				data: {
					property_id: $this.data('property-id'),
					action: "remove_my_property"
				},
				dataType: "json"
			});

			remove_property_request.done(function (response) {
				loader.hide();
				if (response.success) {
					property_item.remove();
				} else {
					remover.show();
					$this.css( 'cursor', 'pointer' );
					ajax_response.text(response.message);
				}
			});

			remove_property_request.fail(function (jqXHR, textStatus) {
				loader.hide();
				remover.show();
				$this.css( 'cursor', 'pointer' );
				ajax_response.text("Request Failed: " + textStatus);
			});
		});


	});

})(jQuery);
