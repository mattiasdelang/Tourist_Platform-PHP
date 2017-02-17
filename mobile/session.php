<?php
session_set_cookie_params(3600*24*30,"/");
session_start();
include_once("classes/route.class.php");

$r = new Route();
$kid = $r->Showleerlingklas();
$did = $_POST["days"];
$results = $r->Showlist($kid,$did);
$hotel = $r->showhotel($kid);

if (!($_POST)) { echo 'error'; }
    
else {
$longitude = $_POST["sort1"];
$latitude = $_POST["sort2"];
$mode = $_SESSION["mobile_login"]["mode"];
$a = array();
$i = 0;
while($result = $results->fetch_array())
{
    
    $eind = str_replace(' ', '', $result["address"]);
	$url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$longitude.",".$latitude."&destinations=".$eind."&mode=".$mode."&language=nl-BE&key=AIzaSyCqUWQzBgFs0OcN3H9d3d0uBIZ4ieaDwJA";
	$json = file_get_contents($url);
	$data = json_decode($json, true);
	
	$a[$i][0] = $data["rows"][0]["elements"][0]["distance"]["text"];
	$a[$i][1] = $data["rows"][0]["elements"][0]["duration"]["text"];


	$i++;
}

$ehotel = str_replace(' ', '', $hotel);
$url = "https://maps.googleapis.com/maps/api/distancematrix/json?origins=".$longitude.",".$latitude."&destinations=".$ehotel."&mode=".$mode."&language=nl-BE&key=AIzaSyCqUWQzBgFs0OcN3H9d3d0uBIZ4ieaDwJA";
$json = file_get_contents($url);
$data = json_decode($json, true);
	
$a[$i][0] = $data["rows"][0]["elements"][0]["distance"]["text"];
$a[$i][1] = $data["rows"][0]["elements"][0]["duration"]["text"];

echo json_encode($a);
}
    
?>