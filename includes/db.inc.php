<?php

/**
$hostname = 'localhost';
**/
$username = 'immutabl_imhues';

$password = 'ArvixeClave*7';

try {
    $pdo = new PDO('mysql:host=localhost;dbname=immutabl_CHATDB', $username, $password);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->exec('SET NAMES "utf8"');
    }
catch(PDOException $e)
    {
	$output = 'Unable to connect to the datebase server.' . $e->getMessage();
	include 'output.html.php';
	exit();
    }

/***
$output = 'Database connection established.';
include 'output.html.php';
***/

/***?>***/

	