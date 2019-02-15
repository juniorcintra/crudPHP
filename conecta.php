<?php 
	date_default_timezone_set('America/Sao_Paulo');

	$pdo = new PDO("mysql:host=localhost;dbname=crud_db","root","",  array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

?>