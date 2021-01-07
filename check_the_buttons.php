<?php

	// Access: Admin
	// Purpose: Check if a bin is close and send notification to the administrator

require 'includes/functions.php';
is_admin();
$sql="SELECT DISTINCT bin_id FROM stats";
$stmt =$conn->prepare($sql);
$stmt->execute();
$bins=$stmt->fetchAll();
foreach($bins as $bin){
	$sql1="SELECT * FROM stats WHERE bin_id=:bid ORDER BY timestamp DESC LIMIT 2 ";
	$stmt1 = $conn->prepare($sql1);
	$stmt1->execute(array(':bid'=> $bin->bin_id));
	$results=$stmt1->fetchAll();
	$arr=array();
	$but=array();
	foreach($results as $row){
		array_push($arr,$row->timestamp);
		array_push($but,$row->button);
	}
	if(count($arr)>1){
		if(((strtotime($arr[0])- strtotime($arr[1]))/60>=10) && $but[0]==1 && $but[1]==1){
			echo " <span class='badge badge-dark'><i  class='fas fa-exclamation-triangle' style='font-size:20px;color:yellow;'></i></span>";
		}
	}
}
?>

