<?php

class settings extends smpl 
{
	
	public function siteInfo()
	{
		$sql ="SELECT * FROM pengaturan WHERE id_pengaturan=1";
		$perintah = $this->query($sql);
		return $perintah;
	}
	public function loadInfo()
	{
		$this->info=$this->siteInfo();
		$this->infosite=$this->info->fetch_array();
		return $this->infosite;
		$this->infosite->free_result();
	}
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
}

?>