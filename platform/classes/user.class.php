<?php
include_once("db.class.php");
class User
	{
	
		private $id;
		private $Lastname;
		private $Firstname;
		private $Email;
		private $Password;
		private $Newpw;
		private $Confirmpw;
		private $Who;
		private $Login;
		private $Salt = 'ezvzeéùµùµµ(21154.$ùù$ù';
	
		public function setId($id)
		{

			$this->id = $id;

		}

		public function getId($id)
		{

			return $this->id;

		}

		public function setWho($Who)
		{

			$this->Who = $Who;

		}

		public function getWho($id)
		{

			return $this->Who;

		}
		
		public function setEmail($Email)
		{

			$this->Email = $Email;

		}

		public function getEmail()
		{

			return  mysql_real_escape_string($this->Email);

		}

		public function setFirstname($Firstname)
		{

			$this->Firstname = $Firstname;

		}

		public function getFirstname()
		{

			return  mysql_real_escape_string($this->Firstname);

		}

		public function setLastname($Lastname)
		{

			$this->Lastname = $Lastname;

		}

		public function getLastname()
		{

			return  mysql_real_escape_string($this->Lastname);

		}

		public function setConfirmpw($Confirmpw)
		{


			$this->Confirmpw = md5($Confirmpw.$this->Salt);

		}

		public function getConfirmpw()
		{

			return $this->Confirmpw;

		}

		public function setNewpw($Newpw)
		{

			

			$this->Newpw = md5($Newpw.$this->Salt);

		}

		public function getNewpw()
		{

			return $this->Newpw;

		}

		public function setPassword($Password)
		{

		

			$this->Password = md5($Password.$this->Salt);


		}

		public function getPassword()
		{

			return $this->Password;

		}

		public function setLogin($Login)
		{

			$this->Login = $Login;

		}

		public function getLogin($Login)
		{

			return $this->Login;

		}
		
		public function Checklogin()
		{

			$db = new Db();

				$sql = "select * from leerling where login ='" . $this->Login . "' and password = '" . $this->Password . "';";
				$result = $db->conn->query($sql);
				$num_rows = $result->num_rows;
				if ($num_rows === 0)
				{
				
					$sql1= "select * from leerkracht where login ='" . $this->Login . "' and password = '" . $this->Password . "';";
					$result1 = $db->conn->query($sql1);
					$num_rows1 = $result1->num_rows;
					if ($num_rows1 === 0)
					{
					
						throw new Exception("Login of wachtwoord is niet correct.");
							
					}
					else
					{
					
						$rows = $result1->num_rows;
						
						 if($rows === 1)
						{

							while($row = mysqli_fetch_array($result1))
							{

								$id = $row['id'];

							}

							$_SESSION["project_login"]["login"] = $this->Login;
							$_SESSION["project_login"]["timeout"] = time();
							$_SESSION["project_login"]["who"] = 1;
							$_SESSION["project_login"]["id"] = $id;
							$_SESSION["project_login"]["password"] = $this->Password;
							

						}
						else
						{

							throw new Exception("Login of wachtwoord is niet correct.");

						}
							
					}
				}
				else
				{
				
					$rows = $result->num_rows;
					
					 if($rows === 1)
					{

						while($row = mysqli_fetch_array($result))
						{

							$id = $row['id'];

						}

						$_SESSION["project_login"]["login"] = $this->Login;
						$_SESSION["project_login"]["timeout"] = time();
						$_SESSION["project_login"]["id"] = $id;
						$_SESSION["project_login"]["password"] = $this->Password;

					}
					else
					{

						throw new Exception("Login of wachtwoord is niet correct.");

					}
				}
		}

		public function Insertmail()
		{
						
			$db = new Db();
			$userid = $_SESSION["project_login"]["id"];
			$sql = "Select * From leerling where email = '" . $this->Email . "';";
			$result = $db->conn->query($sql);
			$rs =$result->num_rows;

			if($rs == 1)
			{

				throw new Exception("Er bestaat al een account met dit mailadres.");

			}
			else
			{

				$sql1 = "update leerling SET email = '" . $this->Email . "' where id = '". $userid . "';";
				$result = $db->conn->query($sql1);

			}

		}

		public function Checkmail()
		{
			$mail = "";
			$userid = $_SESSION["project_login"]["id"];
			$db = new Db();
			$sql = "Select email From leerling where id = '" . $userid . "';";
			$result = $db->conn->query($sql);

			
	            $rows =$result->num_rows;

	            if($rows === 1)
	            {

	                while($row = mysqli_fetch_array($result))
	                {
	                    $mail = $row['email'];
	                }

	            }
	            else
	            {

	                throw new Exception("Error occurred in the proces, contact helpdesk Error #1523");

	            }
	        
				if(empty($mail))
				{
					return "false";
				} 
				else
				{
					return "ok";
				}  
			
			


		}

		public function Changepassword()
		{

			$db = new Db();
			$userid = $_SESSION["project_login"]["id"];
			$sql= "select * from leerling where id ='" . $userid . "' and password = '" . $this->Password . "';";
			$result = $db->conn->query($sql);
			
			if ($result === false)
			{
			
				throw new Exception("Huidig wachtwoord is niet correct.");
					
			}
			else
			{
			
				$rows = $result->num_rows;
				
				 if($rows === 1)
				{

					if($this->Newpw == $this->Confirmpw)
					{

						$sql1= "update leerling SET password = '" . $this->Newpw . "' where id = '". $userid . "';";
						$result = $db->conn->query($sql1);

					}
					else
					{

						throw new Exception("Nieuwe wachtwoorden komen niet over elkaar.");

					}

				}
				else
				{

					throw new Exception("Huidig wachtwoord is niet correct.");

				}

			}
	
		}

		public function Changemail()
		{

			$db = new Db();
			$userid = $_SESSION["project_login"]["id"];
			$sql= "select * from leerling where id ='" . $userid . "' and password = '" . $this->Password . "';";
			$result = $db->conn->query($sql);
			
			if ($result === false)
			{
			
				throw new Exception("Huidig wachtwoord is niet correct.");
					
			}
			else
			{
			
				$rows = $result->num_rows;
				
				 if($rows === 1)
				{

						$sql1= "update leerling SET email = '" . $this->Email . "' where id = '". $userid . "';";
						$result = $db->conn->query($sql1);

					
				}
				else
				{

					throw new Exception("Huidig wachtwoord is niet correct.");

				}

			}
	
		}

		public function Showmonuser()
		{

			$db = new Db();
			$userid = $_SESSION["project_login"]["id"];
			$sql= "select classid, monumentid from werk where studentid = ". $userid .";";
			$results = $db->conn->query($sql);

			while($result = $results->fetch_array())
			{

				$_SESSION["project_login"]["mid"] = $result["monumentid"];
				$_SESSION["project_login"]["kid"] = $result["classid"];

			}

		}
}