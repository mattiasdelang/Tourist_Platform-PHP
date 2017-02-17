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

							$_SESSION["mobile_login"]["login"] = $this->Login;
							$_SESSION["mobile_login"]["timeout"] = time();
							$_SESSION["mobile_login"]["who"] = 1;
							$_SESSION["mobile_login"]["id"] = $id;
							$_SESSION["mobile_login"]["password"] = $this->Password;
							$_SESSION["mobile_login"]["mode"] = "walking";
							header("Location:index.php");

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

						$_SESSION["mobile_login"]["login"] = $this->Login;
						$_SESSION["mobile_login"]["timeout"] = time();
						$_SESSION["mobile_login"]["id"] = $id;
						$_SESSION["mobile_login"]["password"] = $this->Password;
						$_SESSION["mobile_login"]["mode"] = "walking";
						$_SESSION["mobile_login"]["mode1"] = "WALKING";
						header("Location:index.php");

					}
					else
					{

						throw new Exception("Login of wachtwoord is niet correct.");

					}
				}
		}
				
	}