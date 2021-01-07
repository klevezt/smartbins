<?php

// Access: The api  
	// Purpose: The employee class

class Emp {
	
	private $name;
	private $age;
	private $address;
	private $username;
	private $email;
	private $password;
	private $confirm_password;
	private $role;
		
	function __construct($name,$age,$address,$username,$email,$password,$confirm_password,$role) {
		$s = new Sanitize();
		$arr=array();
		$arr = $s->sanitize_value($name,$age,$address,$username,$email,$password,$confirm_password,$role);
	    $this->name = $arr[0];
	    $this->age = $arr[1];
		$this->address = $arr[2];
		$this->username = $arr[3];
		$this->email = $arr[4];
		$this->password = $arr[5];
		$this->confirm_password = $arr[6];
		$this->role = $arr[7];
	}
	
		
	function getName(){
		return $this->name;
	}
	function getAge(){
		return $this->age;
	}
	function getAddress(){
		return $this->address;
	}
	function getUsername(){
		return $this->username;
	}
	function getEmail(){
		return $this->email;
	}
	function getPassword(){
		return $this->password;
	}
	function getConfirmPassword(){
		return $this->confirm_password;
	}
	function getRole(){
		return $this->role;
	}
	
}


?>