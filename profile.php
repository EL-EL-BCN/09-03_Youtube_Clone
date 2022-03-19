<?php 
require_once("includes/header.php");
require_once("includes/Classes/ProfileGenerator.php"); 

if(isset($_GET["username"])) {
	$profileUsername = $_GET["username"];
}
else {
	echo "channel not found";
	exit();
}

$profileGenerator = new profileGenerator($con, $userLoggedInObj, $profileUsername);
 echo $profileGenerator->create();

?>
