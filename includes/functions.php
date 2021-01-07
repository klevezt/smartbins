<?php

	// Access: The php files 
	// Purpose: Insert information to the logfiles , change the language , create footer and header for every page
	//          create footer and header for administrator page,create code for reset password , encryption and decryption method , check the type of current user

require_once "headers.php";
function getMonths(){
	$months = array("Ιανουάριος","Φεβρουάριος","Μάρτιος","Απρίλιος","Μάιος","Ιούνιος","Ιούλιος","Αύγουστος","Σεπτέμβριος","Οκτώβριος","Νοέμβριος","Δεκέμβριος");
	return $months;
}


//change language//
function __($str) {
    if ($_SESSION['lang']=="en") {
        return $lang[$_SESSION['lang']][$str];
    }else {
        return $str;
    }
}
//

//logfiles insertion
function logfiles($action){
    global $conn;
    $sql="INSERT INTO logfiles (ip ,userid, timestamp, action) VALUES (:ip, :userid, :timestamp, :action)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(':ip'=>$_SERVER['REMOTE_ADDR'],':userid'=>$_SESSION['userid'], ':timestamp'=>date('Y-m-d H:i:s'), ':action'=>$action));
}
//


function bin_show_errors($lat,$lng,$description,$alert,$washDate){
		
		if (empty($alert)||!is_numeric($alert)) {
			logfiles('111');
			die('1.Λάθος/Κενή τιμή πεδίου συναγερμού');
		}

		if (empty($lat)||!is_numeric($lat)) {
			logfiles('111');
			die('2.Λάθος/Κενή τιμή γεωγραφικού πλάτους');
		}

		if (empty($lng)||!is_numeric($lng)) {
			logfiles('111');
			die('3.Λάθος/Κενή τιμή γεωγραφιού μήκους');
		}

}

function select_logfiles_sql(){
	global $conn;
	$sql="SELECT l.*,u.name, u.username FROM logfiles l LEFT JOIN users u ON l.userid=u.id";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$logs=$stmt->fetchAll();
	return $logs;
}

function update_bin_show_errors($lat,$lng,$description,$alert,$washDate){
		
		
    if (empty($alert)) {

        logfiles('111');
        SessionData::set(__('Κενή τιμή συναγερμού'),'danger');
        return 1;
    }

    if (empty($lat)) {

        logfiles('111');
        SessionData::set(__('Κενή τιμή γεωγραφικού πλάτους '),'danger');
        return 1;
    }

    if (empty($lng)) {
        logfiles('111');
        SessionData::set(__('Κενή τιμή γεωγραφικού μήκους '),'danger');
        return ;
    }

    if (!is_numeric($lat)){

        logfiles('111');
        SessionData::set(__('Λάθος τιμή γεωγραφικού πλάτους'),'danger');
        return 1;

    }

    if (!is_numeric($lng)){

        logfiles('111');
        SessionData::set(__('Λάθος τιμή γεωγραφικού μήκους'),'danger');
        return 1;
    }
    if (!is_numeric($alert)){

        logfiles('111');
        SessionData::set(__('Λάθος τιμή συναγερμού'),'danger');
        return 1;
    }

}

function emp_show_errors($name,$age,$address,$username,$email,$password,$confirm_password,$role,$fact){
	
		if (empty($username)) {
			logfiles('107');
			die('1.Λάθος username');
		}

		if (!is_numeric($age)){
			logfiles('107');
			die('2.Λάθος τιμή ηλικίας');
		}

		if($fact==1){
			if (empty($password) || $password!==$confirm_password) {
				logfiles('107');
				die('3.Λάθος password');
			}
		}

}
function update_emp_show_errors($name,$age,$address,$username,$email,$password,$confirm_password,$role){
	
		 if (!is_numeric($age)){
			logfiles('109');
			SessionData::set(__('Λάθος τιμή ηλικίας'),'danger');
			return 1;
		}

		if (empty($username)) {
			logfiles('109');
			SessionData::set(__('Λάθος username'),'danger');
			return 1;

		}


}
	
