<?php
class smpl extends dataInput
{
	public function prepare($data)
	{
		$prth = $this->koneksi->prepare($data);
		if(!$prth) die("Error prepare statement :".$this->koneksi->error);
		return $prth;
	}
	public function query($data)
	{
		$prth = $this->koneksi->query($data);
		if(!$prth) die("Error statement :".$this->koneksi->error);
		return $prth;
	}
	public function selectRole()
	{
		$sql = "SELECT name FROM role ORDER by weight desc";
		$prth = $this->query($sql);
		return $prth;
	}
	public function cekNik($data){
		$sql="SELECT nik FROM users WHERE nik=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("s", $param_data);
			$param_data=$data;
			if($stmt->execute()):
				$stmt->store_result();
				if($stmt->num_rows==1):
					return true;
				else:
					return false;
				endif;
			endif;
		endif;
		$stmt->close();
	}
	public function listAll_Club()
	{
		$sql = "SELECT id_club, nama_club, alamat_club, kontak_club, logo_club FROM profile_club";
		$perintah = $this->query($sql);
		return $perintah;
	}
	public function listAll_liga()
	{
		$sql="SELECT id_liga, nama_liga, nama_penyelenggara, tahun_penyelenggaraan, jumlah_tim, sistem_pertandingan FROM liga";
		$perintah=$this->query($sql);
		return $perintah;
	}

	public function sessionData($data)
	{
		if(!empty($data)):

			if($_SESSION['role']=='administrator'):

			    $sql="SELECT * FROM users WHERE id_user='$data'";
				$perintah=$this->query($sql);
				$this->datasession=$perintah->fetch_array();
				return $this->datasession;
				return $perintah->free_result();

			elseif($_SESSION['role']=='petugas'):

				$sql="SELECT id_petugas, profile_petugas.id_user, nik, role, nama_user, foto_user,  tempat_lahir, tgl_lahir, alamat, kontak_petugas  FROM profile_petugas INNER JOIN users ON profile_petugas.id_user=users.id_user WHERE profile_petugas.id_user='$data'";
				$perintah=$this->query($sql);
				$this->datasession=$perintah->fetch_array();
				return $this->datasession;
				return $perintah->free_result();
				
			elseif($_SESSION['role']=='adminclub'):
			    $sql="SELECT id_admclub, id_club, profile_admclub.id_user, nik, role, nama_user, foto_user,  tempat_lahir, tgl_lahir, alamat, kontak_admin FROM profile_admclub INNER JOIN users ON profile_admclub.id_user=users.id_user WHERE profile_admclub.id_user='$data'";
				$perintah=$this->query($sql);
				$this->datasession=$perintah->fetch_array();
				return $this->datasession;
				return $perintah->free_result();

			  else:
			      if($_SESSION['role']=='pemain'):
			       $sql = "SELECT id_pemain, profile_pemain.id_user, id_club, users.nik, role, nama_user, foto_user, no_punggung_pemain, posisi_pemain, no_kk, tempat_lahir, tgl_lahir, tinggi_badan, berat_badan, golongan_darah, alamat,  kontak_pemain, status FROM profile_pemain INNER JOIN users ON profile_pemain.id_user=users.id_user WHERE profile_pemain.id_user='$data'";
			       		$perintah=$this->query($sql);
						$this->datasession=$perintah->fetch_array();
						return $this->datasession;
						return $perintah->free_result();
			      endif;
			endif;
			/*
			$sql="SELECT * FROM users WHERE id_user='$data'";
			$perintah=$this->query($sql);
			$this->datasession=$perintah->fetch_array();
			return $this->datasession;
			return $perintah->free_result();
			*/
		endif;
	}
	
	
	
	
	
}
?>