<?php
session_set_cookie_params(3600*24*30,"/");
session_start();
ob_start();
include_once("classes/class.class.php");
$c = new klas();
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

	$c->Checkteacher($_GET['id'],$_SESSION['project_login']['id']);

}
$checkl = true;


$kinfos = $c->Showkinfo($_GET['id']);
$leerlingen = $c->Showkleerlingen($_GET['id']);
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
	<?php

		while ($kinfo = $kinfos->fetch_array())
	    {
	    	?>
	    	<div id="best">
	      	<?=$kinfo["0"]?>
	       	<?=$kinfo["1"]; $cid = $kinfo["2"]; $mons = $c->Showmom($cid);?>
	   		</div>
			<?php	    
	    }
	   ?>
	
	<form action="" method="POST">
	<table class="list">
	<tr>
	<th>Leerling</th>
	<th>bestemming</th>
	</tr>
	<?php
	$e = 0;
	    while ($leerling = $leerlingen->fetch_array())
	    {
	    ?>
			<tr class="item">
	    	<td><label for="best<?=$e?>">
			<?=$leerling["0"] ." ". $leerling["1"]?>	
	    	</label>
	    	<input type="hidden" name="id<?=$e?>" value="<?=$leerling["2"]?>"></td>

	    	<td><select class="input" name="best<?=$e?>">
			<?php
				$a = array();
				$i = 0;
			    foreach ($mons as $mon) 
			    {

				   $a[$i] = $mon;		   
							    	
			?>
			    <option value="<?= $a[$i]["id"]?>"><?= $a[$i]["name"]?></option>
			<?php
				$i++;
			    }
			    
			
			?>
				
			</select></td></tr>

	<?php	
			$e++;    
	    }

	    if(!empty($_POST["dest"]))
		{
			for($r=0; $r < $e; $r = $r + 1)
			{

				$lid = $_POST["id".$r];
				$mid = $_POST["best".$r];
				$c->Insertmon($lid,$mid,$_GET['id']);
				header("Location:plantrip.php?kid=".$_GET['id']);

			}
			
		}
	?>
	</table>
	<input type="submit" class="link" name="dest" value="keuze bevestigen"/>

	</form>

	</article>
	</div>
</body>
</html>