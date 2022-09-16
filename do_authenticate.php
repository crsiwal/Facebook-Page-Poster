<?php 

	include "config.php";	
	
	global $fb;

	$helper = $fb->getRedirectLoginHelper();
	$permissions = ['email']; // Optional permissions

	$loginUrl = $helper->getLoginUrl(SITE_URL."fb-callback.php", $permissions);

	header("location: $loginUrl");
	exit;