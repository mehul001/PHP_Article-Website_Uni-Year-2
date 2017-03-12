<?php 
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {//if logged in
require('config.php');
//$results = $pdo->query('SELECT * FROM users');

$categories = new DatabaseTable($pdo, 'users');
$results = $categories->select();

$tableGenerator = new TableGenerator();
$tableGenerator->setHeadings(['Firstname', 'Surname', 'E-mail', 'Delete']);

foreach ($results as $row){
	$user_1 = new User($row['name'], $row['surname'], $row['email'],
		'<a href="viewadmin&id= '.$row['id'].'">Delete</a>');
	$user_info = array($user_1->getName(), $user_1->getSurname(), $user_1->getEmail(), $user_1->getLink());
	$tableGenerator->addRow($user_info);	
}

echo '<p>All current administrators are displayed below</p>';

echo $tableGenerator->getHTML();

if(isset($_GET['id'])){
	$_SESSION['delete_id_post'] = $_GET['id'];
	//echo $_SESSION['delete_id_post'];
	header("Refresh: 0;url=deleteadmin");
}


} else {//if not logged this will be displayed
	echo '<p>Error 403: Access Denied/Forbidden</p>
		<p>You will Shortly Be Redirected To The Homepage...</p>';
header("Refresh: 2;url=index");	
}

?>