function bin_add_sql($lat,$lng,$description,$alert,$washDate){
		$sql = "INSERT INTO bin (lat, lng, description, status, alert, washDate) VALUES (:lat, :lng, :description, 1, :alert, :washDate)";
		$stmt = DB::instance()->getConnection()->prepare($sql);
		$stmt->execute(array(':lat' => $lat, ':lng' => $lng, ':description' => $description, ':alert' => $alert, ':washDate' => $washDate));
		$count = $stmt->rowCount();
		return $count;
}

function emp_add_sql($name,$age,$address,$username,$email,$password,$confirm_password,$role){
			
			if ($role!='Yes') {
				$sql="INSERT INTO users ( name, age, address, username, email, password, role, status) VALUES (:name, :age, :address, :username, :email, :password, 1, 1)";
			}else {
				$sql="INSERT INTO users ( name, age, address, username, email, password, role, status) VALUES (:name, :age, :address, :username, :email, :password, 0, 1)";
			}
			$stmt = DB::instance()->getConnection()->prepare($sql);
			$stmt->execute(array(':name'=>$name,':age'=>$age, ':address'=>$address, ':username'=>$username, ':email'=>$email, ':password'=>hash('sha256',$password)));
			$count=$stmt->rowCount();
			return $count;
}

function delete_bin_sql($id_bin){
		$sqlDeleteBin="UPDATE bin Set status=0 WHERE id_bin=:id";
		$stmt1 = DB::instance()->getConnection()->prepare($sqlDeleteBin);
		$stmt1->execute(array(':id'=>$id_bin));
		$count=$stmt1->rowCount();
		return $count;
}

function delete_user_sql($id){
		$sqlDeleteUser="UPDATE users Set status=0 WHERE id=:id";
		$stmt1 = DB::instance()->getConnection()->prepare($sqlDeleteUser);
		$stmt1->execute(array(':id'=>$id));
		$count1=$stmt1->rowCount();
		return $count1;
}

function select_unique_username($username){
		$sqlUniqueUsername="SELECT username FROM users WHERE username=:username";
		$stmt = DB::instance()->getConnection()->prepare($sqlUniqueUsername);
		$stmt->execute(array(':username'=>$username));
		$countUniqueUser=$stmt->rowCount();
		return $countUniqueUser;
}

function select_unique_email($email){
		$sqlUniqueEmail="SELECT email FROM users WHERE email=:email";
		$stmt = DB::instance()->getConnection()->prepare($sqlUniqueEmail);
		$stmt->execute(array(':email'=>$email));
		$countUniqueEmail=$stmt->rowCount();
		return $countUniqueEmail;
}

function select_user_by_id($id){
		$sqlGetUser="SELECT * FROM users WHERE id=:id";
		$stmt = DB::instance()->getConnection()->prepare($sqlGetUser);
		$stmt->execute(array(':id'=>$id));
		$user=$stmt->fetch();
		$role=$user->role;
		return $role;
}

function select_bin_by_id($id){
		$sqlGetBin="SELECT * FROM stats WHERE bin_id =:id and timestamp in (SELECT max(timestamp) from stats WHERE bin_id=:id)";
		$stmt = DB::instance()->getConnection()->prepare($sqlGetBin);
		$stmt->execute(array(':id'=>$id));
		$bin=$stmt->fetch();
		$bin_contend=$bin->bin_contend;
		$bin_humid=$bin->bins_humidity;
		$bin_tmp=$bin->bins_temperature;
		$bin_last_contact=$bin->timestamp;
		return array($bin_contend,$bin_humid,$bin_tmp,$bin_last_contact);
}

function select_bins_over_limit(){
		
		return admin_change_sql_mode()[1];
}
function select_bin_by_over_limit($id){
		
		return select_bin_by_id($id);
}



