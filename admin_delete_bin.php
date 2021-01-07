<?php

	// Access: Admin
	// Purpose: Delete the specified bin
	
require'includes/functions.php';
require'includes/sanitize.class.php';
is_admin();
$s = new Sanitize();
$arr=array();
$arr = $s->sanitize_value($_POST['id_bin']);
//delete bin

$count1=delete_bin_sql($arr[0]);

if ($count1){
    logfiles('118');
    SessionData::set(__('Επιτυχής διαγραφή'),'success');

}else {
    logfiles('119');
    SessionData::set(__('Δεν έγινε διαγραφή'),'danger');
}

header("location: admin_list_of_bins.php" );
exit();

?>