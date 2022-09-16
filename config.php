<?php 

require "Facebook/autoload.php";
require "functions.php";

if(!session_id()) {
    session_start();
}

define("SITE_URL" , "http://web5.adgyde.in/"); // Replace with the URL of your website 
define("APP_ID" , "1755328811518222"); // Replace with the Facebook app id
define("APP_SECRET" , "e3203bf5b2abbb581df82ced4e2b9afa"); // Replace with the Facebook secret key


define("DATABASE_HOST" , "localhost"); // Replace with the database host. Usually its localhost
define("DATABASE_NAME" , "fbpages"); //Replace with the database name
define("DATABASE_USER" , "root"); //Replace with the database username
define("DATABASE_PASS" , ""); //Repalce wit the database password



$fb = new \Facebook\Facebook([
  'app_id' => APP_ID,
  'app_secret' => APP_SECRET,
  'default_graph_version' => 'v2.10',
  //'default_access_token' => '{access-token}', // optional
]);


$con = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

if($con->connect_errno) {
    echo "Sorry, this website is experiencing problems.";
    echo "Error: Failed to make a MySQL connection, here is why: \n";
    echo "Errno: " . $mysqli->connect_errno . "\n";
    exit;
}



