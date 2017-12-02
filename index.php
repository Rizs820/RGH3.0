<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include_once 'includes/fetch.php';


//session_start();            // Start the PHP session
date_default_timezone_set('Asia/Kolkata');
if(!isset($_COOKIE['rm0301stat'])) {
    $rm_theme_color="theme-black";
    $rm_theme="black";
} else {
    $rm_theme_color="theme-".base64_decode($_COOKIE['rm0301stat']);
    $rm_theme=base64_decode($_COOKIE['rm0301stat']);
    //echo "Value is: " . $_COOKIE[$cookie_name];
}
$user_request=$_GET["act_request"];
$errorc=$_GET["error"];
$my_secrete_code="RizMah0301+";
$my_page=$_GET["act"];


$path=explode("/", $my_page);
$act_path="";
$i=1;
foreach ($path as $s_path)
{
    if($i==count($path))
    {
        $act_path=$act_path.$s_path.".blaze.php";
    }
    else
    {
        $act_path=$act_path.$s_path.".inc.php/";
    }
    $i++;
}
if($my_page=="login")
    if (login_check($mysqli) == true)
        header("Location: ?act=home");

if($my_page!="login")
    if (login_check($mysqli) == false)
        if($_SESSION['passchange']==md5("1"))
        {
            $_SESSION['passchange']="";
            header("Location: ?act=login&pchange=1");
        }
        else
            header("Location: ?act=login");
else
    if (((login_check($mysqli) == true)&&($my_page==""))||((login_check($mysqli) == true)&&($my_page=="login")))
        header("Location: ?act=home");
if($my_page!="login")
    if (login_check($mysqli) == false)
        die("Something Went Wrong. Please contact Admin @ +91 9922592979");
if($err=="") $err=NULL;
if($stat=="") $stat=NULL;
if($access_token)
{
    mysqli_query($mysqli,"UPDATE members SET status=1 WHERE access_token='$access_token'");
    alert_wr("Account Activated, You may proceed to Login!!!","?act=login");
}

if($my_page!="login"&&$user_group!=1&&$my_page!="home")
{
    //alert($uid);
    //alert(user_access($mysqli,$uid,$my_page));
    if(!(user_access($mysqli,$uid,$my_page)==1||group_access($mysqli,$user_group,$my_page)==1))
            alert_wr("Invalid Access!!! Contact Admin to Get Access!!!","./");
}

if($my_page!="login"&&$user_group!=1&&$my_page!="home")
{
    //alert($uid);
    //alert(user_access($mysqli,$uid,$my_page));
    if(!(user_access($mysqli,$uid,$my_page)==1||group_access($mysqli,$user_group,$my_page)==1))
            die("Something Went Wrong. Please contact Admin @ +91 9922592979");
}

if($my_page=="login")
{
    include("login.inc.php");
}
else
{
    if($my_page)
    {
        $act_path="blaze/".$act_path;
    }
    /*else
    {
        header("Location: ./?act=home");
    }*/
    if($my_page=="common/reports/generate")
    {
        include("blaze/reports.inc.php/generate.blaze.php");
    }
    else
    {
        include("home.inc.php");
    }
}
if($my_page=="login"&&$errorc==1)
    alert("Invalid Username/Password or Account not Activated");
?>
