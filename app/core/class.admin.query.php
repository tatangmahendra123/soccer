<?php

/**
														
	| Kehidupan ini seperti mimpi, terasa sebentar,
	| seperti halnya mimpi yang terasanya nyata
	| berada dalam ingatan, ketika berlalu
	| semua hanya menjadi kenangan.
	| Hidup seperti tidak ada masa depan, karena setiap
	| masa depan hanya akan menjadi kenangan.
	| Dan kenangan ini mungkin ini terus hidup dimasa, depan - masa
	| depan yang akan menjadi kenangan :(
	|
    |----------------------------------------|
    | Author          			 			 |
	| name 			  : Benny maulana 			 | 
	| mail 			  : innupasha2@gmail.com  |
	| blog 			  : xdmultimedia.id         |  
	|----------------------------------------| 

 	******************************************************************
	* Fungsi addProfile sebelumnya digunakan untuk memasukan data user dengan
	* role pemain, petugas dan admin clun kedalam tabel profile
	* tapi kemudian dirubah konsepnya dimana untuk penambahan user
	* pemain, petugas, dan adminclub akan menggunakan antarmuka tersendiri
	* secara terpisah, sedangkan untuk menambahkan user akan tetap menggunakan
	* fungsi adduser. Fungsi addUser akan berlaku untuk menambahkan user lain.
	* Fungsi ini merupakan operasi ini yang dilakukan oleh admin
	* dengan urutan proses :

	1. buat query di class.admin.query.php
	2. Eksekusi pada main.form.admin.php
	3. load module ke index.php

	* File utama yang selalu disertakan
	1. Database
	2. public query
	3. public input
	4. dan tambahan session jika diperlukan

	************************************************************************
*/

