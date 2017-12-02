<?php 
/**
*PARAMETERS FETCH FOR FORM
**/

$myRequestArray=$_SESSION[$user_request];
//alert($myRequestArray[0]." ".$myRequestArray[1]);

?>


    <div class="container-fluid">
            <div class="block-header">
                <h2>LOCATION MANAGER (LM) / GET LOCATION</h2>
            </div>    
            <!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Find Points of Interest
                            </h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="./?act=home">Back to Home</a></li>
                                        <li><a href="#" onclick='location.reload(true); return false;'>Reset/Reload</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <form  method="POST" name="frm_ser" action="./?act=location/modify">
                                
                                <label for="user_loc">Select Locality</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select id="user_loc" name="user_loc" class="form-control show-tick" data-live-search="true" required>
                                        <option value="">Please Select Locality</option>
                                        <?php
                                            $query=mysqli_query($mysqli,"SELECT name FROM locality") or die(mysqli_error($mysqli));
                                            while($row=mysqli_fetch_array($query))
                                            {
                                                echo $user_dept==$row['name'] ? '<option value="'.$row['name'].'" selected>'.$row['name'].'</option>' : '<option value="'.$row['name'].'">'.$row['name'].'</option>';
                                            }
                                        ?>
                                        
                                    </select>
                                    </div>
                                </div>
                               <input type="hidden"  name="lat1" id="lat1">
                                 <input type="hidden"  name="lat2" id="lat2">
                                <button type="submit" name="submit" value="By Locality" class="btn btn-block btn-lg btn-primary m-t-20 waves-effect" value="By Locality">Get POIs By Locality </button>
                                 <button type="submit" name="submit" value="add_user" class="btn btn-block btn-lg btn-primary m-t-20 waves-effect">Get POIs Near Me</button>
                               
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Vertical Layout -->
    </div>
    
 <script>
      // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.
      var map, infoWindow;
      function initMap() {
        
       // infoWindow = new google.maps.InfoWindow;

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
            //infoWindow.open(map);
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