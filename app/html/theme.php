<?php

class themeProperty extends settings
{
	

	public function head()
	{
		$this->sessionData($this->filter($_SESSION['id_user']));
		$this->loadInfo();
		
		echo'
			<!DOCTYPE html>
			<html lang="en">
			<head>
			  <meta charset="utf-8">
			  <meta http-equiv="X-UA-Compatible" content="IE=edge">
			  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
			  <meta name="description" content="'.$this->infosite['deskripsi_situs'].'">
			  <meta name="author" content="'.$this->infosite['nama_pengelola'].'">
			  <link rel="icon" href="../../content/web/'.$this->infosite['favicon'].'">
			  <title>'.$this->infosite['nama_aplikasi'].' - '.$this->infosite['nama_situs'].'</title>


		';
	}
	public function css()
	{
		echo'
		
		<link href="../../assets/templates/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
		<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
	 	<link href="../../assets/templates/css/sb-admin-2.min.css" rel="stylesheet">
	 	<link href="../../assets/templates/vendor/datepicker/css/bootstrap-datepicker.css" rel="stylesheet">
 		<link href="../../assets/templates/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
			</head>
		<body id="page-top">
		<div id="wrapper">
		';
	}
	public function sidebar()
	{
		echo '
			 <!-- Sidebar -->
		    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

		      <!-- Sidebar - Brand -->
		      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="?page=home">
		        <div class="sidebar-brand-icon">
		          '.$this->getDirImage2('../../content/web/',$this->infosite['logo']).'
		        </div>
		        <div class="sidebar-brand-text mx-3">'.$this->infosite['nama_aplikasi'].'</div>
		      </a>

		      <!-- Divider -->
		      <hr class="sidebar-divider my-0">

		      <!-- Nav Item - Dashboard -->
		      <li class="nav-item active">
		        <a class="nav-link" href="?page=home">
		          <i class="fas fa-fw fa-tachometer-alt"></i>
		          <span>Dashboard</span></a>
		      </li>
		      <li class="nav-item">
			        <a class="nav-link" href="?page=pemain">
			          <i class="fas fa-fw fa-table"></i>
			          <span>Pemain</span></a>
			  </li>
			  <li class="nav-item">
			        <a class="nav-link" href="?page=club">
			          <i class="fas fa-fw fa-table"></i>
			          <span>Club</span></a>
			  </li>
			  <li class="nav-item">
		        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
		          <i class="fa fa-trophy"></i>
		          <span>Liga</span>
		        </a>
		        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
		          <div class="bg-white py-2 collapse-inner rounded">
		            <h6 class="collapse-header">Pengaturan Liga:</h6>
		            <a class="collapse-item" href="?page=liga">Liga</a>
		            <a class="collapse-item" href="?page=buat liga">Buat Liga</a>		            
		            <a class="collapse-item" href="?page=jadwal tanding">Jadwal Pertandingan</a>    	          
		        
		             <h6 class="collapse-header">Klasemen:</h6>
		            <a class="collapse-item" href="?page=input skor">Klasemen GA</a>
		            <a class="collapse-item" href="?page=input skor">Klasemen Akhir</a>
		          </div>
		        </div>
		      </li>
		      <!-- Divider -->
		      <hr class="sidebar-divider">

		      <!-- Heading -->
		      <div class="sidebar-heading">
		        POSTING
		      </div>	 
		
		      <li class="nav-item">
		        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
		          <i class="fas fa-fw fa-book"></i>
		          <span>Berita</span>
		        </a>
		        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
		          <div class="bg-white py-2 collapse-inner rounded">
		            <h6 class="collapse-header">Menu:</h6>
		            <a class="collapse-item" href="?page=berita">Berita</a>
		            <a class="collapse-item" href="?page=buat berita">Buat Berita</a>
		            <a class="collapse-item" href="?page=kategori">Kategori</a>
		       
		          </div>
		        </div>
		      </li>
		       <li class="nav-item">
			        <a class="nav-link" href="?page=halaman">
			          <i class="fas fa-fw fa-paper-plane"></i>
			          <span>Halaman</span></a>
			  </li>

		      <!-- Divider -->
		      <hr class="sidebar-divider">

		      <!-- Heading -->
		      <div class="sidebar-heading">
		        PENGGUNA
		      </div>     

		      <!-- Nav Item - Pages Collapse Menu -->
		      <li class="nav-item">
		        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
		          <i class="fas fa-fw fa-user"></i>
		          <span>Pengguna</span>
		        </a>
		        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
		          <div class="bg-white py-2 collapse-inner rounded">
		            <h6 class="collapse-header">Buat Akun:</h6>
		            <a class="collapse-item" href="?page=administrator">Administrator</a>
		            <a class="collapse-item" href="?page=petugas">Petugas</a>
		           	<a class="collapse-item" href="?page=admin club">Admin Club</a>
		           	<a class="collapse-item" href="?page=pemain">Pemain</a>
		           
		          </div>
		        </div>
		      </li>
			      
		     

		      <!-- Divider -->
		      <hr class="sidebar-divider d-none d-md-block">
		      <div class="sidebar-heading">
		        PENGATURAN 
		      </div>    
		       <li class="nav-item">
			        <a class="nav-link" href="?page=pengaturan">
			          <i class="fas fa-fw fa-wrench"></i>
			          <span>Situs</span>
			        </a>
			        <a class="nav-link" href="?page=pengaturan menu">
			          <i class="fas fa-fw fa-book"></i>
			          <span>Menu</span>
			        </a>
			  </li>
		      <!-- Sidebar Toggler (Sidebar) -->
		      <div class="text-center d-none d-md-inline">
		        <button class="rounded-circle border-0" id="sidebarToggle"></button>
		      </div>

		    </ul>
    		<!-- End of Sidebar -->

    		<!-- Content Wrapper -->
    		<div id="content-wrapper" class="d-flex flex-column">
		    <!-- Main Content -->
		    <div id="content">



		';
	}
	public function topBar()
	{

		echo
		'
		<!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
       
         
         

     		<!--
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>
          -->
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>

             

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">'.$this->datasession['nama_user'].'</span>
               '.$this->getDirImage_round2('../../content/foto/'.$this->datasession['role'].'/',$this->datasession['foto_user']).'
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="?page=profile">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
              
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->
        <div class="container-fluid">

		';
	}
	public function menuPetugas()
	{
		echo '
			 <!-- Sidebar -->
		    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

		      <!-- Sidebar - Brand -->
		      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="?page=home">
		        <div class="sidebar-brand-icon">
		          '.$this->getDirImage2('../../content/web/',$this->infosite['logo']).'
		        </div>
		        <div class="sidebar-brand-text mx-3">'.$this->infosite['nama_aplikasi'].'</div>
		      </a>

		      <!-- Divider -->
		      <hr class="sidebar-divider my-0">

		      <!-- Nav Item - Dashboard -->
		      <li class="nav-item active">
		        <a class="nav-link" href="?page=home">
		          <i class="fas fa-fw fa-tachometer-alt"></i>
		          <span>Dashboard</span></a>
		      </li>		     
			  <li class="nav-item">
		        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
		          <i class="fa fa-trophy"></i>
		          <span>Liga</span>
		        </a>
		        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
		          <div class="bg-white py-2 collapse-inner rounded">
		            <h6 class="collapse-header">Pengaturan Liga:</h6>
		            <a class="collapse-item" href="?page=liga">Liga</a>
		            <a class="collapse-item" href="?page=buat liga">Buat Liga</a>		            
		            <a class="collapse-item" href="?page=jadwal tanding">Jadwal Pertandingan</a>    	          
		        
		             <h6 class="collapse-header">Klasemen:</h6>
		            <a class="collapse-item" href="?page=input skor">Klasemen GA</a>
		            <a class="collapse-item" href="?page=input skor">Klasemen Akhir</a>
		          </div>
		        </div>
		      </li>
		      <!-- Divider -->
		      <hr class="sidebar-divider">

		      <!-- Heading -->
		      <div class="sidebar-heading">
		        BERITA
		      </div>	 
		
		      <li class="nav-item">
		        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
		          <i class="fas fa-fw fa-book"></i>
		          <span>Berita</span>
		        </a>
		        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
		          <div class="bg-white py-2 collapse-inner rounded">
		            <h6 class="collapse-header">Menu:</h6>
		            <a class="collapse-item" href="?page=berita">Berita</a>
		            <a class="collapse-item" href="?page=buat berita">Buat Berita</a>
		            <a class="collapse-item" href="?page=kategori">Kategori</a>
		       
		          </div>
		        </div>
		      </li>

		      <!-- Divider -->
		      <hr class="sidebar-divider">     	     

		      <!-- Sidebar Toggler (Sidebar) -->
		      <div class="text-center d-none d-md-inline">
		        <button class="rounded-circle border-0" id="sidebarToggle"></button>
		      </div>

		    </ul>
    		<!-- End of Sidebar -->

    		<!-- Content Wrapper -->
    		<div id="content-wrapper" class="d-flex flex-column">
		    <!-- Main Content -->
		    <div id="content">



		';
	}
	public function menuAdminclub()
	{
		echo '
			 <!-- Sidebar -->
		    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

		      <!-- Sidebar - Brand -->
		      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="?page=home">
		        <div class="sidebar-brand-icon">
		          '.$this->getDirImage2('../../content/web/',$this->infosite['logo']).'
		        </div>
		        <div class="sidebar-brand-text mx-3">'.$this->infosite['nama_aplikasi'].'</div>
		      </a>

		      <!-- Divider -->
		      <hr class="sidebar-divider my-0">

		      <!-- Nav Item - Dashboard -->
		      <li class="nav-item active">
		        <a class="nav-link" href="?page=home">
		          <i class="fas fa-fw fa-tachometer-alt"></i>
		          <span>Dashboard</span></a>
		      </li>		     
			  <li class="nav-item">
			        <a class="nav-link" href="?page=club saya">
			          <i class="fas fa-fw fa-globe"></i>
			          <span>Club Saya</span></a>
			  </li>
		      <li class="nav-item">
		        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
		          <i class="fas fa-fw fa-users"></i>
		          <span>Pemain</span>
		        </a>
		        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
		          <div class="bg-white py-2 collapse-inner rounded">
		            <h6 class="collapse-header">Menu:</h6>
		            <a class="collapse-item" href="?page=pemain">Daftar Pemain</a>
		            <a class="collapse-item" href="?page=tambah pemain">Tambah Pemain</a>
		          
		       
		          </div>
		        </div>
		      </li>
			  <li class="nav-item">
			        <a class="nav-link" href="?page=jadwal tanding">
			          <i class="fas fa-fw fa-calendar"></i>
			          <span>Jadwal Pertandingan</span></a>
			  </li>

			    

		      <!-- Sidebar Toggler (Sidebar) -->
		      <div class="text-center d-none d-md-inline">
		        <button class="rounded-circle border-0" id="sidebarToggle"></button>
		      </div>

		    </ul>
    		<!-- End of Sidebar -->

    		<!-- Content Wrapper -->
    		<div id="content-wrapper" class="d-flex flex-column">
		    <!-- Main Content -->
		    <div id="content">



		';	
	}
	public function menuPemain()
	{
		echo '
			 <!-- Sidebar -->
		    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

		      <!-- Sidebar - Brand -->
		      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="?page=home">
		        <div class="sidebar-brand-icon">
		          '.$this->getDirImage2('../../content/web/',$this->infosite['logo']).'
		        </div>
		        <div class="sidebar-brand-text mx-3">'.$this->infosite['nama_aplikasi'].'</div>
		      </a>

		      <!-- Divider -->
		      <hr class="sidebar-divider my-0">

		      <!-- Nav Item - Dashboard -->
		      <li class="nav-item active">
		        <a class="nav-link" href="?page=home">
		          <i class="fas fa-fw fa-tachometer-alt"></i>
		          <span>Dashboard</span></a>
		      </li>		     
			  <li class="nav-item">
			        <a class="nav-link" href="?page=daftar pemain">
			          <i class="fas fa-fw fa-users"></i>
			          <span>Daftar Pemain</span></a>
			  </li>
			  <li class="nav-item">
			        <a class="nav-link" href="?page=jadwal tanding">
			          <i class="fas fa-fw fa-calendar"></i>
			          <span>Jadwal Pertandingan</span></a>
			  </li>

			    

		      <!-- Sidebar Toggler (Sidebar) -->
		      <div class="text-center d-none d-md-inline">
		        <button class="rounded-circle border-0" id="sidebarToggle"></button>
		      </div>

		    </ul>
    		<!-- End of Sidebar -->

    		<!-- Content Wrapper -->
    		<div id="content-wrapper" class="d-flex flex-column">
		    <!-- Main Content -->
		    <div id="content">



		';	
	}
	public function footer()
	{
		$this->logoutModal();
		echo'
    	</div>
		</div>
	    <!-- End of Main Content -->

	    <!-- Footer -->
	      <footer class="sticky-footer bg-white">
	        <div class="container my-auto">
	          <div class="copyright text-center my-auto">
	            <span>Copyright &copy; '.$this->infosite['nama_aplikasi'].' - '.$this->infosite['nama_situs'].'2020 - proudly powered by <a href="https://roo93.co.id" target="_blank" rel="dofollow">root93</a></span>
	          </div>
	        </div>
	      </footer>
	    <!-- End of Footer -->

	    </div>
	    <!-- End of Content Wrapper -->
		</div>
  		<!-- End of Page Wrapper -->

  		<!-- Scroll to Top Button-->
		<a class="scroll-to-top rounded" href="#page-top">
		    <i class="fas fa-angle-up"></i>
		</a>
		<!-- Bootstrap core JavaScript-->
		  <script src="../../assets/templates/vendor/jquery/jquery.min.js"></script>
		  <script src="../../assets/templates/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

		  <!-- Core plugin JavaScript-->
		  <script src="../../assets/templates/vendor/jquery-easing/jquery.easing.min.js"></script>

		  <!-- Custom scripts for all pages-->
		  <script src="../../assets/templates/js/sb-admin-2.min.js"></script>

		  <!-- Page level plugins -->
		  <script src="../../assets/templates/vendor/datatables/jquery.dataTables.min.js"></script>
		  <script src="../../assets/templates/vendor/datatables/dataTables.bootstrap4.min.js"></script>
		  <script src="../../assets/templates/vendor/chart.js/Chart.min.js"></script>
		  <script type="text/javascript" src="../../assets/ckeditor/ckeditor.js"></script>
		  <script src="../../assets/templates/vendor/datepicker/js/bootstrap-datepicker.js"></script>
		  <script src="../../assets/templates/vendor/datepicker/js/datepicker-format.js"></script>
		  <script src="../../assets/templates/js/demo/datatables-demo.js"></script>
		  <!-- Page level custom scripts
		  <script src="../../assets/templates/js/demo/chart-area-demo.js"></script>
		  <script src="../../assets/templates/js/demo/chart-pie-demo.js"></script>		
		  
		   -->

		</body>

		</html>


		';
	}	
}