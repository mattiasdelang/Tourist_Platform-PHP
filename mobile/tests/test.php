<?php
session_set_cookie_params(3600*24*30,"/");
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
	setInterval(function () {
    navigator.geolocation.getCurrentPosition(onPositionUpdate);
	

	function onPositionUpdate(position) {
    var lat = position.coords.latitude;
    var lon = position.coords.longitude;
	$.ajax(
	    {
	        type: "POST",
	        dataType: "json",
	        url: "session.php",
	        data: 
	        {
	        	sort1:lat,
	        	sort2:lon
	           
	        },
	        success: function(data) {
	        for (i = 0; i < data.length; i++) { 
			     $("#coo"+ i).text(data[i][0] +' '+ data[i][1]);
			}
	      }

	    });
	}
},3000);
});
	</script>

</head>
<body>
<?php
$k = 0;
while($result = $results->fetch_array())
{
	
	
	echo "<div class='titlelist'>" . $result["name"] ." (" . $result["lastname"]. " ".$result["firstname"]. ") </div> <div id='coo" .$k."'></div>";
	
	echo "<div class='content'>" . $result["content"] ."</div>";  
	echo "</br>";
	$k++;
}
	
	
	echo "<div class='titlelist'>Hotel </div> <div id='coo" .$k."'></div> ";
	echo "</br>";


	

?>

</body>
</html>
