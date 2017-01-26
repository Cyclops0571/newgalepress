@extends('layouts.html')

@section('head')
    @parent
@endsection

@section('body')
    <?php
    if (FALSE) {
        $googleMapSet = new GoogleMap();
    }
    ?>
    <style type="text/css">
        #map_canvas {
            height: 100%;
            width: 100%;
            position: fixed !important;
        }

        #zoomBtn {
            position: fixed;
            z-index: 9000000;
            bottom: 10%;
            width: 33px;
            height: 33px;
            left: 5%;
            font-size: 19px;
            line-height: 11px;
            color: #2980B9;
            border: 2px solid #2980B9;
            background-color: #FFF;
        }

        #zoomBtn:hover, #zoomBtn.clicked {
            color: #fff;
            background-color: #2980B9;
        }

        #zoomBtn.widget-icon.widget-icon-circle {
            webkit-box-shadow: none !important;
            -moz-box-shadow: none !important;
            box-shadow: none !important;
        }

        #zoomBtn span {
            line-height: 11px !important;
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
        var coordinates = <?php echo json_encode($initialLocation);?>;
        var initialLocation = new google.maps.LatLng(Number(coordinates.x), Number(coordinates.y));
        var browserSupportFlag = new Boolean();

        function initialize() {
            var myOptions = {
                zoom: 10,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
            var markerSet = [];
            var zoomBtn = document.getElementById("zoomBtn");
            <?php foreach($googleMapSet as $googleMap): ?>
                markerSet.push(
                    new google.maps.Marker({
                        position: new google.maps.LatLng({{$googleMap->Latitude}}, {{$googleMap->Longitude}}),
                        map: map,
                        draggable: false
                    })
            );
                    <?php endforeach; ?>
                    var locationImage = {
                        url: '/img/maps/bullet_blue.png',
                        // This marker is 20 pixels wide by 32 pixels tall.
                        size: new google.maps.Size(32, 32),
                        // The origin for this image is 0,0.
                        origin: new google.maps.Point(0, 0),
                        // The anchor for this image is the base of the flagpole at 0,32.
                        anchor: new google.maps.Point(0, 32)
                    };

            // Try W3C Geolocation (Preferred)
            if (navigator.geolocation) {
                browserSupportFlag = true;
                navigator.geolocation.getCurrentPosition(function (position) {
                            initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                            initialMarker = new google.maps.Marker({
                                position: initialLocation,
                                map: map,
                                draggable: false,
                                icon: locationImage,
                            });
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

            if (browserSupportFlag) {
                google.maps.event.addDomListener(zoomBtn, 'click', function () {
                    google.maps.event.addListener(map, 'bounds_changed', function () {
                        $('#zoomBtn').removeClass('clicked');
                    });
                    map.setCenter(initialLocation);
                    smoothZoom(map, 14, map.getZoom());

                    setTimeout(function () {
                        $('#zoomBtn').addClass('clicked');
                    }, 1250);

                    // zoomBtn.className = zoomBtn.className + " clicked";
                });
            }

            function handleNoGeolocation(errorFlag) {
                $("#zoomBtn").hide();
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
    <body class="bg-img-num1">
    <div id="map_canvas"></div>
    <a href="#" id="zoomBtn" class="widget-icon widget-icon-large widget-icon-circle"><span
                class="icon-location-arrow"></span></a>
    </body>
@endsection