<?php
session_set_cookie_params(3600*24*30,"/");
session_start();

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
$cities = $c->Showcity();
$kid = $_GET['id'];
$classes = $c->Showclass1($kid);

if(!empty($_POST["changecity"]))
{
	$id = $_POST["city"];
	$c->Changedest($_GET["id"],$id);

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>project 2 - Verander bestemming</title>
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

		while($class = $classes->fetch_array())
		{
			//var_dump($class);
			echo "<div id='best'>" . $class["1"] ." " . $class["5"] . "</div>";

		}

	?>
	<div class="opmerking"> Pas op! Doe dit alleen als alle vorige wereking van de leerlingen van de klas zijn opgeslagen, deze zullen met deze actie verwijderd worden.</div>
	<form action="" method="post">
	<select class="input"name="city">

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
	<input type="submit" class="link" value="Verander stad" name="changecity"/>
	</form>
</article>
</body>
</html>