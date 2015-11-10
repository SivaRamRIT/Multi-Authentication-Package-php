$(document).ready(function(){

			var attachWebcam = function() {
  			var width = 1280;
  			var height = 720;

			if(screen.width < screen.height) {
			    width = 240;
			    height = 320;
			  }

			 Webcam.set({
			    width: width,
			    height: height,
			    dest_width: width,
			    dest_height: height,
			    crop_width: width,
			    crop_height: height
			  });

			  Webcam.attach('#my_camera');
			};

			window.addEventListener('orientationchange', function() {
			  Webcam.reset();
			  attachWebcam();
			});

			attachWebcam();
		

            var is_upload = false;
			
			$('#upload').change(handleFiles);


			function handleFiles(f) {
                    var img = $('#up_pic');
                    img[0].src = URL.createObjectURL(f.target.files[0]);
                    is_upload = true;
                    decode();

                }

             $('#snap').click(function(){
             	 decode();
             });
			
			$('div#imgDiv').hide();


			
			 function decode() {

			 
			 	if(is_upload == true) {

				var up_img = document.getElementById('up_pic');			
				
				var up_uri = up_img.src;

			    var img = document.getElementById('pic');
				var img2 = document.getElementById('pic2');
				var img3 = document.getElementById('pic3');
				
				img.setAttribute("src",up_uri);
				img2.setAttribute("src",up_uri);
				img3.setAttribute("src",up_uri);
				
				}

				
				else {
					
					Webcam.snap( function(data_uri) {
                
					    var img = document.getElementById('pic');
						var img2 = document.getElementById('pic2');
						var img3 = document.getElementById('pic3');
						
						img.setAttribute("src",data_uri);
						img2.setAttribute("src",data_uri);
						img3.setAttribute("src",data_uri);
					
					});

				}
			        //Apply effects to images through camanJS if default image does not work
			 
					Caman("#pic", function () {
							
							this.render();
														
					});
					
					Caman("#pic2", function () {
													
							this.greyscale();
							this.render();
													
					});
					
					Caman("#pic3", function () {
							
							this.oldBoot();
							this.render();
											
					});
					
					Caman("#pic4", function () {
							
							this.vintage();
							this.render();
													
					});
					
					
                    doScan();
                
             }

			 function doScan() {	
				
				  setTimeout(function() {
				  
					 var canvas = document.getElementById('pic');	
					 					
					 var canvas_context = canvas.getContext('2d'),
                            source,
                            binarizer,
                            bitmap;
					
                    $('.error').empty();
                    $('.decodedText').empty();
					
					
					try {
                        source = new ZXing.BitmapLuminanceSource(canvas_context, canvas);
						console.log(source);
                        binarizer = new ZXing.Common.HybridBinarizer(source);
						console.log(binarizer);
                        bitmap = new ZXing.BinaryBitmap(binarizer);
						console.log(bitmap);
						var decodeObj = ZXing.PDF417.PDF417Reader.decode(bitmap, null, false);
						console.log(decodeObj);
					   
						
							if (decodeObj.length == 0) 
							{
								console.log('object null');
								doScan_2();
								
							}
							else
							{
							    var parsedText = decodeObj[0].Text;
								$('.decodedText').text(parsedText);
                                extract(parsedText);
								var dText = $('.decodedText').text();
								console.log(dText.length);
							}
							} catch (err) {
								console.log(err);
								$('.error').text(err);
							}
					},2000);	
					
				}
				
				function doScan_2() {	
				
				 
				  
					 canvas = document.getElementById('pic2');	
					
					 var canvas_context = canvas.getContext('2d'),
                            source,
                            binarizer,
                            bitmap;
					
                    $('.error').empty();
                    $('.decodedText').empty();
					
					
					try {
                        source = new ZXing.BitmapLuminanceSource(canvas_context, canvas);
						console.log(source);
                        binarizer = new ZXing.Common.HybridBinarizer(source);
						console.log(binarizer);
                        bitmap = new ZXing.BinaryBitmap(binarizer);
						console.log(bitmap);
						var decodeObj = ZXing.PDF417.PDF417Reader.decode(bitmap, null, false);
						console.log(decodeObj);
					   
						
							if (decodeObj.length == 0) 
							{
								console.log('object null');
								doScan_3();
								
							}
							else
							{
							    var parsedText = decodeObj[0].Text;
								$('.decodedText').text(parsedText);
								 extract(parsedText);
								var dText = $('.decodedText').text();
								console.log(dText.length);
							}
							} catch (err) {
								console.log(err);
								$('.error').text(err);
							}
					
					
				}
				
				function doScan_3() {	
				
				 
				  
					 canvas = document.getElementById('pic3');	
					
					 var canvas_context = canvas.getContext('2d'),
                            source,
                            binarizer,
                            bitmap;
					
                    $('.error').empty();
                    $('.decodedText').empty();
					
					
					try {
                        source = new ZXing.BitmapLuminanceSource(canvas_context, canvas);
						console.log(source);
                        binarizer = new ZXing.Common.HybridBinarizer(source);
						console.log(binarizer);
                        bitmap = new ZXing.BinaryBitmap(binarizer);
						console.log(bitmap);
						var decodeObj = ZXing.PDF417.PDF417Reader.decode(bitmap, null, false);
						console.log(decodeObj);
					   
						
							if (decodeObj.length == 0) 
							{
								console.log('object null');
								//doScan_4();
								
							}
							else
							{
							    var parsedText = decodeObj[0].Text;
								$('.decodedText').text(parsedText);
								 extract(parsedText);
								var dText = $('.decodedText').text();
								console.log(dText.length);
							}
							} catch (err) {
								console.log(err);
								$('.error').text(err);
							}
					
					
				}
				
				function doScan_4() {	
				
				 setTimeout(function() {
				  
					 canvas = document.getElementById('pic4');	
					
					 var canvas_context = canvas.getContext('2d'),
                            source,
                            binarizer,
                            bitmap;
					
                    $('.error').empty();
                    $('.decodedText').empty();
					
					
					try {
                        source = new ZXing.BitmapLuminanceSource(canvas_context, canvas);
						console.log(source);
                        binarizer = new ZXing.Common.HybridBinarizer(source);
						console.log(binarizer);
                        bitmap = new ZXing.BinaryBitmap(binarizer);
						console.log(bitmap);
						var decodeObj = ZXing.PDF417.PDF417Reader.decode(bitmap, null, false);
						console.log(decodeObj);
					   
						
							if (decodeObj.length == 0) 
							{
								console.log('object null');
								
								
							}
							else
							{
							    var parsedText = decodeObj[0].Text;
								$('.decodedText').text(parsedText);
								 extract(parsedText);
								var dText = $('.decodedText').text();
								console.log(dText.length);
							}
							} catch (err) {
								console.log(err);
								$('.error').text(err);
							}
					},500);
					
				}



			  function extract(parsedText) {

			  					
								var fName = parsedText.substring(parsedText.search("\nDCT"));
								
								var firstName = fName.substring(4,fName.indexOf(" "));
								
								var lName = parsedText.substring(parsedText.search("\nDCS"));
								
								var lastName = lName.substring(4,lName.indexOf(" "));
								
								var dob = parsedText.substring(parsedText.search("\nDBB"));
								
								var final_dob = dob.substring(4,dob.indexOf("DBC1"));

								
								$( "#fName" ).val(firstName);
							
								$( "#lName" ).val(lastName);
								
								$('#dob').val(final_dob);
							}
					
		});
