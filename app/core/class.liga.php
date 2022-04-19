<?php

class liga extends smpl
{
	public function viewLiga()
	{
		$sql="SELECT id_liga, nama_liga, nama_penyelenggara, tahun_penyelenggaraan, jumlah_tim, sistem_pertandingan FROM liga";
		$perintah=$this->query($sql);
		return $perintah;
	}
	public function addLiga($nama_liga, $nama_penyelenggara, $tahun_penyelenggaraan, $jumlah_tim, $sistem_pertandingan, $logo, $item_logo, $item_destination)
	{
		$sql="INSERT INTO liga(nama_liga, nama_penyelenggara, tahun_penyelenggaraan, jumlah_tim, sistem_pertandingan, logo_liga) VALUES(?,?,?,?,?,?)";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("ssisss",
			$param_liga, 
			$param_penye,
			$param_tahun, 
			$param_jml, 
			$param_sistem,
			$param_logo
			);

			$param_liga=$nama_liga;
			$param_penye=$nama_penyelenggara;
			$param_tahun=$tahun_penyelenggaraan;
			$param_jml=$jumlah_tim;
			$param_sistem=$sistem_pertandingan;
			$param_logo=$item_logo;
			

			if($stmt->execute()&&(move_uploaded_file($logo,$item_destination.$item_logo))):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();

	}
	public function detailLiga($data)
	{
		$sql="SELECT id_liga, nama_liga, tahun_penyelenggaraan, nama_penyelenggara,  jumlah_tim, sistem_pertandingan, logo_liga FROM liga WHERE id_liga=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("i",$param_data);
			$param_data=$data;
			if($stmt->execute()):
				$stmt->store_result();
				$stmt->bind_result($this->id_liga, $this->nama_liga,  $this->tahun_penyelenggaraan, $this->nama_penyelenggara, $this->jumlah_tim, $this->sistem_pertandingan, $this->logo_liga);
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
	public function updateLiga($nama_liga, $nama_penyelenggara, $tahun_penyelenggaraan, $jumlah_tim, $sistem_pertandingan, $logo, $item_logo, $item_destination, $data)
	{
		$sql="UPDATE liga SET nama_liga=?, nama_penyelenggara=?, tahun_penyelenggaraan=?, jumlah_tim=?, sistem_pertandingan=?, logo_liga=? WHERE id_liga=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("sssissi",
			$param_liga, 
			$param_penye, 
			$param_tahun,
			$param_jml, 
			$param_sistem,
			$param_logo, 			
			$param_data);
			
			$param_liga=$nama_liga;
			$param_penye=$nama_penyelenggara;
			$param_tahun=$tahun_penyelenggaraan;
			$param_jml=$jumlah_tim;
			$param_sistem=$sistem_pertandingan;
			$param_logo=$item_logo;
			$param_data=$data;
			if(empty($_FILES['logo_liga']['tmp_name'])){

					if($stmt->execute()):
						return true;
					else:
						return false;
					endif;
				}else{
					if($stmt->execute()&&(move_uploaded_file($logo,$item_destination.$item_logo))):
						return true;
					else:

					return false;
				endif;
			}
		endif;
		$stmt->close();
	}
	public function deleteLiga($data)
	{
		$sql="DELETE FROM liga WHERE id_liga=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("i",$param_data);
			$param_data=$data;
			if($stmt->execute()):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();
	}
	public function deleteLiga_fromPeserta($data)
	{
		$sql="DELETE FROM peserta_liga WHERE id_liga=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("i",$param_data);
			$param_data=$data;
			if($stmt->execute()):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();
	}
	public function deleteLiga_fromJadwal($data)
	{
		$sql="DELETE FROM jadwal_liga WHERE id_liga=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("i", $param_data);
			$param_data=$data;
			if($stmt->execute()):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();
	}
	public function addPeserta_liga($dliga, $dclub)
	{
		$sql = "INSERT INTO peserta_liga (id_liga, id_club) VALUES (?,?)";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("ss",$param_dliga, $param_dclub);
			$param_dliga=$dliga;
			$param_dclub=$dclub;
			if($stmt->execute()):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();
			
	}
	public function viewPeserta_liga($data)
	{
		$sql="SELECT id_peserta, id_liga, peserta_liga.id_club, nama_club FROM peserta_liga INNER JOIN profile_club ON profile_club.id_club=peserta_liga.id_club WHERE id_liga='$data'";
		$perintah = $this->query($sql);
		return $perintah;
	}
	public function detailPeserta($data)
	{
		$sql="SELECT id_peserta FROM peserta_liga WHERE id_peserta=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("i",$param_data);
			$param_data=$data;
			if($stmt->execute()):
				$stmt->store_result();
				$stmt->bind_result($this->id_peserta);
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
	public function deletePeserta_liga($data)
	{
		$sql="DELETE FROM peserta_liga WHERE id_peserta = ?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("i",$param_data);
			$param_data=$data;
			if($stmt->execute()):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();
	}
	public function addJadwal($id_liga, $minggu, $hari, $tanggal, $jam, $tim_tuan_rumah, $tim_tamu, $skor_rumah, $skor_tamu, $tempat)
	{
		$sql="INSERT INTO jadwal_liga(id_liga, minggu_ke, hari, tanggal, jam, tim_tuan_rumah, tim_tamu, skor_tuan_rumah, skor_tim_tamu, tempat) VALUES (?,?,?,?,?,?,?,?,?,?)";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("iisssiiiis",
			$param_id,
			$param_minggu,
			$param_hari,
			$param_tanggal,
			$param_jam,
			$param_tim_tuan,
			$param_tim_tamu,
			$param_skor_rumah,
			$param_skor_tamu,
			$param_tempat
			);
			$param_id=$id_liga;
			$param_minggu=$minggu;
			$param_hari=$hari;
			$param_tanggal=$tanggal;
			$param_jam=$jam;
			$param_tim_tuan=$tim_tuan_rumah;
			$param_tim_tamu=$tim_tamu;
			$param_skor_rumah=$skor_rumah;
			$param_skor_tamu=$skor_tamu;
			$param_tempat=$tempat;
			if($stmt->execute()):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();

	}
	public function viewJadwal_shownameClub($data)
	{
		if(!empty($data)):
			$sql="SELECT id_club, nama_club FROM profile_club WHERE id_club='$data'";
			$perintah=$this->query($sql);
			$this->nameClub=$perintah->fetch_array();
			$this->rowname=$this->nameClub['nama_club'];		
			return $this->rowname;
			//$this->nameClub->free_result();
		else:
			
			$this->rowname="";		
			return $this->rowname;
			
		endif;
	}
	public function viewJadwal_liga($data)
	{
		$sql="SELECT id_jadwal, id_liga, minggu_ke, hari, tanggal, jam, tim_tuan_rumah, tim_tamu, skor_tuan_rumah, skor_tim_tamu, tempat FROM jadwal_liga WHERE id_liga='$data'";
		$perintah=$this->query($sql);
		return $perintah;
	}
	public function detailJadwal($data)
	{
		$sql = "SELECT id_jadwal, id_liga, minggu_ke, hari, tanggal, jam, tim_tuan_rumah, tim_tamu, skor_tuan_rumah, skor_tim_tamu, tempat FROM jadwal_liga WHERE id_jadwal=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("i",$param_data);
			$param_data=$data;
			if($stmt->execute()):
				$stmt->store_result();
				$stmt->bind_result($this->id_jadwal, $this->id_liga, $this->minggu_ke, $this->hari, $this->tanggal, $this->jam, $this->tim_tuan_rumah, $this->tim_tamu, $this->skor_tuan_rumah, $this->skor_tim_tamu, $this->tempat);
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
	public function updateJadwal($id_liga, $minggu, $hari, $tanggal, $jam, $tim_tuan_rumah, $tim_tamu, $skor_rumah, $skor_tamu, $tempat,$data)
	{
		$sql="UPDATE jadwal_liga SET id_liga=?, minggu_ke=?, hari=?, tanggal=?, jam=?, tim_tuan_rumah=?, tim_tamu=?, skor_tuan_rumah=?, skor_tim_tamu=?, tempat=? WHERE id_jadwal=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("iisssiiiisi",
			$param_id,
			$param_minggu,
			$param_hari,
			$param_tanggal,
			$param_jam,
			$param_tim_tuan,
			$param_tim_tamu,
			$param_skor_rumah,
			$param_skor_tamu,
			$param_tempat,
			$param_data
			);
			$param_id=$id_liga;
			$param_minggu=$minggu;
			$param_hari=$hari;
			$param_tanggal=$tanggal;
			$param_jam=$jam;
			$param_tim_tuan=$tim_tuan_rumah;
			$param_tim_tamu=$tim_tamu;
			$param_skor_rumah=$skor_rumah;
			$param_skor_tamu=$skor_tamu;
			$param_tempat=$tempat;
			$param_data=$data;
			if($stmt->execute()):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();
	}
	
}

?>