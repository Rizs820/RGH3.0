<?php
session_start();
session_regenerate_id(true);
include_once 'psl-config.php';
require 'PM/PHPMailerAutoload.php';
function sec_session_start() {
    $session_name = 'sec_session_id';
    session_name($session_name);

    $secure = true;
    $httponly = true;

    if (ini_set('session.use_only_cookies', 1) === FALSE) {
        header("Location: ../error.php?err=Could not initiate a safe session (ini_set)");
        exit();
    }

    $cookieParams = session_get_cookie_params();
    session_set_cookie_params($cookieParams["lifetime"],
        $cookieParams["path"],
        $cookieParams["domain"],
        $secure,
        $httponly);

    session_start();
    session_regenerate_id(true);
}


function login($email, $password, $mysqli) {

    if ($stmt = $mysqli->prepare("SELECT uid, password, user_active, user_group
        FROM members
       WHERE email = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();


        $stmt->bind_result($user_id, $db_password, $u_status, $u_role);
        $stmt->fetch();

        if ($stmt->num_rows == 1) {

		if($u_status == "on")
		{

                if (password_verify($password, $db_password)) {

                    $user_browser = $_SERVER['HTTP_USER_AGENT'];
                    $user_id = preg_replace("/[^0-9]+/", "", $user_id);
                    $_SESSION['user_id'] = $user_id;
                    $_SESSION['email'] = $email;

                    $_SESSION['login_string'] = hash('sha512',
                              $db_password . $user_browser);
                    $_SESSION['app_name']="CAPS";

                    return true;
                } else {
                    $now = time();
                    return false;
                }

        }
        else
        {
            alert_wr("Account Not Activated!!!","?act=login&err=3");
        }

        } else {

            return false;
        }
    }
}


function group_access($mysqli,$user_group, $module) {
    if ($stmt = $mysqli->prepare("SELECT uid FROM rights_group WHERE  rights_group.group_id= ? AND rights_group.access_list = ? LIMIT 1"))
    {
        $stmt->bind_param('ss', $user_group,$module);
        $stmt->execute();
        $stmt->store_result();


        $stmt->bind_result($uid1);
        $stmt->fetch();
        if ($stmt->num_rows == 1) {
                return 1;
        }
        else
            return 0;
    }


}


function user_access($mysqli,$user_id, $module) {
    if ($stmt = $mysqli->prepare("SELECT uid FROM rights_user WHERE  rights_user.user_id= ? AND rights_user.access_list = ? LIMIT 1"))
    {
        $stmt->bind_param('ss', $user_id,$module);
        $stmt->execute();
        $stmt->store_result();


        $stmt->bind_result($uid2);
        $stmt->fetch();
        if ($stmt->num_rows == 1) {
                return 1;
        }
        else
            return 0;
    }


}


function group_accessp($mysqli,$user_group, $module) {
    if ($stmt = $mysqli->prepare("SELECT uid FROM rights_group WHERE  rights_group.group_id= ? AND rights_group.access_list LIKE ? LIMIT 1"))
    {
        $module="%".$module."%";
        $stmt->bind_param('ss', $user_group,$module);
        $stmt->execute();
        $stmt->store_result();


        $stmt->bind_result($uid1);
        $stmt->fetch();
                if ($stmt->num_rows == 1) {
                return 1;
        }
        else
            return 0;
    }


}


function user_accessp($mysqli,$user_id, $module) {
    if ($stmt = $mysqli->prepare("SELECT uid FROM rights_user WHERE  rights_user.user_id= ? AND rights_user.access_list LIKE ? LIMIT 1"))
    {
        $module="%".$module."%";
        $stmt->bind_param('ss', $user_id,$module);
        $stmt->execute();
        $stmt->store_result();


        $stmt->bind_result($uid2);
        $stmt->fetch();
        if ($stmt->num_rows == 1) {
                return 1;
        }
        else
            return 0;
    }


}




function loging($email, $password, $mysqli) {

    if ($stmt = $mysqli->prepare("SELECT uid, password, status, role
        FROM members
       WHERE email = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();


        $stmt->bind_result($user_id, $db_password, $u_status, $u_role);
        $stmt->fetch();

        if ($stmt->num_rows == 1) {
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
                    return false;
                }

        } else {
            // No user exists.
            return false;
        }
    }
}


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
            // No user exists.
            return false;
        }
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
