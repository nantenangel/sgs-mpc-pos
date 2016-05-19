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
	  <script src="js/jquery-1.4.1.min.js"></script>
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
				<!--
				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="col-md-4" style="text-align:center;cursor:default;">Request ID</th>
							<th class="col-md-4" style="text-align:center;cursor:default;">Request Date</th>
							<th class="col-md-4" style="text-align:center;cursor:default;">Status</th>
						</tr>
					</thead>
					<tbody id="dataTable">
					</tbody>
				</table> -->
				
				<?php
					echo "<table class='table table-bordered'>";
					echo "<tr>
							 <th class='col-md-4' style='text-align:center;cursor:default;'>Request ID</th>
							 <th class='col-md-4' style='text-align:center;cursor:default;'>Request Date</th>
							 <th class='col-md-4' style='text-align:center;cursor:default;'>Status</th>
							</tr>";

					class TableRows extends RecursiveIteratorIterator {
						function __construct($it) {
							parent::__construct($it, self::LEAVES_ONLY);
						}

						function current() {
							return "<td style='text-align:center;cursor:default;'>" . parent::current(). "</td>";
						}

						function beginChildren() {
							echo "<tr>";
						}

						function endChildren() {
							echo "</tr>" . "\n";
						}
					}

					try {
						$stmt = $user->db->prepare("SELECT RequestID, RequestDate, RequestStatus FROM purchaserequestheader WHERE EmployeeID ='".$_SESSION['user_session']."'");
						$stmt->execute();

						// set the resulting array to associative
						$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
						foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
							echo $v;
						}
					} catch(PDOException $e) {
						echo "Error: " . $e->getMessage();
					}
					
					echo "</table>";
					
					echo "<div class='row'>
					         <form action='' method='POST' name=''>
					         <div class='col-xs-6 col-md-3'>
					            <input name='txt_requestid' id='txt_requestid' class='form-control' type='text' placeholder='Enter Request ID'></input>
							 </div>
							 <div class='col-xs-6 col-md-3'>
								<button name='view_request' id='view_request' class='form-control btn btn-primary' type='submit'><span></span>View Request</button>
                             </div>
							 </form>
					      </div>";
					
					echo "<br/>";
					echo "<table class='table table-bordered'>";
					echo "<tr>
							 <th class='col-md-2' style='text-align:center;cursor:default;'>Request Item ID</th>
							 <th class='col-md-8' style='text-align:center;cursor:default;'>Item</th>
							 <th class='col-md-2' style='text-align:center;cursor:default;'>Quantity</th>
						  </tr>";
				    
					if (isset($_POST['view_request'])){
						try {
							$stmt = $user->db->prepare("SELECT RequestItemID, RequestItem, RequestQuantity FROM purchaserequestdetail
							        WHERE RequestID = '".$_POST['txt_requestid']."'");
							$stmt->execute();

							// set the resulting array to associative
							$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
							foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
								echo $v;
							}
						} catch(PDOException $e) {
							echo "Error: " . $e->getMessage();
						}
					}
					/*
					try {
						$stmt = $user->db->prepare("SELECT RequestItemID, RequestItem, RequestQuantity FROM purchaserequestdetail");
						$stmt->execute();

						// set the resulting array to associative
						$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
						foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) {
							echo $v;
						}
					}
					
					catch(PDOException $e) {
						echo "Error: " . $e->getMessage();
					}*/
					
					echo "</table>";
				?>
				
				<hr/>
			</div>
		</div>
	  </div>
   </body>
</html> 