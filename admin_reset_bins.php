<?php

	// Access: Admin
	// Purpose: Reset the specified bin's status
	
require 'includes/functions.php';
require 'includes/sanitize.class.php';

is_admin();
$s = new Sanitize();
$arr=array();
$arr = $s->sanitize_value($_POST['id_bin']);

$count1=reset_bin_sql($arr[0]);

if ($count1){
    logfiles('112');
    SessionData::set(__('Επιτυχής επαναφορά'),'success');

}else {
    logfiles('113');
    SessionData::set(__('Δεν έγινε η επαναφορά'),'danger');

}

header("location: admin_deleted_list_of_bins.php" );
exit();
?>

