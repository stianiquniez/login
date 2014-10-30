<?php

//Configuration of the permissions for use in the site. 
function permissions(){
	return array(
	'user_add' => 'Add users',	//Allowd to add users
	'user_edit' => 'Edit users',	//Allowed to edit and delete users
	'news_add' => 'Add news',
	'news_edit' => 'Edit news',
	'cal_add' => 'Add cal events',
	'cal_edit' => 'Edit cal events',
	);
}

//Get all the permissions the user has, and store them in a session.
function get_user_perm($userid){
	$qry = "SELECT perm FROM user_perm WHERE userid='$userid'";
	$result= mysql_query($qry);
	//$test =  mysql_fetch_array(mysql_query("SELECT id FROM user_perm WHERE userid='$userid'"));
	
	$nameArray = array();
	while($row = mysql_fetch_array($result)) {
	    // Append to the array
    	$nameArray[] = $row['perm']; 
	}
	
	return $nameArray;
}

//Function to write out the checkboxes for registration, OR edit form
function display_perm($i,$userid="", $sessionId=""){

	//list of all permissions
	$perm = permissions();
	
	//list of users permissions. Stored in session array. 
	if(!empty($userid)){
		$user_perm = get_user_perm($userid);
	}
	else {
		$user_perm = array(1);
	}
		echo "<ul>";
		foreach($perm as $key => $value){
			//The user allready has this permission. The box to be checked! 
			if(isset($user_perm)){
			  if(in_array($key,$user_perm)){
				  if(checkPerm($key, $sessionId)){
				  	echo '<li><input type="checkbox" name="perm_'.$key.'" value="1" checked="checked" class="checkbox">&nbsp;<label>'.$value.'</label></li>';
				  }
			  }
	  
			  //The user don't have this permission, box to be unchecked!
			  else {
				  if(checkPerm($key, $sessionId)){
				  	echo '<li><input type="checkbox" name="perm_'.$key.'" value="1" class="checkbox">&nbsp;<label>'.$value.'</label></li>';
				  }
			  }
			
			} else {
				if(checkPerm($key, $sessionId)){
					echo '<li><input type="checkbox" name="perm_'.$key.'" value="1" class="checkbox">&nbsp;<label>'.$value.'</label></li>';
				}
			}
		}
		echo "</ul>";
			
	//Unset the session to be done.
}

//Function for checking permission of a user. 
function checkPerm($perm,$ident=""){
	if(empty($ident)){
		if(isset($_SESSION['SESS_MEMBER_ID'])){
			$ident = $_SESSION['SESS_MEMBER_ID'];
		} else {
			return false;
		}
	}
	
	if(mysql_num_rows(mysql_query("SELECT id FROM user_perm WHERE userid='$ident' AND perm='$perm'")) == '1'){
		return true;
	} else {
		return false;
	}

	/* Example
	*  if(checkPerm('user_add') { allowed to add user }
	*/
}

// Check if user is logged in.. (Temporary, to use checkPerm later..
function loggedIn(){
	if(isset($_SESSION['SESS_MEMBER_ID'])){
		return true;
	} else {
		return false;
	}
}

//Function to sanitize values received from the form. Prevents SQL injection
function clean($str) {
	$str = @trim($str);
	if(get_magic_quotes_gpc()) {
		$str = stripslashes($str);
	}
	return mysql_real_escape_string($str);
}
?>
