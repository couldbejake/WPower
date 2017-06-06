<?php
session_start();

// If the timeframe has not been set, set it to one week.
if(empty($_POST["timeframe"])){
  $timeframe = 604800;
} else {
$timeframe = $_POST["timeframe"];
}

// Get the amount of days that can fit in the timeframe.
$days = round($timeframe / 86400);

// Create an array for each appliance
$time_usage1 = array();
$time_usage2 = array();
$time_usage3 = array();
$time_usage4 = array();

// Get the content of the appliance data files.
$data1 = file_get_contents ("/var/www/data1.json");
$data2 = file_get_contents ("/var/www/data2.json");
$data3 = file_get_contents ("/var/www/data3.json");
$data4 = file_get_contents ("/var/www/data4.json");

// Turn the files contents for each appliance into json data.
$jsonfile1 = json_decode( $data1, true );
$jsonfile2 = json_decode( $data2, true );
$jsonfile3 = json_decode( $data3, true );
$jsonfile4 = json_decode( $data4, true );

// Set the time variable to the current epoch time.
$time = time();

// Get the start of the day in epoch time.
$startDay = strtotime("midnight", $time);

// For every time the appliance was turned off.
foreach ($jsonfile1 as $array){

  $startday = strtotime("midnight", $array['ontime']);
  $endday = strtotime("tomorrow", $startday) - 1;
  $ontime = $array['ontime'];
  $offtime = $array['offtime'];
  // If the time is within the specified range
  if(($time - $timeframe) < $ontime){
  // If the activated time for the current day is empty, set it to 0.
  if(!array_key_exists($startday, $time_usage1)){ $time_usage1[$startday] = 0;}
  // If the json object is valid.
  if($offtime > $ontime){
  // If the time period fits within the day.
  if($ontime > $startday && $offtime < $endday){
    // Add the offtime - ontime to the total time for the light.
    $time_usage1[$startday] = $time_usage1[$startday] + (($offtime - $ontime)/3600);
  } else {
    // Add 24 hours to the days count.
    $time_usage2[$startday] = $time_usage2[$startday] +  12;
  }}}}

foreach ($jsonfile2 as $array){

  $startday = strtotime("midnight", $array['ontime']);
  $endday = strtotime("tomorrow", $startday) - 1;
  $ontime = $array['ontime'];
  $offtime = $array['offtime'];

  if(($time - $timeframe) < $ontime){
  if(!array_key_exists($startday, $time_usage2)){ $time_usage2[$startday] = 0;}
  if($offtime > $ontime){
  if($ontime > $startday && $offtime < $endday){
    $time_usage2[$startday] = $time_usage2[$startday] + (($offtime - $ontime)/3600);
  } else {
    $time_usage2[$startday] = $time_usage2[$startday] + 12;
  }}}}

foreach ($jsonfile3 as $array){

  $startday = strtotime("midnight", $array['ontime']);
  $endday = strtotime("tomorrow", $startday) - 1;
  $ontime = $array['ontime'];
  $offtime = $array['offtime'];

  if(($time - $timeframe) < $ontime){
  if(!array_key_exists($startday, $time_usage3)){ $time_usage3[$startday] = 0;}
  if($offtime > $ontime){
  if($ontime > $startday && $offtime < $endday){
    $time_usage3[$startday] = $time_usage3[$startday] + (($offtime - $ontime)/3600);
  } else {
    $time_usage3[$startday] = $time_usage3[$startday] + 12;
  }}}}

foreach ($jsonfile4 as $array){

  $startday = strtotime("midnight", $array['ontime']);
  $endday = strtotime("tomorrow", $startday) - 1;
  $ontime = $array['ontime'];
  $offtime = $array['offtime'];

  if(($time - $timeframe) < $ontime){
  if(!array_key_exists($startday, $time_usage4)){ $time_usage4[$startday] = 0;}
  if($offtime > $ontime){
  if($ontime > $startday && $offtime < $endday){
    $time_usage4[$startday] = $time_usage4[$startday] + (($offtime - $ontime)/3600);
  } else {
    $time_usage4[$startday] = $time_usage4[$startday] + 12;
  }}}}


// Add all days with data present together.
$days = $time_usage1 + $time_usage2 + $time_usage3 + $time_usage4;

