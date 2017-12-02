<?php
//session_start();
session_regenerate_id(true);
date_default_timezone_set('Asia/Kolkata');


/********************************************************************************************
					LOGIN USER DETAILS FETCH
********************************************************************************************/
 if (isset($_SESSION['user_id'], $_SESSION['email'],$_SESSION['login_string'])) 
 {
 	$email = $_SESSION['email'];
 	$user_id = $_SESSION['user_id'];
 	if ($stmt = $mysqli->prepare("SELECT uid,user_name,user_mobile,user_dept,last_ip,last_login,user_group 
        FROM members
       WHERE email = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $email);  // Bind "$email" to parameter.
        $stmt->execute();    // Execute the prepared query.
        $stmt->store_result();
 
        // get variables from result.
        $stmt->bind_result($uid,$user_name,$user_mobile,$user_dept,$last_ip,$last_login,$user_group);
        $stmt->fetch();
 		//alert($pname);
 		//$m_pname=$user;
        if ($stmt->num_rows == 1) {

        }

 	}      
}
/********************************************************************************************
					END OF LOGIN USER DETAILS FETCH
********************************************************************************************/

/********************************************************************************************
					FORM POST FOR USER PROFILE UPDATE
********************************************************************************************/
if (isset($_POST['update_profile'])) 
{
	if (isset($_POST['pname'], $_POST['pmob'], $_POST['email'])) 
	{
		$p_pname=$_POST['pname'];
		$p_pmob=$_POST['pmob'];
		$p_paccod=$_POST['paccod'];
		$p_pcollege=$_POST['pcollege'];
		$p_pname=mysqli_real_escape_string($mysqli,$p_pname);
		$p_pname=htmlentities($p_pname);
		$p_pname=htmlspecialchars($p_pname);
		$p_pmob=mysqli_real_escape_string($mysqli,$p_pmob);
		$p_pmob=htmlentities($p_pmob);
		$p_pmob=htmlspecialchars($p_pmob);
		$p_paccod=mysqli_real_escape_string($mysqli,$p_paccod);
		$p_paccod=htmlentities($p_paccod);
		$p_paccod=htmlspecialchars($p_paccod);
		$p_pcollege=mysqli_real_escape_string($mysqli,$p_pcollege);
		$p_pcollege=htmlentities($p_pcollege);
		$p_pcollege=htmlspecialchars($p_pcollege);
		$p_uid=$_POST['uid'];
		$p_email=$_POST['email'];
		$role="User";
        $byuser=$email;
        $status="1";
        $upass='$2y$10$W4AOacFPGyFzZIHfGOyDDuSqZsv2d2iAdbP2.Bqhw/txynx2Og8pe';
		$query="INSERT INTO members (email, status, role, byuser, pname, pmob, paccod, pcollege, password) VALUES ('$p_email', '$status', '$role', '$byuser', '$p_pname', '$p_pmob', '$p_paccod', '$p_pcollege', '$upass')";
		/*$query="INSERT INTO members SET pname='$p_pname', pmob='$p_pmob', paccod='$p_paccod',pcollege='$p_pcollege' WHERE uid='$uid' AND email='$email'" */
		$result=mysqli_query($mysqli,$query) or die(mysqli_error()); 
		//alert($result);
		
		if($result)
		{
			/*$res1=mysqli_query($mysqli,"SELECT * FROM members WHERE email='$p_email' AND pmob='$p_pmob' AND pcollege='$p_pcollege' AND pname='$p_pname'") or die(mysqli_error());
			$row1=mysqli_fetch_array($res1);*/
			alert_wr("User Added Successfully!!!","./?act=user");
			//mysqli_free_result($mysqli,$result);
		}
		else
		{
			alert_wr("Unable to Add User, Please Contact Support!!!","./?act=user");
			//mysqli_free_result($mysqli,$result);
		}	
	}
	else
	{
		alert_wr("Wrong Post Variable, Please Contact Support!!!","./?act=user");
	}
	//alert($p_email);
	//$mysqli->query("INSERT INTO login_attempts(user_id, time) VALUES ('$user_id', '$now')");
	
}

        

/********************************************************************************************
					END OF FORM POST FOR USER PROFILE UPDATE
********************************************************************************************/





/********************************************************************************************
					END OF FORM POST FOR FORGOT PASSWORD
********************************************************************************************/


if (isset($_POST['user_fpass'], $_POST['fpass_email'], $_POST['log_password'])) 
{
	if (isset($_POST['fpass_email']))
	{ 
		$u_email=$_POST['fpass_email'];

$u_pass=$_POST['log_password'];
//alert($_POST['user_fpass']);
$password = $_POST['user_fpass'];
$password = password_hash($password, PASSWORD_BCRYPT);
//alert($password);
$result1=mysqli_query($mysqli,"SELECT * FROM members WHERE email='$u_email'") or die(mysqli_error());
if($row=mysqli_fetch_array($result1))
{
		$result=mysqli_query($mysqli,"UPDATE members SET password='$password' WHERE email='$u_email' ") or die(mysqli_error());
		if($result)
		{
			//$npassword=randomPassword(8,1,"lower_case,upper_case,numbers,special_symbols");
			mail_send($u_email,"eTARA Password Recovery - TechnoArena 2k17","fpass.php",$u_pass);			
			alert_wr("New Password Mailed to You. Please Check Mail!!!","./?act=login");
			//mysqli_free_result($mysqli,$result);
		}
		else
		{
			alert_wr("Unable to Process, Please Contact Support!!!","./?act=login");
			//mysqli_free_result($mysqli,$result);
		}
}
else
{
alert_wr("User does not exists, Please Register!!!","./?act=login");
}

	}
	else
	{
		alert_wr("Wrong Post Variable, Please Contact Support!!!","./?act=payment");	
	}
}


/********************************************************************************************
					END OF FORM POST FOR FORGOT PASSWORD
********************************************************************************************/

/********************************************************************************************
					END OF FORM POST FOR RESEND ACTIVATION
********************************************************************************************/


if (isset($_POST['react'])) 
{
	if (isset($_POST['email']))
	{ 
		$u_email=$_POST['email'];
		$result=mysqli_query($mysqli,"SELECT * FROM members WHERE email='$u_email' ") or die(mysqli_error());
		if($row=mysqli_fetch_array($result))
		{
		$access_token=$row['access_token'];
		mail_send($u_email,"eTARA Registration - TechnoArena 2k17 (For Participant)","reg_msg.php","https://gcoej.ac.in/etara?act=login&access_token=".$access_token);
            	alert_wr("Confirmation Mail Resent. Please Check Mail!!!","./?act=login&stat=5");
			//$npassword=randomPassword(8,1,"lower_case,upper_case,numbers,special_symbols");
			//mail_send($u_email,"eTARA Password Recovery - TechnoArena 2k17","fpass.php",$ff);			
			//alert($row['password'],"./?act=payment");
			//mysqli_free_result($mysqli,$result);
		}
		else
		{
			alert_wr("Something went wrong. Contact Admin!!!","./?act=login&stat=0");
			//mysqli_free_result($mysqli,$result);
		}
	}
	else
	{
		alert_wr("Wrong Post Variable, Please Contact Support!!!","./?act=login&assistance=true");	
	}
}


/********************************************************************************************
					END OF FORM POST FOR RESEND ACTIVATION
********************************************************************************************/