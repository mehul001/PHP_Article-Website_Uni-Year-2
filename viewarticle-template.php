<?php
require ('config.php');
//$_SESSION['article_id'] = 200003;

if (!(isset ($_SESSION['article_id']))){
	echo '<p>Error 404: Article Not Found</p>	
		<p>You will Shortly Be Redirected To The Homepage...</p>';
		header("Refresh: 2;url=index");	//redirection to homepage
}else {

$results = $pdo->query('SELECT * FROM articles WHERE article_id = "'.$_SESSION['article_id'].'"');

foreach ($results as $row){
	$article_1 = new Article($row['title'], $row['article_category'], $row['publish_date'], $row['article_content']);		
}

$results_2 = $pdo->query('SELECT cat_name FROM categories WHERE cat_id = "'.$article_1->getCategory().'"');


foreach ($results_2 as $row){
	$name = $row['cat_name'];
}

?>
<p>Your Desired article is displayed below... Enjoy!</p> <br>

<table style="width:700px">

	<tr><td><b>Article Title : </b></td>			<td><?php echo $article_1->getTitle() ?> </tr></td>
	<tr><td><b>Article Publish Date : </b></td>		<td><?php echo $article_1->getDate() ?></tr></td>
	<tr><td><b>Article Category : </b></td>			<td><?php echo $name ?> </tr></td>
	<tr><td><b>Article Content : </b></td>			<td>↓</tr></td>
</table>
<br>
<div class="content" >
	<?php echo $article_1->getContent() ?> 
</div>

<div class="comment">
<h4>Comments...</h4>
<?php

	//$results_3 = $pdo->query('SELECT * FROM comments WHERE article_id = "'.$_SESSION['article_id'].'" ORDER BY comment_id ASC');
	
$articles = new DatabaseTable($pdo, 'comments');
$results_3 = $articles->find('article_id', $_SESSION['article_id']);
	
	foreach ($results_3 as $row){
		echo '<b>'.$row['name']." ". $row['surname']." - ".$row['comment_date'].'</b>';
		echo '<div class="comment_2">';
		echo	$row['comment_content'];
		echo  '</div>';
		
	}
?>
</div>

<table style="width:700px">
	<form action="viewarticle" method="POST"> 
		<tr>
			<td><label for="myinput">Firstname :</label></td>	
			<td><input type="text"  name="name" placeholder="Firstname..." required  /></td>
		</tr>
		<tr>
			<td><label for="myinput">Surname :</label></td>	
			<td><input type="text"  name="surname" placeholder="Surname..." required  /></td>
		</tr>
		<tr>
			<td><label for="myinput">Comment :</label></td>	
			<td><textarea name="mytextarea2" required placeholder="Your Comment..." /></textarea></td>
		</tr>		
</table><br>
<input type="submit" value="Submit" name="submit" /> 


<?php


if (isset($_POST['submit'])){
	//	$stmt = $pdo->prepare('INSERT INTO comments VALUES(DEFAULT, :article_id, :comment, :date, :name, :surname)
	//	');
	//prepare statement entry data
		$criteria = [
				'article_id' => $_SESSION['article_id'],
				'comment_content' => $_POST['mytextarea2'],
				'comment_date' => date("Y-m-d"),
				'name' => $_POST['name'],
				'surname' => $_POST['surname']
		];

	//$stmt ->execute ($criteria);//executes the prepare statement
	
	$insert2 = new DatabaseTable($pdo, 'comments');
			$results2 = $insert2->insert($pdo, 'comments', $criteria);
	header('Location: viewarticle'); 
}
} //error article not found
?>