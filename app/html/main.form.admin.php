<?php

class main_Admin extends adminOperation
{
/***************************
	HTML ADMNISTRATOR
****************************/
	
	public function form_addUser()
	{
		//administrator add user
	
		$nik_err = $nama_err = $pass_err = $pass_kon_err = $role_err = $foto_err ="";
		if($_SERVER['REQUEST_METHOD']=='POST'):
			
				if(empty($this->post('nik'))){
					$nik_err = "Masukan nik dengan benar";
				}elseif($this->validateNumber($this->post('nik'))){
					$nik_err = "No NIK hanya boleh berupa angka";
				}elseif(strlen($this->post('nik'))!=16){
					$nik_err = "No NIK harus 16 digit";
				}
				else{
					#Cek tanpa session				
					if($this->cekNik($this->post('nik'))):
						$nik_err = "Maaf NIK tersebut sudah digunakan";
					else:
						$nik=$this->post('nik');
						$nik=$this->esc($nik);
					endif;
					
				}

				if(empty($this->post('nama_depan') || $this->post('nama_belakang'))){
					$nama_err = "Nama depan dan belakang wajib diisi";
				}elseif($this->validateName('nama_depan')|| $this->validateName('nama_belakang')){
					$nama_err = "Hanya boleh diisi dengan karakter alphabet";
				}else{
					$nama_lengkap = $this->post('nama_depan').' '.$this->post('nama_belakang');
					$nama_lengkap = $this->esc($nama_lengkap);
				}
				if(empty($this->post('password'))){
					$pass_err = "Masukan sebuah password";
				}elseif(strlen($this->post('password'))<5){
					$pass_err = "Password tidak boleh kurang dari 5 karakter";
				}else{
					$password = trim($_POST['password']);
					 
				}				
				if(empty(trim($_POST['confir_password']))){
					$pass_kon_err="Masukan konfirmasi password";
				}else{
					$confir_password=trim($_POST['confir_password']);
					if(empty($pass_err) && ($confir_password!=$password)):
						$pass_kon_err="Konfirmasi password tidak cocok";
					endif;
				}
				if(empty($this->post('role'))){
					$role_err = "Role user harus dipilih";
				}else{
					$role = $this->post('role');
					$role = $this->esc($role);
					
				}		

		      	$this->getImage2('foto_user','../../content/foto/administrator/',$role);

		      	if(in_array($this->file_extension, $this->file_valid)){
					if($this->file_size>300000){
					    $foto_err="Ukuran foto tidak boleh lebih dari 300KB";
					   }else{
					    $foto_user=$this->file_dir;
					}
				}else{
					$foto_err="Wajib diisi dengan format JPG, JPEG, atau PNG";
				}
				
				if(empty($nama_err) && empty ($pass_err) && empty ($pass_kon_err) && empty ($nik_err) && empty ($foto_err)){
					if($role!=='administrator'):
						die("Error : ROle tidak boleh dimanipulasi");
					else:
						if($this->addUser($nik, $password, $role, $nama_lengkap, $foto_user, $this->file_foto, $this->file_destinasi)):
							$this->alert('success','Data berhasil disimpan');
							$this->reload_time('3','administrator');
						else:
							$this->alert('danger','Data gagal disimpan');
						endif;
					endif;
				}
			
		endif;
		$this->formFile();	
		$this->card('Buat Akun');
		echo'	    
		
	        '.$this->formGroup('key', 'text', 'nik', "Masukan nik",$nik_err).'	       
	        <div class="form-group row">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			    	 '.$this->formGroup('user', 'text', 'nama_depan', "Masukan nama depan",$nama_err).'
			    </div>
				<div class="col-sm-6">
					 '.$this->formGroup('user', 'text', 'nama_belakang', "Masukan nama belakang",$nama_err).'
					
			    </div>			                  
			</div>
			               
			<div class="form-group row mt-4">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			    	 '.$this->formGroup('key', 'password', 'password', "Masukan password",$pass_err).'
			    </div>
			    <div class="col-sm-6">
			    	 '.$this->formGroup('key', 'password', 'confir_password', "Masukan konfirmasi password",$pass_kon_err).'
			    </div>
			</div>
			<fieldset disabled>
				 '.$this->formGroup('users', 'text', 'role', "administrator",$role_err).'
			</fieldset>
			<input type="hidden" class="form-control" name="role" value="administrator">			
			'.$this->formGroup_file('file','foto_user',$foto_err).'
			'.$this->formGroup_button('btn-primary', 'btn-md', 'save','Simpan').'          
			
		
	    
	    </div>
        </div>
        </form>

 	

		';
	}
	public function dataAdministrator()
	{
		echo
		'
		 <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>NIK</th>
                      <th>NAMA USER</th>    
                   
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>NIK</th>
                      <th>NAMA USER</th>                   
                    </tr>
                  </tfoot>
                  <tbody>
	              ';
	              	$this->fetchAdministrator();

	              echo
	              '
                   
                  </tbody>
                </table>
              </div>

		';
	}
	public function administrator()
	{
		$this->alert('info','Halaman ini menampilkan daftar Administrator pengelola situs');	
		$this->card('Data Administrator');
		echo'<a class="btn-md btn-primary btn-sm mb-3 float-left" href="?page=buat akun admin"> <i class="fas fa-fw fa-plus"></i> Baru</a>';
		$this->dataAdministrator();
        echo'
		</div>
		</div>
	

		';
	}
	
/***************************
	HTML PETUGAS
****************************/
	public function form_addPetugas()
	{
		$nik_err = $nama_err = $tempat_lahir_err = $tgl_err = $alm_err = $pass_err = $pass_kon_err = $role_err = $foto_err = $id_club_err = $kontak_err = "";
		if($_SERVER['REQUEST_METHOD']=='POST'):
			
				if(empty($this->post('nik'))){
					$nik_err = "Masukan nik dengan benar";
				}elseif($this->validateNumber($this->post('nik'))){
					$nik_err = "No NIK hanya boleh berupa angka";
				}elseif(strlen($this->post('nik'))!=16){
					$nik_err = "No NIK harus 16 digit";
				}
				else{
					#Cek tanpa session				
					if($this->cekNik($this->post('nik'))):
						$nik_err = "Maaf NIK tersebut sudah digunakan";
					else:
						$nik=$this->post('nik');
						$nik=$this->esc($nik);
					endif;
					
				}

				if(empty($this->post('nama_depan') || $this->post('nama_belakang'))){
					$nama_err = "Nama depan dan belakang wajib diisi";
				}elseif($this->validateName('nama_depan')|| $this->validateName('nama_belakang')){
					$nama_err = "Hanya boleh diisi dengan karakter alphabet";
				}else{
					$nama_lengkap = $this->post('nama_depan').' '.$this->post('nama_belakang');
					$nama_lengkap = $this->esc($nama_lengkap);
				}

				if(empty($this->post('tempat_lahir'))){
					$tempat_lahir_err = "Masukan tempat lahir Anda";
				}else{

					$tempat_lahir=$this->post('tempat_lahir');
					$tempat_lahir=$this->esc($tempat_lahir);
				}

				if(empty($this->post('tgl_lahir'))){
					$tgl_err='tanggal lahir masih kosong';	
				}elseif(strlen($this->post('tgl_lahir'))!=10){
					$tgl_err='Format penulisan tanggal lahir lahir salah';	
				}elseif($this->CekTLS_tanggal($this->post('tgl_lahir'))){
					$tgl_err='Format penulisan tanggal lahir salah. Harus Tgl-Bln-Thn';
				}
				else{
					
					if(!$this->BCA_tanggal($this->post('tgl_lahir'))):
						$tgl_err='Format penulisan tanggal lahir salah. Contoh misal 30-07-1993';
					else:
						$tanggal_lahir=$this->post('tgl_lahir');
						$tanggal_lahir=$this->esc($tanggal_lahir);
					endif;			
				}

				if(empty($this->post('jln_dsn')||$this->post('rt') || $this->post('rw') || $this->post('desa') || $this->post('kec') || $this->post('kab'))){

					$alm_err = "Alamt lengkap wajib diisi";

				}else{
					$alamat = 'Dusun/Jln. '.$this->post('jln_dsn').' RT '.$this->post('rt').' RW '.$this->post('rw').' Desa '.$this->post('desa').' Kec. '.$this->post('kec').' Kab.'.$this->post('kab');
					$alamat = $this->esc($alamat);
					
				}
				if(empty($this->post('kontak'))){
					$kontak_err = "Kontak admin club wajib diisi";
				}elseif($this->validateNumber($this->post('kontak'))){
					$kontak_err = "Harap isi nomor kontak dengan benar, hanya karakter angka yang diperbolehkan";
				}else{
					$kontak = $this->post('kontak');
					$kontak = $this->esc($kontak);
				}

				if(empty($this->post('password'))){
					$pass_err = "Masukan sebuah password";
				}elseif(strlen($this->post('password'))<5){
					$pass_err = "Password tidak boleh kurang dari 5 karakter";
				}else{
					$password = trim($_POST['password']);
					 
				}				
				if(empty(trim($_POST['confir_password']))){
					$pass_kon_err="Masukan konfirmasi password";
				}else{
					$confir_password=trim($_POST['confir_password']);
					if(empty($pass_err) && ($confir_password!=$password)):
						$pass_kon_err="Konfirmasi password tidak cocok";
					endif;
				}
				
				if(empty($this->post('role'))){
					$role_err = "Role user harus dipilih";
				}else{
					$role = $this->post('role');
					$role = $this->esc($role);
					
				}		

		      	$this->getImage2('foto_user','../../content/foto/petugas/',$role);

		      	if(in_array($this->file_extension, $this->file_valid)){
					if($this->file_size>300000){
					    $foto_err="Ukuran foto tidak boleh lebih dari 300KB";
					   }else{
					    $foto_user=$this->file_dir;
					}
				}else{
					$foto_err="Wajib diisi dengan format JPG, JPEG, atau PNG";
				}
				
				if(empty($nama_err) && empty ($pass_err) && empty ($pass_kon_err) && empty ($nik_err) && empty ($foto_err) && empty($kontak_err) && empty($alm_err) && empty($tempat_lahir_err) && empty($tgl_err) && empty($role_err)){
					if($role!=='petugas'):

						die("Error");
						
					else:

						if($this->addUser($nik, $password, $role, $nama_lengkap, $foto_user, $this->file_foto, $this->file_destinasi) && $this->addPetugas($this->koneksi->insert_id, $nama_lengkap, $tempat_lahir, $tanggal_lahir, $alamat, $kontak)):

							$this->alert('success','Data berhasil disimpan');
							$this->reload_time('3','petugas');
						else:
							$this->alert('danger','Data gagal disimpan');
						endif;
					endif;

				}
			
		endif;
		$this->alert('info','Silahkan isi data petugas baru yang akan ditambahkan');
		$this->formFile();
		$this->card('Tambah Petugas');	
	
		echo'	    

	       '.$this->formGroup('key', 'text', 'nik', "Masukan NIK 16 Digit",$nik_err).'
			<div class="form-group row">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			       '.$this->formGroup('user', 'text', 'nama_depan', "Masukan nama depan anda",$nama_err).'
			    </div>
				<div class="col-sm-6">
					'.$this->formGroup('user', 'text', 'nama_belakang', "Masukan nama belakang anda",$nama_err).'
			    </div>			                  
			</div>

			<div class="form-group row">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			        '.$this->formGroup('calendar', 'text', 'tempat_lahir', "Masukan tempat lahir anda",$tempat_lahir_err).'
			    </div>
				<div class="col-sm-6">
					'.$this->formGroup_datepicker('calendar', 'text', 'tgl_lahir', "30-07-1993",'tanggal',$tgl_err).'
			    </div>			                  
			</div>

			<div class="form-group row">

			    <div class="col-sm-4 mb-3 mb-sm-0">			    	
			        '.$this->formGroup('map', 'text', 'jln_dsn', "Nama jalan/dusun",NULL).'			           
			    </div>
			    <div class="col-sm-2">
					'.$this->formGroup('map', 'text', 'rt', "RT",NULL).'
			
			    </div>	
			    <div class="col-sm-2">
					'.$this->formGroup('map', 'text', 'rw', "RW",NULL).'
			
			    </div>
				<div class="col-sm-4">
					'.$this->formGroup('map', 'text', 'desa', "Desa",NULL).'
			
			    </div>			                  
			</div>
			<div class="form-group row">
				<div class="col-sm-6 mb-3 mb-sm-0">			    	
			       '.$this->formGroup('map', 'text', 'kec', "Kecamatan",NULL).'    
			    </div>
			    <div class="col-sm-6 mb-3 mb-sm-0">			    	
			        '.$this->formGroup('map', 'text', 'kab', "Kabupaten",NULL).'       
			    </div>
			</div>
			               
			<div class="form-group row mt-4">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			    	 '.$this->formGroup('key', 'password', 'password', "Masukan password",$pass_err).'
			    </div>
			    <div class="col-sm-6">
			    	 '.$this->formGroup('key', 'password', 'confir_password', "Masukan konfirmasi password",$pass_kon_err).'
			    </div>
			</div>
			'.$this->formGroup('phone', 'text', 'kontak', "Masukan telephone/whatsapp petugas",$kontak_err).'
			<input type="hidden" name="role" value="petugas">';
			

			echo'
			'.$this->formGroup_file('file','foto_user',$foto_err).'		             
			
			'.$this->formGroup_button('btn-primary', 'btn-md', 'save','Simpan').' 
	    
	    </div>
        </div>
          </form>

        ';  
	}
	public function dataPetugas()
	{
		
		echo
		'
		 <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Petugas</th>
                      <th>Kontak</th>                  
                      <th>Aksi</th>
                   
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Nama Petugas</th>
                      <th>Kontak</th>                    
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody>
	              ';
	              	$this->fetchPetugas();

	              echo
	              '
                   
                  </tbody>
                </table>
              </div>
              

		';
	}
	public function Petugas()
	{
		$this->alert('info','Halaman untuk pengaturan petugas yang terdaftar. Silahkan untuk menambah petugas baru, mengedit atau menghapus petugas di halaman ini');	
		$this->card('Pengaturan Petugas');
		echo'<a class="btn-md btn-primary btn-sm mb-3 float-left" href="?page=buat akun petugas"> <i class="fas fa-fw fa-plus"></i> Baru</a>';
		$this->dataPetugas();
        echo'
		</div>
		</div>
	

		';
	}
	public function editPetugas()
	{
		if(!$this->detailPetugas($this->get('id_user'))) die($this->alert('danger','Error : id user not found'));

		$nik_err = $nama_err = $tempat_lahir_err = $tgl_err = $alm_err = $pass_err = $pass_kon_err = $role_err = $foto_err = $kontak_err = "";
		if($_SERVER['REQUEST_METHOD']=='POST'):
			
				if(empty($this->post('nik'))){
					$nik_err = "Masukan nik dengan benar";
				}elseif($this->validateNumber($this->post('nik'))){
					$nik_err = "No NIK hanya boleh berupa angka";
				}elseif(strlen($this->post('nik'))!=16){
					$nik_err = "No NIK harus 16 digit";
				}else{
					if($this->post('nik')!=$this->nik):
	                    if($this->cekNik($this->post('nik'))){
	                        $nik_err="Maaf nik tersebut sudah digunakan";
	                    }else{
	                        $nik=$this->post('nik');
	                        $nik=$this->esc($nik);
	                    }
                	else:
	                  $nik=$this->post('nik');
	                  $nik=$this->esc($nik);
	                endif;
				}				

				if(empty($this->post('nama_lengkap'))){
					$nama_err = "Nama lengkap wajib diisi";
				}elseif($this->validateName('nama_lengkap')){
					$nama_err = "Hanya boleh diisi dengan karakter alphabet";
				}else{
					$nama_lengkap = $this->post('nama_lengkap');
					$nama_lengkap = $this->esc($nama_lengkap);
				}

				if(empty($this->post('tempat_lahir'))){
					$tempat_lahir_err = "Masukan tempat lahir Anda";
				}else{

					$tempat_lahir=$this->post('tempat_lahir');
					$tempat_lahir=$this->esc($tempat_lahir);
				}

				if(empty($this->post('tgl_lahir'))){
					$tgl_err='tanggal lahir masih kosong';	
				}elseif(strlen($this->post('tgl_lahir'))!=10){
					$tgl_err='Format penulisan tanggal lahir lahir salah';	
				}elseif($this->CekTLS_tanggal($this->post('tgl_lahir'))){
					$tgl_err='Format penulisan tanggal lahir salah. Harus Tgl-Bln-Thn';
				}
				else{
					
					if(!$this->BCA_tanggal($this->post('tgl_lahir'))):
						$tgl_err='Format penulisan tanggal lahir salah. Contoh misal 30-07-1993';
					else:
						$tanggal_lahir=$this->post('tgl_lahir');
						$tanggal_lahir=$this->esc($tanggal_lahir);
					endif;			
				}

				if(empty($this->post('alamat'))){

					$alm_err = "Alamat lengkap wajib diisi";

				}else{
					$alamat = $this->post('alamat');
					$alamat = $this->esc($alamat);
					
				}
				if(empty($this->post('kontak'))){
					$kontak_err = "Kontak admin club wajib diisi";
				}elseif($this->validateNumber($this->post('kontak'))){
					$kontak_err = "Harap isi nomor kontak dengan benar, hanya karakter angka yang diperbolehkan";
				}else{
					$kontak = $this->post('kontak');
					$kontak = $this->esc($kontak);
				}

				if(empty($this->post('password'))){
					$pass_err = "Masukan sebuah password";
				}elseif(strlen($this->post('password'))<5){
					$pass_err = "Password tidak boleh kurang dari 5 karakter";
				}else{
					$password = trim($_POST['password']);
					 
				}				
				if(empty(trim($_POST['confir_password']))){
					$pass_kon_err="Masukan konfirmasi password";
				}else{
					$confir_password=trim($_POST['confir_password']);
					if(empty($pass_err) && ($confir_password!=$password)):
						$pass_kon_err="Konfirmasi password tidak cocok";
					endif;
				}
			
				if(empty($this->post('role'))){
					$role_err = "Role user harus dipilih";
				}else{
					$role = $this->post('role');
					$role = $this->esc($role);
					
				}		

		      	if(empty($_FILES['foto_user']['tmp_name'])):
					$foto_user=$this->foto_user;
					$this->file_foto=$this->foto_user;
					$this->file_destinasi="";
				else:
					$this->getImage2('foto_user','../../content/foto/petugas/','petugas');
					if(in_array($this->file_extension, $this->file_valid)){
							if($this->file_size>600000){
							    $foto_err="Ukuran foto tidak boleh lebih dari 600KB";
							   }else{
							    $foto_user=$this->file_dir;
							}
					}else{
						$lgo_err="Wajib diisi dengan format JPG, JPEG, atau PNG";
					}
				endif;
				
				if(empty($nama_err) && empty ($pass_err) && empty ($pass_kon_err) && empty ($nik_err) && empty ($foto_err) && empty($kontak_err) && empty($alm_err) && empty($tempat_lahir_err) && empty($tgl_err) && empty($role_err)){
					if($role!=='petugas'):

						die("Error");
						
					else:

						if($this->updateUser($nik, $password, $role, $nama_lengkap, $foto_user, $this->file_foto, $this->file_destinasi, $this->id_user) && $this->updatePetugas($nama_lengkap, $tempat_lahir, $tanggal_lahir, $alamat, $kontak, $this->id_user)):

							$this->alert('success','Data berhasil disimpan');
							$this->reload_time('1','petugas');
						else:
							$this->alert('danger','Data gagal disimpan');
						endif;
					endif;

				}
			
		endif;
		$this->alert('info','Silhkan edit bagian data yang ingin dirubah saja');
		$this->formFile();
		$this->card('Edit Petugas');	
	
		echo'	    

	       '.$this->formGroup_edit('key', 'text', 'nik', "Masukan NIK 16 Digit", $this->nik, $nik_err).'
			'.$this->formGroup_edit('user', 'text', 'nama_lengkap', "Masukan nama lengkap",$this->nama_user, $nama_err).'

			<div class="form-group row">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			        '.$this->formGroup_edit('calendar', 'text', 'tempat_lahir', "Masukan tempat lahir anda",$this->tempat_lahir, $tempat_lahir_err).'
			    </div>
				<div class="col-sm-6">
					'.$this->formGroup_datepicker_edit('calendar', 'text', 'tgl_lahir', "30-07-1993",'tanggal',$this->tgl_lahir,$tgl_err).'
			    </div>			                  
			</div>

			'.$this->formGroup_Textarea_edit('alamat', 'Masukan alamat secara lengkap', $this->alamat, $alm_err).'      
			<div class="form-group row mt-4">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			    	 '.$this->formGroup('key', 'password', 'password', "Masukan password",$pass_err).'
			    </div>
			    <div class="col-sm-6">
			    	 '.$this->formGroup('key', 'password', 'confir_password', "Masukan konfirmasi password",$pass_kon_err).'
			    </div>
			</div>
			'.$this->formGroup_edit('phone', 'text', 'kontak', "Masukan telephone/whatsapp admin", $this->kontak_petugas, $kontak_err).'
			<input type="hidden" name="role" value="petugas">';		

			echo'
			'.$this->formGroup_file('file','foto_user',$foto_err).'	

			<div class="form-group">
	   		 '.$this->getDirImage2('../../content/foto/petugas/',$this->foto_user).'
	   		</div>	             
			
			'.$this->formGroup_button('btn-primary', 'btn-md', 'save','Simpan').' 
	    
	    </div>
        </div>
          </form>

        ';  
	}
	public function form_deletePetugas()
	{
		if(!$this->detailPetugas($this->get('id_user'))) die($this->alert('danger','Error : id user not found'));

		$this->alert('danger','Apakah anda yakin ingin menghapus data ini ?');

		if($_SERVER['REQUEST_METHOD']=='POST'):

			if($this->getImage_unlink('../../content/foto/'.$this->role.'/', $this->foto_user)){
				if($this->deletePetugas($this->id_user) && $this->deleteUser($this->id_user)):
					$this->alert('success','Data berhasil dihapus');
					$this->reload_time('3','petugas');
				else:
					$this->alert('danger','Data gagal dihapus');
				endif;
			}else{
				$this->alert('danger','Terjadi kesalahan, foto gagal dihapus');
			}
		endif;	
		$this->formGeneral();
		$this->card('Hapus user');
		echo $this->formGroup_button('btn-danger', 'btn-md', 'trash','Hapus');		
		echo '</div></div></form>';

	}	
/***************************
	HTML ADMINCLUB
****************************/
	public function form_addAdm_club()
	{
	
		$nik_err = $no_punggung_err = $posisi_err = $nama_err = $tempat_lahir_err = $tgl_err = $alm_err = $pass_err = $pass_kon_err = $role_err = $foto_err = $id_club_err = $kontak_err = "";
		if($_SERVER['REQUEST_METHOD']=='POST'):
			
				if(empty($this->post('nik'))){
					$nik_err = "Masukan nik dengan benar";
				}elseif($this->validateNumber($this->post('nik'))){
					$nik_err = "No NIK hanya boleh berupa angka";
				}elseif(strlen($this->post('nik'))!=16){
					$nik_err = "No NIK harus 16 digit";
				}
				else{
					#Cek tanpa session				
					if($this->cekNik($this->post('nik'))):
						$nik_err = "Maaf NIK tersebut sudah digunakan";
					else:
						$nik=$this->post('nik');
						$nik=$this->esc($nik);
					endif;
					
				}

				if(empty($this->post('nama_depan') || $this->post('nama_belakang'))){
					$nama_err = "Nama depan dan belakang wajib diisi";
				}elseif($this->validateName('nama_depan')|| $this->validateName('nama_belakang')){
					$nama_err = "Hanya boleh diisi dengan karakter alphabet";
				}else{
					$nama_lengkap = $this->post('nama_depan').' '.$this->post('nama_belakang');
					$nama_lengkap = $this->esc($nama_lengkap);
				}

				if(empty($this->post('tempat_lahir'))){
					$tempat_lahir_err = "Masukan tempat lahir Anda";
				}else{

					$tempat_lahir=$this->post('tempat_lahir');
					$tempat_lahir=$this->esc($tempat_lahir);
				}

				if(empty($this->post('tgl_lahir'))){
					$tgl_err='tanggal lahir masih kosong';	
				}elseif(strlen($this->post('tgl_lahir'))!=10){
					$tgl_err='Format penulisan tanggal lahir lahir salah';	
				}elseif($this->CekTLS_tanggal($this->post('tgl_lahir'))){
					$tgl_err='Format penulisan tanggal lahir salah. Harus Tgl-Bln-Thn';
				}
				else{
					
					if(!$this->BCA_tanggal($this->post('tgl_lahir'))):
						$tgl_err='Format penulisan tanggal lahir salah. Contoh misal 30-07-1993';
					else:
						$tanggal_lahir=$this->post('tgl_lahir');
						$tanggal_lahir=$this->esc($tanggal_lahir);
					endif;			
				}

				if(empty($this->post('jln_dsn')||$this->post('rt') || $this->post('rw') || $this->post('desa') || $this->post('kec') || $this->post('kab'))){

					$alm_err = "Alamt lengkap wajib diisi";

				}else{
					$alamat = 'Dusun/Jln. '.$this->post('jln_dsn').' RT '.$this->post('rt').' RW '.$this->post('rw').' Desa '.$this->post('desa').' Kec. '.$this->post('kec').' Kab.'.$this->post('kab');
					$alamat = $this->esc($alamat);
					
				}
				if(empty($this->post('kontak'))){
					$kontak_err = "Kontak admin club wajib diisi";
				}elseif($this->validateNumber($this->post('kontak'))){
					$kontak_err = "Harap isi nomor kontak dengan benar, hanya karakter angka yang diperbolehkan";
				}else{
					$kontak = $this->post('kontak');
					$kontak = $this->esc($kontak);
				}

				if(empty($this->post('password'))){
					$pass_err = "Masukan sebuah password";
				}elseif(strlen($this->post('password'))<5){
					$pass_err = "Password tidak boleh kurang dari 5 karakter";
				}else{
					$password = trim($_POST['password']);
					 
				}				
				if(empty(trim($_POST['confir_password']))){
					$pass_kon_err="Masukan konfirmasi password";
				}else{
					$confir_password=trim($_POST['confir_password']);
					if(empty($pass_err) && ($confir_password!=$password)):
						$pass_kon_err="Konfirmasi password tidak cocok";
					endif;
				}
				if(empty($this->post('id_club'))){
					$id_club_err = "Mohon untuk memilih club yang tersedia";
				}elseif($this->validateNumber($this->post('id_club'))){
					$id_club_err = "Harap pilih club dengan benar";
				}else{
					$id_club = $this->post('id_club');
					$id_club = $this->esc($id_club);
				}
				if(empty($this->post('role'))){
					$role_err = "Role user harus dipilih";
				}else{
					$role = $this->post('role');
					$role = $this->esc($role);
					
				}		

		      	$this->getImage2('foto_user','../../content/foto/adminclub/',$role);

		      	if(in_array($this->file_extension, $this->file_valid)){
					if($this->file_size>300000){
					    $foto_err="Ukuran foto tidak boleh lebih dari 300KB";
					   }else{
					    $foto_user=$this->file_dir;
					}
				}else{
					$foto_err="Wajib diisi dengan format JPG, JPEG, atau PNG";
				}
				
				if(empty($nama_err) && empty ($pass_err) && empty ($pass_kon_err) && empty ($nik_err) && empty ($foto_err) && empty($kontak_err) && empty($role_err) && empty($alm_err) && empty($id_club_err) && empty($tgl_err) && empty($tempat_lahir_err)){
					if($role!=='adminclub'):

						die("Error");
						
					else:

						if($this->addUser($nik, $password, $role, $nama_lengkap, $foto_user, $this->file_foto, $this->file_destinasi) && $this->addAdm_club($this->koneksi->insert_id, $id_club, $nama_lengkap, $tempat_lahir, $tanggal_lahir, $alamat, $kontak)):

							$this->alert('success','Data berhasil disimpan');
						else:
							$this->alert('danger','Data gagal disimpan');
						endif;
					endif;

				}
			
		endif;
		$this->alert('info','Silahkan isi data admin club baru yang akan ditambahkan');
		$this->formFile();
		$this->card('Tambah Admin Club');	
	
		echo'	    

	       '.$this->formGroup('key', 'text', 'nik', "Masukan NIK 16 Digit",$nik_err).'
			<div class="form-group row">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			       '.$this->formGroup('user', 'text', 'nama_depan', "Masukan nama depan anda",$nama_err).'
			    </div>
				<div class="col-sm-6">
					'.$this->formGroup('user', 'text', 'nama_belakang', "Masukan nama belakang anda",$nama_err).'
			    </div>			                  
			</div>

			<div class="form-group row">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			        '.$this->formGroup('calendar', 'text', 'tempat_lahir', "Masukan tempat lahir anda",$tempat_lahir_err).'
			    </div>
				<div class="col-sm-6">
					'.$this->formGroup_datepicker('calendar', 'text', 'tgl_lahir', "30-07-1993",'tanggal',$tgl_err).'
			    </div>			                  
			</div>

			<div class="form-group row">

			    <div class="col-sm-4 mb-3 mb-sm-0">			    	
			        '.$this->formGroup('map', 'text', 'jln_dsn', "Nama jalan/dusun",NULL).'			           
			    </div>
			    <div class="col-sm-2">
					'.$this->formGroup('map', 'text', 'rt', "RT",NULL).'
			
			    </div>	
			    <div class="col-sm-2">
					'.$this->formGroup('map', 'text', 'rw', "RW",NULL).'
			
			    </div>
				<div class="col-sm-4">
					'.$this->formGroup('map', 'text', 'desa', "Desa",NULL).'
			
			    </div>			                  
			</div>
			<div class="form-group row">
				<div class="col-sm-6 mb-3 mb-sm-0">			    	
			       '.$this->formGroup('map', 'text', 'kec', "Kecamatan",NULL).'    
			    </div>
			    <div class="col-sm-6 mb-3 mb-sm-0">			    	
			        '.$this->formGroup('map', 'text', 'kab', "Kabupaten",NULL).'       
			    </div>
			</div>
			               
			<div class="form-group row mt-4">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			    	 '.$this->formGroup('key', 'password', 'password', "Masukan password",$pass_err).'
			    </div>
			    <div class="col-sm-6">
			    	 '.$this->formGroup('key', 'password', 'confir_password', "Masukan konfirmasi password",$pass_kon_err).'
			    </div>
			</div>
			'.$this->formGroup('phone', 'text', 'kontak', "Masukan telephone/whatsapp admin",$kontak_err).'
			<input type="hidden" name="role" value="adminclub">';
			$this->fetchClub_option();

			echo'
			'.$this->formGroup_file('file','foto_user',$foto_err).'		             
			
			'.$this->formGroup_button('btn-primary', 'btn-md', 'save','Simpan').' 
	    
	    </div>
        </div>
          </form>

        ';   
	}
	public function admClub()
	{
		$this->alert('info','Halaman untuk pengaturan admin club yang terdaftar. Silahkan untuk menambah admin club baru, mengedit atau menghapus admin club di halaman ini');	
		$this->card('Pengaturan Club');
		echo'<a class="btn-md btn-primary btn-sm mb-3 float-left" href="?page=buat akun adminclub"> <i class="fas fa-fw fa-plus"></i> Baru</a>';
		$this->dataAdm_club();
        echo'
		</div>
		</div>
	

		';
	}
	public function dataAdm_club()
	{
		echo
		'
		 <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Admin</th>
                      <th>Kontak</th>
                      <th>Club</th>                
                      <th>Aksi</th>
                   
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Nama Admin</th>
                      <th>Kontak</th>
                      <th>Club</th>                     
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody>
	              ';
	              	$this->fetchAdm_club();

	              echo
	              '
                   
                  </tbody>
                </table>
              </div>

		';
	}
	public function form_editAdm_club(){
		if(!$this->detail_adminClub($this->get('id_user'))) die ("Error");
		$nik_err = $nama_err = $tempat_lahir_err = $tgl_err = $alm_err = $pass_err = $pass_kon_err = $role_err = $foto_err = $id_club_err = $kontak_err = "";
		if($_SERVER['REQUEST_METHOD']=='POST'):
			
				if(empty($this->post('nik'))){
					$nik_err = "Masukan nik dengan benar";
				}elseif($this->validateNumber($this->post('nik'))){
					$nik_err = "No NIK hanya boleh berupa angka";
				}elseif(strlen($this->post('nik'))!=16){
					$nik_err = "No NIK harus 16 digit";
				}else{

					if($this->post('nik')!=$this->nik):
	                    if($this->cekNik($this->post('nik'))){
	                        $nik_err="Maaf nik tersebut sudah digunakan";
	                    }else{
	                        $nik=$this->post('nik');
	                        $nik=$this->esc($nik);
	                    }
                	else:
	                  $nik=$this->post('nik');
	                  $nik=$this->esc($nik);
	                endif;
				}				

				if(empty($this->post('nama_lengkap'))){
					$nama_err = "Nama lengkap wajib diisi";
				}elseif($this->validateName('nama_lengkap')){
					$nama_err = "Hanya boleh diisi dengan karakter alphabet";
				}else{
					$nama_lengkap = $this->post('nama_lengkap');
					$nama_lengkap = $this->esc($nama_lengkap);
				}

				if(empty($this->post('tempat_lahir'))){
					$tempat_lahir_err = "Masukan tempat lahir Anda";
				}else{

					$tempat_lahir=$this->post('tempat_lahir');
					$tempat_lahir=$this->esc($tempat_lahir);
				}

				if(empty($this->post('tgl_lahir'))){
					$tgl_err='tanggal lahir masih kosong';	
				}elseif(strlen($this->post('tgl_lahir'))!=10){
					$tgl_err='Format penulisan tanggal lahir lahir salah';	
				}elseif($this->CekTLS_tanggal($this->post('tgl_lahir'))){
					$tgl_err='Format penulisan tanggal lahir salah. Harus Tgl-Bln-Thn';
				}
				else{
					
					if(!$this->BCA_tanggal($this->post('tgl_lahir'))):
						$tgl_err='Format penulisan tanggal lahir salah. Contoh misal 30-07-1993';
					else:
						$tanggal_lahir=$this->post('tgl_lahir');
						$tanggal_lahir=$this->esc($tanggal_lahir);
					endif;			
				}

				if(empty($this->post('alamat'))){

					$alm_err = "Alamat lengkap wajib diisi";

				}else{
					$alamat = $this->post('alamat');
					$alamat = $this->esc($alamat);
					
				}
				if(empty($this->post('kontak'))){
					$kontak_err = "Kontak admin club wajib diisi";
				}elseif($this->validateNumber($this->post('kontak'))){
					$kontak_err = "Harap isi nomor kontak dengan benar, hanya karakter angka yang diperbolehkan";
				}else{
					$kontak = $this->post('kontak');
					$kontak = $this->esc($kontak);
				}

				if(empty($this->post('password'))){
					$pass_err = "Masukan sebuah password";
				}elseif(strlen($this->post('password'))<5){
					$pass_err = "Password tidak boleh kurang dari 5 karakter";
				}else{
					$password = trim($_POST['password']);
					 
				}				
				if(empty(trim($_POST['confir_password']))){
					$pass_kon_err="Masukan konfirmasi password";
				}else{
					$confir_password=trim($_POST['confir_password']);
					if(empty($pass_err) && ($confir_password!=$password)):
						$pass_kon_err="Konfirmasi password tidak cocok";
					endif;
				}
				if(empty($this->post('id_club'))){
					$id_club_err = "Mohon untuk memilih club yang tersedia";
				}elseif($this->validateNumber($this->post('id_club'))){
					$id_club_err = "Harap pilih club dengan benar";
				}else{
					$id_club = $this->post('id_club');
					$id_club = $this->esc($id_club);
				}
				if(empty($this->post('role'))){
					$role_err = "Role user harus dipilih";
				}else{
					$role = $this->post('role');
					$role = $this->esc($role);
					
				}		

		      	if(empty($_FILES['foto_user']['tmp_name'])):
					$foto_user=$this->foto_user;
					$this->file_foto=$this->foto_user;
					$this->file_destinasi="";
				else:
					$this->getImage2('foto_user','../../content/foto/adminclub/','adminclub');
					if(in_array($this->file_extension, $this->file_valid)){
							if($this->file_size>600000){
							    $foto_err="Ukuran foto tidak boleh lebih dari 600KB";
							   }else{
							    $foto_user=$this->file_dir;
							}
					}else{
						$foto_err="Wajib diisi dengan format JPG, JPEG, atau PNG";
					}
				endif;
				
				if(empty($nama_err) && empty ($pass_err) && empty ($pass_kon_err) && empty ($nik_err) && empty ($foto_err) && empty($kontak_err) && empty($role_err) && empty($alm_err) && empty($id_club_err) && empty($tgl_err) && empty($tempat_lahir_err)){
					if($role!=='adminclub'):

						die("Error");
						
					else:

						if($this->updateUser($nik, $password, $role, $nama_lengkap, $foto_user, $this->file_foto, $this->file_destinasi, $this->id_user) && $this->updateAdmin_club($id_club, $nama_lengkap, $tempat_lahir, $tanggal_lahir, $alamat, $kontak, $this->id_user)):

							$this->alert('success','Data berhasil disimpan');
							$this->reload_time('1','admin club');
						else:
							$this->alert('danger','Data gagal disimpan');
						endif;
					endif;

				}
			
		endif;
		$this->alert('info','Silhkan edit bagian data yang ingin dirubah saja');
		$this->formFile();
		$this->card('Edit Admin Club');	
	
		echo'	    

	       '.$this->formGroup_edit('key', 'text', 'nik', "Masukan NIK 16 Digit", $this->nik, $nik_err).'
			'.$this->formGroup_edit('user', 'text', 'nama_lengkap', "Masukan nama lengkap",$this->nama_user, $nama_err).'

			<div class="form-group row">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			        '.$this->formGroup_edit('calendar', 'text', 'tempat_lahir', "Masukan tempat lahir anda",$this->tempat_lahir, $tempat_lahir_err).'
			    </div>
				<div class="col-sm-6">
					'.$this->formGroup_datepicker_edit('calendar', 'text', 'tgl_lahir', "30-07-1993",'tanggal',$this->tgl_lahir,$tgl_err).'
			    </div>			                  
			</div>

			'.$this->formGroup_Textarea_edit('alamat', 'Masukan alamat secara lengkap', $this->alamat, $alm_err).'      
			<div class="form-group row mt-4">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			    	 '.$this->formGroup('key', 'password', 'password', "Masukan password",$pass_err).'
			    </div>
			    <div class="col-sm-6">
			    	 '.$this->formGroup('key', 'password', 'confir_password', "Masukan konfirmasi password",$pass_kon_err).'
			    </div>
			</div>
			'.$this->formGroup_edit('phone', 'text', 'kontak', "Masukan telephone/whatsapp admin", $this->kontak_admin, $kontak_err).'
			<input type="hidden" name="role" value="adminclub">';
			
			$this->fetchClub_option_edit();

			echo'
			'.$this->formGroup_file('file','foto_user',$foto_err).'	

			<div class="form-group">
	   		 '.$this->getDirImage2('../../content/foto/adminclub/',$this->foto_user).'
	   		</div>	             
			
			'.$this->formGroup_button('btn-primary', 'btn-md', 'save','Simpan').' 
	    
	    </div>
        </div>
          </form>

        ';   
	}
	public function form_deleteAdmin_club()
	{
		if(!$this->detail_adminClub($this->get('id_user'))) die ($this->alert('danger','Error : id user not found'));

		$this->alert('danger','Apakah anda yakin ingin menghapus data ini ?');

		if($_SERVER['REQUEST_METHOD']=='POST'):

			if($this->getImage_unlink('../../content/foto/'.$this->role.'/', $this->foto_user)){
				if($this->deleteAdmin_club($this->id_user) && $this->deleteUser($this->id_user)):
					$this->alert('success','Data berhasil dihapus');
					$this->reload_time('3','admin club');
				else:
					$this->alert('danger','Data gagal dihapus');
				endif;
			}else{
				$this->alert('danger','Terjadi kesalahan, foto gagal dihapus');
			}
		endif;	
		$this->formGeneral();
		$this->card('Hapus user');
		echo $this->formGroup_button('btn-danger', 'btn-md', 'trash','Hapus');		
		echo '</div></div></form>';
	}
/***************************
	HTML CLUB
****************************/
	
