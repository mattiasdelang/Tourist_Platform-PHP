<?php
session_set_cookie_params(3600*24*30,"/");
session_start();
include_once("classes/route.class.php");

if(!isset($_SESSION['mobile_login']))
{
	
	header("Location:login.php");

}

$u = new Route();
$kid = $u->ShowLeerlingklas();
$dagen = $u->Showclassinfo($kid);
$city = $u->Showcity($kid);

?>


<!DOCTYPE html>
<html lang="en">
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>project 2 - index</title>

	<link rel="stylesheet" type="text/css" href="css.css">
	<link rel="stylesheet" type="text/css" href="mediaquery.css">
	
</head>
<body>
	<div id="logo">
		<img src="images/logo.png" alt="logo">
	</div>
	<div id="login">
		<div id="info">
			<p>
				<?php echo $city;?>
			</p>
		</div>
		<?php

		for($i = 0;$i < $dagen;$i++)
		{

			?>
			
				<a href="routelist.php?did=<?php echo $i;?>">
					<div class="days">
						dag <?php echo $i+1;?>
					</div>
				</a>	

			<?php

		}


		?>
		<a  href="logout.php">
			<div id="logout">
				logout
			</div>
		</a>
	</div>
</body>
</html>