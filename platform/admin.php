<?php
	session_set_cookie_params(3600*24*30,"/");
	session_start();
	error_reporting(0);
	include_once("classes/teacher.class.php");


	if(!isset($_SESSION['project_login']["who"]))
	{
		if(!isset($_SESSION['project_login']))
		{
			header("Location:login.php");
		}

		header("Location:deliver.php?id=".$_SESSION['project_login']['id']."&mid=".$_SESSION['project_login']['mid']."&kid=".$_SESSION['project_login']['kid']."");
	
	}
	$checkl = true;

	$a = new Teacher();
	$classes = $a->Showclass();

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>project 2 - admin</title>
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
	<a href="newclass.php"class="link">Nieuwe klas</a>
	<table class="list">
	<tr>
	<th>Leerlingenlijst</th>
	<th>Login</th>
	<th>Bestemming</th>
	<th>Planning</th>
	</tr>
	<?php
		if ($classes->num_rows == 0)
		{
		?>
		    <div>
		        Geen klassen gevonden.
		    </div>
		<?php

		}

		else
		{

		    while ($class = $classes->fetch_array())
		    {
		    	//var_dump($class);

		        ?>
				<tr class="item">
		        <td><a href="class.php?id=<?=$class['id']?>"/><?=$class['1']?></a></td>
		        <td><a href="<?=$class['fileurl']?>">Gegevens</a></td>
		        <td><a href="changedes.php?id=<?=$class['id']?>">Verander</a></td>
		        <td><a href="plantrip.php?kid=<?=$class['id']?>">Verander</a></td>
				</tr>
		       
		    <?php

		    }

		}
	?>

	</table>
</article>
</body>
</html>