function select_deleted_bins_sql(){
		$sql="SELECT id_bin, lat, lng, description, alert,washDate FROM bin WHERE status=0";
		$stmt = DB::instance()->getConnection()->prepare($sql);
		$stmt->execute();
		$bins=$stmt->fetchAll();
		return $bins;
}

function select_deleted_emps_sql(){
		$sql="SELECT id, name, age, address, username,email,role FROM users WHERE status=0";
		$stmt = DB::instance()->getConnection()->prepare($sql);
		$stmt->execute();
		$users=$stmt->fetchAll();
		return $users;
}

function select_list_of_bins_sql(){
		$sql="SELECT id_bin, lat, lng, description, alert,washDate FROM bin WHERE status=1";
		$stmt =DB::instance()->getConnection()->prepare($sql);
		$stmt->execute();
		$bins=$stmt->fetchAll();
		return $bins;
}

function select_list_of_emps_sql(){
		$sql="SELECT id, name, age, address, username,email,role FROM users WHERE status=1";
		$stmt =DB::instance()->getConnection()->prepare($sql);
		$stmt->execute();
		$users=$stmt->fetchAll();
		return $users;
}

function check_the_button_sql(){
	global $conn;
	$bins = select_list_of_bins_sql();
	$idd=array();	
	foreach($bins as $bin){
		//echo $bin->id_bin;
		$sql1="SELECT * FROM stats WHERE bin_id=:bid ORDER BY timestamp DESC LIMIT 2 ";
		$stmt1 = $conn->prepare($sql1);
		$stmt1->execute(array(':bid'=> $bin->id_bin));
		$results=$stmt1->fetchAll();
		$arr=array();
		$but=array();
		foreach($results as $row){
			array_push($arr,$row->timestamp);
			array_push($but,$row->button);
		}
		if(count($arr)>1){
			if(((strtotime($arr[0])- strtotime($arr[1]))/60>=10) && $but[0]==1 && $but[1]==1){
					array_push($idd,$bin->id_bin);
				 
			}
		}
	}
	return $idd;
}


function admin_change_sql_mode(){
	global $conn;
	$sql="SELECT bin_id,id,timestamp FROM stats INNER JOIN bin ON bin.id_bin=stats.bin_id WHERE bin.alert<=stats.bin_contend AND timestamp in ( SELECT max(timestamp) FROM stats GROUP by bin_id )  ";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$count2=$stmt->rowCount();
	$bins=$stmt->fetchAll();
	return array($count2,$bins);
}

function select_bin_emps_sql(){
	global $conn;
	$months = getMonths();
	$sql="SELECT lat FROM bin WHERE status=1";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$count=$stmt->rowCount();

	$sql="SELECT age FROM users WHERE status =1" ;
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$count1=$stmt->rowCount();
	$sql="select month(timestamp) as date,avg(bin_contend) as avg_p , year(timestamp) as y from stats group by month(timestamp),year(timestamp) ORDER BY timestamp";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$stats=$stmt->fetchAll();
	$label=[];
	$data=[];
	foreach($stats as $stat) {
		array_push($label, $months[$stat->date]. " ".$stat->y);
		array_push($data, $stat->avg_p);

	}
	
	return array($count,$count1,$label,$data);
}

function reset_emp_sql($id){
		$sqlDeleteEmp="UPDATE users Set status=1 WHERE id=:id";
		$stmt = DB::instance()->getConnection()->prepare($sqlDeleteEmp);
		$stmt->execute(array(':id'=>$id));
		$count=$stmt->rowCount();
		return $count;
}

function reset_bin_sql($id_bin){
		$sqlDeleteBin="UPDATE bin Set status=1 WHERE id_bin=:id";
		$stmt1 = DB::instance()->getConnection()->prepare($sqlDeleteBin);
		$stmt1->execute(array(':id'=>$id_bin));
		$count1=$stmt1->rowCount();
		return $count1;
}

