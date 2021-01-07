<?php

	// Access: Admin
	// Purpose: Export the information about the employees to a csv file
	
	require "includes/db.class.php";
	include "includes/functions.php";
	check_login();
	
	header('Content-Type: application/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=list_of_emps.csv');
	
	
	$emps=select_list_of_emps_sql();
		
		
	$output = fopen('php://output', 'w');
	fputcsv($output, array('Employee ID', 'Name', 'Age', 'Address', 'Username', 'Email'));
	$list = array();

	foreach($emps as $row ) {
		$arr=array(
			"id" => $row->id,
            "name"    => $row->name,
			"age"    => $row->age,
            "address" => $row->address,
			"username" => $row->username,
			"email" => $row->email
			);
			array_push($list,$arr);
	}
		
	foreach ($list as $fields){
		fputcsv($output,$fields);
	}
	exit;
	header("Location: admin_list_of_emps.php");

?>