<?php
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {//if logged in
echo '<P>Are you sure you want to delete the selected user (Displayed below)</P>';
require('config.php');
//$results = $pdo->query('SELECT * FROM users WHERE id = "'.$_SESSION['delete_id_post'].'"');
$users = new DatabaseTable($pdo, 'users');
$results = $users->find('id', $_SESSION['delete_id_post']);

$edit = $_SESSION['delete_id_post'];

$tableGenerator = new TableGenerator();
$tableGenerator->setHeadings(['Name', 'Surname', 'E-mail']);

foreach ($results as $row){
	$user_1 = new User($row['name'], $row['surname'], $row['email'],"");
	$user_info = array($user_1->getName(), $user_1->getSurname(), $user_1->getEmail());
	$tableGenerator->addRow($user_info);	
}
echo $tableGenerator->getHTML();
?>
<p><b>Warning!</b> This change is not reversible</p><br>

<form action="deleteadmin" method="POST"> 
	<input type="submit" value="Delete" name="submit" style="width: 130px; height: 40px; "/> 	 
</form>

<?php
} else {//if not logged this will be displayed
	echo '<p>Error 403: Access Denied/Forbidden</p>
		<p>You will Shortly Be Redirected To The Homepage...</p>';
header("Refresh: 2;url=index");	
}

if (isset ($_POST['submit'])){
	
	//$pdo->query('DELETE FROM users WHERE id = "'.$_SESSION['delete_id_post'].'"');
	$users = new DatabaseTable($pdo, 'users');
	$results = $users->delete('id', $_SESSION['delete_id_post']);
	
	/****************************/

	$id_user = $_SESSION['loggedin'];
	$type_info = 'DELETE';
	$description = 'An Admin Was Removed - ' . $user_1->getName() ;
	
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
	//echo $entry;
	
	/***************************/
	
	$_SESSION['delete_id_post'] = 0;
	header('Location: temp'); //redirection
}
?>