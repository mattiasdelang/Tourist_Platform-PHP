<?php
session_set_cookie_params(3600*24*30,"/");
session_start();

include_once("classes/class.class.php");
$c = new klas();
$db = new Db();
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

	$c->Checkteacher($_GET['kid'],$_SESSION['project_login']['id']);

}
$checkl = true;

$days = $c->Showdays($_GET['kid']);

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>project 2 - plan trip</title>
    <link rel="stylesheet" type="text/css" href="reset.css">
    <link rel="stylesheet" type="text/css" href="css.css">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>

	<style type="text/css">
		.connectedSortable { width:100%; min-height:400px; border:#34B296 1px solid; background:#34B296;list-style-type: none; margin: 0; padding: 0; margin-right: 10px;border-radius:5px; }
		.connectedSortable li { background:#EDEDED; cursor:move;border:#34B296 1px solid;border-radius:5px;margin: 5px 5px 5px 5px; padding: 5px; font-size: 20px;text-align: center;  line-height: 25px;}
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
              <li class="name"><?php echo $_SESSION['project_login']['login'] ?></li>
              <li class="knop1"><a href="settings.php">settings</a></li>
              <li class="knop1"><a href="logout.php">logout</a></li>
            </ul>
    </nav>
    <article>
        <a href="admin.php" class="link">Klaar</a>
    <div>
<?php

    for($x = 0; $x < $days;$x++)
    {
        $column= '';
        $query = "SELECT werk.id,leerling.lastname,leerling.firstname,monument.name FROM werk  INNER JOIN leerling on werk.studentid = leerling.id INNER JOIN monument on werk.monumentid = monument.id WHERE werk.classid = ". $_GET['kid'] ." AND  werk.colom = ".$x." ORDER BY rank ASC";
        $results = $db->conn->query($query);
        while ($result = $results->fetch_array())
		{
            $column .= '<li id="entry_' . $result['id'] . '" class="ui-state-default">' .  $result['name'] . '</br> ( '.$result['lastname'] . ' ' . $result['firstname'] . ' ) </li>';
        }
            
        $m = $x+1;
        echo "<div class='rij'><p>Dag " . $m . "</p>";
        echo "<ul id='sortable".$x."' class='connectedSortable'>";
        echo $column;
        echo "</ul></div>";
    }

?>
</div>
<script type="text/javascript">
$(function() 
{
    $("<?php
    
    for($l = 0; $l < $days;$l++)
    {
    
        echo '#sortable'. $l . ',';

    }
     ?>").sortable(
    {
        connectWith: '.connectedSortable',
        update : function () 
        { 
            $.ajax(
            {
                type: "POST",
                url: "draggable.php",
                data: 
                {
                    <?php
                    for($a = 0; $a < $days;$a++)
                    {   
                        echo "sort".$a . ":$('#sortable".$a."').sortable('serialize'),";
                    }
                    ?>
                   
                },
                success: function(html)
                {
                    //$('.success').fadeIn(500);
                }
            });
        } 
    }).disableSelection();
});
</script>

</article>

</div>
</body>
</html>