<?php 


error_reporting(E_ALL); 
ini_set('display_errors', 1);

function query($sql) {

	global $con;
	if ($result = $con->query($sql)) {
	
		//$user = $result->fetch_assoc();
		return $result;

	}
	else {
		echo "query failed: ".$sql;
		return false;
	}

}

function post_to_page() {
	?>
	<form action="post.php" method="post"  enctype="multipart/form-data" id="post_to_page_form">
  		
  		<div class="form-group">
  			<label>Caption:</label>
  			<textarea name="text" placeholder="Caption"  class="form-control"></textarea>
  		</div>
  		<!-- <div class="form-group">
  			<label>Image:</label>
  			<input type="file" name="mfile" class="form-control" id="fileupload" data-url="uploads/">
  		</div> -->
  		<span class="btn btn-success fileinput-button">
	        <i class="glyphicon glyphicon-plus"></i>
	        <span>Select file</span>
	        <!-- The file input field used as target for the file upload widget -->
	        <input id="fileupload" type="file" name="mfile[]" data-url="uploads/" >
    	</span>
    	<div id="progress" class="progress">
        	<div class="progress-bar progress-bar-success"></div>
   		</div>
    	<div id="files" class="files row"></div>


		<script type="text/javascript">
		$(function () {

			$('#fileupload').fileupload({
		        //url: url,
		        dataType: 'json',
		        done: function (e, data) {
		            console.log(data.result.mfile);
		            $.each(data.result.mfile, function (index, file) {
		            	console.log(file);
		            	//var html = "<div class='col-md-2'><img src='"+file.url+"'></div><div class='col-md-10'>"+file.name+"</div>";
		            	var html = "<div class='col-md-12'>"+file.name+"</div>";
		            	window.IMGURL = file.url;
		            	$('#files').append(html)
		                //$('<p/>').text(file.name).appendTo('#files');
		            });
		        },
		        progressall: function (e, data) {
		            var progress = parseInt(data.loaded / data.total * 100, 10);
		            $('#progress .progress-bar').css(
		                'width',
		                progress + '%'
		            );
		        }
		    }).prop('disabled', !$.support.fileInput)
		        .parent().addClass($.support.fileInput ? undefined : 'disabled');

		});
		</script>
  		<div class="form-group pages_group">
  			<label>Pages:</label><br>
  			<div class="clearfix">
  				<div class="row row_main">
  					
		  			<div class="col-md-4 label_select_all_all"><label><input type='checkbox' > Select all</label></div>	
		  			<div class="col-md-4 label_select_all_1"><label><input type='checkbox' > Select all from group 1</label></div>	
		  			<div class="col-md-4 label_select_all_2"><label><input type='checkbox' >Select all from group 2</label></div>	
  				</div>
  			</div>
  			<div class="row">
  				
  			<?php 
  				$pages = get_list_of_pages();

  				//$pages = stripslashes($pages);
  				foreach($pages as $page) {
  					$group = get_group($page['id']);
  					echo "<div class='col-md-4'>
  							<label class='group_label group_label_$group'><input type='checkbox' value='{$page['id']}' name='pages[]' />{$page['name']}</label>
  							</div>";
  				}
  			?>
  			</div>
  		</div>
  		
  		<div class="hidden_loader" style="display: none">
  			<img src="spinner.gif" width="40">
  			<span class="loader_current_span"></span>
  		</div>
  		<input type="submit" class="btn btn-primary" >
  	</form>
      <?php 
}

function authenticate_btn() {
	
	global $fb;

	$helper = $fb->getRedirectLoginHelper();
	$permissions = ['email', 'pages_manage_posts']; // Optional permissions
	$loginUrl = $helper->getLoginUrl(SITE_URL."fb-callback.php", $permissions);

	echo "<a href='$loginUrl' class='btn btn-primary btn-lg '>Click here to Authenticate</a>";

}


function authentication_done() {


	if(get_access_token()) {
		return true; 
	}		
	else {
		return false;
	}


}

function get_access_token() {

	$user_id = $_SESSION["user_id"];

	$res = query("select * from user where ID = $user_id");

	$user = $res->fetch_object();

	return $user->accesstoken;

}

function fb_logout_btn() {
	global $fb;

	try {
	  // Returns a `Facebook\FacebookResponse` object
	  $response = $fb->get('/me?fields=id,name', get_access_token() );
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
	  echo 'Graph returned an error: ' . $e->getMessage();
	  exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	  echo 'Facebook SDK returned an error: ' . $e->getMessage();
	  exit;
	}

	$user = $response->getGraphUser();
	$url = SITE_URL."fblogout.php";
	echo  "<div class='logout_div'> Logged in as <b>".$user['name']."</b>. <a href='$url'>Logout?</a> </div>";
	//print_r($user);

}

