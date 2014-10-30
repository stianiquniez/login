<?php
	
	//Gi tilgang for inkludering av config.
	$config = true;
    
	include("../config.php");
   	 session_start();
  	  session_destroy();
	setcookie("cal_perm","",time()+1,"/");
	echo "Logged out succesfully";
   	die;    
?>
