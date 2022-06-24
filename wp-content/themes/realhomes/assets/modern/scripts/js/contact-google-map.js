/**
 * Javascript to handle open street map for property single page.
 */
(function($) {
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
                styles: [{
                    "featureType": "administrative",
                    "elementType": "labels.text",
                    "stylers": [{
                        "color": "#000000"
                    }]
                }, {
                    "featureType": "administrative",
                    "elementType": "labels.text.fill",
                    "stylers": [{
                        "color": "#444444"
                    }]
                }, {
                    "featureType": "administrative",
                    "elementType": "labels.text.stroke",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "administrative",
                    "elementType": "labels.icon",
                    "stylers": [{
                        "visibility": "on"
                    }, {
                        "color": "#380d0d"
                    }]
                }, {
                    "featureType": "landscape", "elementType": "all", "stylers": [{
                        "color": "#f2f2f2"
                    }]
                }, {
                    "featureType": "poi", "elementType": "all", "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "road", "elementType": "all", "stylers": [{
                        "saturation": -100
                    }, {
                        "lightness": 45
                    }]
                }, {
                    "featureType": "road", "elementType": "geometry", "stylers": [{
                        "visibility": "on"
                    }, {
                        "color": "#dedddb"
                    }]
                }, {
                    "featureType": "road", "elementType": "labels.text", "stylers": [{
                        "color": "#000000"
                    }]
                }, {
                    "featureType": "road", "elementType": "labels.text.fill", "stylers": [{
                        "color": "#1f1b1b"
                    }]
                }, {
                    "featureType": "road", "elementType": "labels.text.stroke", "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "road", "elementType": "labels.icon", "stylers": [{
                        "visibility": "on"
                    }, {
                        "hue": "#ff0000"
                    }]
                }, {
                    "featureType": "road.highway", "elementType": "all", "stylers": [{
                        "visibility": "simplified"
                    }]
                }, {
                    "featureType": "road.arterial",
                    "elementType": "labels.icon",
                    "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "transit", "elementType": "all", "stylers": [{
                        "visibility": "off"
                    }]
                }, {
                    "featureType": "water", "elementType": "all", "stylers": [{
                        "color": contactMapData.mapWaterColor
                    }, {
                        "visibility": "on"
                    }]
                }]
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

            // Map Styles
            if (undefined !== contactMapData.styles) {
                contactMapOptions.styles = JSON.parse(contactMapData.styles);
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