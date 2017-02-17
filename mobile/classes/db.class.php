<?php
class db
{

	private $m_sHost = "";
	private $m_sUser = "";
	private $m_sPassword = "";
	private $m_sDatabase = "";
	
	public $conn;
	
	public function __construct()
	{
	
		$this->conn = new mysqli($this->m_sHost,$this->m_sUser,$this->m_sPassword,$this->m_sDatabase);
	
	}

}