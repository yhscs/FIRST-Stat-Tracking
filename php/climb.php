<?php
	include_once('../db.php');
	
	$team = $_POST['team'];
	$round = $_POST['roundNum'];
	$value = $_POST['value'];
	$success = $_POST['success'];
	
	if ($value == "true")
		$value = 1;
	else
		$value = 0;
		
	if ($success == "true")
		$success = 1;
	else
		$success = 0;
	
	$result=$dbh->prepare("SELECT `ID` FROM `Boardship` WHERE `Team` = ? AND `Round` = ? LIMIT 1");
	$result->execute(array($team, $round));
	$result=$result->fetch();
	
	if ($result['ID'] == null && $value == 1 && $success == 0)
	{
		$result=$dbh->prepare("INSERT INTO `Boardship` (`Team`, `Round`) VALUES (?, ?)");
		$result->execute(array($team,$round));
	}
	else if ($result['ID'] == null && $value == 1 && $success == 1)
	{
		$result=$dbh->prepare("INSERT INTO `Boardship` (`Team`, `Round`, `Success`) VALUES (?, ?, 1)");
		$result->execute(array($team,$round));
	}
	else if ($result['ID'] != null && $value == 0 && $success == 0)
	{
		$result=$dbh->prepare("DELETE FROM `Boardship` WHERE `Team` = ? AND `Round` = ? LIMIT 1");
		$result->execute(array($team, $round));
	}
	else if ($result['ID'] != null && $success == 1)
	{
		$result=$dbh->prepare("UPDATE `Boardship` SET `Success` = ? WHERE `Team` = ? AND `Round` = ? LIMIT 1");
		$result->execute(array($value, $team, $round));
	}
?>