<?php 
ob_start(); // turns on output buffering
session_start(); // turns on use of sessions

date_default_timezone_set("Europe/Madrid"); // sets the default timezone

try {
	$con = new PDO("mysql:dbname=VideoTube; host=localhost", "root", "");
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
}
catch (PDOException $e) {
	echo "connection failed: " . $e->getMessage();
}
?>