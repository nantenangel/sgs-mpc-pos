<?php
  include_once 'dbconfig.php';
  
  if (!$user->is_loggedin()){
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
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]> 
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script> 
  <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script> 
  <![endif]-->
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) --> 
  <script src="https://code.jquery.com/jquery.js"></script> 
  <!-- Include all compiled plugins (below), or include individual files as needed --> 
  <script src="js/bootstrap.min.js"></script>
  <script src="js/1.12.2.js"></script>
</head> 
<body>
  <!-- Navigation -->
  <nav role="navigation">
	  <div class="mynav navbar-fixed-top">
         <ul class="nav nav-pills pull-left">
		    <li><a href="home.php"><span class="glyphicon glyphicon-home"></span></a></li>
            <li><a href="newrequest.php"><span class="glyphicon glyphicon-file"></span><span class="hidden-xs">&nbsp;New Request</span></a></li>
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
  <!-- Navigation Ends -->
  
  <div class="container">
    <div class="center-block panel panel-default" style="max-width:1024px;">
    <div class="panel-body">
	  <?php //Get All Purchase Request
        try{
          $stmt = $user->db->prepare("SELECT RequestID, RequestDate, RequestStatus, DueDate, EmployeeID FROM purchaserequestheader WHERE EmployeeID = :employeeid");
          $stmt->execute([':employeeid'=>$_SESSION['user_session']]);
        } catch(PDOException $e){
          echo "Error: " . $e->getMessage();
        }
      ?>
	  <hr/>
      <table class="table table-default" style="margin-bottom:0px;">
      <thead>
        <th class="col-md-2"></th>
        <th class="col-md-2" style="text-align:center;cursor:default;">Request ID</th>
        <th class="col-md-3" style="text-align:center;cursor:default;">Request Date</th>
        <th class="col-md-3" style="text-align:center;cursor:default;">Due Date</th>
        <th class="col-md-2" style="text-align:center;cursor:default;">Status</th>
      </thead>
	  </table> <!-- End of Table Request -->
      <?php
	    if ($stmt->rowCount()>0) {
        for ($i=0; $i<$stmt->rowCount();$i++){
          if ($row = $stmt->fetch()){
            $requestid = $row['RequestID'];
            $employeeid = $row['EmployeeID']?>
            <table class="table table-default" style="margin-bottom:0px;">
            <tr>
              <td class="col-md-2" style="text-align:center;"><a href="#<?php echo $requestid; ?>" data-toggle="modal" data-target="#<?php echo $requestid; ?>">View Details</a></td>
              <td class="col-md-2" style="text-align:center;cursor:default;"><?php echo $row['RequestID'] ?></td>
              <td class="col-md-3" style="text-align:center;cursor:default;"><?php echo $row['RequestDate'] ?></td>
              <td class="col-md-3" style="text-align:center;cursor:default;"><?php echo $row['DueDate'] ?></td>
              <td class="col-md-2" style="text-align:center;cursor:default;"><?php echo $row['RequestStatus'] ?></td>							   
            </tr>
            </table> <!-- End of Table Request Per Item -->
			<!-- Modal -->
            <div class='modal fade' id='<?php echo $requestid; ?>' role='dialog'>
            <div class='modal-dialog'>
            <!-- Modal content-->
            <div class='modal-content'>
              <div class='modal-header'>
                <button type='button' class='close' data-dismiss='modal'>&times;</button>
                <h4 class='modal-title'>Request ID [<?php echo $requestid; ?>]</h4>
              </div>
              <div class='modal-body'>
			  <table class='table table-bordered'>
              <thead>
                <th class='col-md-8' style='text-align:left;cursor:default;'>Item</th>
                <th class='col-md-4' style='text-align:center;cursor:default;'>Quantity</th>
              </thead>
			  <?php
			    try {
                  $stmt2 = $user->db->prepare("SELECT RequestItem, RequestQuantity FROM purchaserequestdetail WHERE RequestID = :requestid");
                  $stmt2->execute([':requestid'=>$requestid]);
                } catch(PDOException $e) {
                  echo "Error: " . $e->getMessage();
                }
			  ?>
			  <?php
			    for ($j=0;$j<$stmt2->rowCount();$j++){
				  if ($row2 = $stmt2->fetch()){ ?>
				    <tr>							    
                      <td class=""  style="text-align:left;cursor:default;"><?php echo $row2['RequestItem'] ?></td>
                      <td class=""  style="text-align:right;cursor:default;"><?php echo number_format($row2['RequestQuantity']) ?></td>
                    </tr>
			  <?php }
				}
			  ?>
			  </table>              
			  </div>
			  <div class="modal-footer">
			    <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
			  </div>
			</div>
			</div>
			</div> <!-- End of Modal -->
        <?php } //end of if
	      } //end of for 
		} //end of if(rowCount>0)
		else {
		  echo "No existing records...";
		} ?>
      <hr/>
    </div> <!-- End of Panel Body -->
    </div> <!-- End of Panel -->
  </div> <!-- End of Container -->
</body>
</html>