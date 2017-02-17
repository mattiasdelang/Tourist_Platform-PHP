<?php
	session_set_cookie_params(3600*24*30,"/");
	session_start();
	include_once("classes/user.class.php");
	
	if(isset($_SESSION['mobile_login']))
	{
		
		header("Location:index.php");
	
	}
	
	if(!empty($_POST["login"]))
	{
		
		try
		{

			$u = new User();
			$u->setLogin($_POST["login"]);
			$u->setPassword($_POST["password"]);
			$u->Checklogin();

		}
		catch (Exception $e)
		{
		
			$error = $e->getMessage();
		
		}
		
	}


?>
<!doctype html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>project 2 - login</title>
	<link rel="stylesheet" type="text/css" href="css.css">
	<link rel="stylesheet" type="text/css" href="mediaquery.css">
	<style type="text/css">

	.error{
	<?php

		if(isset($error))
		{
		
			echo "border: 2px #e74c3c solid;";
		
		}
	
	?>
	}
	</style>
	
</head>
<body>
<div id="logo">
	<img src="images/logo.png" alt="logo">
</div>

<div id="login">	
	<form action="" method="post">
		<div><input class="error" type="text" name="login" placeholder="achternaam.voornaam" value="Delang.Mattias" required></div>
		<div><input class="error" type="password" name="password" placeholder="wachtwoord" value="delang.mattias"required></div>
		<div><input type="submit" id="knop" name="button" value="aanmelden"></div>
	</form>
</div>

<div id="forgot">
	<p>Wachtwoord vergeten?</p>
</div>

</body>
</html>