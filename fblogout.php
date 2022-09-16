<?php 

include "config.php";

$user_id = $_SESSION['user_id'];
$sql = "update user set accesstoken = '', pages='' where ID = $user_id";

query($sql);

header("location: members.php");