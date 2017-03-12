<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {//if logged in

?>

<P>To create a category please fill out the form below</P>
	
	<form action="addcat" method="POST"> 		
			<table style="width:500px">
				<tr>
					<td><label for="myinput">Category Name:</label></td>
					<td><input type="text"  name="name1" required  /></td>
				</tr>
				<tr>
					<td><label for="myinput">Description: </label></td>
					<td><textarea name="mytextarea" required/></textarea></td>
				</tr>	
			</table><br>
		<input type="submit" value="Submit" name="submit" /> 	 
	</form>


<?php
require('config.php');
} else {//if not logged this will be displayed
	echo '
	<main>
		<p>Error 403: Access Denied/Forbidden</p>
		<p>You will Shortly Be Redirected To The Homepage...</p>
		
	</main>
	';
header("Refresh: 2;url=index");	
}

if ((isset($_POST['name1']) && $_POST['mytextarea'])) {
	//prepare statement	
	//$stmt = $pdo->prepare('INSERT INTO categories VALUES(DEFAULT, :catName, :catDescription)	');
//prepare statement entry data
	$criteria = [
			'cat_name' => $_POST['name1'],
			'cat_desc' => $_POST['mytextarea']
	];
	
	$insert2 = new DatabaseTable($pdo, 'categories');
			$results2 = $insert2->insert($pdo, 'categories', $criteria);
	
	//$stmt ->execute ($criteria);//executes the prepare statement
	
	/****************************/

	$id_user = $_SESSION['loggedin'];
	$type_info = 'CREATE';
	$description = 'A New Category Was Created - ' . $_POST['name1'] ;
	
	//prepare statement	
	//$entry = $pdo->prepare('INSERT INTO edit VALUES(DEFAULT, :date, :type, :desc, :author)');
	//prepare statement entry data
	$criteria_1 = [	
	'edit_datetime' => date("d-m-Y"),
			'edit_type' => $type_info,
			'edit_desc' => $description,
			'author_id' => $id_user
	];

	//$entry ->execute ($criteria_1);//executes the prepare statement
	
			
			$insert2 = new DatabaseTable($pdo, 'edit');
			$results2 = $insert2->insert($pdo, 'edit', $criteria_1);
	
	/***************************/
	
	header('Location: temp'); //redirection
}