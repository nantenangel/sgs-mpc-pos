<!DOCTYPE html> 
<html> 
  <head>
    <title>Approver</title> 
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
        <li><a href="logout.php" class="navbar-link"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Logout</a></li>
      </ul>
    </div>
    </nav>
    <br/>
    <br/>
    <br/>
    <!--Navigation End-->
    <div class="container">
	<div class="row">
	<h4 style="border-bottom:solid thin black;margin-bottom:3px;">Request ID</h4>
	</div>
	<div class="row" style="text-transform:uppercase;">
	Prepared By  Request Date
	</div>
	<div class="row" style="text-transform:uppercase;">
	Branch       Pending
    </div>
	<div class="row" style="text-transform:uppercase;">
	Department
    </div>
    <div>
  </body>
</html>