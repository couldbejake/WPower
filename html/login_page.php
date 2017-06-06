<?php
session_start();

// Connect to the MYSQL database using DB login details
$con = mysql_connect('localhost','wpower_access','D9kdp144wp193');

// Select the database wpower_users
mysql_select_db('wpower_users');

// Set a default for the variable $username
$username = '';

// If the username is not set from post
if(!isset($_POST['username'])){
  // Take the username from the session variables
  $username = $_SESSION['username'];
} else {
  // Take the username from the POST.
  $username = $_POST['username'];
}

// Do a query to check whether $username exists
$change_pass = mysql_query("SELECT * FROM wpower_table WHERE user_name='".$username."'",$con);

// Get the number of rows from the query
if(mysql_num_rows($change_pass) >= 1){
  $array = mysql_fetch_array($change_pass);
  // Get the variable for whether the user has logged in before.
  $logged_in =  $array[4];
  // If the user has not logged in before
  if($logged_in == 0){
    // Set their incorrect attemps to 0, and logged in to true.
    $_SESSION['incorrect'] = 0;
    $_SESSION['logged_in'] = True;
    // Redirect the user to the change password page.
    header('Location: changepassword.php');
  }}
  // If the username or password is not set
  if(!isset($_POST['username']) || !isset($_POST['password'])){
    // If the user is not logged in
    if(!$_SESSION['logged_in']){
      // Redirect them to the login page
      header('Location: index.php');
    }
  } else {
    $_SESSION['username'] = $_POST['username'];
  }
  // Welcome the user back and show a message.
  echo "<br><center><h1>Appliance Panel</h1>";
  echo "<br><center><b><font face='verdana'>Welcome back ".$_SESSION['username']."</face>!</b></center>";
  echo "<br><center><strong><a href='logout.php'>Logout</a></strong>";
  echo " | ";
  echo "<strong><a href='schedule1.php'>Appliance Schedule</a></strong>";
  echo " | ";
  echo "<strong><a href='admin.php'>Admin Panel</a></strong>";
  echo " | ";
  echo "<strong><a href='powerusage.php'>Power Usage</a></strong></center>";

  // Load the last permission error to a local variable
  $last_perm_error =  $_SESSION['last_perm_error'];
  // If the last permission error is not empty
  if(!empty($last_perm_error)){
    // Display the message
    echo "<br><center><font color='red'>".$_SESSION['last_perm_error']."</font></center>";

    // Delete the message so it’s not displayed again.
    unset($_SESSION['last_perm_error']);
  }
  // Connect to the MYSQL database with the DB details
  $con = mysql_connect('localhost','wpower_access','D9kdp144wp193');

  // Select the database wpower_users
  mysql_select_db('wpower_users');
  // Do a query to check whether the entered usernames and passwords are correct
  // Note: Binary ensures the password is case sensitive (It compares the binary version of the passwords).
  $query = mysql_query("SELECT * FROM wpower_table WHERE user_name='".$_POST['username']."' AND BINARY password='".$_POST['password']."'",$con);
  // See how many rows of results are returned
  $result_count = mysql_num_rows($query);
  // If there are no instances
  if($result_count==0){
    // Add one to the incorrect count
    $incorrect = $_SESSION['incorrect'];
    $incorrect = $incorrect + 1;
    $_SESSION['incorrect'] = $incorrect;
  } else {
    // else log the user in.
    $_SESSION['logged_in'] = True;
  }
  if(!$_SESSION['logged_in']){
    // If not logged in redirect the user to the login page
    header('Location: index.php');
  }
  ?>
  <html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Load the custom style sheets && Custom google font -->
    <link rel='stylesheet' type='text/css' href='index.css'>
    <link href='https://fonts.googleapis.com/css?family=Fira+Sans' rel='stylesheet'>
    <link rel='icon' type='image/png' href='favicon.png' />
  </head>
  <body>
    <br><br>
    <center>
      <!-- A form which sends a value to a PHP Script -->
      <form action='relay_executor.php' method='POST'>
        <!-- Each button is a submit button and sends a different value -->
        <!-- to the relay_executor.php script -->
        <button name="value" value="1" type="submit">TV | On</button>
        <button name="value" value="2" type="submit">TV | Off</button><br>
        <!-- A break to format buttons in two -->
        <br>
        <button name="value" value="3" type="submit">TV Light | On</button>
        <button name="value" value="4" type="submit">TV Light | Off</button><br>
        <br>
        <button name="value" value="5" type="submit">Side Light | On</button>
        <button name="value" value="6" type="submit">Side Light | Off</button><br>
        <br>
        <button name="value" value="7" type="submit">Light 4 | On</button>
        <button name="value" value="8" type="submit">Light 4 | Off</button>
      </form>
    </center>
  </body>
  </html>
