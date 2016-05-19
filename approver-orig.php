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
	  <script>
	     function getID(element) {
			 //alert(element.parentNode.parentNode.rowIndex);
		 }
	  </script>
   </head> 
   <body>
      <!--Navigation-->
      <nav role="navigation">
	  <div class="mynav navbar-fixed-top">
         <ul class="nav nav-pills pull-left">
            <!--<i><a  href="home.php"><span class="glyphicon glyphicon-file"></span><span class="hidden-xs">&nbsp;New Request</span></a></li>
            <li class="active"><a style="cursor:default;"><span class="glyphicon glyphicon-list"></span><span class="hidden-xs">&nbsp;Request List</span></a></li>
			-->
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
				<?php //Get All Purchase Request
					try {
						$stmt = $user->db->prepare("SELECT RequestID, RequestDate, RequestStatus, DueDate FROM purchaserequestheader");
						$stmt->execute();
					} catch(PDOException $e) {
						echo "Error: " . $e->getMessage();
					}
				?>
				<table class='table table-striped'>
					<thead>
						<th class='col-md-2'></th>
					    <th class='col-md-2' style='text-align:center;cursor:default;'>Request ID</th>
					    <th class='col-md-3' style='text-align:center;cursor:default;'>Request Date</th>
						<th class='col-md-3' style='text-align:center;cursor:default;'>Due Date</th>
						<th class='col-md-2' style='text-align:center;cursor:default;'>Status</th>
					</thead>
				<?php 
					for ($i=0; $i<$stmt->rowCount();$i++){
						
						if ($row = $stmt->fetch()){
							$id=$row['RequestID']; ?>
							<tr>							    
								<td class="col-md-2" style="text-align:center;"><a href="#<?php echo $id; ?>" data-toggle="modal" data-target="#RequestInfo">View Details</a></td>
								<td class="col-md-2"  style="text-align:center;cursor:default;"><?php echo $row['RequestID'] ?></td>
								<td class="col-md-3" style="text-align:center;cursor:default;"><?php echo $row['RequestDate'] ?></td>
								<td class="col-md-3"  style="text-align:center;cursor:default;"><?php echo $row['DueDate'] ?></td>
								<td class="col-md-2"  style="text-align:center;cursor:default;"><?php echo $row['RequestStatus'] ?></td>							   
							</tr>
				<?php } ?>
				<div class='modal fade' id='RequestInfo' role='dialog'>
				    <div class='modal-dialog'>
					<!-- Modal content-->
					<div class='modal-content'>
						<div class='modal-header'>
							<button type='button' class='close' data-dismiss='modal'>&times;</button>
							<h4 class='modal-title'>Request ID [<?php echo $id; ?>]</h4>
						</div>
						<div class='modal-body'>
							<?php
								try {
									$stmt = $user->db->prepare("SELECT * FROM employeedetails WHERE EmployeeID = :employeeid");
									$stmt->execute([':employeeid'=>$_SESSION['user_session']]);
								} catch(PDOException $e) {
									echo "Error: " . $e->getMessage();
								}
								$row = $stmt->fetch();
								$surname = $row['SurName'];
								$givenname = $row['GivenName'];
								$department = $row['Department'];
								$position = $row['Position'];
								$branch = $row['Branch'];
								
							?>
							
							<label>Prepared By:</label>
							<p>Name: <?php echo $surname . ", " . $givenname; ?></p>
							<p>Branch: <?php echo $branch; ?></p>
							<p>Department: <?php echo $department; ?></p>
							<p>Position: <?php echo $position; ?></p>
							<hr/>
							<table class='table table-bordered'>
								<thead>
								<th class='col-md-6' style='text-align:left;cursor:default;'>Item</th>
								<th class='col-md-3' style='text-align:center;cursor:default;'>Quantity</th>
								<th class='col-md-3' >Price</th>
								</thead>
							<?php
								try {
									$stmt = $user->db->prepare("SELECT RequestItem, RequestQuantity FROM purchaserequestdetail
									WHERE RequestID = :requestid");
									$stmt->execute([':requestid'=>$id]);
								} catch(PDOException $e) {
									echo "Error: " . $e->getMessage();
								} ?>
								<form method="POST">
							<?php
								for ($i=0;$i<$stmt->rowCount();$i++){						
									if ($row = $stmt->fetch()){
										?>
										<tr>							    
											<td class=""  style="text-align:left;cursor:default;"><?php echo $row['RequestItem'] ?></td>
											<td class=""  style="text-align:right;cursor:default;"><?php echo number_format($row['RequestQuantity']) ?></td>
											<td><input required min="1" type="number" class="form-control"></input></td>
										</tr>
							<?php	}
								}
							?>
								
							</table>
							<hr/>
							<div class="form-group">
							<label>Remarks</label>
							<textarea class="form-control" style="resize:none;"></textarea>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span>&nbsp;Approve</button>
								<button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span>&nbsp;Disapprove</button>
							</div>
							</form>
						</div>
						<div class='modal-footer'>
							<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
						</div>
					</div>
					</div>
				</div>
				<?php
					}
				?>
				</table>				
				<hr/>
			</div>
		</div>
	  </div>
   </body>
</html>