/**
 * Javascript to handle open street map for Lightbox popup.
 */
(function ($) {
    "use strict";

    $(document).on('ready',function () {

        function rhOSMInitLightbox() {

            $('body').on('click', '.rhea_trigger_map', function (event) {
                event.preventDefault();

                var id = $(this).attr('data-rhea-map-source');
                var location = $(this).attr('data-rhea-map-location');
                var locSplit = location.split(",");
                var lat = locSplit[0];
                var lng = locSplit[1];
                var zoom = locSplit[2];
                var title = $(this).data('rhea-map-title');
                var price = $(this).data('rhea-map-price');
                var thumbNail = $(this).data('rhea-map-thumb');

                $.fancybox.open(
                    {
                        src: '<div class="rhea_map_lightbox_content" id="' + id + '"></div>',
                        type: 'html',
                        touch: false,
                    }
                );

                setTimeout(function () {

                    if (typeof propertyMapData !== "undefined") {


                        if ($('body #' + id).hasClass('fancybox-content')) {


                            if (lat && lng) {


                                var tileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                                });

                                // Basic map
                                var mapCenter = L.latLng(lat, lng);
                                var mapZoom = 16;

                                // zoom
                                if (zoom > 0) {
                                    mapZoom = parseInt(zoom);
                                }

                                var mapOptions = {
                                    center: mapCenter,
                                    zoom: mapZoom
                                };

                                var propertyMap = L.map(id, mapOptions);
                                propertyMap.scrollWheelZoom.disable();
                                propertyMap.addLayer(tileLayer);

                                // Marker
                                var markerOptions = {
                                    riseOnHover: true
                                };

                                if (title) {
                                    markerOptions.title = title;
                                }

                                if (propertyMapData.marker_type === 'circle') {
                                    var propertyMarker = new L.Circle(mapCenter, 120, {
                                        fillColor: propertyMapData.marker_color,
                                        color: propertyMapData.marker_color,
                                        weight: 2,
                                        fillOpacity: 0.6,
                                        opacity: 0.6
                                    });
                                    propertyMap.addLayer(propertyMarker);
                                } else {
                                    // Marker icon
                                    if (propertyMapData.icon) {
                                        var iconOptions = {
                                            iconUrl: propertyMapData.icon,
                                            iconSize: [42, 57],
                                            iconAnchor: [20, 57],
                                            popupAnchor: [1, -54]
                                        };
                                        if (propertyMapData.retinaIcon) {
                                            iconOptions.iconRetinaUrl = propertyMapData.retinaIcon;
                                        }
                                        markerOptions.icon = L.icon(iconOptions);
                                    }

                                    var propertyMarker = L.marker(mapCenter, markerOptions).addTo(propertyMap);
                                }

                                // Marker popup
                                var popupContentWrapper = document.createElement("div");
                                popupContentWrapper.className = 'osm-popup-content';
                                var popupContent = "";

                                if (thumbNail) {
                                    popupContent += '<img class="osm-popup-thumb" src="' + thumbNail + '" alt="' + title + '"/>';
                                }

                                if (title) {
                                    popupContent += '<h5 class="osm-popup-title">' + title + '</h5>';
                                }

                                if (price) {
                                    popupContent += '<p><span class="osm-popup-price">' + price + '</span></p>';
                                }

                                popupContentWrapper.innerHTML = popupContent;

                                propertyMarker.bindPopup(popupContentWrapper);

                            }

                        }

                    }

                }, 1000);
            });

        };

        rhOSMInitLightbox();

    });



})(jQuery);