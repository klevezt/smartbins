<?php

	// Access: Admin
	// Purpose: Renew and delete the logfiles after a certain period of time

require 'includes/functions.php';
is_admin();
$sql="DELETE FROM logfiles where timestamp <= DATE_SUB( NOW(), INTERVAL 30 DAY ) ";
$stmt = $conn->prepare($sql);
$stmt->execute();
?>

