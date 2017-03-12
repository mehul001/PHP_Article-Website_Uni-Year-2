<P>To Login Please Enter Your Credentials Below...</P>
	
	<form action="/login" method="POST"> 	 
		 <table style="width:500px">
	 
		  <tr>
				<td><label for="myinput">E-mail Address :</label></td>
				<td><input type="email"  name="email" required  /></td>
		  </tr>		  
		   <tr>
				<td><label for="myinput">Password :</label> </td>
				<td><input type="password"  name="password" required  /></td>
		  </tr>		  		  
		</table> <br>
		<input type="submit" value="Submit" name="submit" /> 	 
	</form>

<?php
require('config.php');
if ((isset($_POST['email']) && $_POST['password'])){
		//prepare statement	
/*	$stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
	//prepare statement entry data
	$criteria = [
	 'email' => $_POST['email'],
	];
	//executes the prepare statement
	$stmt->execute($criteria);

	$user = $stmt->fetch();
*/
			
$login = new DatabaseTable($pdo, 'users');
$user = $login->findLogin('email', $_POST['email']);		
	var_dump ($user);
	
	if (password_verify($_POST['password'], $user['password'])) {
	 $_SESSION['loggedin'] = $user['id'];
	  header('Location: /index');  
	  //echo '<p>Successful</p>';
	}
	else {//if not logged this will be displayed
	 echo '<p>Sorry, your account could not be found...Please Try Again</p>';
	}
}
?>	