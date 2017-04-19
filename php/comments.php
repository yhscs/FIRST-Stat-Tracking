<?php
	include_once('../db.php');
	
	$team = $_POST['team'];
	$round = $_POST['roundNum'];
	$comments = $_POST['comments'];
	
	$result=$dbh->prepare("UPDATE `Game` SET `Comments` = ? WHERE `Round` = ? AND `Team` = ?");
	$result->execute(array( $comments, $round, $team));
?>