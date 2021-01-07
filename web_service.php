<?php

class WEB_SERVICE{
	
	
	public function webservice($bin_id,$bin_contend,$bins_humidity,$bins_temperature,$button,$timestamp){
		
		$sql="SELECT id_bin FROM bin WHERE id_bin=:id";
		$stmt = DB::instance()->getConnection()->prepare($sql);
		$stmt->execute(array(':id'=>$bin_id));
		$count=$stmt->rowCount();
		if($count>0){
			$sql = "INSERT INTO stats (bin_id, bin_contend, bins_humidity, bins_temperature, button, timestamp) VALUES (:lat, :lng, :description, 1, :alert)";
			$stmt = DB::instance()->getConnection()->prepare($sql);
			$stmt->execute(array(':bin_id' => $bin_id, ':bin_contend' => $bin_contend, ':bins_humidity' => $bins_humidity, ':bins_temperature' => $bins_temperature), ':button' => $button), ':timestamp' => $timestamp));
		}
		
	}
	
	
}


?>