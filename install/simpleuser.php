<?php

	$config = require_once __DIR__ . "/../src/config/db.php";

	$pdo = new PDO('mysql:host=' . $config["host"] . ';port=' . $config["port"] . ';dbname=' . $config["dbname"] . ';', $config["user"], $config["password"]);

	//Create the DB if needed
	$sql = file_get_contents( __DIR__ . '/users.sql' );
	$st = $pdo->prepare( $sql, array( PDO::ATTR_EMULATE_PREPARES => true ) );
	$st->execute();

?>