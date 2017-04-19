<?php
	include_once('../db.php');
	
	$team = $_POST['team'];
	$round = $_POST['roundNum'];
	
	$result=$dbh->prepare("INSERT INTO `Low Goal` (`Team`, `Round`) VALUES (?, ?)");
	$result->execute(array($team,$round));
?>