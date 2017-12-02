<?php
/**
 * These are the database login details
 */  
define("HOST", "localhost");     // The host you want to connect to.
/*
define("USER", "gcoejjif_etara");    // The database username. 
define("PASSWORD", "}n+T4R5-E^#-");    // The database password.
define("DATABASE", "etara_pub");    // The database name.
*/

define("USER", "gcoejjif_caps");    // The database username. 
define("PASSWORD", "}8a.NR3f4+A&");    // The database password. 
define("DATABASE", "gcoejjif_caps_hostel");    // The database name.

define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");
 
define("SECURE", TRUE);    // FOR DEVELOPMENT ONLY!!!!

/**
*These are the payment credentials
*/


/**
*These are the Google OAuth2.0 Credentials 
*/
//require_once ('libraries/Google/autoload.php');
//Insert your cient ID and secret 
//You can get it from : https://console.developers.google.com/
$client_id = '824490684083-c75pqp5i03ld7dd9sjiiq75uob72g9mg.apps.googleusercontent.com'; 
$client_secret = 'RkhjTsUyr8w-lmAqom6GUsBI';
$redirect_uri = 'http://gcoej.ac.in/caps/admin/';

/*******Google ******/
require_once 'libraries/Google/src/config.php';
require_once 'libraries/Google/src/Google_Client.php';
require_once 'libraries/Google/src/contrib/Google_PlusService.php';
require_once 'libraries/Google/src/contrib/Google_Oauth2Service.php'; 


//Google App Details
define('GOOGLE_APP_NAME', 'CAPS for GCoE, Jalgaon');
define('GOOGLE_OAUTH_CLIENT_ID', '824490684083-c75pqp5i03ld7dd9sjiiq75uob72g9mg.apps.googleusercontent.com');
define('GOOGLE_OAUTH_CLIENT_SECRET', 'RkhjTsUyr8w-lmAqom6GUsBI');
define('GOOGLE_OAUTH_REDIRECT_URI', 'http://gcoej.ac.in/caps/admin/');
define("GOOGLE_SITE_NAME", 'http://gcoej.ac.in');



/************************************************
  Make an API request on behalf of a user. In
  this case we need to have a valid OAuth 2.0
  token for the user, so we need to send them
  through a login flow. To do this we need some
  information from our API console project.
 ************************************************/
/*$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");*/

 $client = new Google_Client();
$client->setScopes(array('https://www.googleapis.com/auth/plus.login','https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/plus.me'));
$client->setApprovalPrompt('auto');

$plus       = new Google_PlusService($client);
$oauth2     = new Google_Oauth2Service($client);
//unset($_SESSION['access_token']);

/************************************************
  When we create the service here, we pass the
  client to it. The client then queries the service
  for the required scopes, and uses that when
  generating the authentication URL later.
 ************************************************/
//$service = new Google_Service_Oauth2($client);



/**
 * Icons for Dept. 
 */
  $icons = array
  (
  array("Civil","location_city"),
  array("Computer","laptop_mac"),
  array("Electrical","wb_incandescent"),
  array("ExTC","router"),
  array("Instrumentation","satellite"),
  array("Mechanical","local_car_wash"),
  array("Robotics","android"),
  array("Sports","golf_course")
  );

?>