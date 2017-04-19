<?php
	include_once('../db.php');
	
	$team = $_POST['team'];
	$round = $_POST['roundNum'];
	$side = $_POST['side'];
	
	$result=$dbh->prepare("SELECT `ID` FROM `Auto` WHERE `Team` = ? AND `Round` = ? LIMIT 1");
	$result->execute(array($team, $round));
	$result=$result->fetch();
	
	if ($result['ID'] == null)
	{
		$result=$dbh->prepare("INSERT INTO `Auto` (`Team`, `Round`, `Side`) VALUES (?, ?, ?)");
		$result->execute(array($team,$round,$side));
	}
	else
	{
		$result=$dbh->prepare("UPDATE `Auto` SET `Side` = ? WHERE `Team` = ? AND `Round` = ?");
		$result->execute(array($side, $team, $round));
	}
?>