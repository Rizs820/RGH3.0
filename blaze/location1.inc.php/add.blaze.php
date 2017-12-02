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
                               
                                <button type="submit" name="add_user" value="add_user" class="btn btn-block btn-lg btn-primary m-t-20 waves-effect">Get POIs</button>
                               
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Vertical Layout -->
    </div>
    
