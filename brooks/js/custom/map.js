(function($, window) {

    var BrooksTheme = window.BrooksTheme || {},
        _global = BrooksTheme.Global;

    BrooksTheme.ThemeOptions = BrooksTheme.ThemeOptions || {};

    var map_mode = BrooksTheme.ThemeOptions.map_mode;
    var map_grey = BrooksTheme.ThemeOptions.map_grey;
    var mainColor = BrooksTheme.ThemeOptions.theme_custom_color?BrooksTheme.ThemeOptions.theme_custom_color:BrooksTheme.ThemeOptions.theme_color;

    BrooksTheme.Map = function($map, dataOptions){
        this.$map = $map;

        this.settings = $.extend(true, {}, BrooksTheme.Map.settings, dataOptions);

        this.settings.infowindow.offset = {
            x: this.settings.infowindow.width/2,
            y: this.settings.infowindow.height + this.settings.marker.height/2 + this.settings.infowindow.bottomSpacing
        };

        this.settings.infowindow.openOffset = {
            x: 0,
            y: this.settings.infowindow.height/2 + this.settings.marker.height/2 - this.settings.infowindow.bottomSpacing
        }

        this.init();
    }

    BrooksTheme.Map.settings = {
        fitBounds: false,
        geolocation: false,
        clusterImage: null,
        markerImage: null,
        markers: [],
        preloader: null,
        infowindow: {
            width: 230,
            height: 190,
            bottomSpacing: 10
        },
        marker: {
            width: 40,
            height: 40,
            markup: null
        },
        cluster: {
            width: 40,
            height: 40,
            gridSize: 40,
            markup: null
        },

        styles: null,
        zoom: 14,
        zoomControl: true,
        panControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: false,
        scrollwheel: false,
        draggable: true,
        navigationControl: false,
        instances: []
    }

    BrooksTheme.Map.prototype.init = function(){
        var _self = this;

        this.settings.center = this.settings.center != undefined?new google.maps.LatLng(this.settings.center.latitude, this.settings.center.longitude):null;
        this.settings.styles = this.initStyles();

        this.markers = [];

        var options = {
            styles: this.settings.styles,
            center: this.settings.center,
            zoom: this.settings.zoom,
            zoomControl: this.settings.zoomControl,
            panControl: this.settings.panControl,
            mapTypeId: this.settings.mapTypeId,
            mapTypeControl: this.settings.mapTypeControl,
            scrollwheel: this.settings.scrollwheel,
            draggable: this.settings.draggable,
            navigationControl: this.settings.navigationControl,
            preloader: this.settings.preloader
        }

        this.map = new google.maps.Map(this.$map.get(0), options);

        if(this.settings.preloader)
            google.maps.event.addListenerOnce(this.map, 'tilesloaded', function(){
                $('#' + _self.settings.preloader).fadeOut();
            });


        if (this.settings.geolocation) {
            if (navigator.geolocation) {

                navigator.geolocation.getCurrentPosition(function (position) {
                    _self.map.setCenter( new google.maps.LatLng(position.coords.latitude, position.coords.longitude) );
                }, null);
            }
        }

        if (!this.settings.center || this.settings.fitBounds) {
            if (this.settings.markers.length !== 0) {
                this.bounds = new google.maps.LatLngBounds();

                this.settings.markers.forEach(function(marker){
                    _self.bounds.extend(new google.maps.LatLng( marker.latitude, marker.longitude));
                });
                this.map.fitBounds(_self.bounds);
            }
        }

        this.render();
    }

    BrooksTheme.Map.prototype.render = function(){
        var _self = this;

        this.bounds = new google.maps.LatLngBounds();

        this.settings.markers.forEach(function (marker) {
            _self.addMarker(marker);
        });

        this.markerCluster = new MarkerClusterer(this.map, this.markers, {
            gridSize: this.settings.cluster.gridSize,
            styles: [
                {
                    url: this.settings.clusterImage,
                    height: this.settings.cluster.height,
                    width: this.settings.cluster.width
                }
            ]
        });

        google.maps.event.addListener(this.markerCluster, 'clusteringend', function (clusterer) {


            clusterer.getClusters().forEach(function(cluster){
                var clusterMarkers = cluster.getMarkers();

                if(clusterMarkers.length > 1) {
                    clusterMarkers.forEach(function(marker){
                        marker.marker.isHidden = true;
                        marker.marker.close();
                    });

                    cluster.markersHidden = true;
                } else {
                    clusterMarkers.forEach(function(marker){
                        marker.marker.isHidden = false;
                        marker.marker.open(_self.map, marker);
                    });
                }

            });
        });

        google.maps.event.addListener(this.map, 'zoom_changed', function() {
            _self.hideInfoboxes();
        });
        google.maps.event.addListener(this.map, 'click', function() {
            _self.hideInfoboxes();
        })

    }

    BrooksTheme.Map.prototype.hideInfoboxes = function(){
        this.markers.forEach(function(marker){
            if (marker.infobox)
                marker.infobox.hide();
        });
    }

    BrooksTheme.Map.prototype.updateMapMarkers = function(markers){
        var _self = this;
            newMarkers = [];

        this.hideMarkers();
        _self.markerCluster.removeMarkers(_self.markers);

        if(!markers.length)
            return;

        markers.forEach(function(marker){
            var newMarker = _self.markerExist(marker);

            if(!newMarker) {
                newMarker = _self.addMarker(marker);
            }

            newMarker.setVisible(true);
            newMarker.marker.show();

            newMarkers.push(newMarker);
        });

        _self.markerCluster.addMarkers(newMarkers);
        _self.markerCluster.fitMapToMarkers();
        _self.markerCluster.repaint();
    }

    BrooksTheme.Map.prototype.hideMarkers = function(){
        this.markers.forEach(function(marker){
            marker.setVisible(false);
            marker.marker.hide();

            if (marker.infobox)
                marker.infobox.hide();
        });
    }

    BrooksTheme.Map.prototype.addMarker = function(marker){
        if(!marker.latitude || !marker.longitude)
            return;

        var _self = this;

        if(_self.settings.fitBounds)
            this.bounds.extend(new google.maps.LatLng(marker.latitude, marker.longitude));

        var mapMarker = new google.maps.Marker({
            position: new google.maps.LatLng(marker.latitude, marker.longitude),
            map: _self.map,
            icon: {
                anchor: new google.maps.Point(_self.settings.marker.width/2, _self.settings.marker.height/2),
                url: _self.settings.markerImage,
                size: new google.maps.Size(_self.settings.marker.width, _self.settings.marker.height)
            }
        });

        if (marker.content) {
            var template = _global.fillTemplate( BrooksTheme.Data.Map.templates[marker.content.template], marker.content.data),
                offset =  new google.maps.Size(-_self.settings.infowindow.offset.x, -_self.settings.infowindow.offset.y );

            mapMarker.openOffset = {
                x: _self.settings.infowindow.openOffset.x,
                y: _self.settings.infowindow.openOffset.y
            }

            if(marker.content.size) {
                template = _global.fillTemplate( template, marker.content.size);
                offset = new google.maps.Size(-marker.content.size.width/2, - (_self.settings.infowindow.offset.y - _self.settings.infowindow.height + marker.content.size.height) );

                mapMarker.openOffset.y = marker.content.size.height/2 + _self.settings.marker.height/2 - _self.settings.infowindow.bottomSpacing;
            }

            mapMarker.infobox = new InfoBox({
                content: template,
                disableAutoPan: true,
                pixelOffset: offset,
                position: new google.maps.LatLng(marker.latitude, marker.longitude),
                isHidden: false,
                closeBoxURL: "",
                pane: "floatPane",
                enableEventPropagation: false
            });

            mapMarker.infobox.open(_self.map, mapMarker);
            mapMarker.infobox.hide();
        }


        mapMarker.marker = new InfoBox({
            draggable: true,
            content: marker.markup || _self.settings.marker.markup,
            disableAutoPan: true,
            pixelOffset: new google.maps.Size( -_self.settings.marker.width/2, -_self.settings.marker.height/2 ),
            position: mapMarker.getPosition(),
            closeBoxURL: "",
            isHidden: false,
            pane: "floatPane",
            enableEventPropagation: true
        });

        mapMarker.postID = marker.ID || null;

        mapMarker.marker.open(_self.map, mapMarker);
        var markerIndex = _self.markers.push(mapMarker) - 1;

        google.maps.event.addListener( mapMarker, 'click', function (e) {

            if (mapMarker.infobox) {
                var position = new google.maps.LatLng(mapMarker.getPosition().lat(), mapMarker.getPosition().lng());

                _self.map.panTo(position);
                _self.map.panBy( -mapMarker.openOffset.x, -mapMarker.openOffset.y );

                _self.markers.forEach(function (oneMarker, i) {
                    if (i == markerIndex)
                        return;

                    oneMarker.infobox.hide();
                });

                mapMarker.infobox.show();
            }

        });

        return mapMarker;
    }

    BrooksTheme.Map.prototype.markerExist = function(newMarker){
        var markerExist = this.markers.filter(function(marker){ return marker.postID == newMarker.ID });

        if(markerExist.length)
            return markerExist.shift();

        return false;
    }

    BrooksTheme.Map.prototype.initStyles = function(){
        var styles = [
            {
                featureType: "all",
                elementType: "geometry.stroke",
                stylers: [
                    { visibility: "off" }
                ]
            },
            {
                featureType: "road",
                elementType: "labels.icon",
                stylers: [
                    { visibility: "off" }
                ]
            },
            {
                featureType: "water",
                elementType: "labels",
                stylers: [
                    { visibility: "off" }
                ]
            },
            {
                featureType: "poi",
                elementType: "labels.icon",
                stylers: [
                    { visibility: "off" }
                ]
            },
            {
                featureType: "landscape",
                elementType: "labels",
                stylers: [
                    { visibility: "off" }
                ]
            },
            {
                featureType: "transit.line",
                stylers: [
                    { visibility: "off" }
                ]
            },
            {
                featureType: "transit.station",
                elementType: "labels",
                stylers: [
                    { visibility: "off" }
                ]
            }
        ];

        if(map_mode == 'normal')
            styles = styles.concat([
                {
                    featureType: "all",
                    stylers: [
                        { hue: mainColor },
                        { saturation: (!map_grey)?0:-100 },
                        { lightness: 0 },
                    ]
                },
                {
                    featureType: "all",
                    elementType: "labels.text.fill",
                    stylers: [
                        { color: mainColor },
                        { lightness: -50 },
                        { saturation: (!map_grey)?50:-100 },
                    ]
                },


                //All Land Colors
                {
                    featureType: "administrative",
                    elementType: "geometry",
                    stylers: [
                        { hue: mainColor },
                        { lightness: 0 },
                        { saturation: (!map_grey)?50:-100 },
                    ]
                },
                {
                    featureType: "transit",
                    elementType: "geometry",
                    stylers: [
                        { hue: mainColor },
                        { lightness: 0 },
                        { saturation: (!map_grey)?50:-100 },
                    ]
                },
                {
                    featureType: "poi",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: mainColor },
                        { lightness: 0 },
                        { saturation: (!map_grey)?50:-100 },
                    ]
                },
                {
                    featureType: "landscape",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: mainColor },
                        { lightness: 0 },
                        { saturation: (!map_grey)?50:-100 },
                    ]
                },
                //All Land Colors END


                {
                    featureType: "water",
                    elementType: "geometry",
                    stylers: [
                        { lightness: -50},
                        { saturation: (!map_grey)?-25:-100 },
                    ]
                },
                {
                    featureType: "road",
                    elementType: "geometry",
                    stylers: [
                        { lightness: 100},
                    ]
                },
                {
                    featureType: "all",
                    elementType: "labels.text.stroke",
                    stylers: [
                        { lightness: 100},
                    ]
                }
            ]);
        else if(map_mode == 'dark')
            styles = styles.concat([
                {
                    featureType: "all",
                    elementType: "geometry",
                    stylers: [
                        { hue: mainColor },
                        { lightness: -50 },
                        { saturation: (!map_grey)?-25:-100 },
                    ]
                },
                {
                    featureType: "all",
                    elementType: "labels.text.fill",
                    stylers: [
                        { lightness: 100 },
                    ]
                },

                //All Land Colors
                {
                    featureType: "administrative",
                    elementType: "geometry",
                    stylers: [
                        { hue: mainColor },
                        { lightness: -50 },
                        { saturation: (!map_grey)?-25:-100 },
                    ]
                },
                {
                    featureType: "transit",
                    elementType: "geometry",
                    stylers: [
                        { hue: mainColor },
                        { lightness: -50 },
                        { saturation: (!map_grey)?-25:-100 },
                    ]
                },
                {
                    featureType: "poi",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: mainColor },
                        { lightness: -50 },
                        { saturation: (!map_grey)?-25:-100 },
                    ]
                },
                {
                    featureType: "landscape",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: mainColor },
                        { lightness: -50 },
                        { saturation: (!map_grey)?-25:-100 },
                    ]
                },
                //All Land Colors END



                {
                    featureType: "water",
                    elementType: "geometry",
                    stylers: [
                        { hue: mainColor },
                        { lightness: 50 },
                        { saturation: (!map_grey)?-50:-100 },
                    ]
                },
                {
                    featureType: "road",
                    elementType: "geometry",
                    stylers: [
                        { color: mainColor },
                        { lightness: -50 },
                        { saturation: (!map_grey)?-25:-100 },
                    ]
                },
                {
                    featureType: "all",
                    elementType: "labels.text.stroke",
                    stylers: [
                        { color: mainColor },
                        { lightness: -50 },
                        { saturation: (!map_grey)?-25:-100 },
                    ]
                }
            ]);

        else if(map_mode == 'light')
            styles = styles.concat([
                {
                    featureType: "all",
                    elementType: "geometry",
                    stylers: [
                        { hue: mainColor },
                        { lightness: 75 },
                        { saturation: (!map_grey)?50:-100 },
                    ]
                },
                {
                    featureType: "all",
                    elementType: "geometry.stroke",
                    stylers: [
                        { color: mainColor },
                        { lightness: -25 },
                        { saturation: (!map_grey)?0:-100 },
                        { visibility: "on" }
                    ]
                },
                {
                    featureType: "all",
                    elementType: "labels.text.fill",
                    stylers: [
                        { lightness: 100 },
                    ]
                },
                {
                    featureType: "all",
                    elementType: "labels.text.stroke",
                    stylers: [
                        { color: mainColor },
                        { lightness: -25 },
                        { saturation: (!map_grey)?0:-100 },
                        { visibility: "on" }
                    ]
                },

                //All Land Colors
                {
                    featureType: "administrative",
                    elementType: "geometry",
                    stylers: [
                        { hue: mainColor },
                        { lightness: 75 },
                        { saturation: (!map_grey)?50:-100 },
                    ]
                },
                {
                    featureType: "transit",
                    elementType: "geometry",
                    stylers: [
                        { hue: mainColor },
                        { lightness: 75 },
                        { saturation: (!map_grey)?50:-100 },
                    ]
                },
                {
                    featureType: "poi",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: mainColor },
                        { lightness: 75 },
                        { saturation: (!map_grey)?50:-100 },
                    ]
                },
                {
                    featureType: "landscape",
                    elementType: "geometry.fill",
                    stylers: [
                        { hue: mainColor },
                        { lightness: 75 },
                        { saturation: (!map_grey)?50:-100 },
                    ]
                },
                //All Land Colors END

                {
                    featureType: "water",
                    elementType: "geometry",
                    stylers: [
                        { hue: mainColor },
                        { lightness: -25 },
                        { saturation: (!map_grey)?-50:-100 },
                    ]
                },
                {
                    featureType: "road",
                    elementType: "geometry",
                    stylers: [
                        { color: mainColor },
                        { lightness: -25 },
                        { saturation: (!map_grey)?0:-100 },
                    ]
                },
            ]);

        return styles;
    }

    BrooksTheme.Map.init = function(){
        $('.theme__google__map__block').each( function() {
            var dataOptions = BrooksTheme.Data.Map[ $(this).attr('id') ] || {},
                instance = new BrooksTheme.Map( $(this), dataOptions );

            BrooksTheme.Map.settings.instances.push(instance);

            $(this).data('Map', instance);
            $(this).trigger('mapInit');
        });
    }


    $(document).ready(function() {
        BrooksTheme.Map.init();
    });
})(jQuery, window);