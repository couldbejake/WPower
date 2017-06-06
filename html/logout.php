<?php

// Start  PHP session to keep all variables.
session_start();
// If logged in, destroy the session.
// This prevents people from bypassing the timeout by visiting the logout.php page.
if(isset($_SESSION['logged_in'])){
  // Destroy the session and delete all variables
  session_destroy();
  // Redirect the user to the login page.
  header("Location: index.php");
} else {
  // Redirect the user to the login page.
  header("Location: index.php");
}
?>
