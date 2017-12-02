   <?php
    $lat=floatval($_POST['lat1']);
    $lng=floatval($_POST["lat2"]);
    /*$lat=24.5764421;
    $lng=73.6835109;*/
   $locality=$_POST['user_loc'];
   //alert($locality);
   //SELECT id, ( 3959 * acos( cos( radians(37) ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(-122) ) + sin( radians(37) ) * sin( radians( lat ) ) ) ) AS distance FROM pois HAVING distance < 25 ORDER BY distance LIMIT 0 , 20;
   ?>
    <div class="container-fluid">
            <div class="block-header">
                <h2>LOCATION MANAGER (LM) / VIEW POIs (V)</h2>
            </div>    
            <?php
            if($_POST['submit']=="By Locality")
            {
            ?>
             <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                VIEW POIs
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
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Locality</th>
                                        <th>Guides</th>
                                        <th>Ratings</th>
                                        <th>Booking</th>
                
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Locality</th>
                                        <th>Guides</th>
                                        <th>Ratings</th>
                                        <th>Booking</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php 
                                        $query = mysqli_query($mysqli,"SELECT * FROM pois WHERE locality = '$locality' ORDER BY id") or die(mysqli_error($mysqli));
                                        
                                            while ($row=mysqli_fetch_array($query))
                                            {
                                                $query1 = mysqli_query($mysqli,"SELECT * FROM guides WHERE locality='$locality'")or die(mysqli_error($mysqli));
                                                 $guidec=mysqli_num_rows($query1);
                                                echo '<tr>';
                                                echo '<td>'.$row['name'].'</td>';
                                                echo '<td>'.$locality.'</td>';
                                                echo '<td>'.$guidec.'</td>';
                                                echo '<td>'.$row['rating'].'</td>';
                                                 echo '<td><form method="POST" action="./?act=location/book"><input type="hidden" id="request_opr'.$uid.'" value="Book_Guide"><input type="hidden" id="request_id'.$uid.'" name="request_id" value="'.UUID::v4().'"><input type="hidden" id="uid_val'.$row['locality'].'" name="uid_val" value="'.$row['locality'].'"><button type="submit" class="btn bg-light-green waves-effect" id="Book_Action" name="Book_Action" value="'.$row['locality'].'"><i class="material-icons ">BOOK NOW</i></button></form></td>';
                                                echo '</tr>';
            
                                            }
                                        
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
            <?      
            } 
            else
            {
            ?>
            <!-- Exportable Table -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                VIEW POIs
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
                            <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Locality</th>
                                        <th>Distance</th>
                                        <th>Guides</th>
                                        <th>Ratings</th>
                                        <th>Booking</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Locality</th>
                                        <th>Distance</th>
                                        <th>Guides</th>
                                        <th>Ratings</th>
                                        <th>Booking</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php 
                                        $qt="SELECT id,name,rating,locality, ( 6371 * acos( cos( radians(".$lat.") ) * cos( radians( lat ) ) * cos( radians( lng ) - radians(".$lng.") ) + sin( radians(".$lat.") ) * sin( radians( lat ) ) ) ) AS distance  FROM pois HAVING distance < 2500 ORDER BY distance";
                                        $query = mysqli_query($mysqli,$qt) or die(mysqli_error($mysqli));
                                        
                                            while ($row=mysqli_fetch_array($query))
                                            {
                                                $locality=$row['locality'];
                                                 $query1 = mysqli_query($mysqli,"SELECT * FROM guides WHERE locality='$locality'")or die(mysqli_error($mysqli));
                                                 $guidec=mysqli_num_rows($query1);
                                                  
                                                echo '<tr>';
                                                echo '<td>'.$row['name'].'</td>';
                                                echo '<td>'.$row['locality'].'</td>';
                                                echo '<td>'.round($row['distance'],2).'</td>';
                                                echo '<td>'.$guidec.'</td>';
                                                echo '<td>'.$row['rating'].'</td>';
                                                echo '<td><form method="POST" action="./?act=location/book"><input type="hidden" id="request_opr'.$uid.'" value="Book_Guide"><input type="hidden" id="request_id'.$uid.'" name="request_id" value="'.UUID::v4().'"><input type="hidden" id="uid_val'.$row['locality'].'" name="uid_val" value="'.$row['locality'].'"><button type="submit" class="btn bg-light-green waves-effect" id="Book_Action" name="Book_Action" value="'.$row['locality'].'"><i class="material-icons ">BOOK NOW</i></button></form></td>';
                                                echo '</tr>';
            
                                            }
                                        
                                    ?>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Exportable Table -->
            <?php
            }
            ?>
    </div>
    
