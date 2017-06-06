<?php
// Start a PHP session to keep all variables
session_start();
// If not logged in.
if(!isset($_SESSION['logged_in'])){
  // Redirect the user to the login page.
  header('Location: index.php');
}
// Set the variable user to the post data.
$user = $_POST['removeUser'];

// Connect to the MYSQL database with the DB login details.
$con = mysql_connect('localhost','wpower_access','D9kdp144wp193');
// Select the database wpower_users.
mysql_select_db('wpower_users');
echo $user; echo $_SESSION['username'];
if(strtolower($user) == strtolower($_SESSION['username'])){

  $_SESSION['last_error'] = "You can not delete yourself!";
  // Redirect them to the admin page.
  header('Location: admin.php');
} else {

  // Do a MYSQL query to see the users in wpower_table with the username $user
  $exists = mysql_query("DELETE FROM wpower_table WHERE user_name='".$user."'",$con);
  // If the query returned 1.
  if($exists ==1){
    // Tell the user the $user was successfully removed.
    $_SESSION['last_error'] = "Successfully removed user!";
    // echo success for debug.
    echo "success!";
  }
}

// Redirect the user to the admin panel
header('Location: admin.php');
?>
