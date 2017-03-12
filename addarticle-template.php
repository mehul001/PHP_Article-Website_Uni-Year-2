<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {//if logged in

require('config.php');
//$results = $pdo->query('SELECT * FROM categories');
$categories = new DatabaseTable($pdo, 'categories');
$results = $categories->select();
?>

<p>To create an article please fill out the form below & also to when the article to be published online</p>

<form action="addarticle" method="POST"> 		
		<table style="width:500px">
			<tr>
				<td><label for="myinput">Article Title:</label></td>
				<td><input type="text"  name="title" placeholder="Title" required  /></td>
			</tr>
			<tr>
				<td> <label for="myinput">Category :</label> </td>
				<td>
				
				<select  name="category"required > 
					<option value = "">Please Select...</option>
					<?php foreach ($results as $row) {
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
				<td><label for="myinput">Author : </label></td>
				<td><input type="text"  name="author" placeholder="e.g. Mehul Chamunda" required  /></td>
			</tr>
			<tr>
				<td><label for="myinput">Day (dd): </label></td>
				<td><input type="text"  name="day" placeholder="09" required  /></td>
			</tr>
			<tr>
				<td><label for="myinput">Month (mm): </label></td>
				<td><input type="text"  name="month" placeholder="09" required  /></td>
			</tr>
			<tr>
				<td><label for="myinput">Year (yyyy): </label></td>
				<td><input type="text"  name="year" placeholder="2016" required  /></td>
			</tr>
			<tr>
				<td><label for="myinput">Article Content </label></td>
				<td><textarea name="mytextarea2" required placeholder="Article Content" /></textarea></td>
			</tr>				
		</table><br>
	<input type="submit" value="Submit" name="submit" /> 	 
</form>
		
		
<?php
} else {//if not logged this will be displayed
		echo '<p>Error 403: Access Denied/Forbidden</p>
		<p>You will Shortly Be Redirected To The Homepage...</p>';
		header("Refresh: 2;url=index.php");	//redirection to homepage
}
if (isset ($_POST['submit'])){
	$date = $_POST['year'].'-'.$_POST['month'].'-'.$_POST['day'];
	
	//$stmt = $pdo->prepare('INSERT INTO articles VALUES(DEFAULT, :title, :category, :date, :content)	');
	//prepare statement entry data
		$criteria = [
				'title' => $_POST['title'],
				'article_category' => $_POST['category'],
				'publish_date' => $date,
				'article_content' => $_POST['mytextarea2'],
				'article_author' => $_POST['author']
		];

	//$stmt ->execute ($criteria);//executes the prepare statement
	$insert2 = new DatabaseTable($pdo, 'articles');
			$results2 = $insert2->insert($pdo, 'articles', $criteria);
	/****************************/

	$id_user = $_SESSION['loggedin'];
	$type_info = 'CREATE';
	$description = 'A New Article Was Created - ' . $_POST['title'] ;
	
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
	//echo $entry;
	$insert2 = new DatabaseTable($pdo, 'edit');
			$results2 = $insert2->insert($pdo, 'edit', $criteria_1);
	
	/***************************/
	header('Location: temp'); //redirection
}	
?>