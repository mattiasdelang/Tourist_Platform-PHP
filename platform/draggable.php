<?php
include_once("classes/db.class.php");
$db = new Db();
if (!($_POST)) { echo 'error'; }
	
else {

    $days = 2;

    for($k = 0; $k < $days; $k++)
    {
    	$sport = "sort".$k;

    	parse_str($_POST[$sport], $sort);

    	foreach($sort['entry'] as $key=>$value) {
			$updatequery = "UPDATE werk SET rank = ".$key.", colom = '".$k."' WHERE id = ".$value.";";	
			$db->conn->query($updatequery);
			}


    }
}
    
?>