<?php

// Access: The api  
	// Purpose: The class for verification at the api

class Login_Checking{
	
	private $username;
	private $password;
	
	function __construct($username,$password){
		$this->username = $username;
		$this->password = $password;
	}
		
	function verify_login_admin(){
		$sql="SELECT * FROM users WHERE username= :username and password= :password and status!=0 and role=0";
		$stmt = DB::instance()->getConnection()->prepare($sql);
		$stmt->execute(array(':username'=>$this->username,':password'=>hash('sha256',$this->password)));
		$usersCount=$stmt->rowCount();

		if ($usersCount==1) {
			return true;
		}
		else return false;
	}
	function verify_login_emp(){
		$sql="SELECT * FROM users WHERE username= :username and password= :password and status!=0 and role=1";
		$stmt = DB::instance()->getConnection()->prepare($sql);
		$stmt->execute(array(':username'=>$this->username,':password'=>hash('sha256',$this->password)));
		$usersCount=$stmt->rowCount();

		if ($usersCount==1) {
			return true;
		}
		else return false;
	}
	
}


?>