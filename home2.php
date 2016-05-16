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
	     var itemcount = 0;
	     function click_add(){
			 var name = document.getElementById("item").value;
			 var qty = document.getElementById("quantity").value;
			 
			 if (name!="" && isNaN(qty)==false && qty>0){
				var tbl = document.getElementById("tblpos");
				var row = tbl.insertRow(itemcount+1);
				var cell1 = row.insertCell(0);
				var cell2 = row.insertCell(1);
				//var cell3 = row.insertCell(2);
			
				cell1.innerHTML = name;
				cell2.innerHTML = numberWithCommas(qty);
				cell2.style = 'text-align:right;';
				cell2.name = 'qty[]';
				//cell3.innerHTML = "<button type='button' class='btn btn-xs btn-danger' onclick='click_sub(this)'><span class='glyphicon glyphicon-remove'></span</button>";
				itemcount += 1;
			 
				document.getElementById("quantity").value = "";
				document.getElementById("item").value = "";
			 } else if (isNaN(qty)){
				document.getElementById("quantity").value = "";
			 }
		 }
		 
		 function numberWithCommas(num){
		    var parts = num.toString().split(".");
			parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g,",");
			return parts.join(".");
		 }
	  
	     function addRow(tableID) {
			var table = document.getElementById(tableID);

			var rowCount = table.rows.length;
			var row = table.insertRow(rowCount);

			var cell1 = row.insertCell(0);
			var element1 = document.createElement("input");
			element1.type = "checkbox";
			element1.name="chkbox[]";
			cell1.appendChild(element1);

			var cell2 = row.insertCell(1);
			cell2.innerHTML = "<input type='text' name='item[]'>";

			var cell3 = row.insertCell(2);
			cell3.innerHTML = "<input type='text'  name='price[]' />";

			var cell4 = row.insertCell(3);
			cell4.innerHTML =  "<input type='text'  name='qty[]' />";
		 }
		function deleteRow(tableID) {
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
					}
				}
			}catch(e) {
					alert(e);
			}
		}-
	  </script>
   </head> 
   <body>
      <!--Navigation
      <nav class="navbar navbar-default">
		  <div class="nav navbar-nav">	  
			  <ul class="nav nav-pills" style="margin:4px 4px;">
				 <li class="active"><a href=""><span class="glyphicon glyphicon-file"></span></a></li>
				 <li><a href="requestlist.php"><span class="glyphicon glyphicon-list"></span></a></li>
			  </ul>
		  </div>
		  <div>
			  <p class="navbar-text navbar-right" style="margin-right:10px;">
			  <span class="glyphicon glyphicon-log-out"></span><a href="logout.php" class="navbar-link" style="margin-left:3px;">Logout</a></p>
		  </div>
	  </nav>
	  <!--Navigation End-->
		 <form method="POST">
		 <div class="center-block panel panel-default" style="width:700px;">
			<div class="panel-body">
			   <table id="tblpos" class="table table-bordered" style="margin:0px;">
			      <thead>
				     <tr>
						<th class="col-md-9">Particulars</th>
						<th class="col-md-3" style="text-align:center;">Quantity</th>
					 </tr>
				  </thead>
			   </table>
			   <hr/>
			   <!--
			   <div class="row">
			      <label class="col-md-12">Prepared By:</label>
			   </div>
			   <div class="row">
			      <label class="col-md-12">(Requestor Name Goes Here)</label>
			   </div>
			   <div class="row">
			      <label class="col-md-12">(Department/Position)</label>
			   </div>
			   <div class="row">
			      <label class="col-md-12">(Branch)</label>
			   </div> -->
			</div>
			<div class="panel-footer">			  
				<button name="button_submit" type="submit" class="form-control center-block btn-primary" style="width:150px;">
				<span class="glyphicon glyphicon-send"></span> Send Request</button>
			</div>
		 </div>
		 </form>
	  </div>
   </body>
</html> 