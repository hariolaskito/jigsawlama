<?php

date_default_timezone_set('Australia/Melbourne');

?>

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
	
	function showResult(str) {
	  if (str.length==0) { 
	    document.getElementById("livesearch").innerHTML="";
	    document.getElementById("livesearch").style.border="0px";
	    return;
	  }
	  if (window.XMLHttpRequest) {
	    // code for IE7+, Firefox, Chrome, Opera, Safari
	    xmlhttp=new XMLHttpRequest();
	  } else {  // code for IE6, IE5
	    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  xmlhttp.onreadystatechange=function() {
	    if (this.readyState==4 && this.status==200) {
	      document.getElementById("livesearch").innerHTML=this.responseText;
	      document.getElementById("livesearch").style.border="1px solid #A5ACB2";
	    }
	  }
	  xmlhttp.open("GET","livesearch.php?q="+str,true);
	  xmlhttp.send();
	}
	
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
	      document.getElementById("tracking_no").innerHTML=this.responseText;
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
                        <a href="#page-top"></a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#about">Open Orders</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="#search">Search</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
<?php

// Login database 

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

$sql = "SELECT `order`.`order_no`, `cust_name`, `email_address`, `phone_no`, `order_datetime`, `cust_address1`, `cust_address2`, `suburb`, `state`, `postcode` FROM `order` join `puzzles` on `order`.`order_no` = `puzzles`.`order_no` where `sent_datetime` = '0000-00-00 00:00:00' group by `order`.`order_no`, `cust_name`, `email_address`, `phone_no`, `order_datetime`, `cust_address1`, `cust_address2`, `suburb`, `state`, `postcode`";
$result = $conn->query($sql);
?>

    <!-- Intro Header -->
    <header class="intro">
        <div class="intro-body">

                <div class="row">
                    <div class="col-md-12">
                        <h3>Open Orders</h3>
                        <table class="table">
                        <tr><th>Order No.<th>Customer Name<th>Address<th>Email Address<th>Phone Number<th>Date Ordered</tr>
<?php
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
    	$address = $row['cust_address1']."<br />";
    	if(strlen($row['cust_address2']) > 0) $address .= $row['cust_address2']."<br />";
    	$address .= $row['suburb']." ".$row['state']." ".$row['postcode'];
    	echo "<tr>
    	        <td class='text-left'><a href='detail.php?order=".$row['order_no']."'>Order #".$row['order_no']."</a>
    	        <td class='text-left'>".$row['cust_name']."
    	        <td class='text-left'>".$address."
    	        <td class='text-left'><a href='mailto:".$row['email_address']."'>".$row['email_address']."</a>
    	        <td class='text-left'>".$row['phone_no']."
    	        <td class='text-left'>".date('d/m/Y H:i', strtotime($row['order_datetime']))."
    	      </tr>";
    }
}
?>

                        </table>
                    </div>
                </div>

        </div>
    </header>

    <section id="search" class="container content-section text-center">
        <div class="row">
            <div class="col-xs-12">
		<h3>Customer Search</h3>
		<form>
			<input placeholder="Please enter the customer name you would like to search" type="text" class="form-control" onkeyup="showResult(this.value)">
			<div id="livesearch"></div>
		</form>
            </div>
        </div>
    </section>


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