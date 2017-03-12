<P>All current articles are displayed below. <br> 
To view articles by category please select one from the <b>category</b> drop down menu.<br>
To view a specific article please select one from the <b>article</b> drop down menu.</P>

<?php
require('config.php');	

$tableGenerator = new TableGenerator();//category table
$tableGenerator2 = new TableGenerator();//admin category table

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
$tableGenerator2->setHeadings(['Article Title', 'Publish Date', 'Edit/Delete']);
} else {
	$tableGenerator->setHeadings(['Article Title', 'Publish Date']);
}		
$today = date("Y-m-d");
?>

<form action="listarticle" method="POST" >
	<table style="width:550px">
		<tr>
			<td> <label for="myinput">Article :</label> </td>
			<td>
				<select  name="article"required > 
					<option value = "">Please Select...</option>
					<?php 
					//$results = $pdo->query('SELECT * FROM articles WHERE publish_date <= "'.$today.'" ;');
					$articleTable = new DatabaseTable($pdo, 'articles');
					$record = $articleTable->find('publish_date <', date("Y-m-d"));
					foreach ($record as $row) {
						 echo '<option value="'.$row['article_id'].'">' . $row['title'] .  '</option>';
						} ?>
				</select>
			</td>
			<td>
				<input type="submit" name="submit" value="Go!" style="width: 130px; height: 40px; ">
			</td>
			
</form>

<form action="listarticle" method="POST"> 		
				<td> <label for="myinput">Search :</label> </td>
				<td>				
					<input type="text" id="myinput" name="search" />
				</td>
				<td>
				<input type="submit" name="search2" value="Search" style="width: 70px; height: 40px; ">
				</td>
			</tr>
		</table>
		<table style="width:700px">	
			<tr>
				<form action="listarticle" method="POST"> 		
					<td> <label for="myinput">Category :</label> </td>
					<td>				
					<select  name="category" > 
					<option value = "">Please Select...</option>
					<?php 
					$categoryTable = new DatabaseTable($pdo, 'categories');
					$results_c = $categoryTable->select();
					//$results_c = $pdo->query("SELECT * FROM categories");
					foreach ($results_c as $row) {
						 echo '<option value="'.$row['cat_id'].'">' . $row['cat_name'] .  '</option>';
						} ?>
					</select>
				</td>
				<td>
				<input type="submit" name="submit_filter" value="Search" style="width: 70px; height: 40px; ">
				</td> 			
				</form>	
			</tr>	
				
		</table>
	</form>	

<br><br>
<?php


if (isset ($_GET['edit_id'])){
	$_SESSION['edit_id_post'] = $_GET['edit_id'];
	//echo $_SESSION['edit_id_post'];
	header("Refresh: 0;url=amendarticle");	
}

if(isset($_GET['id'])){
	$_SESSION['delete_id_post'] = $_GET['id'];
	echo $_SESSION['delete_id_post'];
	header("Refresh: 0;url=deletearticle");
}

if(isset($_POST['submit'])){
	$_SESSION['article_id'] = $_POST['article'];
	//echo $_SESSION['article_id'];
	header("Refresh: 0;url=viewarticle");
}

if(isset($_POST['search2'])){

	$today = date("Y-m-d");
	$search = $_POST['search'];
	/*
	$results = $pdo->prepare('SELECT * FROM articles WHERE publish_date <= "'.$today.'" AND title LIKE "%" :search "%"');
	$criteria = [
			'search' => $search
			];

			$results ->execute ($criteria);	
		*/	
	$articleTable2 = new DatabaseTable($pdo, 'articles');
	$record2 = $articleTable2->where_like('publish_date <', date("Y-m-d"), 'title', $_POST['search']);		
			
	foreach ($record2 as $row){
		
		$article_1 = new Article($row['title'], $row['article_category'], $row['publish_date'], $row['article_content']);		
		
		
		$article_info = array($article_1->getTitle(), $article_1->getDate());
		$tableGenerator->addRow($article_info);	
		
		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
			$article_1 = new Article_Admin($row['title'], $row['article_category'], $row['publish_date'], $row['article_content'],
			'<a href="listarticle&id= '.$row['article_id'].'">Delete</a> / <a href="listarticle&edit_id='.$row['article_id'].'">Edit</a>');
			
			$article_info = array($article_1->getTitle(), $article_1->getDate(), $article_1->getLink());
			$tableGenerator2->addRow($article_info);
		}
	}
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
		echo $tableGenerator2->getHTML(); 
	} else {
		echo $tableGenerator->getHTML();
	}




} else if (isset($_POST['submit_filter'])){ 
	$record_filter = $pdo->query('SELECT * FROM articles WHERE publish_date < "'.date("Y-m-d").'" AND article_category = "'.$_POST['category'].'"');
		
		foreach($record_filter as $row){
		$article_1 = new Article($row['title'], $row['article_category'], $row['publish_date'], $row['article_content']);		
		$article_info = array($article_1->getTitle(), $article_1->getDate());
		$tableGenerator->addRow($article_info);	
		
		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
			$article_1 = new Article_Admin($row['title'], $row['article_category'], $row['publish_date'], $row['article_content'],
			'<a href="listarticle&id= '.$row['article_id'].'">Delete</a> / <a href="listarticle&edit_id='.$row['article_id'].'">Edit</a>');
			
			$article_info = array($article_1->getTitle(), $article_1->getDate(), $article_1->getLink());
			$tableGenerator2->addRow($article_info);
		}
}
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	echo $tableGenerator2->getHTML(); 
} else {
	echo $tableGenerator->getHTML();
}

}
else {
	$today = date("Y-m-d");
	//$results = $pdo->query('SELECT * FROM articles WHERE publish_date <= "'.$today.'" ;');

	$articleTable2 = new DatabaseTable($pdo, 'articles');
	$record3 = $articleTable2->find('publish_date <', date("Y-m-d"));
	
	foreach ($record3 as $row){
		$article_1 = new Article($row['title'], $row['article_category'], $row['publish_date'], $row['article_content']);		
		$article_info = array($article_1->getTitle(), $article_1->getDate());
		$tableGenerator->addRow($article_info);	
		
		if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
			$article_1 = new Article_Admin($row['title'], $row['article_category'], $row['publish_date'], $row['article_content'],
			'<a href="listarticle&id= '.$row['article_id'].'">Delete</a> / <a href="listarticle&edit_id='.$row['article_id'].'">Edit</a>');
			
			$article_info = array($article_1->getTitle(), $article_1->getDate(), $article_1->getLink());
			$tableGenerator2->addRow($article_info);
		}
}
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
	echo $tableGenerator2->getHTML(); 
} else {
	echo $tableGenerator->getHTML();
}
}
?>