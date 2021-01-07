<?php

	// Access: The php files 
	// Purpose: Set the logfile list , check the cookies , find the IP and get the language of the webpage	

date_default_timezone_set('Europe/Athens');
require_once "db.class.php";
require_once "lang.en.php";
require_once "SessionData.php";
session_start();

//logfiles list
$logfile=array(
    '101' => "Επιτυχία εισόδου",
    '102' => "Αποτυχία εισόδου",
    '103' => "Επιτυχία προσθήκης κάδου",
    '104' => "Αποτυχία προσθήκης κάδου",
    '105' => "Επιτυχία εξόδου",
    '106' => "Επιτυχία προσθήκης υπαλλήλου",
    '107' => "Αποτυχία προσθήκης υπαλλήλου",
    '108' => "Επιτυχία επεξεργασίας υπαλλήλου",
    '109' => "Αποτυχία επεξεργασίας υπαλλήλου",
    '110' => "Επιτυχία επεξεργασίας κάδου",
    '111' => "Αποτυχία επεξεργασίας κάδου",
    '112' => "Επιτυχία επαναφοράς κάδου",
    '113' => "Αποτυχία επαναφοράς κάδου",
    '114' => "Επιτυχία επαναφοράς υπαλλήλου",
    '115' => "Αποτυχία επαναφοράς υπαλλήλου",
    '116' => "Επιτυχία διαγραφής υπαλλήλου",
    '117' => "Αποτυχία διαγραφής υπαλλήλου",
    '118' => "Επιτυχία διαγραφής κάδου",
    '119' => "Αποτυχία διαγραφής κάδου",
    '120' => "Επιτυχία ανανέωσης διαχειριστή",
    '121' => "Αποτυχία ανανέωσης διαχειριστή"
);
//

//find ip
$localhost= array('127.0.0.1','::1');
if(in_array($_SERVER['REMOTE_ADDR'],$localhost)){
 $domain='http://localhost/Garbage_Management' ;    

}
else{   
    
    if(empty($_SERVER['HTTPS'])||$_SERVER['HTTPS']==="off"){
	$location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	header('HTTP/1.1 301 Moved Permanently');
	header('Location:' . $location);

}
    
}

//define(('APP_URL'),$domain);
//

//check cookie 
if (isset($_COOKIE['rememberMe']) ) {
    $array=(unserialize($_COOKIE['rememberMe']));
    $sql="Select * FROM users WHERE id= :id AND status=1 AND rememberMe=:remember";
    $stmt = $conn->prepare($sql);
	$stmt->execute(array(':id'=>$array[0],':remember'=>$array[1]));
    $Count=$stmt->rowCount();
      
	if ($Count==1) {
		$user = $stmt->fetch();
		$_SESSION['userid']=$user->id;
		$_SESSION['name']=$user->name;
		$_SESSION['role']=$user->role;
        $_SESSION['status']=$user->status;
    }
}
//


//get language//
if (isset($_GET['lang'])) {
    $_Lang=$_GET['lang'];
}else {
    $_Lang = 'el';
}
$_SESSION['lang']= $_Lang;
//