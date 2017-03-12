<P>All current categories are displayed below...</P>

<?php
$tableGenerator = new TableGenerator();//category table

$tableGenerator2 = new TableGenerator();//admin category table

require('config.php');

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
$tableGenerator2->setHeadings(['Category Name', 'Category Description', 'Edit/Delete']);
} else {
	$tableGenerator->setHeadings(['Category Name', 'Category Description']);
}
	//$results = $pdo->query('SELECT cat_id, cat_name,cat_desc FROM categories;');	
	
	$categories = new DatabaseTable($pdo, 'categories');
	$record = $categories->select();		

foreach ($record as $row) {
	$cat_1 = new Category($row['cat_name'],$row['cat_desc'] );
	$cat_info = array($cat_1->getName(), $cat_1->getDesc());
	$tableGenerator->addRow($cat_info);		
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
		$cat_1 = new Category_Admin($row['cat_name'],$row['cat_desc'] ,
		'<a href="displaycat&id= '.$row['cat_id'].'">Delete</a> / <a href="displaycat&edit_id='.$row['cat_id'].'">Edit</a>') ;
		//using the tableGenerator
		$cat_info = array($cat_1->getName(), $cat_1->getDesc(), $cat_1->getLink());
		$tableGenerator2->addRow($cat_info);	//using the tableGenerator
	}			
}
 

	if (isset ($_GET['edit_id'])){
		//echo $_GET['edit_id'];
		$_SESSION['edit_id_post'] = $_GET['edit_id'];
		header("Refresh: 0;url=editcat");	
		}
		
	if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
		echo $tableGenerator2->getHTML(); 
	} else {
		echo $tableGenerator->getHTML();
		}//using the tableGenerator
				 
		if(isset($_GET['id'])){
			$_SESSION['delete_id_post'] = $_GET['id'];
			//echo $_SESSION['delete_id_post'];
			header("Refresh: 0;url=deletecat");
		}		
		
		
	?>