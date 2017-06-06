<?php
// Start a PHP session to keep all variables.
session_start();
// If the user is not logged in.


if(!isset($_SESSION['logged_in'])){
  // Redirect them to login page.
  //header('Location: index.php');
}
// Echo the ID of the light turned on for debugging.
echo $_POST['value'][0];
echo "<br>";
// Execute the python script relay_handler.py with the argument of the ID of which light to turn on.
//$result = exec("sudo /usr/bin/python /var/www/relay_handler.py ".$_POST['value']." 2>&1", $output);

$result = exec("sudo /usr/bin/python /var/www/relay_handler.py ".$_POST['value']." ". $_SESSION['username']." 2>&1", $output);

// Redirect the user back to the main page.
header('Location: login_page.php');
?>
