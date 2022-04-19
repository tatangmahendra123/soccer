<?php
class dataInput extends Database
{
	public function filter($data)
	{
		$data = htmlspecialchars($data);
		$data = trim($data);
		$data = stripcslashes($data);
		return $data;
	}
	public function post($data)
	{
		$data = $_POST[$data];
		$data = $this->filter($data);
		return $data;
	}	
	public function esc($data)
	{
		$data = $this->koneksi->real_escape_string($data);
		return $data;
	}
	public function getPage($data)
	{
		if($this->get('page')==$data):
			return true;
		else:
			return false;
		endif;
	}
	public function getEmpty()
	{
			//if(!isset($this->get('page'))){$this->get('page')='';}
			if(!isset($_GET['page'])){$_GET['page']='';}
	}
	public function get($data)
	{
		$data = $_GET[$data];
		$data = $this->filter($data);
		return $data;
	}
	public function getImage($data, $path)
	{
		$this->file_name=$_FILES[$data]['name'];
		$this->file_dir=$_FILES[$data]['tmp_name'];
		$this->file_size=$_FILES[$data]['size'];			
		$this->file_extension=strtolower(pathinfo($this->file_name, PATHINFO_EXTENSION));
		$this->file_valid=array('jpg','jpeg','png');
		$this->file_destinasi='content/foto/'.$path.'/';
		$this->file_foto=rand(100,1000000).".".$this->file_extension;
	}
	public function getImage2($data, $path, $name)
	{
		$this->file_name=$_FILES[$data]['name'];
		$this->file_dir=$_FILES[$data]['tmp_name'];
		$this->file_size=$_FILES[$data]['size'];			
		$this->file_extension=strtolower(pathinfo($this->file_name, PATHINFO_EXTENSION));
		$this->file_valid=array('jpg','jpeg','png');
		$this->file_destinasi=''.$path.'';
		$this->file_foto=$name.rand(100,1000000).".".$this->file_extension;
	}
	public function getImage3($data, $path, $name)
	{
		$this->file_name=$_FILES[$data]['name'];
		$this->file_dir=$_FILES[$data]['tmp_name'];
		$this->file_size=$_FILES[$data]['size'];			
		$this->file_extension=strtolower(pathinfo($this->file_name, PATHINFO_EXTENSION));
		$this->file_valid=array('jpg','jpeg','png');
		$this->file_destinasi=''.$path.'';
		$this->file_logo=$name.".".$this->file_extension;
	}
	public function getDirImage($path,$data)
	{
		return '
		<img class="img-fluid" height="80px" width="50px" src="content/foto/'.$path.'/'.$data.'" alt="image" />
		';
	}
	public function getDirImage2($path,$data)
	{
		return '
		<img class="img-fluid" height="80px" width="50px" src="'.$path.''.$data.'" alt="image" />
		';
	}
	public function getDirImage_round($path,$data)
	{
		return '
		<img class="img-profile rounded-circle" height="80px" width="80px" src="content/foto/'.$path.'/'.$data.'" alt="image" />
		';
	}
	public function getDirImage_round2($path,$data)
	{
		return '
		<img class="img-profile rounded-circle" height="80px" width="80px" src="'.$path.''.$data.'" alt="image" />
		';
	}
	public function getDirImage_artikel($path, $data)
	{
		return '
		<img class="img-fluid" width="768px" src="'.$path.''.$data.'" alt="image" />
		';
	}
	public function imageBreadcrumb($path,$data)
	{
		return '
		<img class="img-fluid" height="60px" width="30px" src="'.$path.''.$data.'" alt="image" />
		';
	}
	public function getImage_unlink($path, $data)
	{
		$perintah=unlink($path.$data);
		
		if($perintah):
			return true;
		else:
			return false;
		endif;
	
	}
	public function hari($data)
	{	

		switch($data){
			
			case'Monday':$data="Senin";
			return $data;
			case'Tuesday':$data="Selasa";
			return $data;
			case'Wednesday':$data="Rabu";
			return $data;
			case'Thursday':$data="Kamis";
			return $data;
			case'Friday':$data="Jumat";
			return $data;
			case'Saturday':$data="Sabtu";
			return $data;
			case'Sunday':$data="Minggu";
			return $data;
		}
	}
	public function bulan($data)
	{
		switch($data){
			case'1':$data="Januari";return $data;
			case'2':$data="Februari";return $data;
			case'3':$data="Maret";return $data;
			case'4':$data="April";return $data;
			case'5':$data="Mei";return $data;
			case'6':$data="Juni";return $data;
			case'7':$data="Juli";return $data;
			case'8':$data="Agustus";return $data;
			case'9':$data="September";return $data;
			case'10':$data="Oktober";return $data;
			case'11':$data="Nopember";return $data;
			case'12':$data="Desember";return $data;
		}
	}
	public function tanggalIndo()
	{
		$tanggal=$this->hari(date('l')).', ';
		$tanggal.=date('d').' ';
		$tanggal.=$this->bulan(date('m')).' ';
		$tanggal.=date('Y');
		return $tanggal;
	}
	public function tanggalMain($data)
	{
		$ht = explode("-", $data);
		return $ht;

	}
	public function validateUsername($data){
		if(!preg_match("/^[a-zA-Z-0-9]*$/",$data)){
			return true;
		}else{
			return false;
		}
	}
	public function validateUrl($data){
	  if(!preg_match("#^http://[_a-z0-9-]+\\.[_a-z0-9-]+#i",$data)){
	    return true;
	  }else{
	    return false;
	  }
	}
	public function validateName($data){
		if(preg_match("/^[a-zA-Z ]*$/",$data)){
			return true;
		}else{
			return false;
		}
	}
	public function validateNumber($data){
		if(!preg_match("/^[0-9]*$/",$data)){
			return true;
		}else{
			return false;
		}
	}
	public function CekTLS_tanggal($data)
	{
		if(!preg_match("/^[0-9-\-]*$/",$data)){
			return true;
		}else{
			return false;
		}
	}
	public function BCA_tanggal($data)
	{
		$ar=explode("-", $data);
		//Anda bisa merubah posisi array sesuai format yang diinginkan
		//default Tgl-Bln-Thn 1 0 2
		//Format US Thn-Bln-Tgl 1 2 0
		if(checkdate($ar[1], $ar[0], $ar[2])){			
			return true;
		}else{
			return false;
		}	
	}
	public function reload($data){
		echo "
			<meta http-equiv=\"refresh\"content=\"3;URL=?page=$data\"/>
		";
	}
	public function reload_time($time, $url)
	{
		echo "
			<meta http-equiv=\"refresh\"content=\"$time;URL=?page=$url\"/>
		";
	}
	public function dtSaved()
	{
		echo'
			<div class="alert alert-dismissible alert-success">
           	 <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            	Data berhasil disimpan
        	</div>
		';
	}
	public function failSaved()
	{
		echo'
			<div class="alert alert-dismissible alert-danger">
           	 <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            	Data gagal disimpan
        	</div>
		';
	}
	public function dltSuccess($data)
	{

		echo'
			<div class="alert alert-dismissible alert-success">
	            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
	            '.$data.'
	        </div>
        ';
	}
	public function dltFail($data)
	{
		
	}
	public function emailCek($data)
	{
		if(!filter_var($this->post($data), FILTER_VALIDATE_EMAIL)):
			return true;
		else:
			return false;
		endif;
	}
	
