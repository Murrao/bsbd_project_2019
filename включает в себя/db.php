<?php

	$host = 'localhost';
	$db_name = 'bsbd_project';
	$db_user = 'bsbd_admin';
	$db_pass = '0kVfA2a4aoSZpyPf';

	$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

	try {
		$db = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $db_user, $db_pass, $options);
	} catch (PDOException $e) {
		die ('Подключение не удалось!');
	}
	
?>
