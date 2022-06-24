(function($){
	"use strict"
	$(document).ready(function(){

		// Enable or disable recurring option based on the payments gateway type
		let payment_gateway = $('select[id="ims_basic_settings[ims_payment_method]"]');
		control_recurring_option();
		payment_gateway.on('change', function(){
			control_recurring_option();
		});

		function control_recurring_option(){
			let recurring_option = $('input[name="ims_basic_settings[ims_recurring_memberships_enable]"]');
			
			if('woocommerce'===payment_gateway.val()){
				recurring_option.prop('checked', false);
				recurring_option.attr('disabled', 'disabled');
			} else {
				recurring_option.removeAttr('disabled');
			}
		}
	});
})(jQuery);