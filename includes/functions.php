<?php
session_start();            // Start the PHP session 
session_regenerate_id(true);
include_once 'psl-config.php';
require 'PM/PHPMailerAutoload.php';	//Mail Config
function sec_session_start() {
    $session_name = 'sec_session_id';   // Set a custom session name
    /*Sets the session name. 
     *This must come before session_set_cookie_params due to an undocumented bug/feature in PHP. 
     */
    session_name($session_name);
 
    $secure = true;
    // This stops JavaScript being able to access the session id.
    $httponly = true;
    // Forces sessions to only use cookies.
    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }
    // Gets current cookies params.
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"], 
        $cookieParams["domain"], 
        $secure,
        $httponly);
 
    session_start();            // Start the PHP session 
    session_regenerate_id(true);    // regenerated the session, delete the old one. 
}

/***********************************************************************************************************************************************
** Function Name : Login                                                                                                                      **
** Added By : Rizwan Syed                                                                                                                     **
** Date : 5/2/17                                                                                                                              **
** Description : This function will check the email and password against the database. Using the password_verify function rather than comparing the strings helps to prevent timing attacks. It will return true if there is a match                                                          **
***********************************************************************************************************************************************/

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

            /*if($u_role == "Publicity")
            {*/
                // Check if the password in the database matches
                // the password the user submitted. We are using
                // the password_verify function to avoid timing attacks.
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
                    // We record this attempt in the database
                    $now = time();
                    //$mysqli->query("INSERT INTO login_attempts(user_id, time) VALUES ('$user_id', '$now')");
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

/** 
*Function Name : User Group Access Check (group_access)
*Added By : Rizwan Syed
*Date:15/8/17
*Description : This function will check for User Group Access for Module
**/

function group_access($mysqli,$user_group, $module) {
    if ($stmt = $mysqli->prepare("SELECT uid FROM rights_group WHERE  rights_group.group_id= ? AND rights_group.access_list = ? LIMIT 1")) 
    {
        $stmt->bind_param('ss', $user_group,$module);  // Bind "$mypage" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
 
        // get variables from result.
        $stmt->bind_result($uid1);
        $stmt->fetch();
        //alert($pname);
        //$m_pname=$user;
        if ($stmt->num_rows == 1) {
                return 1;
        }
        else
            return 0;
    }


}

/** 
*Function Name : User  Access Check (user_access)
*Added By : Rizwan Syed
*Date:15/8/17
*Description : This function will check for User Access for Module
**/

function user_access($mysqli,$user_id, $module) {
    if ($stmt = $mysqli->prepare("SELECT uid FROM rights_user WHERE  rights_user.user_id= ? AND rights_user.access_list = ? LIMIT 1")) 
    {
        $stmt->bind_param('ss', $user_id,$module);  // Bind "$mypage" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
 
        // get variables from result.
        $stmt->bind_result($uid2);
        $stmt->fetch();
        //alert($pname);
        //$m_pname=$user;
        if ($stmt->num_rows == 1) {
                return 1;
        }
        else
            return 0;
    }


}

/** 
*Function Name : User Group Access Check -Parent  (group_accessp)
*Added By : Rizwan Syed
*Date:15/8/17
*Description : This function will check for User Group Access for Module
**/

function group_accessp($mysqli,$user_group, $module) {
    if ($stmt = $mysqli->prepare("SELECT uid FROM rights_group WHERE  rights_group.group_id= ? AND rights_group.access_list LIKE ? LIMIT 1")) 
    {
        $module="%".$module."%";
        $stmt->bind_param('ss', $user_group,$module);  // Bind "$mypage" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
 
        // get variables from result.
        $stmt->bind_result($uid1);
        $stmt->fetch();
        //alert($pname);
        //$m_pname=$user;
        if ($stmt->num_rows == 1) {
                return 1;
        }
        else
            return 0;
    }


}

/** 
*Function Name : User  Access Check - Parent(user_accessp)
*Added By : Rizwan Syed
*Date:15/8/17
*Description : This function will check for User Access for Module
**/

