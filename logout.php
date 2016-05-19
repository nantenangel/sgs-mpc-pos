<?php
  include_once 'dbconfig.php';

  $user->logout();
  $user->redirect('index.php');
?>