<?php
/**
 * These are the database login details
 */  
define("HOST", "localhost");     // The host you want to connect to.

define("USER", "root");    // The database username. 
define("PASSWORD", "newroot");    // The database password.
define("DATABASE", "rgh3");    // The database name.

/*
define("USER", "gcoejjif_cdap");    // The database username. 
define("PASSWORD", "ek2.%y+RWsNM");    // The database password. 
define("DATABASE", "gcoejjif_cdap");    // The database name.
*/
define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");
 
define("SECURE", TRUE);    // FOR DEVELOPMENT ONLY!!!!

/**
*These are the payment credentials
*/


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