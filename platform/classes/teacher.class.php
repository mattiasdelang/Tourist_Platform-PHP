<?php
include_once("db.class.php");
require('fpdf.php');

class Teacher
	{

		
	public function Showclass()
	{

		$db = new Db();
		$userid = $_SESSION["project_login"]["id"];
		$sql = "Select klas.id, klas.name, klas.teacherid, klas.fileurl, school.name From klas INNER JOIN school ON klas.schoolid=school.id  where klas.teacherid = '" . $userid . "';";
		return $db->conn->query($sql);
		
	}

	public function Showstudents($id)
	{

		$db = new Db();
		$sql = "select leerling.id, leerling.firstname, leerling.lastname,werk.score, monument.name, monument.id, werk.checkteacher from werk inner join leerling on werk.studentid=leerling.id inner join monument on werk.monumentid=monument.id where leerling.classid = '". $id ."';";
		return $db->conn->query($sql);
		

	}

	public function Showmonument($id,$mid)
	{

		$db = new Db();
		$sql = "Select monument.name from werk INNER JOIN monument on werk.monumentid = monument.id where studentid = '". $id ."' AND monumentid = '". $mid ."';";
		return $db->conn->query($sql);

	}

	public function Showwerk($id,$mid)
	{

		$db = new Db();
		$sql = "Select * from werk where studentid = '". $id ."' AND monumentid = '". $mid ."';";
		return $db->conn->query($sql);

	}

	public function Checkteacher($kid,$id)
	{

		$db = new Db();
		$sql = "Select * from klas where id = '". $kid ."' AND teacherid = '". $id ."';";
		$result = $db->conn->query($sql);
			
			if ($result->num_rows == 0)
			{
				
				header("Location:admin.php");
					
			}
			
	}

	public function Insert1versie($info,$mid,$id,$kid)
	{
		$db = new Db();
		$sql = "update werk set content='".$info."',checkteacher=1, time=CURRENT_TIMESTAMP where studentid=".$id." and classid=".$kid." and monumentid=".$mid.";";
		$db->conn->query($sql);
		header("Location:deliver.php?id=".$_SESSION['project_login']['id']."&mid=".$_SESSION['project_login']['mid']."&kid=".$_SESSION['project_login']['kid']."");
	}

	public function Insert2versie($info,$mid,$id,$kid)
	{
		$db = new Db();
		$sql = "update werk set content='".$info."',checkteacher=3, time=CURRENT_TIMESTAMP where studentid=".$id." and classid=".$kid." and monumentid=".$mid.";";
		$db->conn->query($sql);
		header("Location:deliver.php?id=".$_SESSION['project_login']['id']."&mid=".$_SESSION['project_login']['mid']."&kid=".$_SESSION['project_login']['kid']."");
	}

	public function Insertfeedback($info,$mid,$id,$kid)
	{
		$db = new Db();
		$sql = "update werk set message='".$info."',checkteacher=2, time=CURRENT_TIMESTAMP where studentid=".$id." and classid=".$kid." and monumentid=".$mid.";";
		$db->conn->query($sql);
		header("Location:class.php?id=".$kid);
	}

	public function Insertpunten($info,$mid,$id,$kid)
	{
		$db = new Db();
		$sql = "update werk set score='".$info."',checkteacher=4 where studentid=".$id." and classid=".$kid." and monumentid=".$mid.";";
		$db->conn->query($sql);
		header("Location:class.php?id=".$kid);

	}

	public function Checkscore($kid)
	{

		$db = new Db();
		$sql = "select showscore from werk where classid=".$kid.";";
		$shows = $db->conn->query($sql);

		while($show = $shows->fetch_array())
		{

			$showid = $show["showscore"];

		}
		return $showid;
	}

	public function Showscore($kid)
	{

		$db = new Db();
		$sql = "update werk set showscore=1 where classid = ".$kid.";";
		$db->conn->query($sql);
		header("location:class.php?id=".$kid);

	}



	public function Hidescore($kid)
	{
		$db = new Db();
		$sql = "update werk set showscore=0 where classid = ".$kid.";";
		$db->conn->query($sql);
		header("location:class.php?id=".$kid);
	}

	public function Getname($id)
	{

		$db = new Db();
		$sql = "select leerling.lastname, leerling.firstname,monument.name from werk inner join leerling on werk.studentid=leerling.id inner join monument on werk.monumentid=monument.id where leerling.id = '". $id ."'";
		return $db->conn->query($sql);

	}

	public function Savedocs($id,$lname,$fname,$mname)
	{

		$db = new Db();
		$sql = "select time,content,message,score from werk where studentid = ".$id.";";
		$infos = $db->conn->query($sql);

		$string = "Naam: " . $lname . " " . $fname . "\n";
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial');
		while($info = $infos->fetch_array())
		{

			$string .= "Tijdsbepaling: " . $info['time'] . "\n";
			$string .= "Voorbereiding: \n";
			$string .= $info['content'];
			$string .= "\n\n";
			$string .= "Feedback leerkracht: \n";
			$string .= $info['message'];
			$string .= "\n\nScore:";
			$string .= $info['score'];

		}
		
		
		$sname = $lname . "_" . $fname . "_" . $mname;
		$pdf->Multicell(0,12,$string);

		$pdf->Output($sname. ".pdf","D");


	}

	public function Showcity($kid)
	{

		$db = new Db();
		$sql = "select stad.name from klas inner join stad on klas.cityid = stad.id where klas.id =".$kid.";";
		$citys = $db->conn->query($sql);

		while($city = $citys->fetch_array())
		{

			$name = $city["name"];

		}

		return $name;

	}


		
	}