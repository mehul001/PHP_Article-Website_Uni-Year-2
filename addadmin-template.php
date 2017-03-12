<?php
require 'config.php';//settings file for database
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {//if logged in

?>

<P>Please Fill Out the Fields Below To Add an Admin User</P>
	
	<form action="addadmin" method="POST"> 	 
		<table style="width:500px">
			<tr>
				<td><label for="myinput">Firstname :</label> </td>
				<td><input type="text"  name="name" required  /></td>
		  </tr>
			<tr>
				<td><label for="myinput">Surname :</label> </td>
				<td><input type="text"  name="surname" required  /></td>
		  </tr>	
		    <tr>
				<td><label for="myinput">E-mail Address :</label></td>
				<td><input type="email"  name="email" required  /></td>
		  </tr>		  
		   <tr>
				<td><label for="myinput">Password :</label> </td>
				<td><input type="password"  name="password" required  /></td>
		  </tr>		  
		   <tr>
				<td><label for="myinput">Password Confirmation :</label> </td>
				<td><input type="password"  name="password_c" required  /></td>
		  </tr>	 
		   		  
		</table> <br>
	<input type="submit" value="Submit" name="submit" /> 
	
	</form>
<?php
} else {
	echo '
	<main>
		<p>Error 403: Access Denied/Forbidden</p>
		<p>You will Shortly Be Redirected To The Homepage...</p>
		
	</main>
	';
header("Refresh: 2;url=index");	
}

if ((isset($_POST['name']) && $_POST['surname'] && $_POST['email'] && $_POST['password']) && $_POST['password_c']) {
	//prepare statement	
	$stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
	//prepare statement entry data
	$criteria = [
	 'email' => $_POST['email']
	];
	//executes the prepare statement
	$stmt->execute($criteria);
	

	if ($stmt->rowCount() <= 0) {

		if ($_POST['password'] == $_POST['password_c']){	
		//prepare statement	
		//	$stmt = $pdo->prepare('INSERT INTO users VALUES(DEFAULT, :email, :password, :name, :surname)
		///	');
			
			$password = $_POST['password'];
			$hash = password_hash($password, PASSWORD_DEFAULT);
		//prepare statement entry data
			$criteria = [
					'name' => $_POST['name'],
					'surname' => $_POST['surname'],
					'email' => $_POST['email'],
					'password' => $hash
			];
			//executes the prepare statement
		//	$stmt ->execute ($criteria);
		$insert = new DatabaseTable($pdo, 'users');
		$results = $insert->insert($pdo, 'users', $criteria);
			/****************************/

			$id_user = $_SESSION['loggedin'];
			$type_info = 'CREATE';
			$description = 'A New Admin Was Created - ' . $_POST['name'] ;
			
			//prepare statement	
			//$entry = $pdo->prepare('INSERT INTO edit VALUES(DEFAULT, :date, :type, :desc, :author)');
			//prepare statement entry data
			$criteria_1 = [	
			'edit_datetime' => date("d-m-Y"),
			'edit_type' => $type_info,
			'edit_desc' => $description,
			'author_id' => $id_user
			];
			
			$insert2 = new DatabaseTable($pdo, 'edit');
			$results2 = $insert2->insert($pdo, 'edit', $criteria_1);

			//$entry ->execute ($criteria_1);//executes the prepare statement			
			/***************************/
			
			header('Location: temp'); 	
		} else {
			echo '<p>ERROR: Passwords Don\'t Match <br> Account Was NOT Created... Please Try Again</p>';
			}
	}else {
			echo '<p>ERROR: E-mail Address Already In Use<br> Account Was NOT Created... Please Try Again</p>';
			}
}
?>	