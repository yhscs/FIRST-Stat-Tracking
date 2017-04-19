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

        <h1>Foximus Prime <br>Stat-o-Matic</h1>
        
        <div id="recordStats" class="centerText">
            <a href="otherBots.php"><div id="otherButton">Record Stats</div></a>
            <br><br>
        </div>
        
        <div class="tableWrap">
            <table class="centerTable" id="statsTable">
                <tr>
                    <th>Match</th>
                    <th>Team</th>
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
                </tr>
                
                <?php
					include('php/getStats.php');
				?>
            </table>
        </div>

        <script src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
        <script>window.jQuery || document.write('<script src="jquery-1.12.0.min.js"><\/script>')</script>
        <script src="main.js"></script>
    </body>
</html>
