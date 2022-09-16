<?php 

require "config.php";

$username = $_POST["username"];
$pass = $_POST["password"];
$pass = md5($pass);

$sql = "select * from user where username='$username' and pass='$pass'";

$result = query($sql);

if($user = $result->fetch_assoc()) {
	

	//echo $user["ID"];
	//print_r($_SESSION);
	$_SESSION["user_id"] = $user["ID"]; 
	
	header("location: ".SITE_URL."members.php");
	
	exit;
}
else {
	header("location: ".SITE_URL."login.php?incorrectpass");
	exit;
}


?>