function user_accessp($mysqli,$user_id, $module) {
    if ($stmt = $mysqli->prepare("SELECT uid FROM rights_user WHERE  rights_user.user_id= ? AND rights_user.access_list LIKE ? LIMIT 1")) 
    {
        $module="%".$module."%";
        $stmt->bind_param('ss', $user_id,$module);  // Bind "$mypage" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
 
        // get variables from result.
        $stmt->bind_result($uid2);
        $stmt->fetch();
        //alert($pname);
        //$m_pname=$user;
        if ($stmt->num_rows == 1) {
                return 1;
        }
        else
            return 0;
    }


}



/***********************************************************************************************************************************************
** Function Name : Login        Google                                                                                                              **
** Added By : Rizwan Syed                                                                                                                     **
** Date : 5/2/17                                                                                                                              **
** Description : This function will check the email and password against the database. Using the password_verify function rather than comparing the strings helps to prevent timing attacks. It will return true if there is a match                                                          **
***********************************************************************************************************************************************/

function loging($email, $password, $mysqli) {
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $mysqli->prepare("SELECT uid, password, status, role 
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
        if($u_status == 1)
        {

            
                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    // XSS protection as we might print this value
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['email'] = $email;
                    // XSS protection as we might print this value
                    $_SESSION['login_string'] = hash('sha512', 
                              $db_password . $user_browser);
                    // Login successful.
                    return true;

        }
        else
        {
            alert_wr("Account Not Activated!!!","?act=login&err=3");
        }
            
        } else {
            // No user exists.
            alert_wr("Email Not Registered!!!","?act=login&err=1");
            return false;
        }
    }
}




/***********************************************************************************************************************************************
** Function Name : checkbrute                                                                                                                 **
** Added By : Rizwan Syed                                                                                                                     **
** Date : 5/2/17                                                                                                                              **
** Description :  This will log failed attempts and lock the user's account after five failed login attempts                                  **
***********************************************************************************************************************************************/
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

/***********************************************************************************************************************************************
** Function Name : login_check                                                                                                                **
** Added By : Rizwan Syed                                                                                                                     **
** Date : 5/2/17                                                                                                                              **
** Description :  The "login_string" SESSION variable has the user's browser information hashed together with the password. To check if they are equal, we use the hash_equals function to prevent timing attacks.                                                                         **
***********************************************************************************************************************************************/

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


/***********************************************************************************************************************************************
** Function Name : esc_url                                                                                                                    **
** Added By : Rizwan Syed                                                                                                                     **
** Date : 5/2/17                                                                                                                              **
** Description : To prevent the trouble with using the server variable unfiltered is that it can be used in a cross site scripting attack     **
***********************************************************************************************************************************************/

function esc_url($url) {
 
    if ('' == $url) {
        return $url;
    }
 
    $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
 
    $strip = array('%0d', '%0a', '%0D', '%0A');
    $url = (string) $url;
 
    $count = 1;
    while ($count) {
        $url = str_replace($strip, '', $url, $count);
    }
 
    $url = str_replace(';//', '://', $url);
 
    $url = htmlentities($url);
 
    $url = str_replace('&amp;', '&#038;', $url);
    $url = str_replace("'", '&#039;', $url);
 
    if ($url[0] !== '/') {
        // We're only interested in relative links from $_SERVER['PHP_SELF']
        return '';
    } else {
        return $url;
    }
}

