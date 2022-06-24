(function ($, settings) {
	"use strict";
	
	/**
	 * Energy Performance Certificate fields management.
	 */
	var epc_classes_settings = $('.energy-classes-settings'); // EPC settings wrapper.

	if(epc_classes_settings){

		// Sortable classes fields & their container.
		var container = $('.epc-classes-sortable');
		var epc_classes = container.find('.epc-class');

		set_dragging_effect(epc_classes); // Set dragging effect on EPC classes fields.
		set_removing_action(container);   // Make EPC fields removable.

		// Handling EPC class dragging field drop in its container.
		container.on('dragover', function(event){
			event.preventDefault();

			var getDropBeforeField = getDropBeforeClass( container, event.clientY );
			var dragging = $('.epc-class.dragging');

			if ( getDropBeforeField == undefined ) {
				$(this).append(dragging);
			} else {
				dragging.insertBefore(getDropBeforeField);
			}
		});
		
		// Prevent default behaviour of EPC classes fields reordering Handle.
		var reorder_handle = epc_classes.find('.reorder-epc-class');
		reorder_handle.each(function(){
			$(this).on('click', function(event){
				event.preventDefault();
			});
		});

		// Apply color picker to the class color fields.
        if (typeof $.fn.wpColorPicker === 'function') {
            $('.epc-class.draggable .class-color').wpColorPicker();
        }
        
		// Adding more epc classes.
		var epc_add_class = epc_classes_settings.find('.add-epc-class');
		epc_add_class.on('click', function(e){
			e.preventDefault();
			var epc_classes = container.find('.epc-class'); // Get updated classes list.
			$('.epc-classes-sortable').append(
				`
				<tr class="epc-class draggable">
					<td>
						<a class="reorder-epc-class" draggable="true"></a>
						<input type="text" class="class-name" name="inspiry_property_energy_classes[${epc_classes.length}][name]" value="">
					</td>
					<td>
						<input type="text" class="class-color" name="inspiry_property_energy_classes[${epc_classes.length}][color]" value="#1ea69a">
						<a class="remove-epc-class" href="#"><span class="dashicons dashicons-dismiss"></span></a>
					</td>
				</tr>
				`
			);
			
			// Apply effect and action to the recently updated EPC fields.
			$('.epc-class.draggable .class-color').wpColorPicker();
			var epc_classes_updated = container.find('.epc-class');
			set_dragging_effect(epc_classes_updated);
			set_removing_action(container);
		});

		// Make container inner draggable fields removable.
		function set_removing_action(container){
			var epc_remove_class = container.find('.remove-epc-class');
			epc_remove_class.each(function(index){
				$(this).on('click', function(e){
					e.preventDefault();
					$(this).closest('tr.epc-class').remove();
				});
			});
		}

		// Set dragging effect to the EPC classes fields.
		function set_dragging_effect(epc_classes){
			epc_classes.each(function(){
				$(this).on('dragstart', function(e){
					if( $(e.target).hasClass('reorder-epc-class') ) {
						$(this).addClass('dragging');
						e.originalEvent.dataTransfer.setDragImage(this, 8, 25);
					}
				});
	
				$(this).on('dragend', function(){
					$(this).removeClass('dragging');
				});
			});
		}

		// Return field to drop dragging field before.
		function getDropBeforeClass(container, y) {

			var draggableClasses = [...container.find('.epc-class.draggable:not(.dragging)')];

			return draggableClasses.reduce(function(closest, child){
				var box = child.getBoundingClientRect();
				var offset = y - box.top - box.height / 2;

				if( offset < 0 && offset > -120) {
					return {offset: offset, element: child};
				} 
				else {
					return closest;
				}

			}, {offset: Number.NEGATIVE_INFINITY}).element;
		}

	}


	 /**
	  * Inspiry Plugins
	  */
    var inspiryPlugin = {
        ajaxNonce: settings.ajax_nonce,
        l10n: settings.l10n,
        installArgs: function () {
            return {
                label: this.l10n.activateNow,
                updateMessage: this.l10n.installing,
                successMessage: this.l10n.installed,
                removeClass: 'install-now',
                addClass: 'activate-now',
            };
        },
        activateArgs: function () {
            return {
                label: this.l10n.active,
                updateMessage: this.l10n.activating,
                successMessage: this.l10n.activated,
                removeClass: 'activate-now',
                addClass: 'button-disabled',
            };
        },
        ajax: function (button, args) {
            var originalText = button.text(),
                failed = this.l10n.failed;

            $.ajax({
                type: "post",
                dataType: "json",
                url: ajaxurl,
                data: args.data,
                beforeSend: function () {
                    button.addClass('updating-message');
                    if (args.updateMessage) {
                        button.text(args.updateMessage);
                    }
                },
                success: function (response) {
                    button.removeClass('updating-message');
                    if (response.success) {
                        button.text(args.successMessage).addClass('updated-message');
                        setTimeout(function () {
                            button.removeClass('updated-message');
                            button.text(args.label).addClass(args.addClass).removeClass(args.removeClass);
                        }, 1000);
                    } else {
                        button.text(failed);
                        setTimeout(function () {
                            button.text(originalText);
                        }, 1000);
                    }
                }
            });
        },
        install: function (button) {
            var args = this.installArgs();

            args.data = {
                action: 'inspiry_install_plugin',
                slug: button.data('slug'),
                plugin: button.data('plugin'),
                source: button.data('source'),
                _ajax_nonce: this.ajaxNonce,
            };

            this.ajax(button, args);
        },
        activate: function (button) {
            var args = this.activateArgs();

            args.data = {
                action: 'inspiry_activate_plugin',
                slug: button.data('slug'),
                plugin: button.data('plugin'),
                _ajax_nonce: this.ajaxNonce,
            };

            this.ajax(button, args);
        }
    };

    $(document).ready(function () {
        var $inspiryPluginCards = $(".inspiry-plugin-card-wrapper"),
            $inspiryPluginFilter = $("#inspiry-plugin-filter");

        /**
         * Click handler for plugin install and activation.
         */
        $inspiryPluginCards.on('click', '.button', function (event) {
            var $button = $(this);

            if (!$button.hasClass('download-link')) {
                event.preventDefault();
            }

            if ($button.hasClass('download-link') || $button.hasClass('updating-message') || $button.hasClass('button-disabled')) {
                return;
            }

            if ($button.hasClass('install-now')) {
                inspiryPlugin.install($button);
            } else if ($button.hasClass('activate-now')) {
                inspiryPlugin.activate($button);
            }
        });

        /**
         * Realhomes plugin filters
         */
        $inspiryPluginFilter.on('click', 'a', function (event) {
            event.preventDefault();

            var $this = $(this),
                $filter = $this.data('filter');

            $inspiryPluginFilter.find('a').removeClass('active');
            $this.addClass('active');
            $inspiryPluginCards.hide();
            $inspiryPluginCards.filter($filter).show();
        });

        /**
         * Feedback from validation and ajax request
         */
        $("#inspiry-feedback-form").on('click', '.button', function (event) {
            event.preventDefault();
            var $response_msg = $("#inspiry-feedback-form-success"),
                $error_msg = $("#inspiry-feedback-form-error"),
                $email = $("#inspiry-feedback-form-email").val(),
                $feedback = $("#inspiry-feedback-form-textarea").val(),
                data = {
                    action: 'inspiry_send_feedback',
                    inspiry_feedback_form_nonce: $("#inspiry_feedback_form_nonce").val(),
                },
                clear = function () {
                    setTimeout(function () {
                        $response_msg.html('');
                        $error_msg.html('');
                    }, '3000');
                };

            $response_msg.html('');
            $error_msg.html('');

            if ($email) {
                data.inspiry_feedback_form_email = $email;

                if ($feedback) {
                    data.inspiry_feedback_form_textarea = $feedback;
                } else {
                    $error_msg.html('Please add your feedback before send.');
                }
            } else {
                $error_msg.html('Please provide a valid email address.');
            }

            if ($email && $feedback) {
                $.post(ajaxurl, data, function (response) {
                    if (response.success) {
                        document.getElementById("inspiry-feedback-form").reset();
                        $response_msg.html(response.message);
                    } else {
                        $error_msg.html(response.message);
                    }
                    clear();
                }, 'json');
            }
        });
    });
})(jQuery, window.inspiryPluginsSettings);