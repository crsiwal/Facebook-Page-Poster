<?php 

header("location: login.php");
exit;

require "config.php";


$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // Optional permissions

$loginUrl = $helper->getLoginUrl(SITE_URL."fb-callback.php", $permissions);

header("location: $loginUrl");