//===================================================================================================================================//
//                                               FUCTION ALERT                                                                       //
//===================================================================================================================================//
//  Created By  :-                                                                                                                   //
//  Created Date:- 12/02/2017                                                                                                        //
//  Modify By   :-                                                                                                                   //
//  Modify Date :-                                                                                                                   //
//  Discription :- This is the function that is use for give the alert message about the data not inserted sucessfully.              //
//                 In this function we have to only 1 parameter where parameter having its own meanign.                              //
//                 Sach as,                                                                                                          //
//                 ===========================================================================================                       //
//                 $message  :- It is variable which is used for store the custome message that will shown to user.                  //
//===================================================================================================================================//
function alert($message)
{?>
    <script language="javascript">
        alert("<? echo $message;?>");
    </script> 
<?}
function alert_sweet_success($message)
{?>
    <script language="javascript">
        //swal("Success!!!","<? echo $message;?>","success");
        //location.reload();

        swal({title: "Success!!!", text: "<? echo $message;?>", type: "success"},
            function(){ 
            //location.reload();
            window.location.href = window.location.href.replace(/#.*$/, '');
        }
        );
    </script> 
<?}

function alert_sweet_success_wr($message,$url)
{?>
    <script language="javascript">
        //swal("Success!!!","<? echo $message;?>","success");
        //location.reload();

        swal({title: "Success!!!", text: "<? echo $message;?>", type: "success", html: true},
            function(){ 
            //location.reload();
            window.location.href = '<? echo $url;?>' ;
        }
        );
    </script> 
<?}


function alert_sweet_failed($message)
{?>
    <script language="javascript">
        //swal("Success!!!","<? echo $message;?>","success");
        //location.reload();

        swal({title: "Error Occured!!!", text: "<? echo $message;?>", type: "error", html: true},
            function(){ 
            //location.reload();
            window.location.href = window.location.href.replace(/#.*$/, '');
        }
        );
    </script> 
<?}

function alert_sweet_failed_wr($message,$url)
{?>
    <script language="javascript">
        //swal("Success!!!","<? echo $message;?>","success");
        //location.reload();

        swal({title: "Error Occured!!!", text: "<? echo $message;?>", type: "error", html: true},
            function(){ 
            //location.reload();
            window.location.href = '<? echo $url;?>';
        }
        );
    </script> 
<?}


function alert_wr($message,$url)
{?>
    <script language="javascript">
    alert("<? echo $message;?>");
    window.location.href='<? echo $url;?>';
    </script> 
<?}
function page_redirect($url)
{?>
    <script language="javascript">
    //swal("Success!!!","<? echo $message;?>","success");
    window.location.href='<? echo $url;?>';
    </script> 
<?}





if(!function_exists('hash_equals'))
{
    function hash_equals($str1, $str2)
    {
        if(strlen($str1) != strlen($str2))
        {
            return false;
        }
        else
        {
            $res = $str1 ^ $str2;
            $ret = 0;
            for($i = strlen($res) - 1; $i >= 0; $i--)
            {
                $ret |= ord($res[$i]);
            }
            return !$ret;
        }
    }
}



/***********************************************************************************************************************************************
** Function Name : Change Password                                                                                                           **
** Added By : Rizwan Syed                                                                                                                     **
** Date : 5/2/17                                                                                                                              **
** Description : This function will check the email and password against the database. Using the password_verify function rather than comparing the strings helps to prevent timing attacks. It will return true if there is a match                                                          **
***********************************************************************************************************************************************/

function change_password($email,$npassword, $opassword, $mysqli) {
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $mysqli->prepare("SELECT uid, password 
        FROM members
       WHERE email = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
        //alert($email);
        // get variables from result.
        $stmt->bind_result($user_id, $db_password);
        $stmt->fetch();
        //alert("$user_id");
        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts 
                
            //alert($password." ".$db_password);
                // Check if the password in the database matches
                // the password the user submitted. We are using
                // the password_verify function to avoid timing attacks.
                if (password_verify($opassword, $db_password)) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $nvpass = password_hash($npassword, PASSWORD_BCRYPT); 
                    
                    $result= mysqli_query($mysqli,"UPDATE members  SET password='$nvpass' WHERE uid='$user_id' AND email='$email'") or die(mysqli_error());
                    
                    if($result)
                    {
                        //mysqli_free_result($result);
                         // Change successful.
                        return true;
                    }
                    else
                    {
                        //mysqli_free_result($result);
                        return false;
                    }                    
                } else {
                    // Password is not correct
                    // We record this attempt in the database
                    //$now = time();
                    //$mysqli->query("INSERT INTO login_attempts(user_id, time) VALUES ('$user_id', '$now')");
                    return false;
                }
            
        } else {
            // No user exists.
            return false;
        }
    }
}



/***********************************************************************************************************************************************
** Function Name : Change Password                                                                                                           **
** Added By : Rizwan Syed                                                                                                                     **
** Date : 5/2/17                                                                                                                              **
** Description : This function will check the email and password against the database. Using the password_verify function rather than comparing the strings helps to prevent timing attacks. It will return true if there is a match                                                          **
***********************************************************************************************************************************************/

