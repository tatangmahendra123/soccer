<?php
class login extends smpl
{
	public function loginAuth($nik, $pass)
	{
		$sql="SELECT id_user, nik, password FROM users WHERE nik=?";
		if($stmt=$this->prepare($sql)):
			$stmt->bind_param("s",$param_data);
			$param_data=$nik;
			if($stmt->execute()):
				$stmt->store_result();
				$stmt->bind_result($this->id_user, $this->nik, $this->pass_hash);
				$stmt->fetch();
				if($stmt->num_rows==1):
					if(password_verify($pass, $this->pass_hash)):
						return true;
					else:
						return false;
					endif;
				endif;
			endif;
		endif;
		$stmt->close();
	}
	
}