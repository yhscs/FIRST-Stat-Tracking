<?php
	include_once('../db.php');
	
	$team = $_POST['team'];
	$round = $_POST['roundNum'];
	$make = $_POST['make'];
	
	if ($make == 0)
		$result=$dbh->prepare("INSERT INTO `High Goal` (`Team`, `Made`, `Missed`, `Round`) VALUES (?, '0', '1', ?)");
	else
		$result=$dbh->prepare("INSERT INTO `High Goal` (`Team`, `Made`, `Missed`, `Round`) VALUES (?, '1', '0', ?)");
	$result->execute(array($team,$round));
?>