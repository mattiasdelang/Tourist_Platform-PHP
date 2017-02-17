<?php
	session_set_cookie_params(3600*24*30,"/");
	session_start();
	include_once("classes/user.class.php");
	$checkl = false;
	if(isset($_SESSION['project_login']))
	{
		if(isset($_SESSION['project_login']['who']))
			{
					
				header("Location:admin.php");	
				
			}
	header("Location:deliver.php?id=".$_SESSION['project_login']['id']."&mid=".$_SESSION['project_login']['mid']."&kid=".$_SESSION['project_login']['kid']);
	}
	
	if(!empty($_POST["login"]))
	{
		
		try
		{

			$u = new User();
			$u->setLogin($_POST["login"]);
			$u->setPassword($_POST["password"]);
			$u->Checklogin();
			$u->Showmonuser();
			if(isset($_SESSION['project_login']['who']))
			{
					
				$checkl = true;
				
			}

			if($checkl == true)
				{
					header("Location:admin.php");
				}
				else
				{
					header("Location:deliver.php?id=".$_SESSION['project_login']['id']."&mid=".$_SESSION['project_login']['mid']."&kid=".$_SESSION['project_login']['kid']);	
				}
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
	
	<title>project 2 - login</title>
	<link rel="stylesheet" type="text/css" href="reset.css">
	<link rel="stylesheet" type="text/css" href="css.css">
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

	<div id="wrapper">
		<div id="logo">
			<img src="images/logo.png" alt="logo">
		</div>
		<div id="login">	
			<form action="" method="post">
				<div><input class="error" type="text" name="login" placeholder="achternaam.voornaam" value="Vermeulen.Jos" required></div>
				<div><input class="error" type="password" name="password" placeholder="wachtwoord" value="vermeulen.jos"required></div>
				<div><input type="submit" id="knop" name="button" value="aanmelden"></div>
			</form>
		</div>
	</div>
		
</body>
</html>