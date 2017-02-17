<?php
	session_set_cookie_params(3600*24*30,"/");
	session_start();
	include_once("classes/user.class.php");
	$checkl=false;

	if(isset($_SESSION['project_login']['who']))
	{
			
		$checkl = true;
		
	}

	if(!isset($_SESSION['project_login']))
	{
		
		header("Location:login.php");
	
	}

	if(!empty($_POST["changepw"]))
	{
		try
		{
			$u = new User();
			$u->setPassword($_POST["current"]);
			$u->setNewpw($_POST["newpw"]);
			$u->setConfirmpw($_POST["confirm"]);
			$u->Changepassword();

		} catch (Exception $e)
		{

			$error = $e->getMessage();

		}

	}

	if(!empty($_POST["changemail"]))
	{
		try
		{
			$u = new User();
			$u->setPassword($_POST["currentmail"]);
			$u->setEmail($_POST["newmail"]);
			$u->Changemail();

		} catch (Exception $e)
		{

			$error = $e->getMessage();

		}

	}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>project 2 - settings</title>
	<link rel="stylesheet" type="text/css" href="reset.css">
	<link rel="stylesheet" type="text/css" href="css.css">
	<style type="text/css">

	.input{
	<?php

		if(isset($error))
		{
		
			echo "border: 2px red solid;";
		
		}
	
	?>
	}
	</style>
</head>
<body>
	<div id="wrapper">
	<nav>
			<?php
			if($checkl == true)
			{
				echo "<a href='admin.php'><img src='images/logo_klein.png' alt='logo'></a>";
			}
			else
			{
				echo "<a href='deliver.php?id=".$_SESSION['project_login']['id']."&mid=".$_SESSION['project_login']['mid']."&kid=".$_SESSION['project_login']['kid']."'><img src='images/logo_klein.png' alt='logo'></a>";	
			}


			?>
			<ul>
			  <li class="name"><?php echo $_SESSION["project_login"]["login"];?></li>
			  <li class="knop1"><a href="settings.php">settings</a></li>
			  <li class="knop1"><a href="logout.php">logout</a></li>
			</ul>
	</nav>

	<article>
	<form action="" method="post">
		<input type='password' class="input" name="current" placeholder="Huidig wachtwoord" required/>
		<input type='password' class="input" name="newpw" placeholder="Nieuw wachtwoord" required/>
		<input type='password' class="input" name="confirm" placeholder="Bevestig wachtwoord" required/>

		<input type='submit' class="knop" name="changepw" value='Verander wachtwoord'/>
	</form>

	<form action="" method="post">
		<input type='password' class="input" name="currentmail" placeholder="Huidig wachtwoord" required/>
		<input type='email' class="input" name="newmail" placeholder="email@adres.com" required/>

		<input type='submit' class="knop" name="changemail" value='Verander Emailadres'/>
	</form>
</article>
</body>
</html>