// Sort the days by epoch time, hence put the days in order.
ksort($days, 1);

?>
<html>
      <head>
      <!-- Set the pages title to Wpower Login Page -->
      <title>WPower Login page</title>
      <!-- Load the stylesheet found in the same directory as index -->
      <link rel='stylesheet' type='text/css' href='index.css'>
      <!-- Load the Google Font Fira Sans from the Google font API -->
      <link href='https://fonts.googleapis.com/css?family=Fira+Sans' rel='stylesheet'>
      <link rel='icon' type='image/png' href='favicon.png' />

        <!--Load the AJAX API-->
        <script type="text/javascript" src="https://www.google.com/jsapi"></script>
        <script type="text/javascript">

          // Load the Visualization API and the piechart package.
          google.load('visualization', '1.0', {'packages':['corechart', 'line']});
          // Set a callback to run when the Google Visualization API is loaded.
          google.setOnLoadCallback(drawChart);

          // Callback that creates and populates a data table,
          // instantiates the pie chart, passes in the data and
          // draws it.
          function drawChart() {

            // Create the data table.

	    var data = new google.visualization.DataTable();
	      data.addColumn('string', 'Day');
      	      data.addColumn('number', 'Appliance 1');
	      data.addColumn('number', 'Appliance 2');
	      data.addColumn('number', 'Appliance 3');
	      data.addColumn('number', 'Appliance 4');

              data.addRows([
<?php
// For every day in which data is present
foreach($days as $key => $value){
  // Get the date in the form year-month-day
  $dt = new DateTime("@$key");
  $date =  $dt->format('Y-m-d');

  $daysdata = "['". $date . "'," ;
  // for each appliance if data exists, add the data to the $daysdata variable.
  // if there is no data present set the data for that day and that appliance to 0.
  if(array_key_exists ($key, $time_usage1)){
    $daysdata = $daysdata . $time_usage1[$key] . ", ";
  } else {
    $daysdata = $daysdata . 0 . ", ";
  }

  if(array_key_exists ($key, $time_usage2)){
    $daysdata = $daysdata . $time_usage2[$key] . ", ";
  } else {
    $daysdata = $daysdata . 0 . ", ";
  }

  if(array_key_exists ($key, $time_usage3)){
    $daysdata = $daysdata . $time_usage3[$key] . ", ";
  } else {
    $daysdata = $daysdata . 0 . ", ";
  }

  if(array_key_exists ($key, $time_usage4)){
    $daysdata = $daysdata . $time_usage4[$key];
  } else {
    $daysdata = $daysdata . 0;
  }

  $daysdata = $daysdata . "],";
  // Echo the daysdata variable to the javascript google charts data api.
  echo $daysdata;





}

?>
      	     ]);


            // Set chart options

            var options = {
              title: 'Hours left on by each user',
            };

            // Draw our chart, passing in some options.
            var chart = new google.charts.Line(document.getElementById('userusage1'));
            chart.draw(data, options);
          }


        </script>
      </head>
      <body>
	<center><h1>Time left on by system users</h1>
<?php
        echo "<tag><strong><a href='userusage.php' class='button' style='height:20px;'>> User Usage <</a></strong><br>";
        echo "<br><center><strong><a href='logout.php'>Logout</a></strong>";
        echo " | ";
        echo "<strong><a href='login_page.php'>Main Panel</a></strong>";
        echo " | ";
        echo "<strong><a href='schedule1.php'>Appliance Schedule</a></strong>";
        echo " | ";
        echo "<strong><a href='admin.php'>Admin Panel</a></strong></center></tag><br>";
        ?>

        <br><br><b><tag>Click to choose a timeframe: </tag></b>

        <br><br>
	<form action="timeusage.php" method="post">
	<button name="timeframe" value="604800" type="submit">Last Week</button>
	<button name="timeframe" value="2678400" type="submit">Last Month</button>
	<button name="timeframe" value="5184000" type="submit">Last Two Months</button>
	<button name="timeframe" value="31557600" type="submit">Last Year</button>
	</form>

        </center>
        <!--Divs that will hold the charts-->
        <center><div id="userusage1" style='width: 900px; height: 500px;border: 40px solid white;'></div></center>
	<br><br><br>
      </body>
    </html>
