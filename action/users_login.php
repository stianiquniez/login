<? 
//Gi tilgang for inkludering av config.
$config = true; 

include("../config.php"); 
include("../functions.php");
ob_start();
session_start();

//Array to store validation errors
$errmsg_arr = array();
 
//Validation error flag
$errflag = false;
 
//Sanitize the POST values
$username = clean($_POST['email']);
$password = clean($_POST['password']);
$enc_password = clean(md5($password));
 
//Input Validations
if($username == '') {
	$errmsg_arr[] = 'Username missing';
	$errflag = true;
}

if($password == '') {
	$errmsg_arr[] = 'Password missing';
	$errflag = true;
}
 
//If there are input validations, redirect back to the login form
if($errflag) {
	$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
	session_write_close();
	echo "There are blank fields";
	exit();
}
 
//Create query
$qry="SELECT * FROM user WHERE email='$username' AND password='$enc_password'";
$result=mysql_query($qry) or die(mysql_error());

//Check whether the query was successful or not
if($result) {
if(mysql_num_rows($result) > 0) {
echo "Logged in!";	

//Login Successful
session_regenerate_id();
$member = mysql_fetch_assoc($result);
$_SESSION['SESS_MEMBER_ID'] = $member['id'];
$_SESSION['SESS_FIRST_NAME'] = $member['email'];
$_SESSION['SESS_LAST_NAME'] = $member['password'];
$_SESSION['SESS_NAME'] = $member['name'];
$_SESSION['SESS_PERM'] = $member['permission'];

session_write_close();

setcookie("cal_perm", checkPerm("cal_add")|(checkPerm("cal_edit")<<1), 0, '/');

exit();
}else {
//Login failed
$errmsg_arr[] = 'User name and password not found';
$errflag = true;
if($errflag) {
$_SESSION['ERRMSG_ARR'] = $errmsg_arr;
session_write_close();
echo $errmsg_arr[0];
}
}
}else {
die("Query failed");
}
?>
