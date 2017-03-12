<?php
session_start();

require 'loadTemplate.php';

function autoload($name) {//auto-loaders to load objects/classes
	require strtolower($name) . '.php';
}

spl_autoload_register('autoload');  



if (isset ($_GET['page'])){
	require $_GET['page'] . '.php';
} else {
	$title = 'Blog';
	$header = 'Blog : Homepage';
	$content = loadTemplate('index-template.php');	
}

	$templateVars = [
	 'title' => $title,	 
	 'header' => $header,
	 'content' => $content
	];

	echo loadTemplate('layout.php', $templateVars);
?>



