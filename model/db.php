<?php

$DBhostname = "localhost";
$DBusername = "root";
$DBpassword = "";
$DBname = "online_book_store";

$conn = new mysqli(
    $DBhostname,
    $DBusername,
    $DBpassword,
    $DBname
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>