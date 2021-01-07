<?php

	// Access: Admin
	// Purpose: Delete the specified employee
	
require 'includes/functions.php';
require 'includes/sanitize.class.php';
is_admin();

$s = new Sanitize();
$arr=array();
$arr = $s->sanitize_value($_POST['user_id']);
$role=select_user_by_id($arr[0]);

if($role == 1){
    
    $count1=delete_user_sql($arr[0]);

    if ($count1){
        logfiles('116');
        SessionData::set(__('Επιτυχής διαγραφή'),'success');

    }else {
        logfiles('117');
        SessionData::set(__('Δεν έγινε διαγραφή'),'danger');
    }


} elseif($role == 0) {
    logfiles('117');
    SessionData::set(__('Δεν μπορείτε να διαγράψετε τον διαχειριστή'),'warning');
}

header("location: admin_list_of_emps.php" ); exit();

?>