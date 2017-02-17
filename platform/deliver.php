<?php
	session_set_cookie_params(3600*24*30,"/");
	session_start();
	include_once("classes/user.class.php");
	include_once("classes/teacher.class.php");
	$checkl=false;
	$t = new Teacher();

	if(!isset($_SESSION['project_login']["who"]))
	{
		if(isset($_SESSION['project_login']))
		{	
			
			if($_SESSION['project_login']['id'] == $_GET['id'])
			{

			}
			else
			{
				header("Location:deliver.php?id=".$_SESSION['project_login']['id']."&mid=".$_SESSION['project_login']['mid']."&kid=".$_SESSION['project_login']['kid']."");
			}
		}
		else
		{
			header("Location:login.php");
		}

	
	}
	else
	{

		$t->Checkteacher($_GET['kid'],$_SESSION['project_login']['id']);
		$checkl = true;

	}

	$best = $t->Showcity($_GET['kid']);

		

	
	$titles = $t->Showmonument($_GET['id'], $_GET['mid']);
	$works = $t->Showwerk($_GET['id'], $_GET['mid']);

	if(!empty($_POST["indienen1"]))
	{
		$t->Insert1versie($_POST["werkje1"],$_GET['mid'],$_GET['id'],$_GET['kid']);

	}

	if(!empty($_POST["indienen2"]))
	{

		$t->Insert2versie($_POST["werkje2"],$_GET['mid'],$_GET['id'],$_GET['kid']);

	}

	if(!empty($_POST["message"]))
	{

		$t->Insertfeedback($_POST["feedback"],$_GET['mid'],$_GET['id'],$_GET['kid']);

	}

	if(!empty($_POST["score"]))
	{

		$t->Insertpunten($_POST["punten"],$_GET['mid'],$_GET['id'],$_GET['kid']);

	}

	if(!empty($_POST["save"]))
	{

		$infos = $t->Getname($_GET['id']);
		while($info = $infos->fetch_array())
		{

			$lname = $info["lastname"];
			$fname = $info["firstname"];
			$mname = $info["name"];

		}
		$t->Savedocs($_GET['id'],$lname,$fname,$mname);

	}



?>

<!DOCTYPE html>
<html lang="en">
<head>
	
	<title>project 2 - deliver</title>
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
			  <li class="name"><?php echo $best; ?></li>
			  <li class="knop1"><a href="settings.php">settings</a></li>
			  <li class="knop1"><a href="logout.php">logout</a></li>
			</ul>
	</nav>

	<article>

		<?php
		while ($title = $titles->fetch_array())
	    {
	    	//var_dump($result);

	        ?>

			<div id="best"><?=$title['name']?></div>
	        
	    <?php

	    }
		while ($work = $works->fetch_array())
	    {
	    	//var_dump($work);
	    	if(isset($_SESSION['project_login']['who']))
			{
		    	if($work['checkteacher'] == 0)
				{

					echo "<div class='opmerking'>De leerling heeft nog niets ingediend.</div>";

				}
				else
				{

			        ?>
					<?php
			    	if($work['checkteacher'] == 1)
			    	{
			    	?>
			    		<div class="voorb"><?=$work['1']?></div>
						<form action="" method="post">
				    	<textarea name="feedback" placeholder="Plaats je feedback hier." style="height: 300px;  width: 580px;"><?=$work['6']?></textarea>
						<input type="submit" name="message" class="knop" value="Geef feedback">
			    		</form>
			    	<?php
			   		}

			   		if($work['checkteacher'] == 2)
					{
		   			?>
		   			<div class='opmerking'>Wachten op een definitieve versie</div>
		   			<div class="voorb"><?=$work['1']?></div>
					<div class="feed"><?=$work['6']?></div>
					
					<?php
					}

			    	if($work['checkteacher'] == 3)
					{
					?>	
						<div class="voorb"><?=$work['1']?></div>
						<div class="feed"><?=$work['6']?></div>
						<form action="" method="post">
			    		<input class="input" type="text" name="punten" placeholder="<?=$work['7']?>"></br>
			    		<input type="submit" name="score" class="knop" value="Geef score">
			    		</form>
			    	<?php
			    	}
			    	if($work['checkteacher'] == 4)
					{
					?>	
						<div class="voorb"><?=$work['1']?></div>
						<div class="feed"><?=$work['6']?></div>
			    		<div class="punt"><?=$work['7']?></div>
			    		<form action="" method="post">
			    			<input type="submit" name="save" class="knop" value="Voorbereiding opslaan">
			    		</form>
			    	<?php
			    	} 
				}
			}
			else
		    {
		    	if($work['checkteacher'] == 0)
				{
		   			?>
		   			<form action="" method="post">
					<textarea name="werkje1" placeholder="Maak je voorbereiding hier"></textarea>
					<input type="submit" name="indienen1" class="knop" value="1ste versie indienen">
					</form>

					<?php
				}

				if($work['checkteacher'] == 1)
				{
		   			?>
		   			<div class='opmerking'>Wachten op feedback</div>
					<div class="voorb"><?=$work['1']?></div></br>
					
					<?php
				}

				if($work['checkteacher'] == 2)
				{
		   			?>
		   			<form action="" method="post">
					<textarea name="werkje2"><?=$work['1']?></textarea>
					<div class="feed"><?=$work['6']?></div>
					<input type="submit" class="knop" name="indienen2" value="Definitieve versie indienen">
					</form>
					<?php
				}

				if($work['checkteacher'] == 3)
				{
		   			?>
		   			<div class='opmerking'>Wachten op een score</div>
					<div class="voorb"><?=$work['1']?></div>
					<div class="feed"><?=$work['6']?></div>
					
					<?php
				}

				if($work['checkteacher'] == 4)
				{
					if($work['8'] == 1)
			    	{
		   				?>
		   				<div class="voorb"><?=$work['1']?></div>
						<div class="feed"><?=$work['6']?></div>
		    			<div class="punt"><?=$work['7']?></div>
						<?php
		    		}
		    		else
		    		{
		    			?>
		    			<div class='opmerking'>Wachten op een score</div>
		    			<div class="voorb"><?=$work['1']?></div>
						<div class="feed"><?=$work['6']?></div>
		    			<?php
		    		}

				}
				
	    	}  
	    }
		
		?>
	</article>
	</div>
</body>
</html>