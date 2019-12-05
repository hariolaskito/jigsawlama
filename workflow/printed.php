<?php

date_default_timezone_set('Australia/Melbourne');

$servername = "localhost";
$username = "root";
$password = "";
$database = "jigsawpu_orders";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "update `puzzles` set `print_datetime` = now() where `puzzle_no` = ".$_GET['puzzle'];
$result = $conn->query($sql);

$sql = "SELECT `print_datetime` FROM `puzzles` where `puzzle_no` = ".$_GET['puzzle'];

$result = $conn->query($sql);
$row = $result->fetch_assoc();
echo $row['print_datetime'];
?>