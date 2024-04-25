<?php

$server = "localhost";
$username = "root";
$dpassword = "";
$db = "medi_connect";

$conn = new mysqli($server, $username, $dpassword, $db);

if ($conn->connect_error) {
    die("connection failed :" . $conn->connect_error);
}

?>