<?php
$server = 'localhost';
$username = 'student';
$password = 'student';
$schema = 'csy2028_Articles';

$pdo = new PDO('mysql:dbname=' . $schema . ';host=' . $server, $username, $password);
?>