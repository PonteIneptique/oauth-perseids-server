CREATE DATABASE oAuthServer;
GRANT USAGE ON *.* to perseids@localhost identified by 'perseids';
GRANT ALL PRIVILEGES ON oAuthServer.* to perseids@localhost ;

/*
 *
 * Largely inspired by https://github.com/jasongrimes/silex-simpleuser/blob/master/sql/mysql.sql
 * 
 */
CREATE TABLE oAuthServer.`users` (
	`id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`email` VARCHAR(100) NOT NULL DEFAULT '',
	`password` VARCHAR(255) DEFAULT NULL,
	`salt` VARCHAR(255) NOT NULL DEFAULT '',
	`roles` VARCHAR(255) NOT NULL DEFAULT '',
	`name` VARCHAR(100) NOT NULL DEFAULT '',
	`time_created` INT NOT NULL DEFAULT 0,
	PRIMARY KEY (`id`),
	UNIQUE KEY `unique_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE oAuthServer.`user_custom_fields` (
user_id INT(11) UNSIGNED NOT NULL,
attribute VARCHAR(50) NOT NULL DEFAULT '',
value VARCHAR(255) DEFAULT NULL,
PRIMARY KEY (user_id, attribute)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;