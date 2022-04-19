<?php
class export extends main_Admin
{
	public function exportBy_club()
	{

		$this->data=$this->paraPemain($this->esc($this->get('id_club')));
		echo'
	
			<table border="1">					       
				<tr>
					<thead>
						<tr>
							<th colspan="8">DAFTAR PEMAIN '.$this->shownameClub($this->get('id_club')).'</th>
						</tr>
		               <tr>
		                	<th>NAMA LENGKAP</th>
		                    <th>TEMPAT TGL/LAHIR</th>
		                    <th>CLUB</th>
		                    <th>POSISI/NO PUNGGUNG</th>
		                    <th>NIK</th>
		                    <th> NO KK</th>
		                    <th>TINGGI/BERAT BADAN /GOL. DARAH</th>
		                    <th>KONTAK</th>
		                    

		                </tr>
		            </thead>
						';
						while($row=$this->data->fetch_array()){
			
							echo'
							<tr>					
							<td>'.$row['nama_pemain'].'</td>
							<td>'.$row['tempat_lahir'].','.$row['tgl_lahir'].'</td>
							<td>'.$this->shownameClub($row['id_club']).'</td>
							<td>'.$row['posisi_pemain'].',('.$row['no_punggung_pemain'].')</td>
							<td>"'.$row['nik'].'"</td>
							<td>"'.$row['no_kk'].'"</td>
							<td>'.$row['tinggi_badan'].' CM /'.$row['berat_badan'].' KG /'.$row['golongan_darah'].'</td>
							<td>'.$row['kontak_pemain'].'</td>
							</tr>
							';
						}
						$this->data->free_result();
						echo '    
			</table>
	
		';
	
	}
	public function exportBy_club_session()
	{
		$this->sessionData($this->filter($_SESSION['id_user']));
		$this->data=$this->paraPemain($this->datasession['id_club']);
		echo'
	
			<table border="1">					       
				<tr>
					<thead>
						<tr>
							<th colspan="8">DAFTAR PEMAIN '.$this->shownameClub($this->datasession['id_club']).'</th>
						</tr>
		               <tr>
		                	<th>NAMA LENGKAP</th>
		                    <th>TEMPAT TGL/LAHIR</th>
		                    <th>CLUB</th>
		                    <th>POSISI/NO PUNGGUNG</th>
		                    <th>NIK</th>
		                    <th> NO KK</th>
		                    <th>TINGGI/BERAT BADAN /GOL. DARAH</th>
		                    <th>KONTAK</th>
		                    

		                </tr>
		            </thead>
						';
						while($row=$this->data->fetch_array()){
			
							echo'
							<tr>					
							<td>'.$row['nama_pemain'].'</td>
							<td>'.$row['tempat_lahir'].','.$row['tgl_lahir'].'</td>
							<td>'.$this->shownameClub($row['id_club']).'</td>
							<td>'.$row['posisi_pemain'].',('.$row['no_punggung_pemain'].')</td>
							<td>"'.$row['nik'].'"</td>
							<td>"'.$row['no_kk'].'"</td>
							<td>'.$row['tinggi_badan'].' CM /'.$row['berat_badan'].' KG /'.$row['golongan_darah'].'</td>
							<td>'.$row['kontak_pemain'].'</td>
							</tr>
							';
						}
						$this->data->free_result();
						echo '    
			</table>
	
		';
	}
}
?>