function reset_password($email,$npassword, $mysqli) {
    // Using prepared statements means that SQL injection is not possible. 
    if ($stmt = $mysqli->prepare("SELECT uid, password 
        FROM members
       WHERE email = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
        //alert($email);
        // get variables from result.
        $stmt->bind_result($user_id, $db_password);
        $stmt->fetch();
        //alert("$user_id");
        if ($stmt->num_rows == 1) {
            // If the user exists we check if the account is locked
            // from too many login attempts 
                
            //alert($password." ".$db_password);
                // Check if the password in the database matches
                // the password the user submitted. We are using
                // the password_verify function to avoid timing attacks.
                //if (password_verify($opassword, $db_password)) {
                    // Password is correct!
                    // Get the user-agent string of the user.
                    $nvpass = password_hash($npassword, PASSWORD_BCRYPT); 
                    
                    $result= mysqli_query($mysqli,"UPDATE members  SET password='$nvpass' WHERE uid='$user_id' AND email='$email'") or die(mysqli_error());
                    
                    if($result)
                    {
                        //mysqli_free_result($result);
                         // Change successful.
                        return true;
                    }
                    else
                    {
                        //mysqli_free_result($result);
                        return false;
                    }                    
                /*} else {
                    // Password is not correct
                    // We record this attempt in the database
                    //$now = time();
                    //$mysqli->query("INSERT INTO login_attempts(user_id, time) VALUES ('$user_id', '$now')");
                    return false;
                }*/
            
        } else {
            // No user exists.
            return false;
        }
    }
}

/***********************************************************************************************************************************************
** Function Name : Mail Sending                                                                                                 **
** Added By : Rizwan Syed                                                                                                                     **
** Date : 5/2/17                                                                                                                              **
** Description : Send Mail                                                          **
***********************************************************************************************************************************************/


function mail_send($email,$subject,$msgid,$para1)
{
//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = "md-in-58.webhostbox.net";
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 465;
//smtp sERVER
$mail->SMTPSecure = 'ssl';
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
$mail->Username = "no-reply@gcoej.ac.in";
//Password to use for SMTP authentication
$mail->Password = "4vAr#$=w;eQA";
//Set who the message is to be sent from
$mail->setFrom('no-reply@gcoej.ac.in', 'GCOEJ CAPS 2017-18');
//Set an alternative reply-to address
$mail->addReplyTo('admin@gcoej.ac.in', 'GCOEJ CAPS 2017-18');
//Set who the message is to be sent to
$mail->addAddress($email,$name);

//Set the subject line
$mail->Subject = $subject;
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
ob_start();
include $msgid;
$msg = ob_get_clean();
//$msg=include();
$mail->msgHTML($msg);




//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
   // echo "Mailer Error: " . $mail->ErrorInfo;
} else 
{
   // echo "Message sent!";

}
}
/**
*File Upload
**/
/**
 * uploadFile()
 * 
 * @param string $file_field name of file upload field in html form
 * @param bool $check_image check if uploaded file is a valid image
 * @param bool $random_name generate random filename for uploaded file
 * @return array
 */
