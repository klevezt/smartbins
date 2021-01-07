<?php

// Access: Admin,Employee
	// Purpose: The class for sanitizing the data

class Sanitize {
	
	function sanitize_value(){
		$arr = array();
		$numargs = func_num_args();
		$arg_list = func_get_args();
		for($i=0;$i<$numargs;$i++){
			array_push($arr,filter_var($arg_list[$i], FILTER_SANITIZE_STRING));
		}
		return $arr;
	}
	
}

?>