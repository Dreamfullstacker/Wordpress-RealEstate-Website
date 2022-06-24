<script>
    /**
     * Javascript to handle open street map for multiple properties
     */
    jQuery( function( $ ) {
            'use strict';

        if ( typeof propertiesMapData !== "undefined" ) {

            if ( 0 < propertiesMapData.length ) {

                var tileLayer = L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                } );

                // get map bounds
                var mapBounds = [];
                for( var i = 0; i < propertiesMapData.length; i++ ) {
                    if ( propertiesMapData[i].lat && propertiesMapData[i].lng ) {
                        mapBounds.push( [ propertiesMapData[i].lat, propertiesMapData[i].lng ] );
                    }
                }

                // Basic map
                var mapCenter = L.latLng( 27.664827, -81.515755 );	// given coordinates not going to matter 99.9% of the time but still added just in case.
                if ( 1 == mapBounds.length ) {
                    mapCenter = L.latLng( mapBounds[0] );	// this is also not going to effect 99% of the the time but just in case of one property.
                }
                var mapDragging = (L.Browser.mobile) ? false : true; // disabling one finger dragging on mobile but zoom with two fingers will still be enabled.
                var mapOptions = {
                    dragging: mapDragging,
                    center: mapCenter,
                    zoom: 10,
                    zoomControl: false,
                    tap: false
                };
                var propertiesMap = L.map( 'listing-map', mapOptions );

                L.control.zoom( {
                    position : 'bottomleft'
                } ).addTo( propertiesMap );

                propertiesMap.scrollWheelZoom.disable();

                if ( 1 < mapBounds.length ) {
                    propertiesMap.fitBounds( mapBounds );	// fit bounds should work only for more than one properties
                }

                propertiesMap.addLayer( tileLayer );

                for( var i = 0; i < propertiesMapData.length; i++ ) {

                    if ( propertiesMapData[i].lat && propertiesMapData[i].lng ) {

                        var propertyMapData = propertiesMapData[i];

                        var markerLatLng = L.latLng( propertyMapData.lat, propertyMapData.lng );

                        var markerOptions = {
                            riseOnHover: true
                        };

                        // Marker icon
                        if ( propertyMapData.title ) {
                            markerOptions.title = propertyMapData.title;
                        }

                        // Marker icon
                        if ( propertyMapData.icon ) {
                            var iconOptions = {
                                iconUrl: propertyMapData.icon,
                                iconSize: [42, 57],
                                iconAnchor: [20, 57],
                                popupAnchor: [1, -54]
                            };
                            if ( propertyMapData.retinaIcon ) {
                                iconOptions.iconRetinaUrl = propertyMapData.retinaIcon;
                            }
                            markerOptions.icon = L.icon( iconOptions );
                        }

                        var propertyMarker = L.marker( markerLatLng, markerOptions ).addTo( propertiesMap );

                        // Marker popup
                        var popupContentWrapper = document.createElement( "div" );
                        popupContentWrapper.className = 'osm-popup-content';
                        var popupContent = "";

                        if( propertyMapData.thumb ) {
                            popupContent += '<a class="osm-popup-thumb-link" href="' + propertyMapData.url + '"><img class="osm-popup-thumb" src="' + propertyMapData.thumb + '" alt="' + propertyMapData.title + '"/></a>';
                        }

                        if ( propertyMapData.title ) {
                            popupContent += '<h5 class="osm-popup-title"><a class="osm-popup-link" href="' + propertyMapData.url + '">' + propertyMapData.title + '</a></h5>';
                        }

                        if( propertyMapData.price ) {
                            popupContent += '<p><span class="osm-popup-price">' + propertyMapData.price + '</span></p>';
                        }

                        popupContentWrapper.innerHTML = popupContent;

                        propertyMarker.bindPopup( popupContentWrapper );

                    }

                }

            } else {

                // Fallback Map
                var fallbackLayer = L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution : '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                } );

                // todo: provide an option for fallback map coordinates
                var fallbackMapOptions = {
                    center : [27.664827, -81.515755],
                    zoom : 12
                };

                var fallbackMap = L.map( 'listing-map', fallbackMapOptions );
                fallbackMap.addLayer( fallbackLayer );

            }

        }

        // Add custom class to zoom control to apply z-index for modern variation
        $(".leaflet-control-zoom").parent(".leaflet-bottom").addClass("rh_leaflet_controls_zoom");

    } );
</script>