<?php
//session_start();
session_regenerate_id(true);
date_default_timezone_set('Asia/Kolkata');



 if (isset($_SESSION['user_id'], $_SESSION['email'],$_SESSION['login_string']))
 {
 	$email = $_SESSION['email'];
 	$user_id = $_SESSION['user_id'];
 	if ($stmt = $mysqli->prepare("SELECT uid,user_name,user_mobile,user_dept,last_ip,last_login,user_group
        FROM members
       WHERE email = ?
        LIMIT 1")) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();

        $stmt->bind_result($uid,$user_name,$user_mobile,$user_dept,$last_ip,$last_login,$user_group);
        $stmt->fetch();
 		//alert($pname);
 		//$m_pname=$user;
        if ($stmt->num_rows == 1) {

        }

 	}
}
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

}
