<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <style type="text/css">
        html { height:350px; }
        body { height:100%; margin: 0; padding: 0; }
        #map-canvas { height: 100%; }
    </style>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script type="text/javascript">
        function initialize() {
            var locations = {{ $json }};
            var mapOptions = {};
            var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
            var bounds = new google.maps.LatLngBounds();
            for(var i = 0; i < locations.length; i++)
            {
                var location = locations[i];
                var marker = new google.maps.Marker({
                    position: new google.maps.LatLng(location.lat, location.lng),
                    map: map,
                    title: location.description
                });
                bounds.extend(marker.position);
            }
            map.setCenter(bounds.getCenter());
            map.fitBounds(bounds);
        }
        google.maps.event.addDomListener(window, 'load', initialize);
    </script>
</head>
<body>
    <div id="map-canvas"/>
</body>
</html>