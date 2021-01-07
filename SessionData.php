<?php


	// Access: Admin and Employee
	// Purpose: Notifications and messages display

Class SessionData{
    static function get(){
		if(isset($_SESSION['notifications'])){
			foreach ($_SESSION['notifications'] as $k=>$v ){
				echo   "
					<div class='message'>
					<div class='alert alert-".$v['messageType']." alert-dismissible'>
					<button type='button' class='close' data-dismiss='alert'>&times;</button>
					".$v['message']."
					</div>
					</div>";
					unset($_SESSION['notifications'][$k]);
			}
		}
            
    }
    
    static function set($message,$messageType){
        $_SESSION['notifications'][]=array('message'=>$message,'messageType'=>$messageType);
    }
    
    
}
?>