<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "usermanagement";

$conn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
if(mysqli_connect_error()){
    die("Failed to connect ".mysqli_error($conn));
}

// echo "Connected Successfully ";

?>