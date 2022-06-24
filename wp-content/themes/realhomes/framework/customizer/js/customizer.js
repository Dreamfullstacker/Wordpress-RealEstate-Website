/**
 * RealHomes Customizer postMessage JS controls
 *
 * @since 2.6.2
 */
(function ($) {
    "use strict";

    // Keyword Search Placeholder
    wp.customize('inspiry_keyword_placeholder_text', function (value) {
        value.bind(function (to) {
            $('.advance-search .option-bar #keyword-txt').attr("placeholder", to);
        });
    });

    // Property ID Search Placeholder
    wp.customize('inspiry_property_id_placeholder_text', function (value) {
        value.bind(function (to) {
            $('.advance-search .option-bar #property-id-txt').attr("placeholder", to);
        });
    });

    // Keyword Label
    wp.customize('inspiry_keyword_label', function (value) {
        value.bind(function (to) {
            $('.option-bar label[for="keyword-txt"]').text(to);
        });
    });

    // Property ID Label
    wp.customize('inspiry_property_id_label', function (value) {
        value.bind(function (to) {
            $('.advance-search .option-bar label[for="property-id-txt"]').text(to);
        });
    });

    // Property Status Label
    wp.customize('inspiry_property_status_label', function (value) {
        value.bind(function (to) {
            $('.advance-search .option-bar label[for="select-status"]').text(to);
        });
    });

    // Property Type Label
    wp.customize('inspiry_property_type_label', function (value) {
        value.bind(function (to) {
            $('.advance-search .option-bar label[for="select-property-type"]').text(to);
        });
    });

    // Agent Label
    wp.customize('inspiry_agent_field_label', function (value) {
        value.bind(function (to) {
            $('.advance-search .option-bar label[for="select-agent"]').text(to);
        });
    });

    // Search Button Text
    wp.customize('inspiry_search_button_text', function (value) {
        value.bind(function (to) {
            $('.advance-search .option-bar input.real-btn').attr("value", to);
        });
    });

    // Location 1 Label
    wp.customize('theme_location_title_1', function (value) {
        value.bind(function (to) {
            $('.advance-search .option-bar label[for="location"]').text(to);
        });
    });

    // Location 2 Label
    wp.customize('theme_location_title_2', function (value) {
        value.bind(function (to) {
            $('.advance-search .option-bar label[for="child-location"]').text(to);
        });
    });

    // Location 3 Label
    wp.customize('theme_location_title_3', function (value) {
        value.bind(function (to) {
            $('.advance-search .option-bar label[for="grandchild-location"]').text(to);
        });
    });

    // Location 4 Label
    wp.customize('theme_location_title_4', function (value) {
        value.bind(function (to) {
            $('.advance-search .option-bar label[for="great-grandchild-location"]').text(to);
        });
    });

    // Beds Label
    wp.customize('inspiry_min_beds_label', function (value) {
        value.bind(function (to) {
            $('.advance-search .option-bar label[for="select-bedrooms"]').text(to);
        });
    });

    // Baths Label
    wp.customize('inspiry_min_baths_label', function (value) {
        value.bind(function (to) {
            $('.advance-search .option-bar label[for="select-bathrooms"]').text(to);
        });
    });

    // Garages Label
    wp.customize('inspiry_min_garages_label', function (value) {
        value.bind(function (to) {
            $('.advance-search .option-bar label[for="select-garages"]').text(to);
        });
    });

    // Minimum Price Label
    wp.customize('inspiry_min_price_label', function (value) {
        value.bind(function (to) {
            $('.advance-search .option-bar label[for="select-min-price"]').text(to);
        });
    });

    // Maximum Price Label
    wp.customize('inspiry_max_price_label', function (value) {
        value.bind(function (to) {
            $('.advance-search .option-bar label[for="select-max-price"]').text(to);
        });
    });

    // Minimum Area Search Placeholder
    wp.customize('inspiry_min_area_placeholder_text', function (value) {
        value.bind(function (to) {
            $('.advance-search .option-bar #min-area').attr("placeholder", to);
        });
    });

    // Maximum Area Search Placeholder
    wp.customize('inspiry_max_area_placeholder_text', function (value) {
        value.bind(function (to) {
            $('.advance-search .option-bar #max-area').attr("placeholder", to);
        });
    });

    // Area Unit Placeholder
    wp.customize('theme_area_unit', function (value) {
        value.bind(function (to) {
            $('.advance-search .option-bar label[for="min-area"] span, .advance-search .option-bar label[for="max-area"] span').text("(" + to + ")");
        });
    });

    // Footer Partners Text
    wp.customize('theme_partners_title', function (value) {
        value.bind(function (to) {
            $('.brands-carousel h3 span').text(to);
        });
    });

    // Property Additional Details Section Title
    wp.customize('theme_additional_details_title', function (value) {
        value.bind(function (to) {
            $('.property-item h4.additional-title').text(to);
        });
    });

    // Property Features Section Title
    wp.customize('theme_property_features_title', function (value) {
        value.bind(function (to) {
            $('.property-item .features h4.title').text(to);
        });
    });

	// Property Views Section Title
	wp.customize('inspiry_property_views_title', function (value) {
		value.bind(function (to) {
			$('.property-views-wrap h4').text(to);
		});
	});

	// Property Mortgage Calculator Section Title
	wp.customize('inspiry_property_views_title', function (value) {
		value.bind(function (to) {
			$('.property-views-wrap h4').text(to);
		});
	});

    // Property Availability Calendar Section Title
    wp.customize('inspiry_availability_calendar_title', function (value) {
        value.bind(function (to) {
            $('.availability-calendar-wrap h4').text(to);
        });
    });

    // Property Child Properties
    wp.customize('theme_child_properties_title', function (value) {
        value.bind(function (to) {
            $('#overview .child-properties h3').text(to);
        });
    });

})(jQuery);
