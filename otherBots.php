<?php
	$pass = sha1($_POST['pass']);
	
	include_once('db.php');
	
	$result=$dbh->prepare("SELECT * FROM `admin` LIMIT 1");
	$result->execute();
	$result=$result->fetch();

	if($pass == $result['Pass'] || $_COOKIE['pass'] == $result['Pass'])
	{
		$_COOKIE['pass'] = $pass;
		$team = $_POST['team'];
		include('foximusStats.php');	
	}
	else
	{
		if(isset($_POST))
		{
			
?>
			
   
            <form method="POST" action="otherBots.php">
            <span style="font-size: xx-large; letter-spacing: 1px;">Password</span> <input type="password" name="pass" style="font-size: xx-large; letter-spacing: 1px;"></input><br>
			<?php
				$result=$dbh->prepare("SELECT * FROM `Team` WHERE `Active` = 1 ORDER BY `Number`");
				$result->execute();
				$count=$result->rowCount();
				$result=$result->fetchAll();
				
				echo '<select id="team" style="font-size: xx-large; letter-spacing: 1px;">';
				
				$firstTeam = $result[0]['Number'];
				
				for ($i=0; $i<$count; $i++)
					echo '<option value="'.$result[$i]['Number'].'">Team '.$result[$i]['Number'].' :: '.$result[$i]['Team Name'].'</option>';
				
				echo '</select>';
				
			?>
			
			<script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        	<script>window.jQuery || document.write('<script src="jquery-1.12.0.min.js"><\/script>')</script>
			<script>
                $('#team').change(function() {
					$('#teamNum').val($('#team').find(":selected").val());						   
				});
            </script>
            
            <input type="hidden" id="teamNum" name="team" value="<?php echo $firstTeam; ?>"></input>
            <br><input type="submit" name="submit" value="Enter Stats" style="font-size: xx-large; letter-spacing: 1px;"></input>
            </form>
<?php
        }
	}
?>