function update_bin_sql($id_bin,$lat,$lng,$description,$alert,$washDate){
		$sql="UPDATE bin Set lat=:lat, lng=:lng, description=:description, alert=:alert, washDate=:washDate WHERE id_bin=:id";
		$stmt = DB::instance()->getConnection()->prepare($sql);
		$stmt->execute(array(':lat'=>$lat,':lng'=>$lng, ':description'=>$description, ':alert'=>$alert, ':washDate'=>$washDate, ':id'=>$id_bin));
		$count=$stmt->rowCount();
		return $count;
}

function update_users_sql($id,$name,$age,$address,$username,$email,$old_username,$old_email){
		$sql="UPDATE users Set name=:name, age=:age, address=:address, username=:username , email=:email WHERE id=:id";
		$stmt = DB::instance()->getConnection()->prepare($sql);
		$stmt->execute(array(':name'=>$name,':age'=>$age, ':address'=>$address, ':username'=>$username, ':email'=>$email, ':id'=>$id));
		$count=$stmt->rowCount();
		return $count;
}

function create_data_for_bin_contend_stats($year,$fr,$to){
	global $conn;
	$months = getMonths();
	if($fr!="" && $to!=""){
		$sql="select day(timestamp),avg(bin_contend) as avg_p ,month(timestamp) as date, year(timestamp) as y from stats where date(timestamp) between :fr and :to GROUP by month(timestamp),year(timestamp) ORDER BY timestamp";
		$stmt = $conn->prepare($sql);
		$stmt->execute(array(":fr" => $fr, ":to" =>$to));
	} 
	else{
		$sql="select month(timestamp) as date,avg(bin_contend) as avg_p from stats where year(timestamp)=:year group by month(timestamp)";
		$stmt = $conn->prepare($sql);
		$stmt->execute(array(":year" =>$year));
	}
	
	$stats=$stmt->fetchAll();
	$label=[];
	$data=[];
	foreach($stats as $stat) {		
		if($fr!="" && $to!="") array_push($label, $months[$stat->date-1]." ".$stat->y);
		else array_push($label, $months[$stat->date-1]." ".$year);
		array_push($data, $stat->avg_p);

	}
	return array($data,$label);
}

function create_data_for_humidity_stats($year,$fr,$to){
	global $conn;
	$months = getMonths();
	if($fr!="" && $to!=""){
		$sql1="select day(timestamp),avg(bins_humidity) as avg_p ,month(timestamp) as date, year(timestamp) as y from stats where date(timestamp) between :fr and :to GROUP by month(timestamp),year(timestamp) ORDER BY timestamp";
		$stmt1 = $conn->prepare($sql1);
		$stmt1->execute(array(":fr" => $fr, ":to" =>$to));
	} 
	else{
		$sql1="select month(timestamp) as date,avg(bins_humidity) as avg_p from stats where year(timestamp)=:year group by month(timestamp)";
		$stmt1 = $conn->prepare($sql1);
		$stmt1->execute(array(":year" => $year));
	}

	$stats1=$stmt1->fetchAll();
	$label_ch=[];
	$data_ch=[];
	foreach($stats1 as $stat) {
		if($fr!="" && $to!="") array_push($label_ch, $months[$stat->date-1]." ".$stat->y);
		else array_push($label_ch, $months[$stat->date-1]." ".$year);
		array_push($data_ch, $stat->avg_p);

	}
	return array($data_ch,$label_ch);
}

