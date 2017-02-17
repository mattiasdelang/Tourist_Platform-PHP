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
$did = $_GET['did'];
$city = $r->Showcity($kid);
$lijst = $r->Giveaddress($kid,$did);
$hotel = $r->showhotel($kid);
$ehotel = str_replace(' ', '', $hotel);
$aantal = count($lijst);

?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Waypoints in directions</title>
    <link rel="stylesheet" type="text/css" href="reset.css">
  <link rel="stylesheet" type="text/css" href="css.css">
  <link rel="stylesheet" type="text/css" href="mediaquery.css">
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
      #alles{
        display:none;

      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script>
          var directionsDisplay;
          var directionsService = new google.maps.DirectionsService();
          var map;

          function initialize() {
            directionsDisplay = new google.maps.DirectionsRenderer();
            //var current = new google.maps.LatLng(<?php echo $lijst[0][1]; ?>);
            navigator.geolocation.getCurrentPosition(function(position) {
            initialLocation = new google.maps.LatLng(position.coords.latitude,position.coords.longitude);
            var mapOptions = {
              zoom: 6,
              center: initialLocation,
			   disableDefaultUI: false
			   
            }
            map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
            var marker = new google.maps.Marker({
                position: initialLocation,
                map: map,
            });
            directionsDisplay.setMap(map);
          })
          }

          function calcRoute() {
            var start = document.getElementById('start').innerHTML;
            var end = document.getElementById('end').innerHTML;
            var waypts = [];
            var checkboxArray = document.getElementById('waypoints');
            for (var i = 0; i < checkboxArray.length; i++) {
              if (checkboxArray.options[i].selected == true) {
                waypts.push({
                    location:checkboxArray[i].value,
                    stopover:true});
              }
            }

            var request = {
                origin: start,
                destination: end,
                waypoints: waypts,
                optimizeWaypoints: true,
                travelMode: google.maps.TravelMode.<?php echo $_SESSION['mobile_login']['mode1'];?>
            };
            directionsService.route(request, function(response, status) {
              if (status == google.maps.DirectionsStatus.OK) {
                directionsDisplay.setDirections(response);
              }
            });
          }
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

          google.maps.event.addDomListener(window, 'load', initialize);

    </script>
  </head>
  <body onload="calcRoute(); getLocation(); ">
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

    <div id="map-canvas" style="width:100%;height:100%;"></div>
    <div id="alles">
    <div id="start"><?php echo $lijst[0][1];?></div>
    <select multiple id="waypoints">
        <?php

        for($i=1;$i<$aantal;$i++)
        {
        echo "<option value='".$lijst[$i][1]."' selected></option>";
        }
        ?>
    </select>
    <div id="end"><?php echo $ehotel;?></div>
  </div>
  <div id="bottom">
    <div id="refresh" class="bot"><img src="images/refresh.png"alt="refresh"></div>
    <a href="changemode1.php?id=0&did=<?php echo $did;?>"><div class="bot"<?php if($_SESSION['mobile_login']['mode']=='walking'){echo "id='active'";}?>><img src="images/walk.png"alt="walk"></div></a>
    <a href="changemode1.php?id=1&did=<?php echo $did;?>"><div class="bot"<?php if($_SESSION['mobile_login']['mode']=='driving'){echo "id='active'";}?>><img src="images/car.png"alt="drive"></div></a>
    <a href="changemode1.php?id=2&did=<?php echo $did;?>"><div class="bot"<?php if($_SESSION['mobile_login']['mode']=='bycycling'){echo "id='active'";}?>><img src="images/cycle.png"alt="bycycling"></div></a>
    <a href="routelist.php?id=2&did=<?php echo $did;?>"><div class="bot"><img src="images/list.png"alt="list"></div></a>
  </div>   
  </body>
</html>