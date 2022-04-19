<?php

class main_Liga extends liga
{
	
	public function fetchClub_option()
	{
		echo'
		
				<div class="form-group">
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
					</div>
				
		';

	}
	public function fetchLiga_byid_tuanRumah()
	{
		echo'
		
				<div class="form-group">					
						<div class="input-group">
					        <div class="input-group-prepend">
					        	<div class="input-group-text">
					        		<i class="fas fa-fw fa-users"></i>
					        	</div>
					        </div>
					        	<select class="form-control" name="tim_tuan_rumah" required="">
					        		<option value="'.$this->tim_tuan_rumah.'">'.$this->viewJadwal_shownameClub($this->tim_tuan_rumah).'</option>
					        	';

					        		$this->option=$this->viewPeserta_liga($this->get('id_liga'));
					        		if($this->option->num_rows>0):
										while($this->rwClub=$this->option->fetch_array()){
											echo '

											<option value="'.$this->rwClub['id_club'].'">'.$this->rwClub['nama_club'].'</option>

											';	
										
											
										}
										$this->option->free_result();
									else:
										echo'<option class="text-danger">Anda belum menambah peserta ke liga </option>';
									endif;

					        	echo'
					        	</select>

					    </div>
					</div>
				
		';
	}
	public function fetchLiga_byid_tamu()
	{
		echo'
		
				<div class="form-group">					
						<div class="input-group">
					        <div class="input-group-prepend">
					        	<div class="input-group-text">
					        		<i class="fas fa-fw fa-users"></i>
					        	</div>
					        </div>
					        	<select class="form-control" name="tim_tamu" required="">
					        		<option value="'.$this->tim_tamu.'">'.$this->viewJadwal_shownameClub($this->tim_tamu).'</option>
					        	';

					        		$this->option=$this->viewPeserta_liga($this->get('id_liga'));
					        		if($this->option->num_rows>0):
										while($this->rwClub=$this->option->fetch_array()){
											echo '

											<option value="'.$this->rwClub['id_club'].'">'.$this->rwClub['nama_club'].'</option>

											';	
										
											
										}
										$this->option->free_result();
									else:
										echo'<option class="text-danger">Anda belum menambah peserta ke liga </option>';
									endif;

					        	echo'
					        	</select>

					    </div>
					</div>
				
		';
	}
	public function tabelLiga()
	{
		echo
		'
		 <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Liga</th>
                      <th>Tahun</th>
                      <th>Nama Penyelenggara</th>
                      <th>Jumlah TIM</th>
                      <th>Sistem Pertandingan</th>
                      <th>Aksi</th>
                   
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Nama Liga</th>
                      <th>Tahun</th>
                      <th>Nama Penyelenggara</th>
                      <th>Jumlah TIM</th>
                      <th>Sistem Pertandingan</th>
                      <th>Aksi</th>
                    </tr>
                  </tfoot>
                  <tbody>
	              ';
	              
	              $this->no = 1;
	              $this->liga = $this->viewLiga();	              
	              while($this->row=$this->liga->fetch_array()):
	              	echo '
	              		<tr>
		              		<td>'.$this->no.'</td>
		              		<td>'.$this->row['nama_liga'].'</td>
		              		<td>'.$this->row['tahun_penyelenggaraan'].'</td>
		              		<td>'.$this->row['nama_penyelenggara'].'</td>
		              		<td>'.$this->row['jumlah_tim'].'</td>
		              		<td>'.$this->row['sistem_pertandingan'].'</td>
		              		<td>
		              		<a href="?page=tambah peserta liga&id_liga='.$this->row['id_liga'].'" title="tambah peserta liga"><i class="fas fa-fw fa-plus"></i></a>

		              		<a href="?page=jadwal liga&id_liga='.$this->row['id_liga'].'" title="input jadwal"><i class="fas fa-fw fa-calendar"></i></a>

		              		<a href="?page=edit liga&id_liga='.$this->row['id_liga'].'" title="edit"><i class="fas fa-fw fa-edit"></i></a>

		              		<a href="?page=delete liga&id_liga='.$this->row['id_liga'].'" title="delete"><i class="fas fa-fw fa-trash"></i></a>
		              		</td>
	              		</tr>

	              	';
	              	$this->no+=1;
	              endwhile;


	              echo
	              '
                   
                  </tbody>
                </table>
              </div>

		';
	}

