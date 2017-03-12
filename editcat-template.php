<?php 
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {//if logged in
require('config.php');
//$results = $pdo->query('SELECT * FROM categories WHERE cat_id = "'.$_SESSION['edit_id_post'].'"');

$categories = new DatabaseTable($pdo, 'categories');
$results = $categories->find('cat_id',$_SESSION['edit_id_post']);

$edit = $_SESSION['edit_id_post'];
?>	
	

	<P>Please Make Your Changes Below</P>
	
	<form action="editcat" method="POST"> 		
			<table style="width:500px">
				<tr>
					<td><label for="myinput">Category Name:</label></td>
					<?php 
					foreach ($results as $row) {
					echo '<td><input type="text"  name="name1" value="'.$row['cat_name'].'" required  /></td>'; 
					}
					?>
				</tr>
				<tr>
					<td><label for="myinput">Description: </label></td>
					
					<?php
					//foreach ($results as $row) {
					echo '<td><textarea name="mytextarea" required/>'. $row['cat_desc'] .'</textarea></td>';
					//}
					?>
				</tr>	
			</table><br>
		<input type="submit" value="Submit" name="submit" /> 	 
		</form>


<?php 
} else {//if not logged this will be displayed
	echo '<p>Error 403: Access Denied/Forbidden</p>
		<p>You will Shortly Be Redirected To The Homepage...</p>';
header("Refresh: 2;url=index");	
}
require("config.php");
if ((isset($_POST['name1']) && $_POST['mytextarea'])) {
	//prepare statement	
	//$stmt = $pdo->prepare('UPDATE categories SET cat_name=:catName, cat_desc=:catDescription WHERE cat_id = "'.$edit.'"
	//');
//prepare statement entry data
	$criteria = [
			'cat_name' => $_POST['name1'],
			'cat_desc' => $_POST['mytextarea']
	];
//executes the prepare statement
	//$stmt ->execute ($criteria);	
	$insert = new DatabaseTable($pdo, 'categories');
	$results = $insert->update($pdo, $criteria, 'categories', 'cat_id', $edit);
	/****************************/

				$id_user = $_SESSION['loggedin'];
				$type_info = 'AMEND';
				$description = 'A CATEGORY Was Amended - ' . $_POST['name1'];
				
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
	
	$_SESSION['edit_id_post'] = 0;
	header('Location: temp'); //redirection
} 