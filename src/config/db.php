<?php
return array
	/*
	'driver' => 'pdo_mysql',
	'port' => $_SERVER['RDS_PORT'],
	'host' => $_SERVER['RDS_HOSTNAME'],
	'dbname' => $_SERVER['RDS_DB_NAME'],
	'user' => $_SERVER['RDS_USERNAME'],
	'password' => $_SERVER['RDS_PASSWORD'],
	*/
    'driver' => 'pdo_sqlite',
    'path' => __DIR__.'/../../cache/.ht.sqlite',
);
