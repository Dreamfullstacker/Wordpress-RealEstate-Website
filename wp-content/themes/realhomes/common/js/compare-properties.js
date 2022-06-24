(function ($) {
    "use strict";

    $(document).ready(function () {

		/*-----------------------------------------------------------------------------------*/
		/* Render the added properties to compare data after page load.
		/*-----------------------------------------------------------------------------------*/
		render_compare_properties_data();

		/*-----------------------------------------------------------------------------------*/
		/* Toggle the compare properties tray and its button.
		/*-----------------------------------------------------------------------------------*/
		$('html').on('click', '.rh_floating_compare_button', function (e) {
			$('.rh_wrapper_properties_compare').toggleClass('rh_compare_open');
			$('.rh_fixed_side_bar_compare').fadeToggle(200);
			e.stopPropagation();
		});

		/*-----------------------------------------------------------------------------------*/
		/* Add property to compare.
		/*-----------------------------------------------------------------------------------*/
        $('body').on('click', 'a.rh_trigger_compare', function (event) {
            event.preventDefault();

			// Prepare property data that has to be added.
			var compare_link = $(this); // Add to compare button.
			var property_id = compare_link.parent().data('property-id');

			if(undefined === property_id) {return;} // Do nothing if property ID is not defined.

			var property_img = compare_link.parent().data('property-image');
			var property_url = compare_link.parent().data('property-url');
			var property_title = compare_link.parent().data('property-title');

			add_to_compare_btn_placeholder(property_id, true); // Highlight the add to compare button.
			apply_compare_properties_limit(); // Apply properties compare limit.
			add_property_to_compare_tray(property_id, property_title, property_img, property_url); // Add property card to the compare tray.
			add_property_to_localStorage(property_id, property_title, property_img, property_url); // Add property to localStorage.
			update_compare_button_url(); // Update compare properties button url.
			update_compare_tray_counter(); // Update compare properties tray counter with number of properties avilable to compare.
			control_compare_tray_display(); // Control the properties compare tray display.
		});
		
		/*-----------------------------------------------------------------------------------*/
		/* Remove property from compare.
		/*-----------------------------------------------------------------------------------*/
        $('body').on('click', 'a.rh_compare__remove', function (event) {
			event.preventDefault();
			
			// Prepare property data that has to be removed.
			var compare_link = $(this); // Add to compare button.
			var property_id = parseInt(compare_link.data('property-id'));
			var property_card = compare_link.parents('.rh_compare__slide');

			add_to_compare_btn_placeholder(property_id, false); // Remove highlight of add to compare button.
			property_card.remove(); // Remove property card from compare tray.
			remove_property_from_localStorage(property_id); // Remove property from localStorage.
			update_compare_button_url(); // Update compare properties button url.
			update_compare_tray_counter(); // Update compare properties tray counter with number of properties avilable to compare.
			control_compare_tray_display(); // Control the properties compare tray display.
		});
		
        // Render compare properties data on page load.
		function render_compare_properties_data(){

			var properties_string = window.localStorage.getItem('inspiry_compare'); // Get compare properties data from localStorage.
			if(null != properties_string){
				var properties_array_string = properties_string.split('||');
				if(Array.isArray(properties_array_string) && properties_array_string.length && properties_array_string[0] !== ''){

					// Build array of array from array of strings.
					var properties_array = [];
					properties_array_string.forEach(function(property){
						properties_array.push(JSON.parse(property));
					});
	
					properties_array.forEach(function(property){
						add_to_compare_btn_placeholder(property.property_id, true); // Highlight the add to compare button.
						add_property_to_compare_tray(property.property_id, property.property_title, property.property_img, property.property_url); // Add property card to the compare tray.
					});
	
					update_compare_tray_counter(); // Update compare properties tray counter with number of properties avilable to compare.
					control_compare_tray_display(); // Control the properties compare tray display.
					update_compare_button_url(); // Update compare properties button url.
				}
			}
		}
				
		// Control compare tray display.
		function control_compare_tray_display() {
			var compare_properties_number = $('.rh_compare .rh_compare__carousel > div').length;
			if (compare_properties_number !== 0) {
				$('.rh_wrapper_properties_compare').addClass('rh_has_compare_children'); // Show the compare tray button.
			} else {
				$('.rh_wrapper_properties_compare').removeClass('rh_compare_open'); // Remove active color of compare tray button.
				$('.rh_wrapper_properties_compare').removeClass('rh_has_compare_children'); // Hide compare tray button.
				$('.rh_fixed_side_bar_compare').fadeOut(0); // Hide compare tray.
			}
		}		

		// Update compare properties count in compare tray.
		function update_compare_tray_counter() {
			$('.rh_compare_count').fadeOut(200, function () {
				var getDivCount = $('body .rh_compare .rh_compare__carousel > div').length;
				$('.rh_wrapper_properties_compare .rh_compare_count').html(' ( ' + getDivCount + '/4 ) ');
			});
			$('.rh_compare_count').fadeIn(200);
		}

		function add_to_compare_btn_placeholder(property_id,placeholder){
			// Highlight the add to compare button.
			if(placeholder){
				$('.compare-btn-'+property_id).find('.compare-placeholder').removeClass('hide');
				$('.compare-btn-'+property_id).find('a.rh_trigger_compare').addClass('hide');
			} else {
				$('.compare-btn-'+property_id).find('.compare-placeholder').addClass('hide');
				$('.compare-btn-'+property_id).find('a.rh_trigger_compare').removeClass('hide');
			}
		}

		// Compare limit for exceeding more than four properties in compare.
		function apply_compare_properties_limit() {
			// Remove the oldest property from the list if number of properties goes above four.
			var slides_number = $('.rh_compare__carousel .rh_compare__slide').length;
            if (slides_number >= 4) {
				$('.rh_compare__carousel .rh_compare__slide:nth-child(1) a.rh_compare__remove').trigger("click");
				var notification_bar = $('#rh_compare_action_notification');
				notification_bar.addClass('show');
				setTimeout(function () {
					notification_bar.removeClass('show');
				}, 6000);
			}
		}

		// Add property card to the properties compare tray.
		function add_property_to_compare_tray(property_id, property_title, property_img, property_url) {
			$('.rh_compare__carousel').append(
				'<div class="rh_compare__slide">' +
				'<div class="rh_compare__slide_img">' +
				'<div class="rh_compare_img_inner">' +
				'<a target="_blank" href="' + property_url + '"><img src="' + property_img + '" width="488" height="326" ></a>' +
				'<a class="rh_compare__remove" data-property-id=" ' + property_id + ' " href=" ' + property_url + ' " ><i class="fa"><svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24" style="fill:none;stroke-linejoin:round;stroke-width:2;stroke:currentColor">' +
				'<line x1="18" x2="6" y1="6" y2="18"/>' +
				'<line x1="6" x2="18" y1="6" y2="18"/>' +
				'</svg></i></a>' +
				'</div>' +
				'<a target="_blank" href="' + property_url + '" class="rh_compare_view_title">' + property_title + '</a>' +
				'</div>' +
				'</div>'
			);
		}

		// Add property to the localStorage.
		function add_property_to_localStorage(property_id, property_title, property_img, property_url){
				// Prepare property data object.
				var property_obj = {
					property_id,
					property_title,
					property_url,
					property_img
				};

				var new_property = JSON.stringify(property_obj);
	
				// Add property to the localStorage.
				var old_properties = window.localStorage.getItem('inspiry_compare'); // Get compare properties data from localStorage.
				if('' !== old_properties && null !== old_properties){
					window.localStorage.setItem('inspiry_compare', old_properties + '||' + new_property);
				} else {
					window.localStorage.setItem('inspiry_compare', new_property);
				}
		}

		// Remove property from localStorage.
		function remove_property_from_localStorage(property_id){

			var properties_array_string = window.localStorage.getItem('inspiry_compare').split('||'); // Get compare properties data from localStorage.

			// Build an array of array from array of strings.
			var properties_array = [];
			properties_array_string.forEach(function(property){
				properties_array.push(JSON.parse(property));
			});

			// Prepare properites array except property to remove.
			var properties_array_filtered = $.grep(properties_array, function(property){
				return property.property_id != property_id && property.property_id != undefined;
		   });

		   var properties_string = '';
		   properties_array_filtered.forEach(function(property){
			   if(properties_string !== '') {
				   properties_string += '||';
			   }
				properties_string += JSON.stringify(property);
		   });
		   window.localStorage.setItem('inspiry_compare', properties_string);
		}

		// Update compare properties button url with properties ids.
		function update_compare_button_url(){

			var compare_link = $('.rh_compare__submit');
			var compare_url_neat = compare_link.attr('href').split('?')[0];

			var properties_array_string = window.localStorage.getItem('inspiry_compare').split('||');
			if(Array.isArray(properties_array_string) && properties_array_string.length && properties_array_string[0] !== ''){

				var compare_url = new URL(compare_url_neat);
				var search_params = compare_url.searchParams;
				
				var properties_array = [];
				properties_array_string.forEach(function(property){
					properties_array.push(JSON.parse(property));
				});

				var property_ids = '';
				properties_array.forEach(function(property){
					if('' === property_ids) {
						property_ids = property.property_id;
					} else {
						property_ids += ',' + property.property_id;
					}
				});

				search_params.append('id', property_ids);
				compare_url.search = search_params.toString();
				var new_compare_url = compare_url.toString();
				compare_link.attr('href', new_compare_url);
			} else {
				compare_link.attr('href', compare_url_neat);
			}
		}
    });
})(jQuery);