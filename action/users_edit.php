<?php

$config = true;
include("../config.php");
include("../functions.php");

ob_start();
session_start();
//Perform verification
if(!checkPerm('user_edit')){
	die('no access');
}
if(isset($_POST['name2']) && !empty($_POST['name2']) AND isset($_POST['surname2']) && !empty($_POST['surname2']) AND isset($_POST['email2']) && !empty($_POST['email2'])){  
  $id = clean($_POST['editID']);
  $name = clean($_POST['name2']);
  $surname = clean($_POST['surname2']);
  $email = clean($_POST['email2']);
  $pass = md5(clean(($_POST['password2'])));  
  
} else {
	echo "An error occured. Please try again!";
}

if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){  
	echo "No valid e-mail!";
	exit();
}else{  
	
	if($pass !=''){
		$pass = "password='$pass',";
	}else{
		$pass = '';

	mysql_query("UPDATE user SET name='$name', surname='$surname', $pass email='$email' WHERE id='$id'") or die(mysql_error());

}

//Handle permissions.

$perm = permissions(); 			 //Get all permissions
$user_perm = get_user_perm($id); //Get users already permission

foreach($perm as $key1 => $value1){

	mysql_query("DELETE FROM user_perm WHERE userid='$id' AND perm='$key1'");
	
	if($_POST["perm_".$key1] == '1' && checkPerm($key1)){ 
		mysql_query("INSERT INTO user_perm (userid,perm) VALUES ( '$id', '$key1' )");
		}
}//foreach


//New version to run fewer SQL queries.
/*
foreach($perm as $key => $value){
	
		//User has this permission, and postet is 0. Remove it
		if(array_key_exists($key,$user_perm) && $_POST["perm_".$key] !== '1'){
			mysql_query("DELETE FROM user_perm WHERE userid='$id' AND perm='$key'");
		}
		else{ //user has not this permission
			//User has postet he want it, check permission
			if($_POST["perm_".$key] == '1' && checkPerm($key)){
				//insert permission
				mysql_query("INSERT INTO user_perm (userid,perm) VALUES ( '$id', '$key' ) ");
			}
		} 
}
*/

	echo "Update was succesfull!!";		

}	
?>
