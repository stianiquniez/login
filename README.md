login
=====

Log in and user administration script

User log in and administration script. 
Made typical for news sites, blog sites, and sites with many users who need diffrent credentials. 

Made easy to add credentials, and to add and edit users to theis credentials.

Example: 

add a new credential in the config.php file

function permissions(){
	return array(
	'user_add' => 'Add users',	//Allowd this user to add users
	);
}

and check it inside the code with: 
if(checkPerm('user_add') { allowed to add user }
