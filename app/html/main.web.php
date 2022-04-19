<?php
class main_Web extends web
{
	public function home()
	{
		$this->loadInfo();
		echo '
	      <header class="py-5 bg-image-full bg-image-height" style="background-image: url(http://'.$_SERVER['SERVER_NAME'].'/soccer/content/web/cover.jpg);">         
	      </header>
	      	<section class="py-5">
	          <div class="container">
	            <h3>Selamat Datang di situs '.$this->infosite['nama_situs'].'</h3>
	            <p class="lead">'.$this->infosite['deskripsi_situs'].'</p><hr>
	          </div>
	        </section>
   
    	';	
	}
	
	public function berita_beranda()
	{
		echo
		'
		<div class="container related mb-4" style="margin-top:50px;">	
				<nav aria-label="breadcrumb">			
				  <div class="card shadow bg-secondary p-2 mb-4 shadow font-weight-bold text-white">
				  		<h5>Berita SOCCER </h5>
				  </div>
				</nav>
			<div class="row">					
			';
	           		 $main_berita=$this->showBerita_beranda();	               		
	                  		while($row=$main_berita->fetch_array()):
	                  			echo'
	                  		<div class="col-md-3 col-sm-4 pt-2">
	                  			<div class="box-item">
					                <div class="box-post">
					                    <span class="badge badge-success">
					                        <a href="#" rel="tag">'.$row['kategori_berita'].'</a>
					                    </span>
					                    <h4 class="post-title">
					                    ';
					                    if(strlen($row['judul_berita'])>50){
					                        echo'<a href="berita?id_berita='.$row['id_berita'].'">
					                             '.substr($row['judul_berita'],0,50).'...
					                        </a>';
					                    }else{
					                    	echo'<a href="berita?id_berita='.$row['id_berita'].'">
					                             '.substr($row['judul_berita'],0,50).'
					                        </a>';
					                    }
					                    echo'
					                    </h4>
					                    <span class="meta">
					                        
					                        <span><i class="glyphicon glyphicon-time"></i> '.$row['tanggal_berita'].'</span>
					                    </span>
					                </div>
					               	<img src="content/berita/'.$row['gambar_berita'].'" 
                					class="img-fluid">  
					            </div>
					        </div>';
	                  		endwhile;
	                  	
	        echo'
	        	<div class="col">
	               <a href="semua_berita" class="btn btn-secondary btn-md mt-2"> Semua Berita</a>
	            </div>
	        </div>
	    </div>
	    '; 
	}
	public function semua_berita(){
		
		echo
		'
		<div class="container" style="margin-top:50px;">	
			<nav aria-label="breadcrumb">			
			  <div class="card shadow bg-secondary p-2 mb-4 shadow font-weight-bold text-white">
			  		<h5>BERITA SOCCER</h5>
			  </div>
			</nav>
				<div class="row">

					
			';
	           		 $main_berita=$this->limitBerita();	
	               		if($main_berita->num_rows>0){
	                  		while($row=$main_berita->fetch_array()):
	                  			echo'
	                  			<div class="col-md-4 col-lg-4 jasgrid">
	                  			<div class="box-item">
					                <div class="box-post">
					                    <span class="badge badge-success">
					                        <a href="#" rel="tag">'.$row['kategori_berita'].'</a>
					                    </span>
					                    <h3 class="post-title">
					                    ';
					                    if(strlen($row['judul_berita'])>50){
					                        echo'<a href="berita?id_berita='.$row['id_berita'].'">
					                             '.substr($row['judul_berita'],0,50).'...
					                        </a>';
					                    }else{
					                    	echo'<a href="berita?id_berita='.$row['id_berita'].'">
					                             '.substr($row['judul_berita'],0,50).'
					                        </a>';
					                    }
					                    echo'
					                    </h3>
					                    <span class="meta">
					                        
					                        <span><i class="glyphicon glyphicon-time"></i> '.$row['tanggal_berita'].'</span>
					                    </span>
					                </div>
					               	<img src="content/berita/'.$row['gambar_berita'].'" 
                					class="img-fluid">  
					            </div>
					             </div>';
	                  		endwhile;
	                  	}else{

	                  		echo '<h1>Content Not fount</h1>';
	                  		$this->reload_time('1','home');
	                  	}
	        echo'
	               
	            </div>
	    </div>
	        ';       			  
	}
	public function readBerita()
	{
		
		echo'
		<div class="container mt-4 mb-4">
			<div class="row">
				<div class="card shadow">

					<div class="d-flex justify-content-center">
						'.$this->getDirImage_artikel('content/berita/',$this->gambar_berita).'
					</div>

					<div class="d-sm-flex align-items-center justify-content-between ">
				        <span class="bg-line text-dark p-2">Berita Harian</span>				        
			        </div>
			        <hr/>				

			        <h3 class="p-4">'.$this->judul_berita.'</h3>
			        <div class="row m-2 p-4">
			        	'.htmlspecialchars_decode($this->isi_berita).'
			        </div>
			        <div class="d-flex mt-4 p-4">
			        	<i class="fas fa-fw fa-user"></i>'.$this->penulis_berita.' &nbsp;        
			        	<i class="fas fa-fw fa-tag"></i>'.$this->kategori_berita.'&nbsp;
			        	<i class="fas fa-fw fa-calendar"></i>'.$this->tanggal_berita.'&nbsp;
			        	

			        </div>
			    </div>    
		    </div>
		</div>
		';
	}
	public function relatedBerita()
	{
		echo
		'
		<div class="container related mb-4" style="margin-top:50px;">	
			<nav aria-label="breadcrumb">			
			  <div class="card shadow bg-secondary p-2 mb-4 shadow font-weight-bold text-white">
			  		<h5>Related Post :</h5>
			  </div>
			</nav>
				<div class="row">

					
			';
	           		 $main_berita=$this->relatedPost($this->kategori_berita, $this->id_berita);	
	               		
	                  		while($row=$main_berita->fetch_array()):
	                  			echo'
	                  			<div class="col-md-4 col-sm-2 pt-2">
	                  			<div class="box-item">
					                <div class="box-post">
					                    <span class="badge badge-success">
					                        <a href="#" rel="tag">'.$row['kategori_berita'].'</a>
					                    </span>
					                    <h4 class="post-title">
					                    ';
					                    if(strlen($row['judul_berita'])>50){
					                        echo'<a href="berita?id_berita='.$row['id_berita'].'">
					                             '.substr($row['judul_berita'],0,50).'...
					                        </a>';
					                    }else{
					                    	echo'<a href="berita?id_berita='.$row['id_berita'].'">
					                             '.substr($row['judul_berita'],0,50).'
					                        </a>';
					                    }
					                    echo'
					                    </h4>
					                    <span class="meta">
					                        
					                        <span><i class="glyphicon glyphicon-time"></i> '.$row['tanggal_berita'].'</span>
					                    </span>
					                </div>
					               	<img src="content/berita/'.$row['gambar_berita'].'" 
                					class="img-fluid">  
					            </div>
					             </div>';
	                  		endwhile;
	                  	
	        echo'
	               
	            </div>
	    </div>
	        ';    
	}
	public function pagging()
	{
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
	                 <li class="page-item"><a class="page-link"  href="javascript:history.back()">Previous</a>
	                 </li>
	              </li>';
             }else{
          
              echo'
               <ul class="pagination justify-content-center mt-4">
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

                 		$this->reload_time('1','semua_berita');
	                  
	               else:

	               		$number=$this->get('halaman');
	               		if(!is_numeric($number)) die($this->reload_time('1','semua_berita'));

		               	echo'
		                  <li class="page-item">
		                   
		                     <li class="page-item"><a class="page-link"  href="?page=berita&halaman='.($number+1).'">Next</a></li>
		                   
		                 	
		                </ul>';
	               endif;
            }
        endif;
	}
	public function jadwal_beranda()
	{
		$data = $this->jadwalPertandingan_beranda();
		if($data->num_rows>0):
			$liga = $data->fetch_array();
			$bln_main=$this->tanggalMain($liga['tanggal']);
			
			echo'

				<div class="container jadwal mb-4">	
					<nav aria-label="breadcrumb">			
					  <div class="card shadow bg-secondary p-2 mb-4 shadow font-weight-bold text-white">
					  		<h5>Jadwal Pertandingan </h5>
					  </div>
					</nav>
					<div class="row text-center">
							<div class="table-responsive">
								<table class="table table-borderless m-2">
									<tbody>
										
											<tr>
												<td>'.$this->getDirImage2('content/foto/club/',$this->selectLogo($liga['tim_tuan_rumah'])).'</td>
												<td colspan="3">'.$bln_main[0], ' '.$this->bulan($bln_main[1]).' '.$bln_main[2].' - '.$liga['tempat'].' - '.$liga['jam'].' - '.$this->namaLiga($liga['id_liga']).'</td>
												<td>'.$this->getDirImage2('content/foto/club/',$this->selectLogo($liga['tim_tamu'])).'</td>
											</tr>
											<tr>
												
												<td><h5>'.$this->namaClub($liga['tim_tuan_rumah']).'</h5></td>

												<td><h3>'.$liga['skor_tuan_rumah'].'</h3></td>
												<td><h3>Vs</h3> </td>
												<td><h3>'.$liga['skor_tim_tamu'].'</h3></td>
												<td><h3>'.$this->namaClub($liga['tim_tamu']).'</h3></td>
											</tr>
											

									</tbody>
								</table>
							</div>
						<div class="col">
			               <a href="jadwal" class="btn btn-secondary btn-md mt-2"> Semua Jadwal</a>
			            </div>
					</div>
				</div>

			';
			$data->free_result();
		endif;
	}
	public function jadwal()
	{
		$data = $this->semuaJadwal_limit();
		if($data->num_rows>0):
			
			
				echo'

				<div class="container jadwal mb-4" style="margin-top:50px;">	
					<nav aria-label="breadcrumb">			
					  <div class="card shadow bg-secondary p-2 mb-4 shadow font-weight-bold text-white">
					  		<div class="pull-left">
					  			<img src="content/web/logo.png" class="img-fluid" width="30px;"> 
					  				Jadwal Pertandingan 
					  		</div>
					  		
					  </div>
					</nav>
					<div class="row text-center">
							<div class="table-responsive">
								<table class="table table-borderless m-2">
									<tbody>
				';
									while($liga = $data->fetch_array()):
										$bln_main=$this->tanggalMain($liga['tanggal']);
										echo'
											<tr>
												<td>'.$this->getDirImage2('content/foto/club/',$this->selectLogo($liga['tim_tuan_rumah'])).'</td>
												<td colspan="3">'.$bln_main[0], ' '.$this->bulan($bln_main[1]).' '.$bln_main[2].' - '.$liga['tempat'].' - '.$liga['jam'].' - '.$this->namaLiga($liga['id_liga']).'</td>
												<td>'.$this->getDirImage2('content/foto/club/',$this->selectLogo($liga['tim_tamu'])).'</td>
											</tr>
											<tr>
												
												<td><h3>'.$this->namaClub($liga['tim_tuan_rumah']).'</h3></td>

												<td><h3>'.$liga['skor_tuan_rumah'].'</h3></td>
												<td><h3>VS</h3> </td>
												<td><h3>'.$liga['skor_tim_tamu'].'</h3></td>
												<td><h3>'.$this->namaClub($liga['tim_tamu']).'</h3></td>
											</tr>
											';
											
									endwhile;
									echo'		
									</tbody>
								</table>
							</div>
						
					</div>
				</div>

			';
			
		endif;
	}
	public function paggingJadwal()
	{
		$jadwal=$this->semuaJadwal();
        $total_jadwal = $jadwal->num_rows;  
        # Total data dibagi total keinginan pembagian perhalaman            
        $pages = ceil($total_jadwal/$this->halaman);
        $i=1;  
                          
             
        if (!isset($_GET['halaman'])) { $_GET['halaman']='1'; }
        if($pages>0):
            if($i<$_GET['halaman']){
               echo'
               <ul class="pagination justify-content-center">	              
	                 <li class="page-item"><a class="page-link"  href="javascript:history.back()">Previous</a>
	                 </li>
	              </li>';
             }else{
          
              echo'
               <ul class="pagination justify-content-center mt-4">
                 <li class="page-item">
                  
                </li>';
             }
             	for ($i=1; $i<=$pages ; $i++){ 
	               //Bagian nomor halaman ketika belum/sudah terjadi request get
	                echo'
	               	 	<li class="page-item">          
	                  		<a class="page-link" href="?page=jadwal&halaman='.$i.'">'.$i.'</a>
	                  	</li>'; 
                }
     
                if($_GET['halaman']==$pages){

             
                    echo'
                    <li class="page-item">
                      
                    </li>
                  </ul>';
                 }else{
               
                 	if($this->get('halaman')>$pages):

                 		die($this->reload_time('1','semua_jadwal'));
	                  
	               else:

	               		$number=$this->get('halaman');
	               		if(!is_numeric($number)) die($this->reload_time('1','semua_jadwal'));

		               	echo'
		                  <li class="page-item">
		                   
		                     <li class="page-item"><a class="page-link"  href="?page=jadwal&halaman='.($number+1).'">Next</a></li>
		                   
		                 	
		                </ul>';
	               endif;
            }
        endif;
	}
	public function club()
	{
		echo '
			<div class="container mt-4 mb-4">
					<nav aria-label="breadcrumb">			
					  <div class="card shadow bg-secondary p-2 mb-4 shadow font-weight-bold text-white">
					  		<div class="pull-left">
					  			<img src="content/web/logo.png" class="img-fluid" width="30px;"> 
					  				Daftar Club 
					  		</div>
					  		
					  </div>
					</nav>
				<div class="row shadow m-auto">
				';
					$main_club=$this->semuaTim();	
	               		if($main_club->num_rows>0){
	                  		while($row=$main_club->fetch_array()):
	                  			echo'
	                  			<div class="col-md-4">
		                  			<div class="thumbnail text-center mb-2 mt-2">              
						      			<img src="content/foto/club/'.$row['logo_club'].'" height="100px" alt="club">
	             						<div class="caption">
	             							<h4>'.$row['nama_club'].'</h4>
	             							<a href="?page=data&id_club='.$row['id_club'].'" class="btn btn-secondary btn-sm" role="button">Detail</a>
	             						</div>
						            </div>
						        </div>
					           ';
	                  		endwhile;
	                  		$main_club->free_result();
	                  	}else{

	                  		echo '<h1>Belum ada club</h1>';
	                  		$this->reload_time('1','home');
	                  	}
	        	echo'
	               
	            </div>
	   		</div>
	        ';     		
	}
	public function clubData()
	{
		if(!$this->detailClub($this->get('id_club'))) die($this->alert('danger','Error : id club not found'));
		echo
		'
			<div class="container mt-4 mb-4">
				<div class="row">
					<div class="col-md-3 mb-2">
						<div class="card shadow">
										<div class="card-header py-3">
							                <h6 class="m-0 font-weight-bold text-secondary">'.$this->nama_club.'</h6>
							            </div>
							<div class="card-body text-center">
							        	'.$this->getDirImage2('content/foto/club/',$this->logo_club).'
							        	<p>'.$this->alamat_club.'</p>
							        	<p>'.$this->kontak_club.'</p>
							</div>
						</div>
					</div>
					<div class="col-md-8">
						<div class="card shadow">
								<div class="card-header py-3">
							        <h6 class="m-0 font-weight-bold text-secondary">Pemain '.$this->nama_club.'</h6>
							    </div>
								<div class="card-body">
								    <div class="row">
									';
										$main_club=$this->paraPemain($this->id_club);	
								             if($main_club->num_rows>0){
								                  while($row=$main_club->fetch_array()):
								                  		echo'
								                  			<div class="col-md-4">
									                  			<div class="thumbnail text-center mb-2 mt-2">              
													      			<img src="content/foto/pemain/'.$this->paraPemain_foto($row['id_user']).'" height="100px" alt="club">
								             						<div class="caption">
								             							<h5 class="text-secondary pt-2">'.$row['nama_pemain'].'</h5>
								             							<a href="#" data-target="#confirm-detail" id_user='.$row['id_user'].' class="lihat_data btn btn-secondary btn-sm" role="button">Detail</a>
								             						</div>
													            </div>
													        </div>';
													       
								                  	endwhile;
								                  	$main_club->free_result();
								                  	}else{

								                  		echo '<h1>Belum ada pemain yang ditambahkan</h1>';
								                  		
								                  	}
								       echo'
								               
								    </div>
							</div>
						</div>
					</div>			
					
				</div>
			</div>



		';
		$this->modalDetail();
	}
	public function profile()
	{
		
	}
	public function readPages()
	{
	
		
		if(!$this->detailPages($this->get('id_pages')))die($this->alert('danger','Error : Id halaman tidak ditemukan'));
		
		
		echo'
		<style>
			span {color:#000;}
		</style>
		<div class="container mt-4 mb-4">
			<div class="row">
				<div class="card shadow">							

			        <h3 class="p-4">'.$this->judul_pages.'</h3>
			        <div class="row m-2 p-4">
			        	'.htmlspecialchars_decode($this->isi_pages).'
			        </div>
			       
			    </div>    
		    </div>
		</div>
		';
	}
	public function login()
	{
		
		$nik_err = $pass_err = $oklogin ="";

		if($_SERVER['REQUEST_METHOD']=='POST'):

	        if(empty($this->post('nik'))){
	            $nik_err="Masukan nik Anda";
	        
	        }else{

	            $nik=$this->post('nik');
	            $nik=$this->esc($nik);
	        }

	        if(empty($this->post('password'))){
	            $password_err="Masukan sebuah password";
	        
	        }else{
	            $password=$this->post('password');
	            
	        }

	        if(empty($nik_err) && empty($password_err)){
	            if($this->loginAuth($nik, $password)):
	                
	                $_SESSION['id_user']=$this->id_user;              
	                $_SESSION['role']=$this->role; 
	                $_SESSION['nama_user']=$this->nama_user; 

	                $oklogin ='
	                <div class="alert alert-dismissible alert-success">
			            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			            Login terverifikasi
			        </div>';

	                if($_SESSION['role']=='administrator'){
	                  $this->reload_time('2','user/admin');                  
	                  }elseif($_SESSION['role']=='petugas'){ 
	                    $this->reload_time('2','user/petugas');  
	                  }elseif($_SESSION['role']=='adminclub'){ 
	                    $this->reload_time('2','user/adminclub');                    
	                  }else{
	                      if($_SESSION['role']=='pemain'):
	                         $this->reload_time('2','home');  
	                      endif;
	                  }     
	            else:
	               $oklogin ='
	                <div class="alert alert-dismissible alert-danger">
			            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
			            NIK, password salah atau Akun Anda belum aktif
			        </div>';

	            endif;
	        }
	    endif;

        
    
		echo'
		
		<div class="container" style="margin-top:80px;">
		    <div class="card bg-login">    
	            <div class="wrapper col-md-8 mx-auto mb-4 mt-4 bg-default">
		            <div class="col text-center mt-4">  
		            	<h4>LOGIN</h4>
		            </div>
	            	<hr/>
	            <form action="" method="post" class="mt-4">
	                <div class="input-group mb-4">
	                  <div class="input-group-prepend">
	                      <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
	                    </div>
	                    <input type="text" class="form-control" style="height:50px" name="nik" placeholder="NIK user" maxlength="16" minlength="16" required="" aria-label="Nik" aria-describedby="basic-addon1">             
	                </div>
	                <div class="input-group mb-4">
	                  <div class="input-group-prepend">
	                      <span class="input-group-text" id="basic-addon1"><i class="fa fa-lock"></i></span>
	                    </div>
	                    <input type="password" class="form-control" style="height:50px" name="password" placeholder="Password" required="" aria-label="Password" aria-describedby="basic-addon1">               
	                </div>

	                <div class="col text-center">         
		           	 	<button type="submit" class="btn btn-secondary btn-md btn-block" style="height:60px" name="login">LOGIN</button>
		            </div>
		            <div class="col text-center mt-4"> 
		            	<span>'.$oklogin.'</span>
		            </div>
		        </form>
	        </div>
	             
	    </div>
	    </div>
	    <div style="margin-bottom:100px">
                    <br/>
                    <br/>
            </div>  
		';
	}

}