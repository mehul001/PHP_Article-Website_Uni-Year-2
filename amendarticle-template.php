<?php 
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {//if logged in
require('config.php');
//$_SESSION['edit_id_post'] = 200001;
//$results = $pdo->query('SELECT * FROM articles WHERE article_id = "'.$_SESSION['edit_id_post'].'"');
//$results_c = $pdo->query('SELECT * FROM categories');
$articles = new DatabaseTable($pdo, 'articles');
$results = $articles->find('article_id', $_SESSION['edit_id_post']);


//$results_c = $pdo->query('SELECT * FROM categories');
$categories = new DatabaseTable($pdo, 'categories');
$results_c = $categories->select();

$edit = $_SESSION['edit_id_post'];
foreach ($results as $row){
				$hello = $row['publish_date'];
			}
$dates = explode("-",$hello);
?>	

<P>Please Make Your Changes Below</P>

<form action="amendarticle" method="POST"> 		
	<table style="width:500px">
		<tr>
			<td><label for="myinput">Article Title:</label></td>
			<?php 
			//$results = $pdo->query('SELECT * FROM articles WHERE article_id = "'.$_SESSION['edit_id_post'].'"');
			foreach ($results as $rows) {
			echo '<td><input type="text"  name="title" value="'.$row['title'].'" required  /></td>'; 
			}
			?>
		</tr>
		<tr>
			<td><label for="myinput">Author : </label></td>
			<?php
		echo '<td><input type="text"  name="author" value="'.$row['article_author'].'" required  /></td>';
			?>
		</tr>
		<tr>
		<td> <label for="myinput">Category :</label> </td>
		<td>
		
		<select  name="category"required > 
			<option value = "">Please Select...</option>
			<?php foreach ($results_c as $row) {
				 echo '<option value="'.$row['cat_id'].'">' . $row['cat_name'] .  '</option>';
				} ?>
			</select>
		</td>
		</tr>
		<tr>
			<td><label for="myinput">Publish Date: </label></td>
			<td><label for="myinput"> ↓ </label></td>
			
		</tr>
		
		
		
		<tr>
			<td><label for="myinput">Day (dd): </label></td>
			<?php
		echo '<td><input type="text"  name="day" value="'.$dates[2].'" required  /></td>';	
			?>
		</tr>
		<tr>
			<td><label for="myinput">Month (mm): </label></td>
			<?php
		echo '<td><input type="text"  name="month" value="'.$dates[1].'" required  /></td>';	
			?>
		</tr>
		<tr>
			<td><label for="myinput">Year (yyyy): </label></td>
			<?php
		echo '<td><input type="text"  name="year" value="'.$dates[0].'" required  /></td>';	
			?>
		</tr>
		<tr>
			<td><label for="myinput">Article Content </label></td>
			<?php 
			$results = $pdo->query('SELECT * FROM articles WHERE article_id = "'.$_SESSION['edit_id_post'].'"');
			foreach ($results as $row) {
			echo '<td><textarea name="mytextarea2" />'. $row['article_content'] .'</textarea></td>'; 
			}
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

if (isset($_POST['submit'])) {
	$date = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];
	//prepare statement	
	//$stmt = $pdo->prepare('UPDATE articles SET title=:title, article_category=:category, publish_date=:date, article_content=:content WHERE article_id = "'.$_SESSION['edit_id_post'].'"
	//');
//prepare statement entry data
	$criteria = [
				'title' => $_POST['title'],
				'article_category' => $_POST['category'],
				'publish_date' => $date,
				'article_content' => $_POST['mytextarea2'],
				'article_author' => $_POST['author']
		];
//executes the prepare statement
	//$stmt ->execute ($criteria);	
	$insert = new DatabaseTable($pdo, 'articles');
	$results = $insert->update($pdo, $criteria, 'articles', 'article_id', $_SESSION['edit_id_post']);
	//echo $date;
	
	/****************************/

				$id_user = $_SESSION['loggedin'];
				$type_info = 'AMEND';
				$description = 'An ARTICLE Was Amended - ' . $_POST['title'];
				
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
	
	$_SESSION['edit_id_post'] = 0;
	header('Location: temp'); //redirection
} 

?>