<?php
 session_start();

 
 if (isset($_GET['logout'])) {
  unset($_SESSION['user']);
  session_unset();
  session_destroy();
  header("Location: index.php");
  exit;
 }


   // it will never let you open register(sign-up) page if session is set
 if ( isset($_SESSION['admin'])!="" ) {
  header("Location: home_admin.php");
  exit;
 } else if(isset($_SESSION['user'])!="") {
  header("Location: home_user.php");
 } else if (!isset($_SESSION['user'])) {
  header("Location: index.php");
 } 
 ?>