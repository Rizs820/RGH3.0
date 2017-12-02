<?php
include_once 'db_connect.php';
include_once 'functions.php';
//My Secure Session Starts Here
sec_session_start();

/********************************************************************************************
					FORM POST FOR USER REGISTRATION
********************************************************************************************/

	$error_msg = "";
 
if (isset($_POST['email'], $_POST['p'])) {
    // Sanitize and validate the data passed in
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Not a valid email
        //$error_msg .= '<p class="error">The email address you entered is not valid</p>';
        $error_msg .= '1';
    }
 
    $password = filter_input(INPUT_POST, 'p', FILTER_SANITIZE_STRING);
    if (strlen($password) != 128) {
        // The hashed pwd should be 128 characters long.
        // If it's not, something really odd has happened
        //$error_msg .= '<p class="error">Invalid password configuration.</p>';
        $error_msg .= '2';
    }
 
    // Username validity and password validity have been checked client side.
    // This should should be adequate as nobody gains any advantage from
    // breaking these rules.
    //
 
    $prep_stmt = "SELECT uid FROM members WHERE email = ? LIMIT 1";
    $stmt = $mysqli->prepare($prep_stmt);
 
   // check existing email  
    if ($stmt) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
 
        if ($stmt->num_rows == 1) {
            // A user with this email address already exists
            //$error_msg .= '<p class="error">A user with this email address already exists.</p>';
            $error_msg .= '3';
                        $stmt->close();
        }
    } else {
        //$error_msg .= '<p class="error">Database error Line 39</p>';
        $error_msg .= '4';
                $stmt->close();
    }
 
    
    // TODO: 
    // We'll also have to account for the situation where the user doesn't have
    // rights to do registration, by checking what type of user is attempting to
    // perform the operation.
 
    if (empty($error_msg)) {
 
        // Create hashed password using the password_hash function.
        // This function salts it with a random salt and can be verified with
        // the password_verify function.
        $password = password_hash($password, PASSWORD_BCRYPT);
        $access_token = md5(uniqid(24));
        $role="Participant";
        $byuser="SELF";
        $status="0";
 		$query="INSERT INTO members (email, password, access_token, status, role, byuser) VALUES ('$email', '$password', '$access_token', '$status', '$role', '$byuser')";
 		$result=mysqli_query($mysqli,$query) or die(mysql_error());
 		if($result)
 		{
mail_send($email,"eTARA Registration - TechnoArena 2k17 (For Participant)","reg_msg.php","https://gcoej.ac.in/etara?act=login&access_token=".$access_token);
            alert_wr("Confirmation Mail Sent, Check Mail!!!","../?act=login&stat=5");
 			//header("Location: ../?act=login&stat=5"); 
 		}
 		else
 		{
            alert_wr("Something went wrong. Contact Admin!!!","../?act=login&stat=0");
 		     //header("Location: ../?act=login&stat=0");	
 		}
        // Insert the new user into the database 
        /*if ($insert_stmt = $mysqli->prepare("INSERT INTO members (email, password) VALUES (?, ?, ?)")) {
            $insert_stmt->bind_param('sss', $email, $password);
            // Execute the prepared query.
            if (! $insert_stmt->execute()) {
                header('Location: ../error.php?err=Registration failure: INSERT');
            }
        }
        header('Location: ./register_success.php');*/
    }
    else
    {
        header("Location: ../?act=login&stat=$error_msg");  
    }
}	

/********************************************************************************************
					END OF FORM POST FOR USER REGISTRATION
********************************************************************************************/
