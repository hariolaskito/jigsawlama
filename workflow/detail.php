<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Jigsaw Puzzles Australia - Workflow Management System</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/grayscale.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesnt work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script>
    	function approve(puzzle) {
	  if (window.XMLHttpRequest) {
	    // code for IE7+, Firefox, Chrome, Opera, Safari
	    xmlhttp=new XMLHttpRequest();
	  } else {  // code for IE6, IE5
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp.onreadystatechange=function() {
	    if (this.readyState==4 && this.status==200) {
	      document.getElementById("approve"+puzzle).innerHTML=this.responseText;
	    }
	  }
	  var postage = document.getElementById("postage"+puzzle).value;
	  xmlhttp.open("GET","approve.php?puzzle="+puzzle+"&postage="+postage,true);
	  xmlhttp.send();	  	   
	}

    	function collapprove(order) {
	  if (window.XMLHttpRequest) {
	    // code for IE7+, Firefox, Chrome, Opera, Safari
	    xmlhttp=new XMLHttpRequest();
	  } else {  // code for IE6, IE5
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp.onreadystatechange=function() {
	    if (this.readyState==4 && this.status==200) {
	      document.getElementById("collapproved").innerHTML=this.responseText;
	    }
	  }
	  var postage = document.getElementById("collpostage").value;
	  var design = document.getElementById("colldesign").value;
	  xmlhttp.open("GET","collapprove.php?order="+order+"&postage="+postage+"&design="+design,true);
	  xmlhttp.send();	  	   
	}


	function printed(puzzle) {
	  if (window.XMLHttpRequest) {
	    // code for IE7+, Firefox, Chrome, Opera, Safari
	    xmlhttp=new XMLHttpRequest();
	  } else {  // code for IE6, IE5
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp.onreadystatechange=function() {
	    if (this.readyState==4 && this.status==200) {
	      document.getElementById("printed"+puzzle).innerHTML=this.responseText;
	    }
	  }
	  xmlhttp.open("GET","printed.php?puzzle="+puzzle,true);
	  xmlhttp.send();	  	   
	}
	
	function sent(puzzle) {
	  if (window.XMLHttpRequest) {
	    // code for IE7+, Firefox, Chrome, Opera, Safari
	    xmlhttp=new XMLHttpRequest();
	  } else {  // code for IE6, IE5
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp.onreadystatechange=function() {
	    if (this.readyState==4 && this.status==200) {
	      document.getElementById("sent"+puzzle).innerHTML=this.responseText;
	    }
	  }
	  xmlhttp.open("GET","sent.php?puzzle="+puzzle,true);
	  xmlhttp.send();	  	   
	}	
	
	function tracking(order) {
	  if (window.XMLHttpRequest) {
	    // code for IE7+, Firefox, Chrome, Opera, Safari
	    xmlhttp=new XMLHttpRequest();
	  } else {  // code for IE6, IE5
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp.onreadystatechange=function() {
	    if (this.readyState==4 && this.status==200) {
	      document.getElementById("tracking").innerHTML=this.responseText;
	    }
	  }
	  var tracking = document.getElementById("tracking_no").value;
	  xmlhttp.open("GET","tracking.php?order="+order+"&tracking="+tracking,true);
	  xmlhttp.send();	  	   
	}	
	</script>
    

</head>

<body id="page-top" data-spy="scroll" data-target=".navbar-fixed-top">

    <!-- Navigation -->
    <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">
                    <i class="fa fa-play-circle"></i><span class="light">Jigsaw Puzzles Australia</span> - Workflow Management System
                </a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right navbar-main-collapse">
                <ul class="nav navbar-nav">
                    <!-- Hidden li included to remove active class from about link when scrolled up past about section -->
                    <li class="hidden">
                        <a href="index.php#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="index.php#page-top">Open Orders</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="index.php#search">Search</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
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

$sql = "SELECT * FROM `order` where `order_no` = ".$_GET['order'];
$result = $conn->query($sql);
?>

    <!-- Intro Header -->
    <header class="intro" style="padding-top:75px">
        <div class="intro-body">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3>Order Details</h3>
                        <table class='table table-bordered'>
<?php
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

//  collage_type ?
   
    if($row['collage_type'] == '') {

    	echo "<tr><td class='text-left'>Order #<td class='text-left'>".$row['order_no']."
    	      <tr><td class='text-left'>Customer Name<td class='text-left'>".$row['cust_name']."
    	      <tr><td class='text-left'>Customer Email<td class='text-left'><a href='mailto:".$row['email_address']."'>".$row['email_address']."</a>
    	      <tr><td class='text-left'>Customer Phone<td class='text-left'>".$row['phone_no']."
    	      <tr><td class='text-left'>Delivery Address<td class='text-left'>".$row['cust_address1']."<br />".$row['cust_address2']."<br />".$row['suburb']."  ".$row['state']."  ".$row['postcode']."
    	      <tr><td class='text-left'>Tracking #<td class='text-left' id='tracking'><input placeholder='Tracking #' style='color:black' class='col-xs-6' id='tracking_no' type='text'><a class='btn btn-primary' onclick='tracking(".$row['order_no'].")'>Tracked</a>";
    } else {

    	echo "<tr><td class='text-left'>Order #<td class='text-left'>".$row['order_no']."
    	      <tr><td class='text-left'>Customer Name<td class='text-left'>".$row['cust_name']."
    	      <tr><td class='text-left'>Customer Email<td class='text-left'><a href='mailto:".$row['email_address']."'>".$row['email_address']."</a>
    	      <tr><td class='text-left'>Customer Phone<td class='text-left'>".$row['phone_no']."
    	      <tr><td class='text-left'>Delivery Address<td class='text-left'>".$row['cust_address1']."<br />".$row['cust_address2']."<br />".$row['suburb']."  ".$row['state']."  ".$row['postcode']."
    	      <tr><td class='text-left'>Collage Size<td class='text-left'>".$row['collage_type']."
    	      <tr><td class='text-left'>Approved<td class='text-left' id='collapproved'>
    	      <input placeholder='Postage ($.00)' style='color:black' class='col-xs-4' id='collpostage' type='text'>
    	      <input placeholder='Design Fee ($.00)' style='color:black' class='col-xs-4' id='colldesign' type='text'>
    	      <a class='btn btn-primary' onclick='collapprove(".$row['order_no'].")'>Approved</a>

    	      <tr><td class='text-left'>Tracking #<td class='text-left' id='tracking'><input placeholder='Tracking #' style='color:black' class='col-xs-6' id='tracking_no' type='text'>
    	      <a class='btn btn-primary' onclick='tracking(".$row['order_no'].")'>Tracked</a>";
    
    }
}
?>

                        </table>
                    </div>
                </div>
<?php
$sql = "SELECT * FROM `order` join `puzzles` on `order`.`order_no` = `puzzles`.`order_no` where `collage_type` = '' and `order`.`order_no` = ".$_GET['order'];
$result = $conn->query($sql);
if ($result->num_rows > 0) {

?>
                <div class="row">
                    <div class="col-md-12">
                        <h3>Puzzle Details</h3>
                        <table style="width:100%">
<?php
    while($row = $result->fetch_assoc()) {
    	if($row['approve_datetime'] == '0000-00-00 00:00:00'){
    	    $approve = "<input placeholder='Postage' class='col-xs-6' style='color:black' id='postage".$row['puzzle_no']."' type='text'><a class='btn btn-primary' onclick='approve(".$row['puzzle_no'].")'>Approved</a>";
    	} else {
    	    $approve = date('d/m/Y H:i', strtotime($row['approve_datetime']));
    	}
    	if($row['print_datetime'] == '0000-00-00 00:00:00'){
    	    $printed = "<a class='btn btn-primary' onclick='printed(".$row['puzzle_no'].")'>Done</a>";
    	} else {
    	    $printed = date('d/m/Y H:i', strtotime($row['print_datetime']));
    	}
    	if($row['sent_datetime'] == '0000-00-00 00:00:00'){
    	    $sent = "<a class='btn btn-primary' onclick='sent(".$row['puzzle_no'].")'>Sent</a>";
    	} else {
    	    $sent = date('d/m/Y H:i', strtotime($row['sent_datetime']));
    	}
    	
    	

    	echo "<tr>
    		<td>
    			<table class='table table-bordered'>
    				<tr>
    				   <td class='text-left' rowspan='3' style='width:15%'><img class='img-responsive' src='../".$row['filename']."'>
    				   <td class='text-left'>Puzzle Type
    				   <td class='text-left'>".$row['puzzle_type']."
    				<tr>
    				   <td class='text-left'>Box Type
    				   <td class='text-left'>".$row['box_type']."
    				<tr>
    				   <td class='text-left'>Number ordered
    				   <td class='text-left'>".$row['num_ordered']."
    			</table>
    	      <tr><td><table class='table table-bordered'><tr><td class='text-left'>Ordered<td class='text-left'>".date('d/m/Y H:i', strtotime($row['order_datetime']))."
    	      <td class='text-left'>Approved<td class='text-left' id='approve".$row['puzzle_no']."'>".$approve."
    	      <td class='text-left'>Printed<td class='text-left' id='printed".$row['puzzle_no']."'>".$printed."
   	      <td class='text-left'>Sent<td class='text-left' id='sent".$row['puzzle_no']."'>".$sent."
   	      </table>";
    }

?>

                        </table>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Footer -->
    <footer>
        <div class="container text-center">
            <p>Copyright &copy; Jigsaw Puzzles Australia 2017</p>
        </div>
    </footer>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="js/jquery.easing.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/grayscale.js"></script>

</body>

</html>