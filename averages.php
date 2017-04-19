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
		$result=$dbh->prepare("SELECT * FROM `Team` WHERE `Active` = 1");
		$result->execute();
		$count=$result->rowCount();
		$result=$result->fetchAll();
		
		
	   
	   ?>
       
       <div id="recordStats" class="centerText">
            <a href="index.php"><div id="otherButton">Return to Home</div></a>
            <br><br>
        </div>
        
        <h2>Team Stats</h2>
        
        <div class="tableWrap">
            <table class="centerTable" id="statsTable">
                <tr>
                    <th>Team</th>
                    <th>Defense</th>
                    <th>Driver Skill</th>
                    <th>Average Gears Placed</th>
                    <th>Average Time to Ascend</th>
                </tr>
        
        <?php
		
		for ($i=0; $i<$count; $i++)
		{
			echo '<tr><td>'.$result[$i]['Number'].' - '.$result[$i]['Team Name'].'</td>';
		
			$dAndD=$dbh->prepare("SELECT AVG(`Driver`) AS `DriveAvg`, AVG(`Defense`) AS `DAvg` FROM `DriverDefense` WHERE `Team` = ?");
			$dAndD->execute(array($result[$i]['Number']));
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
				$defense = '1 - No Defense';
				break;
			case 2:
				$defense = '2 - Rarely Played Defense';
				break;
			case 3:
				$defense = '3 - Sometimes Played Defense';
				break;
			case 4:
				$defense = '4 - Mostly Played Defense';
				break;
			default:
				$defense = 'N/A';
		}

		switch($driver) {
			case 1:
				$driver = '1 - Poor';
				break;
			case 2:
				$driver = '2 - Fair';
				break;
			case 3:
				$driver = '3 - Good';
				break;
			case 4:
				$driver = '4 - Excellent';
				break;
			default:
				$driver = 'N/A';
		}
		
		
		$gears=$dbh->prepare("SELECT AVG(`Placed`) AS `Gears` FROM `Gear` WHERE `Team` = ?");
		$gears->execute(array($result[$i]['Number']));
		$gears=$gears->fetch();
		$gears=$gears['Gears'];
	
		$gears = round($gears, 2);
		
		
		$time=$dbh->prepare("SELECT AVG(`Time`) AS `AscendTime` FROM `Boardship` WHERE `Team` = ?");
		$time->execute(array($result[$i]['Number']));
		$time=$time->fetch();
		$time=$time['AscendTime'];
	
		$time = round($time, 2);
	
		echo "<td>$defense</td>";
		echo "<td>$driver</td>";
		echo "<td>$gears</td>";
		echo "<td>$time</td></tr>";
		
		}
		?>
        
      </table>
      </div>
        </div>

        <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        <script>window.jQuery || document.write('<script src="jquery-1.12.0.min.js"><\/script>')</script>
        <script src="main.js"></script>
    </body>
</html>