function create_data_for_temperature_stats($year,$fr,$to){
	global $conn;
	$months = getMonths();
	if($fr!="" && $to!=""){
		$sql2="select day(timestamp),avg(bins_temperature) as avg_p ,month(timestamp) as date, year(timestamp) as y from stats where date(timestamp) between :fr and :to GROUP by month(timestamp),year(timestamp) ORDER BY timestamp";
		$stmt2 = $conn->prepare($sql2);
		$stmt2->execute(array(":fr" => $fr, ":to" =>$to));
	} 
	else{
		$sql2="select month(timestamp) as date,avg(bins_temperature) as avg_p from stats where year(timestamp)=:year group by month(timestamp)";
		$stmt2 = $conn->prepare($sql2);
		$stmt2->execute(array(":year" => $year));
	}
	
	$stats2=$stmt2->fetchAll();
	$label_temp=[];
	$data_temp=[];
	foreach($stats2 as $stat) {
		if($fr!="" && $to!="") array_push($label_temp, $months[$stat->date-1]." ".$stat->y);
		else array_push($label_temp, $months[$stat->date-1]." ".$year);
		array_push($data_temp, $stat->avg_p);

	}
	return array($data_temp,$label_temp);
}

function create_data_for_bin_contend_stats_by_bin($year,$fr,$to,$bin_id){
	global $conn;
	$months = getMonths();
	if($fr!="" && $to!=""){
		$sql="select day(timestamp),avg(bin_contend) as avg_p ,month(timestamp) as date, year(timestamp) as y from stats where bin_id=:bin_id and date(timestamp) between :fr and :to GROUP by month(timestamp),year(timestamp) ORDER BY timestamp";
		$stmt = $conn->prepare($sql);
		$stmt->execute(array(":fr" => $fr, ":to" =>$to, ':bin_id'=>$bin_id));
	} 
	else{
		$sql="select month(timestamp) as date,avg(bin_contend) as avg_p from stats where bin_id=:bin_id and year(timestamp)=:year group by month(timestamp)";
		$stmt = $conn->prepare($sql);
		$stmt->execute(array(':bin_id'=>$bin_id,":year"=>$year ));
	}
	
	$stats=$stmt->fetchAll();
	$label=[];
	$data=[];
	foreach($stats as $stat) {		
		if($fr!="" && $to!="") array_push($label, $months[$stat->date-1]." ".$stat->y);
		else array_push($label, $months[$stat->date-1]." ".$year);
		array_push($data, $stat->avg_p);
	}
	return array($data,$label);
}

function create_data_for_humidity_stats_by_bin($year,$fr,$to,$bin_id){
	global $conn;
	$months = getMonths();
	if($fr!="" && $to!=""){
		$sql1="select day(timestamp),avg(bins_humidity) as avg_p ,month(timestamp) as date, year(timestamp) as y from stats where bin_id=:bin_id  and date(timestamp) between :fr and :to GROUP by month(timestamp),year(timestamp) ORDER BY timestamp";
		$stmt1 = $conn->prepare($sql1);
		$stmt1->execute(array(":fr" => $fr, ":to" =>$to, ':bin_id'=>$bin_id));
	} 
	else{
		$sql1="select month(timestamp) as date,avg(bins_humidity) as avg_p from stats where bin_id=:bin_id  and year(timestamp)=:year group by month(timestamp)";
		$stmt1 = $conn->prepare($sql1);
		$stmt1->execute(array(':bin_id'=>$bin_id, ":year"=>$year ));
	}
	
	$stats1=$stmt1->fetchAll();
	$label_ch=[];
	$data_ch=[];
	foreach($stats1 as $stat) {
		if($fr!="" && $to!="") array_push($label_ch, $months[$stat->date-1]." ".$stat->y);
		else array_push($label_ch, $months[$stat->date-1]." ".$year);
		array_push($data_ch, $stat->avg_p);

	}
	return array($data_ch,$label_ch);
}