	public function card ($data)
	{
		echo 
	    '
	    <!-- Dont Forget to add two end div, if this function call -->
	        <div class="card shadow mb-4">
	            <div class="card-header py-3">
	                <h6 class="m-0 font-weight-bold text-primary">'.$data.'</h6>
	            </div>
	        <div class="card-body">
	    ';
	}
	public function card_dropdown($title, $body, $link_header, $link, $link_name)
	{
		echo'

		 <!-- Dropdown Card Example -->
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">'.$title.'</h6>
                  <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                      <div class="dropdown-header">'.$link_header.':</div>
                      <a class="dropdown-item" href="'.$link.'">'.$link_name.'</a>
                    
                    </div>
                  </div>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  '.$body.'
                </div>
              </div>

		';
	}
	public function alert($type, $data)
	{
		echo'
		<div class="alert alert-dismissible alert-'.$type.'">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            '.$data.'
        </div>
       ';
	}
	public function alertInfo ($data)
	{
		echo'
		<div class="alert alert-dismissible alert-info">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
            '.$data.'
        </div>
       ';
	}
	public function required($data)
	{
		return 
		'
			<span class="text-danger">'.$data.'</span>
		';
	}

	public function formFile()
	{
		echo
		'
			<form action="'.htmlspecialchars($_SERVER['REQUEST_URI']).'" method="post" enctype="multipart/form-data">
		';
	}
	public function formGeneral()
	{
		echo '
		<form action="'.htmlspecialchars($_SERVER['REQUEST_URI']).'" method="post">
		';
	}
	public function formGroup($icon, $type, $name, $placeholder, $error)
	{
		
		return '
			<div class="form-group">
		        <div class="input-group">
			        <div class="input-group-prepend">
			        	<div class="input-group-text"><i class="fas fa-fw fa-'.$icon.'"></i></div>
			        </div>
			        <input type="'.$type.'" class="form-control" name="'.$name.'" placeholder="'.$placeholder.'" required="">
			    </div>
			  	'.$this->required($error).'      		           
			            
		     </div>
	    ';
	}
	public function formGroup_noRequired($icon, $type, $name, $placeholder, $error)
	{
		
		return '
			<div class="form-group">
		        <div class="input-group">
			        <div class="input-group-prepend">
			        	<div class="input-group-text"><i class="fas fa-fw fa-'.$icon.'"></i></div>
			        </div>
			        <input type="'.$type.'" class="form-control" name="'.$name.'" placeholder="'.$placeholder.'">
			    </div>
			  	'.$this->required($error).'      		           
			            
		     </div>
	    ';
	}
	public function formGroup_datepicker($icon, $type, $name, $placeholder, $tgl, $error)
	{
		
		return '
			<div class="form-group">
		        <div class="input-group">
			        <div class="input-group-prepend">
			        	<div class="input-group-text"><i class="fas fa-fw fa-'.$icon.'"></i></div>
			        </div>
			        <input type="'.$type.'" class="form-control '.$tgl.'" name="'.$name.'" placeholder="'.$placeholder.'" required="">
			    </div>
			  	'.$this->required($error).'      		           
			            
		     </div>
	    ';
	}
	public function formGroup_Textarea($name, $placeholder, $error)
	{
		return
		'
		<div class="form-group">
			<label> Alamat : </label>
		       <textarea class="form-control" name="'.$name.'" rows="5" placeholder="'.$placeholder.'" required=""></textarea>
		        '.$this->required($error).'
	   	</div>

		';

	}
	public function formGroup_TextareaCkeditor($name, $placeholder, $error)
	{
		return
		'
		<div class="form-group">
			
		       <textarea class="form-control ckeditor" name="'.$name.'" rows="5" placeholder="'.$placeholder.'" required=""></textarea>
		        '.$this->required($error).'
	   	</div>

		';

	}
	public function formGroup_TextareaCkeditor_edit($name, $placeholder, $value, $error)
	{
		return
		'
		<div class="form-group">
			
		       <textarea class="form-control ckeditor" name="'.$name.'" rows="5" placeholder="'.$placeholder.'" required="">'.$value.'</textarea>
		        '.$this->required($error).'
	   	</div>

		';

	}
	public function formGroup_edit($icon, $type, $name, $placeholder, $value, $error)
	{
		return '
			<div class="form-group">
		        <div class="input-group">
			        <div class="input-group-prepend">
			        	<div class="input-group-text"><i class="fas fa-fw fa-'.$icon.'"></i></div>
			        </div>
			        <input type="'.$type.'" class="form-control" name="'.$name.'" value="'.$value.'" placeholder="'.$placeholder.'" required="">
			    </div>
			  	'.$this->required($error).'      		           
			            
		    </div>
	    ';
	}
	
