<?php
/**
*PARAMETERS FETCH FOR FORM
**/
$m_mode="RESET PASSWORD (RP)";
?>


    <div class="container-fluid">
            <div class="block-header">
                <h2>USER MANAGER (UM) / <?php echo $m_mode;?></h2>
            </div>
            <!-- Vertical Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>
                                RESET PASSWORD
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
                            <form action="" method="POST">
                                <label for="user_id">Select User </label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <select id="user_id" name="user_id" class="form-control show-tick" data-live-search="true" required>
                                        <option value="">Please Select User</option>
                                        <?php
                                            $query=mysqli_query($mysqli,"SELECT uid,user_name,email FROM members WHERE user_group>='$user_group'") or die(mysqli_query($mysqli));
                                            while($row=mysqli_fetch_array($query))
                                            {
                                                echo $user_id==$row['email'] ? '<option value="'.$row['email'].'" selected>'.$row['user_name'].'</option>' : '<option value="'.$row['email'].'">'.$row['user_name'].'</option>';
                                            }
                                        ?>
                                        </select>
                                    </div>
                                </div>
                                <label for="npassword">New Password</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="password" id="npassword" name="npassword" class="form-control" placeholder="Enter your new password" required>
                                    </div>
                                </div>
                                <label for="npasswordc">Confirm New Password</label>
                                <div class="form-group">
                                    <div class="form-line">
                                        <input type="password" id="npasswordc" name="npasswordc" class="form-control" placeholder="Enter your new password again" required>
                                    </div>
                                </div>
                                <input type="hidden" name="cp_email" value="<?php echo $email;?>"/>
                                <button type="button" name="change_password" value="change_password" class="btn btn-block btn-lg btn-primary m-t-20 waves-effect" onclick="resetformhash(this.form, this.form.npassword, this.form.npasswordc)">RESET USER PASSWORD</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- #END# Vertical Layout -->
    </div>

<?php
if (isset($_POST['cp_pn'], $_POST['user_id'])) {
    $npassword = $_POST['cp_pn']; // The hashed password.
    $uemail = $_POST['user_id'];
    if (reset_password($uemail,$npassword, $mysqli) == true) {
        // Change success
        alert_sweet_success("User Password Updated Successfully!!! User Can Login with New Password!!!");
        //header("Location: ?act=login&pchange=1");
    } else {
        // Change failed
        alert_sweet_failed("Unable to Update Password, Please Contact Administrator!!!");
    }
} else {
    // The correct POST variables were not sent to this page.
    //alert_sweet_failed("Something went wrong, Contact Support!!!");
}
?>
