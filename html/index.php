<?php

// Start a PHP Session to save all PHP variables.
session_start();
// If incorrect attemps are not set.
if(!isset($_SESSION['incorrect'])){
// Set the incorrect attemps to 0.
$_SESSION['incorrect'] = 0;
}
// Initialize the $login_allowed variable with a value of True.
$login_allowed = True;
// Unset the logged in variable if set.
unset($_SESSION['logged_in']);
// If the incorrect attempts value is more than 0, but less than max.
if($_SESSION[incorrect] >= 1 && $_SESSION['incorrect']<=4){
// Tell the user they typed an incorrect username or password.
echo "<b><font color='5A595A'>Incorrect Username or Password</font></b>";
}
// If incorrect attemps are not set. Set incorrect attemps to 0.
if(!isset($_SESSION['incorrect'])){
$_SESSION['incorrect'] = 0;
} else {
// If the last_attempt time is set.
if(isset($_SESSION['last_attempt'])){
// Check whether the time until they can next log in has expired.
if(($_SESSION['last_attempt']-time()) < 0){
// Set the incorrect attempts to 0.
$_SESSION['incorrect'] = 0;
// Unset the time of last attempt
unset($_SESSION['last_attempt']);
}}
// If the user has passed their max attempts and their previous attempt has expired.
if($_SESSION['incorrect'] > 5 && ($_SESSION['last_attempt']<time())){
// Add 300 seconds to the time they can next log in.
$_SESSION['last_attempt'] = time()+300;
}
// If the incorrect attemps is more than 5.
if($_SESSION['incorrect'] >= 5){
// Set the variable $time_remaining to the last attempt time – current time in seconds.
$time_remaining = $_SESSION['last_attempt']-time();
// Deny login
$login_allowed = False;
// Echo the HTMl to tell the user they had too many incorrect attemps.
echo "<b><font color='5A595A' face='verdana'>Too many incorrect attempts!</b> <br>Please try again in ". (round($time_remaining/60))." minutes and ".($time_remaining % 60)." seconds.</font>";
}
}
// Use echo as we’re still using PHP.
echo "
<html>
   <head>
      <!-- Set the pages title to Wpower Login Page -->
      <title>WPower Login page</title>
      <!-- Load the stylesheet found in the same directory as index -->
      <link rel='stylesheet' type='text/css' href='index.css'>
      <!-- Load the Google Font Fira Sans from the Google font API -->
      <link href='https://fonts.googleapis.com/css?family=Fira+Sans' rel='stylesheet'>
      <link rel='icon' type='image/png' href='favicon.png' />
   </head>
   <body>
      <center>
      <br>
      <!-- Show the title WPower -->
      <h1><font size='20'><b>WPower</b></font></h1>
      <br>";
      echo"
      <!-- A form to contain the username and password login details -->
      <form action='login_page.php' method='POST'>
         <!-- Show the text username and a text input next to it -->
         <font face='verdana' size='3'>Username</font><br>
         <br><input type='text' name='username'><br>
         <!-- Show the text password and a text input next to it -->
         <br><font face='verdana' size='3'>Password</font><br>
         <br><input type='password' name='password'><br>";
         if($login_allowed || True){
         // Show a button to submit
         echo    " <br><input type='submit' value='Submit'>";
         }
         echo"      
      </form>
      <center>
   </body>
</html>
";
