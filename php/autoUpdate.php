<?php
	include_once('../db.php');
	
	$team = $_POST['team'];
	$round = $_POST['roundNum'];
	$value = $_POST['value'];
	$type = $_POST['type'];
	
	if ($value == true)
		$value = 1;
	else
		$value = 0;
	
	$result=$dbh->prepare("SELECT `ID` FROM `Auto` WHERE `Team` = ? AND `Round` = ? LIMIT 1");
	$result->execute(array($team, $round));
	$result=$result->fetch();
	
	if ($result['ID'] == null)
	{
		if ($type == 'baseline')
			$result=$dbh->prepare("INSERT INTO `Auto` (`Team`, `Round`, `Baseline`) VALUES (?, ?, ?)");
		else if ($type == 'fuel')
			$result=$dbh->prepare("INSERT INTO `Auto` (`Team`, `Round`, `Fuel`) VALUES (?, ?, ?)");
		else if ($type == 'gear')
			$result=$dbh->prepare("INSERT INTO `Auto` (`Team`, `Round`, `Gear`) VALUES (?, ?, ?)");
		
		$result->execute(array($team,$round,$value));
	}
	else
	{
		if ($type == 'baseline')
			$result=$dbh->prepare("UPDATE `Auto` SET `Baseline` = ? WHERE `Team` = ? AND `Round` = ?");
		else if ($type == 'fuel')
			$result=$dbh->prepare("UPDATE `Auto` SET `Fuel` = ? WHERE `Team` = ? AND `Round` = ?");
		else if ($type == 'gear')
			$result=$dbh->prepare("UPDATE `Auto` SET `Gear` = ? WHERE `Team` = ? AND `Round` = ?");

		$result->execute(array($value, $team, $round));
	}
?>