<?php
session_start();

if(empty($_POST["timeframe"])){
  $timeframe = 3600;
} else {
$timeframe = $_POST["timeframe"];
}
  

$user_data1 = array();
$user_data2 = array();
$user_data3 = array();
$user_data4 = array();

$data1 = strtolower(file_get_contents ("/var/www/data1.json"));
$data2 = strtolower(file_get_contents ("/var/www/data2.json"));
$data3 = strtolower(file_get_contents ("/var/www/data3.json"));
$data4 = strtolower(file_get_contents ("/var/www/data4.json"));

$jsonfile1 = json_decode( $data1, true );
$jsonfile2 = json_decode( $data2, true );
$jsonfile3 = json_decode( $data3, true );
$jsonfile4 = json_decode( $data4, true );

$time = time();


foreach ($jsonfile1 as $array) {
  if(!array_key_exists($array['user'], $user_data1)){
    $user_data1[$array['user']] = 0;
  }
  if(($time - $timeframe) < $array['offtime']){
  $user_data1[$array['user']] = $user_data1[$array['user']] + ($array['offtime'] - $array['ontime']);
  }
}

foreach ($jsonfile2 as $array) {
  if(!array_key_exists($array['user'], $user_data2)){
    $user_data2[$array['user']] = 0;
  }
  if(($time - $timeframe) < $array['offtime']){
  $user_data2[$array['user']] = $user_data2[$array['user']] + ($array['offtime'] - $array['ontime']);
  }
}

foreach ($jsonfile3 as $array) {
  if(!array_key_exists($array['user'], $user_data3)){
    $user_data3[$array['user']] = 0;
  }
  if(($time - $timeframe) < $array['offtime']){
  $user_data3[$array['user']] = $user_data3[$array['user']] + ($array['offtime'] - $array['ontime']);
  }
}

foreach ($jsonfile4 as $array) {
  if(!array_key_exists($array['user'], $user_data4)){
    $user_data4[$array['user']] = 0;
  }
  if(($time - $timeframe) < $array['offtime']){
  $user_data4[$array['user']] = $user_data4[$array['user']] + ($array['offtime'] - $array['ontime']);
  }
}

