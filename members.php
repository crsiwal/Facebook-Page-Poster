<?php include "header.php"; ?>
  <div class="row">
    <div class="col-lg-12 text-center">
      <h1 class="mt-5">Post to pages</h1>
      
      <div class="post_to_page">
      	
      	<?php 

          if(isset($_GET["success"])) {
            echo "<p class='bg bg-success'>Post has been published</p>";
          }
      		if(authentication_done()) {
            include "ajax_paginator.php";
            //fetch_page_tokens();
            fb_logout_btn();
      		  //get_list_of_pages();
            post_to_page();


      	  }
      		else {
      			authenticate_btn();
      		}

      	?>


      </div>
      
    </div>
  </div>
  <script type="text/javascript">
    
    jQuery(".label_select_all_1 input").change(function() {
      var a = jQuery(this).prop("checked")
      jQuery(".group_label_1 input").prop("checked" , a);
    })
    jQuery(".label_select_all_all input").change(function() {
      var a = jQuery(this).prop("checked")
      jQuery(".group_label_1 input , .group_label_2 input").prop("checked" , a);
    })
    jQuery(".label_select_all_2 input").change(function() {
      var a = jQuery(this).prop("checked")
      jQuery(".group_label_2 input").prop("checked" , a);
    })

  </script>
<?php include "footer.php"; ?>