function create_data_for_temperature_stats_by_bin($year,$fr,$to,$bin_id){
	global $conn;
	$months = getMonths();
	if($fr!="" && $to!=""){
		$sql2="select day(timestamp),avg(bins_temperature) as avg_p ,month(timestamp) as date, year(timestamp) as y from stats  where bin_id=:bin_id  and date(timestamp) between :fr and :to GROUP by month(timestamp),year(timestamp) ORDER BY timestamp";
		$stmt2 = $conn->prepare($sql2);
		$stmt2->execute(array(":fr" => $fr, ":to" =>$to, ':bin_id'=>$bin_id));
	} 
	else{
		$sql2="select month(timestamp) as date,avg(bins_temperature) as avg_p from stats where bin_id=:bin_id  and year(timestamp)=:year group by month(timestamp)";
		$stmt2 = $conn->prepare($sql2);
		$stmt2->execute(array(':bin_id'=>$bin_id, ":year"=>$year ));
	}
	
	$stats2=$stmt2->fetchAll();
	$label_temp=[];
	$data_temp=[];
	foreach($stats2 as $stat) {
		if($fr!="" && $to!="") array_push($label_temp, $months[$stat->date-1]." ".$stat->y);
		else array_push($label_temp, $months[$stat->date-1]." ".$year);
		array_push($data_temp, $stat->avg_p);

	}
	return array($data_temp,$label_temp);
}

function get_last_update($sql1){
	global $conn;
	$stmt1 = $conn->prepare($sql1);
	$stmt1->execute();
	$count1=$stmt1->rowCount();
	$lastUpdate=$stmt1->fetch(PDO::FETCH_BOTH);
	return $lastUpdate;
}



//create random code for reset password//
function randomPassword($num=12)
{
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $num; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
//


//encryption-decryption for get methods (AES)
function my_simple_crypt( $string, $action = 'e' ) {
    $secret_key = 'dimitris';
    $secret_iv = 'panos';

    $output = false;
    $encrypt_method = "AES-256-CBC";

    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );

    if( $action == 'e' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'd' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }

    return $output;
}
//


//header//
function getHead() {
echo "
<!DOCTYPE html>
	<html>
        <head>
            <title> SmartBins </title>
            <link rel='stylesheet' href='assets/css/bootstrap.min.css' />
            <link rel='stylesheet' href='assets/css/style.css' />
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
            
            
            
            <script src='https://www.google.com/recaptcha/api.js' async defer></script>
            <script src='assets/js/jquery.min.js'></script>
            <script src='assets/js/popper.min.js'></script>
           
    
            <meta http-equiv='Content-Type' content='text/html;charset=utf-8' >
            <meta name='viewport' content='width=device-width, initial-scale=1'>
        </head>


        <body>
        
        
            <nav class=' navbar navbar-expand-sm bg-dark navbar-dark'>
            
            <h1 class='navbar-brand' style='color:white'> Καλώς Ορίσατε στο SmartBins </h1>
            <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
                        <span class='navbar-toggler-icon'></span>
            </button>
    
    
</nav>
";
}
//


//footer//
function getFooter() {

echo"
<div class='foot' >
<footer>

		
		<div class=\"footer-limiter\">

			<div class=\"footer-right\">

				<a href='https://www.facebook.com/uowm.gr/'><i class=\"fa fa-facebook\"></i></a>
				<a href='#'><i class=\"fa fa-twitter\"></i></a>
				<a href='#'><i class=\"fa fa-linkedin\"></i></a>
				<a href='https://github.com/mdasyg'><i class=\"fa fa-github\"></i></a>

			</div>

			<div class=\"footer-left\">

				<p class=\"footer-links\">Developed By Dimitris Panos and Klevest Palucaj</p>

				<p>Supervised by Minas Dasigenis</p>
			</div>

		</div>

	</footer>
</div>

</body>
</html>
        ";
}
//

//return true boolean if user is_logged//
function is_logged() {
    if (isset($_SESSION['userid']) && $_SESSION['userid']>0 ) {
        return true;
    }
    return false;
}
//

//check if user is logged in//
function check_login(){
    if(!is_logged()){

    header("location:index.php");
    exit;
    }
}
//

