<?php
class Database
{
	private $host="localhost";
	private $username="root";
	private $pass="";
	private $db="pssi";
	protected $koneksi;
	public function __construct()
	{
		$this->koneksi = new mysqli($this->host, $this->username, $this->pass, $this->db);
		if($this->koneksi==false): die("Tidak dapat terhubung ke database. Error :".$this->koneksi->connect_error()); 
		endif;
		return $this->koneksi;
	}
	
}
?>