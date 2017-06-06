<?php
session_start();

$_SESSION['last_scheduled'] = 3;
// If not logged in, redirect the user to the login page.
if(!$_SESSION['logged_in']){
    #
    header('Location: index.php');
}
// Show the top menu, echo as we're in PHP.
echo "<br><center><h1>Schedule Appliances</h1>";
echo "<br><center><b><font face='verdana'>Welcome back ".$_SESSION['username']."</face>!</b></center>";
echo "<br><center><strong><a href='logout.php'>Logout</a></strong>";
echo " | ";
echo "<strong><a href='admin.php'>Admin Panel</a></strong>";
echo " | ";
echo "<strong><a href='login_page.php'>Main Panel</a></strong></center>";
?>
<html>
<head>
  <link rel='icon' type='image/png' href='favicon.png' />
  <script>
  // This script in written in [JavaScript].
  // I've used HTML, CSS, PHP and JavaScript on this website.

  // Create an array of the activated hours.
  var OnArray = new Array;
  // When the page is Started
  function pageStart() {
  // Post to the console that JavaScript has been enabled
  console.log("Js Started");
  // Get al elements with the ClassName hour
  var elements = document.getElementsByClassName("hour");
  // For i in range length of elements.
  for(var i=0; i<elements.length;i++){
    // Get element in position i of the array elements.
    element = document.getElementsByClassName("hour")[i]
    // If a green hour is found in the list of elements on the page
    if(element.getAttribute("style").split(":")[1] == "green"){
      // Print to the console that a green element was found
	    console.log("Found Green Element")
      // Add the element's day and hour to the array.
      OnArray.push(element.getAttribute("day")+":"+element.getAttribute("hour"))
    }

  }
  }
  // A function which is activated when the submit button is pressed
  // This function loads all the data in the array OnArray which contains a list
  // Of which lights are on, to a dataholder element in the HTML form.
  function sendData(){
    // Print Sending Data to the console for debug
    console.log("Sending Data")
    // Add the information in OnArray to the place holder HTML form.
    document.getElementById("dataholder").value = OnArray;
  }
  // A function to change the color of hours from red > green and green > red
  // when clicked
  function myFunction(divObj){
    // If the hours colour is green
    if (divObj.getAttribute("style").split(":")[1] == "green" || divObj.style.background == "green"){
      // Print Remove to the console for debug
      console.log("Remove")
      // Set the background colour to red.
      divObj.style.background = "red";
      // Remove the value day:hour from the array.
      //OnArray.pop(divObj.getAttribute("day")+":"+divObj.getAttribute("hour"))
      // Get the position of day:hour
      pos = OnArray.indexOf(divObj.getAttribute("day")+":"+divObj.getAttribute("hour"));
      // If it found an element at day:hour
      if(pos > -1){
            // Remove element at position pos
            OnArray.splice(pos, 1);
      }
    } else {
      // Log to the console Push [colour]
      console.log("Push "+divObj.style.background)
      // Change the hours colour to green.
      divObj.style.background = "green";
      // Push day:hour to the OnArray array.
      OnArray.push(divObj.getAttribute("day")+":"+divObj.getAttribute("hour"))
    }

  function updateSchedule(){
    element_value = document.getElementById("selector").value
    light_id = element_value[element_value.length - 1]
    console.log(light_id)

  }

    // Log day:hour
    console.log("Day: "+divObj.getAttribute("day")+" hour "+divObj.getAttribute("hour"))
  }
  </script>


  <link rel='stylesheet' type='text/css' href='index.css'>
  <link href='https://fonts.googleapis.com/css?family=Fira+Sans' rel='stylesheet'>
  <style>
  /* For elements table, th and td, set their width to 100%*/
  table, th, td {
    width: 100px;
    font-size: 30px;
    color: black;
  }
  /* Set the table's padding to 40px */
  table {
    padding: 40px;
  }
  /* Set the styling for the hour boxes */
  .hour {
    /* Set the size, height and background colour for each hour box */
    width: 100%;
    height: 48px;
    margin: 0px;
    padding 0px;
    background-color: red;
  }

  </style>
</head>
<!-- Run the JavaScript function pageStart on page load -->
<body onload="pageStart();">
  <?php
  if(isset($_SESSION['last_error'])){
    // If there is an error, display the error
    echo "<br><center><font color='red'>".$_SESSION['last_error']."</font></center>";
    // Unset the error so it's not displayed again.
    unset($_SESSION['last_error']);
  }
  ?>
  <br><br>
  <!-- A form to hold the information about which hours the lights -->
  <!-- are enabled on. -->

  <a class="button" href="schedule1.php" style="width:15%;height:20px">Appliance 1</a>
  <a class="button" href="schedule2.php" style="width:15%;height:20px">Appliance 2</a>
  <a class="button" href="schedule3.php" style="background-color: green;width:15%;height:20px">Appliance 3</a>
  <a class="button" href="schedule4.php" style="width:15%;height:20px">Appliance 4</a>
  <br><br>
  <form action="set_schedule.php" method="POST">
    <!-- A hidden input box will contain the information about which -->
    <!-- lights will be enabled at which times. The information is set -->
    <!-- via the JavaScript script futhur above. -->
    <input type="hidden" id="dataholder" name="scheduledata" value="">
    <!-- When clicked run the JavaScript function sendData() -->
    <center><button onclick="sendData()" type="submit" value="Submit">Set Schedule</button>
  </center>
  </form>
  <center>
  <!-- A table with width 80% -->
  <table style="width:80%;">
    <!-- Set the table headers. -->
    <tr>
      <th></th>
      <th>Mon</th>
      <th>Tue</th>
      <th>Wed</th>
      <th>Thu</th>
      <th>Fri</th>
      <th>Sat</th>
      <th>Sun</th>
    </tr>
    <?php
    // Load the information in scheduldata.txt
    $handle = file_get_contents("scheduledata3.txt");
    $array = [];
    if(!$handle){
      // Show a debug error if there was an error opening the file
      echo "Error Opening File! " . error_get_last();
    }
    // Split up the data from $handle by character ','
    $array = explode(",",$handle);

    // For every hour in the day.
    for($i2 = 0; $i2 < 24; $i2++){
      // For every day in the week
      for($i = 0; $i < 8; $i++){
        // If in the first column
        if($i == 0){
          // Show the time down the side
          echo "<th style='width:10%'>" . ($i2 + 1) .":00</th>";
        } else {
    // If the current hour:day is found
	  if(in_array($i . ":" . ($i2 + 1), $array)  ){
      //Create a div with a green colour that runs myFunction when pressed.
      echo "<td><div class='hour' id = 'hour' onclick='myFunction(this)' day = '" . $i ."' hour = '" . ($i2 + 1) . "' style='background-color:green'></div></td>";
	  } else {
      //Create a div with a red colour that runs the JavaScript function myFunction when pressed
	     echo "<td><div class='hour' id = 'hour' onclick='myFunction(this)' day = '" . $i ."' hour = '" . ($i2 + 1) . "' style='background-color:red'></div></td>";
	  }

        }
      }
      echo "</tr>";
    }

    ?>
  </table>
  </center>
</center>
</body>
</html>
