<?php
session_start();
// If not logged in, redirect the user to the login screen.
if(!$_SESSION['logged_in'] == True){
header('Location: index.php');
}
// show a personalised welcome back message.
echo "<br><center><b><font face='verdana' style='font-size:25px'>Welcome back ".$_SESSION['username']."</face>!</b></center>";
?>
<html>
<head>
      <!-- Load styling sheet && custom google font -->
      <link rel='stylesheet' type='text/css' href='index.css'>
      <link href='https://fonts.googleapis.com/css?family=Fira+Sans' rel='stylesheet'>
      <link rel='icon' type='image/png' href='favicon.png' />
</head>
<body>
<br><br>
<!-- A heading to tell the user to change their password -->
<center><h1 style="font-size:25px">Please change your password using the field below</h1></center>
<!-- A form containing an input box for the user's password -->
<form action='set_password.php' method='POST'>
	<center>
         <!-- An input box with the placeholder text password -->
         <input type="password" name="password" placeholder = "Password">
         <!-- A button which allows the user to send the form -->
         <button name="value" value="1" type="submit">Set Password</button><br>
         <!-- The ability for the user to change access levels -->
         <br>
	</center>
</form>
</center>
</body>
</html>
