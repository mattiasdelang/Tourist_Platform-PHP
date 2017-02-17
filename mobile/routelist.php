<?php
session_set_cookie_params(3600*24*30,"/");
session_start();
include_once("classes/route.class.php");

if(!isset($_SESSION['mobile_login']))
{
	
	header("Location:login.php");

}


$r = new Route();
$kid = $r->Showleerlingklas();
$did = $_GET["did"];
$city = $r->Showcity($kid);
$results = $r->Showlist($kid,$did);
$hotel = $r->showhotel($kid);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>project 2 - routelist</title>
	<link rel="stylesheet" type="text/css" href="reset.css">
	<link rel="stylesheet" type="text/css" href="css.css">
	<link rel="stylesheet" type="text/css" href="mediaquery.css">
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript">

	function getposition(){
    navigator.geolocation.getCurrentPosition(onPositionUpdate);
	

	function onPositionUpdate(position) {
    var lat = position.coords.latitude;
    var lon = position.coords.longitude;
	$.ajax(
	    {
	        type: "POST",
	        dataType: "json",
	        url: "session.php",
	        data: 
	        {
	        	sort1:lat,
	        	sort2:lon,
	        	days:<?php echo $did;?>
	           
	        },
	        success: function(data) {
	        for (i = 0; i < data.length; i++) { 
			     $("#coo"+ i).text(data[i][0] +' '+ data[i][1]);
			}
	      }

	    });
	}
	};
	
	function getLocation()
	  {
	  if (navigator.geolocation)
		{
		navigator.geolocation.getCurrentPosition(showPosition);
		}
	  };
	function showPosition(position)
	{
		  $.ajax({
		  url: "https://api.forecast.io/forecast/20a7078d9f9c0dc7e8fe032a436050c2/" + position.coords.latitude + "," + position.coords.longitude,
		  dataType: "jsonp",
		  success: function (data) {
		 document.getElementById("right").innerHTML=Math.round((data.currently.temperature - 32)/1.8) + "&degC";
		 console.log(data);
	}})};

	$(document).ready(function() {
			getposition();
			$("#refresh").click(function(){
				getposition();
			});

			$('.click').click(function (e) {
		        e.stopPropagation();
		        var target = $(this).parent().find('.content');
		        target.slideToggle("slow");
		    });

		});



	

	</script>
</head>
<body onLoad="getLocation()">
	<div id="top">
		<ul>
		<li id="img">
			<a href="index.php"><img src="images/mini_logo.png" alt="logo"></a>
		</li>
		<li class="txt" id="center">
			<?php
			echo $city;
			?>
		</li>
		<li class="txt" id="right">
			
			

		</li>
		</ul>
	</div>
	<div id="content">
		<?php

			$k = 0;
			while($result = $results->fetch_array())
			{
				echo "<div>
					  <div class='click'>
					  <div class='title'>
					  <div class='list'>". $result["lastname"]. " ".$result["firstname"]."</div>
					  <div class='coo' id='coo" .$k."'></div>
					  </div>";
				echo "<div class='mon' id='mon".$k."'>
					  <div class='montitle'>" . $result["name"] ."</div>
					  </div>";

				echo "<div class='content'id='con".$k."'><div class='infobox'>" . $result["content"] ."</div></div>
					  </div></div>";  

				
				?>
				<style type="text/css">
				<?php
				echo "#mon".$k."{background: url(".$result["url"].") no-repeat;}";
				?>
					width:100%;
					background-size: cover;
					background-position: 50% 50%;
				</style>
				<?php
				$k++;
			}
			echo "<div class='title'><div class='list'>Hotel </div> <div class='coo'id='coo" .$k."'></div></div> ";
		?>
	</div>
	<div id="bottom">
		<div id="refresh" class="bot"><img src="images/refresh.png"alt="refresh"></div>
		<a href="changemode.php?id=0&did=<?php echo $did;?>"><div class="bot"<?php if($_SESSION['mobile_login']['mode']=='walking'){echo "id='active'";}?>><img src="images/walk.png"alt="walk"></div></a>
		<a href="changemode.php?id=1&did=<?php echo $did;?>"><div class="bot"<?php if($_SESSION['mobile_login']['mode']=='driving'){echo "id='active'";}?>><img src="images/car.png"alt="drive"></div></a>
		<a href="changemode.php?id=2&did=<?php echo $did;?>"><div class="bot"<?php if($_SESSION['mobile_login']['mode']=='bycycling'){echo "id='active'";}?>><img src="images/cycle.png"alt="bycycling"></div></a>
		<a href="map.php?id=2&did=<?php echo $did;?>"><div class="bot"><img src="images/map.png" alt="map"></div></a>
	</div>	

</body>
<style type="text/css">
	
</style>
</html>