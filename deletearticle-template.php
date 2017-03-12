<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {

require('config.php');

$delete_id = $_SESSION['delete_id_post'];
//$results = $pdo->query('SELECT * FROM articles WHERE article_id = "'.$delete_id.'" ;');
$articles = new DatabaseTable($pdo, 'articles');
$results = $articles->find('article_id', $delete_id);
?>

<p>Are You Sure You Want To <b>DELETE</b> This Article?</p>

<?php

$tableGenerator = new TableGenerator();//category table
$tableGenerator->setHeadings(['Article Title', 'Publish Date']);


foreach ($results as $row){
	$article_1 = new Article($row['title'], $row['article_category'], $row['publish_date'], $row['article_content']);		
	$article_info = array($article_1->getTitle(), $article_1->getDate());
	$tableGenerator->addRow($article_info);	
}
echo $tableGenerator->getHTML();

echo '<p><b>WARNING!</b> This will also delete all the comments on this article</p>';

echo '<br>
<form action="deletearticle" method="POST"> 
	<input type="submit" value="Delete" name="submit" style="width: 130px; height: 40px; "/> 	 
</form>
';
} else {//if not logged this will be displayed
	echo '<p>Error 403: Access Denied/Forbidden</p>
		<p>You will Shortly Be Redirected To The Homepage...</p>';
header("Refresh: 2;url=index");	
}

if (isset ($_POST['submit'])){
	
	//$pdo->query('DELETE FROM articles WHERE article_id = "'.$delete_id.'"');
	$del_1 = new DatabaseTable($pdo, 'articles');
	$results = $del_1->delete('article_id', $delete_id);


	//$pdo->query('DELETE FROM comments WHERE article_id = "'.$delete_id.'"');
	$del_2 = new DatabaseTable($pdo, 'comments');
	$results = $del_2->delete('article_id', $delete_id);
	/****************************/

	$id_user = $_SESSION['loggedin'];
	$type_info = 'DELETE';
	$description = 'An Article Was Removed - ' . $article_1->getTitle() ;
	
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
	
	$_SESSION['delete_id_post'] = 0;
	header('Location: temp'); //redirection
}
?>