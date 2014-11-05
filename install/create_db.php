<?php

	$config = array(
		'driver' => 'pdo_mysql',
		'host' => 'localhost',
		'port' => '3306',
		'user' => 'root',
		'password' => 'root',
	);

	#$config = require_once __DIR__ . "/../src/config/db.php";

	$pdo = new PDO('mysql:host=' . $config["host"] . ';port=' . $config["port"] . ';', $config["user"], $config["password"]);

	//Create the DB if needed
	$sql = file_get_contents( __DIR__ . '/database.sql' );
	$st = $pdo->prepare( $sql, array( PDO::ATTR_EMULATE_PREPARES => true ) );
	$st->execute();

?>