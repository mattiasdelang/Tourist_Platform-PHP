<?php
session_set_cookie_params(3600*24*30,"/");
session_start();
$check = false;
$checkl = false;
if(isset($_SESSION['project_login']))
{
		
	$check = true;
	
}

if(isset($_SESSION['project_login']['who']))
{
		
	$checkl = true;
	
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>School travel guide</title>
	<link rel="stylesheet" type="text/css" href="reset.css">
	<link rel="stylesheet" type="text/css" href="css.css">
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/slide.js"></script>
	<script type="text/javascript">


		if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
			window.location = "http://www.mattiasdelang.be/project/mobile";
		}



		$( document ).ready(function() {
			setInterval(function () {
		    var height = window.innerHeight;
		    $( header ).height( height );
		    $( "#kader" ).css('top',height*0.5);
		},50);
		});

	</script>
</head>
<body>
	<nav>
		<div class="mid">
			<img src="images/logo.png" alt="logo">
			<ul>
			  <li><a href="#header">home</a></li>
			  <li><a href="#about">about</a></li>
			  <li><a href="#contact">contact</a></li>
			  <li><a href="#">download</a></li>
			</ul>
			<?php
			if($check == true)
			{
				if($checkl == true)
				{
					echo "<a href='platform/admin.php' id='login'>" . $_SESSION['project_login']['login'] . "</a>";
				}
				else
				{
					echo "<a href='platform/deliver.php?id=".$_SESSION['project_login']['id']."&mid=".$_SESSION['project_login']['mid']."&kid=".$_SESSION['project_login']['kid']."' id='login'>" . $_SESSION['project_login']['login'] . "</a>";	
				}
			}
			else
			{

				echo "<a href='platform/login.php' id='login'>login</a>";

			}

			?>
		</div>
	</nav>

	<header>
		<div id="header" class="mid">
			<div id="kader">
				<div id="info">
					<p>create your own school travel guide right here</p>
				</div>
				<a href="platform/login.php">
					<div id="knop">
						<p>make guide</p>
					</div>
				</a>
			</div>
		</div>
	</header>
	
	<div id="content1">
		<div id="about" class="mid">
			<ul>
				<li class="image">
					<img src="images/login.png" alt="loginscherm"/>
				</li>	
				<li class="gwn">
					<p>
						School travel guide biedt middelbare scholen een oplossing aan om het plannen en organiseren van uitstappen naar toeristische steden te vergemakkelijken.
						Aan de hand van een online platform kunnen leerkrachten trips organiseren en kunnen hun voorbereiding inleveren.
					</p>
				</li>	
				<li class="gwn">
					<p>
						Deze voorbereidingen worden in 2 fases verbeterd door de leerkracht en worden dan gepubliseerd naar de rest van de klas. Via een <a href="mobile/login.php">mobiele website</a> kunnen de leerlingen
						hun voorbereiding raadplegen tijdens de reis, samen met andere reisinformatie zoals weer, afstand, tijd. Ook wordt de route aangegeven op een map, samen met je huidige locatie, zo kan de leerling zich makelijk oriënteren.
					</p>
				</li>	
				<li class="image">
					<img src="images/list.png" alt="loginscherm"/>
				</li>
			</ul>
			

		</div>
	</div>

	<div id="content2">
		<div class="mid">
			<div id="contact">
			<p>Heb je interesse in ons product?</br> Gelieve dit even in te vullen.</p>
				<form action="" method="post">
					<div class="input">
						<label for="name">Je naam</label>
						<input type="text" name="name" placeholder="Naam" required>
					</div>
					<div class="input">
						<label for="mail">Je emailadres</label>
						<input type="text" name="mail" placeholder="Emailadres" required>
					</div>
					<div class="input">
						<label for="content">Je bericht</label>
						<textarea name="content" placeholder="Plaats je bericht en info hier" required></textarea>
					</div>
					<div class="input">
						<input id="send" type="submit" name="send" value="Verzend">
					</div>
				</form>
			</div>
		</div>
	</div>



	<footer>
		<div id="footer" class="mid">
			<p>made by <a href="http://www.mattiasdelang.be">mattiasdelang.be</a></p>
		</div>
	</footer>

</body>
</html>