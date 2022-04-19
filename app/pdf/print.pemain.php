<?php
session_start();
if(isset($_SESSION['role']))
{
  $array = array('administrator','adminclub','petugas','pemain');
  if(!in_array($_SESSION['role'], $array))header("location:../../login.php");

}

require_once '../../config/database.php';
require_once '../../app/core/class.input.php';
require_once '../../app/core/class.public.query.php';
require_once '../../app/core/class.settings.php';
require_once '../../app/core/class.admin.query.php';
require_once '../../app/html/main.form.admin.php';
require_once '../../plugins/mpdf/mpdf.php';
$obj = new main_Admin;

$obj->loadInfo();
if(!$obj->detailPemain($obj->get('id_user'))) die('Error : Id user not found !');
   
    if($_SESSION['role']!='administrator'): 

        $obj->sessionData($obj->filter($_SESSION['id_user']));

        if($obj->datasession['id_club']!=$obj->id_club){

          die("Data ini bukan milik Anda");  

        }else{

          if($_SESSION['role']=='pemain'):
            if($obj->datasession['id_user']!=$obj->id_user) die("Error : Data ini bukan milik Anda !");
          endif;  
        }

    endif;
$dokumen='BIODATA PEMAIN'; 
$mpdf=new mPDF('utf-8', 'A4'); 
ob_start(); 

          
echo '

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <title>'.$obj->nama_situs.'</title>
  
  <style type="text/css">
    body {font-family: sans-serif;
      font-size: 9pt;
      background: transparent url(\'bgbarcode.png\') repeat-y scroll left top;
    }

    h5, p { margin: 0pt;
    }
    table.items {
      font-size: 9pt; 
      border-collapse: collapse;
      
    }
    td { vertical-align: top; 
    }
    table thead td { background-color: #EEEEEE;
      text-align: center;
    }
    table tfoot td { background-color: #AAFFEE;
      text-align: center;
    }
    .barcode {
      padding: 1.5mm;
      margin: 0;
      vertical-align: top;
      color: #000000;
    }
    .barcodecell {
      text-align: center;
      vertical-align: middle;
      padding: 0;
    }
    .kapital{
      text-transform:uppercase;
    } 
  </style>
</head>
<body>
<table class="items" width="100%" cellpadding="2">
  <tbody>
      <tr>
        <td align="right" style="border-bottom:3px solid #403d3d;">
          '.$obj->getDirImage_round2('../../content/web/',$obj->logo).'
            
        </td>
        <td align="center" colspan="2" style="border-bottom:3px solid #403d3d;">
         <h2>'.$obj->nama_situs.'</h2>
         <p>'.$obj->deskripsi_situs.' '.$obj->alamat_situs.'</p>
    
        </td>
      </tr>
  </tbody>
</table>
<br>
<table class="items" width="100%" cellpadding="6">
  <tbody>
    </tr>
      <tr>
        <td colspan="3"><h3>BIODATA PEMAIN</h3></td>
        <td rowspan="8" valign="top">
          <div align="center">
            '.$obj->getDirImage_round2('../../content/foto/pemain/',$obj->foto_user).'<br>
            
          </div>
        </td>      
      </tr>      
      <tr>
        <td>NAMA LENGKAP </td>
        <td>:</td>
        <td class="kapital">'.$obj->nama_user.'</td>
        <td>&nbsp;</td>      
      </tr>
      <tr>
        <td>TEMPAT TGL LAHIR</td>
        <td>:</td>
        <td class="kapital">'.$obj->tempat_lahir.' , '.$obj->tgl_lahir.'</td>
        <td>&nbsp;</td>      
      </tr>
      <tr>
        <td>CLUB</td>
        <td>:</td>
        <td class="kapital">'.$obj->shownameClub($obj->id_club).'</td>
        <td>&nbsp;</td>      
      </tr>
      <tr>
        <td>POSISI/NO. PUNGGUNG</td>
        <td>:</td>
        <td class="kapital">'.$obj->posisi_pemain.' ('.$obj->no_punggung.')</td>
        <td>&nbsp;</td>      
      </tr>
      <tr>
        <td>NIK</td>
        <td>:</td>
        <td class="kapital">'.$obj->nik.'</td>
        <td>&nbsp;</td>      
      </tr>
      <tr>
        <td>NO. KK</td>
        <td>:</td>
        <td class="kapital">'.$obj->no_kk.'</td>
        <td>&nbsp;</td>      
      </tr>
      <tr>
        <td>TINGGI / BERAT BADAN</td>
        <td>:</td>
        <td class="kapital">'.$obj->tinggi_badan.' CM /'.$obj->berat_badan.' KG</td>
        <td>&nbsp;</td>      
      </tr>
      <tr>
        <td>GOL. DARAH</td>
        <td>:</td>
        <td class="kapital">'.$obj->golongan_darah.'</td>
        <td>&nbsp;</td>      
      </tr>
      <tr>
        <td>ALAMAT</td>
        <td>:</td>
        <td class="kapital">'.$obj->alamat.'</td>
        <td>&nbsp;</td>      
      </tr>   
      <tr>
        <td>KONTAK PEMAIN</td>
        <td>:</td>
        <td class="kapital">'.$obj->kontak_pemain.'</td>
        <td>&nbsp;</td>      
      </tr>                                                                  
  </tbody>
</table>
<div style="text-align: center; padding: 0.5mm; padding-top: 2mm;">    
    <barcode code="0003469123456789012345" type="EAN128C"/><br>
    <div style="font-family: ocrb;">0003469-'.date('Y').''.$obj->id_user.'-'.$obj->id_club.'</div>
</div>
</body>
</html>
';

$html = ob_get_contents(); 
ob_end_clean();
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML(utf8_encode($html));
$mpdf->Output($dokumen.".pdf" ,'I');
exit;
?>
