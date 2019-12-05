<?php

date_default_timezone_set('Australia/Melbourne');

$number = 1234.56;

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

$sql = "update `puzzles` set `approve_datetime` = now() where `puzzle_no` = ".$_GET['puzzle'];
$result = $conn->query($sql);

$sql = "SELECT `approve_datetime`, `filename`, `email_address`, `puzzle_type`, `num_ordered`, `sameday`, `box_type` FROM `puzzles` join `order` on `puzzles`.`order_no` = `order`.`order_no` where `puzzle_no` = ".$_GET['puzzle'];

$result = $conn->query($sql);
$row = $result->fetch_assoc();

//setlocale(LC_MONETARY, 'en_AU.UTF-8');

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

// $price = ($cost[$row['puzzle_type']] * $row['num_ordered']) + $_GET['postage'];

// $invoice = "<table class='table'><tr><td>".$row['num_ordered']." x ".$row['puzzle_type']."<td>".money_format('%.2n', ($cost[$row['puzzle_type']] * $row['num_ordered']))."<tr><td>Express Postage<td>".money_format('%.2n', $_GET['postage']);
// if($row['box_type'] == 'Sturdy clip-lid Plastic Boxes (+$9.95)') {
//	$box_cost = 9.95;
//	$price += ($box_cost * $row['num_ordered']);
//	$invoice .= "<tr><td>".$row['num_ordered']." x ".$row['box_type']."<td>".money_format('%.2n', ($box_cost * $row['num_ordered']));
// }
// if($row['sameday'] == 'Same Day Manufacture (+$7.50)') {
//		$sameday_cost = 7.5;
//		$price += $sameday_cost;
//		$invoice .= "<tr><td>".$row['sameday']."<td>".money_format('%.2n', $sameday_cost);
// }

// $invoice .= "<tr><td>Total<td>".money_format('%.2n', $price)."</table>";

// Code No Money Format


function asDollars($value) {
  return '$' . number_format($value, 2);
}

// echo $pricetotal = asDollars($pricetotal);

$price = ($cost[$row['puzzle_type']] * $row['num_ordered']) + $_GET['postage'];

$invoice = "<table class='table'><tr><td>".$row['num_ordered']." x ".$row['puzzle_type']."<td>".($cost[$row['puzzle_type']] * $row['num_ordered'])."<tr><td>Express Postage<td>".$_GET['postage'];
if($row['box_type'] == 'Sturdy clip-lid Plastic Boxes (+$9.95)') {
	$box_cost = 9.95;
	$price += ($box_cost * $row['num_ordered']);
	$invoice .= "<tr><td>".$row['num_ordered']." x ".$row['box_type']."<td>".($box_cost * $row['num_ordered']);
 }
 if($row['sameday'] == 'Same Day Manufacture (+$7.50)') {
		$sameday_cost = 7.5;
		$price += $sameday_cost;
		$invoice .= "<tr><td>".$row['sameday']."<td>".$sameday_cost;
 }

 $price = asDollars($price);
 $invoice .= "<tr><td>Total<td>".$price."</table>";


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
<p>We are pleased to advise that the image you uploaded has sufficient resolution and clarity for us to make your jigsaw.</p>
<img class='img-responsive' src='http://jigsawpuzzlesaustralia.com.au/dev/".$row['filename']."'>
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

echo $row['approve_datetime'];
?>