<?php
session_start();            // Start the PHP session 
date_default_timezone_set('Asia/Kolkata');
include_once '../includes/db_connect.php';
$result=0;
$myrequest=array();
$url="";
$message="";
$redirect=0;
$request_id=$_POST['request_id'];
$uid_val=$_POST['uid_val'];
$request_opr=$_POST['request_opr'];
$rreason=$_POST['rreason'];

if($request_opr=="Edit_User")
{
	$myrequest[]=$request_opr;
	$myrequest[]=$uid_val;
	$_SESSION[$request_id]=$myrequest;
	$url="./?act=user/add&act_request=".$request_id;
	$redirect=1;
	$message=$uid_val;
}
elseif($request_opr=="Delete_Book") 
{
	$redirect=0;
	$query = "DELETE FROM booking WHERE uid = ?";
    $stmt = $mysqli->stmt_init();
    if(!$stmt->prepare($query))
    {
        $result=0;
		$message="Unable to Delete Booking!!! UID - ".$uid_val;
    }
    else
    {
		$stmt->bind_param('s', $uid_val);
		$stmt->execute(); 
		$stmt->close();
		$result=1;
		$message="Booking Deleted Successfully!!! UID - ".$uid_val;
		$url=$uid_val;
	}
}

echo json_encode(array("redirect" => $redirect, "url" => $url, "message" => $message, "result" => $result));
