<?php
require 'src/openid.php';
?>
<!DOCTYPE html>
<html>
<head>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<title>Title of the document</title>
<!--<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">-->
<!--<link rel="stylesheet" type="text/css" href="css/font-awesome.css">-->
<link rel="stylesheet" type="text/css" href="css/bootstrap-social.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">

</head>

<body>

 <div class="container">
            <h3>OpenID Login</h3>
            <div class="form-container">

<?php

//open ID yahoo example

 $opID = new LightOpenID('http://localhost/authpackage'); # CHANGE ME
 
		if(! $opID->mode )
	        {
	            $opID->identity = 'me.yahoo.com';
	            //$opID->identity = 'myspace.com/ezio_ram';
	            //$opID->identity = 'login.ubuntu.com';
	            //$opID->identity = 'steamcommunity.com/openid/';
	          
	            $opID->required = array('contact/email', 'namePerson');
	          
			    echo '
						<form class="form-horizontal" role="form">
                      
					  <div class="form-group"> 
						
						<div class="col-sm-offset-2">		
								<p class="navbar-btn">
									<a href="'.$opID->authURL().'" class="btn btn-info btn-lg btn-round btn-block text-center">Sign in with Yahoo</a>
								 </p>
						 </div>
					  </div>
				</form>';
		    }
		elseif($opID->mode == 'cancel')
	        {
	            echo "User has cancelled the authentication";
	        }
	    else
	        { 
		       
	            # validation here
	            if($opID->validate())
	            {
	                //echo $opID->identity;
					$user_attr = $opID->getAttributes();  //get user details

					$email = $user_attr['contact/email'];
					$name  = $user_attr['namePerson'];
					
					$pieces = explode("/", $_GET['openid_identity']);  //get unique user identity 
                    $openid_identity = end($pieces);
										
				   
					//use the user credentials for authentication

	            }
	            else
	            {
	                echo 'Not logged';
	            }
	        }
 
?>			

</div>
</div>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>

</html>
