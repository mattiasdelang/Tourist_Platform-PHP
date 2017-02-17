<?php
session_set_cookie_params(3600*24*30,"/");
session_start();
ob_start();
include_once("classes/class.class.php");

if(!isset($_SESSION['project_login']["who"]))
{
	if(!isset($_SESSION['project_login']))
	{
		header("Location:login.php");
	}

	header("Location:deliver.php?id=".$_SESSION['project_login']['id']."&mid=".$_SESSION['project_login']['mid']."&kid=".$_SESSION['project_login']['kid']."");
	
}
	$checkl = true;

	$c = new klas();
	$cities = $c->Showcity();


	if(!empty($_POST["makeclass"]))
	{
		$cityid=$_POST["city"];
		$name = $_POST["nameclass"];
		$addressh = $_POST["address"];
		$tsid = $c->Showteacherschool();
		$days = $_POST["dagen"];

		$kid = $c->Createclass($name,$tsid,$cityid,$days,$addressh);

		
		$acc =split("\r\n", $_POST["newacc"]); 
		$c->Makeaccs($acc,$kid,$tsid);
		header("Location:newclassf2.php?id=" . $kid);
		
		
	}



?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>project 2 - nieuwe klas</title>
	<link rel="stylesheet" type="text/css" href="reset.css">
	<link rel="stylesheet" type="text/css" href="css.css">
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
			  <li class="name"><?php echo $_SESSION['project_login']['login'] ?></li>
			  <li class="knop1"><a href="settings.php">settings</a></li>
			  <li class="knop1"><a href="logout.php">logout</a></li>
			</ul>
	</nav>
	<article>
	<form action="" method="post">
	
	<input type="text" name="nameclass" class="input" placeholder="naam richting + schooljaar" required>
	<select name="city" class="input">
	<?php
	

	    while ($city = $cities->fetch_array())
	    {
	    	//var_dump($result);

	        ?>

	        <option value="<?=$city['id']?>"><?=$city['name']?></option>
	    <?php

	    }

	
	?>
		
	</select>
	<input type="number" name="dagen" class="input" placeholder="Aantal bezoekdagen" required>
	<input type="text" name="address" class="input" placeholder="adres verblijfplaats" required>
	<textarea name="newacc" style="width: 400px;" placeholder="Maak hier de leerling accounts                                            Naam Voornaam                                                     Naam Voornaam" required></textarea>
	<input type="submit" value="Maak klas" class="link" name="makeclass"/>

	</form>
	</article>
	</div>
</body>
</html>