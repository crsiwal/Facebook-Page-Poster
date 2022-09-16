<?php include "header.php"; ?>
  <div class="row">
    <div class="col-md-6 col-md-offset-3 text-center">
      <h1 class="mt-5">Login</h1>
      
      <div class="post_to_page">
      	<form action="checklogin.php" method="post">
      		<?php 
            if(isset($_GET["incorrectpass"])) {
              echo "<p class='bg bg-warning'>Incorrect credentials</p>";
            }
          ?>
      		<div class="form-group">
      			<label>Username:</label>
            <input type="text" name="username" class="form-control" placeholder="Username">
          </div>
          <div class="form-group">
            <label>Pass:</label>
      			<input type="password" name="password" class="form-control" placeholder="Password">
      		</div>

      		
      		<input type="submit" class="btn btn-primary" value="submit">

      	</form>


      </div>
      
    </div>
  </div>
<?php include "footer.php"; ?>