	public function liga()
	{
		echo '
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
	            <h1 class="h3 mb-0 text-gray-800">Daftar Liga</h1>
	            
        </div>
        <p class="mb-4">
     	 Halaman ini memuat semuat liga/kompetisi yang pernah dibuat setiap tahunnya. Anda mengatur jadwal, menambah peserta pada setiap liga yang tersedia dengan menekan icon <i class="fas fa-fw fa-plus"></i> untuk menambah peserta/club yang akan diikutsertakan dalam liga dan <i class="fas fa-fw fa-calendar"></i> unntuk membuat jadwal pertandingan
     	 </p>
        ';
		
		$this->card('Daftar Liga');
		
		$this->tabelLiga();
        echo'</div></div>';
	}
	public function form_addLiga()
	{
		$liga_err = $tahun_err = $nama_err = $tim_err = $sistem_err = $logo_err ="";

		if($_SERVER['REQUEST_METHOD']=='POST'):

			if(empty($this->post('nama_liga'))){
				$liga_err = "Harap untuk memasukan nama liga";
			}else{
				$liga = $this->post('nama_liga');
				$liga = $this->esc($liga);
			}
			if(empty($this->post('tahun_penyelenggaraan'))){
				$tahun_err = "Masukan tahun penyelenggaraan";
			}elseif($this->validateNumber($this->post('tahun_penyelenggaraan'))){
				$tahun_err = "Harap masukan tahun dengan benar !";
			}else{
				$tahun = $this->post('tahun_penyelenggaraan');
				$tahun = $this->esc($tahun);
			}
			if(empty($this->post('nama_penyelenggara'))){
				$nama_err = "Nama penyelenggara tidak boleh dikosongkan";
			}else{
				$nama = $this->post('nama_penyelenggara');
				$nama = $this->esc($nama);
			}
			if(empty($this->post('jumlah_tim'))){
				$tim_err = "Masukan jumlah tim yang akan diikutsertakan";
			}elseif($this->validateNumber($this->post('jumlah_tim'))){
				$tim_err = "Masukan jumlah tim dengan benar";
			}else{
				$jumlah = $this->post('jumlah_tim');
				$jumlah = $this->esc($jumlah);
			}
			if(empty($this->post('sistem_pertandingan'))){
				$sistem_err = "Masukan jenis sistem pertandingan";
			}else{
				$sistem = $this->post('sistem_pertandingan');
				$sistem = $this->esc($sistem);
			}
			$this->getImage2('logo_liga','../../content/liga/','logo_liga_');

		    if(in_array($this->file_extension, $this->file_valid)){
				if($this->file_size>300000){
						$logo_err="Ukuran logo tidak boleh lebih dari 300KB";
					}else{
						$logo_liga=$this->file_dir;
				}
			}else{
				$logo_err="Wajib diisi dengan format JPG, JPEG, atau PNG";
			}
				
			if(empty($liga_err) && empty($tahun_er) && empty($nama_err) && empty($tim_err) && empty($sistem_err) && empty($logo_err)){

				if($this->addLiga($liga, $nama, $tahun, $jumlah, $sistem, $logo_liga, $this->file_foto, $this->file_destinasi)):
					$this->alert('success','Liga baru berhasil ditambahkan');
					$this->reload_time('2','liga');
				else:
					$this->alert('danger','Liga baru gagal ditambahkan');
					$this->reload_time('5','liga');
				endif;
			}	

		endif;

		$this->alert('info','Anda dapat menambah atau membuat liga baru pada halaman ini');
		$this->formFile();
		$this->card('Tambah Liga');

		echo'
		
		
		

		 	<div class="form-group row">
				<div class="col-sm-4 mb-3 mb-sm-0">
			    '.$this->formGroup('trophy', 'text', 'nama_liga', 'Masukan nama liga',$liga_err).'
				</div>
				<div class="col-sm-2">
				'.$this->formGroup_datepicker('calendar', 'text', 'tahun_penyelenggaraan', 'tahun','tahun',$tahun_err).'
				</div>
				<div class="col-sm-6">
				'.$this->formGroup('users', 'text', 'nama_penyelenggara', 'Masukan nama penyelenggara liga',$nama_err).'
				</div>
							                  
			</div>
	  	 	<div class="form-group row">
				<div class="col-sm-4 mb-3 mb-sm-0">
			    '.$this->formGroup('sort-amount-up', 'text', 'jumlah_tim', "Masukan jumlah tim",$tim_err).'
				</div>
				<div class="col-sm-8">
					<div class="form-group">
				        <div class="input-group">
					        <div class="input-group-prepend">
					        	<div class="input-group-text"><i class="fas fa-fw fa-compass"></i></div>
					        </div>
					       		<select class="form-control" name="sistem_pertandingan" required="">
					       			<option></option>
					       			<option value="Sistem Setengah Kompetisi">Sistem Setengah Kompetisi</option>
					       			<option value="Sistem Kompetisi Penuh">Sistem Kompetisi Penuh</option>
					       			<option value="Sistem Gugur Tunggal">Sistem Gugur Tunggal</option>
					       			<option value="Sistem Gugur Rangkap">Sistem Gugur Rangkap</option>
					       			<option value="Sistem Consulation">Sistem Consulation</option>
					       			<option value="Sistem Kombinasi">Sistem Kombinasi</option>

					       			
					       		</select>
					    </div>	
					    
					  <span class="text-danger">'.$sistem_err.'</span>          
				    </div>
				</div>
							                  
			</div>
			'.$this->formGroup_file('file','logo_liga',$logo_err).'
	   		 '.$this->formGroup_button('btn-primary', 'btn-md', 'save','Simpan').' 

		';

		echo '</div></div></form>';
	}
	public function form_editLiga()
	{
		if(!$this->detailLiga($this->get('id_liga'))) die($this->alert('danger','Id liga not Found !'));
		$liga_err = $tahun_err = $nama_err = $tim_err = $sistem_err = $logo_err ="";
		if($_SERVER['REQUEST_METHOD']=='POST'):

			if(empty($this->post('nama_liga'))){
				$liga_err = "Harap untuk memasukan nama liga";
			}else{
				$liga = $this->post('nama_liga');
				$liga = $this->esc($liga);
			}
			if(empty($this->post('tahun_penyelenggaraan'))){
				$tahun_err = "Masukan tahun penyelenggaraan";
			}elseif($this->validateNumber($this->post('tahun_penyelenggaraan'))){
				$tahun_err = "Harap masukan tahun dengan benar !";
			}else{
				$tahun = $this->post('tahun_penyelenggaraan');
				$tahun = $this->esc($tahun);
			}
			if(empty($this->post('nama_penyelenggara'))){
				$nama_err = "Nama penyelenggara tidak boleh dikosongkan";
			}else{
				$nama = $this->post('nama_penyelenggara');
				$nama = $this->esc($nama);
			}
			if(empty($this->post('jumlah_tim'))){
				$tim_err = "Masukan jumlah tim yang akan diikutsertakan";
			}elseif($this->validateNumber($this->post('jumlah_tim'))){
				$tim_err = "Masukan jumlah tim dengan benar";
			}else{
				$jumlah = $this->post('jumlah_tim');
				$jumlah = $this->esc($jumlah);
			}
			if(empty($this->post('sistem_pertandingan'))){
				$sistem_err = "Masukan jenis sistem pertandingan";
			}else{
				$sistem = $this->post('sistem_pertandingan');
				$sistem = $this->esc($sistem);
			}
			if(empty($_FILES['logo_liga']['tmp_name'])):
					$logo_liga=$this->logo_liga;
					$this->file_foto=$this->logo_liga;
					$this->file_destinasi="";
				else:
					$this->getImage2('logo_liga','../../content/liga/','logo_liga_');
					if(in_array($this->file_extension, $this->file_valid)){
							if($this->file_size>600000){
							    $logo_err="Ukuran foto tidak boleh lebih dari 600KB";
							   }else{
							    $logo_liga=$this->file_dir;
							}
					}else{
						$logo_err="Wajib diisi dengan format JPG, JPEG, atau PNG";
					}
				endif;
			if(empty($liga_err) && empty($tahun_er) && empty($nama_err) && empty($tim_err) && empty($sistem_err) && empty($logo_err)){

				if($this->updateLiga($liga, $nama, $tahun, $jumlah, $sistem, $logo_liga, $this->file_foto, $this->file_destinasi, $this->id_liga)):
					$this->alert('success','Liga berhasil diperbaharui');
					$this->reload_time('2','liga');
				else:
					$this->alert('danger','Liga baru gagal diperbaharui');
					$this->reload_time('51','liga');
				endif;
			}	

		endif;
		$this->formFile();
		$this->card('Edit Liga');
		echo'
		
		
		

		 	<div class="form-group row">
				<div class="col-sm-4 mb-3 mb-sm-0">
			    '.$this->formGroup_edit('trophy', 'text', 'nama_liga', 'Masukan nama liga',$this->nama_liga, $liga_err).'
				</div>
				<div class="col-sm-2">
				'.$this->formGroup_datepicker_edit('calendar', 'text', 'tahun_penyelenggaraan', 'tahun','tahun',$this->tahun_penyelenggaraan, $tahun_err).'
				</div>
				<div class="col-sm-6">
				'.$this->formGroup_edit('users', 'text', 'nama_penyelenggara', 'Masukan nama penyelenggara liga',$this->nama_penyelenggara, $nama_err).'
				</div>
							                  
			</div>
	  	 	<div class="form-group row">
				<div class="col-sm-4 mb-3 mb-sm-0">
			    '.$this->formGroup_edit('sort-amount-up', 'text', 'jumlah_tim', "Masukan jumlah tim",$this->jumlah_tim, $tim_err).'
				</div>
				<div class="col-sm-8">
					<div class="form-group">
				        <div class="input-group">
					        <div class="input-group-prepend">
					        	<div class="input-group-text"><i class="fas fa-fw fa-compass"></i></div>
					        </div>
					       		<select class="form-control" name="sistem_pertandingan" required="">
					       			<option value="'.$this->sistem_pertandingan.'">'.$this->sistem_pertandingan.'</option>
					       			<option value="Sistem Setengah Kompetisi">Sistem Setengah Kompetisi</option>
					       			<option value="Sistem Kompetisi Penuh">Sistem Kompetisi Penuh</option>
					       			<option value="Sistem Gugur Tunggal">Sistem Gugur Tunggal</option>
					       			<option value="Sistem Gugur Rangkap">Sistem Gugur Rangkap</option>
					       			<option value="Sistem Consulation">Sistem Consulation</option>
					       			<option value="Sistem Kombinasi">Sistem Kombinasi</option>

					       			
					       		</select>
					    </div>	
					    
					  <span class="text-danger">'.$sistem_err.'</span>          
				    </div>
				</div>

							                  
			</div>

			'.$this->formGroup_file('file','logo_liga',$logo_err).'	

			<div class="form-group">
	   		 '.$this->getDirImage2('../../content/liga/',$this->logo_liga).'
	   		</div>	 
	   		 '.$this->formGroup_button('btn-primary', 'btn-md', 'save','Simpan').' 
	   		 <a class="btn btn-md btn-primary" href="?page=liga">Kembali</a>
		';
		echo '</div></div></form>';
	}
	public function form_deleteLiga()
	{
		if(!$this->detailLiga($this->get('id_liga'))) die($this->alert('danger','Id liga not Found !'));

		if($_SERVER['REQUEST_METHOD']=='POST'):
			if($this->getImage_unlink('content/liga/',$this->logo_liga)){
				if($this->deleteLiga($this->id_liga)):
					$this->deleteLiga_fromPeserta($this->id_liga);
					$this->deleteLiga_fromJadwal($this->id_liga);
					$this->alert('success','Data liga berhasil dihapus');
					$this->reload_time('2','liga');
				else:
					$this->alert('danger','Data gagal dihapus');
					$this->reload_time('3','liga');
				endif;
			}else{
				$this->alert('danger','Tidak dapat menghapus data logo. Data gagal dihapus');
			}
		endif;

		$this->alert('danger','Aksi ini dapat mengahapus liga, peserta liga dan jadwal liga yang terdapat didalamnya ?');
		$this->formGeneral();
		echo '
		'.$this->formGroup_button('btn-danger', 'btn-md', 'trash','Hapus').'
		'; 
		echo '</form>';
	}

