<?php

	// Access: Admin
	// Purpose: Reset the specified employee's status
	
require'includes/functions.php';
is_admin();
$s = new Sanitize();
$arr=array();
$arr = $s->sanitize_value($_POST['user_id']);
$count=reset_emp_sql($arr[0]);

if ($count){
    logfiles('114');
    SessionData::set(__('Επιτυχής επαναφορά'),'success');

}else {
    logfiles('115');
    SessionData::set(__('Δεν έγινε η επαναφορά'),'danger');

}

header("location: admin_deleted_list_of_emps.php" );
exit();
?>

