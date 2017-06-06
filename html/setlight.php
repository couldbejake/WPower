<?php
session_start();
if($_GET["light"]){
$_SESSION['last_light'] = $_GET["light"];
}
?>
Light <?php echo $_SESSION["last_light"]; ?><br>

