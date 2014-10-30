<? 
session_start();
//Gi tilgang for inkludering av config.
$config = true;

include("../config.php"); 
include "../functions.php";
	
$id = clean($_POST['valueID']);

display_perm(1,$id, $_SESSION['SESS_MEMBER_ID']);

?>