//foreach($user_data3 as $user => $time){
//              echo " ['" . $user . "', " . $time . "],";
//}
unset($user_data1['0']);
unset($user_data2['0']);
unset($user_data3['0']);
unset($user_data4['0']);



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
          google.load('visualization', '1.0', {'packages':['corechart']});

          // Set a callback to run when the Google Visualization API is loaded.
          google.setOnLoadCallback(drawChart);

          // Callback that creates and populates a data table,
          // instantiates the pie chart, passes in the data and
          // draws it.
          function drawChart() {

            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Topping');    
            data.addColumn('number', 'Slices');
            data.addRows([
<?php
foreach($user_data1 as $user => $time){
              echo " ['" . $user . "', " . $time/3600 . "],";
}
?>
                ['no data',0.00001 ],
            ]);
            // Create the data table.
            var data2 = new google.visualization.DataTable();
            data2.addColumn('string', 'Topping');
            data2.addColumn('number', 'Slices');
            data2.addRows([
<?php
foreach($user_data2 as $user => $time){
              echo " ['" . $user . "', " . $time/3600 . "],";
}
?>
               ['no data',0.00001 ],
            ]);

            var data3 = new google.visualization.DataTable();
            data3.addColumn('string', 'Year');
            data3.addColumn('number', 'Expenses');
            data3.addRows([
<?php
foreach($user_data3 as $user => $time){
              echo " ['" . $user . "', " . $time/3600 . "],";
}
?>
              ['no data',0.00001 ],
            ]);

            // Create the data table.
            var data4 = new google.visualization.DataTable();
            data4.addColumn('string', 'Topping');
            data4.addColumn('number', 'Slices');
            data4.addRows([
<?php
foreach($user_data4 as $user => $time){
              echo " ['" . $user . "', " . $time/3600 . "],";
}
?>
               ['no data',0.000001 ],
            ]);


            // Set chart options

            var options = {
              title: 'Hours left on by each user',
              pieHole: 0.4,
              'backgroundColor' : 'transparent'
            };

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('userusage1'));
            chart.draw(data, options);
            var chart2 = new google.visualization.PieChart(document.getElementById('userusage2'));
            chart2.draw(data2, options);
            var chart3 = new google.visualization.PieChart(document.getElementById('userusage3'));
            chart3.draw(data3, options);
            var chart4 = new google.visualization.PieChart(document.getElementById('userusage4'));
            chart4.draw(data4, options);
          }


      function changeLight(){
      var selected_light = document.getElementById('userusage').options[document.getElementById('userusage').selectedIndex].value;
      //console.log(selected_light);
      document.getElementById('userusage1').style.display = 'none';
      document.getElementById('userusage2').style.display = 'none';
      document.getElementById('userusage3').style.display = 'none';
      document.getElementById('userusage4').style.display = 'none';

      var light_id = 0;

      if(selected_light == 'Light 1'){
        console.log('light 1 has been selected')
        document.getElementById('userusage1').style = 'display:block;';
        light_id = 1;
      }

      if(selected_light == 'Light 2'){
        console.log('light 2 has been selected')
	document.getElementById('userusage2').style = 'display:block;';
        light_id = 2;
      }

      if(selected_light == 'Light 3'){
        console.log('light 3 has been selected')
	document.getElementById('userusage3').style = 'display:block;';
        light_id = 3;
      }

      if(selected_light == 'Light 4'){
        console.log('light 4 has been selected')
	document.getElementById('userusage4').style = 'display:block;';
        light_id = 4;
      }


      if (window.XMLHttpRequest){
      xmlhttp=new XMLHttpRequest();
      }

      else{
      xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
      }

      xmlhttp.open("GET", "setlight.php?light="+light_id, false);
      xmlhttp.send();


    }


    function hideUsage(){
      document.getElementById('userusage1').style.display = 'block';
      document.getElementById('userusage2').style.display = 'none';
      document.getElementById('userusage3').style.display = 'none';
      document.getElementById('userusage4').style.display = 'none';


    }
        </script>
      </head>
      <body onload='changeLight();'>
	<center><h1>Time left on by system users</h1>
	<?php
	echo "<tag><strong><a href='timeusage.php' class='button' style='height:20px;'>> Time Usage <</a></strong><br>";
        echo "<br><center><strong><a href='logout.php'>Logout</a></strong>";
        echo " | ";
        echo "<strong><a href='login_page.php'>Main Panel</a></strong>";
        echo " | ";
        echo "<strong><a href='schedule1.php'>Appliance Schedule</a></strong>";
        echo " | ";
        echo "<strong><a href='admin.php'>Admin Panel</a></strong></center></tag><br>";
        ?>
        <b><tag>Click to choose a light: </tag></b>
        <select id='userusage' onChange='changeLight()'>


	<?php
	foreach(range(1,4) as $number){
	if($_SESSION["last_light"] == $number){
        echo "<option selected='selected'>Light " . $number . "</option>";
	} else {
	echo "<option>Light " . $number . "</option>";
	}

	}
	?>

        </select>



        <br><br>
	<form action="userusage.php" method="post">
        <button name="timeframe" value="3600" type="submit">Last Hour</button>
	<button name="timeframe" value="86400" type="submit">Last Day</button>
	<button name="timeframe" value="172800" type="submit">Last 2 days</button>
	<button name="timeframe" value="604800" type="submit">Last Week</button>
	<button name="timeframe" value="2678400" type="submit">Last Month</button>
	<button name="timeframe" value="31557600" type="submit">Last Year</button>
	</form>

        </center>
        <!--Divs that will hold the charts-->
        <div id="userusage1" style='width: 900px; height: 500px;'></div>
        <div id="userusage2" style='width: 900px; height: 500px;'></div>
        <div id="userusage3" style='width: 900px; height: 500px;'></div>
        <div id="userusage4" style='width: 900px; height: 500px;'></div>
      </body>
    </html>
