<?php
   // Start a session to insure all variables are saved.
   Session_start();
   // Connect to the MYSQL database with the DB login
   $con = mysql_connect('localhost','wpower_access','D9kdp144wp193');
   // Select the database wpower_users
   mysql_select_db('wpower_users');
   // Do a query to  get all information for a user.
   $query = mysql_query("SELECT * FROM wpower_table WHERE user_name='".$_SESSION['username']."'",$con);
   $result = mysql_fetch_array($query);
   // If the 4th column of the users data = 0 (if privilege_level = 0)
   if($result[3]==0){
   // Tell the user they do not have access
   $_SESSION['last_perm_error'] = "You do not have permission to access this area.";
   // Redirect the user to the login page.
   header('Location: login_page.php');
   }

   // If the username is not set, or the password is not set.
   if(!isset($_POST['username']) || !isset($_POST['password'])){
   if(!$_SESSION['logged_in']){
   // If the user is not logged in.
   // Redirect them to the login page.
   header('Location: index.php');
   }
   } else {
   // If logged in, set the session name username to the post data recieved
   $_SESSION['username'] = $_POST['username'];
   }

  echo "<br><center><h1>Admin Panel</h1>";   
  echo "<br><center><b><font face='verdana'>Welcome back ".$_SESSION['username']."</face>!</b></center>";
  echo "<br><center><strong><a href='logout.php'>Logout</a></strong>";
  echo " | ";
  echo "<strong><a href='login_page.php'>Main Panel</a></strong>";
  echo " | ";
  echo "<strong><a href='schedule1.php'>Appliance Schedule</a></strong>";
  echo " | ";
 
  echo "<strong><a href='powerusage.php'>Power Usage</a></strong></center>";

   // Connect to the MYSQL database with DB login details.
   $con = mysql_connect('localhost','wpower_access','D9kdp144wp193');
   
   // Select the database wpower_users
   mysql_select_db('wpower_users');
   
   // Do a MYSQL query to collect all users with matching username and password.
   $query = mysql_query("SELECT * FROM wpower_table WHERE user_name='".$_POST['username']."' AND BINARY password='".$_POST['password']."'",$con);
   
   //Count the number of rows received from the Query.
   $result_count = mysql_num_rows($query);
   
   // If the user does not exist.
   if($result_count==0){
   
   // Add one to the incorrect attemps
   $incorrect = $_SESSION['incorrect'];
   $incorrect = $incorrect + 1;
   $_SESSION['incorrect'] = $incorrect;
   
   //If not logged in, redirect to the login page.
   if(!$_SESSION['logged_in']){
   header('Location: index.php');
   }
   
   } else {
   
   // Set logged in to true
   $_SESSION['logged_in'] = True;
   
   }
   
   ?>
<html>
   <head>
      <!-- Load the stylesheet in the same directory as index.php -->
      <link rel='stylesheet' type='text/css' href='index.css'>
      <!-- Load the google font Fira Sans from the google font apis -->
      <link href='https://fonts.googleapis.com/css?family=Fira+Sans' rel='stylesheet'>
      <link rel='icon' type='image/png' href='favicon.png' />
   </head>
   <body>
      <?php
         // If there is a message to display to the user.
         
         if(isset($_SESSION['last_error'])){
         
          // Display the message
         
          echo "<br><center><font color='red'>".$_SESSION['last_error']."</font></center>";
         
          // Delete the message so it’s not displayed again.
         
          unset($_SESSION['last_error']);
         }
         ?>
      <br><br>
      <!-- A heading to inform the user the function of the section -->
      <center>
         <h1 style="font-size:25px">Add a user</h1>
      </center>
      <center>
      <!-- A HTML form used to add a user via POST -->
      <form action='add_user.php' method='POST'>
         <!-- An input box with the placeholder text username -->
         <input type="text" name="user" placeholder = "Username">
         <!-- A button which allows the user to send the form -->
         <button name="value" value="1" type="submit">Add User</button><br>
         <!-- The ability for the user to change access levels -->
         <br>
         <tag>Access level : </tag>
         <!-- A drop down menu showing the access levels avaliable -->
         <select name="privLevel">
            <option value="0">Low</option>
            <option value="1">High</option>
         </select><br><br>
	 <tag>Randomly Generated Password : </tag>
	 <?php
	 // Generating a random password. I found this by looking at various forums about their methods.
	 $rand = substr(md5(microtime()), rand(0,26), 5);

	 echo "<input type='text' style='width:100px;' name='pass' value = '" . $rand . "' placeholder = '". $rand ."' readonly>"; 

	 ?>
      </form>
      <br><br>
      <!-- A heading to inform the user the function of the section -->
      <center>
         <h1 style="font-size:25px">Remove a user</h1>
      </center>
      <center>
         <!-- Another form allowing the admin to send a POST form to a php script -->
         <form action='remove_user.php' method='POST'>
            <!-- A Drop Down Menu -->
            <select name="removeUser">
            <?php
               // Connect to the MYSQL database using DB login details
               $con = mysql_connect('localhost','wpower_access','D9kdp144wp193');
               
               // Select the database wpower_users.
               mysql_select_db('wpower_users');
               
               // Set the variable $users to the array of all users from wpower_table.
               $users = mysql_query("SELECT * FROM wpower_table",$con);
               
               // For every row in the query
               while ($row = mysql_fetch_array($users)){
               
               // If the current row’s user is an admin
               if($row[3]== 1){
               
               // Add their username to the drop down menu with stars around it.
               echo "<option value='".$row[1]."'>*".$row[1]."* </option>";
               } else {
               
               // Display their username.
               echo "<option value='".$row[1]."'>".$row[1]."</option>";
               }	
               }
               ?>
            </select>
            <!-- A button to send the remove_user.php POST form -->
            <button name="value" value="1" type="submit">Remove User</button><br>
         </form>
      </center>
   </body>
</html>
