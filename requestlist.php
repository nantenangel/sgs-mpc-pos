<?php
	include_once 'dbconfig.php';
	
	if(!$user->is_loggedin())
	{
		$user->redirect('index.php');
	}
	
	$employeeid = $_SESSION['user_session'];
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
	  <script src="js/1.12.2.js"></script>
   </head> 
   <body>
      <!--Navigation-->
      <nav role="navigation">
	  <div class="mynav navbar-fixed-top">
         <ul class="nav nav-pills pull-left">
            <li><a  href="home.php"><span class="glyphicon glyphicon-file"></span><span class="hidden-xs">&nbsp;New Request</span></a></li>
            <li class="active"><a style="cursor:default;"><span class="glyphicon glyphicon-list"></span><span class="hidden-xs">&nbsp;Request List</span></a></li>
         </ul>
         <ul class="nav nav-pills pull-right">
            <li><a href="logout.php" class="navbar-link" style="margin-left:3px;"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
         </ul>
      </div>
      </nav>
      <br/>
      <br/>
      <br/>
      <!--Navigation End-->
      
	  <div class="container">
	  <div class="center-block panel panel-default" style="max-width:1024px;">
			<div class="panel-body">
				<hr/>
				<?php
					try {
						$stmt = $user->db->prepare("SELECT RequestID, RequestDate, RequestStatus FROM purchaserequestheader
						 WHERE EmployeeID = :employeeid");
						$stmt->execute([':employeeid'=>$_SESSION['user_session']]);
					} catch(PDOException $e) {
						echo "Error: " . $e->getMessage();
					}
				?>
				<table class='table table-bordered'>
					<thead>
						<th class='col-md-2'></th>
					    <th class='col-md-3' style='text-align:center;cursor:default;'>Request ID</th>
					    <th class='col-md-3' style='text-align:center;cursor:default;'>Request Date</th>
						<th class='col-md-3' style='text-align:center;cursor:default;'>Status</th>
					</thead>
				<?php 
						for ($i=0;$i<$stmt->rowCount();$i++){
							if ($row = $stmt->fetch()){
								$id=$row['RequestID']; ?>
								<tr>
								<td style='text-align:center;cursor:default;'><a href="#<?php echo $id?>" data-toggle='modal' data-target='#RequestInfo'>View Details</a></td>
								<td style='text-align:center;cursor:default;'><?php echo $row['RequestID'] ?></td>
								<td style='text-align:center;cursor:default;'><?php echo $row['RequestDate'] ?></td>
								<td style='text-align:center;cursor:default;'><?php echo $row['RequestStatus'] ?></td>
								</tr>
				<?php }
					}
				?>
				</table>					
			    <div class='modal fade' id='RequestInfo' role='dialog'>
				   <div class='modal-dialog'>
				      <!-- Modal content-->
					  <div class='modal-content'>
					     <div class='modal-header'>
						    <button type='button' class='close' data-dismiss='modal'>&times;</button>
							<h4 class='modal-title'>Request ID</h4>
						 </div>
						 <div class='modal-body'>
						    <table class='table table-default'><?php echo $id?>
							   <thead>
							      <th class='col-md-2'></th>
								  <th class='col-md-7' style='cursor:default;'>Item</th>
							      <th class='col-md-3' style='text-align:center;cursor:default;'>Quantity</th>
							   </thead>
							</table>
						 </div>
						 <div class='modal-footer'>
						    <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
						 </div>
					  </div>								  
				   </div>
			    </div>					
				<hr/>				
			</div>
		</div>
	  </div>
   </body>
</html> 