<?php
$host = "localhost"; //hostname
$username = "root"; //username
$pass = '';// password
$dbname = "medallion_db"; //database name

try{
	$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $pass);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
}catch(PDOException $e){
	echo "connection failed!" .$e->getMessage();
}
?>