<?php

session_start();            // Start the PHP session 
session_regenerate_id(true);
//include_once 'psl-config.php';
function login($email, $password, $mysqli) {
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $mysqli->prepare("SELECT uid, password, user_active, user_group 
        FROM members
       WHERE email = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
 
        // get variables from result.
        $stmt->bind_result($user_id, $db_password, $u_status, $u_role);
        $stmt->fetch();
 
        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts 
                
            //alert($password." ".$db_password);
		//Check for Activation
		if($u_status == "on")
		{
                // Check if the password in the database matches
                if (password_verify($password, $db_password)) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['email'] = $email;
                    // XSS protection as we might print this value
                    $_SESSION['login_string'] = hash('sha512', 
                              $db_password . $user_browser);
                    $_SESSION['app_name']="CAPS";
                    // Login successful.
                    return true;
                } else {
                    // Password is not correct
                    $now = time();
                    return false;
                }
            /*}
            else
            {
                alert_wr("You are not authorized to Login Here!!!","?act=login&err=0");
            }*/
        }
        else
        {
            alert_wr("Account Not Activated!!!","?act=login&err=3");
        }
            
        } else {
            // No user exists.
            return false;
        }
    }
}

function checkbrute($user_id, $mysqli) {
    // Get timestamp of current time 
    $now = time();
 
    // All login attempts are counted from the past 2 hours. 
    $valid_attempts = $now - (2 * 60 * 60);
 
    if ($stmt = $mysqli->prepare("SELECT time 
                             FROM login_attempts 
                             WHERE user_id = ? 
                            AND time > '$valid_attempts'")) {
        $stmt->bind_param('i', $user_id);
 
        // Execute the prepared query. 
        $stmt->execute();
        $stmt->store_result();
 
        // If there have been more than 5 failed logins 
        if ($stmt->num_rows > 5) {
            return true;
        } else {
            return false;
        }
    }
}

function login_check($mysqli) {
    // Check if all session variables are set 
    if (isset($_SESSION['user_id'], 
                        $_SESSION['email'], 
                        $_SESSION['login_string'],$_SESSION['app_name'])) {
 
        $user_id = $_SESSION['user_id'];
        $login_string = $_SESSION['login_string'];
        $email = $_SESSION['email'];
        $app_name = $_SESSION['app_name'];
 
        // Get the user-agent string of the user.
        $user_browser = $_SERVER['HTTP_USER_AGENT'];
       // alert($user_browser);
        if ($stmt = $mysqli->prepare("SELECT password,user_group 
                                      FROM members 
                                      WHERE uid = ? LIMIT 1")) {
            // Bind "$user_id" to parameter. 
            $stmt->bind_param('i', $user_id);
            $stmt->execute();   // Execute the prepared query.
            $stmt->store_result();
 
            if ($stmt->num_rows == 1) {
                // If the user exists get variables from result.
                $stmt->bind_result($password,$urole);
                $stmt->fetch();
                $login_check = hash('sha512', $password . $user_browser);
 if($app_name!="CAPS")
{
return false;
}
                if (hash_equals($login_check, $login_string) ){
                    // Logged In!!!! 
                    return true;
                } else {
                    // Not logged in 
                    return false;
                }
            } else {
                // Not logged in 
                return false;
            }
        } else {
            // Not logged in 
            return false;
        }
    } else {
        // Not logged in 
        return false;
    }
}

?>