<?php
	class User
	{
		public $db;
		
		function __construct($DB_con){
			$this->db = $DB_con;
		}
		
		public function login($employeeid,$password){
			try{
				$stmt = $this->db->prepare("SELECT * FROM employeelogin WHERE EmployeeID=:employeeid AND Password=:password LIMIT 1");
				$stmt->execute(array(':employeeid'=>$employeeid,':password'=>$password));
				$userRow = $stmt->fetch(PDO::FETCH_ASSOC);
				
				if ($stmt->rowCount() > 0){
					$_SESSION['user_session'] = $userRow['EmployeeID'];
					return true;
				}
			} catch(PDOException $e){
				echo $e->getMessage();
				return false;
			}
		}
		
		public function is_loggedin(){
			if (isset($_SESSION['user_session'])){
				return true;
			} else{
				return false;
			}
		}
		
		public function redirect($url){
			header("Location: $url");
		}
		
		public function logout(){
			unset($_SESSION['user_session']);
			session_destroy();
			return true;
		}
		
		public function insert($item,$qty){
			try{
				foreach ($_POST['item'] as $key => $value) 
				{
					$sql = "INSERT INTO purchaserequestdetail(RequestItemID,RequestID,RequestItem,RequestQuantity) " . 
						   "VALUES(:requestitemid,:requestid,:requestitem,:requestquantity)";
					$stmt = $this->db->prepare($sql);
					$stmt->execute(array(':requestitemid'=>'1',':requestid'=>'1',':requestitem'=>$item,':requestquantity'=>$qty));				
					
					$sql = mysql_query("INSERT INTO purchaserequestdetail values ('1','1','$item','$qty')");        
				}
			} catch(PDOException $e){
				echo $e->getMessage();
			}
		}
	}
?>