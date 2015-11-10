<!DOCTYPE html>
<html>
<head>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Pdf417 Login</title>
<link rel="stylesheet" type="text/css" href="css/bootstrap-social.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/code39-style.css">

</head>

<body>

 <div class="container">
  <h3>Code 39 Login</h3>
	   <div id="my_camera" style='margin-left:auto;margin-right:auto;'></div>
			 
		<section id="container" class="container">
		
			<div class="controls" >
				<fieldset class="input-group">
					<input id='test' type="file" capture/>
				</fieldset>
				
			</div>
		 
			<div id="interactive" class="viewport"></div>
			<div id="debug" class="detection"></div>
		</section>
			  
         <div class="form-container">
			
			<form class="form-horizontal" role="form">
			
				<div class="form-group">
					<label class="control-label col-sm-2" for="stid">Parsed barcode:</label>
					<div class="col-xs-2">
						<input type="stid" class="form-control" id="stid" placeholder="" readonly>
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
			
</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<script src="js/quaggaJS/quagga.min.js"></script>
    <script src="js/quaggaJS/live_w_locator.js"></script>
	<script src="js/quaggaJS/scale.fix.js"></script>
	<script src="js/quaggaJS/file_input.js"></script>
	
</body>

</html>
