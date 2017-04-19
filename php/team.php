<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Yorkville Robotics: Foximus Prime Team 3695</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <h1>Team Stats</h1>
        
        <div class="tableWrap">
            <table class="centerTable" id="statsTable">
                <tr>
                    <th>Match</th>
                    <th>Team</th>
                    <th>High Goal <br>Efficiency</th>
                    <th>High Goal <br>Fuel</th>
                    <th>Low Goal <br>Fuel</th>
                    <th>Boarded <br>Ship</th>
                    <th>Autonomous <br>Starting Position</th>
                    <th>Crossed Baseline <br>During Auto</th>
                    <th>Scored Fuel <br>During Auto</th>
                    <th>Placed Gear <br>During Auto</th>
                    <th>Gears <br>Placed</th>
                </tr>
                
                <?php
	include_once('db.php');
	
	$teamNum = $_GET['team'];
	
	$result=$dbh->prepare("SELECT * FROM `Game` WHERE `Team` = ? ORDER BY `Round`");
	$result->execute(array($teamNum));
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
		echo "<td>$round</td>";
		
		// Output Team Name
		$team=$dbh->prepare("SELECT `Team Name` FROM `Team` WHERE `Number` = ?");
		$team->execute(array($teamNum));
		$team=$team->fetch()['Team Name'];
		echo "<td><a href='team.php?team=$teamNum'>$team</a></td>";
		
		// Output High Goal Efficiency
		$highGoal=$dbh->prepare("SELECT `Made`, `Missed` FROM `High Goal` WHERE `Team` = ? AND `Round` = ?");
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
		
		// Output Board Ship
		$board=$dbh->prepare("SELECT COUNT(*) AS `Board` FROM `Boardship` WHERE `Team` = ? AND `Round` = ? LIMIT 1");
		$board->execute(array($teamNum, $round));
		$board=$board->fetch()['Board'];
		if ($board == 0)
			$board = 'No';
		else
			$board = 'Yes';
		echo "<td>$board</td>";
		
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
			echo '<td>'.$gear.'</td>';
			echo '<td>'.$fuel.'</td>';
		}
		
		// Output Gears Placed
		$gears=$dbh->prepare("SELECT COUNT(*) AS `Gears` FROM `Gear` WHERE `Team` = ? AND `Round` = ?");
		$gears->execute(array($teamNum, $round));
		$gears=$gears->fetch()['Gears'];
		echo "<td>$gears</td>";
		
		echo '</tr>';
	}
?>
			
            </table>
        </div>

        <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        <script>window.jQuery || document.write('<script src="jquery-1.12.0.min.js"><\/script>')</script>
        <script src="main.js"></script>
    </body>
</html>