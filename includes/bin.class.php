<?php

// Access: The api  
	// Purpose: The bin class

class Bin {
	
	private $lat;
	private $lng;
	private $description;
	private $alert;
	private $washDate;
		
	function __construct($lat,$lng,$description,$alert,$washDate) {
		$s = new Sanitize();
		$arr=array();
		$arr = $s->sanitize_value($lat,$lng,$description,$alert,$washDate);
		$this->lat = $arr[0];
		$this->lng = $arr[1];
		$this->description = $arr[2];
		$this->alert = $arr[3];
		$this->washDate = $arr[4];
	}
				
	function printData(){
		echo "Latitude:" . getLat() ." ,Longtitude:" . getLng() . " ,Description:" . getDescription() . " ,Alert:" . getAlert() . " Washdate:" . getWashDate();
	}
	
		
	function getLat(){
		return $this->lat;
	}
	function getLng(){
		return $this->lng;
	}
	function getDescription(){
		return $this->description;
	}
	function getAlert(){
		return $this->alert;
	}
	function getWashDate(){
		return $this->washDate;
	}
	
}


?>