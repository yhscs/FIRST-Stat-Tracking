<?php
	include_once('../db.php');
	
	$team = $_POST['team'];
	$round = $_POST['roundNum'];
	$time = $_POST['time'];
	
	$result=$dbh->prepare("SELECT `ID` FROM `Boardship` WHERE `Team` = ? AND `Round` = ? LIMIT 1");
	$result->execute(array($team, $round));
	$result=$result->fetch();
	
	if ($result['ID'] == null)
	{
		$result=$dbh->prepare("INSERT INTO `Boardship` (`Team`, `Round`, `Time`) VALUES (?, ?, ?)");
		$result->execute(array($team,$round,$time));
	}
	else
	{
		$result=$dbh->prepare("UPDATE `Boardship` SET `Time` = ? WHERE `Team` = ? AND `Round` = ? LIMIT 1");
		$result->execute(array($time, $team, $round));
	}
?>