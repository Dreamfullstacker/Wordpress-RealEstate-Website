/**
 * Javascript to handle open street map for property submit page
 */
(function ($) {
    "use strict";

    $(document).ready(function () {

        var osmTileLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        });

        // Use function construction to store map & DOM elements separately for each instance
        var OsmField = function ($container) {
            this.$container = $container;
        };

        // Use prototype for better performance
        OsmField.prototype = {
            // Initialize everything
            init: function () {
                this.initDomElements();
                this.initMapElements();
                this.initMarkerPosition();
                this.addListeners();
                this.autocomplete();
            },

            // Initialize DOM elements
            initDomElements: function () {
                this.$canvas = this.$container.find('.map-canvas');
                this.canvas = this.$canvas[0];
                this.$coordinate = this.$container.find('.map-coordinate');
                this.$findButton = this.$container.find('.goto-address-button');
                this.$addressField = this.$container.find('.map-address');
            },

            // Initialize map elements
            initMapElements: function () {
                var defaultLoc = this.$coordinate.val();

                defaultLoc = defaultLoc ? defaultLoc.split(',') : [53.346881, -6.258860];

                var latLng = L.latLng(defaultLoc[0], defaultLoc[1]); // Initial position for map.

                this.map = L.map(this.canvas, {
                    center: latLng,
                    zoomControl: false,
                    zoom: 16
                });

                this.map.scrollWheelZoom.disable();

                L.control.zoom({
                    position: 'bottomleft'
                }).addTo(this.map);

                this.map.addLayer(osmTileLayer);

                this.marker = L.marker(latLng, {draggable: true}).addTo(this.map);
            },

            // Initialize marker position
            initMarkerPosition: function () {
                var coordinate = this.$coordinate.val(),
                    location;

                if (coordinate) {
                    location = coordinate.split(',');
                    var latLng = L.latLng(location[0], location[1]);
                    this.marker.setLatLng(latLng);
                    this.map.panTo(latLng);
                } else if (this.$addressField) {
                    this.geocodeAddress();
                }
            },

            // Add event listeners for 'click' & 'drag'
            addListeners: function () {
                var that = this;
                this.map.on('click', function (event) {
                    that.marker.setLatLng(event.latlng);
                    that.updateCoordinate(event.latlng);
                });

                this.map.on('zoom', function () {
                    that.updateCoordinate(that.marker.getLatLng());
                });

                this.marker.on('drag', function () {
                    that.updateCoordinate(that.marker.getLatLng());
                });

                this.$findButton.on('click', function (e) {
                    e.preventDefault();
                    that.geocodeAddress();
                });

                /**
                 * Add a custom event that allows other scripts to refresh the maps when needed
                 * For example: when maps is in tabs or hidden div (this is known issue of Google Maps)
                 */
                $(window).on('map_refresh', function () {
                    that.refresh();
                });

            },

            refresh: function () {
                if (this.map) {
                    this.map.panTo(this.map.getCenter());
                }
            },

            // Autocomplete address
            autocomplete: function () {
                var that = this;

                this.$addressField.autocomplete({
                    source: function (request, response) {
                        $.get('https://nominatim.openstreetmap.org/search', {
                            format: 'json',
                            q: request.term
                            //countrycodes: that.$canvas.data( 'region' ),
                            //"accept-language": that.$canvas.data( 'language' )
                        }, function (results) {
                            if (!results.length) {
                                response([{
                                    value: '',
                                    label: 'No results found!'
                                }]);
                                return;
                            }
                            response(results.map(function (item) {
                                return {
                                    label: item.display_name,
                                    value: item.display_name,
                                    latitude: item.lat,
                                    longitude: item.lon
                                };
                            }));
                        }, 'json');
                    },
                    select: function (event, ui) {
                        var latLng = L.latLng(ui.item.latitude, ui.item.longitude);

                        that.map.panTo(latLng);
                        that.marker.setLatLng(latLng);
                        that.updateCoordinate(latLng);
                    },
                    appendTo: "#map-address-field-wrapper"
                });
            },

            // Update coordinate to input field
            updateCoordinate: function (latLng) {
                this.$coordinate.val(latLng.lat + ',' + latLng.lng);
            },

            // Find coordinates by address
            geocodeAddress: function () {
                var address = this.getAddress(),
                    that = this;

                if (!address) {
                    return;
                }

                $.get('https://nominatim.openstreetmap.org/search', {
                    format: 'json',
                    q: address,
                    limit: 1,
                    //countrycodes: that.$canvas.data( 'region' ),
                    //"accept-language": that.$canvas.data( 'language' )
                }, function (result) {
                    if (result.length !== 1) {
                        return;
                    }
                    var latLng = L.latLng(result[0].lat, result[0].lon);
                    that.map.panTo(latLng);
                    that.marker.setLatLng(latLng);
                    that.updateCoordinate(latLng);

                    if (!(/[a-z]/i.test(address))) {
                        document.querySelector('.map-address').value = result[0].display_name;
                    }

                }, 'json');
            },

            // Get the address value for geocoding.
            getAddress: function () {
                return this.$addressField.val().replace(/\n/g, ',').replace(/,,/g, ',');
            }

        };

        function update() {
            $('.address-map-fields-wrapper').each(function () {
                var $this = $(this),
                    controller = $this.data('osmController');
                if (controller) {
                    return;
                }

                controller = new OsmField($this);
                controller.init();
                $this.data('osmController', controller);
            });
        }

        $(function () {
            update();
        });
    });

})(jQuery);