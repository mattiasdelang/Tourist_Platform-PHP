<?php
include_once("db.class.php");
require("fpdf.php");

class klas
{

	public function Showcity()
	{

		$db = new Db();
		$sql = "Select * from stad;";
		return $db->conn->query($sql);

	}

	public function Createclass($name,$tsid,$cityid,$days,$addressh)
	{

		$db = new Db();
		$url = rand(0,10000) . ".pdf";
		$sql = "insert into klas (name,teacherid,schoolid,cityid,fileurl,days,address) values('" . $name . "'," . $_SESSION['project_login']["id"] . ",". $tsid .",". $cityid .",'".$url."',".$days.",'".$addressh."');";
		$db->conn->query($sql);
		$id = $db->conn->insert_id;
		return $id;
		
	}

	public function Showteacherschool()
	{

		$db = new Db();
		$sql = "select schoolid from leerkracht where id =". $_SESSION['project_login']["id"] .";";
		$tschools = $db->conn->query($sql);

		while ($tschool = $tschools->fetch_array())
	    {
	    	
	       $tsid = $tschool["schoolid"];
	    

	    }

	    return $tsid;

	}
	public function Showschool($kid)
	{

		$db = new Db();
		$sql = "Select schoolid from klas where id =  ". $kid .";";
		$schools = $db->conn->query($sql);

		while ($school = $schools->fetch_array())
	    {
	    	
	       $sid = $school["schoolid"];
	    

	    }
	    return $sid;

	}

	public function Makeaccs($acc,$kid,$tsid)
	{

		$i = rand(1,6235);
		$Salt = 'ezvzeéùµùµµ(21154.$ùù$ù';
		$db = new Db();
		$sql1 = "select fileurl from klas where id = ".$kid.";";
		$fileurls = $db->conn->query($sql1);
		while ($fileurl = $fileurls->fetch_array())
	    {
	    	
	       $url = $fileurl["fileurl"];
	    

	    }

		$string ="";
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial');
				
		foreach ($acc as $line=> $value) {
			$login1 = str_replace('     ', '.', $value);
			$login = str_replace('     ', '.', $login1);
			$value2 = str_replace('    ', '.', $login);
			$value3 = str_replace('   ', '.', $value2);
			$value4 = str_replace('  ', '.', $value3);
			$value5 = str_replace(' ', '.', $value4);
			$name = explode(".", $value5);
			var_dump($name);
			$fname = $name["1"];
			$lname = $name["0"];
			$password = $lname . $i;

			$spass = md5($password . $Salt);
			$string = $string . $value5. "        " .$password . "\n";
			$sql = "insert into leerling (login,password,schoolid,classid,lastname,firstname) values('".$value5."','".$spass."',".$tsid.",".$kid.",'".$lname."','".$fname."');";
			$db->conn->query($sql);
			$id = $db->conn->insert_id;

			$sql1 = "insert into werk (classid,studentid,showscore,checkteacher,checkstudent,colom,rank) values(".$kid.",".$id.",0,0,0,0,0);";
			$db->conn->query($sql1);
			$i++;		
		    
		}
		$pdf->Multicell(0,12,$string);
		$pdf->Output($url,'F');


	}

	public function Showkinfo($kid)
	{

		$db = new Db();
		$sql = "select klas.name, stad.name, stad.id from klas INNER JOIN stad on klas.cityid = stad.id where klas.id = ".$kid.";";
		return $db->conn->query($sql);
	}

	public function Showkleerlingen($kid)
	{

		$db = new Db();
		$sql = "select lastname,firstname,id from leerling where classid = ".$kid.";";
		return $db->conn->query($sql);

	}

	public function Showmom($cid)
	{

		$db = new Db();
		$sql = "select id,name from monument where cityid = ".$cid.";";
		return $db->conn->query($sql);


	}

	public function Insertmon($lid,$mid,$kid)
	{

		$db = new Db();
		$sql = "update werk set monumentid=".$mid." where studentid=".$lid." and classid=".$kid.";";
		$db->conn->query($sql);

	}

	public function Showclass()
	{

		$db = new Db();
		$userid = $_SESSION["project_login"]["id"];
		$sql = "Select klas.id, klas.name, klas.teacherid, klas.fileurl, school.name, stad.name From klas INNER JOIN school ON klas.schoolid=school.id INNER JOIN stad ON klas.cityid=stad.id where klas.teacherid = " . $userid . ";";
		return $db->conn->query($sql);
		
	}

	public function Showclass1($kid)
	{

		$db = new Db();
		$sql = "Select klas.id, klas.name, klas.teacherid, klas.fileurl, school.name, stad.name From klas INNER JOIN school ON klas.schoolid=school.id INNER JOIN stad ON klas.cityid=stad.id where klas.id = '" . $kid . "';";
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

	public function Changedest($id,$cid)
	{

		$db = new Db();
		$sql = "Update klas set cityid=".$cid." where id=".$id.";";
		$db->conn->query($sql);
		header("Location:changedes2.php?kid=".$id."&cid=".$cid);

	}

	public function Updatewerk($lid,$mid,$kid)
	{

		$db = new Db();
		$sql = "update werk set monumentid=".$mid.", content= NULL , time=CURRENT_TIMESTAMP, message= NULL , score='/' ,showscore=0, checkteacher=0,colom=0,rank=0 where studentid=".$lid." and classid=".$kid.";";
		$db->conn->query($sql);

	}

	Public function Showdays($kid)
	{

		$db = new Db();
		$sql = "select days from klas where id =".$kid.";";
		$results = $db->conn->query($sql);
		
		while ($result = $results->fetch_array())
	    {
	    	
	       $info = $result["days"];
	    

	    }
	    return $info;
	}


}

