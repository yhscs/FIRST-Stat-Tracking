<?php
	include_once('../db.php');
	
	$team = $_POST['team'];
	$round = $_POST['roundNum'];
	
	$result=$dbh->prepare("SELECT `ID` FROM `Gear` WHERE `Team` = ? AND `Round` = ? LIMIT 1");
	$result->execute(array($team, $round));
	$result=$result->fetch();
	
	if ($result['ID'] == null)
	{
		$result=$dbh->prepare("INSERT INTO `Gear` (`Team`, `Round`, `Placed`) VALUES (?, ?, ?)");
		$result->execute(array($team,$round,1));
		echo 'INSERT';
	}
	else
	{
		$result=$dbh->prepare("UPDATE `Gear` SET `Placed` = `Placed` + 1 WHERE `Team` = ? AND `Round` = ? LIMIT 1");
		$result->execute(array($team,$round));
		echo 'UPDATE';
	}
?>