	public function form_addPeserta()
	{
		if(!$this->detailLiga($this->get('id_liga'))) die($this->alert('danger','Id liga Not Found'));
		$id_club_err ="";
		if(isset($_POST['tambah'])):
			if(empty($this->post('id_club'))){
				$id_club_err = "Harap pilih club yang tersedia untuk ditambahkan";
			}else{
				$id_club = $this->post('id_club');
				$id_club = $this->esc($id_club);
			}
			if(empty($id_club_err)){
				if($this->addPeserta_liga($this->id_liga, $id_club)):
					$this->alert('success','Peserta baru berhasil ditambahkan');
					
				else:
					$this->alert('danger','Peserta baru gagal ditambahkan');
					$this->reload_time('5',NULL);
				endif;
			}
		endif;
		echo
		'
			<ul class="nav nav-tabs mb-4" role="tablist">
			    <li class="nav-item">
			      <a class="nav-link active" data-toggle="tab" href="#home">Buat Jadwal</a>
			    </li>
			    <li class="nav-item">
			      <a class="nav-link" data-toggle="tab" href="#menu1">Info & Daftar Peserta</a>
			    </li>		    
		  </ul>
		  <div class="tab-content">
			<div id="home" class="tab-pane active">
		';

				$this->formGeneral();
				$this->card('Tambah Peserta liga');
				echo'
				<div class="row">
					<div class="col-xl-7 col-lg-7">';
						$this->fetchClub_option();
						echo'
					</div>
					<div class="col-xl-4 col-lg-4">
						 '.$this->formGroup_button2('tambah','btn-md,','save', 'Tambah').'
						 <a class="btn btn-md btn-primary" href="?page=liga">Kembali</a>
					</div>
				</div></div></div></form>
			</div>
			<div id="menu1" class="container tab-pane fade">
		';
				$this->tabelPeserta_liga();
			echo'</div></div>';
	}
	public function tabelPeserta_liga()
	{
		
		
		echo
		'
		<div class="row mb-4">
			<div class="col-xl-6 col-lg-6">
			
					<div class="table-responsive">
		                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size:14px">
		                  <thead>
		                    <tr>
		                      <th>No</th>
		                      <th>Nama Club</th>             
		                      <th>Aksi</th>
		                   
		                    </tr>
		                  </thead>
		                  <tfoot>
		                    <tr>
		                      <th>No</th>
		                      <th>Nama Club</th>                     
		                      <th>Aksi</th>
		                    </tr>
		                  </tfoot>
		                  <tbody>
			              ';
			              
			              $this->no = 1;
			              $this->liga = $this->viewPeserta_liga($this->get('id_liga'));	              
			              while($this->row=$this->liga->fetch_array()):
			              	echo '
			              		<tr>
				              		<td>'.$this->no.'</td>
				              		<td>'.$this->row['nama_club'].'</td>		              		
				              		<td>
				              		<a href="?page=pemain&id_club='.$this->row['id_club'].'"><i class="fas fa-fw fa-users"></i></a>
				              		 <a href="?page=delete peserta&id_peserta='.$this->row['id_peserta'].'&id_liga='.$this->row['id_liga'].'"><i class="fas fa-fw fa-trash"></i></a>
				              		 
				              		</td>
			              		</tr>

			              	';
			              	$this->no+=1;
			              endwhile;


			              echo
			              '
		                   
		                  </tbody>
		                </table>
		            </div>
		      
		    </div>
		    <div class="col-xl-6 col-lg-6">
		    	<div class="card shadow mb-4">
			    	<div class="card-header py-3">
		                <h6 class="m-0 font-weight-bold text-primary">Info Liga</h6>
		            </div>
		            <div class="text-center">
						'.$this->getDirImage_round2('../../content/liga/',$this->logo_liga).'
					</div>
					<div class="table-responsive text-capitalize">
		                <table class="table table-borderless text-capitalize mt-4">
		                  <tbody>

		                  	<tr>
			           			<td>Nama Liga</td>
			           			<td>:</td>	           			
			           			<td>'.$this->nama_liga.'</td>
			           		</tr>
			           		<tr>
			           			<td>Nama Penyelenggara</td>
			           			<td>:</td>	           			
			           			<td>'.$this->nama_penyelenggara.'</td>
			           		</tr>
			           		<tr>
			           			<td>Jumlah TIM</td>
			           			<td>:</td>	           			
			           			<td>'.$this->jumlah_tim.'</td>
			           		</tr>
			           		<tr>
			           			<td>Sistem Tanding</td>
			           			<td>:</td>	           			
			           			<td>'.$this->sistem_pertandingan.'</td>
			           		</tr>
			           		<tr>
			           			<td>Tahun</td>
			           			<td>:</td>	           			
			           			<td>'.$this->tahun_penyelenggaraan.'</td>
			           		</tr>
			              			              
		                  </tbody>
		                </table>
		       		</div>
		
					<a class="text-center mb-2-4 p-2" href="?page=edit liga&id_liga='.$this->id_liga.'">Edit</a>
				</div>
		    </div>
		</div> 
	          
		';
	}
	public function form_deletePeserta()
	{
		if(!$this->detailPeserta($this->get('id_peserta'))) die($this->alert('danger','Id liga not Found !'));

		if($this->deletePeserta_liga($this->id_peserta)):
			$this->alert('success','Peserta berhasil dihapus');
			$this->reload_time('1','tambah peserta liga&id_liga='.$this->get('id_liga').'');
		else:
			$this->alert('danger','Data gagal dihapus');
			$this->reload_time('5','liga');
		endif;
	}
	public function tabelJadwal_liga()
	{
		echo
		'
		<div class="row shadow mb-4">

			<div class="col-xl-12 col-lg-12">
						<a class="btn btn-sm btn-primary float-right mt-2 mb-2" href="../../app/export/export.jadwal.liga.php?id_liga='.$this->get('id_liga').'"><i class="fas fa-fw fa-download"></i></a>
					<div class="table-responsive mt-4">
					


		                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size:14px">
		                  <thead>
		                    <tr>
		                      <th>Laga Ke</th>
		                      <th>Minggu ke</th>             
		                      <th>Hari/Tanggal</th>
		                      <th>Tim Tuan Rumah</th>
		                      <th>Skor</th>
		                      <th>Tim Tamu</th>
		                      <th>Berlangsung di</th>
		                      <th>Aksi</th>
		                   
		                    </tr>
		                  </thead>
		                  <tfoot>
		                    <tr>
		                      <th>Laga Ke</th>
		                      <th>Minggu ke</th>             
		                      <th>Hari/Tanggal</th>
		                      <th>Tim Tuan Rumah</th>
		                      <th>Skor</th>
		                      <th>Tim Tamu</th>
		                      <th>Berlangsung di</th>
		                      <th>Aksi</th>
		                    </tr>
		                  </tfoot>
		                  <tbody>
		                  
			              ';
			              
			        
			              $this->no = 1;
			              $this->liga = $this->viewJadwal_liga($this->get('id_liga'));	              
			              while($this->row=$this->liga->fetch_array()):
			              	echo '
			              		<tr>
				              		<td>'.$this->no.'</td>
				              		<td>'.$this->row['minggu_ke'].'</td>
				              		<td>'.$this->row['hari'].' , '.$this->row['tanggal'].' '.$this->row['jam'].'</td>
				              		<td>'.$this->viewJadwal_shownameClub($this->row['tim_tuan_rumah']).'</td>
				              		<td>'.$this->row['skor_tuan_rumah'].' - '.$this->row['skor_tim_tamu'].'</td>		
				              		<td>'.$this->viewJadwal_shownameClub($this->row['tim_tamu']).'</td> 
				              		<td>'.$this->row['tempat'].'</td>            		
				              		<td>
				              		';
					              		if(empty($_GET['id_jadwal'])):
					              			echo 
					              			'
					              			 	<a href="'.$_SERVER['REQUEST_URI'].'&edit jadwal&id_jadwal='.$this->row['id_jadwal'].'"><i class="fas fa-fw fa-edit"></i></a>
					              			 	<a href="?page=delete jadwal&id_jadwal='.$this->row['id_jadwal'].'"><i class="fas fa-fw fa-trash"></i></a>
					              			 ';
					              		else: 

					              		 echo 
					              			'
					              			 	<a href="#"><i class="fas fa-fw fa-edit btn-secondary"></i></a>
					              			 	<a href="#"><i class="btn-secondary fas fa-fw fa-trash"></i></a>
					              			 ';
					              		endif;

				              		echo'
				              		 
				              		</td>
			              		</tr>

			              	';
			              	$this->no+=1;
			              endwhile;
							

			              echo
			              '
		                   
		                  </tbody>
		                </table>
		            </div>
		      
		    </div>
		   
		</div> 
	          
		';
	}
	public function tabelJadwal_pertandingan()
	{
		echo
		'
		<div class="card shadow mb-4 mt-2">

			<div class="col-xl-12 col-lg-12">

						<a class="btn btn-sm btn-secondary mt-2 mb-2" href="../../app/export/export.jadwal.liga.php?id_liga='.$this->get('id_tanding').'"><i class="fas fa-fw fa-save"></i> Simpan
						</a> 
						<a class="btn btn-sm btn-secondary mt-2 mb-2" href="?page=jadwal tanding"> x Tutup
						</a>
					<div class="table-responsive mt-4">
					


		                <table class="table table-bordered"  cellspacing="0" style="font-size:14px">
		                  <thead>
		                    <tr>
		                      <th>Laga Ke</th>
		                      <th>Minggu ke</th>             
		                      <th>Hari/Tanggal</th>
		                      <th>Tim Tuan Rumah</th>
		                      <th>Skor</th>
		                      <th>Tim Tamu</th>
		                      <th>Berlangsung di</th>
		                      
		                   
		                    </tr>
		                  </thead>
		                  <tfoot>
		                    <tr>
		                      <th>Laga Ke</th>
		                      <th>Minggu ke</th>             
		                      <th>Hari/Tanggal</th>
		                      <th>Tim Tuan Rumah</th>
		                      <th>Skor</th>
		                      <th>Tim Tamu</th>
		                      <th>Berlangsung di</th>
		                      
		                    </tr>
		                  </tfoot>
		                  <tbody>
		                  
			              ';
			              
			        
			              $this->no = 1;
			              $this->liga = $this->viewJadwal_liga($this->get('id_tanding'));	              
			              while($this->row=$this->liga->fetch_array()):
			              	echo '
			              		<tr>
				              		<td>'.$this->no.'</td>
				              		<td>'.$this->row['minggu_ke'].'</td>
				              		<td>'.$this->row['hari'].' , '.$this->row['tanggal'].' '.$this->row['jam'].'</td>
				              		<td>'.$this->viewJadwal_shownameClub($this->row['tim_tuan_rumah']).'</td>
				              		<td>'.$this->row['skor_tuan_rumah'].' - '.$this->row['skor_tim_tamu'].'</td>		
				              		<td>'.$this->viewJadwal_shownameClub($this->row['tim_tamu']).'</td> 
				              		<td>'.$this->row['tempat'].'</td>            		
				              		
				              		';
					              		

				              		echo'
				              		 
				              		
			              		</tr>

			              	';
			              	$this->no+=1;
			              endwhile;
							

			              echo
			              '
		                   
		                  </tbody>
		                </table>
		            </div>
		      
		    </div>
		   
		</div> 
	          
		';
	}
	public function form_addJadwal()
	{
		
		if(empty($_GET['id_jadwal'])){
			if(!$this->detailLiga($this->get('id_liga'))) die($this->alert('danger','Id liga not Found !'));
			$this->minggu_ke = $this->hari = $this->tanggal = $this->jam = $this->tim_tuan_rumah = $this->tim_tamu = $this->skor_tuan_rumah = $this->skor_tim_tamu = $this->tempat = $batal_edit ="";

		}else{
		
			if(!$this->detailLiga($this->get('id_liga'))) die($this->alert('danger','Id liga not Found !'));
			if(!$this->detailJadwal($this->get('id_jadwal'))) die($this->alert('danger','Id liga not Found !'));
			$batal_edit = '<a class="btn btn-md btn-secondary float-right" href="?page=jadwal liga&id_liga='.$this->id_liga.'">Selesai</a>';
		}

		$minggu_err = $hari_err = $tanggal_err = $jam_err = $ttr_err = $tt_err = $sr_err = $st_err = $tempat_err=  "";
		
		if(isset($_POST['simpan_jadwal'])):

			if(empty($this->post('minggu'))){
				$minggu_err = "Harap masukan minggu ke berapa";
			}elseif($this->validateNumber($this->post('minggu'))){
				$minggu_err = "Harap hanya masukan karakter angka saja";
			}else{
				$minggu = $this->post('minggu');
				$minggu = $this->esc($minggu);
			}
			if(empty($this->post('hari'))){
				$hari_err = "Harap pilih hari";
			
			}else{
				$hari = $this->post('hari');
				$hari = $this->esc($hari);
			}
			if(empty($this->post('tanggal'))){
					$tanggal_err='Tanggal tidak boleh kosong';	
				}elseif(strlen($this->post('tanggal'))!=10){
					$tanggal_err='Format penulisan tanggal salah';	
				}elseif($this->CekTLS_tanggal($this->post('tanggal'))){
					$tanggal_err='Format penulisan tanggal salah';
				}
				else{
					
					if(!$this->BCA_tanggal($this->post('tanggal'))):
						$tanggal_err='Format penulisan tanggal salah';
					else:
						$tanggal=$this->post('tanggal');
						$tanggal=$this->esc($tanggal);
					endif;			
			}
			if(empty($this->post('jam'))){
				$jam_err = "Masukan jam pertandingan";
			}else{
				$jam = $this->post('jam');
				$jam = $this->esc($jam);
			}
			if(empty($this->post('tim_tuan_rumah'))){
				$ttr_err = "Pilih tim tuan rumah";
			}elseif($this->validateNumber($this->post('tim_tuan_rumah'))){
				$ttr_err = "Pilih tim tuan rumah dengan benar";
			}else{
				$tim_tuan_rumah = $this->post('tim_tuan_rumah');
				$tim_tuan_rumah = $this->esc($tim_tuan_rumah);
			}
			if(empty($this->post('tim_tamu'))){
				$tt_err = "Pilih tim tamu";
			}elseif($this->validateNumber($this->post('tim_tamu'))){
				$tt_err = "Pilih tim tamu dengan benar";
			}else{
				$tim_tamu = $this->post('tim_tamu');
				$tim_tamu = $this->esc($tim_tamu);
			}
			if($this->validateNumber($this->post('skor_rumah'))){
				$sr_err = "Masukan skor dengan benar";
			}else{
				$skor_rumah = $this->post('skor_rumah');
				$skor_rumah = $this->esc($skor_rumah);
			}
			if($this->validateNumber($this->post('skor_tamu'))){
				$st_err = "Masukan skor dengan benar";
			}else{
				$skor_tamu = $this->post('skor_tamu');
				$skor_tamu = $this->esc($skor_tamu);
			}
			if(empty($this->post('tempat'))){
				$tempat_err = "Pilih tempat pertandingan";
			}else{
				$tempat = $this->post('tempat');
				$tempat = $this->esc($tempat);
			}
					
		
			if(empty($minggu_err) && empty($hari_err) && empty($tanggal_err) && empty($jam_err) && empty($ttr_err) && empty($tt_err) && empty($sr_err) && empty($st_err) && empty($tempat_err)){

				if(empty($_GET['id_jadwal'])){
					if($this->addJadwal($this->id_liga, $minggu, $hari, $tanggal, $jam, $tim_tuan_rumah, $tim_tamu, $skor_rumah, $skor_tamu, $tempat)):
						$this->alert('success','Jadwal Berhasil ditambahkan');
					else:
						$this->alert('danger','Jadwal gagal ditambahkan');
						$this->reload_time('5','liga');
					endif;
				}else{
					if($this->updateJadwal($this->id_liga, $minggu, $hari, $tanggal, $jam, $tim_tuan_rumah, $tim_tamu, $skor_rumah, $skor_tamu, $tempat, $this->id_jadwal)):
						$this->alert('success','Jadwal Berhasil diperbaharui');
					else:
						$this->alert('danger','Jadwal gagal diperbaharui');
						$this->reload_time('5','liga');
					endif;
				}

				
				
				
				
				
			}

		endif;

		echo '
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
	            <h1 class="h3 mb-0 text-gray-800">Pengaturan Jadwal</h1>
	            
        </div>
        <p class="mb-4">
     	 	Halaman ini memuat jadwal pertandingan dari setiap liga yang pernah/sudah dibuat sebelumnya. Anda dapat menyimpan jadwal pada liga/pertandinga yang tersedia
        </p>
        <ul class="nav nav-tabs mb-2" role="tablist">
		    <li class="nav-item">
		      <a class="nav-link active" data-toggle="tab" href="#home">Buat Jadwal</a>
		    </li>
		    <li class="nav-item">
		      <a class="nav-link" data-toggle="tab" href="#menu1">Sub Menu</a>
		    </li>
		    <li class="nav-item">
		      <a class="nav-link" data-toggle="tab" href="#menu2">Data Menu</a>
		    </li>
		    
		  </ul>
		<div class="tab-content">
			<div id="home" class="tab-pane active">
        ';
        
			$this->formGeneral();
			$this->card('Buat Jadwal');
			echo'
			<div class="row">
				
				<div class="col-sm-2 mt-2">
				    '.$this->formGroup_edit('calendar', 'text', 'minggu', 'Minggu ke',$this->minggu_ke, $minggu_err).'
				</div>
				<div class="col-sm-4 mt-2">
						<div class="form-group">
					        <div class="input-group">
						        <div class="input-group-prepend">
						        	<div class="input-group-text"><i class="fas fa-fw fa-calendar"></i></div>
						        </div>
						       		<select class="form-control" name="hari" required="">
						       			<option value="'.$this->hari.'">'.$this->hari.'</option>					       	
						       			<option value="Senin">Senin</option>
						       			<option value="Selasa">Selasa</option>
						       			<option value="Rabu">Rabu</option>
						       			<option value="Kamis">Kamis</option>
						       			<option value="Jumat">Jumat</option>
						       			<option value="Sabtu">Sabtu</option>
						       			<option value="Minggu">Minggu</option>
						       		</select>
						    </div>	
						    <span class="text-danger">'.$hari_err.'</span>        
					    </div>
				</div>
				<div class="col-sm-3 mt-2">
					
					'.$this->formGroup_datepicker_edit('calendar', 'text', 'tanggal', ''.date("d-m-yy").'','tanggal', $this->tanggal, $tanggal_err).'
				</div>

				<div class="col-sm-3 mt-2">				
					'.$this->formGroup_edit('clock', 'text', 'jam','Masukan jam',$this->jam, $jam_err).'
							
				</div>

				<div class="col-xl-6 col-lg-6 mt-2">';
					$this->fetchLiga_byid_tuanRumah();
					echo'
				</div>

				<div class="col-xl-6 col-lg-6 mt-2">';
					$this->fetchLiga_byid_tamu();
					echo'
				</div>

				

			</div>


			<div class="row">
								                  
				<div class="col-xl-6 col-lg-6 mt-2">
					'.$this->formGroup_edit('plus-square', 'number', 'skor_rumah', 'skor tuan rumah, masukan 0 jika belum ada',$this->skor_tuan_rumah, $st_err).'
				</div>
				<div class="col-xl-6 col-lg-6 mt-2">
					'.$this->formGroup_edit('plus-square', 'number', 'skor_tamu', 'skor tim tamu, masukan 0 jika belum ada',$this->skor_tim_tamu, $st_err).'
				</div>

				

			</div>

			<div class="row">
				<div class="col-xl-12 col-lg-12 mt-2">
				    '.$this->formGroup_edit('chess-board', 'text', 'tempat', 'Berlangsung di',$this->tempat, $tempat_err).'
				</div>
				
				
				
			</div>
			'.$this->formGroup_button2('simpan_jadwal','btn-md,','save', 'Simpan').'&nbsp;
				<a class="btn btn-md btn-primary" href="?page=liga">Kembali</a>
				'.$batal_edit.'

			</div></div></form></div>

		<div id="menu1" class="container tab-pane fade">
		';
			$this->tabelJadwal_liga();
		echo '</div></div>';
       
	}
	public function jadwalPertandingan()
	{
		
		echo
		'
		<div class="d-sm-flex align-items-center justify-content-between mb-4">
	            <h1 class="h3 mb-0 text-gray-800">Jadwal Pertandingan</h1>
	            
        </div>

             <p class="mb-4">
     	  Anda bisa menambah jadwal pertandingan pada setiap liga yang pernah Anda buat pada halaman <a href="?page=liga">Liga</a>. Untuk input skor jika belum ada biarkan saja kosong
        </p>

		<div class="card shadow">
		 <div class="table-responsive mb-2 mt-2 p-2">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Nama Liga</th>
                      <th>Tahun</th>                     
                      <th>Lihat</th>
                   
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>No</th>
                      <th>Nama Liga</th>
                      <th>Tahun</th>                     
                      <th>Lihat</th>
                    </tr>
                  </tfoot>
                  <tbody>
	              ';
	              
	              $this->no = 1;
	              $this->liga = $this->viewLiga();	              
	              while($this->row=$this->liga->fetch_array()):
	              	echo '
	              		<tr>
		              		<td>'.$this->no.'</td>
		              		<td>'.$this->row['nama_liga'].'</td>
		              		<td>'.$this->row['tahun_penyelenggaraan'].'</td>
		              		
		              		<td>
		              		
		              		<a class="btn btn-md btn-primary" href="?page=jadwal tanding&id_tanding='.$this->row['id_liga'].'" title="input jadwal">Lihat Jadwal</a>

		              		
		              		</td>
	              		</tr>

	              	';
	              	$this->no+=1;
	              endwhile;


	              echo
	              '
                   
                  </tbody>
                </table>
         </div>
        </div>      
		';
		if(!empty($_GET['id_tanding'])){
			$this->tabelJadwal_pertandingan();
		}	
		
	}
	public function saveLiga()
	{
		if(!$this->detailLiga($this->get('id_liga'))) die($this->alert('danger','Id liga not Found !'));
		echo'
		<!DOCTYPE html>
		<html>
		<head>
			<title>Export Data</title>
		</head>
		<body>
			<table border="1">
				<tr>
					<td colspan="7" align="center"> <h3>JADWAL & SKOR LIGA '.$this->nama_liga.' TAHUN '.$this->tahun_penyelenggaraan.'</h3></td>
				</tr>
						       
				<tr>
					<thead>
		               <tr>
		                	<th>Laga Ke</th>
		                    <th>Minggu ke</th>             
		                    <th>Hari/Tanggal</th>
		                    <th>Tim Tuan Rumah</th>
		                    <th>Skor</th>
		                    <th>Tim Tamu</th>
		                    <th>Berlangsung di</th>
		                  
		                   
		                </tr>
		            </thead>
						';
						$this->no = 1;
			              $this->liga = $this->viewJadwal_liga($this->id_liga);	              
			              	while($this->row=$this->liga->fetch_array()):
				              	echo '
				              		<tr>
					              		<td>'.$this->no.'</td>
					              		<td>'.$this->row['minggu_ke'].'</td>
					              		<td>'.$this->row['hari'].' , '.$this->row['tanggal'].' '.$this->row['jam'].'</td>
					              		<td>'.$this->viewJadwal_shownameClub($this->row['tim_tuan_rumah']).'</td>
					              		<td>"'.$this->row['skor_tuan_rumah'].'" - "'.$this->row['skor_tim_tamu'].'"</td>		
					              		<td>'.$this->viewJadwal_shownameClub($this->row['tim_tamu']).'</td> 
					              		<td>'.$this->row['tempat'].'</td>   
					              	</tr>
					            ';
					           $this->no+=1;
				       		endwhile;
				       		$this->liga->free_result();
		echo '    
			</table>
		</body>
		</html>
		';
	}
}

?>