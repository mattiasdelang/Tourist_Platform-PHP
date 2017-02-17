<?php
session_set_cookie_params(3600*24*30,"/");
session_start();
$id = $_GET['id'];
$did = $_GET['did']; 
if($id == 0)
{

	$_SESSION['mobile_login']['mode']= "walking";
	$_SESSION["mobile_login"]["mode1"] = "WALKING";

}
else if($id == 1)
{

	$_SESSION['mobile_login']['mode']= "driving";
	$_SESSION["mobile_login"]["mode1"] = "DRIVING";

}
else if($id == 2)
{

	$_SESSION['mobile_login']['mode']= "bycycling";
	$_SESSION["mobile_login"]["mode1"] = "BYCYCLING";

}

header("location:routelist.php?did=".$did);