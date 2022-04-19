<?php
class publicTheme extends settings
{
  public function head(){

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
        <link rel="icon" href="content/web/'.$this->infosite['favicon'].'">
        <title>'.$this->infosite['nama_situs'].'</title>


    ';
  }
  public function css(){
  	echo '    
  	 
      <link href="assets/templates/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
      <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">   
     <link href="assets/templates/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> 
     <!--<link href="assets/templates/vendor/datepicker/css/bootstrap-datepicker.css" rel="stylesheet"> --> 
     <link href="assets/templates/css/costum.css" rel="stylesheet">
     <!-- Please Dont Remove :(     
      
        |----------------------------------------|
        | Author                                 |
        | name        : Benny maulana                  | 
        | mail        : innupasha2@gmail.com      |
        | blog        : xdmultimedia.id             |  
        |----------------------------------------| 
     
      -->  
      </head>
     
     	
    ';
  }
  public function body(){
  	echo'
  	<body class="d-flex flex-column min-vh-100">

      <!-- Navigation -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
          <a class="logo navbar-btn pull-left" href="home" title="Home">
            '.$this->getDirImage2('content/web/',$this->infosite['logo']).' </a>
          <a class="navbar-brand" href="home">'.$this->infosite['nama_situs'].'</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item active">
                <a class="nav-link" href="home">Home
                  <span class="sr-only">(current)</span>
                </a>
              </li>
              ';
                  $menu = $this->showMenu();               
                  if($menu->num_rows>0){
                    while($rm=$menu->fetch_array()):
                      if($rm['kategori_menu']=='single_menu'):
                        echo
                        '
                        <li class="nav-item">
                          <a class="nav-link" href="'.$rm['link_menu'].'">'.$rm['nama_menu'].'</a>
                        </li>
                        ';
                      elseif($rm['kategori_menu']=='dropdown_menu'):
                        echo'
                            <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-hashpopup="true" aria-expanded="false">
                                '.$rm['nama_menu'].'
                              </a>
                              <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            ';
                          $sub_menu=$this->showMenu_bysubMenu($rm['id_menu']);
                          while($rm2=$sub_menu->fetch_array()):
                            echo'
                                <a class="dropdown-item" href="'.$rm2['link_menu'].'">'.$rm2['nama_menu'].'</a>
                              
                              


                            ';
                          endwhile; 
                          $sub_menu->free_result();
                          echo'</div></li>';                      
                      endif;
                     
                    endwhile;
                    $menu->free_result();
                  }
              echo'
           
             
            </ul>
          </div>
        </div>
      </nav>
  	
    
  	';
  }
  /*
  public function menuAfter_login(){
    echo'
    <body>

      <!-- Navigation -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
          <a class="logo navbar-btn pull-left" href="home" title="Home">
           '.$this->getDirImage2('content/web/',$this->infosite['logo']).' </a>
          <a class="navbar-brand" href="home">'.$this->infosite['nama_situs'].'</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item active">
                <a class="nav-link" href="home"><i class="fas fa-home"></i> Home
                  <span class="sr-only">(current)</span>
                </a>
              </li>
              
              <li class="nav-item">
                <a alt="Keranjang belanja" title="Keranjang Belanja" class="nav-link" href="keranjang"><i class="fas fa-shopping-cart"></i> Keranjang</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="profile"><i class="fas fa-user"></i> Profile</a>
              </li>
              <li class="nav-item">
                <a href="logout.php" class="nav-link"><i class="fas fa-sign-out-alt"></i> Keluar</a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
   

    ';
  }
  */
  public function footer(){
    echo '    
      <footer class="py-5 bg-dark">
        <div class="container">
          <p class="m-0 text-center text-white">Copyright &copy; '.$this->infosite['nama_situs'].' '.date('Y').'</p>
        </div>
      </footer>
      <script src="assets/templates/vendor/jquery/jquery.min.js"></script>
      <script src="assets/templates/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
       <script src="modal.js"></script>
     </body>
     </html>
    ';
  }
}

?>