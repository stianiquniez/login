<?
//Gi tilgang for inkludering av config.
$config = true;

include("../config.php"); 
include("../functions.php");

ob_start();
session_start();

if(!checkPerm('user_add')){
	die('no access');
}

			
	//Perform verification
	
	if(isset($_POST['name']) && !empty($_POST['name']) AND isset($_POST['surname']) && !empty($_POST['surname']) AND isset($_POST['email']) && !empty($_POST['email'])){  
	  $name = clean($_POST['name']);
	  $surname = clean($_POST['surname']);
	  $email = clean($_POST['email']);
	  $pass = md5(clean(($_POST['password'])));

	  
	} else {
		echo "An error occured. Please try again!";
	}
	
	if(!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email)){  
		echo "No valid e-mail!";
		exit();
	}else{  
		mysql_query("INSERT INTO user (id ,name , surname, email, password) VALUES ('', '$name','$surname', '$email', '$pass')") or die(mysql_error());
		
		//GET userid!
		$user_array = mysql_fetch_array(mysql_query("SELECT id FROM user WHERE name='$name' AND surname='$surname' AND email='$email'"));
		$userid = $user_array['id'];

		//Permission.
		foreach ($_POST as $key=>$value){
		    if (substr($key,0,5)==='perm_'){
			$currentPermission = clean(substr($key,5)); //Get all after perm_
			//Insert the permission if value is 1
			if($value == '1' && checkPerm($currentPermission)){
				mysql_query("INSERT INTO user_perm ( userid, perm ) VALUES ( '$userid', '$currentPermission' )") or die(mysql_error());
			}
		    }
		}
		
		echo "Registration was succesfull!!";	
	}
		
?>
