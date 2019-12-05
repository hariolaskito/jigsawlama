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

$sql = "update `order` set `tracking_no` = '".$_GET['tracking']."' where `order_no` = ".$_GET['order'];
$result = $conn->query($sql);

$sql = "SELECT `tracking_no`, `email_address` FROM `order` where `order_no` = ".$_GET['order'];

$result = $conn->query($sql);
$row = $result->fetch_assoc();

$to = $row['email_address'];
$subject = "Your Jigsaw Puzzle has been sent.";



$message = "
<html>
<head>
<title>Your Jigsaw Puzzle Order</title>
<!-- Latest compiled and minified CSS -->
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
<!-- jQuery library -->
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<!-- Latest compiled JavaScript -->
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
</head>
<body>
<div class='container'>
<h3>Your Custom Jigsaw Puzzle has been sent!</h3>



<p>We are pleased to advise that your puzzle can be tracked by <a href='https://auspost.com.au/parcels-mail/track.html#/track' class='btn btn-primary'>clicking here</a> and entering your tracking number ".$row['tracking_no'].".</p>


Regards,

<p>Peter and Susan Begbie<br />
Jigsaw Puzzles Australia</p>
</div>
</body>
</html>";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <webmaster@jigsawpuzzlesaustralia.com.au>' . "\r\n";

mail($to,$subject,$message,$headers);


echo $row['tracking_no'];
?>