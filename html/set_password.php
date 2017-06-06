<?php
// Start a PHP session to keep all variables
session_start();
// If not logged in.
if(!isset($_SESSION['logged_in'])){
  // Redirect the user to the login page.
  header('Location: index.php');
}
// Disallow an empty password.
if(empty($_POST['password'])){
  // Redirect the user to the change password page.
  header('Location: changepassword.php');
}
// Connect to the MYSQL DB using DB login details.
$con = mysql_connect('localhost','wpower_access','D9kdp144wp193');
// Select the database wpower_users.
mysql_select_db('wpower_users');
// Set the user's password to $_POST['password'] and the logged_in value to 1, to signify the user has logged in.
$query1 = mysql_query("UPDATE wpower_table SET logged_in=1, password='".$_POST['password']."' WHERE user_name='".$_SESSION['username']."'",$con);

// Debug to print Success if successful query.
if($query1){
  echo "Success setting user's data!";
}
// Redirect the user to the main page.
header('Location: login_page.php');
?>