function fetch_page_tokens() {
	
	global $fb;
	global $con;
	
	$accounts = $fb->get("/me/accounts?limit=100" , get_access_token());

	$pages = array();

	$i = 0;

	$data = $accounts->getBody();

	$data = json_decode($data); 
	//print_r($data); exit;
	foreach($data->data as $page) {
		//print_r($page);
		$pages[$i]["id"] = $page->id;
		$pages[$i]["name"] = $page->name;
		$pages[$i]["access_token"] = $page->access_token;
		$i++;
	}
	//foreach()
	$str = serialize($pages);
	$str = $con->escape_string($str);

	$user_id = $_SESSION["user_id"];

	$sql = "update user set pages = '$str' where ID = $user_id";

	query($sql);

}

function get_list_of_pages() {

	global $con;
	$user_id = $_SESSION["user_id"];
	//echo $user_id;

	//$res = query("select * from user where ID = $user_id");
	if ($result = $con->query("select * from user where ID = $user_id")) {
		
		$val = $result->fetch_object();
		//$val = $val->pages;
		$pages = stripslashes($val->pages); 
		$pages = unserialize($pages);

		//echo "<pre>"; print_r($pages);exit;
		return $pages;
	}
	
}


function get_page_token($page_id) {
	$pages = get_list_of_pages();
	//print_r($pages);exit;
	foreach ($pages as $page) {
		if($page["id"] == $page_id) {
			return $page["access_token"];
		}
	}
	return -1;
}


function post_to_page_call($page_id , $text, $img=-1) {

	global $fb;

	$token = get_page_token($page_id);

	try {
	  // Returns a `Facebook\FacebookResponse` object
		$endpoint = "/$page_id/feed";
		$data = array (
	      'message' => $text,
	    );

		if($img != -1) {
			$data["url"] = $img; 
			$endpoint = "/$page_id/photos";
		}

	  	$response = $fb->post( $endpoint , $data ,$token);
	} 
	catch(Facebook\Exceptions\FacebookResponseException $e) {
	  echo 'Graph returned an error: ' . $e->getMessage();
	  exit;
	} 
	catch(Facebook\Exceptions\FacebookSDKException $e) {
	  echo 'Facebook SDK returned an error: ' . $e->getMessage();
	  exit;
	}
	$graphNode = $response->getGraphNode();
	return $graphNode;
}


function upload_img($name) {

	//echo "<br>aya<br>";
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES[$name]["name"]);
	$uploadOk = 1;
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	// Check if image file is a actual image or fake image
	//if(isset($_POST["submit"])) {
	    $check = getimagesize($_FILES[$name]["tmp_name"]);
	    if($check !== false) {
	        echo "File is an image - " . $check["mime"] . ".";
	        $uploadOk = 1;
	    } else {
	        echo "File is not an image.";
	        $uploadOk = 0;
	    }
	//}

	$filename = "uploads/".uniqid().".".$imageFileType;
	if($uploadOk) {
		move_uploaded_file($_FILES[$name]["tmp_name"], $filename );
	}
	return SITE_URL.$filename;

}


function get_group($page_id) {

	$group_2 = array(1770094666587590,
				856096284437163,
				728215767275060,
				1459985024268171,
				1510098452553570,
				569114653108950,
				218977238214028,
				367872266568740,
				173421922718123,
				331234329434,
				258094287233,
				210365303373,
				215089698880,
				48853225901,
				);

	$group_1 = array(237061733384801,
				587463591446307,
				1177619482269359,
				1067671126583004,
				1437009643227759,
				303452129811818,
				606227806129379,
				440714929407304,
				1470139639873856,
				494116824030329,
				1397037913887469,
				635237499848128,
				693213984022010,
				223064797850947,
				178367812316721,
				501870883182575,
				376948749069708,
				324679724314979,
				518742968153036,
				161488407276188,
				105693892858981,
				225298594164709,
				177694725620972,
				197461726967259,
				220486584643267,
				159846970749043,
				179570275431458,
				176828409038552,
				224237574255751,
				176607275724143,
				192153527479714,
				103615199706836,
				114893638556087,
				124992877525945,
				118978821469892,
				114472261922037,
				112449852113049,
				110768852268902,
				377480418076,
				391163555961,
				339511487659,
				278598349430,
				276186652652,
				283176816479,
				289357127208,
				262249041347,
				249570721252,
				208851989762,
				199148100853,
				207623637528,
				178861996698,
				181849667607,
				);

	if(in_array($page_id, $group_1 )) {
		return 1;
	}
	else {
		return 2;
	}

}