function getSession(){
	return $_SESSION['role'];
}

//check if user is admin//
function is_admin() {
    check_login();
    if ($_SESSION['role']!=0) {
        die("Restricted");
    }
}
//

//check if user is employee
function is_emp() {
    check_login();
    if ($_SESSION['role']!=1) {
        die("Restricted");
    }
}


//admin template//
function admin_page(){
    echo "
   <!DOCTYPE html>
<html lang=\"en\">

  <head>

    <meta charset=\"utf-8\">
    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
    <meta name=\"description\" content=\"\">
    <meta name=\"author\" content=\"\">

    <title>SmartBins</title>
	
	<!-- Leaflet -->
	<link rel='stylesheet' href='https://unpkg.com/leaflet@1.6.0/dist/leaflet.css' integrity='sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ==' crossorigin=''/>
    <script src='https://unpkg.com/leaflet@1.6.0/dist/leaflet.js' integrity='sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew==' crossorigin=''></script>

	
    <!-- Bootstrap core CSS-->
    <link href=\"assets/css/bootstrap.min.css\" rel=\"stylesheet\">

    <!-- Custom fonts for this template-->
    <link href=\"assets/fontawesome-free/css/all.min.css\" rel=\"stylesheet\" type=\"text/css\">

    <!-- Page level plugin CSS-->
    <link href=\"assets/css/dataTables.bootstrap4.min.css\" rel=\"stylesheet\">

    <!-- Custom styles for this template-->
    <link href=\"assets/css/sb-admin.min.css\" rel=\"stylesheet\">
    
    <!-- Chart.js cdn-->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js'></script>
    
  </head>

  <body id=\"page-top\">

    <nav class=\"navbar navbar-expand navbar-dark bg-dark static-top\">

      <a class=\"navbar-brand mr-1\" href=\"admin_index.php\">SmartBins</a>

      <button class=\"btn btn-link btn-sm text-white order-1 order-sm-0\" id=\"sidebarToggle\" href=\"#\">
        <i class=\"fas fa-bars\"></i>
      </button>



      <!-- Navbar -->
      <ul class=\"navbar-nav ml-auto \">

        <li class=\"nav-item dropdown no-arrow\">
          <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"userDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
            <i class=\"fas fa-user-circle fa-fw\"></i>
          </a>
		  
          <div class=\"dropdown-menu dropdown-menu-right\" aria-labelledby=\"userDropdown\">
            <a class=\"dropdown-item\" href=\"admin_settings.php\"><span class='	fa fa-cog'></span>" . __('Ρυθμίσεις') . "</a>
            <a class='dropdown-item' href='logout.php' ><span class='fas fa-sign-out-alt'></span>" . __('Εξοδος') . "</a>
          </div>
		  
        </li>
      </ul>

    </nav>

    <div id=\"wrapper\">
      <!-- Sidebar -->
      <ul class=\"sidebar navbar-nav\">
        <li class=\"nav-item\">
          <a class=\"nav-link\" href=\"admin_index.php\">
            <i class=\"fab fa-adn\"></i>
            <span>" .  __('Αρχική')  . "</span>
          </a>
        </li>
        
        <li class=\"nav-item dropdown\">
          <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"pagesDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
            <i class=\"fas fa-file-alt\"></i>
            <span>" . __('Υπάλληλοι') . "</span>
          </a>
          <div class=\"dropdown-menu\" aria-labelledby=\"pagesDropdown\">
            <h6 class=\"dropdown-header\">" . __('Λειτουργίες:') . "</h6>
            <a class=\"dropdown-item\" href='admin_list_of_emps.php'>" . __('Λίστα Υπαλλήλων') . "</a>
            <a class=\"dropdown-item\" href='admin_deleted_list_of_emps.php'>" . __('Απενεργοποιημένοι') . "</a>
            <a class=\"dropdown-item\" href='admin_add_new_emp.php'>" . __('Προσθήκη Νέου') . "</a>
            </div>
        </li>
		
        
        <li class=\"nav-item dropdown\">
          <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"pagesDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
            <i class=\"fas fa-clipboard	\"></i>
            <span>" .  __('Κάδοι')  . "</span>
          </a>
          <div class=\"dropdown-menu\" aria-labelledby=\"pagesDropdown\">
            <h6 class=\"dropdown-header\">" .  __('Λειτουργίες:')  . "</h6>
            <a class=\"dropdown-item\" href='admin_list_of_bins.php'>" .  __('Λίστα Κάδων')  . "</a>
            <a class=\"dropdown-item\" href='admin_deleted_list_of_bins.php'>" .  __('Απενεργοποιημένοι')  . "</a>
           <a class=\"dropdown-item\" href='admin_add_new_bin.php'>" .  __('Προσθήκη Νέου')  . "</a> 
          </div>
        </li>
        
        <li class=\"nav-item dropdown\">
          <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"pagesDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
            <i class=\"fas fa-chart-area\"></i>
            <span>" .  __('Πίνακες Στατιστικών')  . "</span>
          </a>
          <div class=\"dropdown-menu\" aria-labelledby=\"pagesDropdown\">
            <h6 class=\"dropdown-header\">" .  __('Στατιστικά:')  . "</h6>
            <a class=\"dropdown-item\" href='admin_stats_tables.php'>" .  __('Γενικοί Πίνακες')  . "</a>
            <a class=\"dropdown-item\" href='admin_stats_by_bin.php'>" . __('Στατιστικά ανά Κάδο') . "</a>
          </div>
        </li>
        
        <li class=\"nav-item dropdown\">
          <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"pagesDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
            <i class=\"fas fa-archive\"></i>
            <span>" .  __('Περισσότερα')  . "</span>
          </a>
          <div class=\"dropdown-menu\" aria-labelledby=\"pagesDropdown\">
            <h6 class=\"dropdown-header\">" .  __('Δυνατότητες:')  . "</h6>
			<a class=\"dropdown-item\" href='admin_logfiles_list.php'>" . __('Αρχεία Καταγραφής') . "</a>
			<a class=\"dropdown-item\" href='map.php'>" .  __('Χάρτης Κάδων')  . "</a>
          </div>
        </li>
        
      </ul>
        <div id=\"content-wrapper\">
            <div class=\"container-fluid\">
      
          ";
}
//

