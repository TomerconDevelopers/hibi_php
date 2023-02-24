<?php

require 'config.php';

$dsn = "mysql:host=$DB_HOST;dbname=$DB_NAME;charset=UTF8;port=$DB_PORT";

try {
	$pdo = new PDO($dsn, $DB_USER, $DB_PASS);

	if ($pdo) {
		return $pdo;
		//echo "Connected to the $db database successfully!";
	}
} catch (PDOException $e) {
	echo $e->getMessage();die;
}