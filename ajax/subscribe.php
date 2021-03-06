<?php
require_once("../includes/config.php");

if(isset($_POST['userTo']) && isset($_POST['userFrom'])) {
	
	$userTo = $_POST['userTo'];
	$userFrom = $_POST['userFrom'];

	// Check if the user is subscribed
	$query = $con->prepare("SELECT * FROM subscribers WHERE userTo=:userTo AND userFrom=:userFrom");
	$query->bindParam(":userTo", $userTo);
	$query->bindParam(":userFrom", $userFrom);
	$query->execute();

	if($query->rowCount() == 0) {
		// if not subscribed - Insert
		$query = $con->prepare("INSERT INTO subscribers(userTo, userFrom) VALUES(:userTo, :userFrom)");
		$query->bindParam(":userTo", $userTo);
		$query->bindParam(":userFrom", $userFrom);
		$query->execute();
	}
	else {
		// if subscribed - Delete
		$query = $con->prepare("DELETE FROM subscribers WHERE userTo=:userTo AND userFrom=:userFrom");
		$query->bindParam(":userTo", $userTo);
		$query->bindParam(":userFrom", $userFrom);
		$query->execute();
	}
	// return new number of subs
	$query = $con->prepare("SELECT * FROM subscribers WHERE userTo=:userTo");
	$query->bindParam(":userTo", $userTo);
	$query->execute();

	echo $query->RowCount();
}
else {
	echo "One or more parameters are not passed into subscribe.php file";
}

?>