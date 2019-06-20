<?php
   ini_set('display_errors', 1);
   ini_set('display_startup_errors', 1);
   error_reporting(E_ALL);
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'moham');
   define('DB_PASSWORD', 'welcome');
   define('DB_DATABASE', 'Ultra');
   $db = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   if($db === false){
      die("ERROR: Could not connect. " . mysqli_connect_error());
  }
?>