class adminOperation extends smpl
{
/***************************
	CRUD ADMINISTRATOR
****************************/
	public function addUser($nik, $pass, $role, $nama, $foto_user, $item_foto, $item_destination)
	{
		$sql = "INSERT INTO users (nik, password, role, status, nama_user, foto_user) VALUES(?,?,?,?,?,?)";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("sssiss",$param_nik, $param_pass, $param_role, $param_status, $param_nama, $param_foto);
			$param_nik=$nik;
			$param_pass=password_hash($pass, PASSWORD_DEFAULT);
			$param_role=$role;
			$param_status=1;
			$param_nama=$nama;		
			$param_foto=$item_foto;
			if($stmt->execute()&&(move_uploaded_file($foto_user,$item_destination.$item_foto))):
					return true;
				else:
					return false;
			endif;		
		endif;		
		$stmt->close();

	}
	public function updateUser($nik, $pass, $role, $nama, $foto, $item_foto, $item_destination, $data)
	{
		$sql = "UPDATE users SET nik=?, password=?, role=?, nama_user=?, foto_user=? WHERE id_user=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("sssssi",$param_n, $param_p, $param_r, $param_na, $param_f, $param_data);
			$param_n=$nik;
			$param_p=password_hash($pass, PASSWORD_DEFAULT);
			$param_r=$role;
			$param_na=$nama;
			$param_f=$item_foto;
			$param_data=$data;
			if(empty($_FILES['foto_user']['tmp_name'])){

					if($stmt->execute()):
						return true;
					else:
						return false;
					endif;
				}else{
					if($stmt->execute()&&(move_uploaded_file($foto,$item_destination.$item_foto))):
						return true;
					else:

					return false;
				endif;
			}
		endif;
		$stmt->close();
	}
	public function updateUser_noPass($nik, $role, $nama, $foto, $item_foto, $item_destination, $data)
	{
		$sql = "UPDATE users SET nik=?, role=?, nama_user=?, foto_user=? WHERE id_user=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("ssssi",$param_n, $param_r, $param_na, $param_f, $param_data);
			$param_n=$nik;			
			$param_r=$role;
			$param_na=$nama;
			$param_f=$item_foto;
			$param_data=$data;
			if(empty($_FILES['foto_user']['tmp_name'])){

					if($stmt->execute()):
						return true;
					else:
						return false;
					endif;
				}else{
					if($stmt->execute()&&(move_uploaded_file($foto,$item_destination.$item_foto))):
						return true;
					else:

					return false;
				endif;
			}
		endif;
		$stmt->close();
	}
	public function deleteUser($data)
	{
		$sql="DELETE FROM users WHERE id_user=?";
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
	public function listAll_administrator()
	{
		$sql="SELECT id_user, nik, role, status, nama_user, foto_user FROM users WHERE role='administrator' AND status=1";
		$perintah=$this->query($sql);
		return $perintah;
	}
	public function fetchAdministrator()
	{
		$this->no=1;
		$this->adm=$this->listAll_administrator();
		while($this->admrow=$this->adm->fetch_array()){
			
			echo'
			<tr>
			<td>'.$this->no.'</td>
			<td>'.$this->nik=$this->admrow['nik'].'</td>
			<td>'.$this->nama_admin=$this->admrow['nama_user'].'</td>
			
			</tr>

			';
			$this->no+=1;
		}

		$this->adm->free_result();
	}
	public function jumlahData()
	{
		$sql="SELECT SUM(IF(role='pemain',1,0)) AS jml_pemain, SUM(IF(role='petugas',1,0)) AS petugas, SUM(IF(role='adminclub',1,0)) AS jml_adminclub, SUM(IF(role='administrator',1,0)) AS jml_administrator from users WHERE status=1";
		$perintah=$this->query($sql);
		return $perintah;
	}

/***************************
	CRUD PETUGAS
****************************/
	
	public function addPetugas($data,$nama, $tmpt, $tgl_lahir, $alamat, $kontak)
	{
		$sql="INSERT INTO profile_petugas(id_user, nama_petugas, tempat_lahir, tgl_lahir, alamat, kontak_petugas) VALUES(?,?,?,?,?,?)";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("isssss",$param_data, $param_nama, $param_tmpt, $param_tgl, $param_al, $param_ktk);
			$param_data=$data;
			$param_nama=$nama;
			$param_tmpt=$tmpt;
			$param_tgl=$tgl_lahir;
			$param_al=$alamat;
			$param_ktk=$kontak;
			if($stmt->execute()):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();
	}
	public function listAll_petugas(){

		$sql = "SELECT profile_petugas.id_user, nama_petugas, kontak_petugas, status FROM profile_petugas INNER JOIN users ON profile_petugas.id_user=users.id_user";
		$perintah=$this->query($sql);
		return $perintah;
	}
	public function fetchPetugas(){
		
		if(isset($_POST['active'])):
			if($this->activeUser($this->post('status'))):
				$this->reload_time('1','petugas');
			else:
				$this->reload_time('1','petugas');
			endif;
		endif;
		if(isset($_POST['block'])):
			if($this->blockUser($this->post('status'))):
				$this->reload_time('1','petugas');
			else:
				$this->reload_time('1','petugas');
			endif;
		endif;

		$this->no=1;
		$this->adm=$this->listAll_Petugas();
		while($this->admrow=$this->adm->fetch_array()){
			
			echo'
			<tr>
			<td>'.$this->no.'</td>
			<td>'.$this->admrow['nama_petugas'].'</td>
			<td>'.$this->admrow['kontak_petugas'].'</td>
			<td>
			
			<a class="btn btn-sm btn-primary" style="font-size:0.8em" href="?page=edit petugas&id_user='.$this->id_user=$this->admrow['id_user'].'">Edit</a>
			<a class="btn btn-sm btn-danger" style="font-size:0.8em" href="?page=delete petugas&id_user='.$this->id_user=$this->admrow['id_user'].'">Delete</a>

			';
			if($this->admrow['status']==0):
				echo'
					'.$this->formGeneral().'
						
						<input type="hidden" name="status" value="'.$this->admrow['id_user'].'">
						<button type="submit" name="active" class="mt-2 btn btn-sm btn-info" style="font-size:0.8em" title="aktifkan petugas">active</button>
					</form>
					';
			else:
				echo'
				'.$this->formGeneral().'
					<input type="hidden" name="status" value="'.$this->admrow['id_user'].'">
						<button type="submit" name="block" class="mt-2 btn btn-sm btn-danger" style="font-size:0.8em" title="block petugas">block</button>
				</form>
				';
			endif;
			echo'
			</td>
			</tr>

			';
			$this->no+=1;
		}

		$this->adm->free_result();
	
	}
	public function detailPetugas($data)
	{
		$sql = "SELECT profile_petugas.id_user,nik, nama_user, foto_user, role, tempat_lahir, tgl_lahir, alamat, kontak_petugas FROM profile_petugas INNER JOIN users ON profile_petugas.id_user = users.id_user WHERE profile_petugas.id_user=? ";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("i",$param_data);
			$param_data=$data;
			if($stmt->execute()):
				$stmt->store_result();
				$stmt->bind_result($this->id_user, $this->nik, $this->nama_user, $this->foto_user, $this->role, $this->tempat_lahir, $this->tgl_lahir, $this->alamat, $this->kontak_petugas);
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
	public function updatePetugas($nama, $tempat_lahir, $tgl_lahir, $alamat, $kontak_petugas, $data)
	{
		$sql="UPDATE profile_petugas SET nama_petugas=?, tempat_lahir=?, tgl_lahir=?, alamat=?, kontak_petugas=? WHERE id_user=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("sssssi", $param_nama, $param_tmpt, $param_tgl, $param_alm, $param_ktk, $param_data);
			$param_nama=$nama;
			$param_tmpt=$tempat_lahir;
			$param_tgl=$tgl_lahir;
			$param_alm=$alamat;
			$param_ktk=$kontak_petugas;
			$param_data=$data;
			if($stmt->execute()):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();

	}
	public function deletePetugas($data)
	{
		$sql="DELETE FROM profile_petugas WHERE id_user=?";
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
/***************************
	CRUD ADMIN CLUB
****************************/
	public function addAdm_club($data, $club, $nama, $tmpt, $tgl_lahir, $alamat, $kontak)
	{
		$sql="INSERT INTO profile_admclub(id_user, id_club, nama_admclub, tempat_lahir, tgl_lahir, alamat, kontak_admin) VALUES (?,?,?,?,?,?,?)";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("iisssss",$param_data, $param_clb, $param_nama, $param_tmpt, $param_tgl, $param_alamat, $param_kontak);
			$param_data=$data;
			$param_clb=$club;
			$param_nama=$nama;
			$param_tmpt=$tmpt;
			$param_tgl=$tgl_lahir;
			$param_alamat=$alamat;
			$param_kontak=$kontak;
			if($stmt->execute()):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->execute();
	}
	public function listAll_admClub(){

		if(isset($_POST['active'])):
			if($this->activeUser($this->post('status'))):
				$this->reload_time('1','admin club');
			else:
				$this->reload_time('1','admin club');
			endif;
		endif;
		if(isset($_POST['block'])):
			if($this->blockUser($this->post('status'))):
				$this->reload_time('1','admin club');
			else:
				$this->reload_time('1','admin club');
			endif;
		endif;

		$sql = "SELECT id_admclub, profile_admclub.id_user, profile_club.id_club, nama_club, nama_admclub, kontak_admin, status FROM profile_admclub INNER JOIN profile_club ON profile_admclub.id_club=profile_club.id_club INNER JOIN users ON profile_admclub.id_user=users.id_user";
		$perintah=$this->query($sql);
		return $perintah;
	}
	public function fetchAdm_club(){
		

		$this->no=1;
		$this->adm=$this->listAll_admClub();
		while($this->admrow=$this->adm->fetch_array()){
			
			echo'
			<tr>
			<td>'.$this->no.'</td>
			<td>'.$this->admrow['nama_admclub'].'</td>
			<td>'.$this->admrow['nama_club'].'</td>
			<td>'.$this->admrow['kontak_admin'].'</td>
			<td>
			
			<a class="btn btn-sm btn-primary" style="font-size:0.8em"  href="?page=edit admin club&id_user='.$this->id_club=$this->admrow['id_user'].'&club='.$this->admrow['nama_club'].'">Edit</a>
			<a class="btn btn-sm btn-danger" style="font-size:0.8em"  href="?page=delete admin club&id_user='.$this->id_club=$this->admrow['id_user'].'">Delete</a>
			';
			if($this->admrow['status']==0):
				echo'
					'.$this->formGeneral().'
						
						<input type="hidden" name="status" value="'.$this->admrow['id_user'].'">
						<button type="submit" name="active" class="mt-2 btn btn-sm btn-info" style="font-size:0.8em" title="aktifkan petugas">active</button>
					</form>
					';
			else:
				echo'
				'.$this->formGeneral().'
					<input type="hidden" name="status" value="'.$this->admrow['id_user'].'">
						<button type="submit" name="block" class="mt-2 btn btn-sm btn-danger" style="font-size:0.8em" title="block petugas">block</button>
				</form>
				';
			endif;
			echo'
			</td>
			</tr>

			';
			$this->no+=1;
		}

		$this->adm->free_result();
	
	}
	public function detail_adminClub($data)
	{
		$sql = "SELECT profile_admclub.id_user,id_club, nik, nama_user, foto_user, role, tempat_lahir, tgl_lahir, alamat, kontak_admin FROM profile_admclub INNER JOIN users ON profile_admclub.id_user = users.id_user WHERE profile_admclub.id_user=? ";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("s",$param_data);
			$param_data=$data;
			if($stmt->execute()):
				$stmt->store_result();
				$stmt->bind_result($this->id_user, $this->id_club, $this->nik, $this->nama_user, $this->foto_user, $this->role, $this->tempat_lahir, $this->tgl_lahir, $this->alamat, $this->kontak_admin);
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
	public function updateAdmin_club($id_club, $nama_admclub, $tempat_lahir, $tgl_lahir, $alamat, $kontak_admin, $data)
	{
		$sql="UPDATE profile_admclub SET id_club=?, nama_admclub=?, tempat_lahir=?, tgl_lahir=?, alamat=?, kontak_admin=? WHERE id_user=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("isssssi",$param_id, $param_nama, $param_tmpt, $param_tgl, $param_alm, $param_ktk, $data);

			$param_id=$id_club;
			$param_nama=$nama_admclub;
			$param_tmpt=$tempat_lahir;
			$param_tgl=$tgl_lahir;
			$param_alm=$alamat;
			$param_ktk=$kontak_admin;
			$param_data=$data;

			if($stmt->execute()):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();
	}
	public function deleteAdmin_club($data)
	{
		$sql="DELETE FROM profile_admclub WHERE id_user=?";
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
	public function shownameClub($data)
	{
		$sql="SELECT id_club, nama_club FROM profile_club WHERE id_club='$data'";
		$perintah=$this->query($sql);
		$this->nameClub1=$perintah->fetch_array();
		$this->rowname=$this->nameClub1['nama_club'];		
		return $this->rowname;
		return $perintah->free_result();
	}

/***************************
	CRUD CLUB
****************************/
	public function addClub ($nama, $alm, $ktk, $lgo, $file_item, $file_destinasi)
	{
		$sql="INSERT INTO profile_club(nama_club, alamat_club, kontak_club, logo_club) VALUES(?,?,?,?)";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("ssss",$param_nama, $param_alm, $param_ktk, $param_lgo);
			$param_nama=$nama;
			$param_alm=$alm;
			$param_ktk=$ktk;
			$param_lgo=$file_item;
			if($stmt->execute() && (move_uploaded_file($lgo, $file_destinasi.$file_item))):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();
	}
	public function fetchClub(){

		$this->no=1;
		$this->rowClub=$this->listAll_Club();
		while($this->rwClub=$this->rowClub->fetch_array()){
			
			echo'
			<tr>
			<td>'.$this->no.'</td>
			<td>'.$this->rwClub['nama_club'].'</td>
			<td>'.$this->rwClub['alamat_club'].'</td>
			<td>'.$this->rwClub['kontak_club'].'</td>
			<td>
			
			<a href="?page=edit club&id_club='.$this->id_club=$this->rwClub['id_club'].'"><i class="fas fa-fw fa-edit"></i></a>
			<a href="?page=pemain&id_club='.$this->id_club=$this->rwClub['id_club'].'"><i class="fas fa-fw fa-users"></i></a>
			<a href="../../app/export/export.pemain.club.php?id_club='.$this->rwClub['id_club'].'&club='.$this->rwClub['nama_club'].'" target="_blank"><i class="fas fa-fw fa-download"></i></a>
			<a href="?page=delete club&id_club='.$this->id_club=$this->rwClub['id_club'].'"><i class="fas fa-fw fa-trash"></i></a>

			</td>
			</tr>

			';
			$this->no+=1;
		}

		$this->rowClub->free_result();
	}
	public function fetchClub_option()
	{
		echo'<div class="form-group">
				<div class="input-group">
			        <div class="input-group-prepend">
			        	<div class="input-group-text">
			        		<i class="fas fa-fw fa-arrow-alt-circle-down"></i>
			        	</div>
			        </div>
			        	<select class="form-control" name="id_club" required="">

			        	';

			        		$this->option=$this->listAll_Club();
							while($this->rwClub=$this->option->fetch_array()){
								echo '

								<option value="'.$this->rwClub['id_club'].'">'.$this->rwClub['nama_club'].'</option>

								';	
							
								
							}
							$this->option->free_result();

			        	echo'
			        	</select>

			    </div>
			</div>';

	}
	public function fetchClub_option_edit()
	{
		echo'<div class="form-group">
				<div class="input-group">
			        <div class="input-group-prepend">
			        	<div class="input-group-text">
			        		<i class="fas fa-fw fa-arrow-alt-circle-down"></i>
			        	</div>
			        </div>
			        	<select class="form-control" name="id_club" required="">
			        		<option value="'.$this->id_club.'">'.$this->get('club').'</option>
			        	';

			        		$this->option=$this->listAll_Club();
							while($this->rwClub=$this->option->fetch_array()){
								echo '

								<option value="'.$this->rwClub['id_club'].'">'.$this->rwClub['nama_club'].'</option>

								';	
							
								
							}
							$this->option->free_result();

			        	echo'
			        	</select>

			    </div>
			</div>';

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
	public function editClub_proses($nama_club, $alamat_club, $kontak_club, $logo_club, $file_item, $file_destinasi, $data)
	{
		$sql = "UPDATE profile_club SET nama_club=?, alamat_club=?, kontak_club=?, logo_club=? WHERE id_club=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("ssssi",$param_nama, $param_alm, $param_ktk, $param_lgo, $param_data);
			$param_nama=$nama_club;
			$param_alm=$alamat_club;
			$param_ktk=$kontak_club;
			$param_lgo=$file_item;
			$param_data=$data;

			if(empty($_FILES['logo_club']['tmp_name'])){

					if($stmt->execute()):
						return true;
					else:
						return false;
					endif;
				}else{
					if($stmt->execute()&&(move_uploaded_file($logo_club,$file_destinasi.$file_item))):
						return true;
					else:

					return false;
				endif;
			}
		endif;
		$stmt->close();
	}

	public function deleteClub($data)
	{
		$sql="DELETE FROM profile_club WHERE id_club=?";
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
	public function paraPemain($data)
	{
		
		$sql="SELECT profile_club.id_club, profile_pemain.id_user, nama_club, nama_pemain, no_punggung_pemain, posisi_pemain, profile_pemain.nik, no_kk, tempat_lahir, tgl_lahir, tinggi_badan, berat_badan, golongan_darah, alamat,  kontak_pemain, status  FROM profile_club INNER JOIN profile_pemain ON profile_pemain.id_club=profile_club.id_club INNER JOIN users ON profile_pemain.id_user=users.id_user  WHERE profile_pemain.id_club='$data' LIMIT 20";
		$perintah=$this->query($sql);
		return $perintah;
	}
/***************************
	CRUD PEMAIN
****************************/
	public function addPemain($id_user, $id_club, $no_punggung,$posisi_pemain, $nama_pemain, $nik, $no_kk, $tempat_lahir, $tgl_lahir, $tinggi_badan, $berat_badan, $golongan_darah, $alamat, $kontak_pemain)
	{
		$sql="INSERT INTO profile_pemain(id_user, id_club, no_punggung_pemain, posisi_pemain, nama_pemain, nik, no_kk, tempat_lahir, tgl_lahir, tinggi_badan, berat_badan, golongan_darah, alamat, kontak_pemain) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("iissssssssssss",$param_id_user, $param_id_club, $param_no_punggung, $param_posisi_pemain, $param_nama_pemain, $param_nik, $param_no_kk, $param_tempat_lahir, $param_tgl_lahir, $param_tinggi_badan, $param_berat_badan, $param_golongan_darah, $param_alamat, $param_kontak_pemain);
			$param_id_user=$id_user;
			$param_id_club=$id_club;
			$param_no_punggung=$no_punggung;
			$param_posisi_pemain=$posisi_pemain;
			$param_nama_pemain=$nama_pemain;
			$param_nik=$nik;
			$param_no_kk=$no_kk;
			$param_tempat_lahir=$tempat_lahir;
			$param_tgl_lahir=$tgl_lahir;
			$param_tinggi_badan=$tinggi_badan;
			$param_berat_badan=$berat_badan;
			$param_golongan_darah=$golongan_darah;
			$param_alamat=$alamat;
			$param_kontak_pemain=$kontak_pemain;
			if($stmt->execute()):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();
	}
	public function addDokumen_pemain($data)
	{
		$sql="INSERT INTO dokumen_pemain(id_user) VALUES(?)";
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

	public function listAll_Pemain(){

		$sql = "SELECT id_pemain, profile_pemain.id_user, profile_club.id_club, nama_club, nama_pemain, no_punggung_pemain, posisi_pemain, profile_pemain.nik, no_kk, tempat_lahir, tgl_lahir, tinggi_badan, berat_badan, golongan_darah, alamat,  kontak_pemain, status FROM profile_pemain INNER JOIN profile_club ON profile_pemain.id_club=profile_club.id_club INNER JOIN users ON profile_pemain.id_user=users.id_user LIMIT 20";
		$perintah=$this->query($sql);
		return $perintah;
	}
	public function fetchPemain(){
		
		if(isset($_POST['active'])):
			if($this->activeUser($this->post('status'))):
				$this->reload_time('1','pemain');
			else:
				$this->reload_time('1','pemain');
			endif;
		endif;
		if(isset($_POST['block'])):
			if($this->blockUser($this->post('status'))):
				$this->reload_time('1','pemain');
			else:
				$this->reload_time('1','pemain');
			endif;
		endif;
		$this->no=1;


		if(!empty($_GET['id_club'])):

				$this->adm=$this->paraPemain($this->esc($this->get('id_club')));
				$this->jml_pemain = $this->adm->num_rows;
			else:

				$this->adm=$this->listAll_Pemain();
				$this->jml_pemain = $this->adm->num_rows;

		endif;

		while($this->admrow=$this->adm->fetch_array()){
			
			echo'
			<tr>
			<td>'.$this->no.'</td>
			<td>'.$this->admrow['nama_pemain'].'</td>
			<td>'.$this->admrow['kontak_pemain'].'</td>
			<td>'.$this->admrow['nama_club'].'</td>
			<td>
			
			<a href="?page=edit pemain&id_user='.$this->admrow['id_user'].'&club='.$this->admrow['nama_club'].'"><i class="fas fa-fw fa-edit"></i></a>
			
			<a href="?page=detail pemain&id_user='.$this->admrow['id_user'].'&club='.$this->admrow['nama_club'].'"><i class="fas fa-fw fa-eye"></i></a>

			<a href="../../app/pdf/print.pemain.php?id_user='.$this->admrow['id_user'].'&club='.$this->admrow['nama_club'].'" target="_blank"><i class="fas fa-fw fa-print"></i></a>

			<a href="?page=delete pemain&id_user='.$this->id_club=$this->admrow['id_user'].'"><i class="fas fa-fw fa-trash"></i></a>
			';
			if($this->admrow['status']==0):
				echo'
					'.$this->formGeneral().'
						
						<input type="hidden" name="status" value="'.$this->admrow['id_user'].'">
						<button type="submit" name="active" class="btn btn-sm btn-info" style="font-size:0.8em" title="aktifkan pemain">aktif</button>
					</form>
					';
			else:
				echo'
				'.$this->formGeneral().'
					<input type="hidden" name="status" value="'.$this->admrow['id_user'].'">
						<button type="submit" name="block" class="btn btn-sm btn-danger" style="font-size:0.8em" title="block pemain">block</button>
				</form>
				';
			endif;
			echo'

			</td>
			</tr>

			';
			$this->no+=1;
		}

		$this->adm->free_result();
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
	public function updatePemain($id_club, $no_punggung, $posisi_pemain, $nama_pemain, $no_kk, $tempat_lahir, $tgl_lahir, $tinggi_badan, $berat_badan, $golongan_darah, $alamat, $kontak_pemain, $data)
	{
		$sql="UPDATE profile_pemain SET id_club=?, no_punggung_pemain=?, posisi_pemain=?, nama_pemain=?, no_kk=?, tempat_lahir=?, tgl_lahir=?, tinggi_badan=?, berat_badan=?, golongan_darah=?, alamat=?, kontak_pemain=? WHERE id_user=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("isssssssssssi", $param_id, $param_no, $param_po, $param_na, $param_nok, $param_te, $param_tgl, $param_ti, $param_be, $param_go, $param_al, $param_ko, $param_data);
			$param_id=$id_club;
			$param_no=$no_punggung;
			$param_po=$posisi_pemain;
			$param_na=$nama_pemain;
			$param_nok=$no_kk;
			$param_te=$tempat_lahir;
			$param_tgl=$tgl_lahir;
			$param_ti=$tinggi_badan;
			$param_be=$berat_badan;
			$param_go=$golongan_darah;
			$param_al=$alamat;
			$param_ko=$kontak_pemain;
			$param_data=$data;
			if($stmt->execute()):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();
	}
	public function deletePemain($data)
	{
		$sql="DELETE FROM profile_pemain WHERE id_user=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("i",$param_data);
			$param_data=$data;
			if($stmt->execute()):
				return true;
			else:
				return false;
			endif;
		endif;

	}
	public function deleteDokumen_pemain($data)
	{
		$sql="DELETE FROM dokumen_pemain WHERE id_user=?";
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
/***************************
	CRUD SETTING 
****************************/
	public function siteInfo()
	{
		$sql="SELECT id_pengaturan, nama_situs, nama_aplikasi, nama_pengelola, deskripsi_situs, alamat_situs, status_situs, logo, favicon FROM pengaturan WHERE id_pengaturan=1";
		$perintah=$this->query($sql);
		return $perintah;
	}
	public function loadInfo()
	{
		$this->info=$this->siteInfo();
		$this->inf=$this->info->fetch_array();
		$this->id_pengaturan=$this->inf['id_pengaturan'];
		$this->nama_situs=$this->inf['nama_situs'];
		$this->nama_aplikasi=$this->inf['nama_aplikasi'];
		$this->nama_pengelola=$this->inf['nama_pengelola'];
		$this->deskripsi_situs=$this->inf['deskripsi_situs'];
		$this->alamat_situs=$this->inf['alamat_situs'];
		$this->status=$this->inf['status_situs'];
		$this->logo=$this->inf['logo'];
		$this->icon=$this->inf['favicon'];
		
		
	}
	public function updateSitus($nama_situs, $nama_aplikasi, $nama_pengelola, $deskripsi_situs, $alamat_situs, $status_situs, $data)
	{
		$sql="UPDATE pengaturan SET nama_situs=?, nama_aplikasi=?, nama_pengelola=?, deskripsi_situs=?, alamat_situs=?, status_situs=? WHERE id_pengaturan=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("ssssssi", $param_nama, $param_apl, $param_pengelola, $param_des, $param_alm, $param_stat, $param_data);
			$param_nama=$nama_situs;
			$param_apl=$nama_aplikasi;
			$param_pengelola=$nama_pengelola;
			$param_des=$deskripsi_situs;
			$param_alm=$alamat_situs;
			$param_stat=$status_situs;
			$param_data=$data;
			if($stmt->execute()):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();
	}
	public function updateLogo($logo, $item_logo, $item_destination, $data)
	{
		$sql = "UPDATE pengaturan SET logo=? WHERE id_pengaturan=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("si",$param_logo, $param_data);
			$param_logo=$item_logo;			
			$param_data=$data;
			if(empty($_FILES['logo']['tmp_name'])){

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
	public function updateIcon($icon, $item_icon, $item_destination, $data)
	{
		$sql = "UPDATE pengaturan SET favicon=? WHERE id_pengaturan=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("si",$param_icon, $param_data);
			$param_icon=$item_icon;			
			$param_data=$data;
			if(empty($_FILES['icon']['tmp_name'])){

					if($stmt->execute()):
						return true;
					else:
						return false;
					endif;
				}else{
					if($stmt->execute()&&(move_uploaded_file($icon,$item_destination.$item_icon))):
						return true;
					else:

					return false;
				endif;
			}
		endif;
		$stmt->close();
	}
/***************************
	CRUD BERITA
****************************/

	public function showBerita()
	{
		$sql="SELECT * FROM berita";
		$perintah=$this->query($sql);
		return $perintah;
	}
	public function limitBerita()
	{
		$this->halaman = 5;         
	    $this->page = isset($_GET['halaman'])? (int)$_GET["halaman"]:1;    
	    $mulai = ($this->page>1) ? ($this->page * $this->halaman) - $this->halaman : 0;
		$sql="SELECT * FROM berita ORDER by id_berita desc LIMIT $mulai, ".$this->halaman."";
		$perintah=$this->query($sql);
		return $perintah;
	}
	public function insertBerita($judul, $isi, $kategori, $status, $penulis, $gambar, $tanggal, $item_gambar, $destinasi)
	{
		$sql="INSERT INTO berita(judul_berita, isi_berita, kategori_berita, status_berita, penulis_berita, gambar_berita, tanggal_berita) VALUES (?,?,?,?,?,?,?)";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("sssssss",$param_judul, $param_isi, $param_kategori, $param_status, $param_penulis, $param_gambar, $param_tanggal);
			
			$param_judul=$judul;
			$param_isi=$isi;
			$param_kategori=$kategori;
			$param_status=$status;
			$param_penulis=$penulis;
			$param_gambar=$item_gambar;
			$param_tanggal=$tanggal;

			if($stmt->execute() && (move_uploaded_file($gambar, $destinasi.$item_gambar))):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();

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
	public function updateBerita($judul, $isi, $kategori, $status, $penulis, $gambar, $tanggal, $item_gambar, $destinasi, $data)
	{
		$sql="UPDATE berita SET judul_berita=?, isi_berita=?, kategori_berita=?, status_berita=?, penulis_berita=?, gambar_berita=?, tanggal_berita=? WHERE id_berita=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("sssssssi",$param_judul, $param_isi, $param_kategori, $param_status, $param_penulis, $param_gambar, $param_tanggal, $param_data);
			$param_judul=$judul;
			$param_isi=$isi;
			$param_kategori=$kategori;
			$param_status=$status;
			$param_penulis=$penulis;
			$param_gambar=$item_gambar;
			$param_tanggal=$tanggal;
			$param_data=$data;
			if(empty($_FILES['gambar']['tmp_name'])){
				if($stmt->execute()):
					return true;
				else:
					return false;
				endif;
			}else{
				if($stmt->execute()&& (move_uploaded_file($gambar, $destinasi.$item_gambar))):
					return true;
				else:
					return false;
				endif;

			}
		endif;
		$stmt->close();

	}
	public function deleteBerita($data)
	{
		$sql="DELETE FROM berita WHERE id_berita=?";
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
	public function showKategori()
	{
		$sql="SELECT id_kategori, kategori_berita FROM berita_kategori";
		$perintah=$this->query($sql);
		return $perintah;
	}
	public function insertKategori($data)
	{
		$sql="INSERT INTO berita_kategori (kategori_berita) VALUES (?)";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("s",$param_data);
			$param_data=$data;
			if($stmt->execute()):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();
	}
	public function detailKategori($data)
	{
		$sql="SELECT id_kategori FROM berita_kategori WHERE id_kategori=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("i",$param_data);
			$param_data=$data;
			if($stmt->execute()):
				$stmt->store_result();
				$stmt->bind_result($this->id_kategori);
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

	public function deleteKategori($data)
	{
		$sql="DELETE FROM berita_kategori WHERE id_kategori=?";
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
/***************************
	CRUD PAGES
****************************/
	public function insertPages($judul, $isi, $penulis)
	{
		$sql="INSERT INTO pages(judul_pages, isi_pages, penulis_pages) VALUES(?,?,?)";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("sss",$judul, $isi, $penulis);
			if($stmt->execute()):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();
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
	public function updatePages($judul, $isi, $penulis, $data)
	{
		$sql="UPDATE pages SET judul_pages=?, isi_pages=?, penulis_pages=? WHERE id_pages=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("sssi",$param_a, $param_b, $param_c, $param_d);
			$param_a=$judul;
			$param_b=$isi;
			$param_c=$penulis;
			$param_d=$data;
			if($stmt->execute()):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();
	}
	public function deletePages($data)
	{
		$sql="DELETE FROM pages WHERE id_pages=?";
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
	public function pages()
	{
		$sql="SELECT * FROM pages";
		$perintah = $this->query($sql);
		return $perintah;
	}
	public function limitPages()
	{
		$this->halaman = 5;         
	    $page = isset($_GET['halaman'])? (int)$_GET["halaman"]:1;    
	    $mulai = ($page>1) ? ($page * $this->halaman) - $this->halaman : 0;
		$sql="SELECT * FROM pages ORDER by id_pages desc LIMIT $mulai, ".$this->halaman."";
		$perintah=$this->query($sql);
		return $perintah;
	}
/***************************
	BLOCK OR ACTIVATED USER
****************************/
	public function activeUser($data)
	{
		$sql="UPDATE users SET status=? WHERE id_user=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("ii",$param_status, $param_data);
			$param_status=1;
			$param_data=$data;
			if($stmt->execute()):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();
		

	}
	public function blockUser($data)
	{
		$sql="UPDATE users SET status=? WHERE id_user=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("ii",$param_status, $param_data);
			$param_status=0;
			$param_data=$data;
			if($stmt->execute()):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();
		

	}
/***************************
	CRUD SETTING MENU
****************************/
	public function showMenu()
	{
		$sql="SELECT * FROM menu WHERE kategori_menu='single_menu' OR kategori_menu='dropdown_menu' ORDER by urut asc";
		$perintah=$this->query($sql);
		return $perintah;
	}
	public function showMenu_bysubMenu($data)
	{
		$sql="SELECT * FROM menu WHERE kategori_menu='sub_menu' AND parent='$data'";
		$perintah=$this->query($sql);
		return $perintah;
	}
	public function showMenu_dropdownMenu()
	{
		$sql="SELECT * FROM menu WHERE kategori_menu='dropdown_menu'";
		$perintah = $this->query($sql);
		return $perintah;
	}
	public function addMenu($nama, $kategori, $link, $urut)
	{
		$sql="INSERT INTO menu (nama_menu, kategori_menu, link_menu, urut) VALUES(?,?,?,?)";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("sssi",$param_nama, $param_kat, $param_link, $param_urut);
			$param_nama=$nama;
			$param_kat=$kategori;
			$param_link=$link;
			$param_urut=$urut;
			if($stmt->execute()):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();
	}
	public function add_subMenu($nama, $kategori, $parent, $link, $urut)
	{
		$sql="INSERT INTO menu (nama_menu, kategori_menu, link_menu, urut, parent) VALUES(?,?,?,?,?)";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("sssii",$param_nama, $param_kat, $param_link, $param_urut, $param_parent);
			$param_nama=$nama;
			$param_kat=$kategori;
			$param_link=$link;
			$param_urut=$urut;
			$param_parent=$parent;
			if($stmt->execute()):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();
	}
	public function detailMenu($data)
	{
		$sql="SELECT id_menu, nama_menu, kategori_menu, link_menu, urut, parent FROM menu WHERE id_menu=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("i",$param_data);
			$param_data=$data;
			if($stmt->execute()):
				$stmt->store_result();
				$stmt->bind_result($this->id_menu, $this->nama_menu, $this->kategori_menu, $this->link_menu, $this->urut, $this->parent);
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
	public function updateMenu($nama, $kategori, $link, $urut, $parent, $data)
	{
		$sql="UPDATE menu SET nama_menu=?, kategori_menu=?, link_menu=?, urut=?, parent=? WHERE id_menu=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("sssiii",$param_nama, $param_kategori, $param_link, $param_urut, $param_parent, $param_data);
			$param_nama=$nama;
			$param_kategori=$kategori;
			$param_link=$link;
			$param_urut=$urut;
			$param_parent=$parent;
			$param_data=$data;
			if($stmt->execute()):
				return true;
			else:
				return false;
			endif;
		endif;
		$stmt->close();
	}
	public function deleteMenu($data)
	{
		$sql="DELETE FROM menu WHERE id_menu=?";
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
	public function deleteSubmenu($data)
	{
		$sql="DELETE FROM menu WHERE parent=?";
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
/***************************
	OPERATION BY SESSION
****************************/

	public function updateProfile($nik, $pass, $role, $nama, $foto, $item_foto, $item_destination, $data)
	{
		#Update with session
		$sql = "UPDATE users SET nik=?, password=?, role=?, nama_user=?, foto_user=? WHERE id_user=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("sssssi",$param_n, $param_p, $param_r, $param_na, $param_f, $param_data);
			$param_n=$nik;
			$param_p=password_hash($pass, PASSWORD_DEFAULT);
			$param_r=$role;
			$param_na=$nama;
			$param_f=$item_foto;
			$param_data=$data;
			if(empty($_FILES['foto_user']['tmp_name'])){

					if($stmt->execute()):
						return true;
					else:
						return false;
					endif;
				}else{
					if($stmt->execute()&&(move_uploaded_file($foto,$item_destination.$item_foto))):
						return true;
					else:

					return false;
				endif;
			}
		endif;
		$stmt->close();
	}
	public function shownameClub_session($data)
	{
		if(!empty($data)):
			$sql="SELECT id_club, nama_club, alamat_club, kontak_club, logo_club FROM profile_club WHERE id_club='$data'";
			$perintah=$this->query($sql);
			$this->nameClub=$perintah->fetch_array();					
			return $this->nameClub;
			return $perintah->free_result();
		endif;
	}
	public function listAll_Pemain_session($data)
	{
		if(!empty($data)):
			$sql = "SELECT id_pemain, profile_pemain.id_user, profile_club.id_club, nama_club, nama_pemain, no_punggung_pemain, posisi_pemain, profile_pemain.nik, no_kk, tempat_lahir, tgl_lahir, tinggi_badan, berat_badan, golongan_darah, alamat,  kontak_pemain, status FROM profile_pemain INNER JOIN profile_club ON profile_pemain.id_club=profile_club.id_club INNER JOIN users ON profile_pemain.id_user=users.id_user WHERE profile_club.id_club='$data'";
			$perintah=$this->query($sql);
			return $perintah;
		endif;
	}
	
}

