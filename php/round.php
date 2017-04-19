<?php
	include_once('../db.php');
	
	$team = $_POST['team'];
	
	$result=$dbh->prepare("SELECT `Round` FROM `Game` WHERE `Team` = ? ORDER BY `Round` DESC LIMIT 1");
	$result->execute(array($team));
	$result=$result->fetch();
	
	if ($result['Round'] != null)
		$round = $result['Round'] + 1;
	else
		$round = 1;
		
	$result=$dbh->prepare("INSERT INTO `Game` (`Round`, `Team`) VALUES (?, ?)");
	$result->execute(array($round, $team));
	
	echo $round;
?>