/**
 * Javascript to handle open street map for property single page.
 */
(function($) {
    "use strict";

    var mapContainer = document.getElementById("map_canvas");

    if (typeof contactMapData !== "undefined" && mapContainer !== null) {

        if (contactMapData.lat && contactMapData.lng) {

            var tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            });

            var mapCenter = L.latLng(parseFloat(contactMapData.lat), parseFloat(contactMapData.lng));
            var mapZoom = 14;

            if (contactMapData.zoom) {
                mapZoom = contactMapData.zoom
            }

            var mapOptions = {
                center: mapCenter, zoom: mapZoom
            };

            var contactMap = L.map('map_canvas', mapOptions);
            contactMap.scrollWheelZoom.disable();
            contactMap.addLayer(tileLayer);

            L.marker(mapCenter).addTo(contactMap);
        }
    }
})(jQuery);