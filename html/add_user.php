<?php

//Start a php session in order to save all variables.
session_start();

//If not logged in
if(!isset($_SESSION['logged_in'])){

//Redirect the user to the login page
header('Location: index.php');

}
// Set the local variables $user and $priv to the data from POST.
$user = $_POST['user'];
$priv = $_POST['privLevel'];
$pass = $_POST['pass'];

// Print the variables for debug
echo $user;
echo $priv;
echo $pass;

// If the variable user is null redirect the admin to the admin page.
if($user == "" || !isset($_POST['user'])){
$_SESSION['last_error'] = "The added user can not be null.";
header('Location: admin.php');
} else {

// Connect to the MYSQL database using DB login details
$con = mysql_connect('localhost','wpower_access','D9kdp144wp193');

// Select the database wpower_users
mysql_select_db('wpower_users');

// Do a query to check whether $user already exists
$already_exists = mysql_query("SELECT * FROM wpower_table WHERE user_name='".$user."'",$con);

// Get the number of rows from the query
$already_exists_count = mysql_num_rows($already_exists);
echo $already_exists_count;

// If there are one or more instances with the same username
if($already_exists_count >= 1){
echo "That user already exists!";

// Set the ‘alert’ variable.
// In order to inform the user the user already exists.
$_SESSION['last_error'] = "That user already exists!";
} else {

// Do a query to add the user to the table using $user and $priv.
// Set the password to changePass, in order to alert the created user
// when logged in, to change their password.

$query = mysql_query("INSERT INTO wpower_table (user_name,password, privilege_level, logged_in) VALUES ('" . $user . "','" . $pass . "','" . $priv. "', 0)",$con);

}

if(!$query){
 // If the query was a failure, echo the query.
 echo mysql_error();
}
// Redirect the user back to the admin.php page.
header('Location: admin.php');
}
?>
