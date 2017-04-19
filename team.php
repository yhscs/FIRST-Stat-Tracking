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
        
        <?php
	include_once('db.php');
	$teamNum = $_GET['team'];
	
        // Output Team Name
		$team=$dbh->prepare("SELECT `Team Name` FROM `Team` WHERE `Number` = ?");
		$team->execute(array($teamNum));
		$team=$team->fetch()['Team Name'];
		

       echo" <h1>$team (#$teamNum) Stats</h1>";
	   
	   ?>
       
       <div id="recordStats" class="centerText">
            <a href="index.php"><div id="otherButton">Return to Home</div></a>
            <br><br>
        </div>
        
        <h2>Team Stats</h2>
        
        <?php
		
			$dAndD=$dbh->prepare("SELECT AVG(`Driver`) AS `DriveAvg`, AVG(`Defense`) AS `DAvg` FROM `DriverDefense` WHERE `Team` = ?");
			$dAndD->execute(array($teamNum));
			$dAndD=$dAndD->fetch();
			$defense=$dAndD['DAvg'];
			$driver=$dAndD['DriveAvg'];
			
		if ($defense === NULL)
			$defense = 0;
			
		if ($driver === NULL)
			$driver = 0;
			
		$defense = round($defense);
		$driver = round($driver);
		
		switch($defense) {
			case 1:
				$defense = 'No Defense';
				break;
			case 2:
				$defense = 'Rarely Played Defense';
				break;
			case 3:
				$defense = 'Sometimes Played Defense';
				break;
			case 4:
				$defense = 'Mostly Played Defense';
				break;
			default:
				$defense = 'N/A';
		}

		switch($driver) {
			case 1:
				$driver = 'Poor';
				break;
			case 2:
				$driver = 'Fair';
				break;
			case 3:
				$driver = 'Good';
				break;
			case 4:
				$driver = 'Excellent';
				break;
			default:
				$driver = 'N/A';
		}
		
		
		$gears=$dbh->prepare("SELECT AVG(`Placed`) AS `Gears` FROM `Gear` WHERE `Team` = ?");
		$gears->execute(array($teamNum));
		$gears=$gears->fetch();
		$gears=$gears['Gears'];
	
		$gears = round($gears, 2);
		
		
		$time=$dbh->prepare("SELECT AVG(`Time`) AS `AscendTime` FROM `Boardship` WHERE `Team` = ?");
		$time->execute(array($teamNum));
		$time=$time->fetch();
		$time=$time['AscendTime'];
	
		$time = round($time, 2);
	
		echo "<p class='margin10'>$defense<br>";
		echo "Driver Skill: $driver<br>";
		echo "Average Gears Placed: $gears<br>";
		echo "Average Time to Ascend: $time</p>";
		?>
        
        <div class="tableWrap">
            <table class="centerTable" id="statsTable">
                <tr>
                    <th>Match</th>
                    <th>Ascended</th>
                    <th>Time <br>to Ascend</th>
                    <th>Autonomous <br>Starting Position</th>
                    <th>Crossed Baseline <br>During Auto</th>
                    <th>Scored Fuel <br>During Auto</th>
                    <th>Placed Gear <br>During Auto</th>
                    <th>Total Gears <br>Placed</th>
                    <th>Picked Up <br>a Gear</th>
                    <th>Defense</th>
                    <th>Driver <br>Skill</th>
                    <th>Comments</th>
                </tr>
                
                <?php
	
	
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
		
		
		
		// Output High Goal Efficiency
		/*
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
		$gears=$dbh->prepare("SELECT `Placed` FROM `Gear` WHERE `Team` = ? AND `Round` = ? LIMIT 1");
		$gears->execute(array($teamNum, $round));
		$gears=$gears->fetch()['Placed'];
		
		$picked = 'No';
		if ($gears > 0)
		{
			$picked=$dbh->prepare("SELECT `Picked` FROM `Gear` WHERE `Team` = ? AND `Round` = ? LIMIT 1");
			$picked->execute(array($teamNum, $round));
			$picked=$picked->fetch()['Picked'];	
			
			$gears -= $picked;
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
		
		// Output Comments
		$comments=$dbh->prepare("SELECT `Comments` FROM `Game` WHERE `Team` = ? AND `Round` = ?");
		$comments->execute(array($teamNum, $round));
		$comments=$comments->fetch()['Comments'];
		echo "<td>$comments</td>";
		
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