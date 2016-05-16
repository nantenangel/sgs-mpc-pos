<?php
	include_once 'dbconfig.php';
	
	if(!$user->is_loggedin())
	{
		$user->redirect('index.php');
	}
	
	$employeeid = $_SESSION['user_session'];
	
	if (isset($_SESSION['alert_msg'])){
		$alert_msg = $_SESSION['alert_msg'];
	}
	
	if(isset($_POST['submit_button']))
    {
		date_default_timezone_set("Singapore");
		$requestid;
		
		try{
			$stmt = $user->db->prepare("SELECT * FROM purchaserequestheader");
			$stmt->execute();
			
			if ($stmt->rowCount() > 0){
				$requestid="SGS-".($stmt->rowCount()+1);
			} else {
				$requestid="SGS-1";
			}
		} catch(PDOException $e){
			echo $e->getMessage();
		}
		$duedate = $_POST['due_date'];;
		
		//PurchaseRequestHeader
		try{
			$sql = "INSERT INTO purchaserequestheader(RequestID,EmployeeID,RequestDate,RequestStatus,DueDate) " . 
				   "VALUES(:requestid,:employeeid,:requestdate,:requeststatus,:duedate)";
			$stmt = $user->db->prepare($sql);
			$stmt->execute(array(':requestid'=>$requestid,':employeeid'=>$_SESSION['user_session']
			,':requestdate'=>date("Y/m/d h:i:s a"),':requeststatus'=>'PENDING',':duedate'=>$duedate));
		} catch(PDOException $e){
			echo $e->getMessage();
		}
		//PurchaseRequestDetail
		$itemid = 1;
		try
		{
			foreach ($_POST['item'] as $key => $value) 
			{
				$item = $_POST["item"][$key];
				$qty = $_POST["qty"][$key];
			
				$sql = "INSERT INTO purchaserequestdetail(RequestItemID,RequestID,RequestItem,RequestQuantity) " . 
					   "VALUES(:requestitemid,:requestid,:requestitem,:requestquantity)";
				$stmt = $user->db->prepare($sql);
				$stmt->execute(array(':requestitemid'=>$requestid.'-'.$itemid,':requestid'=>$requestid,':requestitem'=>$item,':requestquantity'=>$qty));
				
				$itemid++;
			}
		} catch(PDOException $e){
			echo $e->getMessage();
		}
		
		$_SESSION['alert_msg'] = "Purchase Request sent! Please wait for approval.";
		$user->redirect('home.php');
	} else {
		$_SESSION['alert_msg'] = null;
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
	<script src="js/jquery-1.12.2.js"></script>
	<script src="js/jquery-1.4.1.min.js"></script>
	<script>
		var itemcount = 0;
	    
		function numberWithCommas(num){
			var parts = num.toString().split(".");
			parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g,",");
			return parts.join(".");
		}
	    
		function addRow(tableID){ 
			var table = document.getElementById(tableID);
			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);
			
			var cell1 = row.insertCell(0);
			var element1 = document.createElement("input");
			element1.type = "checkbox";
			element1.name = "chkbox[]";
			cell1.style = "margin:0 auto;text-align:center;";
			cell1.appendChild(element1);

			var cell2 = row.insertCell(1);
			cell2.innerHTML = "<input class='form-control' type='number' min='1' step='1'  name='qty[]' data-bind='value:qty[]' required/>";

			var cell3 = row.insertCell(2);
			cell3.innerHTML = "<input class='form-control' type='text' name='item[]' required/>";
			
			document.getElementById("remove_button").disabled = false;
			document.getElementById("remove_button").style = "cursor:hand;";
			document.getElementById("submit_button").disabled = false;
			document.getElementById("submit_button").style = "cursor:hand;";
			document.getElementById("chkboxAll").disabled = false;
        }
		 
		function deleteRow(tableID){
			try {
				var table = document.getElementById(tableID);
				var rowCount = table.rows.length;
				
				for(var i=0; i<rowCount; i++) {
					var row = table.rows[i];
					var chkbox = row.cells[0].childNodes[0];
					
					if(null != chkbox && true == chkbox.checked) {
						table.deleteRow(i);
						rowCount--;
						i--;
						
						if(rowCount == 0) {						
							document.getElementById("remove_button").disabled = true;
							document.getElementById("remove_button").style = "cursor:default;";
							document.getElementById("submit_button").disabled = true;
							document.getElementById("submit_button").style = "cursor:default;";
							document.getElementById("chkboxAll").checked = false;
							document.getElementById("chkboxAll").disabled = true;
						}
					}	
				}
			} catch(e) {
				alert(e);
			}
        }
		
		function selectAll(tableID){
			var chkbox = document.getElementById("chkboxAll");
			var table = document.getElementById(tableID);
			var rowCount = table.rows.length;
			
			if (chkbox.checked == true){
				try {
					for(var i=0; i<rowCount; i++) {
						var row = table.rows[i];
						var chkbox = row.cells[0].childNodes[0];
						
						if(null != chkbox && false == chkbox.checked) {
							chkbox.checked = true;
						}	
					}
				} catch(e) {
					alert(e);
				}
			} else {
				try {
					for(var i=0; i<rowCount; i++) {
						var row = table.rows[i];
						var chkbox = row.cells[0].childNodes[0];
						
						if(null != chkbox && true == chkbox.checked) {
							chkbox.checked = false;
						}	
					} 
				} catch(e) {
					alert(e);
				}
			}
		}
	</script>
	<script>
	     $(document).ready(function(){
			$("#close_button").click(function(){
				$("#alert_msg").hide();
			});
		 });
	</script>
