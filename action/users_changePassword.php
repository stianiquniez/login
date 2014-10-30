<?
$config = true;

include("../config.php");
include("../functions.php");
ob_start();
session_start();
			
//Perofrm verification

if(isset($_POST['old_password']) && !empty($_POST['old_password']) AND isset($_POST['new_password']) && !empty($_POST['new_password']) AND isset($_POST['confirm_password']) && !empty($_POST['confirm_password'])){  
  $id = clean($_POST['editID']);
  $old_password = md5(clean($_POST['old_password']));
  $new_password = md5(clean($_POST['new_password']));
  //$confirm_password = clean($_POST['confirm_password']);
  $username = $_SESSION['SESS_FIRST_NAME'];
  
  //$pass = md5(clean(($_POST['password2'])));
  
  //Create query
$qry="SELECT * FROM user WHERE email='$username' AND password='$old_password'";
$result=mysql_query($qry) or die(mysql_error());

//Check whether the query was successful or not
if($result) {
if(mysql_num_rows($result) > 0) {

mysql_query("UPDATE user SET password='$new_password' WHERE id='$id'") or die(mysql_error());
		
		echo "Password change was succesfull!!";

	}
} else {
		
	
	
	} echo "Incorrect Password";
	
		
		
}
		
?>
