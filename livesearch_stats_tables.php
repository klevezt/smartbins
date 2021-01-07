<?php

	// Access: Admin and Employee
	// Purpose: Search the year for the stats

require "includes/db.class.php";
include "includes/functions.php";
include "includes/sanitize.class.php";
$s = new Sanitize();
$arr=array();
$arr = $s->sanitize_value($_GET["q"]);
check_login();
$q=$arr[0];
if(isset($_GET["bin_id"])){
$arr = $s->sanitize_value($_GET["bin_id"]);
$binn_id = $arr[0];
}
if(isset($binn_id)) {
	$sql="SELECT year(timestamp) as ye FROM stats where bin_id=:bin_id and year(timestamp) like CONCAT(:qq, '%') GROUP by year(timestamp)";
	$stmt = $conn->prepare($sql);
	$stmt->execute(array(':qq' => $q, ":bin_id" =>$binn_id));
}
else {
	$sql="SELECT year(timestamp) as ye FROM stats where year(timestamp) like CONCAT(:qq, '%') GROUP by year(timestamp)";
	$stmt = $conn->prepare($sql);
	$stmt->execute(array(':qq' => $q));
}

$years=$stmt->fetchAll();
$resp ="";
foreach ($years as $y){
	$resp = $resp. "<option value=".$y->ye."> ".$y->ye."</option>";
}
echo $resp;

?>