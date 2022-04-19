<?php
class sessionMain
{
	public function administrator(){

		if($_SESSION['role']!='administrator'){
				return true;
			}else{
				return false;
			}
	}
	
	public function petugas(){

		if($_SESSION['role']!='petugas'){
				return true;
			}else{
				return false;
			}
	}
	public function adminclub(){

		if($_SESSION['role']!='adminclub'){
				return true;
			}else{
				return false;
			}
	}
	public function pemain(){

		if($_SESSION['role']!='pemain'){
				return true;
			}else{
				return false;
			}
	}
	
	
}

?>