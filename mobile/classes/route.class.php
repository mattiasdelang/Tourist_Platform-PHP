<?php
include_once("db.class.php");

class Route
{
	public function ShowLeerlingklas()
	{

		$db = new Db();
		$id = $_SESSION['mobile_login']['id'];
		$sql = "select classid from leerling where id = ".$id.";";
		$results = $db->conn->query($sql);

		while($result = $results->fetch_array())
		{

			$kid = $result["classid"];

		}

		return $kid;
	}

	public function Showlist($kid,$did)
	{

		$db = new Db();
		$sql = "select monument.name, leerling.firstname,monument.url , leerling.lastname, werk.content, monument.address from werk inner join monument on werk.monumentid = monument.id inner join leerling on werk.studentid = leerling.id where werk.classid = ".$kid." and werk.colom = ".$did." order by rank";
		return $db->conn->query($sql);

	}

	public function Showhotel($kid)
	{

		$db = new Db();
		$sql = "select address from klas where id = ".$kid.";";
		$results = $db->conn->query($sql);

		while($result = $results->fetch_array())
		{

			$hotel = $result["address"];

		}

		return $hotel;
	}

	public function Giveaddress($kid,$did)
	{

		$db = new Db();
		$sql = "select monument.address, monument.lat, monument.long from werk inner join monument on werk.monumentid = monument.id inner join leerling on werk.studentid = leerling.id where werk.classid = ".$kid." and werk.colom = ".$did." order by rank";
		$addresses = $db->conn->query($sql);

		$i = 0;
		while($addr = $addresses->fetch_array())
		{
			$mooi = str_replace(' ', '', $addr["address"]);
			$lijst[$i][0] = $mooi;
			$lijst[$i][1] = $addr["lat"].",".$addr["long"];
			$i++;

		}

		return $lijst;

	}

	public function Showclassinfo($kid)
	{

		$db = new Db();
		$sql = "select days from klas where id =".$kid.";";
		$results = $db->conn->query($sql);

		while($result = $results->fetch_array())
		{

			$dagen = $result["days"];

		}

		return $dagen;

	}

	public function Showcity($kid)
	{

		$db = new Db();
		$sql = "select stad.name from klas inner join stad on klas.cityid = stad.id where klas.id = ".$kid.";";
		$results = $db->conn->query($sql);

		while($result = $results->fetch_array())
		{

			$naam = $result["name"];

		}

		return $naam;

	}


}