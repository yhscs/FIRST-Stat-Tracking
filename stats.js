//$('#makeHigh').click(function(){highGoal(1);});
//$('#missHigh').click(function(){highGoal(0);});
//$('#lowGoal').click(function(){lowGoal();});
$('#numGears').click(function(){placeGear();});
$('#pickGear').click(function(){pickGear();});
$("input[name='auto']").click(function(){autoSide();});
$("input[name='defense']").click(function(){defenseChange();});
$("input[name='driver']").click(function(){driverChange();});
$('#baseline').click(function(){autoBaseline();});
$('#autoGear').click(function(){autoGear();});
$('#autoFuel').click(function(){autoFuel();});
$('#climb').click(function(){ascend();});
$('#climbAttempt').click(function(){ascendAttempt();});
$('#climbTimer').click(function(){timer.start('climbTimer');});
$("input[name='gears']").click(function(){gears(this.id);});
$('#comments').keyup(function(){saveComments();});
$('#teamSelect').change(function() {$('#team').val($('#teamSelect').find(":selected").val());
		 resetAll();																	  
	});

/*
function highGoal(make)
{
	var team = $('#team').val();
	var roundNum = $('#round').val();
	
	if (make == 1)
	{
		var make = $('#makeAmount').html();
		$('#makeAmount').html(parseInt(make) + 1);
	}
	else
	{
		var miss = $('#missAmount').html();
		$('#missAmount').html(parseInt(miss) + 1);
	}
	
	$.post('php/scoreHigh.php', {team: team, roundNum: roundNum, make: make});
}

function lowGoal()
{
	var team = $('#team').val();
	var roundNum = $('#round').val();
	
	$.post('php/scoreLow.php', {team: team, roundNum: roundNum}, function(){
		var fuel = $('#gearsPlaced').html();
		$('#gearsPlaced').html(parseInt(fuel) + 1);
	});
}
*/

function placeGear()
{
	var team = $('#team').val();
	var roundNum = $('#round').val();
	
	$.post('php/gear.php', {team: team, roundNum: roundNum}, function(){
		var gears = $('#gearsPlaced').html();
		$('#gearsPlaced').html(parseInt(gears) + 1);
	});
	
}

function autoSide()
{
	var side = $('input[name="auto"]:checked').val();
	var team = $('#team').val();
	var roundNum = $('#round').val();
	
	$.post('php/autoSide.php', {team: team, roundNum: roundNum, side: side});
}

function defenseChange()
{
	var defense = $('input[name="defense"]:checked').val();
	var team = $('#team').val();
	var roundNum = $('#round').val();
	
	$.post('php/defense.php', {team: team, roundNum: roundNum, defense: defense});
}

function driverChange()
{
	var driver = $('input[name="driver"]:checked').val();
	var team = $('#team').val();
	var roundNum = $('#round').val();
	
	$.post('php/driver.php', {team: team, roundNum: roundNum, driver: driver});
}

function autoBaseline()
{
	var baseline = $('#baseline').is(':checked');
	var team = $('#team').val();
	var roundNum = $('#round').val();
	
	$.post('php/autoUpdate.php', {team: team, roundNum: roundNum, value: baseline, type: "baseline"});
}

function autoGear()
{
	var gear = $('#autoGear').is(':checked');
	var team = $('#team').val();
	var roundNum = $('#round').val();
	
	$.post('php/autoUpdate.php', {team: team, roundNum: roundNum, value: gear, type: "gear"});
}

function autoFuel()
{
	var fuel = $('#autoFuel').is(':checked');
	var team = $('#team').val();
	var roundNum = $('#round').val();
	
	$.post('php/autoUpdate.php', {team: team, roundNum: roundNum, value: fuel, type: "fuel"});
}

function ascend()
{
	var climb = $('#climb').is(':checked');
	var team = $('#team').val();
	var roundNum = $('#round').val();
	
	if ($('#climbAttempt').is(':checked') != true)
		$('#climbAttempt').prop('checked', true);

	$.post('php/climb.php', {team: team, roundNum: roundNum, value: climb, success: true});
}

