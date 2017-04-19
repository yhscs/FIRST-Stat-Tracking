<?php
	include_once('../db.php');
	
	$team = $_POST['team'];
	$round = $_POST['roundNum'];
	$value = $_POST['value'];
	
	if ($value == "true")
		$value = 1;
	else
		$value = 0;
	
	$result=$dbh->prepare("SELECT `ID` FROM `Gear` WHERE `Team` = ? AND `Round` = ? LIMIT 1");
	$result->execute(array($team, $round));
	$result=$result->fetch();
	
	if ($result['ID'] == null && $value == 1)
	{
		$result=$dbh->prepare("INSERT INTO `Gear` (`Team`, `Round`, `Picked`) VALUES (?, ?, 1)");
		$result->execute(array($team,$round));
	}
	else if ($result['ID'] != null && $value == 0)
	{
		$result=$dbh->prepare("UPDATE `Gear` SET `Picked` = 0 WHERE `Team` = ? AND `Round` = ? LIMIT 1");
		$result->execute(array($team, $round));
	}
?>