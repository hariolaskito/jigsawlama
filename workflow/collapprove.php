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

$sql = "SELECT `email_address`, `collage_type` FROM `order` where `order_no` = ".$_GET['order'];


$result = $conn->query($sql);
$row = $result->fetch_assoc();

setlocale(LC_MONETARY, 'en_AU.UTF-8');

$cost['30 pieces - $24.50 (inc GST)'] = 24.5;
$cost['36 pieces - $29.50 (inc GST)'] = 29.5;
$cost['60 pieces - $31.50 (inc GST)'] = 31.5;
$cost['120 pieces - $24.50 (inc GST)'] = 24.5;
$cost['252 pieces - $31.50 (inc GST)'] = 31.5;
$cost['500 pieces - $39.50 (inc GST)'] = 39.5;
$cost['1000 pieces - $59.50 (inc GST)'] = 59.5;
$cost['Australia - $39.50 (inc GST)'] = 39.5;
$cost['Love Heart - $29.50 (inc GST)'] = 29.5;
$box_cost = 0;

$price = $cost[$row['collage_type']] + $_GET['postage'] + $_GET['design'];

$invoice = "<table class='table'><tr><td> 1 x ".$row['collage_type']."<td>".money_format('%.2n', $cost[$row['collage_type']])."<tr><td>Express Postage<td>".money_format('%.2n', $_GET['postage'])." <tr><td>Design Fee<td>".money_format('%.2n', $_GET['design']);

$invoice .= "<tr><td>Total<td>".money_format('%.2n', $price)."</table>";

$to = $row['email_address'];
$subject = "Your Jigsaw Puzzle Order";



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
<h3>Thank you for ordering a customised jigsaw puzzle from us!</h3>
<p>We are pleased to advise that the images you uploaded had sufficient resolution and clarity for us to make your jigsaw.</p>
".$invoice."
<p>Bank details for payment are as follows:-</p>

<p>Bendigo Bank<br />
BSB: 633000<br />
A/c No.: 113136089<br />
A/c Name: PJB Software Australia</p>

<p>Alternatively you can call Susan on 0408-571-101 if you wish to pay by credit card.</p>

<p>You can also pay by paypal using pbeg@iprimus.com.au.</p>

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

echo "Collage Design Approved";

?>