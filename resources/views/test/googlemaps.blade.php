<!DOCTYPE html>
<html>
	<head>
		<?php
		/*
		 * 
		 * Users of the free API:
			2,500 requests per 24 hour period.
			5 requests per second.
			Google Maps API for Work customers:
			100,000 requests per 24 hour period.
			10 requests per second.
		 */ 
		?>
		<style type="text/css">
			html { height: 100% }
			body { height: 100%; margin: 0; padding: 0 }
			#map-canvas { height: 100% }
		</style>
		<script type="text/javascript"
				src="https://maps.googleapis.com/maps/api/js">
		</script>
		<script type="text/javascript">
			//?key=AIzaSyABU5W1OsqdgiUWDEQm8EMW_iuFpQQUMNE
            var map = null;
            function initialize() {
				var initialLocation = null;
				var locationMarker = null;
                var currentZoom = 2;
                var myLatLngSet = [];
                var mapOptions = {
                    zoom: currentZoom
                };
                map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                var myMarkerSet = [];
//                var imageSrcUrl = 'http://galepress.com/img/pin.png';
                var markerImage = {
                    url: 'http://galepress.com/img/pin.png',
                    // This marker is 20 pixels wide by 32 pixels tall.
                    size: new google.maps.Size(50, 62),
                    // The origin for this image is 0,0.
                    origin: new google.maps.Point(0, 0),
                    // The anchor for this image is the base of the flagpole at 0,32.
                    anchor: new google.maps.Point(0, 32)
                };
				var locationImage = {
                    url: 'http://www.galepress.com/img/maps/bullet_blue.png',
					// This marker is 20 pixels wide by 32 pixels tall.
                    size: new google.maps.Size(32, 32),
                    // The origin for this image is 0,0.
                    origin: new google.maps.Point(0, 0),
                    // The anchor for this image is the base of the flagpole at 0,32.
                    anchor: new google.maps.Point(0, 32)
				};
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function (position) {
                        initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                        map.setCenter(initialLocation);
                        myLatLngSet.push(initialLocation);
                        myLatLngSet.forEach(function (myLanLin) {
							var marker = null;
							if(myMarkerSet.length == 0) {
								locationMarker = myMarkerSet[0];
								marker = new google.maps.Marker({
									position: myLanLin,
									map: map,
									// This marker is 20 pixels wide by 32 pixels tall.
									title: 'Lat:' + myLanLin.lat() + " - Lon:" + myLanLin.lat(),
									icon: locationImage,
									animation: google.maps.Animation.DROP,
								});
							} else {
								marker = new google.maps.Marker({
									position: myLanLin,
									map: map,
									// This marker is 20 pixels wide by 32 pixels tall.
									title: 'Lat:' + myLanLin.lat() + " - Lon:" + myLanLin.lat(),
									icon: markerImage,
									animation: google.maps.Animation.DROP,
								});
							}
                            myMarkerSet.push(marker);
                        });
                        
//                        var infowindow = new google.maps.InfoWindow();
//                        myMarkerSet.forEach(function (myMarker) {
//                            google.maps.event.addListener(myMarker, 'click', function () {
//                                infowindow.open(map, myMarker);
//
//                            });
//                        });
                    });

                    var zoomBtn = document.getElementById("zoomBtn");
                    google.maps.event.addDomListener(zoomBtn, 'click', function () {
						if(initialLocation) {
							map.setCenter(initialLocation);
						} 
//						smoothZoom(map, 14, map.getZoom());
                        //map.setZoom(16);
                        smoothZoom(map, 16, map.getZoom());
                    });
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
		</script>
	</head>
	<body onload="initialize()">
		<input type="button" class="btn btn-info" id="zoomBtn" value="goToCurrentLocation" />
		<div id="map-canvas"></div>
	</body>
</html>