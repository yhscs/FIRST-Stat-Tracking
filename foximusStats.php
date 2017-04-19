<?php
	include_once('db.php');
	
	$result=$dbh->prepare("SELECT * FROM `admin` LIMIT 1");
	$result->execute();
	$result=$result->fetch();
	
	if($_COOKIE['pass'] == $result['Pass'])
	{
		$result=$dbh->prepare("SELECT `Round` FROM `Game` WHERE `Team` = ? ORDER BY `Round` DESC LIMIT 1");
		$result->execute(array($team));
		$result=$result->fetch();
		
		if ($result['Round'] != null)
			$round = $result['Round'] + 1;
		else
			$round = 1;
			
		$result=$dbh->prepare("INSERT INTO `Game` (`Round`, `Team`) VALUES (?, ?)");
		$result->execute(array($round, $team));
?>
		<head>
        	<title>Team Stats</title>
        	<link rel="stylesheet" href="style.css">
        </head>
		
        <body style="font-size:xx-large;">
        
        <h1>Stats for Team #<?php echo $team; ?> in Match <?php echo $round;?></h1>
		<input id ="team" type="hidden" value="<?php echo $team; ?>">
        <input id ="round" type="hidden" value="<?php echo $round; ?>">
		
        <div id="recordStats" class="centerText">
        <a href="index.php"><div id="otherButton" class="centerText">Return to Home</div></a>
            <br><br>
            
            <?php
				$result=$dbh->prepare("SELECT * FROM `Team` WHERE `Active` = 1 ORDER BY `Number`");
				$result->execute();
				$count=$result->rowCount();
				$result=$result->fetchAll();
				
				echo '<select id="teamSelect" style="font-size: xx-large; letter-spacing: 1px;">';
				
				$firstTeam = $result[0]['Number'];
				
				for ($i=0; $i<$count; $i++)
					if ($result[$i]['Number'] != $team)
						echo '<option value="'.$result[$i]['Number'].'">Team '.$result[$i]['Number'].' :: '.$result[$i]['Team Name'].'</option>';
					else
						echo '<option value="'.$result[$i]['Number'].'" selected>Team '.$result[$i]['Number'].' :: '.$result[$i]['Team Name'].'</option>';
				
				echo '</select>';
				
			?>
            
        </div>
        
        
        <!--
        <div class="centerText">
        <h2>High Goal Shots</h2>
            <div id="makeHigh">Make<br><span id="makeAmount">0</span></div>
            <div id="missHigh">Miss<br><span id="missAmount">0</span></div>
		</div>
		
        <div id="lowGoal">Low Goal Fuel (<span id="lowGoalFuel">0</span>)</div>
        -->

		<div><h3>Autonomous Starting Position</h3>
        	<div><input type="radio" value="left" name="auto">Left Side <br><input type="radio" value="middle" name="auto">Middle <br><input type="radio" value="right" name="auto">Right Side </div>
        </div>
        
        <div><h3>Defensive Play</h3>
        	<div><input type="radio" value="1" name="defense">No Defense <br><input type="radio" value="2" name="defense">Rarely Played Defense <br><input type="radio" value="3" name="defense">Sometimes Played Defense <br><input type="radio" value="4" name="defense">Mostly Played Defense </div>
        </div>
        
        <div><h3>Driver Skill</h3>
        	<div><input type="radio" value="1" name="driver">Poor Driver <br><input type="radio" value="2" name="driver">Fair Driver <br><input type="radio" value="3" name="driver">Good Driver <br><input type="radio" value="4" name="driver">Excellent Driver </div>
        </div>
        
        <h3>Autonomous Actions</h3>
        <div><input type="checkbox" id="baseline"> Crossed Baseline</div>
        
        <div><input type="checkbox" id="autoGear"> Placed Gear</div>
        
        <div><input type="checkbox" id="autoFuel"> Scored Fuel</div>
        
        <h3>Ascension and Gears</h3>
        
        <div><input type="checkbox" id="climbAttempt"> Attempted Ascend</div>
        
        <div><input type="checkbox" id="climb"> Successful Ascend</div>
        
        <div><input type="checkbox" id="pickGear"> Picked Up a Gear</div>
        
        <div class="centerText">
        <div id="numGears">Total Gears Placed (<span id="gearsPlaced">0</span>)</div>
        
        <div id="climbTimer">Start Ascend<br>0.00</div>
        <br><br>
        </div>
        
        <!--
        <div>
        	<div>Rotor 1 <input type="checkbox" id="gear1-1" name="gears"> Gear 1</div>
            <div>Rotor 2 <input type="checkbox" id="gear2-1" name="gears"> Gear 1 <input type="checkbox" id="gear2-2" name="gears"> Gear 2</div>
            <div>Rotor 3 <input type="checkbox" checked disabled="disabled"> Gear 1 <input type="checkbox" id="gear3-2" name="gears"> Gear 2 <input type="checkbox" id="gear3-3" name="gears"> Gear 3 <input type="checkbox" id="gear3-4" name="gears"> Gear 4</div>
            <div>Rotor 4 <input type="checkbox" checked disabled="disabled"> Gear 1 <input type="checkbox" checked disabled="disabled"> Gear 2 <input type="checkbox" id="gear4-3" name="gears"> Gear 3 <input type="checkbox" id="gear4-4" name="gears"> Gear 4 <input type="checkbox" id="gear4-5" name="gears"> Gear 5 <input type="checkbox" id="gear4-6" name="gears"> Gear 6</div>
        </div>
        -->
        
        <div>
        	<textarea rows="10" cols="100" placeholder="The comments you type here will be public...choose your words wisely." id="comments"></textarea>
        </div>
        
        <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        <script>window.jQuery || document.write('<script src="jquery-1.12.0.min.js"><\/script>')</script>
        <script src="stats.js"></script>
        </body>
<?php
	}
	else
	{
		header('HTTP/1.0 403 Forbidden');
     	die('You are not allowed to access this file.');
	}
?>