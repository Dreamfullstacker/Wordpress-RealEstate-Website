(function ($) {
    "use strict";

	/**
	 * Initializes the similar properties filters.
	 *
	 * @since 3.13
	 */
	function similarPropertiesFilters() {
		const similarPropertiesFiltersWrap = $('#similar-properties-filters-wrapper');

		if (similarPropertiesFiltersWrap.length) {
			const similarPropertiesFilters = similarPropertiesFiltersWrap.find('a');
			const similarProperties = $('#similar-properties');
			const similarPropertiesHtml = similarProperties.html();

			// Check for localized similar properties data
			if (typeof similarPropertiesData !== "undefined") {

				const design = similarPropertiesData.design;
				let buttonClass = 'rh-btn rh-btn-primary';
				let buttonClassCurrent = 'rh-btn rh-btn-secondary';

				if ('classic' === design) {
					buttonClass = '';
					buttonClassCurrent = 'current';
				}

				similarPropertiesFiltersWrap.on('click', 'a', function (event) {
					const self = $(this);
					const propertyFilter = self.data('similar-properties-filter');

					similarPropertiesFilters.removeClass(buttonClassCurrent).addClass(buttonClass);
					self.removeClass(buttonClass).addClass(buttonClassCurrent);

					if ('recommended' === propertyFilter) {
						similarProperties.html(similarPropertiesHtml);
					} else {
						$.ajax({
							url: ajaxurl,
							type: 'post',
							dataType: 'html',
							data: {
								action: 'realhomes_filter_similar_properties',
								property_id: similarPropertiesData.propertyId,
								properties_per_page: similarPropertiesData.propertiesPerPage,
								property_filter: propertyFilter,
								design: design
							},
							success: function (response) {
								similarProperties.html(response);
							}
						});
					}

					event.preventDefault();
				});
			} else {
				// Hide filters when no data available
				similarPropertiesFiltersWrap.hide();
			}
		}
	}




	/**
	 * Adds css class in body to stack the floating features div if the property agent sticky bar exists in DOM.
	 *
	 * @since 3.14
	 */
	function agentStickyBarHandler() {
		const agentStickyBar = $('#property-agent-contact-methods-wrapper');

		if (767 > $(window).width() && agentStickyBar.length ) {
			$('body').addClass('has-agent-sticky-bar');
		}
	}

    $(document).ready(function () {

		var $window = $(window),
			$body = $('body'),
			isRtl = $body.hasClass('rtl');

		similarPropertiesFilters();
		agentStickyBarHandler();

		// TODO: need to find a way to run this code only on property single page.
		$window.on('resize', function () {
			agentStickyBarHandler();
		});

        // Stop propagation of click event on favorites button when user is not logged in.
        $('.add-favorites-without-login').on('click', function (event) {
			event.stopPropagation();
		});

		/*-----------------------------------------------------------------*/
        /* Save Searches for Email Alerts
        /*-----------------------------------------------------------------*/
		$('#rh_save_search_btn').on('click', function(e){

			e.preventDefault();
			let button = $(this);
			let $form  = button.closest('form');
			let searchArguments = $form.find('.rh_wp_query_args').val();
			let searchURL = $form.find('.rh_url_query_str').val();
			let icon = button.find('i');
			let savedLabel = button.data('saved-label');

			icon.addClass('fa-spin');

			if(button.hasClass('require-login')){

				// Prepare new alert object to store in local storage.
				let currentTime = $form.find('.rh_current_time').val();
				let newSavedSearch = {
					'wp_query_args': searchArguments,
					'query_str': searchURL,
					'time': currentTime
				};

				// Add new alert to the local storage.
				var oldSavedSearches = window.localStorage.getItem('realhomes_saved_searches');
				if(oldSavedSearches){
					allSavedSearches = JSON.parse(oldSavedSearches);
					allSavedSearches.push(newSavedSearch);
					window.localStorage.setItem('realhomes_saved_searches', JSON.stringify(allSavedSearches));
				} else {
					window.localStorage.setItem('realhomes_saved_searches', JSON.stringify([newSavedSearch]));
				}

				// Update the save alert button.
				button.addClass('search-saved');
				icon.removeClass('fa-spin');
				button.html('<i class="far fa-bell"></i>' + savedLabel);

				// Open the login/register dialoage box.
				var loginModel = $('body').find('.rh_login_modal_wrapper');
				if (loginModel.length) {
					$('.rh_login_modal_wrapper').css("display", "flex").hide().fadeIn(500);
				} else {
					window.location = button.data('login');
				}
			} else {
				let nonce = $form.find('.rh_save_search_nonce').val();
				$.post(ajaxurl,{
						nonce: nonce,
						action: 'inspiry_save_search',
						search_args: searchArguments,
						search_url: searchURL,
					},
					function(response) {
						response = JSON.parse(response);
						if(response.success){
							// Update the save search button.
							button.addClass('search-saved');
							icon.removeClass('fa-spin');
							button.html('<i class="far fa-bell"></i>' + savedLabel);
						}
					}
				);
			}
		});

		/**
		 * Migrate saved searches from local to server.
		 */
		var allSavedSearches = JSON.parse(window.localStorage.getItem('realhomes_saved_searches'));
		if(allSavedSearches && $('body').hasClass('logged-in')){
			var migrateSavedSearches = {
				type : 'post',
				url : ajaxurl,
				data : {
					action: 'realhomes_saved_searches_migration',
					saved_searches : allSavedSearches,
				},
				success: function(response) {
					if ('true' === response) {
						// Clear all saved searches from local storage.
						window.localStorage.removeItem('realhomes_saved_searches');
					}
				}
			};
			$.ajax(migrateSavedSearches);
		}


		/*-----------------------------------------------------------------*/
        /* Mortgage Calculator
        /*-----------------------------------------------------------------*/
		if( $('.rh_property__mc_wrap').length ) {

			let mc_reassign_fields = function($this = null) {
				if ( 'object' === typeof $this && typeof $this.closest( '.rh_property__mc' ) ) {
					$this = $this.closest( '.rh_property__mc' );
					mcState.fields = {
						'term': $this.find('select.mc_term'),
						'interest_text': $this.find('.mc_interset'),
						'interest_slider': $this.find('.mc_interset_slider'),
						'price_text': $this.find('.mc_home_price'),
						'price_slider': $this.find('.mc_home_price_slider'),
						'downpayment_text': $this.find('.mc_downpayment'),
						'downpayment_text_p': $this.find('.mc_downpayment_percent'),
						'downpayment_slider': $this.find('.mc_downpayment_slider'),
						'tax': $this.find('.mc_cost_tax_value'),
						'hoa': $this.find('.mc_cost_hoa_value'),
						'currency_sign': $this.find('.mc_currency_sign'),
						'sign_position': $this.find('.mc_sign_position'),
						'info_term': $this.find('.mc_term_value'),
						'info_interest': $this.find('.mc_interest_value'),
						'info_cost_interst': $this.find('.mc_cost_interest span'),
						'info_cost_total': $this.find('.mc_cost_total span'),
						'graph_interest': $this.find('.mc_graph_interest'),
						'graph_tax': $this.find('.mc_graph_tax'),
						'graph_hoa': $this.find('.mc_graph_hoa'),
					}

					if ( $('.mc_cost_over_graph').length > 0 ) {
						mcState.fields.info_cost_total = $this.find('.mc_cost_over_graph');
					}
				}
			}

			let mc_only_numeric = function(data){
				if('string' === typeof data) {
					return (data.replace(/[^0-9-.]/g,'')).replace(/^\./, ''); // leave only numeric value.
				}
				return data;
			}

			let mc_input_focus = function(){
				$(this).val( mc_only_numeric( $(this).val() ) ); // leave only numeric value.
			}

			let mc_input_blur = function(){
				// percentage value.
				mcState.fields.interest_text.val( mc_only_numeric( mcState.fields.interest_text.val() ) + '%');
				mcState.fields.downpayment_text_p.val( mc_only_numeric( mcState.fields.downpayment_text_p.val() ) + '%');

				// formatted amount value.
				mcState.fields.price_text.val(mc_format_amount( mcState.fields.price_text.val()));
				mcState.fields.downpayment_text.val(mc_format_amount(mcState.fields.downpayment_text.val()));
			}

			let mc_format_amount = function(amount) {
				if( 'after' === mcState.values.sign_position ){
					return new Intl.NumberFormat('en-us').format( mc_only_numeric( amount ) ) + mcState.values.currency_sign;
				}
				return mcState.values.currency_sign + new Intl.NumberFormat('en-us').format( mc_only_numeric( amount ) );
			}

			let mc_update_fields_values = function(){

				const $this = $(this);
				mc_reassign_fields($this);
				mcState.values = mc_get_input_values(); // get all input values to be used for the calculation.

				if( 'range' === $this.attr('type') ) {

					if($this.hasClass('mc_interset_slider')) { // Interest slider changed.

						mcState.fields.interest_text.val($this.val() + '%'); // update interest percentage text field value.

					} else if ($this.hasClass('mc_home_price_slider')) { // Price slider changed.

						mcState.fields.price_text.val(mc_format_amount($this.val())); // update price text field value.

						// update downpayment amount text field value according to the selected percentage.
						let home_price = $this.val();
						let dp_percent = mcState.values.downpayment_percent;
						let downpayment = Math.round((home_price * dp_percent) / 100);

						mcState.fields.downpayment_text.val(mc_format_amount(downpayment));

					} else if ($this.hasClass('mc_downpayment_slider')) { // Downpayment slider.

						mcState.fields.downpayment_text_p.val($this.val() + '%');

						let home_price = mcState.values.price;
						let dp_percent = $this.val();
						let downpayment = Math.round((home_price * dp_percent) / 100);

						mcState.fields.downpayment_text.val(mc_format_amount(downpayment));
					}
				} else if( 'text' === $this.attr('type') ) {

					if($this.hasClass('mc_interset')) {

						mcState.fields.interest_slider.val( mcState.values.interest );

					} else if ($this.hasClass('mc_home_price')) {

						mcState.fields.price_slider.val( mcState.values.price );

						let home_price = mcState.values.price;
						let dp_percent = mcState.values.downpayment_percent;
						let downpayment = Math.round(( home_price * dp_percent ) / 100);

						mcState.fields.downpayment_text.val(mc_format_amount(downpayment));

					} else if ($this.hasClass('mc_downpayment_percent')) {

						mcState.fields.downpayment_slider.val( mcState.values.downpayment_percent );

						let home_price = mcState.values.price;
						let dp_percent = mcState.values.downpayment_percent;
						let downpayment = ( home_price * dp_percent ) / 100;

						mcState.fields.downpayment_text.val(mc_format_amount(downpayment));

					} else if ($this.hasClass('mc_downpayment')) {

						let home_price = mcState.values.price;
						let downpayment = mcState.values.downpayment;

						let price = ( home_price < downpayment ) ? downpayment : home_price;
						let dp_percent = ((downpayment * 100) / price).toFixed(2).replace(/[.,]00$/, "");

						mcState.fields.downpayment_text_p.val(dp_percent + '%');
						mcState.fields.downpayment_slider.val(dp_percent);

					}
				}

				mc_calculate();
			}

			let mc_get_input_values = function(){
				let interest = mc_only_numeric( mcState.fields.interest_text.val() );
				let price = mc_only_numeric( mcState.fields.price_text.val() );
				let downpayment = mc_only_numeric( mcState.fields.downpayment_text.val() );
				let downpayment_percent = mc_only_numeric( mcState.fields.downpayment_text_p.val() );
				let tax = mc_only_numeric( mcState.fields.tax.val() );
				let hoa = mc_only_numeric( mcState.fields.hoa.val() );
				let currency_sign = mcState.fields.currency_sign.val();
				let sign_position = mcState.fields.sign_position.val();

				let mcInputVals = {
					term: parseInt(mcState.fields.term.val()),
					interest: ('' === interest.replace('-', '')) ? 0 : parseFloat(interest),
					price: ('' === price.replace('-', '')) ? 0 : parseFloat(price),
					downpayment: ( '' === downpayment.replace('-', '') ) ? 0 : parseFloat(downpayment),
					downpayment_percent: ( '' === downpayment_percent.replace('-', '') ) ? 0 : parseFloat(downpayment_percent),
					tax: ('' === tax.replace('-', '')) ? 0 : parseFloat(tax),
					hoa: ('' === hoa.replace('-', '')) ? 0 : parseFloat(hoa),
					currency_sign: ('' === currency_sign) ? '$' : currency_sign,
					sign_position: ('' === sign_position) ? 'before' : sign_position,
				};

				return mcInputVals;
			}

			let mc_get_principle_interest = function(){

				let home_price = parseFloat(mcState.values.price);
				let downpayment = parseFloat(mcState.values.downpayment);
				let loanBorrow = home_price - downpayment;
				let totalTerms = 12 * mcState.values.term;

				if ( 0 === parseInt( mcState.values.interest ) ) {
					return loanBorrow / totalTerms;
				}

				let interestRate = parseFloat(mcState.values.interest) / 1200;
				return Math.round(loanBorrow * interestRate / (1 - (Math.pow(1/(1 + interestRate), totalTerms))));
			}

			let mc_get_payment_per_month = function(){

				let principal_interest = parseFloat(mcState.princial_interest);
				let property_tax = parseFloat(mcState.values.tax);
				let hoa_dues = parseFloat(mcState.values.hoa);

				return Math.round(principal_interest + property_tax + hoa_dues);
			}

			let mc_get_data_percentage = function(){

				let principal_interest = mcState.princial_interest;
				let property_tax = mcState.values.tax;
				let hoa_dues = mcState.values.hoa;

				let p_i = (principal_interest*100)/mcState.payment_per_month;
				let tax = (property_tax*100)/mcState.payment_per_month;
				let hoa = (hoa_dues*100)/mcState.payment_per_month;

				let data_percentage = {
					p_i,
					tax,
					hoa
				};

				return data_percentage;
			}

			let mc_render_information = function(){

				// Update calculated information.
				mcState.fields.info_term.text(mcState.values.term);
				mcState.fields.info_interest.text(mcState.values.interest);
				mcState.fields.info_cost_interst.text(mc_format_amount(Math.round(mcState.princial_interest)));

				if ( $('.mc_cost_over_graph').length > 0 ) {

					// Update circle graph and total cost.
					let cost_prefix = mcState.fields.info_cost_total.attr('data-cost-prefix');
					mcState.fields.info_cost_total.html('<strong>' + mc_format_amount(mcState.payment_per_month) + '</strong>' + cost_prefix);

					var $circle = mcState.fields.graph_interest;
					var circle_pct = mcState.percentage.p_i;
					var r = $circle.attr('r');
					var c = Math.PI*(r*2);
					if (circle_pct < 0) { circle_pct = 0;}
					if (circle_pct > 100) { circle_pct = 100;}
					var pct = ((100-circle_pct)/100)*c;
					$circle.css({ strokeDashoffset: pct});

					var $circle = mcState.fields.graph_tax;
					var circle_pct = mcState.percentage.tax + mcState.percentage.p_i;
					var r = $circle.attr('r');
					var c = Math.PI*(r*2);
					if (circle_pct < 0) { circle_pct = 0;}
					if (circle_pct > 100) { circle_pct = 100;}
					var pct = ((100-circle_pct)/100)*c;
					$circle.css({ strokeDashoffset: pct});

					var $circle = mcState.fields.graph_hoa;
					var circle_pct = mcState.percentage.hoa + mcState.percentage.tax + mcState.percentage.p_i;
					var r = $circle.attr('r');
					var c = Math.PI*(r*2);
					if (circle_pct < 0) { circle_pct = 0;}
					if (circle_pct > 100) { circle_pct = 100;}
					var pct = ((100-circle_pct)/100)*c;
					$circle.css({ strokeDashoffset: pct});

				} else {
					// Update bar graph and total cost.
					mcState.fields.info_cost_total.text(mc_format_amount(mcState.payment_per_month));
					mcState.fields.graph_interest.css( 'width', (mcState.percentage.p_i) + '%');
					mcState.fields.graph_tax.css( 'width', (mcState.percentage.tax) + '%');
					mcState.fields.graph_hoa.css( 'width', (mcState.percentage.hoa) + '%');
				}

			}

			let mc_calculate = function(){
				mcState.values = mc_get_input_values(); // get all input vaues to be used for the calculation.
				mcState.princial_interest = mc_get_principle_interest(); // caclcualte and get the principle and interest amount.
				mcState.payment_per_month = mc_get_payment_per_month(); // calculate and get the per month payment to be paid.
				mcState.percentage = mc_get_data_percentage(); // calculate and get the percentages of the data for the graph display.
				mc_render_information(); // Display the information on frontend side.
			}

			const mcState = {};
			mcState.fields = {
				'term': $('select.mc_term'),
				'interest_text': $('.mc_interset'),
				'interest_slider': $('.mc_interset_slider'),
				'price_text': $('.mc_home_price'),
				'price_slider': $('.mc_home_price_slider'),
				'downpayment_text': $('.mc_downpayment'),
				'downpayment_text_p': $('.mc_downpayment_percent'),
				'downpayment_slider': $('.mc_downpayment_slider'),
				'tax': $('.mc_cost_tax_value'),
				'hoa': $('.mc_cost_hoa_value'),
				'currency_sign': $('.mc_currency_sign'),
				'sign_position': $('.mc_sign_position'),
				'info_term': $('.mc_term_value'),
				'info_interest': $('.mc_interest_value'),
				'info_cost_interst': $('.mc_cost_interest span'),
				'info_cost_total': $('.mc_cost_total span'),
				'graph_interest': $('.mc_graph_interest'),
				'graph_tax': $('.mc_graph_tax'),
				'graph_hoa': $('.mc_graph_hoa'),
			}

			if ( $('.mc_cost_over_graph').length > 0 ) {
				mcState.fields.info_cost_total = $('.mc_cost_over_graph');
			}

			mc_calculate(); // Initiate Mortgage Calculator.
			mc_input_blur(); // Format the amounts in the text fields.

			// Apply calculation action on calculator values change.
			$('.rh_mc_field select, .rh_mc_field input[type=range]').on('change', mc_update_fields_values);
			$('.rh_mc_field input[type=range]').on('input', mc_update_fields_values);
			$('.rh_mc_field input[type=text]').on('keyup', mc_update_fields_values);

			// Add focus and blur actions on text input fields.
			$('.rh_mc_field input[type=text]').on('focus', mc_input_focus);
			$('.rh_mc_field input[type=text]').on('blur', mc_input_blur);
		}


		/*-----------------------------------------------------------------------------------*/
		/*	Language Switcher
		/*-----------------------------------------------------------------------------------*/
        $body.on('click','.inspiry-language',function (e) {
            if($('.inspiry-language-switcher').find('.rh_languages_available').children('.inspiry-language').length > 0){
                $('.rh_wrapper_language_switcher').toggleClass('parent_open');
                $(this).toggleClass('open');
                if($(this).hasClass('open')){
                    $('.rh_languages_available').fadeIn(200);
                }else{
                    $('.rh_languages_available').fadeOut(200);
                }
            }
            e.stopPropagation();
        });
        $('html').on('click',function () {
            $('.rh_wrapper_language_switcher').removeClass('parent_open');
            $('html .inspiry-language').removeClass('open');
            $('.rh_languages_available').fadeOut(200);
        });


        /*-----------------------------------------------------------------------------------*/
        /*	Partners Carousel
        /*-----------------------------------------------------------------------------------*/
        if (jQuery().owlCarousel) {
            $('.brands-owl-carousel').owlCarousel({
                nav: true,
                dots: false,
                navText: ['<i class="fas fa-caret-left"></i>', '<i class="fas fa-caret-right"></i>'],
                loop: true,
                autoplay: true,
                autoplayTimeout: 4500,
                autoplayHoverPause: true,
                margin: 0,
                rtl: isRtl,
                responsive: {
                    0: {
                        items: 1
                    },
                    480: {
                        items: 2
                    },
                    768: {
                        items: 3
                    },
                    992: {
                        items: 4
                    },
                    1199: {
                        items: 5
                    }
                }
            });
        }


        /*-----------------------------------------------------------------------------------*/
        /* Agent form's validation script for property detail page.
        /*-----------------------------------------------------------------------------------*/
		function inspiryValidateForm(form) {
			var $form = $(form),
				submitButton = $form.find('.submit-button'),
				ajaxLoader = $form.find('.ajax-loader'),
				messageContainer = $form.find('.message-container'),
				errorContainer = $form.find(".error-container"),
				formOptions = {
					beforeSubmit: function () {
						submitButton.attr('disabled', 'disabled');
						ajaxLoader.fadeIn('fast').css("display", "inline-block");
						messageContainer.fadeOut('fast');
						errorContainer.fadeOut('fast');
					},
					success: function (ajax_response, statusText, xhr, $form) {
						var response = $.parseJSON(ajax_response);
						ajaxLoader.fadeOut('fast');
						submitButton.removeAttr('disabled');
						if (response.success) {
							$form.resetForm();
							messageContainer.html(response.message).fadeIn('fast');

							// call reset function if it exists
							if (typeof inspiryResetReCAPTCHA == 'function') {
								inspiryResetReCAPTCHA();
							}

							if (typeof agentData !== 'undefined') {
								setTimeout(function () {
									window.location.replace(agentData.redirectPageUrl);
								}, 1000);
							}else{
								setTimeout(function () {
									messageContainer.fadeOut('slow')
								},3000);
							}
						} else {
							errorContainer.html(response.message).fadeIn('fast');
						}
					}
				};

			$form.validate({
				errorLabelContainer: errorContainer,
				submitHandler: function (form) {
					$(form).ajaxSubmit(formOptions);
				}
			});
		}

		if (jQuery().validate && jQuery().ajaxSubmit) {
			if ($body.hasClass('single-property')) {
				var getAgentForms = $('.agent-form');
				if (getAgentForms.length) {
					$.each(getAgentForms, function (i, form) {
						var id = $(form).attr("id");
						inspiryValidateForm('#' + id);
					});
				}
			}
		}


        /*-----------------------------------------------------------------------------------*/
        /*	Login Required Function
        /*-----------------------------------------------------------------------------------*/
        $('body').on('click','.inspiry_submit_login_required',function (e) {
            e.preventDefault();
            $('.rh_login_modal_wrapper').css("display", "flex").hide().fadeIn(500);
        });


        /*-----------------------------------------------------------------------------------*/
        /*	BootStrap Select
        /*-----------------------------------------------------------------------------------*/
        var inspirySelectPicker = function (id) {
            if (jQuery().selectpicker) {
                jQuery(id).selectpicker({
                    iconBase: 'fas',
					width: "100%",
                    size: 5,
                    tickIcon: 'fa-check',
                    selectAllText: '<span class="inspiry_select_bs_buttons inspiry_bs_select">' +
						'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><polygon points="22.1 9 20.4 7.3 14.1 13.9 15.8 15.6 "/><polygon points="27.3 7.3 16 19.3 9.6 12.8 7.9 14.5 16 22.7 29 9 "/><polygon points="1 14.5 9.2 22.7 10.9 21 2.7 12.8 "/></svg>' +
						'</span>',
                    deselectAllText: '<span class="inspiry_select_bs_buttons inspiry_bs_deselect"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 30 30"><style type="text/css">  \n' +
                        '\t.rh-st0{fill:none;stroke:#000000;stroke-width:2;stroke-miterlimit:10;}\n' +
                        '</style><path class="inspiry_des rh-st0" d="M3.4 10.5H20c3.8 0 7 3.1 7 7v0c0 3.8-3.1 7-7 7h-6"/><polyline class="inspiry_des rh-st0" points="8.4 15.5 3.4 10.5 8.4 5.5 "/></svg></span>',

                });

				$(".rh_sort_controls .inspiry_select_picker_trigger").click(function (e) {

					if (!$(this).hasClass('open')){
						$(this).addClass('open');
						e.stopPropagation();
					}else{
						$(this).removeClass('open');
						e.stopPropagation();
					}
				});
            }
        };

		// TODO: This commented code should be removed if it is not needed.
        // if ($('.dsidx-resp-search-form')) {
        //     $('.dsidx-resp-search-form select').addClass('inspiry_select_picker_trigger inspiry_bs_default_mod  inspiry_bs_green show-tick');
		//
        //     if ($('.dsidx-sorting-control')) {
        //         $('.dsidx-sorting-control select').addClass('inspiry_select_picker_trigger inspiry_bs_default_mod  inspiry_bs_green show-tick');
        //     }
        //     if ($('#dsidx-search-form-main')) {
        //         $('#dsidx-search-form-main select').addClass('inspiry_select_picker_trigger inspiry_bs_default_mod  inspiry_bs_green show-tick');
        //     }
        //     if ($('#dsidx.dsidx-details')) {
        //         $('.dsidx-contact-form-schedule-date-row select').addClass('inspiry_select_picker_trigger inspiry_bs_default_mod  inspiry_bs_green show-tick');
        //     }
		//
        //     inspirySelectPicker('body .inspiry_select_picker_trigger');
        // }

        inspirySelectPicker('body .inspiry_select_picker_trigger');
        inspirySelectPicker('body .widget_categories select');
        inspirySelectPicker('body .widget_archive select');

		// TODO: Remove this if it is not required.
        // inspirySelectPicker('.inspiry_select_picker_mod');

        $(".inspiry_multi_select_picker_location").on('change', function (e, clickedIndex, isSelected, previousValue) {
        	setTimeout(function () {
                $('.inspiry_multi_select_picker_location').selectpicker('refresh');
            },500);
        });

        $(".inspiry_bs_submit_location").on('changed.bs.select', function () {
            $('.inspiry_bs_submit_location').selectpicker('refresh');
        });

        $(".inspiry_select_picker_status").on('changed.bs.select', function () {
            $('.inspiry_select_picker_price').selectpicker('refresh');
        });

        $('.inspiry_select_picker_trigger').on('show.bs.select', function () {
            $(this).parents('.rh_prop_search__option').addClass('inspiry_bs_is_open')
        });

        $('.inspiry_select_picker_trigger').on('hide.bs.select', function () {
            $(this).parents('.rh_prop_search__option').removeClass('inspiry_bs_is_open')
        });

        var locationSuccessList = function (data,thisParent,refreshList = false) {
        	if(true === refreshList){
            thisParent.find('option').not(':selected, .none').remove().end();
            }
            var getSelected = $(thisParent).val();
            jQuery.each(data, function (index, text) {
                if (getSelected) {
                    if (getSelected.indexOf(text[0]) < 0) {
                        thisParent.append(
                            $('<option value="' + text[0] + '">' + text[1] + '</option>')
                        );
                    }
                } else {
                    thisParent.append(
                        $('<option value="' + text[0] + '">' + text[1] + '</option>')
                    );
                }
            });
            thisParent.selectpicker('refresh');
            $(parent).find('ul.dropdown-menu li:first-of-type a').focus();
            $(parent).find('input').focus();
        };

        var loaderFadeIn =function () {
            $('.rh-location-ajax-loader').fadeIn('fast');
        };

        var loaderFadeOut =function () {
            $('.rh-location-ajax-loader').fadeOut('fast');
        };

        var rhTriggerAjaxOnLoad = function(thisParent,fieldValue = ''){
            $.ajax({
                url: localizeSelect.ajax_url,
                dataType: 'json',
                delay: 250, // delay in ms while typing when to perform a AJAX search
                data: {
                    action: 'inspiry_get_location_options', // AJAX action for admin-ajax.php
                    query: fieldValue,
					// TODO: review the commented code below and remove if it is not required.
                    // hideemptyfields: localizeSelect.hide_empty_locations,
                    // sortplpha: localizeSelect.sort_location,
                },
                beforeSend: loaderFadeIn(),
                success: function (data) {
                    loaderFadeOut();
                    locationSuccessList(data,thisParent,true);
                }
            });
		};

        var rhTriggerAjaxOnScroll = function(thisParent,farmControl,fieldValue = ''){
        	var paged = 2;
            farmControl.on('keyup', function (e) {
                paged = 2;
                 fieldValue = $(this).val();
            });

            $('div.inspiry_ajax_location_field div.inner').on('scroll', function () {
                        var thisInner = $(this);
                        var thisInnerHeight = thisInner.innerHeight();
                        var getScrollIndex = thisInner.scrollTop() + thisInnerHeight;
                if(getScrollIndex >= $(this)[0].scrollHeight) {
                    $.ajax({
                        url: localizeSelect.ajax_url,
                        dataType: 'json',
                        delay: 250, // delay in ms while typing when to perform a AJAX search
                        data: {
                            action: 'inspiry_get_location_options', // AJAX action for admin-ajax.php
                            query: fieldValue,
                            page: paged,
							// TODO: review the commented code below and remove if it is not required.
                            // hideemptyfields: localizeSelect.hide_empty_locations,
                            // sortplpha: localizeSelect.sort_location,
                        },
                        beforeSend: loaderFadeIn(),
                        success: function (data) {
                            loaderFadeOut();
                            if (!$.trim(data)){
                                $('.rh-location-ajax-loader').fadeTo( "fast" , 0);
                            }
                            paged++;
                            locationSuccessList(data, thisParent, false);
                        }
                    });
                }
            });
        };

        var inspiryAjaxSelect = function (parent, id) {
            var farmControl = $(parent).find('.form-control');
            var thisParent = $(id);
            rhTriggerAjaxOnScroll(thisParent,farmControl);
            rhTriggerAjaxOnLoad(thisParent);
            farmControl.on('keyup', function (e) {
                var fieldValue = $(this).val();
                fieldValue = fieldValue.trim();
                var wordcounts = jQuery.trim(fieldValue).length;
				// TODO: review the commented code below and remove if it is not required.
                // rhTriggerAjaxLoadMore(thisParent,fieldValue);
                $('.rh-location-ajax-loader').fadeTo( "fast" , 1);
                if (wordcounts > 0) {
                    $.ajax({
                        url: localizeSelect.ajax_url,
                        dataType: 'json',
                        delay: 250, // delay in ms while typing when to perform a AJAX search
                        data: {
                            action: 'inspiry_get_location_options', // AJAX action for admin-ajax.php
                            query: fieldValue,
							// TODO: review the commented code below and remove if it is not required.
                            // hideemptyfields: localizeSelect.hide_empty_locations,
                            // sortplpha: localizeSelect.sort_location,
                        },
                        beforeSend: loaderFadeIn(),
                        success: function (data) {
                            loaderFadeOut();
                            thisParent.find('option').not(':selected, .none').remove().end();
							// TODO: review the commented code below and remove if it is not required.
                            // var options = [];
                            if (fieldValue && data) {
                                locationSuccessList(data,thisParent);
                            } else {
                                thisParent.find('option').not(':selected, .none').remove().end();
                                thisParent.selectpicker('refresh');
                                $(parent).find('ul.dropdown-menu li:first-of-type a').focus();
                                $(parent).find('input').focus();
                            }
                        },
                    });
					// TODO: review the commented code below and remove if it is not required.
                    // rhTriggerAjaxLoadMore(thisParent,fieldValue);
                } else {
                    rhTriggerAjaxOnLoad(thisParent);
                }
            });
        };
        inspiryAjaxSelect('.inspiry_ajax_location_wrapper', 'select.inspiry_ajax_location_field');
    });

	// TODO: review the commented code below and remove if it is not required.
    // $(window).on('load',function () {
    //     $('.inspiry_select_picker_trigger').selectpicker('refresh');
    // });

    $(document).on('ready',function () {
        $('.inspiry_show_on_doc_ready').show();
    });


	/*-----------------------------------------------------------------------------------*/
	/* Favorite Properties
	/*-----------------------------------------------------------------------------------*/
	var addToFavorites = function (e) {
		e.preventDefault();

		if ($(this).hasClass('require-login')) {

			var loginBox = $('.rh_menu__user_profile');
			var loginModel = loginBox.find('.rh_modal');

			if (loginModel.length) {
				$('.rh_login_modal_wrapper').css("display", "flex").hide().fadeIn(500);
			} else {
				window.location = $(this).data('login');
			}
		} else {
			var favorite_link = $(this);
			var span_favorite = $(this).parent().find('span.favorite-placeholder');

			var propertyID = favorite_link.data('propertyid');
			var ajax_url   = ajaxurl;

			if ( propertyID !== '' ) {
				if(favorite_link.hasClass('user_logged_in')){
					var add_to_favorite_options = {
						type : 'post',
						url : ajax_url,
						data : {
							action: 'add_to_favorite',
							property_id : propertyID,
						},
						success: function(response) {
							if('false' !== response) {
								$(favorite_link).addClass('hide');
								$(span_favorite).delay(200).removeClass('hide');
							}
						}
					};
					$.ajax(add_to_favorite_options);
				} else {
					var currentIDs = window.localStorage.getItem('inspiry_favorites');

					if ( currentIDs ) {
						window.localStorage.setItem('inspiry_favorites', currentIDs + ',' + propertyID);
					} else {
						window.localStorage.setItem('inspiry_favorites', propertyID);
					}

					$(favorite_link).addClass('hide');
					$(span_favorite).delay(200).removeClass('hide');
				}
			}

		}
	};
	$('body').on('click', 'a.add-to-favorite', addToFavorites);

	var favorite_properties = window.localStorage.inspiry_favorites; // Get local favorite properties data.

	// Display favorited button and favorite properties on favorite page.
	if ( favorite_properties && ! $('body').hasClass( 'logged-in' ) ) {

		// To display favorited button on page load.
		var property_ids = favorite_properties.split(',');
		property_ids.forEach(function(element,index){
			var favorite_btn_wrap = $('.favorite-btn-' + element);
			var favorite_link = favorite_btn_wrap.find('a.add-to-favorite');
			var span_favorite = favorite_btn_wrap.find('span.favorite-placeholder');

			$(favorite_link).addClass('hide');
			$(span_favorite).delay(200).removeClass('hide');
		});

		// Display favorite properties on the favorites page.
		var favorite_prop_page = $('.favorite_properties_ajax');
		if(favorite_prop_page.length) {

			var design_variation = 'classic';
			if($('body').hasClass('design_modern')){
				design_variation = 'modern';
			}

			var favorite_prop_options = {
				type : 'post',
				dataType : 'html',
				url : ajaxurl,
				data : {
					action: 'display_favorite_properties',
					prop_ids : favorite_properties.split(','),
					design_variation
				},
				success: function(response) {
					favorite_prop_page.html(response);
					remove_from_favorite($('a.remove-from-favorite'));
				}
			};
			$.ajax(favorite_prop_options);
		}
	}

	// Migrate favorite properties from local to server.
	if(favorite_properties && $('body').hasClass('logged-in')){
		var migrate_prop_options = {
			type : 'post',
			url : ajaxurl,
			data : {
				action: 'inspiry_favorite_prop_migration',
				prop_ids : favorite_properties.split(','),
			},
			success: function(response) {
				if ( 'true' === response ) {
					window.localStorage.removeItem('inspiry_favorites');
				}
			}
		};
		$.ajax(migrate_prop_options);
	}

	// Remove favorite properties.
	remove_from_favorite($('a.remove-from-favorite'));
	remove_from_favorite($('.favorite-placeholder.highlight__red'));
	function remove_from_favorite(remove_button){
		remove_button.on('click', function (event) {

			event.preventDefault();

			var $this = $(this);
			var property_item = $this.closest( '.favorite-btn-wrap' );

			if(!property_item.length) {
				property_item = $this.closest('article');
			}

			if(!remove_button.hasClass('user_logged_in')){

				var favorite_properties = window.localStorage.inspiry_favorites;
				if(favorite_properties){
					var prop_ids = favorite_properties.split(',');
					var prop_ids = $.map(favorite_properties.split(','), function(value){
						return parseInt(value);
					});
					const index = prop_ids.indexOf( $this.data('propertyid'));
					if (index > -1) {
						if($this.hasClass('highlight__red')){
							var favorite_link = property_item.find('a.add-to-favorite');
							var span_favorite = property_item.find('span.favorite-placeholder');

							$(span_favorite).addClass('hide');
							$(favorite_link).delay(200).removeClass('hide');
						} else {
							property_item.delay(200).remove();
						}
						prop_ids.splice(index, 1);
						window.localStorage.setItem('inspiry_favorites', prop_ids);
					}
				}

				return;
			}

			var close = $(this).find('i');
			close.addClass('fa-spin');

			var remove_favorite_request = $.ajax({
				url: ajaxurl,
				type: "POST",
				data: {
					property_id: $this.data('propertyid'),
					action: "remove_from_favorites"
				},
				dataType: "json"
			});

			remove_favorite_request.done(function (response) {
				close.removeClass('fa-spin');
				if (response.success) {
					if($this.hasClass('highlight__red')){
						var favorite_link = property_item.find('a.add-to-favorite');
						var span_favorite = property_item.find('span.favorite-placeholder');

						$(span_favorite).addClass('hide');
						$(favorite_link).delay(200).removeClass('hide');
					} else {
						property_item.delay(200).remove();
					}
				}
			});

			remove_favorite_request.fail(function (jqXHR, textStatus) {
			});
		});
	}



})(jQuery);