	public function formGroup_Textarea_edit($name, $placeholder, $value, $error)
	{
		return
		'
		<div class="form-group">
			
		       <textarea class="form-control" name="'.$name.'" rows="5" placeholder="'.$placeholder.'" required="">'.$value.'</textarea>
		        '.$this->required($error).'
	   	</div>

		';

	}
	public function formGroup_datepicker_edit($icon, $type, $name, $placeholder, $tgl, $value, $error)
	{
		
		return '
			<div class="form-group">
		        <div class="input-group">
			        <div class="input-group-prepend">
			        	<div class="input-group-text"><i class="fas fa-fw fa-'.$icon.'"></i></div>
			        </div>
			        <input type="'.$type.'" class="form-control '.$tgl.'" name="'.$name.'" placeholder="'.$placeholder.'" value="'.$value.'" required="">
			    </div>
			  	'.$this->required($error).'      		           
			            
		     </div>
	    ';
	}
	public function formGroup_file($type, $name, $error)
	{
		return '
			<div class="form-group">		        
			        <input type="'.$type.'" class="form-control-file" name="'.$name.'">			   
			  	'.$this->required($error).'      		           
			            
		    </div>
	    ';
	}

	public function formGroup_button($type, $size, $icon, $value)
	{
		return 
		'
		<button type="submit" class="btn '.$type.' '.$size.'">
			<i class="fa fa-'.$icon.' fa-fw"></i> '.$value.'
       	</button>
       	';     
	}
	public function formGroup_button2($name, $size, $icon, $value)
	{
		return 
		'
		<button type="submit" class="btn btn-primary '.$size.'" name="'.$name.'">
			<i class="fa fa-'.$icon.' fa-fw"></i> '.$value.'
       	</button>
       	';     
	}
	public function logoutModal()
	{
		echo'
			<!-- Logout Modal-->
			  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			    <div class="modal-dialog" role="document">
			      <div class="modal-content">
			        <div class="modal-header">
			          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
			          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
			            <span aria-hidden="true">×</span>
			          </button>
			        </div>
			        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
			        <div class="modal-footer">
			          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
			          <a class="btn btn-primary" href="logout.php">Logout</a>
			        </div>
			      </div>
			    </div>
			  </div>
			';
	}
	public function modalDetail()
	{
		echo'    
	    <!-- Modal detail -->
	    <div class="modal fade" id="confirm-detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	      <div class="modal-dialog" role="document">
	        <div class="modal-content">
	          <div class="modal-header bg-secondary text-white">
	            <h5 class="modal-title" id="exampleModalLabel">Profil Pemain</h5>
	            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
	              <span aria-hidden="true">×</span>
	            </button>
	          </div>
	          <div class="modal-body" id="detail_pemain">
	          </div>
	          <div class="modal-footer">
	            <button class="btn btn-secondary" type="button" data-dismiss="modal">Tutup</button>
	                    
	          </div>      
	        </div>
	      </div>
	    </div>

		';
	}

}
?>
