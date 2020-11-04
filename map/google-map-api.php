<!DOCTYPE html>
<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html {
        height: 100%;
        margin: 0;
        padding: 0;
		text-align: center;
      }

      #map {
        height: 500px;
        width: 600px;
      }
    </style>
  </head>
  <body>
  <div id="map"></div>
    <script>

		var locations = [
		  ['วัดลาดปลาเค้า', 13.846876, 100.604481],
		  ['หมู่บ้านอารียา', 13.847766, 100.605768],
		  ['สปีดเวย์', 13.845235, 100.602711],
		  ['สเต็ก ลุงหนวด',13.862970, 100.613834]
		];

      function initMap() {
			var mapOptions = {
			  center: {lat: 13.847860, lng: 100.604274},
			  zoom: 15,
			}
			var maps = new google.maps.Map(document.getElementById("map"),mapOptions);
			
			var marker, i, info;

			for (i = 0; i < locations.length; i++) {  

				marker = new google.maps.Marker({
				   position: new google.maps.LatLng(locations[i][1], locations[i][2]),
				   map: maps,
				   title: locations[i][0]
				});

				info = new google.maps.InfoWindow();

			  google.maps.event.addListener(marker, 'click', (function(marker, i) {
				return function() {
				  info.setContent(locations[i][0]);
				  info.open(maps, marker);
				}
			  })(marker, i));

			}

		}
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtg-A7QGCqUpaDDHD4ptDhzp2GLvPj-BU&callback=initMap"
    async defer></script>
  </body>
</html>