<?php
/********************************************************************************

Test POST PAGE is HERE For You

************************************************************************************/


include_once 'db_connect.php';
include_once 'functions.php';
//My Secure Session Starts Here
sec_session_start();

/********************************************************************************************
					FORM POST FOR EVENT REGISTRATION
********************************************************************************************/
if (isset($_POST['test'])) 
{
	/*
	$p_pname=$_POST['pname'];
	$p_pmob=$_POST['pmob'];
	$p_paccod=$_POST['paccod'];
	$p_pcollege=$_POST['pcollege'];
	$p_uid=$_POST['uid'];
	$p_email=$_POST['email'];
	*/
	alert_wr("Registered Successfully For The Event!!!","?act=home");	
	//alert($p_email);
	//$mysqli->query("INSERT INTO login_attempts(user_id, time) VALUES ('$user_id', '$now')");
	
	/*$result=mysqli_query($mysqli,"UPDATE members SET pname='$p_pname', pmob='$p_pmob', paccod='$p_paccod',pcollege='$p_pcollege' WHERE uid='$p_uid' AND email='$p_email'") or die(mysqli_error());
	//alert($result);
	if($result)
	{
		alert("Profile Update Successfully!!!");
		//mysqli_free_result($mysqli,$result);
	}
	else
	{
		alert("Unable to Update Profile, Please Contact Support!!!");
		//mysqli_free_result($mysqli,$result);
	}*/
}

        

/********************************************************************************************
					END OF FORM POST FOR EVENT REGISTRATION
********************************************************************************************/
?>