function ascendAttempt()
{
	var climb = $('#climbAttempt').is(':checked');
	var team = $('#team').val();
	var roundNum = $('#round').val();
	
	if (climb == false && $('#climb').is(':checked') == true)
		$('#climb').prop('checked', false);

	$.post('php/climb.php', {team: team, roundNum: roundNum, value: climb, success: false});
}

function pickGear()
{
	var pick = $('#pickGear').is(':checked');
	var team = $('#team').val();
	var roundNum = $('#round').val();	

	$.post('php/gearPick.php', {team: team, roundNum: roundNum, value: pick});
}

/*
function gears(gear)
{
	var value = $('#'+gear).is(':checked');
	gear = gear.split('-');
	var rotor = gear[0].substring(4);
	gear = gear[1];
	var team = $('#team').val();
	var roundNum = $('#round').val();	

	$.post('php/gear.php', {team: team, roundNum: roundNum, rotor: rotor, gear: gear, value: value});	
}
*/

function saveComments()
{
	var team = $('#team').val();
	var roundNum = $('#round').val();
	var comments = $('#comments').val();
	$.post('php/comments.php', {team: team, roundNum: roundNum, comments: comments});
}

/*
function climbTimer(countTo)
{
	var timer = $('#climbTimer');
	if (timer.html() == 'Start Climb<br>0.00')
		timer.html('Stop Climb<br><span id="elapsedTime">0.00</span>');

	now = new Date();
	countTo = new Date(countTo);
	difference = (now-countTo);
	
	secs=Math.floor((((difference%(60*60*1000*24))%(60*60*1000))%(60*1000))/1000*1);
	$('#elapsedTime').html(secs);
	
	clearTimeout(climbTimer.to);
	climbTimer.to=setTimeout(function(){ climbTimer(countTo); },1000);
}*/

var timer={

 init:function(id){
   this[id]={
   obj:document.getElementById(id)
  }
 },

 start:function(id){
  var obj=this[id];
  obj.srt=new Date();
  clearTimeout(obj.to);
  this.tick(id);
  $( "#climbTimer" ).off('click');
  $('#climbTimer').click(function(){timer.finalStop(id); return false;});
  if ($('#'+id).html().indexOf('Start') != -1)
  	$('#'+id).html('Stop Ascend<br><span id="elapsedTime">0.00</span>');
 },

 stop:function(id){
  	clearTimeout(this[id].to);
 },
 
 finalStop:function(id){
	 clearTimeout(this[id].to);
	  $.post('php/climbTime.php', {team: $('#team').val(), roundNum: $('#round').val(), time: $('#elapsedTime').html()});
 },

 tick:function(id){
  this.stop(id);
  var obj=this[id],sec=(new Date()-obj.srt)/1000,min=Math.floor(sec/60),sec=sec%60;
  $('#elapsedTime').html(sec>9?sec:''+sec);
  obj.to=setTimeout(function(){ timer.tick(id); },100);
 }
 
	
}

timer.init('climbTimer');

function resetAll()
{
	$('#comments').val("");
	$('#climb').prop('checked', false);
	$('#autoGear').prop('checked', false);
	$('#baseline').prop('checked', false);
	$('#autoFuel').prop('checked', false);
	$('#pickGear').prop('checked', false);
	$('input[name="auto"]:checked').prop('checked', false);
	$('input[name="defense"]:checked').prop('checked', false);
	$('input[name="driver"]:checked').prop('checked', false);
	$('#gearsPlaced').html(0);
	$('#climbTimer').html("Start Ascend<br>0.00");
	$( "#climbTimer" ).off('click');
	$('#climbTimer').click(function(){timer.start('climbTimer');});
	var team = $('#team').val();
	
	
	$.post('php/round.php', {team: team}, function(roundNum) {
		$('h1').html('Stats for Team #'+team+' in Match '+roundNum);
		$('#round').val(roundNum);
	});
	
	
}