</head> 
<body>
	<!--Navigation-->
    <nav role="navigation">
	   <div class="mynav navbar-fixed-top" style="">
		<ul class="nav nav-pills pull-left">
			<li class="active"><a style="cursor:default;"><span class="glyphicon glyphicon-file"></span><span class="hidden-xs">&nbsp;New Request</span></a></li>
			<li><a href="requestlist.php"><span class="glyphicon glyphicon-list"></span><span class="hidden-xs">&nbsp;Request List</span></a></li>
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
				<form action="" method="POST" name="">
				<div class="row">
					<div class="col-sm-3 col-sm-offset-9">
						<input name="due_date" id="due_date" class="form-control" type="text" placeholder="Due Date"></input>
					</div>
				</div>
				<hr/>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th class="col-xs-1 col-md-1" style="margin:0 auto; text-align:center;">
							<input disabled id="chkboxAll" type="checkbox" onclick="selectAll('dataTable')" style="cursor:default;"  /></th>
							<th class="col-xs-2 col-md-2" style="text-align:center;cursor:default;">QUANTITY</th>
							<th class="col-xs-9 col-md-9" style="text-align:center;cursor:default;">ITEM</th>
						</tr>
					</thead>
					<tbody id="dataTable">
					</tbody>
				</table>
				<hr/>
				<div class="row">
					<div class="col-xs-4 col-sm-3 col-md-3">
						<button class="form-control btn-success" type="button" value="Add Row" onClick="addRow('dataTable')" >
						<span class="glyphicon glyphicon-plus"></span><span class="hidden-xs">&nbsp;Add Item</span></button>
					</div>
					<div class="col-xs-4 col-sm-3 col-md-3">
						<button disabled class="form-control btn-danger" type="button" value="Delete Row" onClick="deleteRow('dataTable')" id="remove_button"
						style="cursor:default;">
						<span class="glyphicon glyphicon-remove"></span><span class="hidden-xs">&nbsp;Remove Item</span></button>
					</div>
					<div class="col-xs-4 col-sm-3 col-sm-offset-3 col-md-3 col-md-offset-3">
						<button disabled class="form-control btn-primary" type="submit" value="Submit Requeset" name="submit_button" id="submit_button"
						style="cursor:default;"/>
						<span class="glyphicon glyphicon-send"></span>
						<span class="hidden-xs">&nbsp;Submit Request</span></button>
					</div>
				</div>
				</form>
			</div>
		</div>
		<?php
		    if (isset($alert_msg)){
			   ?>
			   <div id="alert_msg" class="center-block alert alert-success" style="max-width:1024px;text-align:center;cursor:default;">
			      <?php echo $alert_msg; ?>
				  <span id="close_button" class="close">&times;</span>
			   </div>
			   <?php
			}
			?>
		<!--
		<div class="container">
		<div class="row">
		<div class='col-sm-6'>
		<div class="form-group">
		<div class='input-group date' id='datetimepicker1'>
		<input type='text' class="form-control" />
		<span class="input-group-addon">
		<span class="glyphicon glyphicon-calendar"></span>
		</span>
		</div>
		</div>
		</div>
		<script type="text/javascript">
		$(function () {
		$('#datetimepicker1').datetimepicker();
		});
		</script>
		</div>
		</div>
		-->
	</div>
</body>
</html>