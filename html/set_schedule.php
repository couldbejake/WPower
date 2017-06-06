<?php

// Start a PHP session to keep all variables
session_start();

$schedule_id = $_SESSION['last_scheduled'];

// If not logged in
if(!$_SESSION['logged_in']){
// Redirect the user to the login page
header('Location: index.php');
}
// Echo the schedule data for debug
echo $_POST['scheduledata'];
// set the file name to schedule data.
$file_name = 'scheduledata' . $schedule_id . '.txt';
// If schedule data is recieved
if(!empty($_POST['scheduledata'])){
// Set the variable data to the recieved POST data
$data = $_POST['scheduledata'];
// Save the data to the file with name file_name.
file_put_contents($file_name, $data);
} else {
// If there is no schedule data, save a default.
file_put_contents($file_name, "0:0");
}


$result = exec("python /var/www/schedule_player.py 2>&1", $output);

//os.system("python /var/www/schedule_player.py");

header('Location: schedule' . $schedule_id . '.php');

?>
