<?php
require_once 'config/database.php';
require_once 'app/core/class.input.php';
require_once 'app/core/class.public.query.php';
require_once 'app/core/class.settings.php';
require_once 'app/core/class.web.php';
require_once 'app/html/main.web.php';

$web = new main_Web;

if(!$web->detailPemain($web->post('detail_pemain'))) die($web->alert('danger','Error : user not found :('));
  echo' 
      <div class="text-center text-capitalize mt-4">
        '.$web->getDirImage_round2('content/foto/pemain/',$web->foto_user).'
                         
          <p class="p-2" style="font-size:18px"><b>'.$web->nama_user.'</b>
          <br>
          '.$web->tempat_lahir.' , '.$web->tgl_lahir.'
          <br/>                    
          '.$web->posisi_pemain.' ('.$web->no_punggung.')
            <br/>'.$web->tinggi_badan.' CM / '.$web->berat_badan.' KG
          </p>     

      </div>
    ';
 
 
 ?>