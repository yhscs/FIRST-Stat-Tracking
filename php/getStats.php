<?php
	include_once('db.php');
	
	$result=$dbh->prepare("SELECT * FROM `Game` ORDER BY `Round`");
	$result->execute();
	$count=$result->rowCount();
	$result=$result->fetchAll();
	
	for ($i=0; $i<$count; $i++)
	{
		if ($i%2 == 0)
			echo '<tr>';
		else
			echo '<tr class="alt">';
		
		// Output Round
		$round = $result[$i]['Round'];
		$teamNum = $result[$i]['Team'];
		echo "<td>$round</td>";
		
		// Output Team Name with Number
		$team=$dbh->prepare("SELECT `Team Name` FROM `Team` WHERE `Number` = ?");
		$team->execute(array($teamNum));
		$team=$team->fetch()['Team Name'];
		echo "<td><a href='team.php?team=$teamNum'>$teamNum - $team</a></td>";
		
		// Output High Goal Efficiency
		/* $highGoal=$dbh->prepare("SELECT `Made`, `Missed` FROM `High Goal` WHERE `Team` = ? AND `Round` = ?");
		$highGoal->execute(array($teamNum, $round));
		$num=$highGoal->rowCount();
		$highGoal=$highGoal->fetchAll();
		
		$made = 0;
		$total = 0;
		for ($j=0; $j<$num; $j++)
		{
			$total++;
			if ($highGoal[$j]['Made'] == 1)
				$made++;
		}
		if ($total != 0)
		{
			echo '<td>'.round($made/$total*100,2).'%</td>';
			echo "<td>$total</td>";
		}
		else
		{
			echo '<td>N/A</td>';
			echo '<td>N/A</td>';
		}
		
		// Output Low Goal Fuel
		$lowGoal=$dbh->prepare("SELECT COUNT(*) AS `Fuel` FROM `Low Goal` WHERE `Team` = ? AND `Round` = ?");
		$lowGoal->execute(array($teamNum, $round));
		$lowGoal=$lowGoal->fetch()['Fuel'];
		echo "<td>$lowGoal</td>";
		*/
		
		// Output Board Ship
		$board=$dbh->prepare("SELECT COUNT(*) AS `Board` FROM `Boardship` WHERE `Team` = ? AND `Round` = ? LIMIT 1");
		$board->execute(array($teamNum, $round));
		$board=$board->fetch()['Board'];
		
		$boardTime = 'N/A';
		if ($board == 0)
		{
			$board = 'No';
			$boardTime = 'N/A';
		}
		else
		{
			$boardTime=$dbh->prepare("SELECT `Time`, `Success` FROM `Boardship` WHERE `Team` = ? AND `Round` = ? LIMIT 1");
			$boardTime->execute(array($teamNum, $round));
			$boardTime = $boardTime->fetch();
			
			$success = $boardTime['Success'];
			$boardTime = round($boardTime['Time'], 2);
			
			if ($success == 1)
				$board = 'Yes';
			else
			{
				$board = 'Attempted';
				$boardTime = 'N/A';
			}
		}

		echo "<td>$board</td><td>$boardTime</td>";
		
		// Output Autonomous Information
		$auto=$dbh->prepare("SELECT `Side`, `Baseline`, `Gear`, `Fuel` FROM `Auto` WHERE `Team` = ? AND `Round` = ? LIMIT 1");
		$auto->execute(array($teamNum, $round));
		$auto=$auto->fetch();
		
		if ($auto == null)
		{
			echo '<td>N/A</td>';
			echo '<td>N/A</td>';
			echo '<td>N/A</td>';
			echo '<td>N/A</td>';
		}
		else
		{
			if ($auto['Baseline'] == 0)
				$base = 'No';
			else
				$base = 'Yes';
				
			if ($auto['Gear'] == 0)
				$gear = 'No';
			else
				$gear = 'Yes';	
			
			if ($auto['Fuel'] == 0)
				$fuel = 'No';
			else
				$fuel = 'Yes';
			
			echo '<td>'.ucfirst($auto['Side']).'</td>';	
			echo '<td>'.$base.'</td>';
			echo '<td>'.$fuel.'</td>';
			echo '<td>'.$gear.'</td>';
		}
		
		// Output Gears Placed
		$gears=$dbh->prepare("SELECT `Placed` FROM `Gear` WHERE `Team` = ? AND `Round` = ?");
		$gears->execute(array($teamNum, $round));
		$gears=$gears->fetch()['Placed'];
		
		$picked = 'No';
		if ($gears > 0)
		{
			$picked=$dbh->prepare("SELECT `Picked` FROM `Gear` WHERE `Team` = ? AND `Round` = ? AND `Picked` = 1");
			$picked->execute(array($teamNum, $round));
			$picked=$picked->fetch()['Picked'];	

			if ($picked == 0)
				$picked = 'No';
			else
				$picked = 'Yes';
		}
		
		echo "<td>$gears</td><td>$picked</td>";
		
		
		// Output Defense and Driver Skill
		$dAndD=$dbh->prepare("SELECT `Driver`, `Defense` FROM `DriverDefense` WHERE `Team` = ? AND `Round` = ? LIMIT 1");
		$dAndD->execute(array($teamNum, $round));
		$dAndD=$dAndD->fetch();
		$defense=$dAndD['Defense'];
		$driver=$dAndD['Driver'];
		
		if ($defense === NULL)
			$defense = 0;
			
		if ($driver === NULL)
			$driver = 0;
		
		switch($defense) {
			case 1:
				echo '<td>No Defense</td>';
				break;
			case 2:
				echo '<td>Rarely Played Defense</td>';
				break;
			case 3:
				echo '<td>Sometimes Played Defense</td>';
				break;
			case 4:
				echo '<td>Mostly Played Defense</td>';
				break;
			default:
				echo '<td>N/A</td>';
		}

		switch($driver) {
			case 1:
				echo '<td>Poor</td>';
				break;
			case 2:
				echo '<td>Fair</td>';
				break;
			case 3:
				echo '<td>Good</td>';
				break;
			case 4:
				echo '<td>Excellent</td>';
				break;
			default:
				echo '<td>N/A</td>';
		}
		
		echo '</tr>';
	}
?>