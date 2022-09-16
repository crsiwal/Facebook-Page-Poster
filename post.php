<?php 

set_time_limit(200);

include "config.php";

if(isset($_POST["text"]) && isset($_POST["pages"])) {

	$text = $_POST["text"];

	$pages = $_POST["pages"];
	
	$img = upload_img("file");

	foreach($pages as $page) {

		//todo upload image and generate the URL of $img
			
		//$img = 	"http://pramodjodhani.com/wp-content/uploads/2016/05/banner3.jpg";
		if(isset($_FILES["file"])) {

			if($img) {
				post_to_page_call($page , $text , $img);
			}
			else {
				post_to_page_call($page , $text );
			}

		}
		else {
			post_to_page_call($page , $text );
		}
	
	}
	
	header("location: members.php?success");
}
