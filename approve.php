<?php
  include_once 'dbconfig.php'; 
  
  $stmt = $user->db->prepare("UPDATE purchaserequestheader SET RequestStatus = :requeststatus WHERE RequestID = :requestid") ;
  $stmt->execute(array(':requeststatus'=>'APPROVED',':requestid'=>$_SESSION['requestid']));
  
  $user->redirect('approver.php');
?>