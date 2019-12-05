<?php

date_default_timezone_set('Australia/Melbourne');

$array = json_decode($_POST['cart_images'], true);

$to = "pbeg23@gmail.com";
$subject = "Collage Jigsaw Puzzle Order";

$message = "
<html>
<head>
<title>Collage Jigsaw Puzzle Order</title>
<!-- Latest compiled and minified CSS -->
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
<!-- jQuery library -->
<script src='https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js'></script>
<!-- Latest compiled JavaScript -->
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
</head>
<body>
<p>You have received another jigsaw puzzle order. Details are as follows:</p>
<table class='table'>
   <tr><td>Customer name:<td>".$_POST['name']." ".$_POST['surname']."</tr>
   <tr><td>Customer address:<td>".$_POST['addr1']."<br /> ".$_POST['addr2']."<br />".$_POST['city']."  ".$_POST['state']."   ".$_POST['postcode']."</tr>
   <tr><td>Customer email:<td>".$_POST['email']."</tr>
   <tr><td>Customer phone:<td>".$_POST['phone']."</tr>
</table>";

// Always set content-type when sending HTML email
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
$headers .= 'From: <webmaster@jigsawpuzzlesaustralia.com.au>' . "\r\n";
$success = true;

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


$sql = "INSERT INTO `order` (`cust_name`,`cust_address1`,`cust_address2`,`suburb`,`state`,`postcode`,`email_address`,`phone_no`, `order_datetime`, `collage_type`) VALUES ('".$_POST['name']." 
".$_POST['surname']."', '".$_POST['addr1']."', '".$_POST['addr2']."', '".$_POST['city']."', '".$_POST['state']."', '".$_POST['postcode']."', '".$_POST['email']."', '".$_POST['phone']."', 
now(), '".$_POST['jigsaw_type']."')";

if ($conn->query($sql) === TRUE) {
    $order_no = $conn->insert_id;
    $message .= "<h3>Order Number: ".$order_no."</h3>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    $success = false;
}

foreach ($array as &$row) {
    $sql = "INSERT INTO `puzzles` (`order_no`, `filename`, `puzzle_type`, `box_type`, `num_ordered`) VALUES (".$order_no.", '".$row['img_file']."', 'Collage - ".$_POST['jigsaw_type']."', 'Strong 1400gsm Cardboard Boxes (standard)', 1)";

    if ($conn->query($sql) === TRUE) {
        continue;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
        $success = false;
    }
}
$conn->close();
$message .= "</body></html>";

if($success) {
    mail($to,$subject,$message,$headers);
    header("Location: http://jigsawpuzzlesaustralia.com.au/dev/index.php?order=success");
}

?>