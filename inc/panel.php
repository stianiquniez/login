<?php

if(loggedIn()){    
    
    ?>
    <h2>Brukere administrasjonsside</h2>

<a href="#" class="chaButton" rel="<? echo $_SESSION['SESS_MEMBER_ID']; ?>">Bytt passord</a>

<? if(checkPerm('user_add', $_SESSION['SESS_MEMBER_ID'])){ ?>
	<a href="#" class="regButton">Legg til</a>
<? } ?>



<ul class='userlist titles'>
	<li>Navn</li>
	<li>Etternavn</li>
	<li>E-post</li>
	<li>endre/rettigheter</li>
</ul>
<?

$qry="SELECT id, name, surname, email FROM user";
$result=mysql_query($qry) or die(mysql_error());

//Check whether the query was successful or not
if($result) {
if(mysql_num_rows($result) > 0) {

$i=1;
$class1 = 'gray';
$class2 = 'white';
if(checkPerm('user_edit', $_SESSION['SESS_MEMBER_ID'])){ 


while ($member = mysql_fetch_assoc($result)) {
	$class = ($i++ & 1) ? $class1 : $class2;

			echo "<ul class='userlist ".$class."' rel=".$member['id'].">
					<li class='name'>".$member['name']."</li>
					<li class='surname'>".$member['surname']."</li>
					<li class='email'>".$member['email']."</li>
					<li class='link'><a href='#' rel=".$member['id']." class='edit'>Endre</a></li>
					<li class='link'><a href='#' rel=".$member['id']." class='delete'>Slett</a></li>
				</ul>";	
			} //while loop
		
		} //perm if
		
else if(!checkPerm('user_edit', $_SESSION['SESS_MEMBER_ID'])){ 



while ($member = mysql_fetch_assoc($result)) {
	$class = ($i++ & 1) ? $class1 : $class2;
			echo "<ul class='userlist ".$class."' rel=".$member['id'].">
				<li class='name'>".$member['name']."</li>
				<li class='surname'>".$member['surname']."</li>
				<li class='email'>".$member['email']."</li>..</li>
				</ul>";	
			} //while loop
		
		} //perm if	
	
	}// if
}// if $result
?>


<a href="/?p=panel">Oppdater liste</a>

	
<? } else {
	
	echo "Ingen rettigheter.";
	
}

?>


 <div class="overlay"></div>
 	<div class="modalReg modal">
        	<div class="close">X</div>
            
		    <h2>Registerings form</h2>
			<form id="register" action="#" method="post">
			    <label>Navn</label><br />
			    <input id="name" name="name" class="inputs" type="text" /><br />
			    <label>Etternavn</label><br />
			    <input id="surname" name="surname" class="inputs" type="text" /><br />
			    <label>E-post</label><br />
			    <input id="email" name="email" class="inputs" type="text" /><br />
			    <label>Passord</label><br />
			    <input id="password" name="password" class="inputs" type="password"/>
			    <label>Rettigheter</label><br />
			<div class="checkboxes">
            <?php
			//When calling this function, the checkboxes act diffrent then the edit form.
			 display_perm(1,1);
			?>	
            </div>
		    </form>
		    <a href="#" class="submit">Legg til</a>
		    <br />
           	 <div class="messages"></div>
	<div class="messagesError"></div>     
 </div>
        
        
        <div class="modalEdit modal">
        	<div class="close">X</div>
            
            <h2>Redigeringsform</h2>
        	<form id="editForm" action="#" method="post">
            <input type="hidden" id="editID" name="editID" />
            <label>Navn</label><br />
            <input id="name2" name="name2" class="inputs" type="text" /><br />
            <label>Etternavn</label><br />
            <input id="surname2" name="surname2" class="inputs" type="text" /><br />
            <label>E-post</label><br />
            <input id="email2" name="email2" class="inputs" type="text" /><br />
            <label>Passord</label><br />
            <input id="password2" name="password2" class="inputs" type="password"/>
            <label>Gjenta passord</label><br />
            <input id="confirm_password2" name="confirm_password2" class="inputs" type="password"/><br />
            <div class="checkboxes">
            </div>
            </form>
            
            <a href="#" class="submitEdit">Lagre</a>
            <br />
            <div class="messages"></div>
            <div class="messagesError"></div>
		 </div>
         
         
         <div class="modalChange modal">
        	<div class="close">X</div>
            
            <h2>Endre passord</h2>
        	<form id="changeForm" action="#" method="post">
            <input type="hidden" id="editID" name="editID" />
            <label>Gammelt passord</label><br />
            <input id="old_password" name="old_password" class="inputs" type="password"/><br />
             <label>Nytt passord</label><br />
            <input id="new_password" name="new_password" class="inputs" type="password"/><br />
             <label>Gjennta nytt passord</label><br />
            <input id="confirm_password" name="confirm_password" class="inputs" type="password"/>
            
            </form>
            
            <a href="#" class="submitChange">Lagre</a>
            <br />
            <div class="messages"></div>
            <div class="messagesError"></div>
		 </div>           
 
