<?
session_start();
ob_start();

$config = true;

include("../config.php");
include("../functions.php");


if(checkPerm('user_edit')){

	$id = clean($_POST['valueID']);
	//Delete user
	mysql_query("DELETE FROM user WHERE id='$id'") or die(mysql_error());
	
	//Delete users permissions
	mysql_query("DELETE FROM user_perm WHERE userid='$id'") or die(mysql_error());
	
	echo "Deleted";

}
?>
