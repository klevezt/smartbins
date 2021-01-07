<?php

	// Access: Admin
	// Purpose: Export the information about the bins to a csv file
	
	require "includes/db.class.php";
	include "includes/functions.php";
	check_login();
	
	header('Content-Type: application/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=list_of_bins.csv');
	
	$bins=select_list_of_bins_sql();
		
		
	$output = fopen('php://output', 'w');
	fputcsv($output, array('Bin ID', 'Latitude', 'Longitude', 'Description', 'Alert', 'Wash Date'));
	$list = array();

	foreach($bins as $bin ) {
	$arr=array(
			"id_bin" => $bin->id_bin,
            "lat"    => $bin->lat,
			"lng"    => $bin->lng,
            "description" => $bin->description,
			"alert" => $bin->alert,
			"washDate" => $bin->washDate
			);
	array_push($list,$arr);
	}
		
	foreach ($list as $fields){
		fputcsv($output,$fields);
	}
	exit;
	header("Location: admin_list_of_bins.php");

?>