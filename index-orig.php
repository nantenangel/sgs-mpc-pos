<?php
   require_once 'dbconfig.php';
   
   if ($user->is_loggedin()){
      $user->redirect('home.php');
   }
   
   if (isset($_POST['login_button'])){
	  $employeeid = $_POST['employeeid'];
	  $password = $_POST['password'];
	  
	  if ($user->login($employeeid,$password)){
         $user->redirect('home.php');		  
	  } else {
		 $error = "Invalid username/password"; 
	  }
   }
?>
<!DOCTYPE html> 
<html> 
   <head> 
      <title></title> 
      <meta name="viewport" content="width=device-width, initialscale=1.0"> 
      <!-- Bootstrap --> 
      <link href="css/bootstrap.min.css" rel="stylesheet">
	  <link href="css/styles.css" rel="stylesheet">
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries --> 
      <!-- WARNING: Respond.js doesn't work if you view the page  
      via file:// --> 
      <!--[if lt IE 9]> 
         <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/ 
            html5shiv.js"></script> 
         <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/ 
            respond.min.js"></script> 
      <![endif]-->
      <!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
      <script src="https://code.jquery.com/jquery.js"></script> 
      <!-- Include all compiled plugins (below), or include individual files as needed --> 
      <script src="js/bootstrap.min.js"></script>
	  <script src="js/jquery-1.4.1.min.js"></script>
      <script>
	     $(document).ready(function(){
			$("#close_button").click(function(){
				$("#alert_msg").hide();
			});
		 });
	  </script>
   </head> 
   <body>
      <div class="container">
	     <form method="POST">
	     <!--<div class="center-block panel panel-primary absolute-center is-responsive" style="max-width:350px;margin-top:!10px;">-->
		 <div class="absolute-center is-responsive" style="max-width:350px;margin-top:!10px;">
		    <div class="panel-heading">
			   <span class="glyphicon glyphicon-lock"></span>
			</div>
		    <div class="panel-body">
	           <div class="form-group">
	              <label class="hidden-xs" for="employeeid">Employee ID</label>
	              <input id="employeeid" name="employeeid" class="form-control" type="text" placeholder="Enter Employee ID"></input>
		       </div>
		       <div class="form-group">
		          <label class="hidden-xs" for="password">Password</label>
		          <input id="password" name="password" class="form-control" type="password" placeholder="Enter Password"></input>
		       </div>
			</div>
			<div class="panel-footer">
			   <button name="login_button" class="center-block form-control btn btn-primary" type="submit" style="max-width:150px;">Login</button>
			</div>
         </div>
		 </form>
		 <?php
		    if (isset($error)){
			   ?>
			   <div id="alert_msg" class="center-block alert alert-danger" style="max-width:350px;text-align:center;cursor:default;">
			      <span class="glyphicon glyphicon-warning-sign">&nbsp;</span><?php echo $error; ?>
				  <span id="close_button" class="close">&times;</span>
			   </div>
			   <?php
			}
		 ?>
	  </div>
   </body> 
</html> 