	public function club()
	{
		echo '
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
	            <h1 class="h3 mb-0 text-gray-800">Daftar Club</h1>
	            
        </div>
        <p class="mb-4">
     	 Halaman ini menampilkan daftar club yang telah ditambahkan, Anda melihat daftar pemain perclub dengan mengklik tombol <i class="fas fa-fw fa-users"></i>, atau menyimpan data pemain perclub dengan mengklik <i class="fas fa-fw fa-download"></i>
     	 </p>
        ';
		$this->alertInfo('Halaman untuk pengaturan club yang terdaftar. Silahkan untuk menambah club baru, mengedit atau menghapus club di halaman ini');
	
		$this->card('Pengaturan Club');
		echo'<a class="btn-md btn-primary btn-sm mb-3 float-left" href="?page=tambah club"><i class="fas fa-fw fa-plus"></i> Baru</a>';
		$this->dataClub();
        echo'
		</div>
		</div>
	

		';
	}
	public function dataClub()
	{
		echo
		'
		 <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Club</th>
                      <th>Alamat</th>
                      <th>Kontak</th>
                      <th>Aksi</th>
                   
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                       <th>No</th>
                       <th>Nama Club</th>
                      <th>Alamat</th>
                      <th>Kontak</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody>
	              ';
	              	$this->fetchClub();

	              echo
	              '
                   
                  </tbody>
                </table>
              </div>

		';
	}
	public function form_addClub()
	{
		$nama_err = $alm_err = $ktk_err = $lgo_err ="";

		if($_SERVER['REQUEST_METHOD']=='POST'):

			if(empty($this->post('nama'))){
				$nama_err = "Nama club wajib diisi";
			}else{
				$nama_club=$this->post('nama');
				$nama_club=$this->esc($nama_club);
				
			}

			if(empty($this->post('alamat'))){
				$alm_err = "Alamat lengkap club wajib diisi";
			}else{
				$alamat=$this->post('alamat');
				$alamat=$this->esc($alamat);
			}

			if(empty($this->post('kontak'))){
				$ktk_err="Kontak club wajib diisi";
			}elseif(!$this->validateNumber('kontak')){
				$ktk_err="Format kontak hanya boleh berupa angka";
			}else{
				$kontak=$this->post('kontak');
				$kontak=$this->esc($kontak);
			}

			$this->getImage2('logo_club','../../content/foto/club/','club');
			if(in_array($this->file_extension, $this->file_valid)){
					if($this->file_size>600000){
					    $lgo_err="Ukuran foto tidak boleh lebih dari 600KB";
					   }else{
					    $logo_club=$this->file_dir;
					}
			}else{
				$lgo_err="Wajib diisi dengan format JPG, JPEG, atau PNG";
			}

			if(empty($nama_err) && empty($alm_err) && empty($ktk_err) && empty($lgo_err)){

				if($this->addClub($nama_club, $alamat, $kontak, $logo_club, $this->file_foto, $this->file_destinasi)):
					$this->alert('success','Data berhasil disimpan');
					$this->reload('club');
				else:
					$this->alert('danger','Data gagal disimpan');
					$this->reload('club');

				endif;
			}

		endif;

		$this->alertInfo('Silahkan isi data club/tim baru yang akan ditambahkan');
		$this->formFile();
		$this->card('Tambah Club');

		echo'
		'.$this->formGroup('user', 'text', 'nama', "Masukan nama club",$nama_err).'
	   	'.$this->formGroup_Textarea('alamat', 'Masukan alamat club', $alm_err).'
	    '.$this->formGroup('phone', 'text', 'kontak', "Masukan No Tlp/WhatsApp club",$ktk_err).'
	    '.$this->formGroup_file('file', 'logo_club',$lgo_err).'
	    '.$this->formGroup_button('btn-primary', 'btn-md', 'save','Simpan').' 

		';

		echo '</div></div></form>';

	}
	public function form_editClub()
	{
		if(!$this->detailClub($this->get('id_club'))) die($this->alert('danger','Error : id club not found'));
		

		$nama_err = $alm_err = $ktk_err = $lgo_err ="";

		if($_SERVER['REQUEST_METHOD']=='POST'):

			if(empty($this->post('nama'))){
				$nama_err = "Nama club wajib diisi";
			}else{
				$nama_club=$this->post('nama');
				$nama_club=$this->esc($nama_club);
				
			}

			if(empty($this->post('alamat'))){
				$alm_err = "Alamat lengkap club wajib diisi";
			}else{
				$alamat=$this->post('alamat');
				$alamat=$this->esc($alamat);
			}

			if(empty($this->post('kontak'))){
				$ktk_err="Kontak club wajib diisi";
			}elseif(!$this->validateNumber('kontak')){
				$ktk_err="Format kontak hanya boleh berupa angka";
			}else{
				$kontak=$this->post('kontak');
				$kontak=$this->esc($kontak);
			}
			if(empty($_FILES['logo_club']['tmp_name'])):
				$logo_club=$this->logo_club;
				$this->file_foto=$this->logo_club;
				$this->file_destinasi="";
			else:
				$this->getImage2('logo_club','../../content/foto/club/','club');
				if(in_array($this->file_extension, $this->file_valid)){
						if($this->file_size>600000){
						    $lgo_err="Ukuran foto tidak boleh lebih dari 600KB";
						   }else{
						    $logo_club=$this->file_dir;
						}
				}else{
					$lgo_err="Wajib diisi dengan format JPG, JPEG, atau PNG";
				}
			endif;

			if(empty($nama_err) && empty($alm_err) && empty($ktk_err) && empty($lgo_err)){

				if($this->editClub_proses($nama_club, $alamat, $kontak, $logo_club, $this->file_foto, $this->file_destinasi, $this->id_club)):
					$this->alert('success','Data berhasil disimpan');
					$this->reload('club');
				else:
					$this->alert('danger','Data gagal disimpan');
					$this->reload('club');

				endif;
			}
		endif;

		$this->alertInfo('Anda bisa merubah data dibawah ini, rubah bagian data yang ingin dirubah saja');
		$this->formFile();
		$this->card('Edit Club');

		echo
		$this->formGroup_edit('user', 'text', 'nama', "Masukan nama club",$this->nama_club, $nama_err)
	   	.$this->formGroup_Textarea_edit('alamat', 'Masukan alamat club',$this->alamat_club, $alm_err)
	    .$this->formGroup_edit('phone', 'text', 'kontak', "Masukan No Tlp/WhatsApp club",$this->kontak_club, $ktk_err)
	    .$this->formGroup_file('file', 'logo_club',$lgo_err).'
	    <div class="form-group">
	   	 '.$this->getDirImage2('../../content/foto/club/',$this->logo_club).'
	   	 </div>
	   	 
	    '.$this->formGroup_button('btn-primary', 'btn-md', 'save','Simpan'); 

		

		echo '</div></div></form>';

	}
	public function form_deleteClub()
	{
		if(!$this->detailClub($this->get('id_club'))) die ($this->alert('danger','Error : id club not found'));
		$this->alert('danger','Apakah anda yakin ingin menghapus data ini ?');

		if($_SERVER['REQUEST_METHOD']=='POST'):

			if($this->getImage_unlink('../../content/foto/club/', $this->logo_club)){
				if($this->deleteClub($this->id_club)):
					$this->alert('success','Data berhasil dihapus');
					$this->reload('club');
				else:
					$this->alert('danger','Data gagal dihapus');
				endif;
			}else{
				$this->alert('danger','Logo club gagal dihapus');
			}


		endif;
		$this->formGeneral();
		$this->card('Hapus Club');
		echo $this->formGroup_button('btn-danger', 'btn-md', 'trash','Hapus');		
		echo '</div></div></form>';
	}
	public function form_clubSaya()
	{
		$this->sessionData($this->filter($_SESSION['id_user']));
		$this->shownameClub_session($this->datasession['id_club']);
		$this->card('Club Saya');

		echo'
		'.$this->formGroup_edit('user', 'text', 'nama', "Masukan nama club",$this->nameClub['nama_club'], NULL).'
	   	'.$this->formGroup_Textarea_edit('alamat', 'Masukan alamat club',$this->nameClub['alamat_club'], NULL).'
	    '.$this->formGroup_edit('phone', 'text', 'kontak', "Masukan No Tlp/WhatsApp club",$this->nameClub['kontak_club'], NULL).'
	    ';
	    echo'
	    <div class="form-group">
	   	 '.$this->getDirImage2('../../content/foto/club/',$this->nameClub['logo_club']).'
	   	 </div>

	   	 </div></div>
	   	 ';
	}
/***************************
	HTML PEMAIN
****************************/
	public function pemain()
	{
		echo '
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
	            <h1 class="h3 mb-0 text-gray-800">Daftar Pemain</h1>
	            
        </div>
        <p class="mb-4">
     	 Halaman ini telah dilimit sebanyak 20 data, Anda dapat menggunakan filter yang tersedia untuk menampilkan para pemain per/club. Untuk menambah pemain seilahkan klik tombol baru <i class="fas fa-fw fa-plus"></i>. Untuk mengubah dan mereset password pemain Anda bisa mengklik <i class="fas fa-fw fa-edit"></i>, melihat detail pemain klik <i class="fas fa-fw fa-eye"></i>, dan mencetak dokumen <i class="fas fa-fw fa-print"></i>
     	 </p>
        ';
		

		$this->card('Pengaturan Pemain');

		echo
		'
		<a class="btn-md btn-primary btn-sm mb-3 float-left" href="?page=buat akun pemain"> <i class="fas fa-fw fa-plus"></i> Baru</a>
		';

		if(isset($_POST['filter'])):

			if(empty($this->post('id_club'))){
				$id_club_err = "Pilih club untuk memfilter";
			}else{

				$id_club=$this->post('id_club');
			}
			if(empty($id_club_err)){
				$this->reload_time('0',$id_club);
				
			}

		endif;

		$this->formGeneral();
		echo'
		<div class="form-group row">
			<div class="col-sm-4 mb-3 mb-sm-0">
				<select class="form-control" name="id_club" required="">';
						if(!empty($_GET['club'])):
							echo'<option value="pemain&id_club='.$this->get('id_club').'&club='.$this->get('club').'">'.$this->get('club').'</option>';
						endif;					        		
					    $this->option=$this->listAll_Club();
						while($this->rwClub=$this->option->fetch_array()){
						  echo '
							<option value="pemain&id_club='.$this->rwClub['id_club'].'&club='.$this->rwClub['nama_club'].'">'.$this->rwClub['nama_club'].'</option>

							';									
										
						}
					$this->option->free_result();

					echo'
				</select>
			</div>
			<div class="col-sm-2 mb-3 mb-sm-0">
			'.$this->formGroup_button2('filter','btn-sm', 'filter','filter').' 
		
				<a class="btn btn-primary btn-sm" href="?page=pemain">Reset</a>
			</div>
		</div>
		</form>
		';	

		$this->dataPemain();
        echo'
		</div>
		</div>
	

		';
		
	}
	public function dataPemain()
	{
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
		echo
		'
		 <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                  	<tr>
                  		<td colspan="2">Jumlah Pemain</td>
                  		<td colspan="3">'.$this->jml_pemain.'</td>

                    <tr>
                      <th>No</th>
                      <th>Nama Pemain</th>
                      <th>Kontak</th>
                      <th>Club</th>                
                      <th>Aksi</th>
                   
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Nama Pemain</th>
                      <th>Kontak</th>
                      <th>Club</th>                     
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody>';
	           
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

	            
                   echo'
                  </tbody>
                </table>
              </div>

		';
	}
	public function form_addPemain()
	{
		$nik_err = $nama_err = $tempat_lahir_err = $tgl_err = $alm_err = $pass_err = $pass_kon_err = $role_err = $foto_err = $id_club_err = $kontak_err = $tinggi_badan_err = $berat_badan_err = $no_punggung_err = $no_kk_err = "";
		if($_SERVER['REQUEST_METHOD']=='POST'):
			
				if(empty($this->post('nik'))){
					$nik_err = "Masukan nik dengan benar";
				}elseif($this->validateNumber($this->post('nik'))){
					$nik_err = "No NIK hanya boleh berupa angka";
				}elseif(strlen($this->post('nik'))!=16){
					$nik_err = "No NIK harus 16 digit";
				}
				else{
					#Cek tanpa session				
					if($this->cekNik($this->post('nik'))):
						$nik_err = "Maaf NIK tersebut sudah digunakan";
					else:
						$nik=$this->post('nik');
						$nik=$this->esc($nik);
					endif;
					

				}

				if($this->validateNumber($this->post('no_kk'))){

					$no_kk_err = "Pastikan data berupa no nik sepanjang 16 karakter";
				}elseif(strlen($this->post('no_kk'))!=16){
					$no_kk_err = "Pastikan data sebanyak 16 karakter";
				}else{

					$no_kk=$this->post('no_kk');
					$no_kk=$this->esc($no_kk);

				}

				if($this->validateNumber($this->post('no_punggung'))){

					$no_punggung_err = "Data harrus berupa angka";

				}else{
					$no_punggung=$this->post('no_punggung');
					$no_punggung=$this->esc($no_punggung);

				}


				$posisi=$this->post('posisi');
				$posisi=$this->esc($posisi);

				if($this->validateNumber($this->post('tinggi_badan'))){
					$tinggi_badan_err = "Masukan tinggi badan dengan benar. Misal 170";
				}else{
					$tinggi_badan=$this->post('tinggi_badan');
					$tinggi_badan=$this->esc($tinggi_badan);
				}

				if($this->validateNumber($this->post('berat_badan'))){
					$tinggi_badan_err = "Masukan berat badan dengan benar. Misal 65";
				}else{
					$berat_badan=$this->post('berat_badan');
					$berat_badan=$this->esc($berat_badan);
				}
							

				$gol_darah=$this->post('gol_darah');
				$gol_darah=$this->esc($gol_darah);

				if(empty($this->post('nama_depan') || $this->post('nama_belakang'))){
					$nama_err = "Nama depan dan belakang wajib diisi";
				}elseif($this->validateName('nama_depan')|| $this->validateName('nama_belakang')){
					$nama_err = "Hanya boleh diisi dengan karakter alphabet";
				}else{
					$nama_lengkap = $this->post('nama_depan').' '.$this->post('nama_belakang');
					$nama_lengkap = $this->esc($nama_lengkap);
				}

				if(empty($this->post('tempat_lahir'))){
					$tempat_lahir_err = "Masukan tempat lahir Anda";
				}else{

					$tempat_lahir=$this->post('tempat_lahir');
					$tempat_lahir=$this->esc($tempat_lahir);
				}

				if(empty($this->post('tgl_lahir'))){
					$tgl_err='tanggal lahir masih kosong';	
				}elseif(strlen($this->post('tgl_lahir'))!=10){
					$tgl_err='Format penulisan tanggal lahir lahir salah';	
				}elseif($this->CekTLS_tanggal($this->post('tgl_lahir'))){
					$tgl_err='Format penulisan tanggal lahir salah. Harus Tgl-Bln-Thn';
				}
				else{
					
					if(!$this->BCA_tanggal($this->post('tgl_lahir'))):
						$tgl_err='Format penulisan tanggal lahir salah. Contoh misal 30-07-1993';
					else:
						$tanggal_lahir=$this->post('tgl_lahir');
						$tanggal_lahir=$this->esc($tanggal_lahir);
					endif;			
				}

				if(empty($this->post('jln_dsn')||$this->post('rt') || $this->post('rw') || $this->post('desa') || $this->post('kec') || $this->post('kab'))){

					$alm_err = "Alamt lengkap wajib diisi";

				}else{
					$alamat = 'Dusun/Jln. '.$this->post('jln_dsn').' RT '.$this->post('rt').' RW '.$this->post('rw').' Desa '.$this->post('desa').' Kec. '.$this->post('kec').' Kab.'.$this->post('kab');
					$alamat = $this->esc($alamat);
					
				}
				if(empty($this->post('kontak'))){
					$kontak_err = "Kontak admin club wajib diisi";
				}elseif($this->validateNumber($this->post('kontak'))){
					$kontak_err = "Harap isi nomor kontak dengan benar, hanya karakter angka yang diperbolehkan";
				}else{
					$kontak = $this->post('kontak');
					$kontak = $this->esc($kontak);
				}

				if(empty($this->post('password'))){
					$pass_err = "Masukan sebuah password";
				}elseif(strlen($this->post('password'))<5){
					$pass_err = "Password tidak boleh kurang dari 5 karakter";
				}else{
					$password = trim($_POST['password']);
					 
				}				
				if(empty(trim($_POST['confir_password']))){
					$pass_kon_err="Masukan konfirmasi password";
				}else{
					$confir_password=trim($_POST['confir_password']);
					if(empty($pass_err) && ($confir_password!=$password)):
						$pass_kon_err="Konfirmasi password tidak cocok";
					endif;
				}

				if(empty($this->post('id_club'))){
					$id_club_err = "Mohon untuk memilih club yang tersedia";
				}elseif($this->validateNumber($this->post('id_club'))){
					$id_club_err = "Harap pilih club dengan benar";
				}else{
					$id_club = $this->post('id_club');
					$id_club = $this->esc($id_club);
				}

				if(empty($this->post('role'))){
					$role_err = "Role user harus dipilih";
				}else{
					$role = $this->post('role');
					$role = $this->esc($role);
					
				}		

		      	$this->getImage2('foto_user','../../content/foto/pemain/',$role);

		      	if(in_array($this->file_extension, $this->file_valid)){
					if($this->file_size>300000){
					    $foto_err="Ukuran foto tidak boleh lebih dari 300KB";
					   }else{
					    $foto_user=$this->file_dir;
					}
				}else{
					$foto_err="Wajib diisi dengan format JPG, JPEG, atau PNG";
				}
				
				if(empty($nama_err) && empty ($pass_err) && empty ($pass_kon_err) && empty ($nik_err) && empty ($foto_err) && empty($kontak_err) && empty($no_punggung_err) && empty($berat_badan_err) && empty($tinggi_badan_err) && empty($alm_err) && empty($tempat_lahir_err) && empty($tgl_err) && empty($role_err)){
					if($role!=='pemain'):

						die("Error");
						
					else:

						if($this->addUser($nik, $password, $role, $nama_lengkap, $foto_user, $this->file_foto, $this->file_destinasi)):
							$data_id=$this->koneksi->insert_id;
							$this->addPemain($data_id, $id_club, $no_punggung,$posisi, $nama_lengkap, $nik, $no_kk, $tempat_lahir, $tanggal_lahir, $tinggi_badan, $berat_badan, $gol_darah, $alamat, $kontak); 
							$this->addDokumen_pemain($data_id);

							$this->alert('success','Data berhasil disimpan');
							$this->reload_time('2','pemain');
						else:
							$this->alert('danger','Data gagal disimpan');
							$this->reload_time('2','pemain');
						endif;
					endif;

				}
			
		endif;
		$this->alert('info','Silahkan isi data pemain baru yang akan ditambahkan');
		$this->formFile();
		$this->card('Tambah Pemain');	
		echo'	    

	       '.$this->formGroup('key', 'text', 'nik', "Masukan NIK 16 Digit",$nik_err).'
	       '.$this->formGroup('key', 'text', 'no_kk', "Masukan nomor kartu keluarga",$no_kk_err).'
	       <div class="form-group row">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			       '.$this->formGroup('user', 'text', 'no_punggung', "Masukan nomor punggung",$no_punggung_err).'
			    </div>
				<div class="col-sm-6">
					<div class="form-group">
				        <div class="input-group">
					        <div class="input-group-prepend">
					        	<div class="input-group-text"><i class="fas fa-fw fa-arrow-alt-circle-down"></i></div>
					        </div>
					       		<select class="form-control" name="posisi" required="">
					       			
					       			<option value="Goal Keeper">Goal Keeper</option>
					       			<option value="Bek Tengah">Bek Tengah</option>
					       			<option value="Bek Sayap">Bek Sayap</option>
					       			<option value="Gelandang">Gelandang</option>
					       			<option value="Gelandang Bertahan">Gelandang Bertahan</option>
					       			<option value="Gelandang Tengah">Gelandang Tengah</option>
					       			<option value="Gelandang Serang">Gelandang Serang</option>
					       			<option value="Gelandang Sayap">Gelandang Sayap</option>
					       			<option value="Penyerang">Penyerang</option>
					       		</select>
					    </div>	
					            
				     </div>
					
			    </div>			                  
			</div>
			<div class="form-group row">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			       '.$this->formGroup('user', 'text', 'nama_depan', "Masukan nama depan anda",$nama_err).'
			    </div>
				<div class="col-sm-6">
					'.$this->formGroup('user', 'text', 'nama_belakang', "Masukan nama belakang anda",$nama_err).'
			    </div>			                  
			</div>

			<div class="form-group row">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			        '.$this->formGroup('calendar', 'text', 'tempat_lahir', "Masukan tempat lahir anda",$tempat_lahir_err).'
			    </div>
				<div class="col-sm-6">
					'.$this->formGroup_datepicker('calendar', 'text', 'tgl_lahir', "30-07-1993",'tanggal',$tgl_err).'
			    </div>			                  
			</div>

			<div class="form-group row">

			   
			    <div class="col-sm-3">
					'.$this->formGroup('hashtag', 'text', 'tinggi_badan', "Masukan tinggi badan Anda",NULL).'
			
			    </div>	
			    <div class="col-sm-3">
					'.$this->formGroup('hashtag', 'text', 'berat_badan', "Masukan berat badan Anda",NULL).'
			
			    </div>
				<div class="col-sm-6">
					<div class="form-group">
				        <div class="input-group">
					        <div class="input-group-prepend">
					        	<div class="input-group-text"><i class="fas fa-fw fa-arrow-alt-circle-down"></i></div>
					        </div>
					       		<select class="form-control" name="gol_darah" required="">
					       			<option></option>
					       			<option value="A">A</option>
					       			<option value="B">B</option>
					       			<option value="AB">AB</option>
					       			<option value="O">O</option>
					       			<option value="Belum Tahu">Belum Tahu</option>
					       		</select>
					    </div>	
					            
				     </div>
					
			    </div>			                  
			</div>

			<div class="form-group row">

			    <div class="col-sm-4 mb-3 mb-sm-0">			    	
			        '.$this->formGroup('map', 'text', 'jln_dsn', "Nama jalan/dusun",NULL).'			           
			    </div>
			    <div class="col-sm-2">
					'.$this->formGroup('map', 'text', 'rt', "RT",NULL).'
			
			    </div>	
			    <div class="col-sm-2">
					'.$this->formGroup('map', 'text', 'rw', "RW",NULL).'
			
			    </div>
				<div class="col-sm-4">
					'.$this->formGroup('map', 'text', 'desa', "Desa",NULL).'
			
			    </div>			                  
			</div>
			<div class="form-group row">
				<div class="col-sm-6 mb-3 mb-sm-0">			    	
			       '.$this->formGroup('map', 'text', 'kec', "Kecamatan",NULL).'    
			    </div>
			    <div class="col-sm-6 mb-3 mb-sm-0">			    	
			        '.$this->formGroup('map', 'text', 'kab', "Kabupaten",NULL).'       
			    </div>
			</div>
			               
			<div class="form-group row mt-4">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			    	 '.$this->formGroup('key', 'password', 'password', "Masukan password",$pass_err).'
			    </div>
			    <div class="col-sm-6">
			    	 '.$this->formGroup('key', 'password', 'confir_password', "Masukan konfirmasi password",$pass_kon_err).'
			    </div>
			</div>
			'.$this->formGroup('phone', 'text', 'kontak', "Masukan telephone/whatsapp admin",$kontak_err).'
			<input type="hidden" name="role" value="pemain">';
			$this->fetchClub_option();

			echo'
			'.$this->formGroup_file('file','foto_user',$foto_err).'		             
			
			'.$this->formGroup_button('btn-primary', 'btn-md', 'save','Simpan').' 
	    
	    </div>
        </div>
          </form>

        ';   
	}
	public function	form_editPemain()
	{
		if(!$this->detailPemain($this->get('id_user'))) die($this->alert('danger','Id user not found !'));
		$nik_err = $nama_err = $tempat_lahir_err = $tgl_err = $alm_err = $pass_err = $pass_kon_err = $role_err = $foto_err = $id_club_err = $kontak_err = $tinggi_badan_err = $berat_badan_err = $no_punggung_err = $no_kk_err = "";

		if($_SERVER['REQUEST_METHOD']=='POST'):
			if(empty($this->post('nik'))){
					$nik_err = "Masukan nik dengan benar";
				}elseif($this->validateNumber($this->post('nik'))){
					$nik_err = "No NIK hanya boleh berupa angka";
				}elseif(strlen($this->post('nik'))!=16){
					$nik_err = "No NIK harus 16 digit";
				}
				else{
					if($this->post('nik')!=$this->nik){			
						if($this->cekNik($this->post('nik'))):
							$nik_err = "Maaf NIK tersebut sudah digunakan";
						else:
							$nik=$this->post('nik');
							$nik=$this->esc($nik);
						endif;
					}else{

						$nik=$this->post('nik');
						$nik=$this->esc($nik);
					}
						

				}

				if($this->validateNumber($this->post('no_kk'))){

					$no_kk_err = "Pastikan data berupa no nik sepanjang 16 karakter";
				}elseif(strlen($this->post('no_kk'))!=16){
					$no_kk_err = "Pastikan data sebanyak 16 karakter";
				}else{

					$no_kk=$this->post('no_kk');
					$no_kk=$this->esc($no_kk);

				}

				if($this->validateNumber($this->post('no_punggung'))){

					$no_punggung_err = "Data harrus berupa angka";

				}else{
					$no_punggung=$this->post('no_punggung');
					$no_punggung=$this->esc($no_punggung);

				}


				$posisi=$this->post('posisi');
				$posisi=$this->esc($posisi);

				if($this->validateNumber($this->post('tinggi_badan'))){
					$tinggi_badan_err = "Masukan tinggi badan dengan benar. Misal 170";
				}else{
					$tinggi_badan=$this->post('tinggi_badan');
					$tinggi_badan=$this->esc($tinggi_badan);
				}

				if($this->validateNumber($this->post('berat_badan'))){
					$tinggi_badan_err = "Masukan berat badan dengan benar. Misal 65";
				}else{
					$berat_badan=$this->post('berat_badan');
					$berat_badan=$this->esc($berat_badan);
				}
							

				$gol_darah=$this->post('gol_darah');
				$gol_darah=$this->esc($gol_darah);

				if(empty($this->post('nama_depan'))){
					$nama_err = "Nama wajib diisi";
				}elseif($this->validateName('nama_depan')){
					$nama_err = "Hanya boleh diisi dengan karakter alphabet";
				}else{
					$nama_lengkap = $this->post('nama_depan');
					$nama_lengkap = $this->esc($nama_lengkap);
				}

				if(empty($this->post('tempat_lahir'))){
					$tempat_lahir_err = "Masukan tempat lahir Anda";
				}else{

					$tempat_lahir=$this->post('tempat_lahir');
					$tempat_lahir=$this->esc($tempat_lahir);
				}

				if(empty($this->post('tgl_lahir'))){
					$tgl_err='tanggal lahir masih kosong';	
				}elseif(strlen($this->post('tgl_lahir'))!=10){
					$tgl_err='Format penulisan tanggal lahir lahir salah';	
				}elseif($this->CekTLS_tanggal($this->post('tgl_lahir'))){
					$tgl_err='Format penulisan tanggal lahir salah. Harus Tgl-Bln-Thn';
				}
				else{
					
					if(!$this->BCA_tanggal($this->post('tgl_lahir'))):
						$tgl_err='Format penulisan tanggal lahir salah. Contoh misal 30-07-1993';
					else:
						$tanggal_lahir=$this->post('tgl_lahir');
						$tanggal_lahir=$this->esc($tanggal_lahir);
					endif;			
				}

				if(empty($this->post('alamat'))){

					$alm_err = "Alamt lengkap wajib diisi";

				}else{
					$alamat = $this->post('alamat');
					$alamat = $this->esc($alamat);
					
				}
				if(empty($this->post('kontak'))){
					$kontak_err = "Kontak admin club wajib diisi";
				}elseif($this->validateNumber($this->post('kontak'))){
					$kontak_err = "Harap isi nomor kontak dengan benar, hanya karakter angka yang diperbolehkan";
				}else{
					$kontak = $this->post('kontak');
					$kontak = $this->esc($kontak);
				}

				if(!empty($this->post('password'))):
					if(strlen($this->post('password'))<5){
						$pass_err = "Password tidak boleh kurang dari 5 karakter";
					}else{
						$password = trim($_POST['password']);
						 
					}
				endif;
				if(!empty($password)):				
					if(empty(trim($_POST['confir_password']))){
						$pass_kon_err="Masukan konfirmasi password";
					}else{
						$confir_password=trim($_POST['confir_password']);
						if(empty($pass_err) && ($confir_password!=$password)):
							$pass_kon_err="Konfirmasi password tidak cocok";
						endif;
					}
				endif;

				if(empty($this->post('id_club'))){
					$id_club_err = "Mohon untuk memilih club yang tersedia";
				}elseif($this->validateNumber($this->post('id_club'))){
					$id_club_err = "Harap pilih club dengan benar";
				}else{
					$id_club = $this->post('id_club');
					$id_club = $this->esc($id_club);
				}

				if(empty($this->post('role'))){
					$role_err = "Role user harus dipilih";
				}else{
					$role = $this->post('role');
					$role = $this->esc($role);
					
				}		

		      	if(empty($_FILES['foto_user']['tmp_name'])):
					$foto_user=$this->foto_user;
					$this->file_foto=$this->foto_user;
					$this->file_destinasi="";
				else:
					$this->getImage2('foto_user','../../content/foto/pemain/',$role);
					if(in_array($this->file_extension, $this->file_valid)){
							if($this->file_size>600000){
							    $foto_err="Ukuran foto tidak boleh lebih dari 600KB";
							   }else{
							    $foto_user=$this->file_dir;
							}
					}else{
						$lgo_err="Wajib diisi dengan format JPG, JPEG, atau PNG";
					}
				endif;
				
				if(empty($nama_err) && empty ($pass_err) && empty ($pass_kon_err) && empty ($nik_err) && empty ($foto_err) && empty($kontak_err) && empty($no_punggung_err) && empty($berat_badan_err) && empty($tinggi_badan_err) && empty($alm_err) && empty($tempat_lahir_err) && empty($tgl_err) && empty($role_err) && empty($no_kk_err)){
					

						if(!empty($password)){
							if($this->updateUser($nik, $password, $this->role, $nama_lengkap, $foto_user, $this->file_foto, $this->file_destinasi, $this->id_user) && $this->updatePemain($this->datasession['id_club'], $no_punggung,$posisi, $nama_lengkap, $nik, $no_kk, $tempat_lahir, $tanggal_lahir, $tinggi_badan, $berat_badan, $gol_darah, $alamat, $kontak, $this->id_user)):

								$this->alert('success','Data berhasil disimpan');
								$this->reload_time('3','pemain');
							else:
								$this->alert('danger','Data gagal disimpan');
							endif;
						}else{

							if($this->updateUser_noPass($nik, $this->role, $nama_lengkap, $foto_user, $this->file_foto, $this->file_destinasi, $this->id_user) && $this->updatePemain($id_club, $no_punggung,$posisi, $nama_lengkap, $nik, $no_kk, $tempat_lahir, $tanggal_lahir, $tinggi_badan, $berat_badan, $gol_darah, $alamat, $kontak, $this->id_user)):

								$this->alert('success','Data berhasil disimpan');
								$this->reload_time('3','pemain');
							else:
								$this->alert('danger','Data gagal disimpan');
							endif;
						}


				}
		endif;
		$this->alert('info','Silahkan edit data pemain yang ingin Anda rubah. Password tidak perlu diisi jika password tidak akan di reset');
		$this->formFile();
		$this->card('Edit Pemain');	
		echo'	    

	       '.$this->formGroup_edit('key', 'text', 'nik', "Masukan NIK 16 Digit",$this->nik, $nik_err).'
	       '.$this->formGroup_edit('key', 'text', 'no_kk', "Masukan nomor kartu keluarga",$this->nik, $no_kk_err).'
	       <div class="form-group row">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			       '.$this->formGroup_edit('user', 'text', 'no_punggung', "Masukan nomor punggung",$this->no_punggung, $no_punggung_err).'
			    </div>
				<div class="col-sm-6">
					<div class="form-group">
				        <div class="input-group">
					        <div class="input-group-prepend">
					        	<div class="input-group-text"><i class="fas fa-fw fa-arrow-alt-circle-down"></i></div>
					        </div>
					       		<select class="form-control" name="posisi" required="">
					       			<option value="'.$this->posisi_pemain.'">'.$this->posisi_pemain.'</option>
					       			<option value="Goal Keeper">Goal Keeper</option>
					       			<option value="Bek Tengah">Bek Tengah</option>
					       			<option value="Bek Sayap">Bek Sayap</option>
					       			<option value="Gelandang">Gelandang</option>
					       			<option value="Gelandang Bertahan">Gelandang Bertahan</option>
					       			<option value="Gelandang Tengah">Gelandang Tengah</option>
					       			<option value="Gelandang Serang">Gelandang Serang</option>
					       			<option value="Gelandang Sayap">Gelandang Sayap</option>
					       			<option value="Penyerang">Penyerang</option>
					       		</select>
					    </div>	
					            
				     </div>
					
			    </div>			                  
			</div>
			'.$this->formGroup_edit('user', 'text', 'nama_depan', 'Masukan nama lengkap pemain',$this->nama_user, $nama_err).'

			<div class="form-group row">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			        '.$this->formGroup_edit('calendar', 'text', 'tempat_lahir', "Masukan tempat lahir anda",$this->tempat_lahir, $tempat_lahir_err).'
			    </div>
				<div class="col-sm-6">
					'.$this->formGroup_datepicker_edit('calendar', 'text', 'tgl_lahir', "30-07-1993",'tanggal',$this->tgl_lahir, $tgl_err).'
			    </div>			                  
			</div>

			<div class="form-group row">

			   
			    <div class="col-sm-3">
					'.$this->formGroup_edit('hashtag', 'text', 'tinggi_badan', "Masukan tinggi badan Anda",$this->tinggi_badan, NULL).'
			
			    </div>	
			    <div class="col-sm-3">
					'.$this->formGroup_edit('hashtag', 'text', 'berat_badan', "Masukan berat badan Anda",$this->berat_badan, NULL).'
			
			    </div>
				<div class="col-sm-6">
					<div class="form-group">
				        <div class="input-group">
					        <div class="input-group-prepend">
					        	<div class="input-group-text"><i class="fas fa-fw fa-arrow-alt-circle-down"></i></div>
					        </div>
					       		<select class="form-control" name="gol_darah" required="">
					       			<option value="'.$this->golongan_darah.'">'.$this->golongan_darah.'</option>
					       			<option value="A">A</option>
					       			<option value="B">B</option>
					       			<option value="AB">AB</option>
					       			<option value="O">O</option>
					       			<option value="Belum Tahu">Belum Tahu</option>
					       		</select>
					    </div>	
					            
				     </div>
					
			    </div>			                  
			</div>

			'.$this->formGroup_Textarea_edit('alamat', 'Masukan alamat secara lengkap', $this->alamat, $alm_err).' 
			               
			<div class="form-group row mt-4">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			    	 '.$this->formGroup_noRequired('key', 'password', 'password', "Masukan password",$pass_err).'
			    </div>
			    <div class="col-sm-6">
			    	 '.$this->formGroup_noRequired('key', 'password', 'confir_password', "Masukan konfirmasi password",$pass_kon_err).'
			    </div>
			</div>
			'.$this->formGroup_edit('phone', 'text', 'kontak', "Masukan telephone/whatsapp pemain",$this->kontak_pemain, $kontak_err).'
			<input type="hidden" name="role" value="pemain">';
			$this->fetchClub_option_edit();

			echo'
			'.$this->formGroup_file('file','foto_user',$foto_err).'
			<div class="form-group">
	   		 '.$this->getDirImage2('../../content/foto/pemain/',$this->foto_user).'
	   		</div>	    		             
			
			'.$this->formGroup_button('btn-primary', 'btn-md', 'save','Simpan').' 
	    
	    </div>
        </div>
          </form>

        ';   
	}
	public function form_deletePemain()
	{
		if(!$this->detailPemain($this->get('id_user'))) die($this->alert('danger','Id user not found !'));
		if(isset($_SESSION['role'])){

			 if($_SESSION['role']!='administrator'):
			 	$this->sessionData($this->filter($_SESSION['id_user']));
			 	if($this->datasession['id_club']!=$this->id_club) die($this->alert('danger','Data ini bukan milik Anda !'));

			 endif;
		}

		if($_SERVER['REQUEST_METHOD']=='POST'):

			if($this->getImage_unlink('../../content/foto/'.$this->role.'/', $this->foto_user)){
				if($this->deletePemain($this->id_user) && $this->deleteDokumen_pemain($this->id_user) && $this->deleteUser($this->id_user)):
					$this->alert('success','Data berhasil dihapus');
					$this->reload_time('3','pemain');
				else:
					$this->alert('danger','Data gagal dihapus');
				endif;
			}else{
				$this->alert('danger','Terjadi kesalahan, foto gagal dihapus');
			}
		endif;	

		$this->alert('danger','Apakah anda yakin ingin menghapus data ini ?');
		$this->formGeneral();
	
		echo $this->formGroup_button('btn-danger', 'btn-md', 'trash','Lanjutkan');
		echo'</form>';	
	}
	public function form_detailPemain()
	{
		if(!$this->detailPemain($this->get('id_user'))) die($this->alert('danger','Id user not found !'));
		if(isset($_SESSION['role'])){

			 if($_SESSION['role']!='administrator'):
			 	$this->sessionData($this->filter($_SESSION['id_user']));
			 	if($this->datasession['id_club']!=$this->id_club) die($this->alert('danger','Data ini bukan milik Anda !'));

			 endif;
		}
		

		echo '
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
	            <h1 class="h3 mb-0 text-gray-800">Profile Pemain</h1>
	            Detail profile pemain
        </div>
		<div class="row">
			<div class="col-xl-4 col-lg-5">
				<div class="card shadow mb-4">
					<div class="text-center text-capitalize mt-4">
						'.$this->getDirImage_round2('../../content/foto/pemain/',$this->foto_user).'
						<table class="table table-borderless">
							<tr>
								<td>'.$this->nama_user.'<br>'.$this->tempat_lahir.' , '.$this->tgl_lahir.'</td>
							</tr>
							<tr>				
								<td><b>'.$this->get('club').'</b></td>
							</tr>
							<tr>
								<td>'.$this->posisi_pemain.' ('.$this->no_punggung.')</td>
							</tr>
						</table>

					</div>
					<a class="text-center mb-2-4 p-2" href="?page=edit pemain&id_user='.$this->id_user.'&club='.$this->get('club').'">Edit</a>	
				</div>
			</div>
			<div class="col-xl-8 col-lg-7">    
				<div class="card shadow mb-4">
					<div class="table-responsive">
		                <table class="table table-borderless text-capitalize mt-4">
		                  <tbody>

		                  	<tr>
			           			<td> NIK</td>
			           			<td>:</td>	           			
			           			<td>'.$this->nik.'</td>
			           		</tr>
			              	<tr>
			           			<td> No. KK</td>
			           			<td>:</td>	 	           			
			           			<td>'.$this->no_kk.'</td>
			           		</tr>
			           		
			              
			           		<tr>
			           			<td> Tinggi Badan</td>
			           			<td>:</td>	 	           			
			           			<td>'.$this->tinggi_badan.' CM</td>
			           		</tr>
			              	<tr>
			           			<td> Berat Badan</td>
			           			<td>:</td>	 	           			
			           			<td>'.$this->berat_badan.' KG</td>
			           		</tr>
			           		<tr>
			           			<td> Golongan Darah</td>
			           			<td>:</td>	 	           			
			           			<td>'.$this->golongan_darah.'</td>
			           		</tr>
			           		<tr>
			           			<td> Alamat</td>
			           			<td>:</td>	 	           			
			           			<td>'.$this->alamat.'</td>
			           		</tr>
			           		<tr>
			           			<td> Kontak</td>
			           			<td>:</td>	 	           			
			           			<td>'.$this->kontak_pemain.'</td>
			           		</tr>			              
		                  </tbody>
		                </table>
		       		</div>
		
				
				</div>
			</div>


		</div>



		';
	}
	# by session admin club
	public function form_pemainSaya()
	{
		$this->sessionData($this->filter($_SESSION['id_user']));
		$pemain = $this->listAll_Pemain_session($this->datasession['id_club']);
		$pemain_jml = $pemain->num_rows;
		echo
		'
		 <div class="card shadow mb-4">
		 	<div class="card-body">

			 	<div class="table-responsive">
	                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
	                  <thead>
	                  	<tr>
	                  		<td colspan="3">Jumlah Pemain</td>
	                  		<td colspan="2">'.$pemain_jml.'</td>
	                  	</tr>
	                    <tr>
	                      <th>No</th>
	                      <th>Nama Pemain</th>
	                      <th>Kontak</th>
	                      <th>Club</th>                
	                      <th>Aksi</th>
	                   
	                    </tr>
	                  </thead>
	                  <tfoot>
	                    <tr>
	                      <th>No</th>
	                      <th>Nama Pemain</th>
	                      <th>Kontak</th>
	                      <th>Club</th>                     
	                      <th>Aksi</th>
	                    </tr>
	                  </tfoot>
	                  <tbody>';
		           		$no =1;
		              	while($row=$pemain->fetch_array()){
				
							echo'
							<tr>
								<td>'.$no.'</td>
								<td>'.$row['nama_pemain'].'</td>
								<td>'.$row['kontak_pemain'].'</td>
								<td>'.$row['nama_club'].'</td>
								<td>
								
								<a href="?page=edit pemain&id_user='.$row['id_user'].'&club='.$row['nama_club'].'"><i class="fas fa-fw fa-edit"></i></a>
								
								<a href="?page=detail pemain&id_user='.$row['id_user'].'&club='.$row['nama_club'].'"><i class="fas fa-fw fa-eye"></i></a>

								<a href="../../app/pdf/print.pemain.php?id_user='.$row['id_user'].'&club='.$row['nama_club'].'" target="_blank"><i class="fas fa-fw fa-print"></i></a>

								<a href="?page=delete pemain&id_user='.$this->id_club=$row['id_user'].'"><i class="fas fa-fw fa-trash"></i></a>
								
								</td>
							</tr>
							';

							$no+=1;
						}
						$pemain->free_result();

		            
	                   echo'
	                  </tbody>
	                </table>
	            </div>
	        </div>
	     </div>
		';
	}
	public function form_pemainSaya_add()
	{
		$this->sessionData($this->filter($_SESSION['id_user']));

		$nik_err = $nama_err = $tempat_lahir_err = $tgl_err = $alm_err = $pass_err = $pass_kon_err = $role_err = $foto_err = $id_club_err = $kontak_err = $tinggi_badan_err = $berat_badan_err = $no_punggung_err = $no_kk_err = "";

		if($_SERVER['REQUEST_METHOD']=='POST'):
			
				if(empty($this->post('nik'))){
					$nik_err = "Masukan nik dengan benar";
				}elseif($this->validateNumber($this->post('nik'))){
					$nik_err = "No NIK hanya boleh berupa angka";
				}elseif(strlen($this->post('nik'))!=16){
					$nik_err = "No NIK harus 16 digit";
				}
				else{
					#Cek tanpa session				
					if($this->cekNik($this->post('nik'))):
						$nik_err = "Maaf NIK tersebut sudah digunakan";
					else:
						$nik=$this->post('nik');
						$nik=$this->esc($nik);
					endif;
					

				}

				if($this->validateNumber($this->post('no_kk'))){

					$no_kk_err = "Pastikan data berupa no nik sepanjang 16 karakter";
				}elseif(strlen($this->post('nik'))!=16){
					$no_kk_err = "Pastikan data sebanyak 16 karakter";
				}else{

					$no_kk=$this->post('no_kk');
					$no_kk=$this->esc($no_kk);

				}

				if($this->validateNumber($this->post('no_punggung'))){

					$no_punggung_err = "Data harrus berupa angka";

				}else{
					$no_punggung=$this->post('no_punggung');
					$no_punggung=$this->esc($no_punggung);

				}


				$posisi=$this->post('posisi');
				$posisi=$this->esc($posisi);

				if($this->validateNumber($this->post('tinggi_badan'))){
					$tinggi_badan_err = "Masukan tinggi badan dengan benar. Misal 170";
				}else{
					$tinggi_badan=$this->post('tinggi_badan');
					$tinggi_badan=$this->esc($tinggi_badan);
				}

				if($this->validateNumber($this->post('berat_badan'))){
					$tinggi_badan_err = "Masukan berat badan dengan benar. Misal 65";
				}else{
					$berat_badan=$this->post('berat_badan');
					$berat_badan=$this->esc($berat_badan);
				}
							

				$gol_darah=$this->post('gol_darah');
				$gol_darah=$this->esc($gol_darah);

				if(empty($this->post('nama_depan') || $this->post('nama_belakang'))){
					$nama_err = "Nama depan dan belakang wajib diisi";
				}elseif($this->validateName('nama_depan')|| $this->validateName('nama_belakang')){
					$nama_err = "Hanya boleh diisi dengan karakter alphabet";
				}else{
					$nama_lengkap = $this->post('nama_depan').' '.$this->post('nama_belakang');
					$nama_lengkap = $this->esc($nama_lengkap);
				}

				if(empty($this->post('tempat_lahir'))){
					$tempat_lahir_err = "Masukan tempat lahir Anda";
				}else{

					$tempat_lahir=$this->post('tempat_lahir');
					$tempat_lahir=$this->esc($tempat_lahir);
				}

				if(empty($this->post('tgl_lahir'))){
					$tgl_err='tanggal lahir masih kosong';	
				}elseif(strlen($this->post('tgl_lahir'))!=10){
					$tgl_err='Format penulisan tanggal lahir lahir salah';	
				}elseif($this->CekTLS_tanggal($this->post('tgl_lahir'))){
					$tgl_err='Format penulisan tanggal lahir salah. Harus Tgl-Bln-Thn';
				}
				else{
					
					if(!$this->BCA_tanggal($this->post('tgl_lahir'))):
						$tgl_err='Format penulisan tanggal lahir salah. Contoh misal 30-07-1993';
					else:
						$tanggal_lahir=$this->post('tgl_lahir');
						$tanggal_lahir=$this->esc($tanggal_lahir);
					endif;			
				}

				if(empty($this->post('jln_dsn')||$this->post('rt') || $this->post('rw') || $this->post('desa') || $this->post('kec') || $this->post('kab'))){

					$alm_err = "Alamt lengkap wajib diisi";

				}else{
					$alamat = 'Dusun/Jln. '.$this->post('jln_dsn').' RT '.$this->post('rt').' RW '.$this->post('rw').' Desa '.$this->post('desa').' Kec. '.$this->post('kec').' Kab.'.$this->post('kab');
					$alamat = $this->esc($alamat);
					
				}
				if(empty($this->post('kontak'))){
					$kontak_err = "Kontak admin club wajib diisi";
				}elseif($this->validateNumber($this->post('kontak'))){
					$kontak_err = "Harap isi nomor kontak dengan benar, hanya karakter angka yang diperbolehkan";
				}else{
					$kontak = $this->post('kontak');
					$kontak = $this->esc($kontak);
				}

				if(empty($this->post('password'))){
					$pass_err = "Masukan sebuah password";
				}elseif(strlen($this->post('password'))<5){
					$pass_err = "Password tidak boleh kurang dari 5 karakter";
				}else{
					$password = trim($_POST['password']);
					 
				}				
				if(empty(trim($_POST['confir_password']))){
					$pass_kon_err="Masukan konfirmasi password";
				}else{
					$confir_password=trim($_POST['confir_password']);
					if(empty($pass_err) && ($confir_password!=$password)):
						$pass_kon_err="Konfirmasi password tidak cocok";
					endif;
				}

				

				if(empty($this->post('role'))){
					$role_err = "Role user harus dipilih";
				}else{
					$role = $this->post('role');
					$role = $this->esc($role);
					
				}		

		      	$this->getImage2('foto_user','../../content/foto/pemain/',$role);

		      	if(in_array($this->file_extension, $this->file_valid)){
					if($this->file_size>300000){
					    $foto_err="Ukuran foto tidak boleh lebih dari 300KB";
					   }else{
					    $foto_user=$this->file_dir;
					}
				}else{
					$foto_err="Wajib diisi dengan format JPG, JPEG, atau PNG";
				}
				
				if(empty($nama_err) && empty ($pass_err) && empty ($pass_kon_err) && empty ($nik_err) && empty ($foto_err) && empty($kontak_err) && empty($no_punggung_err) && empty($berat_badan_err) && empty($tinggi_badan_err) && empty($alm_err) && empty($tempat_lahir_err) && empty($tgl_err) && empty($role_err)){
					if($role!=='pemain'):

						die("Error");
						
					else:

						if($this->addUser($nik, $password, $role, $nama_lengkap, $foto_user, $this->file_foto, $this->file_destinasi)):
							$data_id=$this->koneksi->insert_id;
							$this->addPemain($data_id, $this->datasession['id_club'], $no_punggung,$posisi, $nama_lengkap, $nik, $no_kk, $tempat_lahir, $tanggal_lahir, $tinggi_badan, $berat_badan, $gol_darah, $alamat, $kontak); 
							$this->addDokumen_pemain($data_id);

							$this->alert('success','Data berhasil disimpan');
							$this->reload_time('2','pemain');
						else:
							$this->alert('danger','Data gagal disimpan');
							$this->reload_time('2','pemain');
						endif;
					endif;

				}
			
		endif;
		$this->alert('info','Silahkan isi data pemain baru yang akan ditambahkan');
		$this->formFile();
		$this->card('Tambah Pemain');	
		echo'	    

	       '.$this->formGroup('key', 'text', 'nik', "Masukan NIK 16 Digit",$nik_err).'
	       '.$this->formGroup('key', 'text', 'no_kk', "Masukan nomor kartu keluarga",$no_kk_err).'
	       <div class="form-group row">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			       '.$this->formGroup('user', 'text', 'no_punggung', "Masukan nomor punggung",$no_punggung_err).'
			    </div>
				<div class="col-sm-6">
					<div class="form-group">
				        <div class="input-group">
					        <div class="input-group-prepend">
					        	<div class="input-group-text"><i class="fas fa-fw fa-arrow-alt-circle-down"></i></div>
					        </div>
					       		<select class="form-control" name="posisi" required="">
					       			
					       			<option value="Goal Keeper">Goal Keeper</option>
					       			<option value="Bek Tengah">Bek Tengah</option>
					       			<option value="Bek Sayap">Bek Sayap</option>
					       			<option value="Gelandang">Gelandang</option>
					       			<option value="Gelandang Bertahan">Gelandang Bertahan</option>
					       			<option value="Gelandang Tengah">Gelandang Tengah</option>
					       			<option value="Gelandang Serang">Gelandang Serang</option>
					       			<option value="Gelandang Sayap">Gelandang Sayap</option>
					       			<option value="Penyerang">Penyerang</option>
					       		</select>
					    </div>	
					            
				     </div>
					
			    </div>			                  
			</div>
			<div class="form-group row">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			       '.$this->formGroup('user', 'text', 'nama_depan', "Masukan nama depan anda",$nama_err).'
			    </div>
				<div class="col-sm-6">
					'.$this->formGroup('user', 'text', 'nama_belakang', "Masukan nama belakang anda",$nama_err).'
			    </div>			                  
			</div>

			<div class="form-group row">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			        '.$this->formGroup('calendar', 'text', 'tempat_lahir', "Masukan tempat lahir anda",$tempat_lahir_err).'
			    </div>
				<div class="col-sm-6">
					'.$this->formGroup_datepicker('calendar', 'text', 'tgl_lahir', "30-07-1993",'tanggal',$tgl_err).'
			    </div>			                  
			</div>

			<div class="form-group row">

			   
			    <div class="col-sm-3">
					'.$this->formGroup('hashtag', 'text', 'tinggi_badan', "Masukan tinggi badan Anda",NULL).'
			
			    </div>	
			    <div class="col-sm-3">
					'.$this->formGroup('hashtag', 'text', 'berat_badan', "Masukan berat badan Anda",NULL).'
			
			    </div>
				<div class="col-sm-6">
					<div class="form-group">
				        <div class="input-group">
					        <div class="input-group-prepend">
					        	<div class="input-group-text"><i class="fas fa-fw fa-arrow-alt-circle-down"></i></div>
					        </div>
					       		<select class="form-control" name="gol_darah" required="">
					       			<option></option>
					       			<option value="A">A</option>
					       			<option value="B">B</option>
					       			<option value="AB">AB</option>
					       			<option value="O">O</option>
					       			<option value="Belum Tahu">Belum Tahu</option>
					       		</select>
					    </div>	
					            
				     </div>
					
			    </div>			                  
			</div>

			<div class="form-group row">

			    <div class="col-sm-4 mb-3 mb-sm-0">			    	
			        '.$this->formGroup('map', 'text', 'jln_dsn', "Nama jalan/dusun",NULL).'			           
			    </div>
			    <div class="col-sm-2">
					'.$this->formGroup('map', 'text', 'rt', "RT",NULL).'
			
			    </div>	
			    <div class="col-sm-2">
					'.$this->formGroup('map', 'text', 'rw', "RW",NULL).'
			
			    </div>
				<div class="col-sm-4">
					'.$this->formGroup('map', 'text', 'desa', "Desa",NULL).'
			
			    </div>			                  
			</div>
			<div class="form-group row">
				<div class="col-sm-6 mb-3 mb-sm-0">			    	
			       '.$this->formGroup('map', 'text', 'kec', "Kecamatan",NULL).'    
			    </div>
			    <div class="col-sm-6 mb-3 mb-sm-0">			    	
			        '.$this->formGroup('map', 'text', 'kab', "Kabupaten",NULL).'       
			    </div>
			</div>
			               
			<div class="form-group row mt-4">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			    	 '.$this->formGroup('key', 'password', 'password', "Masukan password",$pass_err).'
			    </div>
			    <div class="col-sm-6">
			    	 '.$this->formGroup('key', 'password', 'confir_password', "Masukan konfirmasi password",$pass_kon_err).'
			    </div>
			</div>
			'.$this->formGroup('phone', 'text', 'kontak', "Masukan telephone/whatsapp admin",$kontak_err).'
			<input type="hidden" name="role" value="pemain">
			

			
			'.$this->formGroup_file('file','foto_user',$foto_err).'		             
			
			'.$this->formGroup_button('btn-primary', 'btn-md', 'save','Simpan').' 
	    
	    </div>
        </div>
          </form>

        ';   
	}
	public function	form_pemainSaya_edit()
	{
		if(!$this->detailPemain($this->get('id_user'))) die($this->alert('danger','Id user not found !'));
		if(isset($_SESSION['role'])){

			 if($_SESSION['role']!='administrator'):
			 	$this->sessionData($this->filter($_SESSION['id_user']));
			 	if($this->datasession['id_club']!=$this->id_club) die($this->alert('danger','Data ini bukan milik Anda !'));

			 endif;
		}

		$nik_err = $nama_err = $tempat_lahir_err = $tgl_err = $alm_err = $pass_err = $pass_kon_err = $role_err = $foto_err = $id_club_err = $kontak_err = $tinggi_badan_err = $berat_badan_err = $no_punggung_err = $no_kk_err = "";

		if($_SERVER['REQUEST_METHOD']=='POST'):
			if(empty($this->post('nik'))){
					$nik_err = "Masukan nik dengan benar";
				}elseif($this->validateNumber($this->post('nik'))){
					$nik_err = "No NIK hanya boleh berupa angka";
				}elseif(strlen($this->post('nik'))!=16){
					$nik_err = "No NIK harus 16 digit";
				}
				else{
					if($this->post('nik')!=$this->nik){			
						if($this->cekNik($this->post('nik'))):
							$nik_err = "Maaf NIK tersebut sudah digunakan";
						else:
							$nik=$this->post('nik');
							$nik=$this->esc($nik);
						endif;
					}else{

						$nik=$this->post('nik');
						$nik=$this->esc($nik);
					}
						

				}

				if($this->validateNumber($this->post('no_kk'))){

					$no_kk_err = "Pastikan data berupa no nik sepanjang 16 karakter";
				}elseif(strlen($this->post('no_kk'))!=16){
					$no_kk_err = "Pastikan data sebanyak 16 karakter";
				}else{

					$no_kk=$this->post('no_kk');
					$no_kk=$this->esc($no_kk);

				}

				if($this->validateNumber($this->post('no_punggung'))){

					$no_punggung_err = "Data harrus berupa angka";

				}else{
					$no_punggung=$this->post('no_punggung');
					$no_punggung=$this->esc($no_punggung);

				}


				$posisi=$this->post('posisi');
				$posisi=$this->esc($posisi);

				if($this->validateNumber($this->post('tinggi_badan'))){
					$tinggi_badan_err = "Masukan tinggi badan dengan benar. Misal 170";
				}else{
					$tinggi_badan=$this->post('tinggi_badan');
					$tinggi_badan=$this->esc($tinggi_badan);
				}

				if($this->validateNumber($this->post('berat_badan'))){
					$tinggi_badan_err = "Masukan berat badan dengan benar. Misal 65";
				}else{
					$berat_badan=$this->post('berat_badan');
					$berat_badan=$this->esc($berat_badan);
				}
							

				$gol_darah=$this->post('gol_darah');
				$gol_darah=$this->esc($gol_darah);

				if(empty($this->post('nama_depan'))){
					$nama_err = "Nama wajib diisi";
				}elseif($this->validateName('nama_depan')){
					$nama_err = "Hanya boleh diisi dengan karakter alphabet";
				}else{
					$nama_lengkap = $this->post('nama_depan');
					$nama_lengkap = $this->esc($nama_lengkap);
				}

				if(empty($this->post('tempat_lahir'))){
					$tempat_lahir_err = "Masukan tempat lahir Anda";
				}else{

					$tempat_lahir=$this->post('tempat_lahir');
					$tempat_lahir=$this->esc($tempat_lahir);
				}

				if(empty($this->post('tgl_lahir'))){
					$tgl_err='tanggal lahir masih kosong';	
				}elseif(strlen($this->post('tgl_lahir'))!=10){
					$tgl_err='Format penulisan tanggal lahir lahir salah';	
				}elseif($this->CekTLS_tanggal($this->post('tgl_lahir'))){
					$tgl_err='Format penulisan tanggal lahir salah. Harus Tgl-Bln-Thn';
				}
				else{
					
					if(!$this->BCA_tanggal($this->post('tgl_lahir'))):
						$tgl_err='Format penulisan tanggal lahir salah. Contoh misal 30-07-1993';
					else:
						$tanggal_lahir=$this->post('tgl_lahir');
						$tanggal_lahir=$this->esc($tanggal_lahir);
					endif;			
				}

				if(empty($this->post('alamat'))){

					$alm_err = "Alamt lengkap wajib diisi";

				}else{
					$alamat = $this->post('alamat');
					$alamat = $this->esc($alamat);
					
				}
				if(empty($this->post('kontak'))){
					$kontak_err = "Kontak admin club wajib diisi";
				}elseif($this->validateNumber($this->post('kontak'))){
					$kontak_err = "Harap isi nomor kontak dengan benar, hanya karakter angka yang diperbolehkan";
				}else{
					$kontak = $this->post('kontak');
					$kontak = $this->esc($kontak);
				}

				if(!empty($this->post('password'))):
					if(strlen($this->post('password'))<5){
						$pass_err = "Password tidak boleh kurang dari 5 karakter";
					}else{
						$password = trim($_POST['password']);
						 
					}
				endif;
				if(!empty($password)):				
					if(empty(trim($_POST['confir_password']))){
						$pass_kon_err="Masukan konfirmasi password";
					}else{
						$confir_password=trim($_POST['confir_password']);
						if(empty($pass_err) && ($confir_password!=$password)):
							$pass_kon_err="Konfirmasi password tidak cocok";
						endif;
					}
				endif;


		      	if(empty($_FILES['foto_user']['tmp_name'])):
					$foto_user=$this->foto_user;
					$this->file_foto=$this->foto_user;
					$this->file_destinasi="";
				else:
					$this->getImage2('foto_user','../../content/foto/pemain/',$role);
					if(in_array($this->file_extension, $this->file_valid)){
							if($this->file_size>600000){
							    $foto_err="Ukuran foto tidak boleh lebih dari 600KB";
							   }else{
							    $foto_user=$this->file_dir;
							}
					}else{
						$lgo_err="Wajib diisi dengan format JPG, JPEG, atau PNG";
					}
				endif;
				
				if(empty($nama_err) && empty ($pass_err) && empty ($pass_kon_err) && empty ($nik_err) && empty ($foto_err) && empty($kontak_err) && empty($no_punggung_err) && empty($berat_badan_err) && empty($tinggi_badan_err) && empty($alm_err) && empty($tempat_lahir_err) && empty($tgl_err) && empty($role_err) && empty($no_kk_err)){
					if($this->role!=='pemain'):

						die("Error");
						
					else:
						if(!empty($password)){
							if($this->updateUser($nik, $password, $this->role, $nama_lengkap, $foto_user, $this->file_foto, $this->file_destinasi, $this->id_user) && $this->updatePemain($this->datasession['id_club'], $no_punggung,$posisi, $nama_lengkap, $nik, $no_kk, $tempat_lahir, $tanggal_lahir, $tinggi_badan, $berat_badan, $gol_darah, $alamat, $kontak, $this->id_user)):

								$this->alert('success','Data berhasil disimpan');
								$this->reload_time('3','pemain');
							else:
								$this->alert('danger','Data gagal disimpan');
							endif;
						}else{

							if($this->updateUser_noPass($nik, $this->role, $nama_lengkap, $foto_user, $this->file_foto, $this->file_destinasi, $this->id_user) && $this->updatePemain($this->datasession['id_club'], $no_punggung,$posisi, $nama_lengkap, $nik, $no_kk, $tempat_lahir, $tanggal_lahir, $tinggi_badan, $berat_badan, $gol_darah, $alamat, $kontak, $this->id_user)):

								$this->alert('success','Data berhasil disimpan');
								$this->reload_time('3','pemain');
							else:
								$this->alert('danger','Data gagal disimpan');
							endif;
						}
					endif;

				}
		endif;
		$this->alert('info','Silahkan edit data pemain yang ingin Anda rubah. Password tidak usah diisi jika akun yang bersangkutan tidak akan di reset');
		$this->formFile();
		$this->card('Edit Pemain');	
		echo'	    

	       '.$this->formGroup_edit('key', 'text', 'nik', "Masukan NIK 16 Digit",$this->nik, $nik_err).'
	       '.$this->formGroup_edit('key', 'text', 'no_kk', "Masukan nomor kartu keluarga",$this->nik, $no_kk_err).'
	       <div class="form-group row">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			       '.$this->formGroup_edit('user', 'text', 'no_punggung', "Masukan nomor punggung",$this->no_punggung, $no_punggung_err).'
			    </div>
				<div class="col-sm-6">
					<div class="form-group">
				        <div class="input-group">
					        <div class="input-group-prepend">
					        	<div class="input-group-text"><i class="fas fa-fw fa-arrow-alt-circle-down"></i></div>
					        </div>
					       		<select class="form-control" name="posisi" required="">
					       			<option value="'.$this->posisi_pemain.'">'.$this->posisi_pemain.'</option>
					       			<option value="Goal Keeper">Goal Keeper</option>
					       			<option value="Bek Tengah">Bek Tengah</option>
					       			<option value="Bek Sayap">Bek Sayap</option>
					       			<option value="Gelandang">Gelandang</option>
					       			<option value="Gelandang Bertahan">Gelandang Bertahan</option>
					       			<option value="Gelandang Tengah">Gelandang Tengah</option>
					       			<option value="Gelandang Serang">Gelandang Serang</option>
					       			<option value="Gelandang Sayap">Gelandang Sayap</option>
					       			<option value="Penyerang">Penyerang</option>
					       		</select>
					    </div>	
					            
				     </div>
					
			    </div>			                  
			</div>
			'.$this->formGroup_edit('user', 'text', 'nama_depan', 'Masukan nama lengkap pemain',$this->nama_user, $nama_err).'

			<div class="form-group row">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			        '.$this->formGroup_edit('calendar', 'text', 'tempat_lahir', "Masukan tempat lahir anda",$this->tempat_lahir, $tempat_lahir_err).'
			    </div>
				<div class="col-sm-6">
					'.$this->formGroup_datepicker_edit('calendar', 'text', 'tgl_lahir', "30-07-1993",'tanggal',$this->tgl_lahir, $tgl_err).'
			    </div>			                  
			</div>

			<div class="form-group row">

			   
			    <div class="col-sm-3">
					'.$this->formGroup_edit('hashtag', 'text', 'tinggi_badan', "Masukan tinggi badan Anda",$this->tinggi_badan, NULL).'
			
			    </div>	
			    <div class="col-sm-3">
					'.$this->formGroup_edit('hashtag', 'text', 'berat_badan', "Masukan berat badan Anda",$this->berat_badan, NULL).'
			
			    </div>
				<div class="col-sm-6">
					<div class="form-group">
				        <div class="input-group">
					        <div class="input-group-prepend">
					        	<div class="input-group-text"><i class="fas fa-fw fa-arrow-alt-circle-down"></i></div>
					        </div>
					       		<select class="form-control" name="gol_darah" required="">
					       			<option value="'.$this->golongan_darah.'">'.$this->golongan_darah.'</option>
					       			<option value="A">A</option>
					       			<option value="B">B</option>
					       			<option value="AB">AB</option>
					       			<option value="O">O</option>
					       			<option value="Belum Tahu">Belum Tahu</option>
					       		</select>
					    </div>	
					            
				     </div>
					
			    </div>			                  
			</div>

			'.$this->formGroup_Textarea_edit('alamat', 'Masukan alamat secara lengkap', $this->alamat, $alm_err).' 
			               
			<div class="form-group row mt-4">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			    	 '.$this->formGroup_noRequired('key', 'password', 'password', "Masukan password",$pass_err).'
			    </div>
			    <div class="col-sm-6">
			    	 '.$this->formGroup_noRequired('key', 'password', 'confir_password', "Masukan konfirmasi password",$pass_kon_err).'
			    </div>
			</div>
			'.$this->formGroup_edit('phone', 'text', 'kontak', "Masukan telephone/whatsapp pemain",$this->kontak_pemain, $kontak_err).'
			
			'.$this->formGroup_file('file','foto_user',$foto_err).'
			<div class="form-group">
	   		 '.$this->getDirImage2('../../content/foto/pemain/',$this->foto_user).'
	   		</div>	    		             
			
			'.$this->formGroup_button('btn-primary', 'btn-md', 'save','Simpan').' 
	    
	    </div>
        </div>
          </form>

        ';   
	}
	public function form_pemainSaya_pemainLihat()
	{
		$this->sessionData($this->filter($_SESSION['id_user']));
		$pemain = $this->listAll_Pemain_session($this->datasession['id_club']);
		$pemain_jml = $pemain->num_rows;
		echo
		'
		 <div class="card shadow mb-4">
		 	<div class="card-body">

			 	<div class="table-responsive">
	                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
	                  <thead>
	                  	<tr>
	                  		<td colspan="3">Jumlah Pemain</td>
	                  		<td colspan="2">'.$pemain_jml.'</td>
	                  	</tr>
	                    <tr>
	                      <th>No</th>
	                      <th>Nama Pemain</th>
	                      <th>Kontak</th>
	                      <th>Club</th> 
	                      <th>Posisi</th>               
	                      
	                   
	                    </tr>
	                  </thead>
	                  <tfoot>
	                    <tr>
	                      <th>No</th>
	                      <th>Nama Pemain</th>
	                      <th>Kontak</th>
	                      <th>Club</th>
	                      <th>Posisi</th>                     
	                     
	                    </tr>
	                  </tfoot>
	                  <tbody>';
		           		$no =1;
		              	while($row=$pemain->fetch_array()){
				
							echo'
							<tr>
								<td>'.$no.'</td>
								<td>'.$row['nama_pemain'].'</td>
								<td>'.$row['kontak_pemain'].'</td>
								<td>'.$row['nama_club'].'</td>
								<td>'.$row['posisi_pemain'].' / '.$row['no_punggung_pemain'].'</td>
								
							</tr>
							';

							$no+=1;
						}
						$pemain->free_result();

		            
	                   echo'
	                  </tbody>
	                </table>
	            </div>
	        </div>
	     </div>
		';
	}
/***************************
	HTML SETTINGS
****************************/	
	public function form_updateSetting()
	{
		$this->loadInfo();

		$nm_situs_err = $nm_aplikasi_err = $nm_pengelola_err = $des_err = $alm_err = $stat_err = $logo_err = $icon_err = "";

		if(isset($_POST['update_settings'])){
			
			if(empty($this->post('nama_situs'))){
				$nm_situs_err = "Harap masukan nama situs";
			}else{
				$nama_situs = $this->post('nama_situs');
				$nama_situs = $this->esc($nama_situs);
			}
			if(empty($this->post('nama_aplikasi'))){
				$nm_aplikasi_err = "Masukan nama aplikasi Anda";
			}else{
				$nama_aplikasi = $this->post('nama_aplikasi');
				$nama_aplikasi = $this->esc($nama_aplikasi);
			}
			if(empty($this->post('nama_pengelola'))){
				$nm_pengelola_err ="Masukan nama author/pengelola/admin situs";
			}else{
				$nama_pengelola = $this->post('nama_pengelola');
				$nama_pengelola = $this->esc($nama_pengelola);
			}
			if(empty($this->post('deskripsi'))){
				$des_err = "Masukan deskripsi situs Anda";
			}else{
				$deskripsi = $this->post('deskripsi');
				$deskripsi = $this->esc($deskripsi);
			}
			if(empty($this->post('alamat'))){
				$alm_err = "Masukan alamat situs";
			}else{
				$alamat = $this->post('alamat');
				$alamat = $this->esc($alamat);
			}
			if(empty($this->post('status'))){
				$stat_err = "Masukan mode status situs apakah open/sedang maintenance";
			}else{
				$status = $this->post('status');
				$status = $this->esc($status);
			}
			if(empty($nm_situs_err) && empty($nm_aplikasi_err) && empty($nm_pengelola_err) && empty($des_err) && empty($alm_err) && empty($stat_err)){

				if($this->updateSitus($nama_situs, $nama_aplikasi, $nama_pengelola, $deskripsi, $alamat, $status, $this->id_pengaturan)):
					$this->alert('success','Data berhasil disimpan');
					$this->reload_time('1','pengaturan');
				else:
					$this->alert('danger','Data gagal disimpan');
				endif;
			}
		}
		if(isset($_POST['update_logo'])){
			if(empty($_FILES['logo']['tmp_name'])):
					$logo=$this->logo;
					$this->file_logo=$this->logo;
					$this->file_destinasi="";
			else:
					$this->getImage3('logo','../../content/web/','logo');
					if(in_array($this->file_extension, $this->file_valid)){
							if($this->file_size>300000){
							    $logo_err="Ukuran foto tidak boleh lebih dari 300KB";
							   }else{
							    $logo=$this->file_dir;
							}
					}else{
						$logo_err="Wajib diisi dengan format JPG, JPEG, atau PNG";
					}
			endif;
			if(empty($logo_err)){
				if($this->updateLogo($logo, $this->file_logo, $this->file_destinasi, $this->id_pengaturan)):
					$this->alert('success','Data berhasil disimpan');
					$this->reload_time('1','pengaturan');
				else:
					$this->alert('danger','Data gagal disimpan');
				endif;
			}	
		}
		if(isset($_POST['update_icon'])){
			if(empty($_FILES['icon']['tmp_name'])):
					$icon=$this->icon;
					$this->file_logo=$this->icon;
					$this->file_destinasi="";
			else:
					$this->getImage3('icon','../../content/web/','icon');
					if(in_array($this->file_extension, $this->file_valid)){
							if($this->file_size>300000){
							    $icon_err="Ukuran foto tidak boleh lebih dari 300KB";
							   }else{
							    $icon=$this->file_dir;
							}
					}else{
						$icon_err="Wajib diisi dengan format JPG, JPEG, atau PNG";
					}
			endif;
			if(empty($icon_err)){
				if($this->updateIcon($icon, $this->file_logo, $this->file_destinasi, $this->id_pengaturan)):
					$this->alert('success','Data berhasil disimpan');
					
				else:
					$this->alert('danger','Data gagal disimpan');
				endif;
			}	
		}

		$this->formGeneral();
		$this->card('Pengaturan Situs');	
		echo'	    
		<div class="form-group row">
			<div class="col-md-4">	
		     '.$this->formGroup_edit('edit', 'text', 'nama_situs', "Masukan nama situs",$this->nama_situs, $nm_situs_err).'
		    </div>
		    <div class="col-md-4">	
		     '.$this->formGroup_edit('edit', 'text', 'nama_aplikasi', "Masukan nama aplikasi",$this->nama_aplikasi, $nm_aplikasi_err).'
		    </div>
		    <div class="col-md-4">	
		     '.$this->formGroup_edit('user', 'text', 'nama_pengelola', "Masukan nama admin pengelola",$this->nama_pengelola, $nm_pengelola_err).'
		    </div>
	    </div>
	    '.$this->formGroup_Textarea_edit('deskripsi', 'Masukan deskripsi situs', $this->deskripsi_situs, $des_err).'

	    '.$this->formGroup_Textarea_edit('alamat', 'Masukan alamat kantor', $this->alamat_situs, $alm_err).'
	    <div class="form-group">
			<div class="input-group">
				<div class="input-group-prepend">
					<div class="input-group-text"><i class="fas fa-fw fa-arrow-alt-circle-down"></i></div>
					</div>
					<select class="form-control" name="status" required="">		
						<option value="'.$this->status.'">'.$this->status.'</option>
						<option value="Open">Open</option>
						<option value="Maintenance">Maintenance</option>     			
					</select>
			</div>	
					            
		</div>
		'.$this->formGroup_button2('update_settings', 'btn-md','save', 'Simpan').'
	    </div></div></form>';
	    # Update Logo
	    $this->formFile();
		$this->card('Logo');
		echo'
		'.$this->formGroup_file('file', 'logo', $logo_err).'
		<div class="form-group">
	   		 '.$this->getDirImage2('../../content/web/',$this->logo).'
	   	</div>
		'.$this->formGroup_button2('update_logo', 'btn-md','save', 'Simpan').'
		</div></div></form>';
		 # Update Icon
	    $this->formFile();
		$this->card('Favicon');
		echo'
		'.$this->formGroup_file('file', 'icon', $icon_err).'
		<div class="form-group">
	   		 '.$this->getDirImage2('../../content/web/',$this->icon).'
	   	</div>
		'.$this->formGroup_button2('update_icon', 'btn-md','save', 'Simpan').'
		</div></div></form>';	    
	}
/***************************
	HTML BERITA
****************************/
	public function berita()
	{
		$this->card('Berita');
		echo
		'
		<style>
		.table td, .table th {padding: .45rem;}	
		.table tr {border-bottom:1px solid #ccc;}
		
		</style>
		<a class="btn btn-sm btn-md btn-primary" href="?page=buat berita"> + New Post </a>
		 <div class="table-responsive">
                <table class="table table-borderless" style="padding:.25rem">
                  <thead>
                   
                  </thead>
                  
                  <tbody>';

                  	$berita=$this->showBerita();
                  	if($berita->num_rows>0){
                  		while($row=$berita->fetch_array()){
                  			echo'<tr>

                  					<td><a href="#">'.substr($row['judul_berita'],0,100).'</a></td>';
                  					
                  					if($row['status_berita']=='Draft'){

                  						echo '<td><span class="text-danger">Draft</span></td>';
                  					}
                  					echo'
                  					<td>
                  					<a href="?page=lihat berita&id_berita='.$row['id_berita'].'" title="lihat berita">                 					
                  					<i class="fas fa-fw fa-eye"></i>
                  					</a>
                  					<a href="?page=edit berita&id_berita='.$row['id_berita'].'" title="edit berita"><i class="fas fa-fw fa-edit"></i>
                  					</a>
                  					<a href="?page=delete berita&id_berita='.$row['id_berita'].'" title="delete berita"><i class="fas fa-fw fa-trash"></i>
                  					</a>
                  					</td>

                  					
                  				</tr>';
                  		}
                  		$berita->free_result();
                  	}else{
                  		echo '<tr><td colspan="2" align="center">Belum ada berita <a href="?page=buat berita"> <em>Buat Berita</em></a></td></tr>';
                  	}
                  	echo'
                  </tbody>
                </table>
              </div>
            </div>
            </div>

		';
	}
	public function form_limitBerita(){
	
	
		$this->card('Berita');
		echo
		'
			<style>
			
			.table tr {border-bottom:1px solid #ccc;}
			.fas{font-size:18px;}
			</style>
			
		
			<a class="btn btn-sm btn-md btn-primary mb-4" href="?page=buat berita"> + New Post </a>
			<div class="table-responsive">
                <table class="table table-borderless" style="padding:.25rem">
                  <thead>
                   
                  </thead>
                  
                  <tbody>';

                  	$main_berita=$this->limitBerita();	
                  	if($main_berita->num_rows>0){
                  		while($row=$main_berita->fetch_array()){
                  			echo'<tr>

                  					<td><span style="font-size:18px;">'.substr($row['judul_berita'],0,100).'</span></td>';
                  					
                  					if($row['status_berita']=='Draft'){

                  						echo '<td><span class="text-danger">Draft</span></td>';
                  					}
                  					echo'
                  					<td>
                  					<a href="?page=lihat berita&id_berita='.$row['id_berita'].'" title="lihat berita">                 					
                  					<i class="fas fa-fw fa-eye"></i>
                  					</a>
                  					<a href="?page=edit berita&id_berita='.$row['id_berita'].'" title="edit berita"><i class="fas fa-fw fa-edit"></i>
                  					</a>
                  					<a href="?page=delete berita&id_berita='.$row['id_berita'].'" title="delete berita"><i class="fas fa-fw fa-trash"></i>
                  					</a>
                  					</td>

                  					
                  				</tr>';
                  		}
                  		
                  	}else{
                  		echo '<tr><td colspan="2" align="center">Belum ada berita <a href="?page=buat berita"> <em>Buat Berita</em></a></td></tr>';
                  	}
                  	echo'
	                  </tbody>
	                </table>
	              </div>
	            </div>
            </div>


		';
			
	
		

		
        $t=$this->showBerita();
        $total = $t->num_rows;  
        # Total data dibagi total keinginan pembagian perhalaman            
        $pages = ceil($total/$this->halaman);
        $i=1;  
                          
             
            if (!isset($_GET['halaman'])) { $_GET['halaman']='1'; }

        if($pages>0):
            if($i<$_GET['halaman']){
               echo'
               <ul class="pagination justify-content-center">
	               <li class="page-item">
	                <a class="page-link" href="javascript:history.back()" aria-label="Previous">
	                  <span aria-hidden="true">&laquo;</span>
	                  <span class="sr-only">Previous</span>
	                </a>
	              </li>';
             }else{
          
              echo'
               <ul class="pagination justify-content-center">
                 <li class="page-item">
                  
                </li>';
             }
             	for ($i=1; $i<=$pages ; $i++){ 
	               //Bagian nomor halaman ketika belum/sudah terjadi request get
	                echo'
	               	 	<li class="page-item">          
	                  		<a class="page-link" href="?page=berita&halaman='.$i.'">'.$i.'</a>
	                  	</li>'; 
                }
     
                if($_GET['halaman']==$pages){

             
                    echo'
                    <li class="page-item">
                      
                    </li>
                  </ul>';
                 }else{
               
                 	if($this->get('halaman')>$pages):

                 		$this->reload_time('1','berita');
	                  
	               else:

	               		$number=$this->get('halaman');
	               		if(!is_numeric($number)) die($this->reload_time('1','berita'));

		               	echo'
		                  <li class="page-item">
		                    <a class="page-link" href="?page=berita&halaman='.($number+1).'"aria-label="Next">
		                      <span aria-hidden="true">&raquo;</span>
		                      <span class="sr-only">Next</span>
		                    </a>
		                  </li>
		                </ul>';
	               endif;
            }
        endif;
	}
	public function form_addBerita()
	{
		$this->sessionData($this->filter($_SESSION['id_user']));
		$judul_err= $isi_err= $kategori_err= $status_err =  $gambar_err = "";

		if($_SERVER['REQUEST_METHOD']=='POST'):
			if(empty($this->post('judul'))){
				$judul_err = 'Harap masukan judul berita';
			}else{
				$judul = $this->post('judul');
				$judul = $this->esc($judul);
			}
			if(empty($this->post('isi'))){
				$isi_err = 'Harap masukan isi berita';
			}else{
				$isi = $this->post('isi');

			}
			if(empty($this->post('kategori'))){
				$kategori_err = 'Harap masukan kategori berita';
			}else{
				$kategori = $this->post('kategori');
				$kategori = $this->esc($kategori);
			}
			if(empty($this->post('status'))){
				$status_err ='Masukan status berita';
			}else{
				$status = $this->post('status');
				$status = $this->esc($status);
			}

			$penulis = $this->datasession['nama_user'];

			$tanggal = $this->tanggalIndo();

			$this->getImage2('gambar','../../content/berita/','berita');
				if(in_array($this->file_extension, $this->file_valid)){
					if($this->file_size>2000000){
						$gambar_err="Ukuran foto tidak boleh lebih dari 2MB";
					}else{
						$gambar=$this->file_dir;
					}
				}else{
					$gambar_err="Wajib diisi dengan format JPG, JPEG, atau PNG";
				}
			
			//echo $judul.$isi.$kategori.$status.$penulis.$gambar.$tanggal.$this->file_foto.$this->file_destinasi;

			if(empty($judul_err) && empty($isi_err) && empty($kategori_err) && empty($status_err) && empty($gambar_err)){
				
				if($this->insertBerita($judul, $isi, $kategori, $status, $penulis, $gambar, $tanggal, $this->file_foto, $this->file_destinasi)):
					$this->alert('success','Berita berhasil ditambahkan');
				else:
					$this->alert('danger','Berita gagal ditambahkan');
					
				endif;
				
			}
		endif;
		$this->formFile();
		$this->card('Tambah Berita');	
		echo'	    
		
	    '.$this->formGroup('edit', 'text', 'judul', "Judul Berita",$judul_err).'
	    '.$this->formGroup_TextareaCkeditor('isi', 'isi berita', $isi_err).'

	    <div class="form-group">
			
			<input class="form-control" type="text" name="kategori" id="kategori"  list="list_kategori" placeholder="Ketik atau pilih kategori berita">
				    <datalist id="list_kategori">';					        
					  		$kategori=$this->showKategori();
					  		while($kat=$kategori->fetch_array()):
					  			echo '<option value="'.$kat['kategori_berita'].'">'.$kat['kategori_berita'].'</option>';
					  		endwhile;
					  		$kategori->free_result();				         
				    echo'
				    </datalist>
				<span class="text-danger">'.$kategori_err.'</span>
		</div> 
	    
	    <div class="form-group">
			<div class="input-group">
				<div class="input-group-prepend">
					<div class="input-group-text"><i class="fas fa-fw fa-arrow-alt-circle-down"></i></div>
					</div>
					<select class="form-control" name="status" required="">		
						
						<option value="Diterbitkan">Diterbitkan</option>
						<option value="Draft">Draft</option>     			
					</select>
			</div>						            
		</div>
		'.$this->formGroup_file('file', 'gambar', $gambar_err).'
		'.$this->formGroup_button2('berita', 'btn-md','save', 'Simpan').'
	    </div></div></form>';
	}
	public function form_editBerita()
	{
		if(!$this->detailBerita($this->get('id_berita'))) die($this->alert('danger','Error : Id Not found'));

		$judul_err= $isi_err= $kategori_err= $status_err =  $gambar_err = "";
		if($_SERVER['REQUEST_METHOD']=='POST'):
			if(empty($this->post('judul'))){
				$judul_err = 'Harap masukan judul berita';
			}else{
				$judul = $this->post('judul');
				$judul = $this->esc($judul);
			}
			if(empty($this->post('isi'))){
				$isi_err = 'Harap masukan isi berita';
			}else{
				$isi = $this->post('isi');

			}
			if(empty($this->post('kategori'))){
				$kategori_err = 'Harap masukan kategori berita';
			}else{
				$kategori = $this->post('kategori');
				$kategori = $this->esc($kategori);
			}
			if(empty($this->post('status'))){
				$status_err ='Masukan status berita';
			}else{
				$status = $this->post('status');
				$status = $this->esc($status);
			}

			$penulis = $this->penulis_berita;

			$tanggal = $this->tanggal_berita;
			

			if(empty($_FILES['gambar']['tmp_name'])):
					$gambar=$this->gambar_berita;
					$this->file_foto=$this->gambar_berita;
					$this->file_destinasi="";
			else:
					
					$this->getImage2('gambar','../../content/berita/','berita');
					if(in_array($this->file_extension, $this->file_valid)){
						if($this->file_size>2000000){
							$gambar_err="Ukuran foto tidak boleh lebih dari 2MB";
						}else{
							$gambar=$this->file_dir;
						}
					}else{
						$gambar_err="Wajib diisi dengan format JPG, JPEG, atau PNG";
					}
			endif;
			
			//echo $judul.$isi.$kategori.$status.$penulis.$gambar.$tanggal.$this->file_foto.$this->file_destinasi;

			if(empty($judul_err) && empty($isi_err) && empty($kategori_err) && empty($status_err) && empty($gambar_err)){
				
				if($this->updateBerita($judul, $isi, $kategori, $status, $penulis, $gambar, $tanggal, $this->file_foto, $this->file_destinasi, $this->id_berita)):
					$this->alert('success','Berita berhasil diperbaharui');
					$this->reload_time('0','edit berita&id_berita='.$this->id_berita.'');
				else:
					$this->alert('danger','Berita gagal diperbaharui');
					
				endif;
				
			}
		endif;

		$this->formFile();
		$this->card('Edit Berita');	
		echo'	    
		
	    '.$this->formGroup_edit('book', 'text', 'judul', "Judul Berita",$this->judul_berita, $judul_err).'
	    '.$this->formGroup_TextareaCkeditor_edit('isi', 'isi berita', $this->isi_berita, $isi_err).'

	    <div class="form-group">
			
			<input class="form-control" type="text" name="kategori" id="kategori"  list="list_kategori" placeholder="Ketik atau pilih kategori berita">
				    <datalist id="list_kategori">
				    <option value="'.$this->kategori_berita.'">'.$this->kategori_berita.'</option>
				    ';	

					  		$kategori=$this->showKategori();
					  		while($kat=$kategori->fetch_array()):
					  			echo '<option value="'.$kat['kategori_berita'].'">'.$kat['kategori_berita'].'</option>';
					  		endwhile;
					  		$kategori->free_result();				         
				    echo'
				    </datalist>
				<a href="#" class="btn btn-sm mt-2 btn-secondary">'.$this->kategori_berita.'</a>
				<span class="text-danger">'.$kategori_err.'</span>
		</div> 
	    
	    <div class="form-group">
			<div class="input-group">
				<div class="input-group-prepend">
					<div class="input-group-text"><i class="fas fa-fw fa-arrow-alt-circle-down"></i></div>
					</div>
					<select class="form-control" name="status" required="">		
						<option value="'.$this->status_berita.'">'.$this->status_berita.'</option>
						<option value="Diterbitkan">Diterbitkan</option>
						<option value="Draft">Draft</option>     			
					</select>
			</div>						            
		</div>
		'.$this->formGroup_file('file', 'gambar', $gambar_err).'
		<div class="form-group">
	   		 '.$this->getDirImage2('../../content/berita/',$this->gambar_berita).'
	   	</div>	
		'.$this->formGroup_button2('berita', 'btn-md','save', 'Simpan').'
		<a class="btn btn-md btn-primary" href="?page=berita">Kembali</a>
					
	    </div></div></form>';

	}
	public function form_lihatBerita()
	{
		if(!$this->detailBerita($this->get('id_berita'))) die($this->alert('danger','Error : Id Not found'));
		echo '

		'.$this->card('Berita Harian').'
		<div class="d-flex justify-content-center">
			'.$this->getDirImage_artikel('../../content/berita/',$this->gambar_berita).'
		</div>

		<div class="d-sm-flex align-items-center justify-content-between mt-4">
	        <b>Berita Harian</b>
	        <b>'.$this->tanggal_berita.'</b>

        </div>
        <hr/>
		

        <h3 class="mt-2">'.$this->judul_berita.'</h3>
        <div class="row mt-2 p-3">
        	'.htmlspecialchars_decode($this->isi_berita).'
        </div>
        <div class="d-flex mt-4">
        	<i class="fas fa-fw fa-user"></i>'.$this->penulis_berita.' &nbsp;        
        	<i class="fas fa-fw fa-tag"></i>'.$this->kategori_berita.'&nbsp;
        	<i class="fas fa-fw fa-edit"></i><a href="?page=edit berita&id_berita='.$this->id_berita.'" title="edit berita">Edit </a>

        </div>
        </div></div>
        ';
	}
	public function form_deleteBerita()
	{
		if(!$this->detailBerita($this->get('id_berita'))) die($this->alert('danger','Error : Id Not found'));
		if($_SERVER['REQUEST_METHOD']=='POST'):
			if($this->getImage_unlink('../../content/berita/',$this->gambar_berita)){
				if($this->deleteBerita($this->id_berita)):
					$this->alert('success','Data berhasil dihapus');
					$this->reload_time('1','berita');
				else:
					$this->alert('danger','Data gagal dihapus');
				endif;
			}else{
				$this->alert('danger','Gagal menghapus gambar');
			}

		endif;
		$this->formGeneral();
		$this->card('Konfirmasi');

		echo'
			<p class="mb-4">
				Apakah anda yakin ingin menghapus data ini ?
			</p>
		'.$this->formGroup_button('submit', 'btn-md btn-danger', 'trash', 'Delete').'
		</div></div>';

	}
	public function kategori()
	{
		$kategori_err ="";
		if(isset($_POST['simpan'])){
			if(empty($this->post('kategori'))){
				$kategori_err = "Masukan kategori";
			}else{
				$kategori = $this->post('kategori');
				$kategori = $this->esc($kategori);
			}
			if(empty($kategori_err)){
				if($this->insertKategori($kategori)):
					$this->alert('success','Kategori berita berhasil ditambahkan');
				else:
					$this->alert('danger','Kategori gagal ditambahkan');
				endif;

			}
		}
		echo
		'
			<ul class="nav nav-tabs mb-4" role="tablist">
			    <li class="nav-item">
			      <a class="nav-link active" data-toggle="tab" href="#home">Kategori</a>
			    </li>
			    <li class="nav-item">
			      <a class="nav-link" data-toggle="tab" href="#menu1">Daftar Kategori</a>
			    </li>		    
		  </ul>
		  <div class="tab-content">
			<div id="home" class="tab-pane active">
		';

				$this->formGeneral();
				$this->card('Buat Kategori');
				echo'
				<div class="row">
					<div class="col-xl-7 col-lg-7">
					'.$this->formGroup('book', 'text', 'kategori', "Masukan nama kategori",$kategori_err).'
						
					</div>
					<div class="col-xl-4 col-lg-4">
						 '.$this->formGroup_button2('simpan','btn-md,','save', 'Simpan').'
						 
					</div>
				</div></div></div></form>
			</div>
			<div id="menu1" class="container tab-pane fade">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Katgeori</h6>
                </div>
                <div class="card-body">
                	<div class="mb-2">
			 ';
		
				$list=$this->showKategori();
				while($row=$list->fetch_array()):
					echo '   
					<a href="?page=delete kategori&id_kategori='.$row['id_kategori'].'" class="btn btn-danger">
	                    <i class="fas fa-trash"></i> '.$row['kategori_berita'].'
	                  </a>
	                ';

				endwhile;
			echo'
				</div>
				</div>
				</div>
			</div>
			</div>';
	}
	public function form_deleteKategori()
	{
		if(!$this->detailKategori($this->get('id_kategori'))) die($this->alert('danger','Error : id kategori not found'));
		if($this->deleteKategori($this->id_kategori)):
			$this->alert('success','Kategori berhasil dihapus');
			$this->reload_time('1','kategori');
		else:
			$this->alert('danger','Kategori gagal didelete');
		endif;
	}
/***************************
	HTML PAGES
****************************/
	public function form_addPages()
	{
		$this->sessionData($this->filter($_SESSION['id_user']));
		$judul_err= $isi_err= "";

		if($_SERVER['REQUEST_METHOD']=='POST'):
			if(empty($this->post('judul'))){
				$judul_err = 'Harap masukan judul berita';
			}else{
				$judul = $this->post('judul');
				$judul = $this->esc($judul);
			}
			if(empty($this->post('isi'))){
				$isi_err = 'Harap masukan isi berita';
			}else{
				$isi = $this->post('isi');

			}
			

			$penulis = $this->datasession['nama_user'];					

			if(empty($judul_err) && empty($isi_err)){
				
				if($this->insertPages($judul, $isi, $penulis)):
					$this->alert('success','Halaman berhasil ditambahkan');
				else:
					$this->alert('danger','Halaman gagal ditambahkan');
					
				endif;
				
			}
		endif;
		$this->formGeneral();
		$this->card('Tambah Halaman');	
		echo'	    
		
	    '.$this->formGroup('edit', 'text', 'judul', "Judul",$judul_err).'
	    '.$this->formGroup_TextareaCkeditor('isi', 'isi', $isi_err).'

	    
		'.$this->formGroup_button2('berita', 'btn-md','save', 'Simpan').'
	    </div></div></form>';
	}
	public function form_editPages()
	{
		if(!$this->detailPages($this->get('id_pages'))) die($this->alert('danger','Error : Id halaman tidak ditemukan'));
		$judul_err= $isi_err= "";

		if($_SERVER['REQUEST_METHOD']=='POST'):
			if(empty($this->post('judul'))){
				$judul_err = 'Harap masukan judul berita';
			}else{
				$judul = $this->post('judul');
				$judul = $this->esc($judul);
			}
			if(empty($this->post('isi'))){
				$isi_err = 'Harap masukan isi berita';
			}else{
				$isi = $this->post('isi');
			}
			if(empty($judul_err) && empty($isi_err)){
				
				if($this->updatePages($judul, $isi, $this->penulis_pages, $this->id_pages)):
					$this->alert('success','Halaman berhasil diperbaharui');
				else:
					$this->alert('danger','Halaman gagal diperbaharui');
					
				endif;	
			}
		endif;
		$this->formGeneral();
		$this->card('Tambah Halaman');	
		echo'	    
		
	    '.$this->formGroup_edit('edit', 'text', 'judul', "Judul",$this->judul_pages, $judul_err).'
	    '.$this->formGroup_TextareaCkeditor_edit('isi', 'isi', $this->isi_pages, $isi_err).'

	    
		'.$this->formGroup_button2('berita', 'btn-md','save', 'Simpan').'
	    </div></div></form>';
	}
	public function form_pages()
	{
		$this->card('Halaman');
		echo
		'
			<style>
			
			.table tr {border-bottom:1px solid #ccc;}
			.fas{font-size:18px;}
			</style>
			
		
			<a class="btn btn-sm btn-md btn-primary mb-4" href="?page=tambah halaman"> + Buat Halaman </a>
			<div class="table-responsive">
                <table class="table table-borderless" style="padding:.25rem">
                  <thead>
                   
                  </thead>
                  
                  <tbody>';

                  	$main_pages=$this->limitPages();	
                  	if($main_pages->num_rows>0){
                  		while($row=$main_pages->fetch_array()){
                  			echo'<tr>

                  					<td><span style="font-size:18px;">'.substr($row['judul_pages'],0,100).'</span></td>';
                  					
                  					
                  					echo'
                  					<td>
                  					<a href="?page=lihat halaman&id_pages='.$row['id_pages'].'" title="lihat pages">                 					
                  					<i class="fas fa-fw fa-eye"></i>
                  					</a>
                  					<a href="?page=edit halaman&id_pages='.$row['id_pages'].'" title="edit pages"><i class="fas fa-fw fa-edit"></i>
                  					</a>
                  					<a href="?page=delete halaman&id_pages='.$row['id_pages'].'" title="delete berita"><i class="fas fa-fw fa-trash"></i>
                  					</a>
                  					</td>

                  					
                  				</tr>';
                  		}
                  		
                  	}else{
                  		echo '<tr><td colspan="2" align="center">Belum ada halaman yang ditambahkan <a href="?page=tambah halaman"> <em>Buat Halaman</em></a></td></tr>';
                  	}
                  	echo'
	                  </tbody>
	                </table>
	              </div>
	            </div>
            </div>


		';
			
	
		

		
        $t=$this->pages();
        $total = $t->num_rows;  
        # Total data dibagi total keinginan pembagian perhalaman            
        $pages = ceil($total/$this->halaman);
        $i=1;  
                          
             
            if (!isset($_GET['halaman'])) { $_GET['halaman']='1'; }

        if($pages>0):
            if($i<$_GET['halaman']){
               echo'
               <ul class="pagination justify-content-center">
	               <li class="page-item">
	                <a class="page-link" href="javascript:history.back()" aria-label="Previous">
	                  <span aria-hidden="true">&laquo;</span>
	                  <span class="sr-only">Previous</span>
	                </a>
	              </li>';
             }else{
          
              echo'
               <ul class="pagination justify-content-center">
                 <li class="page-item">
                  
                </li>';
             }
             	for ($i=1; $i<=$pages ; $i++){ 
	               //Bagian nomor halaman ketika belum/sudah terjadi request get
	                echo'
	               	 	<li class="page-item">          
	                  		<a class="page-link" href="?page=halaman&halaman='.$i.'">'.$i.'</a>
	                  	</li>'; 
                }
     
                if($_GET['halaman']==$pages){

             
                    echo'
                    <li class="page-item">
                      
                    </li>
                  </ul>';
                 }else{
               
                 	if($this->get('halaman')>$pages):

                 		$this->reload_time('1','halaman');
	                  
	               else:

	               		$number=$this->get('halaman');
	               		if(!is_numeric($number)) die($this->reload_time('1','berita'));

		               	echo'
		                  <li class="page-item">
		                    <a class="page-link" href="?page=halaman&halaman='.($number+1).'"aria-label="Next">
		                      <span aria-hidden="true">&raquo;</span>
		                      <span class="sr-only">Next</span>
		                    </a>
		                  </li>
		                </ul>';
	               endif;
            }
        endif;
	}
	public function form_lihatPages()
	{
		if(!$this->detailPages($this->get('id_pages'))) die($this->alert('danger','Error : Id pages Not found'));
		echo '

		'.$this->card('Halaman').'	

        <h3 class="mt-2">'.$this->judul_pages.'</h3>
        <div class="row mt-2 p-3">
        	'.htmlspecialchars_decode($this->isi_pages).'
        </div>
        <div class="d-flex mt-4">
        	<i class="fas fa-fw fa-user"></i>'.$this->penulis_pages.' &nbsp;        
        </div>
        </div></div>
        ';
	}
	public function form_deletePages()
	{
		if(!$this->detailPages($this->get('id_pages'))) die($this->alert('danger','Error : Id pages Not found'));
		if($_SERVER['REQUEST_METHOD']=='POST'):
			if($this->deletePages($this->id_pages)):
				$this->alert('success','Data berhasil dihapus');
				$this->reload_time('2','halaman');
			else:
				$this->alert('danger','Data gagal dihapus');
				$this->reload_time('5','halaman');
			endif;
		endif;
		$this->formGeneral();
		$this->card('Konfirmasi');

		echo'
			<p class="mb-4">
				Apakah anda yakin ingin menghapus data ini ?
			</p>
		'.$this->formGroup_button('submit', 'btn-md btn-danger', 'trash', 'Delete').'
		</div></div>';
	}
/***************************
	UPDATE PROFILE
****************************/
	public function form_updateProfile_users()
	{
		$this->sessionData($this->filter($_SESSION['id_user']));

		$nik_err = $nama_err = $pass_err = $pass_kon_err = $foto_err = "";
		if(isset($_POST['update_profile'])):
			
				if(empty($this->post('nik'))){
					$nik_err = "Masukan nik dengan benar";
				}elseif($this->validateNumber($this->post('nik'))){
					$nik_err = "No NIK hanya boleh berupa angka";
				}elseif(strlen($this->post('nik'))!=16){
					$nik_err = "No NIK harus 16 digit";
				}else{
					if($this->post('nik')!=$this->datasession['nik']):
	                    if($this->cekNik($this->post('nik'))){
	                        $nik_err="Maaf nik tersebut sudah digunakan";
	                    }else{
	                        $nik=$this->post('nik');
	                        $nik=$this->esc($nik);
	                    }
                	else:
	                  $nik=$this->post('nik');
	                  $nik=$this->esc($nik);
	                endif;
				}				

				if(empty($this->post('nama_lengkap'))){
					$nama_err = "Nama lengkap wajib diisi";
				}elseif($this->validateName('nama_lengkap')){
					$nama_err = "Hanya boleh diisi dengan karakter alphabet";
				}else{
					$nama_lengkap = $this->post('nama_lengkap');
					$nama_lengkap = $this->esc($nama_lengkap);
				}

				if(!empty($this->post('password'))):
					if(strlen($this->post('password'))<5){
						$pass_err = "Password tidak boleh kurang dari 5 karakter";
					}else{
						$password = trim($_POST['password']);
						 
					}
				endif;
				if(!empty($password)):				
					if(empty(trim($_POST['confir_password']))){
						$pass_kon_err="Masukan konfirmasi password";
					}else{
						$confir_password=trim($_POST['confir_password']);
						if(empty($pass_err) && ($confir_password!=$password)):
							$pass_kon_err="Konfirmasi password tidak cocok";
						endif;
					}
				endif;
				

		      	if(empty($_FILES['foto_user']['tmp_name'])):
					$foto_user=$this->datasession['foto_user'];
					$this->file_foto=$this->datasession['foto_user'];
					$this->file_destinasi="";
				else:
					$this->getImage2('foto_user','../../content/foto/'.$this->datasession['role'].'/','user');
					if(in_array($this->file_extension, $this->file_valid)){
							if($this->file_size>600000){
							    $foto_err="Ukuran foto tidak boleh lebih dari 600KB";
							   }else{
							    $foto_user=$this->file_dir;
							}
					}else{
						$lgo_err="Wajib diisi dengan format JPG, JPEG, atau PNG";
					}
				endif;
				
				if(empty($nama_err) && empty ($pass_err) && empty ($pass_kon_err) && empty ($nik_err) && empty ($foto_err)){			
					if(!empty($password)){
						if($this->updateProfile($nik, $password, $this->datasession['role'], $nama_lengkap, $foto_user, $this->file_foto, $this->file_destinasi, $this->datasession['id_user'])):

							$this->alert('success','Data berhasil diperbaharui');
							$this->reload_time('1','profile');
						else:
							$this->alert('danger','Data gagal diperbaharui');
						endif;
					}else{
						if($this->updateUser_noPass($nik,$this->datasession['role'], $nama_lengkap, $foto_user, $this->file_foto, $this->file_destinasi, $this->datasession['id_user'])):

							$this->alert('success','Data berhasil diperbaharui');
							$this->reload_time('1','profile');
						else:
							$this->alert('danger','Data gagal diperbaharui');
						endif;
					}

				
				}
			
		endif;
	
		$this->formFile();
		$this->card('Edit Akun');	
	
		echo'	    

	       '.$this->formGroup_edit('key', 'text', 'nik', "Masukan NIK 16 Digit", $this->datasession['nik'], $nik_err).'
			'.$this->formGroup_edit('user', 'text', 'nama_lengkap', "Masukan nama lengkap",$this->datasession['nama_user'], $nama_err).'

	     
			<div class="form-group row mt-4">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			    	 '.$this->formGroup_noRequired('key', 'password', 'password', "Masukan password",$pass_err).'
			    </div>
			    <div class="col-sm-6">
			    	 '.$this->formGroup_noRequired('key', 'password', 'confir_password', "Masukan konfirmasi password",$pass_kon_err).'
			    </div>
			</div>
		
			'.$this->formGroup_file('file','foto_user',$foto_err).'	

			<div class="form-group">
	   		 '.$this->getDirImage2('../../content/foto/'.$this->datasession['role'].'/',$this->datasession['foto_user']).'
	   		</div>	             
			
			'.$this->formGroup_button2('update_profile','btn-md', 'save','Simpan').' 
	    
	    </div>
        </div>
        </form>

        '; 
        if($_SESSION['role']=='petugas'):
        	$this->form_updateProfile_usersPetugas();
        elseif($_SESSION['role']=='adminclub'):
        		$this->form_updateProfile_usersAdminclub();
        else:
        	if($_SESSION['role']=='pemain'):
        		$this->form_updateProfile_usersPemain();
        	endif;
        endif; 
	}
	public function form_updateProfile_usersPetugas()
	{
		$nama_err = $tempat_lahir_err = $tgl_err = $alm_err = $kontak_err = "";
		if(isset($_POST['update_petugas'])):		
			
				if(empty($this->post('nama_lengkap'))){
					$nama_err = "Nama lengkap wajib diisi";
				}elseif($this->validateName('nama_lengkap')){
					$nama_err = "Hanya boleh diisi dengan karakter alphabet";
				}else{
					$nama_lengkap = $this->post('nama_lengkap');
					$nama_lengkap = $this->esc($nama_lengkap);
				}

				if(empty($this->post('tempat_lahir'))){
					$tempat_lahir_err = "Masukan tempat lahir Anda";
				}else{

					$tempat_lahir=$this->post('tempat_lahir');
					$tempat_lahir=$this->esc($tempat_lahir);
				}

				if(empty($this->post('tgl_lahir'))){
					$tgl_err='tanggal lahir masih kosong';	
				}elseif(strlen($this->post('tgl_lahir'))!=10){
					$tgl_err='Format penulisan tanggal lahir lahir salah';	
				}elseif($this->CekTLS_tanggal($this->post('tgl_lahir'))){
					$tgl_err='Format penulisan tanggal lahir salah. Harus Tgl-Bln-Thn';
				}
				else{
					
					if(!$this->BCA_tanggal($this->post('tgl_lahir'))):
						$tgl_err='Format penulisan tanggal lahir salah. Contoh misal 30-07-1993';
					else:
						$tanggal_lahir=$this->post('tgl_lahir');
						$tanggal_lahir=$this->esc($tanggal_lahir);
					endif;			
				}

				if(empty($this->post('alamat'))){

					$alm_err = "Alamat lengkap wajib diisi";

				}else{
					$alamat = $this->post('alamat');
					$alamat = $this->esc($alamat);
					
				}
				if(empty($this->post('kontak'))){
					$kontak_err = "Kontak admin club wajib diisi";
				}elseif($this->validateNumber($this->post('kontak'))){
					$kontak_err = "Harap isi nomor kontak dengan benar, hanya karakter angka yang diperbolehkan";
				}else{
					$kontak = $this->post('kontak');
					$kontak = $this->esc($kontak);
				}					
				
				if(empty($nama_err) && empty($kontak_err) && empty($alm_err) && empty($tempat_lahir_err) && empty($tgl_err)){
					if ($this->updatePetugas($nama_lengkap, $tempat_lahir, $tanggal_lahir, $alamat, $kontak, $this->datasession['id_user'])):

						$this->alert('success','Data berhasil diperbaharui');
						$this->reload_time('1','profile');
					else:
						$this->alert('danger','Data gagal diperbaharui');
					endif;
					

				}
			
		endif;
	
		$this->formGeneral();
		$this->card('Edit Profile');	
	
		echo'	    

	       
			'.$this->formGroup_edit('user', 'text', 'nama_lengkap', "Masukan nama lengkap",$this->datasession['nama_user'], $nama_err).'

			<div class="form-group row">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			        '.$this->formGroup_edit('calendar', 'text', 'tempat_lahir', "Masukan tempat lahir anda",$this->datasession['tempat_lahir'], $tempat_lahir_err).'
			    </div>
				<div class="col-sm-6">
					'.$this->formGroup_datepicker_edit('calendar', 'text', 'tgl_lahir', "30-07-1993",'tanggal',$this->datasession['tgl_lahir'], $tgl_err).'
			    </div>			                  
			</div>

			'.$this->formGroup_Textarea_edit('alamat', 'Masukan alamat secara lengkap', $this->datasession['alamat'], $alm_err).'      
			
			'.$this->formGroup_edit('phone', 'text', 'kontak', "Masukan telephone/whatsapp admin", $this->datasession['kontak_petugas'], $kontak_err).'			
			           
			'.$this->formGroup_button2('update_petugas','btn-md', 'save','Simpan').' 
	    
	    </div>
        </div>
          </form>

        ';  
	}
	public function form_updateProfile_usersAdminclub()
	{
		$nama_err = $tempat_lahir_err = $tgl_err = $alm_err = $foto_err = $kontak_err = "";
		if(isset($_POST['update_adminclub'])):
			
				if(empty($this->post('nama_lengkap'))){
					$nama_err = "Nama lengkap wajib diisi";
				}elseif($this->validateName('nama_lengkap')){
					$nama_err = "Hanya boleh diisi dengan karakter alphabet";
				}else{
					$nama_lengkap = $this->post('nama_lengkap');
					$nama_lengkap = $this->esc($nama_lengkap);
				}

				if(empty($this->post('tempat_lahir'))){
					$tempat_lahir_err = "Masukan tempat lahir Anda";
				}else{

					$tempat_lahir=$this->post('tempat_lahir');
					$tempat_lahir=$this->esc($tempat_lahir);
				}

				if(empty($this->post('tgl_lahir'))){
					$tgl_err='tanggal lahir masih kosong';	
				}elseif(strlen($this->post('tgl_lahir'))!=10){
					$tgl_err='Format penulisan tanggal lahir lahir salah';	
				}elseif($this->CekTLS_tanggal($this->post('tgl_lahir'))){
					$tgl_err='Format penulisan tanggal lahir salah. Harus Tgl-Bln-Thn';
				}
				else{
					
					if(!$this->BCA_tanggal($this->post('tgl_lahir'))):
						$tgl_err='Format penulisan tanggal lahir salah. Contoh misal 30-07-1993';
					else:
						$tanggal_lahir=$this->post('tgl_lahir');
						$tanggal_lahir=$this->esc($tanggal_lahir);
					endif;			
				}

				if(empty($this->post('alamat'))){

					$alm_err = "Alamat lengkap wajib diisi";

				}else{
					$alamat = $this->post('alamat');
					$alamat = $this->esc($alamat);
					
				}
				if(empty($this->post('kontak'))){
					$kontak_err = "Kontak admin club wajib diisi";
				}elseif($this->validateNumber($this->post('kontak'))){
					$kontak_err = "Harap isi nomor kontak dengan benar, hanya karakter angka yang diperbolehkan";
				}else{
					$kontak = $this->post('kontak');
					$kontak = $this->esc($kontak);
				}

		      	
				
				if(empty($nama_err) && empty($kontak_err) && empty($alm_err) && empty($tgl_err) && empty($tempat_lahir_err)){

					if($this->updateAdmin_club($this->datasession['id_club'], $nama_lengkap, $tempat_lahir, $tanggal_lahir, $alamat, $kontak, $this->datasession['id_user'])):

						$this->alert('success','Data berhasil diperbaharui');
						$this->reload_time('1','profile');
					else:
						$this->alert('danger','Data gagal diperbaharui');
					endif;
					

				}
			
		endif;
		
		$this->formGeneral();
		$this->card('Edit Profile');	
	
		echo'	    

	      
			'.$this->formGroup_edit('user', 'text', 'nama_lengkap', "Masukan nama lengkap",$this->datasession['nama_user'], $nama_err).'

			<div class="form-group row">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			        '.$this->formGroup_edit('calendar', 'text', 'tempat_lahir', "Masukan tempat lahir anda",$this->datasession['tempat_lahir'], $tempat_lahir_err).'
			    </div>
				<div class="col-sm-6">
					'.$this->formGroup_datepicker_edit('calendar', 'text', 'tgl_lahir', "30-07-1993",'tanggal',$this->datasession['tgl_lahir'],$tgl_err).'
			    </div>			                  
			</div>

			'.$this->formGroup_Textarea_edit('alamat', 'Masukan alamat secara lengkap', $this->datasession['alamat'], $alm_err).'      
			
			'.$this->formGroup_edit('phone', 'text', 'kontak', "Masukan telephone/whatsapp admin", $this->datasession['kontak_admin'], $kontak_err).'		
			
			'.$this->formGroup_button2('update_adminclub','btn-md', 'save','Simpan').'
	    
	    </div>
        </div>
          </form>

        ';   
	}
	public function form_updateProfile_usersPemain()
	{
		$nik_err = $nama_err = $tempat_lahir_err = $tgl_err = $alm_err = $pass_err = $pass_kon_err = $role_err = $foto_err = $id_club_err = $kontak_err = $tinggi_badan_err = $berat_badan_err = $no_punggung_err = $no_kk_err = "";

		if(isset($_POST['update_pemain'])):
			

				if($this->validateNumber($this->post('no_kk'))){

				$no_kk_err = "Pastikan data berupa no nik sepanjang 16 karakter";

				}elseif(strlen($this->post('no_kk'))!=16){
					$no_kk_err = "Pastikan data sebanyak 16 karakter";
				}else{

					$no_kk=$this->post('no_kk');
					$no_kk=$this->esc($no_kk);

				}

				if($this->validateNumber($this->post('no_punggung'))){

					$no_punggung_err = "Data harrus berupa angka";

				}else{
					$no_punggung=$this->post('no_punggung');
					$no_punggung=$this->esc($no_punggung);

				}


				$posisi=$this->post('posisi');
				$posisi=$this->esc($posisi);

				if($this->validateNumber($this->post('tinggi_badan'))){
					$tinggi_badan_err = "Masukan tinggi badan dengan benar. Misal 170";
				}else{
					$tinggi_badan=$this->post('tinggi_badan');
					$tinggi_badan=$this->esc($tinggi_badan);
				}

				if($this->validateNumber($this->post('berat_badan'))){
					$tinggi_badan_err = "Masukan berat badan dengan benar. Misal 65";
				}else{
					$berat_badan=$this->post('berat_badan');
					$berat_badan=$this->esc($berat_badan);
				}
							

				$gol_darah=$this->post('gol_darah');
				$gol_darah=$this->esc($gol_darah);

				if(empty($this->post('nama_depan'))){
					$nama_err = "Nama wajib diisi";
				}elseif($this->validateName('nama_depan')){
					$nama_err = "Hanya boleh diisi dengan karakter alphabet";
				}else{
					$nama_lengkap = $this->post('nama_depan');
					$nama_lengkap = $this->esc($nama_lengkap);
				}

				if(empty($this->post('tempat_lahir'))){
					$tempat_lahir_err = "Masukan tempat lahir Anda";
				}else{

					$tempat_lahir=$this->post('tempat_lahir');
					$tempat_lahir=$this->esc($tempat_lahir);
				}

				if(empty($this->post('tgl_lahir'))){
					$tgl_err='tanggal lahir masih kosong';	
				}elseif(strlen($this->post('tgl_lahir'))!=10){
					$tgl_err='Format penulisan tanggal lahir lahir salah';	
				}elseif($this->CekTLS_tanggal($this->post('tgl_lahir'))){
					$tgl_err='Format penulisan tanggal lahir salah. Harus Tgl-Bln-Thn';
				}
				else{
					
					if(!$this->BCA_tanggal($this->post('tgl_lahir'))):
						$tgl_err='Format penulisan tanggal lahir salah. Contoh misal 30-07-1993';
					else:
						$tanggal_lahir=$this->post('tgl_lahir');
						$tanggal_lahir=$this->esc($tanggal_lahir);
					endif;			
				}

				if(empty($this->post('alamat'))){

					$alm_err = "Alamt lengkap wajib diisi";

				}else{
					$alamat = $this->post('alamat');
					$alamat = $this->esc($alamat);
					
				}
				if(empty($this->post('kontak'))){
					$kontak_err = "Kontak admin club wajib diisi";
				}elseif($this->validateNumber($this->post('kontak'))){
					$kontak_err = "Harap isi nomor kontak dengan benar, hanya karakter angka yang diperbolehkan";
				}else{
					$kontak = $this->post('kontak');
					$kontak = $this->esc($kontak);
				}
				
				if(empty($nama_err) && empty ($pass_err) && empty ($pass_kon_err) && empty ($nik_err) && empty ($foto_err) && empty($kontak_err) && empty($no_punggung_err) && empty($berat_badan_err) && empty($tinggi_badan_err) && empty($alm_err) && empty($tempat_lahir_err) && empty($tgl_err) && empty($role_err) && empty($no_kk_err)){
				
							if($this->updatePemain($this->datasession['id_club'], $no_punggung,$posisi, $nama_lengkap, $no_kk, $tempat_lahir, $tanggal_lahir, $tinggi_badan, $berat_badan, $gol_darah, $alamat, $kontak, $this->datasession['id_user'])):

								$this->alert('success','Data berhasil disimpan');
								$this->reload_time('3','profile');
							else:
								$this->alert('danger','Data gagal disimpan');
							endif;
						
					}
					
		endif;
		
		$this->formGeneral();
		$this->card('Edit Profile');	
		echo'	    

	      
	       '.$this->formGroup_edit('key', 'text', 'no_kk', "Masukan nomor kartu keluarga",$this->datasession['no_kk'], $no_kk_err).'
	       <div class="form-group row">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			       '.$this->formGroup_edit('user', 'text', 'no_punggung', "Masukan nomor punggung",$this->datasession['no_punggung_pemain'], $no_punggung_err).'
			    </div>
				<div class="col-sm-6">
					<div class="form-group">
				        <div class="input-group">
					        <div class="input-group-prepend">
					        	<div class="input-group-text"><i class="fas fa-fw fa-arrow-alt-circle-down"></i></div>
					        </div>
					       		<select class="form-control" name="posisi" required="">
					       			<option value="'.$this->datasession['posisi_pemain'].'">'.$this->datasession['posisi_pemain'].'</option>
					       			<option value="Goal Keeper">Goal Keeper</option>
					       			<option value="Bek Tengah">Bek Tengah</option>
					       			<option value="Bek Sayap">Bek Sayap</option>
					       			<option value="Gelandang">Gelandang</option>
					       			<option value="Gelandang Bertahan">Gelandang Bertahan</option>
					       			<option value="Gelandang Tengah">Gelandang Tengah</option>
					       			<option value="Gelandang Serang">Gelandang Serang</option>
					       			<option value="Gelandang Sayap">Gelandang Sayap</option>
					       			<option value="Penyerang">Penyerang</option>
					       		</select>
					    </div>	
					            
				     </div>
					
			    </div>			                  
			</div>
			'.$this->formGroup_edit('user', 'text', 'nama_depan', 'Masukan nama lengkap pemain',$this->datasession['nama_user'], $nama_err).'

			<div class="form-group row">
			    <div class="col-sm-6 mb-3 mb-sm-0">
			        '.$this->formGroup_edit('calendar', 'text', 'tempat_lahir', "Masukan tempat lahir anda",$this->datasession['tempat_lahir'], $tempat_lahir_err).'
			    </div>
				<div class="col-sm-6">
					'.$this->formGroup_datepicker_edit('calendar', 'text', 'tgl_lahir', "30-07-1993",'tanggal',$this->datasession['tgl_lahir'], $tgl_err).'
			    </div>			                  
			</div>

			<div class="form-group row">

			   
			    <div class="col-sm-3">
					'.$this->formGroup_edit('hashtag', 'text', 'tinggi_badan', "Masukan tinggi badan Anda",$this->datasession['tinggi_badan'], NULL).'
			
			    </div>	
			    <div class="col-sm-3">
					'.$this->formGroup_edit('hashtag', 'text', 'berat_badan', "Masukan berat badan Anda",$this->datasession['berat_badan'], NULL).'
			
			    </div>
				<div class="col-sm-6">
					<div class="form-group">
				        <div class="input-group">
					        <div class="input-group-prepend">
					        	<div class="input-group-text"><i class="fas fa-fw fa-arrow-alt-circle-down"></i></div>
					        </div>
					       		<select class="form-control" name="gol_darah" required="">
					       			<option value="'.$this->datasession['golongan_darah'].'">'.$this->datasession['golongan_darah'].'</option>
					       			<option value="A">A</option>
					       			<option value="B">B</option>
					       			<option value="AB">AB</option>
					       			<option value="O">O</option>
					       			<option value="Belum Tahu">Belum Tahu</option>
					       		</select>
					    </div>	
					            
				     </div>
					
			    </div>			                  
			</div>

			'.$this->formGroup_Textarea_edit('alamat', 'Masukan alamat secara lengkap', $this->datasession['alamat'], $alm_err).' 
			               
			
			'.$this->formGroup_edit('phone', 'text', 'kontak', "Masukan telephone/whatsapp pemain",$this->datasession['kontak_pemain'], $kontak_err).'
			
			
			<div class="form-group">
	   		 '.$this->getDirImage2('../../content/foto/pemain/',$this->datasession['foto_user']).'
	   		</div>	    		             
			
			'.$this->formGroup_button2('update_pemain','btn-md', 'save','Simpan').'
	    
	    </div>
        </div>
          </form>

        ';   
	}
/***************************
	DASHBOARD
****************************/
	public function dashboard()
	{
		$this->sessionData($this->filter($_SESSION['id_user']));

		$mainDashboard=$this->jumlahData();
		$mainLiga=$this->listAll_liga();
		$mainClub=$this->listAll_Club();
		$rwclub=$mainClub->num_rows;
		$rwliga=$mainLiga->num_rows;
        $row=$mainDashboard->fetch_array();
        
        $mainDashboard->free_result();
       
        echo'

       		<div class="d-sm-flex align-items-center justify-content-between mb-4">
	            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
	           
         	</div>
        ';
        echo'
          <div class="col-lg-12 mb-4">

              <!-- Illustrations -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">
	                  Selamat datang  di e-Soccer 
	                  <div class="float-right">'.$this->tanggalIndo().'</div>
                  </h6>

                </div>
                <div class="card-body">
                  <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="../../assets/templates/img/undraw_posting_photo.svg" alt="">
                  </div>
                  <p>Selamat datang <b>'.$this->datasession['nama_user'].'</b> di Halaman Aplikasi e-Soccer, Anda login sebagai '.$this->datasession['role'].'. Aplikasi berbasis web ini merupakan aplikasi untuk manajemen sepak bola yang meliputi pengaturan penyelenggaraan liga, jadwal pertandingan, skor,  manajemen club sepak bola beserta tim yang tergabung. Silahkan untuk melakukan pengaturan pada menu yang sudah tersedia</p>
                  
                </div>
              </div>

             

            </div>
            '; 
		echo '
		<div class="row">

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">PEMAIN (Aktif)</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['jml_pemain'].'</div>

                    </div>

                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>

                  </div>
                  <div class="text-sm-right">
                  	<a class="text-primary" href="?page=pemain">more</a>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
             <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">ADMIN CLUB</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">'.$row['jml_adminclub'].'</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>                    
                  </div>
                   <div class="text-sm-right">
                  		<a class="text-success" href="?page=admin club">more</a>
                  </div>
                </div>
              </div>
            </div>

            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">CLUB</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">'.$rwclub.'</div>
                        </div>
                        <div class="col">
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: '.$rwclub.'%" aria-valuenow="'.$rwclub.'" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                  <div class="text-sm-right">
                  		<a class="text-success" href="?page=club">more</a>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Liga</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800">'.$rwliga.'</div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-trophy fa-2x text-gray-300"></i>
                    </div>
                  </div>
                  <div class="text-sm-right">
                  		<a class="text-warning" href="?page=liga">more</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          ';
          
	}
	public function dashboardPetugas()
	{
		$this->sessionData($this->filter($_SESSION['id_user']));
		echo'

       		<div class="d-sm-flex align-items-center justify-content-between mb-4">
	            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
	           
         	</div>
        ';
        echo'
          <div class="col-lg-12 mb-4">

              <!-- Illustrations -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">
	                  Selamat datang  di e-Soccer 
	                  <div class="float-right">'.$this->tanggalIndo().'</div>
                  </h6>

                </div>
                <div class="card-body">
                  <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="../../assets/templates/img/undraw_posting_photo.svg" alt="">
                  </div>
                  <p>Selamat datang <b>'.$this->datasession['nama_user'].'</b> di Halaman Aplikasi e-Soccer, Anda login sebagai '.$this->datasession['role'].'Hak akses Anda adalah sebagi berikut :
	                  <ol>
	                  	<li>Liga (Membuat liga, mengatur dan menyimpan jadwal )</li>
	                  	<li>Mengatur Berita (membuat, mengedit dan menghapus)</li>

	                  </ol>
                  </p>
                  
                </div>
              </div>

             

            </div>
            '; 
	}
	public function dashboard_adminClub()
	{
		$this->sessionData($this->filter($_SESSION['id_user']));
		echo'

       		<div class="d-sm-flex align-items-center justify-content-between mb-4">
	            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
	            <a class="btn btn-primary btn-sm" href="../../app/export/export.pemain.php" target="_blank">
			          <i class="fas fa-fw fa-download"></i>
			          <span>Download</span></a>
         	</div>
        ';
        echo'
          <div class="col-lg-12 mb-4">

              <!-- Illustrations -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">
	                  Selamat datang  di e-Soccer 
	                  <div class="float-right">'.$this->tanggalIndo().'</div>
                  </h6>

                </div>
                <div class="card-body">
                  <div class="text-center">
                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="../../assets/templates/img/undraw_posting_photo.svg" alt="">
                  </div>
                  <p>Selamat datang <b>'.$this->datasession['nama_user'].'</b> di Halaman Aplikasi e-Soccer, Anda login sebagai '.$this->datasession['role'].'. Hak akses Anda adalah sebagi berikut :
	                  <ol>
	                  	<li>Menambah Pemain, Menghapus dan Mengedit</li>
	                  	<li>Melihat Profile Club</li>
	                  	<li>Backup Data Pemain (Excel)</li>
	                  	<li>Melihat Jadwal</li>
	                  </ol>
                  </p>
                  
                </div>
              </div>

             

            </div>
            '; 
	}
	public function dashboardPemain()
	{
		$this->sessionData($this->filter($_SESSION['id_user']));
		$this->shownameClub_session($this->datasession['id_club']);
		echo'

       		<div class="d-sm-flex align-items-center justify-content-between mb-4">
	            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
	            <a class="btn btn-primary btn-sm" href="../../app/pdf/print.pemain.php?id_user='.$this->datasession['id_user'].'&club='.$this->shownameClub($this->datasession['id_club']).'" target="_blank">
			          <i class="fas fa-fw fa-download"></i>
			          <span>Cetak Biodata</span></a>
         	</div>
         	
        ';
        echo '
        	<div class="row">
        		<div class="col-md-4">
        			<div class="card">
        				<div class="card-header py-3">
	                		<h6 class="m-0 font-weight-bold text-primary">PROFILE</h6>
	            		</div>
        				<div class="card-body text-center">
        					'.$this->getDirImage_round2('../../content/foto/pemain/',$this->datasession['foto_user']).'
        					<p style="font-size:18px;"><b>'.$this->datasession['nama_user'].'</b>

        					<br/>
        					'.$this->datasession['tempat_lahir'].' ,'.$this->datasession['tgl_lahir'].'
        					<br/>
        					'.$this->datasession['posisi_pemain'].' / '.$this->datasession['no_punggung_pemain'].'
        					<br/>
        					<a href="?page=profile" title="edit"> Edit </a>
        					</p>
        				</div>
        			</div>
        		</div>
        		<div class="col-md-7">
        			<div class="card">
        				<div class="card-header py-3">
	                		<h6 class="m-0 font-weight-bold text-primary">CLUB</h6>
	            		</div>
        				<div class="card-body text-center">
        					'.$this->getDirImage2('../../content/foto/club/',$this->nameClub['logo_club']).'
        					<p style="font-size:18px;">'.$this->shownameClub($this->datasession['id_club']).'<br> '.$this->nameClub['alamat_club'].'</p>
        				</div>
        			</div>
        		</div>
        	</div>


        ';
	}
/***************************
	MENU
****************************/
	public function form_addMenu()
	{
		
		echo '
		<div class="d-sm-flex align-items-center justify-content-between mb-4">

	            <h1 class="h3 mb-0 text-gray-800">Pengaturan Menu</h1>
	        
        </div>
  
         <p class="mb-4">
     	 	

     	 	Pengaturan pada halaman menu ini akan mempengaruhi menu pada tampilan website utama. Untuk jenis menu Anda bisa menyesuikan dengan id data atau menyesuaikan dengan yang didefinisikan pada file htacces
     	 </p>

        <ul class="nav nav-tabs mb-2" role="tablist">
		    <li class="nav-item">
		      <a class="nav-link" data-toggle="tab" href="#home">Buat Menu</a>
		    </li>
		    <li class="nav-item">
		      <a class="nav-link" data-toggle="tab" href="#menu1">Sub Menu</a>
		    </li>
		     <li class="nav-item">
		      <a class="nav-link active" data-toggle="tab" href="#menu2"> Data Menu</a>
		    </li>
		    
		  </ul>
		<div class="tab-content">
			<div id="home" class="tab-pane fade">
        ';
        	$this->form_primaryMenu();
		echo'

			<!-- tab content active end -->
			</div>

		<div id="menu1" class="container tab-pane fade">
		';
			
		$this->form_subMenu();
		echo'
		</div>

		<div id="menu2" class="container tab-pane active">
		';
		$this->tabelMenu();	
		echo '

		</div>


		<!-- tab content end-->
		</div>';
	}
	public function form_primaryMenu()
	{
		$menu_err = $kategori_err = $link_err = $urut_err ="";
		if(isset($_POST['simpan_menu'])):
			if(empty($this->post('nama_menu'))){
				$menu_err="Menu tidak boleh kosong";
			}else{
				$nama=$this->post('nama_menu');
				$nama=$this->esc($nama);
			}
			if(empty($this->post('kategori_menu'))){
				$kategori_err = "Kategori menu tidak boleh kosong";
			}else{
				$kategori=$this->post('kategori_menu');
				$kategori=$this->esc($kategori);
			}
			if(empty($this->post('link_menu'))){
				$link_err = "Link menu tidak boleh kosong";
			}else{
				$link=$this->post('link_menu');
				$link=$this->esc($link); 
			}
			if(empty($this->post('urut'))){
				$urut_err = "Nomor urut tidak boleh kosong";
			}else{
				$urut=$this->post('urut');
				$urut=$this->esc($urut);
			}
			if(empty($menu_err) && empty($kategori_err) && empty($link_err) && empty($urut_err)){
				if($this->addMenu($nama, $kategori, $link, $urut)):
					$this->alert('success','Menu berhasil ditambahkan');
				else:
					$this->alert('danger','Menu gagal ditambahkan');
				endif;
			}
		endif;
		$this->formGeneral();
			$this->card('Buat Menu');
			echo'
				'.$this->formGroup('edit', 'text', 'nama_menu', 'Judul Menu',$menu_err).'
				
				
						<div class="form-group">
					        <div class="input-group">
						        <div class="input-group-prepend">
						        	<div class="input-group-text"><i class="fas fa-fw fa-book-open"></i></div>
						        </div>
						       		<select class="form-control" name="kategori_menu" required="">
						       						       	
						       			<option value="single_menu">Single Menu</option>
						       			<option value="dropdown_menu">Dropdown</option>
						       			
						       			
						       		</select>
						    </div>	
						    <span class="text-danger">'.$kategori_err.'</span>        
					    </div>
				
				'.$this->formGroup('globe', 'text', 'link_menu', 'misal : '.$_SERVER['SERVER_NAME'].'/profile?id=1 atau masukan # jika tidak ada',$link_err).'
				'.$this->formGroup('hashtag', 'number', 'urut', 'nomor urut menu',$urut_err).'
		
			'.$this->formGroup_button2('simpan_menu','btn-md,','save', 'Simpan').'
				

			<!-- card end -->
			</div></div></form>';
	}
	public function form_subMenu()
	{
		$menu_err = $parent_err = $link_err = $urut_err ="";
		if(isset($_POST['simpan_submenu'])):
			if(empty($this->post('nama_menu'))){
				$menu_err="Menu tidak boleh kosong";
			}else{
				$nama=$this->post('nama_menu');
				$nama=$this->esc($nama);
			}

			$kategori="sub_menu";

			if(empty($this->post('parent'))){
				$parent_err = "Harap pilih dropdown menu";
			}else{

				$parent = $this->post('parent');
				$parent = $this->esc($parent);
			}
		
		
			if(empty($this->post('link_menu'))){
				$link_err = "Link menu tidak boleh kosong";
			}else{
				$link=$this->post('link_menu');
				$link=$this->esc($link); 
			}
			if(empty($this->post('urut'))){
				$urut_err = "Nomor urut tidak boleh kosong";
			}else{
				$urut=$this->post('urut');
				$urut=$this->esc($urut);
			}
			if(empty($menu_err) && empty($parent_err) && empty($link_err) && empty($urut_err)){
				if($this->add_subMenu($nama, $kategori, $parent, $link, $urut)):
					$this->alert('success','Sub Menu berhasil ditambahkan');
				else:
					$this->alert('danger','Menu gagal ditambahkan');
				endif;
			}
		endif;
		$this->formGeneral();
			$this->card('Buat Sub Menu');
			echo'
				'.$this->formGroup('edit', 'text', 'nama_menu', 'Judul Menu',$menu_err).'
				
				
						<div class="form-group">
					        <div class="input-group">
						        <div class="input-group-prepend">
						        	<div class="input-group-text"><i class="fas fa-fw fa-book-open"></i></div>
						        </div>
						       		<select class="form-control" name="parent" required="">
						       			';			       	
						       			$menu=$this->showMenu_dropdownMenu();
						       			if($menu->num_rows>0){
						       				while($row_menu=$menu->fetch_array()):
						       					echo'<option value="'.$row_menu['id_menu'].'">'.$row_menu['nama_menu'].'</option>';
						       				endwhile;
						       			}else{
						       				echo '<option></option>';
						       			}

						       			$menu->free_result();
						       			
						       			echo'
						       		</select>
						    </div>	
						    <span class="text-danger">'.$parent_err.'</span>        
					    </div>
				
				'.$this->formGroup('globe', 'text', 'link_menu', 'misal : '.$_SERVER['SERVER_NAME'].'/profile?id=1 atau masukan # jika tidak ada',$link_err).'
				'.$this->formGroup('hashtag', 'number', 'urut', 'nomor urut menu',$urut_err).'
		
			'.$this->formGroup_button2('simpan_submenu','btn-md,','save', 'Simpan').'
				

			<!-- card end -->
			</div></div></form>';
	}
	public function tabelMenu()
	{
		echo '
			<div class="card shadow">
				<div class="card-body">
					<table class="table table-bordered">
						<tbody>
							<thead>
								<tr>
									<th>NO</th>
									<th>NAMA MENU</th>
									<th>KATEGORI MENU</th>
									<th>LINK</th>
									<th>URUTAN</th>
									<th>AKSI</th>
								</tr>
								';
									$menu = $this->showMenu();
									$no=1;
									if($menu->num_rows>0){

										while($row=$menu->fetch_array()):
											echo'
											<tr>
												<td>'.$no.'</td>
												<td>

												'.$row['nama_menu'].'

												';
												if($row['kategori_menu']=='dropdown_menu'):
													$sub_menu=$this->showMenu_bysubMenu($row['id_menu']);
													while($row2=$sub_menu->fetch_array()):
														echo "<br/>--".$row2['nama_menu'].'<a href="?page=edit menu&id_menu='.$row2['id_menu'].'">
														<i class="fas fa-edit"></i>
													</a>';
													endwhile;											
												endif;

												echo'
												</td>
												<td>'.$row['kategori_menu'].'</td>
												<td>'.$row['link_menu'].'</td>
												<td>'.$row['urut'].'</td>
												<td>
													<a href="?page=delete menu&id_menu='.$row['id_menu'].'">
														<i class="fas fa-trash"></i>
													</a>
													<a href="?page=edit menu&id_menu='.$row['id_menu'].'">
														<i class="fas fa-edit"></i>
													</a>

												</td>
											</tr>';
											$no+=1;
										endwhile;
										$menu->free_result();
									}else{

										echo 
											'<tr>
												<td colspan="4">Belum ada menu</td>
											</tr>';
									}


								echo'
							</thead>								
						</tbody>
					</table>
				</div>
			</div>


		';
	}
	public function form_editMenu()
	{
		if(!$this->detailMenu($this->get('id_menu')))die($this->alert('danger','Id Menu : not found'));
		if($this->kategori_menu!='sub_menu'):
			if(isset($_POST['update_menu'])):
				$nama=$this->post('nama_menu');
				$nama=$this->esc($nama);
				$kategori=$this->post('kategori_menu');
				$kategori=$this->esc($kategori);
				$link=$this->post('link_menu');
				$link=$this->esc($link);
				$urut=$this->post('urut');
				$urut=$this->esc($urut);
				if($this->updateMenu($nama, $kategori, $link, $urut, $this->parent, $this->id_menu)):
					$this->alert('success','Menu berhasil diperbaharui');
					$this->reload_time('1','pengaturan menu');
				else:
					$this->alert('danger','Menu gagal diperbaharui');
				endif;


			endif;
			#form update menu
			$this->formGeneral();
			$this->card('Edit Menu');
			echo'
				'.$this->formGroup_edit('edit', 'text', 'nama_menu', 'Judul Menu',$this->nama_menu,NULL).'
				
				
						<div class="form-group">
					        <div class="input-group">
						        <div class="input-group-prepend">
						        	<div class="input-group-text"><i class="fas fa-fw fa-book-open"></i></div>
						        </div>
						       		<select class="form-control" name="kategori_menu" required="">		       						       	
						       			<option value="'.$this->kategori_menu.'">Select Menu</option>
						       			<option value="single_menu">Single Menu</option>
						       			<option value="dropdown_menu">Dropdown</option>
						       			
						       			
						       		</select>
						    </div>	
						         
					    </div>
				
				'.$this->formGroup_edit('globe', 'text', 'link_menu', 'misal : '.$_SERVER['SERVER_NAME'].'/profile?id=1 atau masukan # jika tidak ada',$this->link_menu, NULL).'
				'.$this->formGroup_edit('hashtag', 'number', 'urut', 'nomor urut menu',$this->urut, NULL).'
		
			'.$this->formGroup_button2('update_menu','btn-md,','save', 'Simpan').'
				

			<!-- card end -->
			</div></div></form>';

		else:
			if(isset($_POST['update_submenu'])):
				$nama=$this->post('nama_menu');
				$nama=$this->esc($nama);
				$link=$this->post('link_menu');
				$link=$this->esc($link);
				$urut=$this->post('urut');
				$urut=$this->esc($urut);
				$parent=$this->post('parent');
				$parent=$this->esc($parent);
				if($this->updateMenu($nama, $this->kategori_menu, $link, $urut, $parent, $this->id_menu)):
					$this->alert('success','Menu berhasil diperbaharui');
					$this->reload_time('1','pengaturan menu');
				else:
					$this->alert('danger','Menu gagal diperbaharui');
				endif;

			endif;
			#update sub menu
			$this->formGeneral();
			$this->card('Edit Sub Menu');
			echo'
				'.$this->formGroup_edit('edit', 'text', 'nama_menu', 'Judul Menu',$this->nama_menu,NULL).'
				
				
						<div class="form-group">
					        <div class="input-group">
						        <div class="input-group-prepend">
						        	<div class="input-group-text"><i class="fas fa-fw fa-book-open"></i></div>
						        </div>
						       		<select class="form-control" name="parent" required="">		       						       	
						       			<option value="'.$this->parent.'">Select Menu</option>
						       			';
						       			$menu=$this->showMenu_dropdownMenu();
						       			if($menu->num_rows>0){
						       				while($row_menu=$menu->fetch_array()):
						       					echo'<option value="'.$row_menu['id_menu'].'">'.$row_menu['nama_menu'].'</option>';
						       				endwhile;
						       			}else{
						       				echo '<option></option>';
						       			}

						       			$menu->free_result();
						       			
						       			echo'
						       			
						       			
						       		</select>
						    </div>	
						         
					    </div>
				
				'.$this->formGroup_edit('globe', 'text', 'link_menu', 'misal : '.$_SERVER['SERVER_NAME'].'/profile?id=1 atau masukan # jika tidak ada',$this->link_menu, NULL).'
				'.$this->formGroup_edit('hashtag', 'number', 'urut', 'nomor urut menu',$this->urut, NULL).'
		
			'.$this->formGroup_button2('update_submenu','btn-md,','save', 'Simpan').'
				

			<!-- card end -->
			</div></div></form>';
		endif;
	}
	public function form_deleteMenu()
	{
		if(!$this->detailMenu($this->get('id_menu')))die($this->alert('danger','Id Menu : not found'));
		if($this->kategori_menu!='dropdown_menu'):
			if($this->deleteMenu($this->id_menu)):
				$this->alert('success','Menu berhasil dihapus');
				$this->reload_time('1','pengaturan menu');
			else:
				$this->alert('danger','Menu gagal dihapus');
			endif;
		else:
			$this->deleteSubmenu($this->id_menu);
			if($this->deleteMenu($this->id_menu)):
				$this->alert('success','Menu berhasil dihapus');
				$this->reload_time('1','pengaturan menu');
			else:
				$this->alert('danger','Menu gagal dihapus');
			endif;
		endif;
	}
}


?>