function uploadFile ($file_field = null, $check_image = false, $random_name = false, $file_path) {
       
  //Config Section    
  //Set file upload path
  $path = $file_path; //with trailing slash
  //Set max file size in bytes
  $max_size = 100000000;
  //Set default file extension whitelist
  $whitelist_ext = array('jpg','png','gif','doc','docx','xls','xlsx','pdf','zip','rar');
  //Set default file type whitelist
  $whitelist_type = array('image/jpeg', 'image/png','image/gif');

  //The Validation
  // Create an array to hold any output
  $out = array('error'=>null);
               
  if (!$file_field) {
    $out['error'][] = "Please specify a valid form field name";           
  }

  if (!$path) {
    $out['error'][] = "Please specify a valid upload path";               
  }
       
  if (count($out['error'])>0) {
    return $out;
  }

  //Make sure that there is a file
  if((!empty($_FILES[$file_field])) && ($_FILES[$file_field]['error'] == 0)) {
         
    // Get filename
    $file_info = pathinfo($_FILES[$file_field]['name']);
    $name = $file_info['filename'];
    $ext = $file_info['extension'];
               
    //Check file has the right extension           
    if (!in_array($ext, $whitelist_ext)) {
      $out['error'][] = "Invalid file Extension";
    }
               
    //Check that the file is of the right type
    /*if (!in_array($_FILES[$file_field]["type"], $whitelist_type)) {
      $out['error'][] = "Invalid file Type";
    }*/
               
    //Check that the file is not too big
    if ($_FILES[$file_field]["size"] > $max_size) {
      $out['error'][] = "File is too big";
    }
               
    //If $check image is set as true
    /*if ($check_image) {
      if (!getimagesize($_FILES[$file_field]['tmp_name'])) {
        $out['error'][] = "Uploaded file is not a valid image";
      }
    }*/

    //Create full filename including path
    if ($random_name) {
      // Generate random filename
      $tmp = str_replace(array('.',' '), array('',''), uniqid());
                       
      if (!$tmp || $tmp == '') {
        $out['error'][] = "File must have a name";
      }     
      $newname = $tmp.'.'.$ext;                                
    } else {
        $newname = $name.'.'.$ext;
    }
               
    //Check if file already exists on server
    if (file_exists($path.$newname)) {
      $out['error'][] = "A file with this name already exists, Try Again !!!";
    }

    if (count($out['error'])>0) {
      //The file has not correctly validated
      return $out;
    } 

    if (move_uploaded_file($_FILES[$file_field]['tmp_name'], $path.$newname)) {
      //Success
      $out['filepath'] = $path;
      $out['filename'] = $newname;
      $out['filetype'] = $_FILES[$file_field]["type"];
      return $out;
    } else {
      $out['error'][] = "Server Error!";
    }
         
  } else {
    $out['error'][] = "No file uploaded";
    return $out;
  }      
}


/**
*Image Upload
**/
/**
 * uploadImage()
 * 
 * @param string $file_field name of file upload field in html form
 * @param bool $check_image check if uploaded file is a valid image
 * @param bool $random_name generate random filename for uploaded file
 * @return array
 */
function uploadImage ($file_field = null, $check_image = false, $random_name = false, $file_path) {
       
  //Config Section    
  //Set file upload path
  $path = $file_path; //with trailing slash
  //Set max file size in bytes
  $max_size = 100000000;
  //Set default file extension whitelist
  $whitelist_ext = array('jpg','png','gif','xlsx');
  //Set default file type whitelist
  $whitelist_type = array('image/jpeg', 'image/png','image/gif');

  //The Validation
  // Create an array to hold any output
  $out = array('error'=>null);
               
  if (!$file_field) {
    $out['error'][] = "Please specify a valid form field name";           
  }

  if (!$path) {
    $out['error'][] = "Please specify a valid upload path";               
  }
       
  if (count($out['error'])>0) {
    return $out;
  }

  //Make sure that there is a file
  if((!empty($_FILES[$file_field])) && ($_FILES[$file_field]['error'] == 0)) {
         
    // Get filename
    $file_info = pathinfo($_FILES[$file_field]['name']);
    $name = $file_info['filename'];
    $ext = $file_info['extension'];
               
    //Check file has the right extension           
    if (!in_array($ext, $whitelist_ext)) {
      $out['error'][] = "Invalid file Extension";
    }
    //alert($_FILES[$file_field]["type"]); 
    //Check that the file is of the right type
    /*if (!in_array($_FILES[$file_field]["type"], $whitelist_type)) {
      $out['error'][] = "Invalid file Type";
    }*/
               
    //Check that the file is not too big
    if ($_FILES[$file_field]["size"] > $max_size) {
      $out['error'][] = "File is too big";
    }
               
    //If $check image is set as true
    /*if ($check_image) {
      if (!getimagesize($_FILES[$file_field]['tmp_name'])) {
        $out['error'][] = "Uploaded file is not a valid image";
      }
    }*/

    //Create full filename including path
    if ($random_name) {
      // Generate random filename
      $tmp = str_replace(array('.',' '), array('',''), uniqid());
                       
      if (!$tmp || $tmp == '') {
        $out['error'][] = "File must have a name";
      }     
      $newname = $tmp.'.'.$ext;                                
    } else {
        $newname = $name.'.'.$ext;
    }
               
    //Check if file already exists on server
    if (file_exists($path.$newname)) {
      $out['error'][] = "A file with this name already exists, Try Again !!!";
    }

    if (count($out['error'])>0) {
      //The file has not correctly validated
      return $out;
    } 

    if (move_uploaded_file($_FILES[$file_field]['tmp_name'], $path.$newname)) {
      //Success
      $out['filepath'] = $path;
      $out['filename'] = $newname;
      $out['filetype'] = $_FILES[$file_field]["type"];
      return $out;
    } else {
      $out['error'][] = "Server Error!";
    }
         
  } else {
    $out['error'][] = "No file uploaded";
    return $out;
  }      
}



