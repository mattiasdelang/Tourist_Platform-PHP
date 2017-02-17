<?php
session_set_cookie_params(3600*24*30,"/");
session_start();
include_once("classes/route.class.php");

if(!isset($_SESSION['mobile_login']))
{
	
	header("Location:login.php");

}
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<title>Capture image with Html5</title>
<style type="text/css">
@import url(http://fonts.googleapis.com/css?family=Raleway:500);

#upload{
	position:fixed;

}

#snap{

position:fixed;

}


#new{
position:fixed;

}

#canvas,#video{

	background-color:#34B296;
	margin-left:auto;
	margin-right:auto;

}
</style>
<script type="text/javascript">

		$( document ).ready(function() {
			
			$(window).on('resize load', function() {
			var height = $(window).height();
			var width = $(window).width();
			if(width > height)
			{

				$("#snap").css({

					"bottom":"38%",
					"right":"-8%"
					

				});
				$("#new").css({

					"top":"5%",
					"right":"-4%",
					"left":"",
					"bottom":""
					
				});
				$("#upload").css({

					"bottom":"5%",
					"right":"-4%",
					"left":"",
					"top":""

				});
				
				$(".img").css({

					"width":"50%",
					"height":"50%%"

				});
				
				

			}
			else
			{
					
				$("#snap").css({

					"bottom":"2%",
					"right":"38%"

				});
				$("#new").css({

					"bottom":"2%",
					"left":"2%",
					"top":"",
					"right":""

				});
				$("#upload").css({

					"bottom":"2%",
					"right":"2%",
					"top":"",
					"left":""

				});
				$(".img").css({

					"width":"80%",
					"height":"80%%"

				});
				
			}
		    $("#canvas").height( height );
		    $("#canvas").width( width );
		    $("#video").height( height );
		    $("#video").width( width );
		});
		});

</script>

</head>

<body>

    <video id="video" autoplay></video>
	<div id="snap"><img class="img" src="images/cam.png" alt="knop"/></div>
	<canvas id="canvas" style="display:none;" ></canvas>
    <div id="upload" style="display:none;"><img class="img" src="images/upload.png" alt="knop"/></div>
    <div id="new" style="display:none;"><img class="img" src="images/new.png" alt="knop"/></div>
<script>
		// Put event listeners into place
		window.addEventListener("DOMContentLoaded", function() {
			// Grab elements, create settings, etc.
			var canvas = document.getElementById("canvas"),
				context = canvas.getContext("2d"),
				video = document.getElementById("video"),
				videoObj = { "video": true },
				errBack = function(error) {
					console.log("Video capture error: ", error.code); 
				};

			// Put video listeners into place
			if(navigator.getUserMedia) { // Standard
				navigator.getUserMedia(videoObj, function(stream) {
					video.src = stream;
					video.play();
				}, errBack);
			} else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
				navigator.webkitGetUserMedia(videoObj, function(stream){
					video.src = window.URL.createObjectURL(stream);
					video.play();
				}, errBack);
			} else if(navigator.mozGetUserMedia) { // WebKit-prefixed
				navigator.mozGetUserMedia(videoObj, function(stream){
					video.src = window.URL.createObjectURL(stream);
					video.play();
				}, errBack);
			}

			// Trigger photo take
			document.getElementById("snap").addEventListener("click", function() {
				var canvas = document.getElementById('canvas');
				canvas.width = window.innerWidth; 
				canvas.height = window.innerHeight; 
				context.drawImage(video, 0, 0,canvas.width,canvas.height);
				// Littel effects
				$('#video').fadeOut('fast');
				$('#canvas').fadeIn('fast');
				$('#snap').hide();
				$('#new').show();
				// Allso show upload button
				$('#upload').show();
			});
			
			// Capture New Photo
			document.getElementById("new").addEventListener("click", function() {
				$('#video').fadeIn('fast');
				$('#canvas').fadeOut('fast');
				$('#snap').show();
				$('#new').hide();
				$('#upload').hide();
			});
			// Upload image to sever 
			document.getElementById("upload").addEventListener("click", function(){
				var dataUrl = canvas.toDataURL();
				$.ajax({
				  type: "POST",
				  url: "camsave.php",
				  data: { 
					 imgBase64: dataUrl
				  }
				}).done(function(msg) {
				$('#video').fadeIn('fast');
				$('#canvas').fadeOut('fast');
				$('#snap').show();
				$('#upload').hide();
				$('#new').hide();
				});
			});
		}, false);

	</script>
</body>
</html>
