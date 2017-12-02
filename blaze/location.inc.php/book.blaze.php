<?php

$myRequestArray=$_SESSION[$user_request];

$locality=$_POST['uid_val'];
?>


    <div class="container-fluid">
            <div class="block-header">
                <h2>LOCATION MANAGER (LM) / Book Guide (G)</h2>
            </div>
            <!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                Book Guide
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
                            <form  method="POST" name="frm_ser" action="">

                                <label for="user_loc">Available Guides</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select id="user_loc" name="user_loc" class="form-control show-tick" data-live-search="true" required>
                                        <option value="">Please Select Your Local Guide</option>
                                        <?php
                                            $query=mysqli_query($mysqli,"SELECT user_name FROM guides WHERE locality='$locality'") or die(mysqli_error($mysqli));
                                            while($row=mysqli_fetch_array($query))
                                            {
                                                echo $book_guide==$row['user_name'] ? '<option value="'.$row['user_name'].'" selected>'.$row['user_name'].'</option>' : '<option value="'.$row['user_name'].'">'.$row['user_name'].'</option>';
                                            }
                                        ?>

                                    </select>
                                    </div>
                                </div>
                               <input type="hidden"  name="lat1" id="lat1">
                                 <input type="hidden"  name="lat2" id="lat2">
                                <button type="submit" name="book_guide" value="book_guide" class="btn btn-block btn-lg btn-primary m-t-20 waves-effect" value="By Locality">Book My Guide</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Vertical Layout -->
    </div>

 <script>
      var map, infoWindow;
      function initMap() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

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

    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCbZeKLxUIX3Bsp3jQsQjH-qfD3rLM_nvE&callback=initMap">
    </script>

<?php
//alert($user_name);
if(isset($_POST['book_guide']))
{
    $guide_d=$_POST['user_loc'];
    $nowt=date("Y-m-d h:i:s");
    $cs=0;
    $stmt = $mysqli->prepare("INSERT INTO booking(tourist,guide,book_time,confirmed) VALUES (?, ?, ?, ?)");
    $stmt->bind_param('ssss', $user_name, $guide_d, $nowt, $cs);
    if($stmt->execute())
        alert_sweet_success("Booking Success!!!");
    else
        alert_sweet_failed("Unable to Book!!! Try Again!!!");
    $stmt->close();
    $_REQUEST = $_POST = $_GET = NULL;
}
?>
