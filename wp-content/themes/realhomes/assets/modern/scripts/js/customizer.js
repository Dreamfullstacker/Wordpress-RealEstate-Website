/**
 * RealHomes Customizer postMessage JS controls
 *
 * @since 2.6.2
 */
( function( $ ) {

	// Body background.
    wp.customize( 'background_color', function( value ) {
        value.bind( function( to ) {
            $( '.rh_section--props_padding:after, .rh_section__agents:after' ).css( { 'border-left-color' : to } );
        } );
    } );
    wp.customize( 'background_color', function( value ) {
        value.bind( function( to ) {
            $( '.rh_section__agents:before' ).css( { 'border-right-color' : to } );
        } );
    } );

    // Keyword Search Placeholder
    wp.customize( 'inspiry_keyword_placeholder_text', function( value ) {
        value.bind( function( to ) {
            $( '.rh_prop_search__option #keyword-txt' ).attr( "placeholder", to );
        } );
    } );

    // Property ID Search Placeholder
    wp.customize( 'inspiry_property_id_placeholder_text', function( value ) {
        value.bind( function( to ) {
            $( '.rh_prop_search__option #property-id-txt' ).attr( "placeholder", to );
        } );
    } );

    // Keyword Label
    wp.customize( 'inspiry_keyword_label', function( value ) {
        value.bind( function( to ) {
            $( '.rh_prop_search__option label[for="keyword-txt"]' ).text( to );
        } );
    } );

    // Property Type Label
    wp.customize( 'inspiry_property_type_label', function( value ) {
        value.bind( function( to ) {
            $( '.rh_prop_search__option label[for="select-property-type"]' ).text( to );
        } );
    } );

    // Agent Label
    wp.customize( 'inspiry_agent_field_label', function( value ) {
        value.bind( function( to ) {
            $( '.rh_prop_search__option label[for="select-agent"]' ).text( to );
        } );
    } );

    // Property Status Label
    wp.customize( 'inspiry_property_status_label', function( value ) {
        value.bind( function( to ) {
            $( '.rh_prop_search__option label[for="select-status"]' ).text( to );
        } );
    } );

    // Beds Label
    wp.customize( 'inspiry_min_beds_label', function( value ) {
        value.bind( function( to ) {
            $( '.rh_prop_search__option label[for="select-bedrooms"]' ).text( to );
        } );
    } );

    // Search Button Text
    wp.customize( 'inspiry_search_button_text', function( value ) {
        value.bind( function( to ) {
            $( '.rh_prop_search__searchBtn .rh_btn__prop_search span' ).text( to );
        } );
    } );

    // Location 1 Label
    wp.customize( 'theme_location_title_1', function( value ) {
        value.bind( function( to ) {
            $( '.rh_prop_search__option label[for="location"]' ).text( to );
        } );
    } );

    // Location 2 Label
    wp.customize( 'theme_location_title_2', function( value ) {
        value.bind( function( to ) {
            $( '.rh_prop_search__option label[for="child-location"]' ).text( to );
        } );
    } );

    // Location 3 Label
    wp.customize( 'theme_location_title_3', function( value ) {
        value.bind( function( to ) {
            $( '.rh_prop_search__option label[for="grandchild-location"]' ).text( to );
        } );
    } );

    // Location 4 Label
    wp.customize( 'theme_location_title_4', function( value ) {
        value.bind( function( to ) {
            $( '.rh_prop_search__option label[for="great-grandchild-location"]' ).text( to );
        } );
    } );

    // Baths Label
    wp.customize( 'inspiry_min_baths_label', function( value ) {
        value.bind( function( to ) {
            $( '.rh_prop_search__option label[for="select-bathrooms"]' ).text( to );
        } );
    } );

    // Garages Label
    wp.customize( 'inspiry_min_garages_label', function( value ) {
        value.bind( function( to ) {
            $( '.rh_prop_search__option label[for="select-garages"]' ).text( to );
        } );
    } );

    // Minimum Price Label
    wp.customize( 'inspiry_min_price_label', function( value ) {
        value.bind( function( to ) {
            $( '.rh_prop_search__option label[for="select-min-price"]' ).text( to );
        } );
    } );

    // Maximum Price Label
    wp.customize( 'inspiry_max_price_label', function( value ) {
        value.bind( function( to ) {
            $( '.rh_prop_search__option label[for="select-max-price"]' ).text( to );
        } );
    } );

    // Minimum Area Search Placeholder
    wp.customize( 'inspiry_min_area_placeholder_text', function( value ) {
        value.bind( function( to ) {
            $( '.rh_prop_search__option #min-area' ).attr( "placeholder", to );
        } );
    } );

    // Maximum Area Search Placeholder
    wp.customize( 'inspiry_max_area_placeholder_text', function( value ) {
        value.bind( function( to ) {
            $( '.rh_prop_search__option #max-area' ).attr( "placeholder", to );
        } );
    } );

    // Min Area Label
    wp.customize( 'inspiry_min_area_label', function( value ) {
        value.bind( function( to ) {
            $( '.rh_prop_search__option label[for="min-area"] .label' ).text( to );
        } );
    } );

    // Max Area Label
    wp.customize( 'inspiry_max_area_label', function( value ) {
        value.bind( function( to ) {
            $( '.rh_prop_search__option label[for="max-area"] .label' ).text( to );
        } );
    } );

    // Area Unit Placeholder
    wp.customize( 'theme_area_unit', function( value ) {
        value.bind( function( to ) {
            $( '.rh_prop_search__option label[for="min-area"] .unit, .rh_prop_search__option label[for="max-area"] .unit' ).text( "(" + to + ")" );
        } );
    } );

    // Property ID Label
    wp.customize( 'inspiry_property_id_label', function( value ) {
        value.bind( function( to ) {
            $( '.rh_prop_search__option label[for="property-id-txt"]' ).text( to );
        } );
    } );

    wp.customize('inspiry_availability_calendar_title', function (value) {
        value.bind(function (to) {
            $('.rh_property__ava_calendar_wrap h4').text(to);
        });
    });

    // Footer: Facebook Link
    wp.customize( 'theme_facebook_link', function( value ) {
        value.bind( function( to ) {
            $( '.rh_footer__social .facebook' ).attr( "href", to );
        } );
    } );

    // Footer: Twitter Link
    wp.customize( 'theme_twitter_link', function( value ) {
        value.bind( function( to ) {
            $( '.rh_footer__social .twitter' ).attr( "href", to );
        } );
    } );

    // Footer: LinkedIn Link
    wp.customize( 'theme_linkedin_link', function( value ) {
        value.bind( function( to ) {
            $( '.rh_footer__social .linkedin' ).attr( "href", to );
        } );
    } );

    // Footer: Instagram Link
    wp.customize( 'theme_instagram_link', function( value ) {
        value.bind( function( to ) {
            $( '.rh_footer__social .instagram' ).attr( "href", to );
        } );
    } );

    // Footer: YouTube Link
    wp.customize( 'theme_youtube_link', function( value ) {
        value.bind( function( to ) {
            $( '.rh_footer__social .youtube' ).attr( "href", to );
        } );
    } );

    // Footer: Skype Link
    wp.customize( 'theme_skype_username', function( value ) {
        value.bind( function( to ) {
            $( '.rh_footer__social .skype' ).attr( "href", "skype:" + to + "?add" );
        } );
    } );

    // Footer: Pinterest Link
    wp.customize( 'theme_pinterest_link', function( value ) {
        value.bind( function( to ) {
            $( '.rh_footer__social .pinterest' ).attr( "href", to );
        } );
    } );

    // Footer: RSS Link
    wp.customize( 'theme_rss_link', function( value ) {
        value.bind( function( to ) {
            $( '.rh_footer__social .rss' ).attr( "href", to );
        } );
    } );

} )( jQuery );
