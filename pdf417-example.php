<!DOCTYPE html>
<html>
<head>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Pdf417 Login</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

</head>

<body>

 <div class="container">
             <h3>Drivers License Login</h3>
			 <div id="my_camera" style='margin-left:auto;margin-right:auto;'></div>
			 
			 <button type="button" id='snap' class="btn btn-success">Snap</button>
            </br>
                 <input type="file"/ id='upload' class="btn btn-success">
                
            </br>
			</br>
                <div class="error"></div>
                <div><pre class="decodedText"></pre>
			  
            <div class="form-container">
			
			<form class="form-horizontal" role="form">
			
				<div class="form-group">
					<label class="control-label col-sm-2" for="fName">First Name:</label>
					<div class="col-xs-2">
						<input type="fName" class="form-control" id="fName" placeholder="" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="lName">Last Name:</label>
					<div class="col-xs-2">
						<input type="lName" class="form-control" id="lName" placeholder="" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2" for="dob">Date of Birth:</label>
					<div class="col-xs-2">
						<input type="dob" class="form-control" id="dob" placeholder="" readonly>
					</div>
				</div>
				  <div class="form-group">
					<label class="control-label col-sm-2" for="pwd">Password:</label>
					<div class="col-xs-2"> 
					  <input type="password" class="form-control" id="pwd" placeholder="">
					</div>
				  </div>
				  
				  <div class="form-group"> 
					<div class="col-sm-offset-2 col-sm-10">
					  <button type="submit" class="btn btn-default">Submit</button>
					</div>
				  </div>
			
			</div>
			
			 <div id='imgDiv'>
                             <img id = "pic" src=""/>
                             <img id = "pic2" src=""/>
                             <img id = "pic3" src=""/>
                             <img id = "pic4" src=""/>
             </div>

             <img id='up_pic' src=""/>
</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/pdf417/2dbarcode.js"></script>
    <script src="js/pdf417/BigInteger.min.js"></script>
	<script src="js/pdf417/zxing-pdf417.js"></script>
	<script src="js/webcamJS/webcam.js"></script>
	<script src="js/camanJS/caman.full.min.js"></script>
</body>

</html>
