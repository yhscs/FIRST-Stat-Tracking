<?php
	include_once('../db.php');
	
	$team = $_POST['team'];
	$round = $_POST['roundNum'];
	$driver = $_POST['driver'];
	
	$result=$dbh->prepare("SELECT `ID` FROM `DriverDefense` WHERE `Team` = ? AND `Round` = ? LIMIT 1");
	$result->execute(array($team, $round));
	$result=$result->fetch();
	
	if ($result['ID'] == null)
	{
		$result=$dbh->prepare("INSERT INTO `DriverDefense` (`Team`, `Round`, `Driver`) VALUES (?, ?, ?)");
		$result->execute(array($team,$round,$driver));
	}
	else
	{
		$result=$dbh->prepare("UPDATE `DriverDefense` SET `Driver` = ? WHERE `Team` = ? AND `Round` = ?");
		$result->execute(array($driver, $team, $round));
	}
?>