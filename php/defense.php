<?php
	include_once('../db.php');
	
	$team = $_POST['team'];
	$round = $_POST['roundNum'];
	$defense = $_POST['defense'];
	
	$result=$dbh->prepare("SELECT `ID` FROM `DriverDefense` WHERE `Team` = ? AND `Round` = ? LIMIT 1");
	$result->execute(array($team, $round));
	$result=$result->fetch();
	
	if ($result['ID'] == null)
	{
		$result=$dbh->prepare("INSERT INTO `DriverDefense` (`Team`, `Round`, `Defense`) VALUES (?, ?, ?)");
		$result->execute(array($team,$round,$defense));
	}
	else
	{
		$result=$dbh->prepare("UPDATE `DriverDefense` SET `Defense` = ? WHERE `Team` = ? AND `Round` = ?");
		$result->execute(array($defense, $team, $round));
	}
?>