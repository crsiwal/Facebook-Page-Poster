<?php 

include "config.php";


if(isset($_POST["text"]) && isset($_POST["page_id"])) {
	echo "ok";

	$text = $_POST["text"];
	$page = $_POST["page_id"];


	if(isset($_POST["img"]) && $_POST["img"]) {
		post_to_page_call($page , $text , $_POST["img"]);
	}
	else {
		post_to_page_call($page , $text );
	}

	
	
}
