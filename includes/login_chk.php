<?php
include_once 'db_connect.php';
include_once 'functions.php';
//My Secure Session Starts Here
//sec_session_start();
session_start();            // Start the PHP session 
    session_regenerate_id(true);
if (isset($_POST['log_email'], $_POST['log_p'])) {
    $email = $_POST['log_email'];
    $password = $_POST['log_p']; // The hashed password.
 	
 	/*$npass = password_hash($password, PASSWORD_BCRYPT);
    echo password_verify($npass, PASSWORD_BCRYPT);
    echo "<br>".$npass;*/
    $username=explode("@", $email);
    if(count($username)==1)
        $email=$email."@gcoej.ac.in";
    if (login($email, $password, $mysqli) == true) {
        // Login success 
        mysqli_query($mysqli,"UPDATE members SET last_login=NOW() WHERE email='$email'") or die(mysqli_error());
        header('Location: ../?act=home');
    } else {
        // Login failed 
        header('Location: ../?act=login&error=1');
    }
} else {
    // The correct POST variables were not sent to this page. 
    header('Location: ../?act=login&error=0');
}
