<?php
require ('config.php');

$tableGenerator = new TableGenerator(); //category table
$tableGenerator->setHeadings(['Category Name', 'Category Description']);

$tableGenerator2 = new TableGenerator();//job table
$tableGenerator2->setHeadings(['Article Title', 'Article Date']);

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {//if logged in
$delete_id = $_SESSION['delete_id_post'];
//echo '<p>'.$delete_id .'</p>';
//$results = $pdo->query('SELECT * FROM categories WHERE cat_id = "'.$delete_id.'"');
$cat = new DatabaseTable($pdo, 'categories');
$results = $cat->find('cat_id', $delete_id);

//Main Content below
echo'
		<p>Are You Sure You Want To <b>DELETE</b> This Category? <br> Warning This Will Also <b>DELETE ALL ARTICLES</b> Associated Within This Category</p>';			 
				foreach ($results as $row) {//categories to be displayed here
				$cat_1 = new Category($row['cat_name'], $row['cat_desc']);	
					$name = $row['cat_name'];
					$cat_info = array($cat_1->getName(), $cat_1->getDesc());
					$tableGenerator->addRow($cat_info);	//using the tableGenerator
				}//for loop ends here
				echo $tableGenerator->getHTML();//using the tableGenerator
		
		echo '<p>Here Are The articles Associated Within The Category Displayed Above :</p>';
		
		$results_j = $pdo->query('SELECT a.title, a.article_category, a.publish_date, a.article_content, c.cat_name
									FROM articles a
									JOIN categories c
									ON a.article_category = c.cat_id
									WHERE a.article_category = '.$delete_id);
									
		foreach ($results_j as $row) {
				//echo '<p> '.$row['title'] .' </p>';
		$article_1 = new Article($row['title'], $row['article_category'], $row['publish_date'], $row['article_content']);
		
		$article_info = array($article_1->getTitle(), $article_1->getDate());
			
			$tableGenerator2->addRow($article_info);		//using the tableGenerator
		}
		echo $tableGenerator2->getHTML();//using the tableGenerator
		
	echo'	<form action="deletecat" method="POST" >
		<input type="submit" name="submit" value="DELETE" style="width: 130px; height: 40px; ">
		</form>';

			if (isset($_POST['submit'])) {
				//$results = $pdo->query('DELETE FROM categories WHERE cat_id = "'.$delete_id.'"');
				$del_1 = new DatabaseTable($pdo, 'categories');
				$results1 = $del_1->delete('cat_id', $delete_id);
	
				$results_del_1 = $pdo->query('DELETE FROM articles WHERE article_category = '.$delete_id);
				/*$del_2 = new DatabaseTable($pdo, 'articles');
				$results11 = $del_2->delete('article_category', $delete_id);*/
				
				/****************************/

				$id_user = $_SESSION['loggedin'];
				$type_info = 'DELETE';
				$description = 'A CATEGORY Was Removed - ' . $cat_1->getName();
				
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
				
				header('Location: temp');  
			}
			
} else {//if not logged this will be displayed
	echo '<p>Error 403: Access Denied/Forbidden</p>
		<p>You will Shortly Be Redirected To The Homepage...</p>';
header("Refresh: 2;url=index");	//redirection to homepage
}		
?>