<?php
require 'config.php';
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {


$results = $pdo->query('SELECT * FROM users WHERE id = "'.$_SESSION['loggedin'].'"');
	foreach ($results as $row) {
					$name = 'Welcome Back '. $row['name'] . ' ' . $row['surname'];
	} 
}
else $name = 'Welcome To The Website';

echo '<p>' . $name . '</p>';
?>