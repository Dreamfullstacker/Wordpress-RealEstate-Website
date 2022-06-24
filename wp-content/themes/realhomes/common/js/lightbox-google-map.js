/**
 * Javascript to handle open street map for Lightbox popup.
 */
(function ($) {
    "use strict";

    $(document).on('ready', function () {

        function rhGoogleMapLightbox() {

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

                var mapContainer = document.getElementById(id);

                setTimeout(function () {

                    if (typeof propertyMapData !== "undefined") {

                        if ($('body #' + id).hasClass('fancybox-content')) {

                            if (lat && lng) {

                                var iconURL = propertyMapData.icon;
                                ;
                                var iconSize = new google.maps.Size(42, 57);
                                var mapZoom = 15;

                                // zoom
                                if (zoom > 0) {
                                    mapZoom = parseInt(zoom);
                                }

                                // retina
                                if (window.devicePixelRatio > 1.5) {
                                    if (propertyMapData.retinaIcon) {
                                        iconURL = propertyMapData.retinaIcon;
                                        iconSize = new google.maps.Size(83, 113);
                                    }
                                }

                                if (propertyMapData.marker_type == 'circle') {
                                    var markerIcon = {
                                        path: google.maps.SymbolPath.CIRCLE,
                                        scale: 30,
                                        fillColor: propertyMapData.marker_color,
                                        strokeColor: propertyMapData.marker_color,
                                        fillOpacity: 0.5,
                                        strokeWeight: 0.6
                                    }
                                } else {
                                    var markerIcon = {
                                        url: iconURL,
                                        size: iconSize,
                                        scaledSize: new google.maps.Size(42, 57),
                                        origin: new google.maps.Point(0, 0),
                                        anchor: new google.maps.Point(21, 56)
                                    };
                                }

                                var propertyLocation = new google.maps.LatLng(lat, lng);
                                var propertyMapOptions = {
                                    center: propertyLocation,
                                    zoom: mapZoom,
                                    scrollwheel: false
                                };

                                // Map Styles
                                if (undefined !== propertyMapData.styles && propertyMapData.styles !== '') {
                                    propertyMapOptions.styles = JSON.parse(propertyMapData.styles);
                                }

                                // Setting Google Map Type
                                switch (propertyMapData.type) {
                                    case 'satellite':
                                        propertyMapOptions.mapTypeId = google.maps.MapTypeId.SATELLITE;
                                        break;
                                    case 'hybrid':
                                        propertyMapOptions.mapTypeId = google.maps.MapTypeId.HYBRID;
                                        break;
                                    case 'terrain':
                                        propertyMapOptions.mapTypeId = google.maps.MapTypeId.TERRAIN;
                                        break;
                                    default:
                                        propertyMapOptions.mapTypeId = google.maps.MapTypeId.ROADMAP;
                                }

                                var propertyMap = new google.maps.Map(mapContainer, propertyMapOptions);

                                var propertyMarker = new google.maps.Marker({
                                    position: propertyLocation,
                                    map: propertyMap,
                                    icon: markerIcon
                                });


                                var boxText = document.createElement("div");
                                boxText.className = 'map-info-window';
                                var innerHTML = "";
                                if (thumbNail) {
                                    innerHTML += '<img class="prop-thumb" src="' + thumbNail + '" alt="' + title + '"/>';
                                }
                                innerHTML += '<h5 class="prop-title">' + title + '</h5>';
                                if (price) {
                                    innerHTML += '<p><span class="price">' + price + '</span></p>';
                                }
                                innerHTML += '<div class="arrow-down"></div>';
                                boxText.innerHTML = innerHTML;

                                // info window close icon URL
                                var closeIconURL = "";
                                if ((typeof mapStuff !== "undefined") && mapStuff.closeIcon) {
                                    closeIconURL = mapStuff.closeIcon;
                                }

                                var infoWindowOptions = {
                                    content: boxText,
                                    disableAutoPan: true,
                                    maxWidth: 0,
                                    alignBottom: true,
                                    pixelOffset: new google.maps.Size(-122, -48),
                                    zIndex: null,
                                    closeBoxMargin: "0 0 -16px -16px",
                                    closeBoxURL: closeIconURL,
                                    infoBoxClearance: new google.maps.Size(1, 1),
                                    isHidden: false,
                                    pane: "floatPane",
                                    enableEventPropagation: false
                                };

                                var infoBox = new InfoBox(infoWindowOptions);

                                google.maps.event.addListener(propertyMarker, 'click', function () {
                                    var scale = Math.pow(2, propertyMap.getZoom());
                                    var offsety = ((150 / scale) || 0);
                                    var projection = propertyMap.getProjection();
                                    var markerPosition = propertyMarker.getPosition();
                                    var markerScreenPosition = projection.fromLatLngToPoint(markerPosition);
                                    var pointHalfScreenAbove = new google.maps.Point(markerScreenPosition.x, markerScreenPosition.y - offsety);
                                    var aboveMarkerLatLng = projection.fromPointToLatLng(pointHalfScreenAbove);
                                    propertyMap.setCenter(aboveMarkerLatLng);
                                    infoBox.open(propertyMap, propertyMarker);
                                });


                            }
                        }


                    }


                }, 1000);
            });
        };

        rhGoogleMapLightbox();

    });


})(jQuery);