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

$sql = "SELECT * FROM `order`";
$result = $conn->query($sql);

$q=$_GET["q"];

$hint = "<table class='table' style='border:1'>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        if (stristr($row['cust_name'],$q)) {
             if($hint == "<table class='table'>") {
	          $hint="<tr><td><a href='detail.php?order=".$row['order_no']."'>Order #".$row['order_no']."</a><td>".$row['cust_name']
	          ."<td>".$row['cust_address1']."<td>".$row['cust_address2']."<td>".$row['suburb']."<td>".$row['state']."<td>".$row['postcode']."<td><a href='mailto:".$row['email_address']."'>".$row['email_address']."</a><td>".$row['phone_no']."</tr>";       
	     } else {
	          $hint.="<tr><td><a href='detail.php?order=".$row['order_no']."'>Order #".$row['order_no']."</a><td>".$row['cust_name']
	          ."<td>".$row['cust_address1']."<td>".$row['cust_address2']."<td>".$row['suburb']."<td>".$row['state']."<td>".$row['postcode']."<td><a href='mailto:".$row['email_address']."'>".$row['email_address']."</a><td>".$row['phone_no']."</tr>";   
	     }    	     
        }
    }
}

if ($hint=="<table class='table'>") {
  $response="no suggestion";
} else {
  $hint .="</table>";
  $response=$hint;
}

//output the response
echo $response;

?>