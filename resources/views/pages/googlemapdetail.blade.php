@extends('layouts.master')

@section('content')
    <?php
    if (FALSE) {
        $googleMap = new GoogleMap();
    }


    if ($googleMap) {
        $ApplicationID = $googleMap->ApplicationID;
        $GoogleMapID = $googleMap->GoogleMapID;
        $Name = $googleMap->Name;
        $Address = $googleMap->Address;
        $Description = $googleMap->Description;
        $Latitude = $googleMap->Latitude;
        $Longitude = $googleMap->Longitude;
    } else {
        $GoogleMapID = 0;
        $Name = '';
        $Address = '';
        $Description = '';
        $Latitude = 0;
        $Longitude = 0;
    }
    ?>
    <style type="text/css">
        #map_canvas {
            height: 600px;
        }

        .gm-style-mtc {
            border: 1px solid #2980B9;
        }

        .gm-style-mtc div {
            padding: 2px 6px !important;
            height: 20px !important;
        }

        .gm-style-mtc * {
            border: none !important;
            text-shadow: none !important;
            color: #2980B9 !important;
        }

        .gm-style-mtc[style="float: left;"]:nth-child(1) {
            border-right: 2px solid #2980B9 !important;
            -webkit-border-top-left-radius: 4px;
            -webkit-border-bottom-left-radius: 4px;
            -moz-border-radius-topleft: 4px;
            -moz-border-radius-bottomleft: 4px;
            border-top-left-radius: 4px;
            border-bottom-left-radius: 4px;
        }

        .gm-style-mtc[style="float: left;"]:nth-child(2) {
            border-left: 0px solid #2980B9 !important;
            -webkit-border-top-right-radius: 4px;
            -webkit-border-bottom-right-radius: 4px;
            -moz-border-radius-topright: 4px;
            -moz-border-radius-bottomright: 4px;
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }

        .gm-style-mtc > div[style*="font-weight"] {
            background: #2980B9 !important;
            color: #fff !important;
        }
    </style>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript">
        var markerLat = Number({{$Latitude}});
        var markerLog = Number({{$Longitude}});
        var coordinates = <?php echo json_encode($initialLocation);?>;
        var initialLocation = new google.maps.LatLng(Number(coordinates.x), Number(coordinates.y));
        if (markerLat != 0 || markerLog != 0) {
            initialLocation = new google.maps.LatLng(markerLat, markerLog);
        }
        var browserSupportFlag = new Boolean();

        $(window).resize(function () {
            $('#map_canvas').css('height', $(this).height() - 110);
        });

        function initialize() {
            var myOptions = {
                zoom: 6,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

            var marker;
            if (markerLat != 0 || markerLog != 0) {
                marker = new google.maps.Marker({
                    position: new google.maps.LatLng(markerLat, markerLog),
                    map: map,
                    draggable: true
                });
            }
            myListener = google.maps.event.addListener(map, 'rightclick', function (event) {
                placeMarker(event.latLng);
            });

            // Try W3C Geolocation (Preferred)
            if (navigator.geolocation) {
                browserSupportFlag = true;
                navigator.geolocation.getCurrentPosition(function (position) {
                            initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                            map.setCenter(initialLocation);
                        }, function () {
                            handleNoGeolocation(browserSupportFlag);
                        },
                        {maximumAge: 600000, timeout: 3000}
                );
                // Try Google Gears Geolocation
            } else {
                browserSupportFlag = false;
                handleNoGeolocation(browserSupportFlag);
            }

            function handleNoGeolocation(errorFlag) {
                $("#zoomBtn").hide();
                map.setCenter(initialLocation);
            }

            function placeMarker(location) {
                if (marker) {
                    marker.setPosition(location);
                } else {
                    marker = new google.maps.Marker({
                        position: location,
                        map: map,
                        draggable: true
                    });
                }
                populateInputs(location);
            }

            function populateInputs(pos) {
                document.getElementById("latitude").value = pos.lat();
                document.getElementById("langitude").value = pos.lng();
            }
        }

        function smoothZoom(map, max, cnt) {
            if (cnt >= max) {
                return;
            } else {
                z = google.maps.event.addListener(map, 'zoom_changed', function (event) {
                    google.maps.event.removeListener(z);
                    smoothZoom(map, max, cnt + 1);
                });
                setTimeout(function () {
                    map.setZoom(cnt);
                }, 80);
            }
        }
        $(function () {
            initialize();
        })
    </script>
    <div class="col-xs-12 col-sm-7 col-md-9 col-lg-9">
        <div id="map_canvas"></div>
    </div>
    <div class="col-xs-12 col-sm-5 col-md-3 col-lg-3">

        <div class="block block-drop-shadow" style="min-width:264px;">
            <div class="header text-center">
                <span class="icon-map-marker" style="font-size:18px;"></span>
            </div>
            {{ Form::open(__('route.maps_detail'), 'POST') }}
            {{ Form::token() }}
            <input type="hidden" name="GoogleMapID" id="GoogleMapID" value="{{ $GoogleMapID }}"/>
            @if((int)Auth::user()->UserTypeID == eUserTypes::Customer)
                <input type="hidden" name="applicationID" id="ApplicationID" value="{{ $ApplicationID }}"/>
            @endif
            <div class="content np">
                <div class="list list-contacts">
                    <a href="#" class="list-item">
                        <div class="list-text">
                            <span class="list-text-name">{{__('common.map_form_name')}}:</span>

                            <div class="list-text-info">
                                <input type="text" id="name" name="name" value="{{$Name}}"/>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-item">
                        <div class="list-text">
                            <span class="list-text-name">{{__('common.map_form_address')}}:</span>

                            <div class="list-text-info">
                                <input type="text" id="address" name='address' value="{{$Address}}"/>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-item">
                        <div class="list-text">
                            <span class="list-text-name">{{__('common.map_form_desc')}}:</span>

                            <div class="list-text-info">
                                <input type="text" id="description" name='description' value="{{$Description}}"/>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-item">
                        <div class="list-text">
                            <span class="list-text-name">{{__('common.map_form_latitude')}}:</span>

                            <div class="list-text-info">
                                <input type="text" id="latitude" name='latitude' value="{{$Latitude}}"/>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-item">
                        <div class="list-text">
                            <span class="list-text-name">{{__('common.map_form_longitude')}}:</span>

                            <div class="list-text-info">
                                <input type="text" id="langitude" name='langitude' value="{{$Longitude}}"/>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-item text-center" style="padding:10px;">

                        <div class="btn-group">
                            <button type="button" style="max-width:95px;" class="btn"
                                    onclick="javascript:location.href='{{ route('maps_list', ['applicationID' => $ApplicationID] ) }}'">{{__('common.map_form_return')}}</button>
                            <button type="button" class="btn my-btn-send hide"
                                    id="zoomBtn">{{__('common.map_form_location')}}</button>
                            <button type="button" style="max-width:76px;" class="btn my-btn-success"
                                    onclick="cGoogleMap.save();">{{__('common.detailpage_save')}}</button>
                        </div>

                    </a>
                </div>
            </div>
            {{ Form::close() }}
        </div>

    </div>


@endsection