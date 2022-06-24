/**
 * Javascript to handle google map for contact page.
 */
(function ($) {

    "use strict";

    var mapContainer = document.getElementById("map_canvas");

    if (typeof contactMapData !== "undefined" && mapContainer !== null) {

        if (contactMapData.lat && contactMapData.lng) {

            var officeLocation = new google.maps.LatLng(parseFloat(contactMapData.lat), parseFloat(contactMapData.lng));

            var mapZoom = 14;
            if (contactMapData.zoom) {
                mapZoom = parseInt(contactMapData.zoom);
            }

            var contactMapOptions = {
                center: officeLocation,
                zoom: mapZoom,
                scrollwheel: false,
            };

            // Map Styles
            if (undefined !== contactMapData.styles) {
                contactMapOptions.styles = JSON.parse(contactMapData.styles);
            }

            // Setting Google Map Type
            switch (contactMapData.type) {
                case 'satellite':
                    contactMapOptions.mapTypeId = google.maps.MapTypeId.SATELLITE;
                    break;
                case 'hybrid':
                    contactMapOptions.mapTypeId = google.maps.MapTypeId.HYBRID;
                    break;
                case 'terrain':
                    contactMapOptions.mapTypeId = google.maps.MapTypeId.TERRAIN;
                    break;
                default:
                    contactMapOptions.mapTypeId = google.maps.MapTypeId.ROADMAP;
            }

            var contactMap = new google.maps.Map(document.getElementById("map_canvas"), contactMapOptions);

            var iconURL = "";
            if (contactMapData.iconURL) {
                iconURL = contactMapData.iconURL;
            }

            var contactMarker = new google.maps.Marker({
                position: officeLocation,
                map: contactMap,
                icon: iconURL
            });
        }
    }
})(jQuery);