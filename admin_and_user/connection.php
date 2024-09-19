<?php
$hostname = "localhost";
$username = "root";
$password = "root";
$db = "nature";
$conn = mysqli_connect($hostname, $username, $password, $db);

if (!$conn) 
{
    echo("Database not connected");
}

?>