/**
*UUID Class
**/
class UUID {
  public static function v3($namespace, $name) {
    if(!self::is_valid($namespace)) return false;

    // Get hexadecimal components of namespace
    $nhex = str_replace(array('-','{','}'), '', $namespace);

    // Binary Value
    $nstr = '';

    // Convert Namespace UUID to bits
    for($i = 0; $i < strlen($nhex); $i+=2) {
      $nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
    }

    // Calculate hash value
    $hash = md5($nstr . $name);

    return sprintf('%08s-%04s-%04x-%04x-%12s',

      // 32 bits for "time_low"
      substr($hash, 0, 8),

      // 16 bits for "time_mid"
      substr($hash, 8, 4),

      // 16 bits for "time_hi_and_version",
      // four most significant bits holds version number 3
      (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x3000,

      // 16 bits, 8 bits for "clk_seq_hi_res",
      // 8 bits for "clk_seq_low",
      // two most significant bits holds zero and one for variant DCE1.1
      (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,

      // 48 bits for "node"
      substr($hash, 20, 12)
    );
  }

  public static function v4() {
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

      // 32 bits for "time_low"
      mt_rand(0, 0xffff), mt_rand(0, 0xffff),

      // 16 bits for "time_mid"
      mt_rand(0, 0xffff),

      // 16 bits for "time_hi_and_version",
      // four most significant bits holds version number 4
      mt_rand(0, 0x0fff) | 0x4000,

      // 16 bits, 8 bits for "clk_seq_hi_res",
      // 8 bits for "clk_seq_low",
      // two most significant bits holds zero and one for variant DCE1.1
      mt_rand(0, 0x3fff) | 0x8000,

      // 48 bits for "node"
      mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
  }

  public static function v5($namespace, $name) {
    if(!self::is_valid($namespace)) return false;

    // Get hexadecimal components of namespace
    $nhex = str_replace(array('-','{','}'), '', $namespace);

    // Binary Value
    $nstr = '';

    // Convert Namespace UUID to bits
    for($i = 0; $i < strlen($nhex); $i+=2) {
      $nstr .= chr(hexdec($nhex[$i].$nhex[$i+1]));
    }

    // Calculate hash value
    $hash = sha1($nstr . $name);

    return sprintf('%08s-%04s-%04x-%04x-%12s',

      // 32 bits for "time_low"
      substr($hash, 0, 8),

      // 16 bits for "time_mid"
      substr($hash, 8, 4),

      // 16 bits for "time_hi_and_version",
      // four most significant bits holds version number 5
      (hexdec(substr($hash, 12, 4)) & 0x0fff) | 0x5000,

      // 16 bits, 8 bits for "clk_seq_hi_res",
      // 8 bits for "clk_seq_low",
      // two most significant bits holds zero and one for variant DCE1.1
      (hexdec(substr($hash, 16, 4)) & 0x3fff) | 0x8000,

      // 48 bits for "node"
      substr($hash, 20, 12)
    );
  }

  public static function is_valid($uuid) {
    return preg_match('/^\{?[0-9a-f]{8}\-?[0-9a-f]{4}\-?[0-9a-f]{4}\-?'.
                      '[0-9a-f]{4}\-?[0-9a-f]{12}\}?$/i', $uuid) === 1;
  }
}