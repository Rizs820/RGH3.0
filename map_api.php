<!DOCTYPE html>
<html>
  <head>
    <title>Geolocation</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
  </head>
  <body>
    <?php

      echo $_POST['lat1']."\n";
      echo $_POST["lat2"];
    ?>
    <form method="POST">
    <input type="hidden"  name="lat1" id="lat1">
     <input type="hidden"  name="lat2" id="lat2">
     <input type="submit" name="submit" value="submit">

</form>
    <div id="map"></div>
    <script>
      // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.
      var map, infoWindow;
      function initMap() {
        
        infoWindow = new google.maps.InfoWindow;

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };
          
            //alert(position.coords.latitude);
            document.getElementById("lat1").value=position.coords.latitude;
            document.getElementById("lat2").value=position.coords.longitude;
            infoWindow.setPosition(pos);
            infoWindow.setContent('Location found.');
            infoWindow.open(map);
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }

  //    alert("Hi");
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCbZeKLxUIX3Bsp3jQsQjH-qfD3rLM_nvE&callback=initMap">
    </script>
  <?php
  echo $_COOKIE['latp'];
  ?>
  </body>
</html>