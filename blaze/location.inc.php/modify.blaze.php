   <?php

   $locality=$_POST['user_loc'];
   //alert($locality);
   ?>
    <div class="container-fluid">
            <div class="block-header">
                <h2>LOCATION MANAGER (LM) / VIEW POIs (V)</h2>
            </div>    
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
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Locality</th>
                                        <th>Guides</th>
                                        <th>Ratings</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php 
                                        $query = mysqli_query($mysqli,"SELECT * FROM pois WHERE locality = '$locality' ORDER BY id") or die(mysqli_error($mysqli));
                                        
                                            while ($row=mysqli_fetch_array($query))
                                            {
                                                echo '<tr>';
                                                echo '<td>'.$row['name'].'</td>';
                                                echo '<td>'.$locality.'</td>';
                                                echo '<td>'.$guidec.'</td>';
                                                echo '<td>'.$row['rating'].'</td>';
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
    </div>
    
