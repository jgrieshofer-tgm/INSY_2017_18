<?php
$servername = "localhost";
$username = "flightticket";
$password = "ticket";
$database = "flightdata";
$port = "3306";

// Create connection
$db = new mysqli($servername, $username, $password, $database, $port);
if(!$db)
{
  exit("Verbindungsfehler: ".mysqli_connect_error());
}else {
}
?>