//admin footer template//
function adminFooter(){
    echo"
    </div>
        <!-- /.container-fluid -->
        
        <!-- Sticky Footer -->
        <footer class=\"sticky-footer\">
          <div class=\"container my-auto\">
            <div class=\"copyright text-center my-auto\">
              <span>Copyright © Laboratory of Digital Systems and Computer Architecture ". date('Y') ."</span>
            </div>
          </div>
        </footer>
        

      </div>
      <!-- /.content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- scroll to top -->
    <a class=\"scroll-to-top rounded\" href=\"#page-top\">
      <i class=\"fas fa-angle-up\"></i>
    </a>

    

    <!-- Bootstrap js-->
    <script src=\"assets/js/jquery.min.js\"></script>
    <script src=\"assets/js/bootstrap.bundle.min.js\"></script>

    <!-- Core plugin JavaScript-->
    <script src=\"assets/js/jquery.easing.min.js\"></script>
    
    
    <!-- Custom scripts-->
    <script src=\"assets/js/sb-admin.min.js\"></script>
    
    <!-- table plugin JavaScript-->
    <script src=\"assets/js/jquery.dataTables.min.js\"></script>
    <script src=\"assets/js/dataTables.bootstrap4.min.js\"></script>
    
    <!-- user plugin -->
    <script src=\"assets/js/datatables-demo.js\"></script>
    
  </body>
 
</html>
    ";
}



