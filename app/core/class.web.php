<?php
/*
 * This class for public web soccer
 *
*/
class web extends settings
{
	public function showBerita()
	{
		$sql="SELECT * FROM berita WHERE status_berita='Diterbitkan' ORDER by id_berita desc";
		$perintah=$this->query($sql);
		return $perintah;
	}
	public function showBerita_beranda()
	{
		$sql="SELECT * FROM berita WHERE status_berita='Diterbitkan' ORDER by id_berita desc LIMIT 4";
		$perintah=$this->query($sql);
		if(!empty($perintah)) return $perintah;
	}
	public function limitBerita()
	{
		$this->halaman = 6;         
	    $this->page = isset($_GET['halaman'])? (int)$_GET["halaman"]:1;    
	    $mulai = ($this->page>1) ? ($this->page * $this->halaman) - $this->halaman : 0;
		$sql="SELECT * FROM berita WHERE status_berita='Diterbitkan' ORDER by id_berita desc LIMIT $mulai, ".$this->halaman."";
		$perintah=$this->query($sql);
		return $perintah;
	}
	
	public function detailBerita($data)
	{
		$sql = "SELECT * FROM berita WHERE id_berita=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("i",$param_data);
			$param_data=$data;
			if($stmt->execute()):
				$stmt->store_result();
				$stmt->bind_result($this->id_berita, $this->judul_berita, $this->isi_berita, $this->kategori_berita, $this->status_berita, $this->penulis_berita, $this->gambar_berita, $this->tanggal_berita, $this->tanggal_berita_update);
				$stmt->fetch();
				if($stmt->num_rows==1):
					return true;
				else:
					return false;
				endif;
			endif;
		endif;
		$stmt->close();
	}
	public function relatedPost($label, $data)
	{
		$sql="SELECT * FROM berita WHERE kategori_berita = '$label' AND status_berita='Diterbitkan' AND id_berita != '$data' order by id_berita desc LIMIT 6";
		$stmt=$this->query($sql);
		if(!empty($stmt)) return $stmt;
	}
	public function semuaJadwal()
	{
		$sql="SELECT * FROM jadwal_liga ORDER BY id_jadwal desc";
		$stmt=$this->query($sql);
		if(!empty($stmt)) return $stmt;
	}
	public function semuaJadwal_limit()
	{
		$this->halaman = 6;         
	    $this->page = isset($_GET['halaman'])? (int)$_GET["halaman"]:1;    
	    $mulai = ($this->page>1) ? ($this->page * $this->halaman) - $this->halaman : 0;
		$sql="SELECT * FROM jadwal_liga ORDER by id_jadwal desc LIMIT $mulai, ".$this->halaman."";
		$perintah=$this->query($sql);
		return $perintah;
	}
	public function jadwalPertandingan_beranda()
	{
		$sql="SELECT * FROM jadwal_liga ORDER BY id_jadwal desc LIMIT 1";
		$stmt=$this->query($sql);
		if(!empty($stmt)) return $stmt;
	}
	public function semuaTim()
	{
		$sql="SELECT * FROM profile_club ORDER by id_club desc";
		$perintah=$this->query($sql);
		if(!empty($perintah)) return $perintah;
	}
	public function detailClub($data)
	{
		$sql = "SELECT id_club, nama_club, alamat_club, kontak_club, logo_club FROM profile_club WHERE id_club=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("i",$param_data);
			$param_data=$data;
			if($stmt->execute()):
				$stmt->store_result();
				$stmt->bind_result($this->id_club, $this->nama_club, $this->alamat_club, $this->kontak_club, $this->logo_club);
				$stmt->fetch();
				if($stmt->num_rows==1):
					return true;
				else:
					return false;
				endif;
			endif;
		endif;
		$stmt->close();
	}
	public function paraPemain($data)
	{
		
		$sql="SELECT profile_club.id_club, id_user, nama_club, nama_pemain, no_punggung_pemain, posisi_pemain, nik, no_kk, tempat_lahir, tgl_lahir, tinggi_badan, berat_badan, golongan_darah, alamat,  kontak_pemain  FROM profile_club INNER JOIN profile_pemain ON profile_pemain.id_club=profile_club.id_club WHERE profile_pemain.id_club='$data' LIMIT 20";
		$perintah=$this->query($sql);
		return $perintah;
	}
	public function paraPemain_foto($data)
	{
		$sql="SELECT foto_user FROM users WHERE id_user='$data'";
		$perintah=$this->query($sql);
		$this->rowfoto=$perintah->fetch_array();
		$this->datafoto=$this->rowfoto['foto_user'];
		return $this->datafoto;
		return $this->rowfoto->free_result();
	}
	public function detailPemain($data)
	{
		$sql="SELECT id_club, profile_pemain.id_user, no_punggung_pemain, posisi_pemain, users.nik, nama_user, no_kk, tempat_lahir, tgl_lahir, tinggi_badan, berat_badan, golongan_darah, alamat, kontak_pemain, foto_user, dok_kartu_keluarga, dok_akte_lahir, dok_raport, role FROM profile_pemain INNER JOIN users ON profile_pemain.id_user=users.id_user INNER JOIN dokumen_pemain ON profile_pemain.id_user=dokumen_pemain.id_user WHERE profile_pemain.id_user=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("i",$param_data);
			$param_data=$data;
			if($stmt->execute()):
				$stmt->store_result();
				$stmt->bind_result($this->id_club, $this->id_user, $this->no_punggung, $this->posisi_pemain, $this->nik, $this->nama_user, $this->no_kk, $this->tempat_lahir, $this->tgl_lahir, $this->tinggi_badan, $this->berat_badan, $this->golongan_darah, $this->alamat, $this->kontak_pemain, $this->foto_user, $this->dok_kartu_keluarga, $this->dok_akte_lahir, $this->dok_raport, $this->role);
				$stmt->fetch();
				if($stmt->num_rows==1):
					return true;
				else:
					return false;
				endif;
			endif;
		endif;
		$stmt->close();
	}	
	public function namaClub($data)
	{

		if(!empty($data)):
			$sql="SELECT id_club, nama_club FROM profile_club WHERE id_club='$data'";
			$perintah=$this->query($sql);
			$this->nameClub=$perintah->fetch_array();
			$this->club=$this->nameClub['nama_club'];		
			return $this->club;
			return $this->nameClub->free_result();
		endif;
	
	}
	public function selectLogo($data)
	{
		if(!empty($data)):
			$sql="SELECT logo_club FROM profile_club WHERE id_club='$data'";
			$perintah=$this->query($sql);
			$this->logoclub=$perintah->fetch_array();
			$this->tmplogo=$this->logoclub['logo_club'];		
			return $this->tmplogo;
			return $this->logoclub->free_result();
		endif;
	}
	public function namaLiga($data)
	{
		if(!empty($data)):
			$sql="SELECT nama_liga FROM liga WHERE id_liga='$data'";
			$perintah=$this->query($sql);
			$this->namaliga=$perintah->fetch_array();
			$this->dataliga=$this->namaliga['nama_liga'];
			return $this->dataliga;
			$this->namaliga->free_result();
		endif;
	}
	public function profilePages()
	{
		$sql="SELECT id_pages, judul_pages, isi_pages, penulis_pages FROM pages";
		$perintah=$this->query($sql);
		if(!empty($perintah)) return $perintah;
	}
	public function detailPages($data)
	{
		$sql="SELECT id_pages, judul_pages, isi_pages, penulis_pages FROM pages WHERE id_pages=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("i",$param_data);
			$param_data = $data;
			if($stmt->execute()):
				$stmt->store_result();
				$stmt->bind_result($this->id_pages, $this->judul_pages, $this->isi_pages, $this->penulis_pages);
				$stmt->fetch();
				if($stmt->num_rows==1):
					return true;
				else:
					return false;
				endif;
			endif;
		endif;

	}
	public function loginAuth($nik, $pass)
	{
		$sql="SELECT id_user, nik, password, role ,nama_user FROM users WHERE nik=? AND status=1";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("s",$param_data);
			$param_data=$nik;
			if($stmt->execute()):
				$stmt->store_result();
				$stmt->bind_result($this->id_user, $this->nik, $this->pass_hash, $this->role, $this->nama_user);
				$stmt->fetch();
				if($stmt->num_rows==1):
					if(password_verify($pass, $this->pass_hash)):
						return true;
					else:
						return false;
					endif;
				endif;
			endif;
		endif;
		$stmt->close();
	}
	
	
}
?>