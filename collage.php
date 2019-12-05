<?php
    date_default_timezone_set('Australia/Melbourne');
function get_timezone_offset($remote_tz, $origin_tz = null) {
    if($origin_tz === null) {
        if(!is_string($origin_tz = date_default_timezone_get())) {
            return false; // A UTC timestamp was returned -- bail out!
        }
    }
    $origin_dtz = new DateTimeZone($origin_tz);
    $remote_dtz = new DateTimeZone($remote_tz);
    $origin_dt = new DateTime("now", $origin_dtz);
    $remote_dt = new DateTime("now", $remote_dtz);
    $offset = $origin_dtz->getOffset($origin_dt) - $remote_dtz->getOffset($remote_dt);
    return $offset;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Jigsaw Puzzles Australia</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <link href='https://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>

    <!-- Plugin CSS -->
    <link href="vendor/magnific-popup/magnific-popup.css" rel="stylesheet">
    <link rel="stylesheet" href="css/animate.min.css" type="text/css">

    <!-- Theme CSS -->
    <link href="css/creative.css" rel="stylesheet">
    <link href="css/full-slider.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script>
         var images = [];
         
         function _(elementID) {
            return document.getElementById(elementID);
         }
         
         function getFirstWord(str) {
            if (str.indexOf(' ') === -1)
               return str;
            else
               return str.substr(0, str.indexOf(' '));
         };
         
         function uploadFile() {
            var file = _("image1").files[0];
            if(_("image1").value === null || _("image1").value === "") {
            	alert('Please upload your image.');
            } else {
            	var formdata = new FormData();
	        formdata.append("image1", file);
	        var ajax = new XMLHttpRequest();
	        ajax.upload.addEventListener("progress", myProgressHandler, false);
	        ajax.addEventListener("load", myCompleteHandler, false);
	        ajax.addEventListener("error", myErrorHandler, false);
	        ajax.addEventListener("abort", myAbortHandler, false);
	        ajax.open("POST", "file_upload_parser.php"); ajax.send(formdata);
           }
         }
         
         function myProgressHandler(event) {
            var percent = (event.loaded / event.total) * 100;
            _("progressBar").value = Math.round(percent);
            _("status").innerHTML = Math.round(percent)+"% uploaded... please wait";
         }
	 function myCompleteHandler(event) {
            _("status").innerHTML = "";
            _("progressBar").value = 0;
	    var table = document.getElementById("cart");
	    var row = table.insertRow(-1);
	    var cell1 = row.insertCell(0);

	    if(event.target.responseText.indexOf('upload is complete') >= 0){
	    	var img = document.createElement("IMG");
	    	var imgloc = getFirstWord(event.target.responseText);
    		img.setAttribute("src", imgloc);
    		img.onload = function(){
  			var image = {
  			   img_file: imgloc,
  			   img_height: img.height,
  			   img_width: img.width,
  			   puz_type: "Collage"
  			}
  			images.push(image);
  			_("cart_images").value = JSON.stringify(images);
		}
	    	cell1.innerHTML = "<img src='"+img.src+"' style='width:400px' class='img-responsive'>";
	    	
	    }
         }
	 function myErrorHandler(event) {
            _("status").innerHTML = "Upload Failed";
         }
	 function myAbortHandler(event) {
            _("status").innerHTML = "Upload Aborted";
         }
    </script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
</head>

<body id="page-top" class="bg-dark">

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top bg-blend">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand page-scroll" href="#page-top">Jigsaw Puzzles Australia</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a class="page-scroll" href="index.php#about">About</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="index.php#services">Our Puzzles</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="index.php#sizing">Handy Sizing Chart</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="index.php#order">Order Now!</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="index.php#specials">Special Jigsaws</a>
                    </li>
                    <li>
                        <a class="page-scroll" href="index.php#contact">Contact</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>


    <aside id="order" style="padding-top:75px">
        <div class="container">
            <div class="call-to-action">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2 class="section-heading">Personalised Collage Jigsaw Order Form</h2>
                    <hr class="primary">
                    <p class="lead">Use this form to upload as many photos as you would like in your collage. We will assess the quality of the photos (resolution, blurriness, etc) and provide you with a costing and a proof prior to manufacturing your puzzle.</p>
                    <hr class="primary">
                </div>
            </div>

    <table class="table" id="cart"></table>
    <form id="image_upload_form" enctype="multipart/form-data" role="form" method="post">
    <div class="controls">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="form_name">Image for upload</label>
                    <input type="file" name="file1" id="image1">
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <input class="btn btn-primary btn-xl" type="button" value="Add to collage" onclick="uploadFile()">
                </div>
            </div>
        </div>         	 
        <progress id="progressBar" value="0" max="100" style="width:300px;"></progress>
        <h3 id="status"></h3>
      </form>
<a onclick="document.getElementById('customer').style.display = 'block';" class="btn btn-primary btn-xl">Checkout</a>
<div id="customer" style="display:none">
<form id="contact-form" method="post" action="collageprocess.php" role="form">

    <div class="messages"></div>

    <div class="controls">
        <div class="row">
            <div class="col-md-12">
                <h3>Full name</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="form_name">Firstname *</label>
                    <input id="form_name" type="text" name="name" class="form-control" placeholder="Please enter your firstname *" required="required" data-error="Firstname is required.">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="form_lastname">Lastname *</label>
                    <input id="form_lastname" type="text" name="surname" class="form-control" placeholder="Please enter your lastname *" required="required" data-error="Lastname is required.">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>Delivery Address</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="form_addr1">Address Line 1 *</label>
                    <input id="form_addr1" type="text" name="addr1" class="form-control" placeholder="Please enter your address line 1 *" required="required" data-error="Valid address line 1 is required.">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label for="form_addr2">Address Line 2</label>
                    <input id="form_addr2" type="text" name="addr2" class="form-control" placeholder="Please enter your address line 2">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="form_city">City *</label>
                    <input id="form_city" type="text" name="city" class="form-control" placeholder="Please enter your city *" required="required" data-error="City is required.">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="form_state">State *</label>
                    <select class="form-control" id="form_state" name="state" required="required" data-error="State is required.">
			   <option value="" disabled="disabled"></option>
			   <option>ACT</option>
			   <option>NSW</option>
			   <option>NT</option>
			   <option>QLD</option>
			   <option>SA</option>
			   <option>TAS</option>
			   <option>VIC</option>
			   <option>WA</option>
		    </select>
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="form_postcode">Postcode *</label>
                    <input id="form_postcode" type="text" name="postcode" class="form-control" placeholder="Please enter your postcode *" required="required" data-error="Valid postcode is required.">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h3>Contact Details</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="form_email">Email *</label>
                    <input id="form_email" type="email" name="email" class="form-control" placeholder="Please enter your email *" required="required" data-error="Valid email address is required.">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="form_phone">Phone *</label>
                    <input id="form_phone" type="tel" name="phone" class="form-control" placeholder="Please enter your phone *" required="required" data-error="Valid phone number is required.">
                    <div class="help-block with-errors"></div>
                </div>
            </div>
        </div>
        <input type="hidden" name="cart_images" id="cart_images" value="0">

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="jigsaw_type">Jigsaw Type *</label>
         	    <select class="form-control" name="jigsaw_type">
			     <option value="" disabled="disabled"></option>
			     <option>30 pieces - $24.50 (inc GST)</option>
			     <option>36 pieces - $29.50 (inc GST)</option>
			     <option>60 pieces - $31.50 (inc GST)</option>
			     <option>120 pieces - $24.50 (inc GST)</option>
			     <option>252 pieces - $31.50 (inc GST)</option>
			     <option>500 pieces - $39.50 (inc GST)</option>
			     <option>1000 pieces - $59.50 (inc GST)</option>
			     <option>Australia - $39.50 (inc GST)</option>
			     <option>Love Heart - $29.50 (inc GST)</option>
	 	    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <input type="submit" class="btn btn-primary btn-xl" value="Order Now!">
        </div>
    </div>

</form>

            </div>
        </div>
    </aside>
        
    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Plugin JavaScript -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
    <script src="vendor/scrollreveal/scrollreveal.min.js"></script>
    <script src="vendor/magnific-popup/jquery.magnific-popup.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/1000hz-bootstrap-validator/0.11.9/validator.min.js"></script>
    <!-- Theme JavaScript -->
    <script src="js/creative.min.js"></script>
    <script>
function recaptcha_check() {

   var recaptcha = $("#g-recaptcha-response").val();
   if (recaptcha === "") {
      event.preventDefault();
      alert("Please check the recaptcha");
   }
}    
    </script>
    <script src="js/jqBootstrapValidation.js"></script>
    <script src="js/contact_me.js"></script>
<script src="js/wow.min.js"></script>

    <!-- Custom Theme JavaScript -->
    
    <script>
    $('.carousel').carousel({
        interval: 5000 //changes the speed
    })
    </script>

</body>

</html>