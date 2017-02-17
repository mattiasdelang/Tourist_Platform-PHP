<?php
	
	session_set_cookie_params(3600*24*30,"/");
	session_start();
	include_once("classes/teacher.class.php");
	
	$t = new Teacher();
	if(!isset($_SESSION['project_login']["who"]))
	{
		if(!isset($_SESSION['project_login']))
		{
			header("Location:login.php");
		}

		header("Location:deliver.php?id=".$_SESSION['project_login']['id']."&mid=".$_SESSION['project_login']['mid']."&kid=".$_SESSION['project_login']['kid']."");
	
	}
	else
	{

		$t->Checkteacher($_GET['id'],$_SESSION['project_login']['id']);

	}

	$checkl = true;


	$showid = $t->Checkscore($_GET['id']);

	if(!empty($_POST["show"]))
	{
		$t->Showscore($_GET['id']);
	}

		if(!empty($_POST["shown"]))
	{
		$t->Hidescore($_GET['id']);
	}

	$students = $t->Showstudents($_GET['id']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>project 2 - klaslijst</title>
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
	<?php
	if($showid == 0)
	{
		?>
			<input type="submit" class="link" value="Toon punten" name="show">
		<?php
	}
	else
	{
		?>
			<input type="submit" class="link" value="Verberg punten" name="shown">
		<?php
	}
	?>
	</form>
	<table class="list">
		<tr>
		<th>Leerling</th>
		<th>Monument</th>
		<th>score</th>
		</tr>
	<?php
		if ($students->num_rows == 0)
		{
		?>
		    <div class="opmerking">
		        Geen leerlingen gevonden.
		    </div>
		<?php

		}

		else
		{

		    while ($student = $students->fetch_array())
		    {
		    	//var_dump($student);

		        ?>

		        
		        <tr class="item">
		        <?php
					if($student['checkteacher'] == 0)
					{
				?>
						<td class="nul"><a href="deliver.php?id=<?=$student['0']?>&mid=<?=$student['5']?>&kid=<?=$_GET['id']?>"/><?=$student['firstname']?> <?=$student['lastname']?></a></td>
		           		<td class="nul"><?=$student['name']?></td>
		           		<td class="nul"><?=$student['score']?></td>
				<?php
					}
					else if($student['checkteacher'] == 1)
					{
				?>
						<td class="een"><a href="deliver.php?id=<?=$student['0']?>&mid=<?=$student['5']?>&kid=<?=$_GET['id']?>"/><?=$student['firstname']?> <?=$student['lastname']?></a></td>
		           		<td class="een"><?=$student['name']?></td>
		           		<td class="een"><?=$student['score']?></td>
				<?php
					}
					else if($student['checkteacher'] == 2)
					{
				?>
						<td class="een"><a href="deliver.php?id=<?=$student['0']?>&mid=<?=$student['5']?>&kid=<?=$_GET['id']?>"/><?=$student['firstname']?> <?=$student['lastname']?></a></td>
		           		<td class="een"><?=$student['name']?></td>
		           		<td class="een"><?=$student['score']?></td>
				<?php
					}
					else if($student['checkteacher'] == 3)
					{
				?>
						<td class="twee"><a href="deliver.php?id=<?=$student['0']?>&mid=<?=$student['5']?>&kid=<?=$_GET['id']?>"/><?=$student['firstname']?> <?=$student['lastname']?></a></td>
		           		<td class="twee"><?=$student['name']?></td>
		           		<td class="twee"><?=$student['score']?></td>
				<?php
					}
					else if($student['checkteacher'] == 4)
					{
				?>
						<td class="twee"><a href="deliver.php?id=<?=$student['0']?>&mid=<?=$student['5']?>&kid=<?=$_GET['id']?>"/><?=$student['firstname']?> <?=$student['lastname']?></a></td>
		           		<td class="twee"><?=$student['name']?></td>
		           		<td class="twee"><?=$student['score']?></td>
						
				<?php
					}
        		?>
		        	</tr>


		    <?php

		    }



		}
	?>
</table>
</div>
</body>
</html>